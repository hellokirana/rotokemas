@extends('layouts.frontend')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Email Verification Successful</div>
                <div class="card-body">
                    <div class="alert alert-success">
                        {{ session('message') ?? 'Your email has been verified successfully. An administrator will now review your account. You will be notified when your account is approved.' }}
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-primary">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection