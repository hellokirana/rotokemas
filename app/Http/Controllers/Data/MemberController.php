<?php

namespace App\Http\Controllers\Data;

use App\Models\User;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\MemberDataTable;
use App\DataTables\LayananDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(MemberDataTable $dataTable)
    {
        return $dataTable->render('data.user.member.index');
    }
    public function create()
    {
        return view('data.user.member.create');
    }

    public function pending(MemberDataTable $dataTable)
    {
        return $dataTable->render('data.user.member.pending'); // Bisa clone dari `index.blade.php`
    }

    public function show($id)
    {
        $this->middleware('verified');
        try {
            $data = User::role('member')->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data = User::role('member')->findOrFail($id);
        return view('data.user.member.show', compact('data'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|unique:users',
            // field lainnya
        ]);

        $data = $request->all();

        // Override atau tambahkan field yang diperlukan
        $data['password'] = Hash::make($request->password);
        $data['email_verified_at'] = now();
        $data['joined_at'] = now();
        $data['status'] = 'approved';
        $data['process'] = implode(', ', $data['process'] ?? []);

        $user = User::create($data);

        $user->assignRole('member');


        return redirect()->route('data.member.index')->with('success', 'Member berhasil ditambahkan');
    }

    public function approve($id)
    {
        $member = User::role('member')->findOrFail($id);

        $member->status = 'approved';

        // Cek dulu biar gak nimpuk kalau udah pernah di-approve
        if (is_null($member->joined_at)) {
            $member->joined_at = now();
        }

        $member->save();

        return redirect()->route('data.member.index')->with('success', 'Member berhasil disetujui');
    }

    public function reject($id)
    {
        $member = User::role('member')->findOrFail($id);
        $member->status = 'rejected';
        $member->save();

        return redirect()->route('members.index')->with('success', 'Member berhasil di-reject.');
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }

        return view('data.user.member.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'company_name' => ['required', 'string', 'max:255'],
            'joined_at' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'password' => $request->password ? ['string', 'min:8', 'confirmed'] : [],
            'type' => ['required', Rule::in(['member', 'founder', 'partner'])], // default type
            'founded_year' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_department' => ['nullable', 'string', 'max:255'],
            'contact_position' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255'],
            'total_employee' => ['nullable', 'string', 'max:255'],
            'printing_line_total' => ['nullable', 'string', 'max:255'],
            'process_printing' => ['nullable', 'string', 'max:255'],
            'process' => ['nullable', 'array'],
            'process.*' => ['string', 'max:255'],
            'anual_turnover' => ['nullable', 'string', 'max:255'],
            'film_production' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated->fails()) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput()
                ->with('warning', 'Data gagal diupdate');
        }

        $data = User::findOrFail($id);

        // Update data user
        $data->update([
            'avatar' => $request->avatar,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $data->password,
            'type' => $request->type,
            'joined_at' => $request->joined_at,
            'founded_year' => $request->founded_year,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_website' => $request->company_website,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'contact_department' => $request->contact_department,
            'contact_position' => $request->contact_position,
            'contact_email' => $request->contact_email,
            'business_type' => $request->business_type,
            'total_employee' => $request->total_employee,
            'printing_line_total' => $request->printing_line_total,
            'process_printing' => $request->process_printing,
            'process' => implode(', ', $request->process ?? []), // Simpan sebagai string
            'anual_turnover' => $request->anual_turnover,
            'film_production' => $request->film_production,
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/user/' . $data->avatar);
            $fileimageName = date('dHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/user', $fileimageName);
            $data->avatar = $fileimageName;
            $data->save();
        }

        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('data.member.index');
    }

    public function destroy($id)
    {
        $data = User::role('member')->where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }



}
