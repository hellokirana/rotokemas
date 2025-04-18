@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('data/media') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-capitalize">
                            Tambah Media
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <x-form.text label="Judul Media" for="title" name="title"
                                        value="{{ old('title') }}" :error="$errors->first('title')" required></x-form.text>
                                </div>
                                <div class="col-md-6">
                                    <x-form.text label="penulis" for="penulis" name="penulis"
                                        value="{{ old('penulis') }}" :error="$errors->first('penulis')" required></x-form.text>
                                </div>
                                <div class="col-12 mt-4">
                                    <label>konten</label>
                                    <x-form.textarea for="konten" name="konten" :value="old('konten')"
                                        :error="$errors->first('konten')"></x-form.textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-capitalize">
                            Info data
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <input class="" type="checkbox" name="featured" value="1"
                                    id="featured">
                                <label class="form-check-label" for="featured">
                                    featured
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <label>Kategori </label><br>
                                {{ Form::select('kategori_id', ['' => 'Pilih kategori'] + kategori_all(), null, ['id' => 'kategori_id', 'class' => 'form-select']) }}
                                @if ($errors->first('kategori'))
                                    <small class="text-danger text-capitalize">{{ $errors->first('kategori') }}</small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <x-form.file label="image" for="image" name="image" value="{{ old('image') }}"
                                    :error="$errors->first('image')"></x-form.file>
                            </div>
                            
                            <div class="mb-3">
                                <x-form.text label="caption" for="caption" name="caption"
                                    value="{{ old('caption') }}" :error="$errors->first('caption')" required></x-form.text>
                            </div>

                            <div class="form-group mb-3">
                                <label>Status </label><br>
                                {{ Form::select('status', status_publish(), null, ['class' => 'form-select']) }}
                                @if ($errors->first('status'))
                                    <small class="text-danger text-capitalize">{{ $errors->first('status') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary "><i class="fa fa-save me-2"></i>Simpan</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#konten'), {
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|',
                        'heading',
                        '|',
                        'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        '|',
                        'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                        '|',
                        'link', 'uploadImage', 'blockQuote', 'codeBlock',
                        '|',
                        'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: false
                }
            });
    </script>
@endpush
