@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Berita Terbaru</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Jika Admin, tampilkan tombol tambah --}}
    {{-- @if($is_admin)
        <div class="mb-3">
            <a href="{{ route('news.create') }}" class="btn btn-primary">+ Tambah Berita</a>
        </div>
    @endif --}}

    @hasrole('superadmin')
    <div class="mb-3 text-end">
        <a href="{{ route('news.create') }}" class="btn btn-primary">+ Tambah Artikel</a>
    </div>
    @endhasrole


    {{-- Timeline Berita --}}
    @forelse($news as $item)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>{{ $item->title }}</strong>
            @hasrole('superadmin')
                <div>
                    <a href="{{ route('news.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            @endhasrole
        </div>

        <div class="card-body">
            @if($item->image_path)
                <img 
                    src="{{ asset('storage/' . $item->image_path) }}" 
                    alt="Gambar" 
                    class="img-fluid mb-2" 
                    style="max-height: 300px; object-fit: cover;">
            @endif

            @if($item->link)
                <p>
                    <a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>
                    @if($item->link_thumbnail)
                        <img 
                            src="{{ $item->link_thumbnail }}" 
                            alt="Link Thumbnail" 
                            class="img-fluid mb-2" 
                            style="max-height: 200px; object-fit: cover;">
                    @endif

                </p>
            @endif

            @if($item->content)
                <p>{!! Str::limit(nl2br(e($item->content)), 200) !!}</p>
            @endif

            @if($item->document_path)
                <a href="{{ asset('storage/' . $item->document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat Dokumen</a>
            @endif
            @hasrole('superadmin')
            <p class="text-muted mt-2">Ditujukan untuk: <strong>{{ ucfirst($item->audience) }}</strong></p>
            @endhasrole
            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-primary mt-2">Lihat Selengkapnya</a>
        </div>
    </div>
@empty
    <p>Belum ada berita.</p>
@endforelse

</div>
@endsection
