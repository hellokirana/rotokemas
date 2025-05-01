@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Berita</h3>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content">Artikel</label>
            <textarea name="content" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="link">Link Berita (opsional)</label>
            <input type="url" name="link" class="form-control">
        </div>

        <div class="mb-3">
            <label for="image">Gambar</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="document">Dokumen (PDF/Word)</label>
            <input type="file" name="document" class="form-control">
        </div>

        <div class="mb-3">
            <label for="audience">Target Audiens</label>
            <select name="audience" class="form-control">
                <option value="all">Semua</option>
                <option value="founder">Founder</option>
                <option value="member">Member</option>
                <option value="partner">Partner</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('news.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
