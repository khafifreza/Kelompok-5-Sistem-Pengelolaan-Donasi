@extends('layouts.admin')
@section('title', 'Kelola Program')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Program</div>
        <h1 class="page-title">Kelola Program Donasi</h1>
        <p class="page-subtitle">Buat, edit, cari, dan ubah status program penggalangan dana.</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuatProgram">
        <i class="bi bi-plus"></i> Buat Program
    </button>
</div>

<div class="content-card">
    <form method="GET" action="{{ route('admin.program') }}" class="card-header-custom">
        <div class="search-box" style="flex: 1; max-width: 400px;">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama program..." aria-label="Cari program">
        </div>
        <div class="filter-group">
            <select class="form-control-custom" name="category" aria-label="Filter kategori">
                <option value="">Semua Kategori</option>
                @foreach($categories as $programCategory)
                    <option value="{{ $programCategory }}" @selected($category === $programCategory)>{{ $programCategory }}</option>
                @endforeach
            </select>
            <select class="form-control-custom" name="status" aria-label="Filter status">
                <option value="">Semua Status</option>
                <option value="active" @selected($status === 'active')>Aktif</option>
                <option value="closed" @selected($status === 'closed')>Ditutup</option>
            </select>
            <button type="submit" class="btn btn-outline-custom">Filter</button>
            @if($search !== '' || $category !== '' || $status !== '')
                <a class="btn btn-ghost" href="{{ route('admin.program') }}">Reset</a>
            @endif
        </div>
    </form>

    <div class="program-admin-list">
        @forelse($programs as $program)
            <article class="program-admin-item">
                <div class="program-admin-img">
                    @if($program->imageUrl())
                        <img src="{{ $program->imageUrl() }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="bi bi-heart"></i>
                    @endif
                </div>
                <div class="program-admin-info">
                    <h4>{{ $program->title }}</h4>
                    <div class="program-admin-meta">
                        <span class="badge-category">{{ $program->category }}</span>
                        @if($program->status === 'active')
                            <span class="status-badge berhasil">Aktif</span>
                        @else
                            <span class="badge text-bg-secondary">Ditutup</span>
                        @endif
                        <span><i class="bi bi-people"></i> {{ $program->donations_count }} donasi</span>
                    </div>
                    <div class="program-admin-progress">
                        <div class="progress-label">
                            <strong>{{ \App\Models\Program::rupiah($program->raisedAmount()) }}</strong>
                            <span>{{ $program->progressPercent() }}% dari {{ \App\Models\Program::rupiah($program->target_amount) }}</span>
                        </div>
                        <div class="progress">
                            <i style="width: {{ $program->progressPercent() }}%;"></i>
                        </div>
                    </div>
                </div>
                <div class="program-admin-actions">
                    <button class="btn btn-ghost btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalEditProgram{{ $program->id }}" aria-label="Edit {{ $program->title }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" onsubmit="return confirm('Hapus program ini? Program yang memiliki riwayat donasi tidak dapat dihapus.')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost btn-sm text-danger" type="submit" aria-label="Hapus {{ $program->title }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <p class="text-center p-4 mb-0">Belum ada program yang cocok dengan pencarian.</p>
        @endforelse
    </div>

    <div class="p-3">
        {{ $programs->links() }}
    </div>
</div>

<div class="modal fade" id="modalBuatProgram" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-program">
            <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="modal-program-header">
                <div class="modal-eyebrow">KELOLA PROGRAM</div>
                <h2>Buat Program Baru</h2>
                <p>Lengkapi informasi utama program penggalangan dana.</p>
            </div>
            <form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_form" value="program-create">
                <input type="hidden" name="status" value="active">
                <div class="form-group-custom">
                    <label for="create-title">Nama Program</label>
                    <input id="create-title" type="text" name="title" class="form-control-custom" value="{{ old('_form') === 'program-create' ? old('title') : '' }}" required>
                    @error('title') <small class="text-danger" role="alert">{{ $message }}</small> @enderror
                </div>
                <div class="form-group-custom">
                    <label for="create-category">Kategori</label>
                    <input id="create-category" type="text" name="category" class="form-control-custom" value="{{ old('_form') === 'program-create' ? old('category') : '' }}" required>
                    @error('category') <small class="text-danger" role="alert">{{ $message }}</small> @enderror
                </div>
                <div class="form-group-custom">
                    <label for="create-target">Target Donasi (Rp)</label>
                    <input id="create-target" type="number" name="target_amount" class="form-control-custom" value="{{ old('_form') === 'program-create' ? old('target_amount') : '' }}" min="10000" required>
                    @error('target_amount') <small class="text-danger" role="alert">{{ $message }}</small> @enderror
                </div>
                <div class="form-group-custom">
                    <label for="create-image">Foto Sampul (opsional, maksimal 5 MB)</label>
                    <input id="create-image" type="file" name="image" class="form-control-custom" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    @error('image') <small class="text-danger" role="alert">{{ $message }}</small> @enderror
                </div>
                <div class="form-group-custom">
                    <label for="create-description">Deskripsi</label>
                    <textarea id="create-description" name="description" class="form-control-custom textarea-custom" required>{{ old('_form') === 'program-create' ? old('description') : '' }}</textarea>
                    @error('description') <small class="text-danger" role="alert">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn-submit-program">Simpan Program <i class="bi bi-plus"></i></button>
            </form>
        </div>
    </div>
</div>

@foreach($programs as $program)
    @php
        $isEditError = old('_form') === 'program-edit' && (int) old('_program_id') === $program->id;
    @endphp
    <div class="modal fade" id="modalEditProgram{{ $program->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-program">
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="modal-program-header">
                    <div class="modal-eyebrow">KELOLA PROGRAM</div>
                    <h2>Edit Program</h2>
                    <p>Perbarui informasi program donasi.</p>
                </div>
                <form method="POST" action="{{ route('admin.programs.update', $program) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="program-edit">
                    <input type="hidden" name="_program_id" value="{{ $program->id }}">
                    <div class="form-group-custom">
                        <label for="edit-title-{{ $program->id }}">Nama Program</label>
                        <input id="edit-title-{{ $program->id }}" type="text" name="title" class="form-control-custom" value="{{ $isEditError ? old('title', $program->title) : $program->title }}" required>
                        @if($isEditError) @error('title') <small class="text-danger" role="alert">{{ $message }}</small> @enderror @endif
                    </div>
                    <div class="form-group-custom">
                        <label for="edit-category-{{ $program->id }}">Kategori</label>
                        <input id="edit-category-{{ $program->id }}" type="text" name="category" class="form-control-custom" value="{{ $isEditError ? old('category', $program->category) : $program->category }}" required>
                        @if($isEditError) @error('category') <small class="text-danger" role="alert">{{ $message }}</small> @enderror @endif
                    </div>
                    <div class="form-group-custom">
                        <label for="edit-target-{{ $program->id }}">Target Donasi (Rp)</label>
                        <input id="edit-target-{{ $program->id }}" type="number" name="target_amount" class="form-control-custom" value="{{ $isEditError ? old('target_amount', $program->target_amount) : $program->target_amount }}" min="10000" required>
                        @if($isEditError) @error('target_amount') <small class="text-danger" role="alert">{{ $message }}</small> @enderror @endif
                    </div>
                    <div class="form-group-custom">
                        <label for="edit-status-{{ $program->id }}">Status</label>
                        <select id="edit-status-{{ $program->id }}" name="status" class="form-control-custom">
                            <option value="active" @selected(($isEditError ? old('status', $program->status) : $program->status) === 'active')>Aktif</option>
                            <option value="closed" @selected(($isEditError ? old('status', $program->status) : $program->status) === 'closed')>Ditutup</option>
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label for="edit-image-{{ $program->id }}">Ganti Foto Sampul (opsional, maksimal 5 MB)</label>
                        @if($program->imageUrl())
                            <img src="{{ $program->imageUrl() }}" alt="Foto sampul {{ $program->title }}" style="display: block; width: 100%; max-height: 180px; object-fit: cover; margin-bottom: 8px;">
                        @endif
                        <input id="edit-image-{{ $program->id }}" type="file" name="image" class="form-control-custom" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        @if($isEditError) @error('image') <small class="text-danger" role="alert">{{ $message }}</small> @enderror @endif
                    </div>
                    <div class="form-group-custom">
                        <label for="edit-description-{{ $program->id }}">Deskripsi</label>
                        <textarea id="edit-description-{{ $program->id }}" name="description" class="form-control-custom textarea-custom" required>{{ $isEditError ? old('description', $program->description) : $program->description }}</textarea>
                        @if($isEditError) @error('description') <small class="text-danger" role="alert">{{ $message }}</small> @enderror @endif
                    </div>
                    <button type="submit" class="btn-submit-program">Simpan Perubahan <i class="bi bi-check"></i></button>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('scripts')
    @if(old('_form') === 'program-create')
        <script>
            window.addEventListener('DOMContentLoaded', () => new bootstrap.Modal(document.getElementById('modalBuatProgram')).show());
        </script>
    @elseif(old('_form') === 'program-edit' && old('_program_id'))
        <script>
            window.addEventListener('DOMContentLoaded', () => new bootstrap.Modal(document.getElementById('modalEditProgram{{ (int) old('_program_id') }}')).show());
        </script>
    @endif
@endsection
