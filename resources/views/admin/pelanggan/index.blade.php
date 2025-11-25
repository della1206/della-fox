@extends('layouts.admin.app')

@section('content')
    {{-- START MAIN CONTENT --}}
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data Pelanggan</h1>
                <p class="mb-0">List data seluruh pelanggan</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.create') }}" class="btn btn-success text-white">
                    <i class="fas fa-plus me-1"></i> Tambah Pelanggan
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        @if (session('success'))
            <div class="alert alert-primary">
                {!! session('success') !!}
            </div>
        @endif
        
        <div class="col-12 mb-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <!-- Filter dan Search -->
                            <form method="GET" action="{{ route('pelanggan.index') }}" class="d-flex align-items-center gap-2">
                                <!-- Filter Gender -->
                                <select name="gender" class="form-select" onchange="this.form.submit()" style="width: auto;">
                                    <option value="All Gender" {{ $selectedGender == 'All Gender' ? 'selected' : '' }}>All Gender</option>
                                    <option value="Male" {{ $selectedGender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $selectedGender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $selectedGender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                
                                <!-- Search -->
                                <div class="input-group" style="width: 300px;">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." 
                                           value="{{ $search }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if($search)
                                        <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="text-muted">
                                Showing {{ $dataPelanggan->firstItem() }} - {{ $dataPelanggan->lastItem() }} 
                                of {{ $dataPelanggan->total() }} entries
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">FIRST NAME</th>
                                    <th class="border-0">LAST NAME</th>
                                    <th class="border-0">BIRTHDAY</th>
                                    <th class="border-0">GENDER</th>
                                    <th class="border-0">EMAIL</th>
                                    <th class="border-0">PHONE</th>
                                    <th class="border-0">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPelanggan as $item)
                                    <tr>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ $item->birthday ? \Carbon\Carbon::parse($item->birthday)->format('Y-m-d') : '-' }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($item->gender == 'Male') bg-primary
                                                @elseif($item->gender == 'Female') bg-success
                                                @else bg-secondary
                                                @endif">
                                                {{ $item->gender }}
                                            </span>
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('pelanggan.show', $item->pelanggan_id) }}" 
                                                   class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                                <a href="{{ route('pelanggan.edit', $item->pelanggan_id) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('pelanggan.destroy', $item->pelanggan_id) }}" 
                                                      method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No customer data found.</p>
                                            @if($search || $selectedGender != 'All Gender')
                                                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                                                    Show All Data
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($dataPelanggan->hasPages())
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-sm-4 text-muted">
                                Showing <strong>{{ $dataPelanggan->firstItem() }}</strong> - 
                                <strong>{{ $dataPelanggan->lastItem() }}</strong> of 
                                <strong>{{ $dataPelanggan->total() }}</strong> entries
                            </div>
                            <div class="col-sm-8 d-flex justify-content-end">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($dataPelanggan->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo;</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dataPelanggan->previousPageUrl() }}" rel="prev">&laquo;</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($dataPelanggan->getUrlRange(1, $dataPelanggan->lastPage()) as $page => $url)
                                            @if ($page == $dataPelanggan->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($dataPelanggan->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dataPelanggan->nextPageUrl() }}" rel="next">&raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">&raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- END MAIN CONTENT --}}
@endsection

@push('styles')
<style>
.pagination {
    margin-bottom: 0;
}
.page-link {
    color: #6c757d;
    border: 1px solid #dee2e6;
}
.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}
.page-link:hover {
    color: #0056b3;
}
.table th {
    font-weight: 600;
    font-size: 0.875rem;
}
.badge {
    font-size: 0.75rem;
}
.btn-group .btn {
    margin-right: 2px;
}
.btn-sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endpush