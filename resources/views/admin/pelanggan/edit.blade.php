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
                <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Pelanggan</h1>
                <p class="mb-0">Form untuk edit data pelanggan.</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                    <i class="far fa-question-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-info">
            {!! session('success') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('pelanggan.update', $pelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Input Hidden untuk ref_table dan ref_id -->
                        <input type="hidden" name="ref_table" value="pelanggan">
                        <input type="hidden" name="ref_id" value="{{ $pelanggan->pelanggan_id }}">

                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" class="form-control" required 
                                           name="first_name" value="{{ $pelanggan->first_name }}">
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" class="form-control" required 
                                           name="last_name" value="{{ $pelanggan->last_name }}">
                                </div>

                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" id="birthday" class="form-control" 
                                           name="birthday" value="{{ $pelanggan->birthday }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" class="form-control" name="gender">
                                        <option value="">Pilih Gender</option>
                                        <option value="Male" {{ $pelanggan->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $pelanggan->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ $pelanggan->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" class="form-control" required 
                                           name="email" value="{{ $pelanggan->email }}">
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" class="form-control" 
                                           name="phone" value="{{ $pelanggan->phone }}">
                                </div>
                            </div>
                        </div>

                        <!-- Multiple File Upload Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">File Pendukung</h5>
                                        <p class="card-text text-muted">Upload file pendukung untuk pelanggan (maksimal 2MB per file)</p>
                                    </div>
                                    <div class="card-body">
                                        <!-- Form Upload File Baru -->
                                        <div class="mb-4">
                                            <label for="files" class="form-label">Tambah File Baru</label>
                                            <input type="file" id="files" class="form-control" 
                                                   name="files[]" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
                                            <small class="text-muted">Format: JPG, JPEG, PNG, PDF, DOC, DOCX, TXT (Max: 2MB per file)</small>
                                        </div>

                                        <!-- Daftar File yang Sudah Diupload -->
                                        @if($pelanggan->files->count() > 0)
                                            <div class="mt-4">
                                                <h6>File Terupload:</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama File</th>
                                                                <th>Tipe</th>
                                                                <th>Preview</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($pelanggan->files as $file)
                                                                <tr>
                                                                    <td>{{ $file->filename }}</td>
                                                                    <td>
                                                                        <span class="badge bg-info">{{ strtoupper($file->file_extension) }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @if($file->is_image)
                                                                            <img src="{{ $file->file_url }}" alt="Preview" class="img-thumbnail" style="max-height: 50px;">
                                                                        @else
                                                                            <span class="text-muted">No Preview</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ $file->file_url }}" target="_blank" class="btn btn-sm btn-info">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <button type="button" class="btn btn-sm btn-danger delete-file" 
                                                                                data-file-id="{{ $file->id }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Belum ada file pendukung yang diupload.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('pelanggan.show', $pelanggan->pelanggan_id) }}" class="btn btn-info">
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </a>
                                <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MAIN CONTENT --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete file
    document.querySelectorAll('.delete-file').forEach(button => {
        button.addEventListener('click', function() {
            const fileId = this.getAttribute('data-file-id');
            if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
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
                        this.closest('tr').remove();
                        // Show success message
                        alert('File berhasil dihapus');
                        // Reload page if no files left
                        if (document.querySelectorAll('.delete-file').length === 0) {
                            location.reload();
                        }
                    } else {
                        alert('Gagal menghapus file');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus file');
                });
            }
        });
    });
});
</script>
@endpush