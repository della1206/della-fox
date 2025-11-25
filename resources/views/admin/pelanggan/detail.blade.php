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
                <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Detail Pelanggan</h1>
                <p class="mb-0">Informasi lengkap data pelanggan.</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.edit', $pelanggan->pelanggan_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <!-- Informasi Pelanggan -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <h5 class="mb-3">Informasi Pribadi</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Nama Lengkap</th>
                                    <td>{{ $pelanggan->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $pelanggan->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $pelanggan->phone ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3">Informasi Tambahan</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Tanggal Lahir</th>
                                    <td>{{ $pelanggan->birthday ? \Carbon\Carbon::parse($pelanggan->birthday)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ $pelanggan->gender ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <td>#{{ $pelanggan->pelanggan_id }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- File Pendukung -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-file me-2"></i>File Pendukung
                                        <span class="badge bg-light text-dark ms-2">{{ $pelanggan->files->count() }} file</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($pelanggan->files->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="35%">NAMA FILE</th>
                                                        <th width="15%">TIPE</th>
                                                        <th width="25%">PREVIEW</th>
                                                        <th width="25%">AKSI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pelanggan->files as $file)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <strong>{{ $file->filename }}</strong>
                                                            </td>
                                                            <td class="align-middle">
                                                                <span class="badge bg-info text-uppercase">
                                                                    {{ $file->file_extension }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle">
                                                                @if($file->is_image)
                                                                    <img src="{{ $file->file_url }}" alt="{{ $file->filename }}" 
                                                                         class="img-thumbnail" style="max-height: 80px; max-width: 120px;">
                                                                @else
                                                                    <div class="text-center text-muted">
                                                                        @switch(strtolower($file->file_extension))
                                                                            @case('pdf')
                                                                                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                                                                @break
                                                                            @case('doc')
                                                                            @case('docx')
                                                                                <i class="fas fa-file-word fa-2x text-primary"></i>
                                                                                @break
                                                                            @case('txt')
                                                                                <i class="fas fa-file-alt fa-2x text-secondary"></i>
                                                                                @break
                                                                            @case('jpg')
                                                                            @case('jpeg')
                                                                            @case('png')
                                                                                <i class="fas fa-file-image fa-2x text-success"></i>
                                                                                @break
                                                                            @default
                                                                                <i class="fas fa-file fa-2x text-secondary"></i>
                                                                        @endswitch
                                                                        <br>
                                                                        <small class="text-muted">No Preview</small>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <!-- Tombol Lihat -->
                                                                    <a href="{{ $file->file_url }}" target="_blank" 
                                                                       class="btn btn-outline-primary" title="Lihat File">
                                                                        <i class="fas fa-eye me-1"></i> Lihat
                                                                    </a>
                                                                    
                                                                    <!-- Tombol Download -->
                                                                    <a href="{{ $file->file_url }}" download 
                                                                       class="btn btn-outline-success" title="Download File">
                                                                        <i class="fas fa-download me-1"></i> Unduh
                                                                    </a>
                                                                    
                                                                    <!-- Tombol Hapus -->
                                                                    <button type="button" class="btn btn-outline-danger delete-file" 
                                                                            data-file-id="{{ $file->id }}" title="Hapus File">
                                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada file pendukung yang diupload.</p>
                                            <a href="{{ route('pelanggan.edit', $pelanggan->pelanggan_id) }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Tambah File
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END MAIN CONTENT --}}
@endsection

@push('styles')
<style>
.file-card {
    transition: transform 0.2s;
}
.file-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.file-name {
    font-size: 0.85rem;
}
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete file dengan sweet alert
    document.querySelectorAll('.delete-file').forEach(button => {
        button.addEventListener('click', function() {
            const fileId = this.getAttribute('data-file-id');
            const fileName = this.closest('tr').querySelector('td:first-child').textContent.trim();
            
            Swal.fire({
                title: 'Hapus File?',
                html: Apakah Anda yakin ingin menghapus file <strong>"${fileName}"</strong>?,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    const deleteButton = this;
                    const originalHtml = deleteButton.innerHTML;
                    deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menghapus...';
                    deleteButton.disabled = true;
                    
                    fetch(/pelanggan-file/${fileId}, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove row from table
                            const row = deleteButton.closest('tr');
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.remove();
                                
                                // Update file count badge
                                const badge = document.querySelector('.badge');
                                if (badge) {
                                    const currentCount = parseInt(badge.textContent);
                                    badge.textContent = (currentCount - 1) + ' file';
                                    
                                    // Show message if no files left
                                    if (currentCount - 1 === 0) {
                                        location.reload();
                                    }
                                }
                                
                                // Show success message
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'File berhasil dihapus',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }, 300);
                        } else {
                            throw new Error(data.message || 'Gagal menghapus file');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        deleteButton.innerHTML = originalHtml;
                        deleteButton.disabled = false;
                        
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus file',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        });
    });
});
</script>
@endpush