<?php

namespace App\Http\Controllers\Data;

use App\Models\Media;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\MediaDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function index(MediaDataTable $dataTable)
    {
        return $dataTable->render('data.media.index');
    }

    public function kategori(Request $request)
    {
        $kategori = $request->input('kategori');
        $cari = $request->input('cari');

        $query = Media::query();

        if (!empty($kategori)) {
            $query->where('kategori_id', $kategori);
        }

        if (!empty($cari)) {
            $query->where('title', 'like', '%' . $cari . '%');
        }

        $media_all = $query->paginate(12);
        $kategori_all = Kategori::all();

        return view('media', compact('media_all', 'kategori_all', 'kategori', 'cari'));
    }


    public function create()
    {
        $kategori = Kategori::all();
        return view('data.media.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategoris,id',
            'title' => 'required',
            'caption' => 'nullable|string',
            'penulis' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Media();
        $data->kategori_id = $request->kategori_id;
        $data->title = $request->title;
        $data->penulis = $request->penulis;
        $data->konten = $request->konten;
        $data->featured = $request->featured;
        $data->status = $request->status;
        $fileimage = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/media',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->save();
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('media.index');
    }

    public function edit($id)
    {
        $data = Media::findOrFail($id);
        return view('data.media.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Media::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'title' => 'required',
            'caption' => 'nullable|string',
            'penulis' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = Media::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->kategori_id = $request->kategori_id;
        $data->title = $request->title;
        $data->penulis = $request->penulis;
        $data->konten = $request->konten;
        $data->featured = $request->featured;
        $data->status = $request->status;
        $data->caption = $request->caption;
        $fileimage = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/media',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/media');
    }

    public function destroy($id)
    {
        $data = Media::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
