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
                <li class="breadcrumb-item"><a href="#">User</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data User</h1>
                <p class="mb-0">List data seluruh user</p>
            </div>
            <div>
                <a href="{{ route('user.create') }}" class="btn btn-success text-white">
                    <i class="fas fa-plus me-1"></i> Tambah User
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
                            <span class="text-muted">
                                Menampilkan {{ $dataUser->firstItem() }} - {{ $dataUser->lastItem() }} 
                                dari {{ $dataUser->total() }} data
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-user" class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Foto Profil</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataUser as $item)
                                    <tr>
                                        <td>
                                            @if($item->profile_picture)
                                                <img src="{{ Storage::url($item->profile_picture) }}" alt="Profile" class="img-thumbnail" width="50" height="50">
                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <span class="text-white">No Image</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('user.edit', $item->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('user.destroy', $item->id) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data user ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    @if($dataUser->hasPages())
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-sm-4 text-muted">
                                Menampilkan <strong>{{ $dataUser->firstItem() }}</strong> - 
                                <strong>{{ $dataUser->lastItem() }}</strong> dari 
                                <strong>{{ $dataUser->total() }}</strong> data
                            </div>
                            <div class="col-sm-8 d-flex justify-content-end">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($dataUser->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo;</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dataUser->previousPageUrl() }}" rel="prev">&laquo;</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($dataUser->getUrlRange(1, $dataUser->lastPage()) as $page => $url)
                                            @if ($page == $dataUser->currentPage())
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
                                        @if ($dataUser->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dataUser->nextPageUrl() }}" rel="next">&raquo;</a>
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
.btn-group .btn {
    margin-right: 2px;
}
.btn-sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endpush