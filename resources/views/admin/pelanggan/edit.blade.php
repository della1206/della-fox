@extends('layouts.admin.app')

@section('content')
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
                <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Pelanggan</h1>
                <p class="mb-0">Form untuk mengedit data pelanggan.</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                    <i class="far fa-question-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror" required
                                        name="first_name" value="{{ old('first_name', $dataPelanggan->first_name) }}">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror" required
                                        name="last_name" value="{{ old('last_name', $dataPelanggan->last_name) }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday <span
                                            class="text-danger">*</span></label>
                                    <input type="date" id="birthday"
                                        class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                        value="{{ old('birthday', $dataPelanggan->birthday) }}">
                                    @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                        name="gender" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Male"
                                            {{ old('gender', $dataPelanggan->gender) == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', $dataPelanggan->gender) == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="Other"
                                            {{ old('gender', $dataPelanggan->gender) == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" required name="email"
                                        value="{{ old('email', $dataPelanggan->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone', $dataPelanggan->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Upload File Baru -->
                                <div class="mb-3">
                                    <label for="files" class="form-label fw-bold">Tambah File Baru</label>
                                    <input type="file" class="form-control @error('files.*') is-invalid @enderror"
                                        name="files[]" multiple accept="*/*">
                                    <small class="text-muted">
                                        Bisa pilih banyak sekaligus. File lama tidak akan hilang kecuali dihapus.<br>
                                        Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, GIF (Max: 5MB)
                                    </small>
                                    @error('files.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('pelanggan.index') }}"
                                        class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>

                        <!-- Tampilkan File yang Sudah Ada -->
@if($dataPelanggan->files && is_array($dataPelanggan->files) && count($dataPelanggan->files) > 0)
<div class="row mb-4">
    <div class="col-12">
        <h6>File Terupload:</h6>
        <div class="row">
            @foreach($dataPelanggan->files as $file)
                @if(is_array($file) && isset($file['path']))
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Selalu tampilkan icon file -->
                            <div class="mb-2" style="font-size: 3rem;">
                                <i class="fas fa-file text-primary"></i>
                            </div>

                            <h6 class="card-title small">
                                {{ isset($file['name']) ? Str::limit($file['name'], 20) : 'File' }}
                            </h6>

                            <div class="btn-group btn-group-sm">
                                <a href="{{ asset('storage/files/' . $file['path']) }}"
                                   target="_blank"
                                   class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('pelanggan.deleteFile', [$dataPelanggan->pelanggan_id, $file['path']]) }}"
                                      method="POST"
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Hapus file ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
