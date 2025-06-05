@extends('layouts.template')

@section('content')
    <style>
        
        .btn-back:hover {
            background-color: #f41800 !important;
            border-color: #f41800 !important;
            color: #fff !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafc;
            color: #333;
        }

        h1,
        h3,
        h5 {
            font-weight: 600;
        }

        .container {
            padding-top: 40px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #2b3ea0;
            color: white;
            border-color: #2b3ea0;
        }

        .btn-secondary {
            background-color: #95a5a6;
            border: none;
            color: white;
        }

        .table thead {
            background-color: #2b3ea0;
        }

        .table thead th {
            color: #fff;
        }

        .rounded-circle {
            object-fit: cover;
            border: 3px solid #e3e3e3;
        }

        .academic-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .academic-item:last-child {
            border-bottom: none;
        }

        .delete-btn {
            color: #a8a8a8;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }

        .delete-btn:hover {
            color: #e41e1e;
        }

        @media (max-width: 768px) {
            .profile-img {
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>

    <div class="container">
        <a href="{{ url('/') }}" class="btn btn-secondary mb-3 btn-back">
            <i class="fa fa-arrow-left me-1"></i> Kembali
        </a>

        <h1 class="mb-4">Profil Mahasiswa</h1>

        {{-- Profil Display --}}
        <div class="card p-4">
            <div class="row align-items-center">
                <div class="col-md-3 text-center profile-img">
                    <img id="profile-photo" src="{{ $fotoPath }}" alt="Foto Profil" class="rounded-circle" width="150"
                        height="150">
                </div>
                <div class="col-md-6">
                    <h3 id="display-nama">{{ $user->name }}</h3>
                    <p><strong>NIM:</strong> <span id="display-username">{{ $user->username }}</span></p>
                    <p><strong>Program Studi:</strong> Teknik Informatika</p>
                    <p><strong>Angkatan:</strong> 2022</p>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-outline-primary" id="btn-edit-profile">
                        <i class="fa fa-edit me-1"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>

        {{-- Form Edit Profil --}}
        <div id="edit-form" style="display: none;">
            <div class="card p-4">
                <form id="form-edit-profile" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->name }}">
                        <div id="error-nama" class="text-danger mt-1" style="display:none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username Baru</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                        <div id="error-username" class="text-danger mt-1" style="display:none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="foto_profil" class="form-label">Foto Profil (jpg/png, max 2MB)</label>
                        <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
                        <div id="error-foto" class="text-danger mt-1" style="display:none;"></div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="btn-cancel">Batal</button>
                </form>
            </div>
        </div>

        {{-- Informasi Akademik --}}
        <div id="academic-profile-section">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informasi Akademik</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Isi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['bidang_keahlian' => 'Keahlian', 'sertifikasi' => 'Minat', 'pengalaman' => 'Pengalaman'] as $key => $label)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td id="td-{{ $key }}">
                                        <div id="list-{{ $key }}">
                                            @foreach(explode(';', $user->$key) as $index => $item)
                                                @if(trim($item) != '')
                                                    <div class="academic-item" data-index="{{ $index }}">
                                                        <span>{{ trim($item) }}</span>
                                                        <i class="fa fa-trash delete-btn" onclick="deleteAcademicItem('{{ $key }}', {{ $index }})" title="Hapus item"></i>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="showAddModal('{{ $key }}', '{{ $label }}')">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Edit Akademik --}}
        <div class="modal fade" id="editAcademicModal" tabindex="-1" aria-labelledby="editAcademicModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-edit-academic" class="modal-content">
                    @csrf
                    <input type="hidden" id="academic-type" name="type">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAcademicModalLabel">Edit Akademik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <label for="academic-value" class="form-label">Isikan bidangnya saja (pisahkan dengan `;`)</label>
                        <textarea class="form-control" id="academic-value" name="value" rows="4" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Tambah Akademik --}}
        <div class="modal fade" id="addAcademicModal" tabindex="-1" aria-labelledby="addAcademicModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-add-academic" class="modal-content">
                    @csrf
                    <input type="hidden" id="add-academic-type" name="type">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAcademicModalLabel">Tambah Akademik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <label for="add-academic-value" class="form-label">Tambahkan item baru</label>
                        <input type="text" class="form-control" id="add-academic-value" name="value" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- FontAwesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        // Toggle tampilkan form edit profil
        document.getElementById('btn-edit-profile').addEventListener('click', () => {
            document.getElementById('edit-form').style.display = 'block';
        });

        document.getElementById('btn-cancel').addEventListener('click', () => {
            document.getElementById('edit-form').style.display = 'none';
            clearProfileErrors();
        });

        function clearProfileErrors() {
            ['error-nama', 'error-username', 'error-foto'].forEach(id => {
                const el = document.getElementById(id);
                el.style.display = 'none';
                el.textContent = '';
            });
        }

        // Submit form edit profil
        document.getElementById('form-edit-profile').addEventListener('submit', function (e) {
            e.preventDefault();
            clearProfileErrors();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('profil.update.profile') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": formData.get('_token'),
                    "Accept": "application/json"
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('display-nama').textContent = data.user.nama;
                        document.getElementById('display-username').textContent = data.user.username;

                        if (data.fotoPath) {
                            document.getElementById('profile-photo').src = data.fotoPath + '?t=' + new Date().getTime();
                        }
                        document.getElementById('edit-form').style.display = 'none';
                    } else if (data.errors) {
                        if (data.errors.nama) {
                            let el = document.getElementById('error-nama');
                            el.textContent = data.errors.nama[0];
                            el.style.display = 'block';
                        }
                        if (data.errors.username) {
                            let el = document.getElementById('error-username');
                            el.textContent = data.errors.username[0];
                            el.style.display = 'block';
                        }
                        if (data.errors.foto_profil) {
                            let el = document.getElementById('error-foto');
                            el.textContent = data.errors.foto_profil[0];
                            el.style.display = 'block';
                        }
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(err => console.error(err));
        });

        // Tampilkan modal edit akademik
        function showEditModal(type, label) {
            document.getElementById('academic-type').value = type;
            document.getElementById('editAcademicModalLabel').innerText = 'Edit ' + label;

            // Ambil data dari list dan gabungkan jadi string pisah ';'
            const items = Array.from(document.querySelectorAll(`#list-${type} .academic-item span`)).map(span => span.textContent.trim());
            document.getElementById('academic-value').value = items.join('; ');

            const modal = new bootstrap.Modal(document.getElementById('editAcademicModal'));
            modal.show();
        }

        // Tampilkan modal tambah akademik
        function showAddModal(type, label) {
            document.getElementById('add-academic-type').value = type;
            document.getElementById('addAcademicModalLabel').innerText = 'Tambah ' + label;
            document.getElementById('add-academic-value').value = '';

            const modal = new bootstrap.Modal(document.getElementById('addAcademicModal'));
            modal.show();
        }

        // Submit form edit akademik modal
        document.getElementById('form-edit-academic').addEventListener('submit', function (e) {
            e.preventDefault();

            const type = document.getElementById('academic-type').value;
            const value = document.getElementById('academic-value').value;
            const token = document.querySelector('input[name="_token"]').value;

            fetch("{{ route('profil.update.academic') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ type: type, value: value, action: 'update' })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateAcademicDisplay(type, data.items);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editAcademicModal'));
                        modal.hide();
                    } else {
                        alert(data.error || 'Terjadi kesalahan');
                    }
                })
                .catch(err => console.error(err));
        });

        // Submit form tambah akademik modal
        document.getElementById('form-add-academic').addEventListener('submit', function (e) {
            e.preventDefault();

            const type = document.getElementById('add-academic-type').value;
            const value = document.getElementById('add-academic-value').value;
            const token = document.querySelector('input[name="_token"]').value;

            fetch("{{ route('profil.update.academic') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ type: type, value: value, action: 'add' })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateAcademicDisplay(type, data.items);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addAcademicModal'));
                        modal.hide();
                    } else {
                        alert(data.error || 'Terjadi kesalahan');
                    }
                })
                .catch(err => console.error(err));
        });

        // Hapus item akademik
        function deleteAcademicItem(type, index) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                const token = document.querySelector('input[name="_token"]').value;

                fetch("{{ route('profil.delete.academic') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ type: type, index: index })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            updateAcademicDisplay(type, data.items);
                        } else {
                            alert(data.error || 'Terjadi kesalahan');
                        }
                    })
                    .catch(err => console.error(err));
            }
        }

        // Update tampilan akademik
        function updateAcademicDisplay(type, items) {
            const container = document.getElementById('list-' + type);
            container.innerHTML = '';

            items.forEach((item, index) => {
                if (item.trim() !== '') {
                    const div = document.createElement('div');
                    div.className = 'academic-item';
                    div.setAttribute('data-index', index);
                    div.innerHTML = `
                        <span>${item.trim()}</span>
                        <i class="fa fa-trash delete-btn" onclick="deleteAcademicItem('${type}', ${index})" title="Hapus item"></i>
                    `;
                    container.appendChild(div);
                }
            });
        }
    </script>
@endsection