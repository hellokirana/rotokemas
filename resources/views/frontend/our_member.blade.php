@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg') }}');"></div>
        <div class="common-banner-content">
            <h3>Our Members</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Our Members</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->

    <!-- Founder -->
<section class="testimonial py-5">
    <div class="container">
        <div class="testimonial-container">
            <div class="common-title text-center mb-5">
                <h6>SHOWING</h6>
                <h3>Our Founder</h3>
            </div>

            <div class="row justify-content-center">
                @foreach($founders as $testimoni)
                    <div class="col-6 col-md-4 col-lg-2 mb-4 text-center">
                        <div class="member-avatar-box">
                            <img src="{{ $testimoni->image_url }}" alt="{{ $testimoni->nama }}" class="member-avatar">
                            <h6 class="member-name mt-2">{{ $testimoni->nama }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Founder -->

 <!-- Member -->
 <section class="testimonial py-5">
    <div class="container">
        <div class="testimonial-container">
            <div class="common-title text-center mb-5">
                
                <h3>Our Member</h3>
            </div>

            <div class="row justify-content-center">
                @foreach($members as $testimoni)
                    <div class="col-6 col-md-4 col-lg-2 mb-4 text-center">
                        <div class="member-avatar-box">
                            <img src="{{ $testimoni->image_url }}" alt="{{ $testimoni->nama }}" class="member-avatar">
                            <h6 class="member-name mt-2">{{ $testimoni->nama }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Member -->

<!-- Partner -->
<section class="testimonial py-5">
    <div class="container">
        <div class="testimonial-container">
            <div class="common-title text-center mb-5">
                
                <h3>Our Partner</h3>
            </div>

            <div class="row justify-content-center">
                @foreach($members as $testimoni)
                    <div class="col-6 col-md-4 col-lg-2 mb-4 text-center">
                        <div class="member-avatar-box">
                            <img src="{{ $testimoni->image_url }}" alt="{{ $testimoni->nama }}" class="member-avatar">
                            <h6 class="member-name mt-2">{{ $testimoni->nama }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Partner -->


@endsection
