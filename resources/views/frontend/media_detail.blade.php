@extends('layouts.frontend')

@section('content')
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg') }}');"></div>
        <div class="common-banner-content">
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active"><i class="fa-solid fa-angles-right"></i><a href="{{ url('media/') }}">Media</a></li>
                    @if(isset($data)) <!-- Pastikan data ada -->
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i>{{ $data->title }}</li> <!-- Atau gunakan $data->slug jika ingin menampilkan slug -->
                    @endif
                </ul>
            </div>
        </div>
    </section>
    <section class=" service-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="common-title">
                        <h4>{{ $data->title}}</h4>

                    </div>
                    <div class="ratio ratio-16x9 mb-4"
                        style="background-image: url('{{ $data->image_url }}');background-repeat: no-repeat;
                        background-size: cover;">

                    </div>
                    <div class="service-details-content">
                        <h4>Service Details</h4>
                        {!! $data->konten !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Debug untuk memastikan jQuery dan event berjalan
    console.log('Document ready');

    // Fungsi untuk memuat data kota
    function loadCities(provinceCode, selectedCity = '') {
        console.log('Loading cities for province:', provinceCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-cities/' + provinceCode,
            type: 'GET',
            success: function(data) {
                console.log('Cities response:', data); // Debug
                $('#city').empty();
                $('#city').append('<option value="">Pilih Kota/Kabupaten</option>');
                data.forEach(function(city) {
                    $('#city').append(`<option value="${city.code}" ${city.code == selectedCity ? 'selected' : ''}>${city.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cities:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            }
        });
    }

    // Fungsi untuk memuat data kecamatan
    function loadDistricts(cityCode, selectedDistrict = '') {
        console.log('Loading districts for city:', cityCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-districts/' + cityCode,
            type: 'GET',
            success: function(data) {
                console.log('Districts response:', data); // Debug
                $('#district').empty();
                $('#district').append('<option value="">Pilih Kecamatan</option>');
                data.forEach(function(district) {
                    $('#district').append(`<option value="${district.code}" ${district.code == selectedDistrict ? 'selected' : ''}>${district.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading districts:', error);
            }
        });
    }

    // Fungsi untuk memuat data desa/kelurahan
    function loadVillages(districtCode, selectedVillage = '') {
        console.log('Loading villages for district:', districtCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-villages/' + districtCode,
            type: 'GET',
            success: function(data) {
                console.log('Villages response:', data); // Debug
                $('#village').empty();
                $('#village').append('<option value="">Pilih Kelurahan/Desa</option>');
                data.forEach(function(village) {
                    $('#village').append(`<option value="${village.code}" ${village.code == selectedVillage ? 'selected' : ''}>${village.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading villages:', error);
            }
        });
    }

    // Event listener untuk perubahan provinsi
    $('#province').on('change', function() {
        const provinceCode = $(this).val();
        console.log('Province changed to:', provinceCode); // Debug
        if (provinceCode) {
            loadCities(provinceCode);
            $('#district').empty().append('<option value="">Pilih Kecamatan</option>');
            $('#village').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kota
    $('#city').on('change', function() {
        const cityCode = $(this).val();
        console.log('City changed to:', cityCode); // Debug
        if (cityCode) {
            loadDistricts(cityCode);
            $('#village').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kecamatan
    $('#district').on('change', function() {
        const districtCode = $(this).val();
        console.log('District changed to:', districtCode); // Debug
        if (districtCode) {
            loadVillages(districtCode);
        }
    });

    // Load data awal jika ada nilai yang tersimpan
    const initialProvinceCode = '{{ Auth::user()->province_code }}';
    const initialCityCode = '{{ Auth::user()->city_code }}';
    const initialDistrictCode = '{{ Auth::user()->district_code }}';
    const initialVillageCode = '{{ Auth::user()->village_code }}';

    console.log('Initial values:', {
        province: initialProvinceCode,
        city: initialCityCode,
        district: initialDistrictCode,
        village: initialVillageCode
    });

    if (initialProvinceCode) {
        loadCities(initialProvinceCode, initialCityCode);
    }
    if (initialCityCode) {
        loadDistricts(initialCityCode, initialDistrictCode);
    }
    if (initialDistrictCode) {
        loadVillages(initialDistrictCode, initialVillageCode);
    }
});
</script>
@endpush
