@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mt-4">
    @php $user = Auth::user(); @endphp

    @hasanyrole('superadmin')
        <h1 class="mb-4">Dashboard Admin</h1>

        <div class="row">
            <!-- Total Anggota Aktif -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Anggota Aktif</h5>
                        <p class="card-text display-6">{{ $totalMembers ?? '0' }}</p>
                        <small class="text-muted">Perusahaan</small>
                    </div>
                </div>
            </div>
        
            <!-- Anggota Pending -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Anggota Pending</h5>
                        <p class="card-text display-6">{{ $pendingMembers ?? '0' }}</p>
                        <small class="text-muted">Perusahaan</small>
                    </div>
                </div>
            </div>

            <!-- Anggota Paid -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Premium Member</h5>
                        <p class="card-text display-6">{{ $memberCount ?? '0' }}</p>
                        <small class="text-muted">Perusahaan</small>
                    </div>
                </div>
            </div>
            <!-- Anggota UnPaid -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Basic Member</h5>
                        <p class="card-text display-6">{{ $partnerCount ?? '0' }}</p>
                        <small class="text-muted">Perusahaan</small>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-3">Kategori Perusahaan</h2>
                <div>{!! $categoryChart->container() !!}</div>
            </div>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-3">Proses Cetak</h2>
                <div>{!! $printingChart->container() !!}</div>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-3">Badan Usaha</h2>
                <div>{!! $businessEntityChart->container() !!}</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow mb-6">
            <h2 class="text-lg font-semibold mb-3">Anggota Bergabung Tiap Tahunnya</h2>
            <div>{!! $joinPerYearChart->container() !!}</div>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Tabel Kategori Perusahaan</h2>
                <select class="border rounded px-2 py-1 text-sm">
                    <option value="Kecil">Kecil</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Besar">Besar</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left">No</th>
                            <th class="px-3 py-2 text-left">Nama Perusahaan</th>
                            <th class="px-3 py-2 text-left">Omset Tahunan</th>
                            <th class="px-3 py-2 text-left">Proses Kerja</th>
                            <th class="px-3 py-2 text-left">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $index => $company)
                        <tr>
                            <td class="border-t px-3 py-2">{{ $index + 1 }}</td>
                            <td class="border-t px-3 py-2">{{ $company->company_name }}</td>
                            <td class="border-t px-3 py-2">{{ $company->anual_turnover }}</td>
                            <td class="border-t px-3 py-2">{{ $company->process }}</td>
                            <td class="border-t px-3 py-2">{{ $company->business_type }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @stack('scripts')

        @push('scripts')
            {!! $categoryChart->script() !!}
            {!! $printingChart->script() !!}
            {!! $businessEntityChart->script() !!}
            {!! $joinPerYearChart->script() !!}
            <script>
                function filterMemberType() {
                    const dropdown = document.getElementById('memberTypeDropdown');
                    const selected = dropdown.value;
                    const countDisplay = document.getElementById('memberTypeCount');

                    fetch(`/admin/member-type-count?type=${selected}`)
                        .then(res => res.json())
                        .then(data => {
                            countDisplay.textContent = data.count;
                        });
                        .catch(err => {
                            console.error('Error fetching member type count:', err);
                            countDisplay.textContent = '0';
                        });
                }                
            </script>
        @endpush
    @else
        <h1 class="mb-4">Dashboard Member</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Selamat datang, {{ $user->company_name }}</h5>
                <p class="card-text">Status: 
                    <span class="badge bg-{{ $user->status === 'approved' ? 'success' : ($user->status === 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </p>
                <p class="card-text">Tipe Member: {{ ucfirst($user->member_type) }}</p>
                <p class="card-text">Email: {{ $user->company_email }}</p>
            </div>
        </div>
    @endhasanyrole
</div>
@endsection
