@extends('layouts.app')

@section('content')
@php
    $anual_turnover = ['< 100 M', '100 M - 500 M', '> 500 M'];
    $film_production = ['CPP Film', 'Blown PP/PE Film'];
    $printing_line_total = ['1 - 3', '4 - 6', '≥ 7'];
    $process = ['Laminasi', 'Extrusi', 'Bag Making'];
    $process_printing = ['Rotogravure', 'Flexography', 'Digital', 'Lain-lain'];
    $total_employee = ['≤ 500', '500 - 1000', '> 1000'];
    $business_type = ['PMA', 'PMDN'];
@endphp
<div class="container">
    <form method="POST" action="{{ url('update_profil') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Profil
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @hasrole('member')
                            <div class="col-md-6">
                                <x-form.date label="Joined At" for="joined_at" name="joined_at"
                                    value="{{ $user->joined_at ? date('Y-m-d', strtotime($user->joined_at)) : '' }}" 
                                    :error="$errors->first('joined_at')" disabled />
                            </div>
                            <!-- Data Perusahaan -->
                            <div class="col-md-6">
                                <x-form.text label="Company Name" for="company_name" name="company_name"
                                    value="{{ $user->company_name }}" :error="$errors->first('company_name')" disabled />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Founded Year" for="founded_year" name="founded_year"
                                    value="{{ $user->founded_year }}" :error="$errors->first('founded_year')" disabled />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Company Address" for="company_address" name="company_address"
                                    value="{{ $user->company_address }}" :error="$errors->first('company_address')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Company Phone" for="company_phone" name="company_phone"
                                    value="{{ $user->company_phone }}" :error="$errors->first('company_phone')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Company Website" for="company_website" name="company_website"
                                    value="{{ $user->company_website }}" :error="$errors->first('company_website')" required />
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-6">
                                <x-form.text label="Contact Name" for="contact_name" name="contact_name"
                                    value="{{ $user->contact_name }}" :error="$errors->first('contact_name')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Contact Phone" for="contact_phone" name="contact_phone"
                                    value="{{ $user->contact_phone }}" :error="$errors->first('contact_phone')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Contact Department" for="contact_department" name="contact_department"
                                    value="{{ $user->contact_department }}" :error="$errors->first('contact_department')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Contact Position" for="contact_position" name="contact_position"
                                    value="{{ $user->contact_position }}" :error="$errors->first('contact_position')" required />
                            </div>
                            <div class="col-md-6">
                                <x-form.email label="Contact Email" for="contact_email" name="contact_email"
                                    value="{{ $user->contact_email }}" :error="$errors->first('contact_email')" required />
                            </div>

                            <!-- Login -->
                            <div class="col-md-6">
                                <x-form.email label="Company Email" for="email" name="email"
                                    value="{{ $user->email }}" :error="$errors->first('email')" disabled />
                            </div>
                            <div class="col-md-6">
                                <x-form.password label="Password (Kosongkan jika tidak diubah)" for="password" name="password"
                                    :error="$errors->first('password')" />
                            </div>
                            
                            <div class="col-md-6">
                                <x-form.password label="Konfirmasi Password" for="password_confirmation" name="password_confirmation"
                                    :error="$errors->first('password_confirmation')" />
                            </div>

                            <!-- Kriteria Perusahaan -->
                            <div class="col-md-6">
                                <label for="business_type" class="form-label">Tipe Bisnis</label>
                                <select name="business_type" id="business_type" class="form-control" disabled>
                                    <option value="">Pilih</option>
                                    @foreach ($business_type as $val)
                                        <option value="{{ $val }}" {{ $user->business_type == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('business_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="total_employee" class="form-label">Total Karyawan</label>
                                <select name="total_employee" id="total_employee" class="form-control" disabled>
                                    <option value="">Pilih</option>
                                    @foreach ($total_employee as $val)
                                        <option value="{{ $val }}" {{ $user->total_employee == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('total_employee')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="printing_line_total" class="form-label">Total Printing Line</label>
                                <select name="printing_line_total" id="printing_line_total" class="form-control" disabled>
                                    <option value="">Pilih</option>
                                    @foreach ($printing_line_total as $val)
                                        <option value="{{ $val }}" {{ $user->printing_line_total == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('printing_line_total')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="process_printing" class="form-label">Process Printing</label>
                                <select name="process_printing" id="process_printing" class="form-control" disabled>
                                    <option value="">Pilih</option>
                                    @foreach ($process_printing as $val)
                                        <option value="{{ $val }}" {{ $user->process_printing == $val ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('process_printing')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Process</label>
                                <div class="form-control p-2" style="height: auto;">
                                @foreach ($process as $val)
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="process[]"
                                            id="process_{{ $loop->index }}"
                                            value="{{ $val }}"
                                            {{ in_array($val, explode(', ', $user->process)) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="process_{{ $loop->index }}">
                                            {{ $val }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                <div class="col-md-6">
                    <label for="anual_turnover" class="form-label">Anual Turnover</label>
                    <select name="anual_turnover" id="anual_turnover" class="form-control" disabled>
                        <option value="">Pilih</option>
                        @foreach ($anual_turnover as $val)
                            <option value="{{ $val }}" {{ $user->anual_turnover == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('anual_turnover')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="film_production" class="form-label">Film Production</label>
                    <select name="film_production" id="film_production" class="form-control" disabled>
                        <option value="">Pilih</option>
                        @foreach ($film_production as $val)
                            <option value="{{ $val }}" {{ $user->film_production == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('film_production')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @endhasrole

                @hasrole('superadmin')
                <div class="col-md-6">
                    <x-form.text label="Name" for="company_name" name="company_name"
                        value="{{ $user->company_name }}" :error="$errors->first('company_name')" disabled />
                </div>
                <div class="col-md-6">
                    <x-form.email label="Company Email" for="email" name="email"
                        value="{{ $user->email }}" :error="$errors->first('email')" disabled />
                </div>
                <div class="col-md-6">
                    <x-form.password label="Password (Kosongkan jika tidak diubah)" for="password" name="password"
                        :error="$errors->first('password')" />
                </div>
                
                <div class="col-md-6">
                    <x-form.password label="Konfirmasi Password" for="password_confirmation" name="password_confirmation"
                        :error="$errors->first('password_confirmation')" />
                </div>
                @endhasrole

                        </div>
                    </div>
                </div>
            </div>
            
            
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Info data
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <x-form.file label="Company Logo" for="image" name="image" data-default-file="{{ $user->avatar_url }}"
                                :error="$errors->first('image')"></x-form.file>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary "><i
                                class="fa fa-save me-2"></i>Simpan</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection