@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>{{ $news->title }}</h4>
        </div>
        <div class="card-body">
            {{-- Tanggal dan waktu --}}
            <p class="text-center text-muted mb-2">
                {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('l, d M Y H:i') }} WIB
            </p>
            @if($news->image_path)
                <img src="{{ asset('storage/' . $news->image_path) }}" alt="Gambar" class="img-fluid mb-3">
            @endif

            @if($news->link)
                <p>
                    <a href="{{ $news->link }}" target="_blank">{{ $news->link }}</a>
                    @if($news->link_thumbnail)
                        <div>
                            <img src="{{ $news->link_thumbnail }}" alt="Link Thumbnail" class="img-fluid mb-2" style="max-height: 200px;">
                        </div>
                    @endif
                </p>
            @endif

            @if($news->content)
                <p>{!! nl2br(e($news->content)) !!}</p>
            @endif

            @if($news->document_path)
                <a href="{{ asset('storage/' . $news->document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary mt-2">Lihat Dokumen</a>
            @endif
            @hasrole('superadmin')
            <p class="text-muted mt-3">Ditujukan untuk: <strong>{{ ucfirst($news->audience) }}</strong></p>
            @endhasrole
            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">← Kembali</a>
        </div>
    </div>
</div>
@endsection
