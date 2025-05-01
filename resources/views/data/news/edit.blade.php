@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Berita</h3>

    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
        </div>

        <div class="mb-3">
            <label for="content">Artikel</label>
            <textarea name="content" class="form-control" rows="4">{{ $news->content }}</textarea>
        </div>

        <div class="mb-3">
            <label for="link">Link Berita</label>
            <input type="url" name="link" class="form-control" value="{{ $news->link }}">
        </div>

        <div class="mb-3">
            <label for="image">Gambar</label>
            <input type="file" name="image" class="form-control">
            @if($news->image_path)
                <img src="{{ asset('storage/' . $news->image_path) }}" alt="Gambar" class="img-thumbnail mt-2" style="max-height: 150px;">
            @endif
        </div>

        <div class="mb-3">
            <label for="document">Dokumen</label>
            <input type="file" name="document" class="form-control">
            @if($news->document_path)
                <a href="{{ asset('storage/' . $news->document_path) }}" target="_blank" class="d-block mt-2">Lihat Dokumen</a>
            @endif
        </div>

        <div class="mb-3">
            <label for="audience">Target Audiens</label>
            <select name="audience" class="form-control">
                <option value="all" {{ $news->audience == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="founder" {{ $news->audience == 'founder' ? 'selected' : '' }}>Founder</option>
                <option value="member" {{ $news->audience == 'member' ? 'selected' : '' }}>Member</option>
                <option value="partner" {{ $news->audience == 'partner' ? 'selected' : '' }}>Partner</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('news.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
