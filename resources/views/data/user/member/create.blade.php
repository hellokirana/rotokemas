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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Tambah Member') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('member.store') }}">
                        @csrf
                        <!-- Company Name -->
                        <div class="row mb-3">
                            <label for="company_name" class="col-md-4 col-form-label text-md-end">Company Name</label>
                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autofocus>
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Field email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Company Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Field password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Founded Year -->
                        <div class="row mb-3">
                            <label for="founded_year" class="col-md-4 col-form-label text-md-end">Founded Year</label>
                            <div class="col-md-6">
                                <input id="founded_year" type="text" class="form-control @error('founded_year') is-invalid @enderror" name="founded_year" value="{{ old('founded_year') }}" required autofocus>
                                @error('founded_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Company Address -->
                        <div class="row mb-3">
                            <label for="company_address" class="col-md-4 col-form-label text-md-end">Company Address</label>
                            <div class="col-md-6">
                                <input id="company_address" type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address') }}" required autofocus>
                                @error('company_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Company Phone -->
                        <div class="row mb-3">
                            <label for="company_phone" class="col-md-4 col-form-label text-md-end">Company Phone</label>
                            <div class="col-md-6">
                                <input id="company_phone" type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ old('company_phone') }}" required>
                                @error('company_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Company Website -->
                        <div class="row mb-3">
                            <label for="company_website" class="col-md-4 col-form-label text-md-end">Company Website</label>
                            <div class="col-md-6">
                                <input id="company_website" type="text" class="form-control @error('company_website') is-invalid @enderror" name="company_website" value="{{ old('company_website') }}" required autofocus>
                                @error('company_website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Name -->
                        <div class="row mb-3">
                            <label for="contact_name" class="col-md-4 col-form-label text-md-end">Contact Name</label>
                            <div class="col-md-6">
                                <input id="contact_name" type="text" class="form-control @error('contact_name') is-invalid @enderror" name="contact_name" value="{{ old('contact_name') }}" required autofocus>
                                @error('contact_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Phone -->
                        <div class="row mb-3">
                            <label for="contact_phone" class="col-md-4 col-form-label text-md-end">Contact Phone</label>
                            <div class="col-md-6">
                                <input id="contact_phone" type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}" required>
                                @error('contact_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Department -->
                        <div class="row mb-3">
                            <label for="contact_department" class="col-md-4 col-form-label text-md-end">Contact Department</label>
                            <div class="col-md-6">
                                <input id="contact_department" type="text" class="form-control @error('contact_department') is-invalid @enderror" name="contact_department" value="{{ old('contact_department') }}" required>
                                @error('contact_department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Position -->
                        <div class="row mb-3">
                            <label for="contact_position" class="col-md-4 col-form-label text-md-end">Contact Position</label>
                            <div class="col-md-6">
                                <input id="contact_position" type="text" class="form-control @error('contact_position') is-invalid @enderror" name="contact_position" value="{{ old('contact_position') }}" required>
                                @error('contact_position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Email -->
                        <div class="row mb-3">
                            <label for="contact_email" class="col-md-4 col-form-label text-md-end">Contact Email</label>
                            <div class="col-md-6">
                                <input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email') }}" required>
                                @error('contact_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="business_type" class="col-md-4 col-form-label text-md-end">Business Type</label>
                            <div class="col-md-6">
                                <select name="business_type" id="business_type" class="form-control" required>
                                    <option value="">-- Pilih Business Type --</option>
                                    @foreach($business_type as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="total_employee" class="col-md-4 col-form-label text-md-end">Total Employee</label>
                            <div class="col-md-6">
                                <select name="total_employee" id="total_employee" class="form-control" required>
                                    <option value="">-- Pilih Total Employee --</option>
                                    @foreach($total_employee as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="printing_line_total" class="col-md-4 col-form-label text-md-end">Printing Line Total</label>
                            <div class="col-md-6">
                                <select name="printing_line_total" id="printing_line_total" class="form-control" required>
                                    <option value="">-- Pilih Printing Line Total --</option>
                                    @foreach($printing_line_total as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="process_printing" class="col-md-4 col-form-label text-md-end">Process Printing</label>
                            <div class="col-md-6">
                                <select name="process_printing" id="process_printing" class="form-control" required>
                                    <option value="">-- Pilih Process Printing --</option>
                                    @foreach($process_printing as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3"> 
                            <label for="process" class="col-md-4 col-form-label text-md-end">Process</label> 
                            <div class="col-md-6"> @foreach($process as $value) 
                                <div class="form-check"> <input class="form-check-input" type="checkbox" name="process[]" value="{{ $value }}" id="process_{{ $loop->index }}"> 
                                    <label class="form-check-label" for="process_{{ $loop->index }}"> 
                                        {{ $value }} 
                                    </label> 
                                </div> 
                            @endforeach 
                            </div> 
                        </div>

                        <div class="row mb-3">
                            <label for="anual_turnover" class="col-md-4 col-form-label text-md-end">Anual Turnover</label>
                            <div class="col-md-6">
                                <select name="anual_turnover" id="anual_turnover" class="form-control" required>
                                    <option value="">-- Pilih Anual Turnover --</option>
                                    @foreach($anual_turnover as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="film_production" class="col-md-4 col-form-label text-md-end">Film Production</label>
                            <div class="col-md-6">
                                <select name="film_production" id="film_production" class="form-control" required>
                                    <option value="">-- Pilih Film Production --</option>
                                    @foreach($film_production as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary "><i
                                    class="fa fa-save me-2"></i>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
