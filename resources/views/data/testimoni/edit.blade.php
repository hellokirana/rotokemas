@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('data/testimoni', $data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-capitalize">
                            Tambah Logo
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <x-form.text label="Nama" for="nama" name="nama" value="{{ $data->nama }}"
                                        :error="$errors->first('nama')" required></x-form.text>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                                <option value="">-- Pilih Type --</option>
                                                <option value="Founder" {{ old('type', $data->type ?? '') == 'Founder' ? 'selected' : '' }}>Founder</option>
                                                <option value="Member" {{ old('type', $data->type ?? '') == 'Member' ? 'selected' : '' }}>Member</option>
                                                <option value="Partner" {{ old('type', $data->type ?? '') == 'Partner' ? 'selected' : '' }}>Partner</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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

                            <div class="mb-3">
                                <x-form.number label="no_urut" for="no_urut" name="no_urut" value="{{ $data->no_urut }}"
                                    min=1 :error="$errors->first('no_urut')" required></x-form.number>
                            </div>

                            <div class="mb-3">
                                <x-form.file label="image" for="image" name="image"
                                    data-default-file="{{ $data->image_url }}" :error="$errors->first('image')"></x-form.file>
                            </div>

                            <div class="form-group mb-3">
                                <label>Status </label><br>
                                {{ Form::select('status', status_publish(), $data->status, ['class' => 'form-select']) }}
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
