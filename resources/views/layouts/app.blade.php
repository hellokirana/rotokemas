<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="initial-province" content="{{ Auth::user()->province_code }}">
    <meta name="initial-city" content="{{ Auth::user()->city_code }}">
    <meta name="initial-district" content="{{ Auth::user()->district_code }}">
    <meta name="initial-village" content="{{ Auth::user()->village_code }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- DataTables Core CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/remixicon/remixicon.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto text-capitalize">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('home') }}">dashboard</a>
                            </li>
                            @hasanyrole('superadmin|member')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('news') }}">news</a>
                                </li>
                            @endhasanyrole
                            
                            {{-- @hasanyrole('superadmin|worker')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('data/withdraw') }}">withdraw</a>
                                </li>
                            @endhasanyrole --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ url('data/order') }}">order</a>
                            </li> --}}



                            @hasanyrole('superadmin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('data/kontak') }}">Pesan Masukan</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="layanan_menu" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Media
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="layanan_menu">
                                        <a class="dropdown-item" href="{{ url('data/media') }}">Media Publik</a>
                                        <a class="dropdown-item" href="{{ url('data/kategori') }}">kategori Media</a>

                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="layanan_menu" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        User
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="layanan_menu">
                                        <a class="dropdown-item" href="{{ url('data/member') }}">member</a>
                                        <a class="dropdown-item" href="{{ route('pending-members.index') }}">Pending Member</a>
                                        <a class="dropdown-item" href="{{ url('data/admin') }}">admin</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="konten_menu" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Tampilan
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="konten_menu">
                                        <a class="dropdown-item" href="{{ url('data/slider') }}">Slide Utama</a>
                                        <a class="dropdown-item" href="{{ url('data/testimoni') }}">Member Logo</a>
                                        {{-- <a class="dropdown-item" href="{{ url('data/bank') }}">bank</a> --}}
                                    </div>
                                </li>
                            @endhasanyrole
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->company_name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('profil') }}">Profil</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- DataTables & Extensions Scripts -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    <script src="{{ asset('js/address-dropdown.js') }}"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        // $(document).ready(function() {
        //     $('#select_data').select2({
        //         placeholder: "Select an option",
        //         allowClear: true
        //     });
        // });
        $(document).on('click', '.update_data', function() {
            let element = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light',
                    cancelButton: 'btn btn-danger waves-effect'
                },
                showClass: {
                    popup: 'animate__animated animate__bounceIn'
                },
                buttonsStyling: true,
                confirmButtonText: "Yes",
                showCancelButton: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = element.data('url');
                };
            })
        });
        // First the delete handler
$(document).on('click', '.delete-post', function(e) {
    e.preventDefault();
    
    var url = $(this).data('url_href');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.success,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'An error occurred while deleting the post.',
                        'error'
                    );
                }
            });
        }
    });
});

// Then separately define the approve handler
$(document).on('click', '.btn-approve', function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    var csrf = $(this).data('csrf');

    Swal.fire({
        title: 'Yakin ingin menyetujui member ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            $('<form>', {
                method: 'POST',
                action: url
            })
            .append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: csrf
            }))
            .append($('<input>', {
                type: 'hidden',
                name: '_method',
                value: 'PUT'
            }))
            .appendTo('body')
            .submit();
        }
    });
});

// And separately define the reject handler
$(document).on('click', '.btn-reject', function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    var csrf = $(this).data('csrf');

    Swal.fire({
        title: 'Yakin ingin menolak member ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            $('<form>', {
                method: 'POST',
                action: url
            })
            .append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: csrf
            }))
            .append($('<input>', {
                type: 'hidden',
                name: '_method',
                value: 'PUT'
            }))
            .appendTo('body')
            .submit();
        }
    });
});
    </script>

    @if (Session::has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Berhasil",
                text: "{{ Session::get('success') }}",
                timer: 3000
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Peringatan",
                text: "{{ Session::get('error') }}",
                timer: 3000
            });
        </script>
    @endif
   
    @stack('scripts')
</body>

</html>
