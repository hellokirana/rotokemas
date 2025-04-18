<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Media;
use App\Models\Order;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\DataTables\KontakDataTable;
use App\DataTables\MemberDataTable;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Support\Facades\Validator;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Total anggota dengan role 'member'
        $totalMembers = User::role('member')->where('status', 'approved')->count();

        // Jumlah anggota berdasarkan status
        $pendingMembers = User::role('member')->where('status', 'pending')->count();
        $approvedMembers = User::role('member')->where('status', 'approved')->count();
        $rejectedMembers = User::role('member')->where('status', 'rejected')->count();

        // Jumlah anggota berdasarkan tipe member
        $founderCount = User::role('member')->where('type', 'founder')->count();
        $memberCount = User::role('member')->where('type', 'member')->count();
        $partnerCount = User::role('member')->where('type', 'partner')->count();

        // Ambil data perusahaan untuk tabel
        $companies = User::role('member')
            ->select('company_name', 'anual_turnover', 'process', 'business_type')
            ->get();

        // === CHARTS ===

        // Hitung kategori berdasarkan omset tahunan
        $allMembers = User::role('member')->select('anual_turnover')->get();

        $kecil = $allMembers->filter(function ($user) {
            return $user->anual_turnover === '< 100 M';
        })->count();

        $menengah = $allMembers->filter(function ($user) {
            return $user->anual_turnover === '100 M - 500 M';
        })->count();

        $besar = $allMembers->filter(function ($user) {
            return $user->anual_turnover === '> 500 M';
        })->count();

        $categoryChart = new Chart;
        $categoryChart->labels(['Kecil', 'Menengah', 'Besar']);
        $categoryChart->dataset('Kategori', 'doughnut', [$kecil, $menengah, $besar])
            ->backgroundColor(['#36A2EB', '#FFCE56', '#FF6384']);



        // Proses cetak
        $processLabels = User::distinct()->pluck('process_printing');
        $processData = $processLabels->map(fn($label) => User::where('process_printing', $label)->count());

        $printingChart = new Chart;
        $printingChart->labels($processLabels->toArray());
        $printingChart->dataset('Proses Cetak', 'bar', $processData->toArray())
            ->backgroundColor('#4BC0C0');

        // Badan usaha
        $businessLabels = User::distinct()->pluck('business_type');
        $businessData = $businessLabels->map(fn($label) => User::where('business_type', $label)->count());

        $businessEntityChart = new Chart;
        $businessEntityChart->labels($businessLabels->toArray());
        $businessEntityChart->dataset('Badan Usaha', 'pie', $businessData->toArray())
            ->backgroundColor(['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']);

        // Anggota bergabung per tahun
        $joinPerYear = User::role('member')
            ->selectRaw('YEAR(joined_at) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year');

        $joinPerYearChart = new Chart;
        $joinPerYearChart->labels($joinPerYear->keys()->toArray());
        $joinPerYearChart->dataset('Anggota Bergabung', 'line', $joinPerYear->values()->toArray())
            ->backgroundColor('rgba(75, 192, 192, 0.2)')
            ->color('rgba(75, 192, 192, 1)');

        // List perusahaan berdasarkan kategori
        $categorizedCompanies = User::role('member')
            ->where('status', 'approved') // optional, biar yg tampil cuma yg disetujui
            ->select('company_name', 'anual_turnover')
            ->get()
            ->groupBy('anual_turnover');

        // Return view dengan semua data & chart
        return view('home', compact(
            'user',
            'totalMembers',
            'pendingMembers',
            'approvedMembers',
            'rejectedMembers',
            'founderCount',
            'memberCount',
            'partnerCount',
            'companies',
            'categoryChart',
            'printingChart',
            'businessEntityChart',
            'joinPerYearChart',
            'categorizedCompanies',

        ));
    }

    public function getMemberTypeCount(Request $request)
    {
        $type = $request->query('type');

        if ($type === 'all') {
            $count = User::role('member')->count();
        } else {
            $count = User::role('member')->where('type', $type)->count();
        }

        return response()->json([
            'count' => $count,
        ]);
    }


    public function profil()
    {
        $data = Auth::user();
        $provinces = province::whereIn('code', ['36', '32', '31'])->get();
        return view('frontend.profil', compact('data', 'provinces'));
    }


    public function update_profil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'no_rekening' => 'nullable|string|unique:users,no_rekening,' . Auth::user()->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|max:2048',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $data = User::where('id', Auth::user()->id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->name = $request->name;
        $data->email = $request->email;
        if (!empty($request->password)) {
            $data->password = bcrypt($request->password);
        }
        $data->no_telp = $request->no_telp;
        $data->province_code = $request->province_code;
        $data->city_code = $request->city_code;
        $data->district_code = $request->district_code;
        $data->village_code = $request->village_code;
        $data->alamat = $request->alamat;
        $data->rt = $request->rt;
        $data->rw = $request->rw;

        if ($request->no_rekening !== $data->no_rekening) {
            $data->no_rekening = $request->no_rekening;
        }

        $fileimage = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/user',
                $fileimage,
                $fileimageName
            );

            $data->avatar = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('profil');
    }
    public function getCities($province_code)
    {
        try {
            $cities = City::where('province_code', $province_code)->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDistricts($city_code)
    {
        try {
            $districts = District::where('city_code', $city_code)->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getVillages($district_code)
    {
        try {
            $villages = Village::where('district_code', $district_code)->get();
            return response()->json($villages);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function member(MemberDataTable $dataTable)
    {
        return $dataTable->render('data.user.member.index');
    }

    public function kontak(KontakDataTable $dataTable)
    {
        return $dataTable->render('data.kontak.index');
    }

    public function media_detail($slug)
    {
        $data = Media::with('kategori')->where('status', 1)->where('slug', $slug)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $user = Auth::user();
        return view('frontend.media_detail', compact('data', 'user'));
    }

    public function send_order(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'layanan_id' => 'required|exists:layanans,id',
            'waktu' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'province_code' => 'required|exists:indonesia_provinces,code',
            'city_code' => 'required|exists:indonesia_cities,code',
            'district_code' => 'required|exists:indonesia_districts,code',
            'village_code' => 'required|exists:indonesia_villages,code',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $requestDate = $request->waktu; // Assume this is in 'Y-m-d' format
        $serviceTime = $request->jam;  // Assume this is in 'H:i:s' format

        // Combine the date and time
        $combinedDateTime = $requestDate . ' ' . $serviceTime;

        // Parse the combined date and time
        $dateTime = new DateTime($combinedDateTime);

        $layanan = Layanan::with('kategori')->find($request->layanan_id);
        if (!$layanan) {
            return redirect()->back()->with('error', 'Layanan tidak ditemukan.');
        }

        $order = new Order();
        $order->layanan_id = $request->layanan_id;
        $order->kategori_id = $layanan->kategori_id;
        $order->customer_id = Auth::user()->id;
        $order->harga_member = $layanan->harga_member;
        $order->harga_worker = $layanan->harga_worker;
        $order->nominal = $layanan->harga_member + rand(100, 999);
        $order->waktu = $dateTime;
        $order->alamat = $request->alamat;
        $order->province_code = $request->province_code;
        $order->city_code = $request->city_code;
        $order->district_code = $request->district_code;
        $order->village_code = $request->village_code;
        $order->status_pembayaran = 1;
        $order->status_order = 1;
        $order->save();

        return redirect('data/order/' . $order->id . '/success_order')->with('success', 'order berhasil di buat');
    }
}
