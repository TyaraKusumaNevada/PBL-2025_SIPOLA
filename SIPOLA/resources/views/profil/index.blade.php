@extends('layouts.template')

@section('content')
    <div class="container">
        <h1 class="mb-4">Profil Saya</h1>

        <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back()">Kembali</button>

        {{-- Nama dan Foto --}}
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center">
                <img id="profile-photo" src="{{ $fotoPath }}" alt="Foto Profil" class="rounded-circle me-3" width="80"
                    height="80">
                <div>
                    <h3 id="display-nama">{{ $user->name }}</h3>
                    <h6 class="mb-0" style="color: rgb(105, 98, 235);">@<span id="display-username">{{ $user->username }}</span></h6>

                </div>
            </div>
        </div>

        {{-- Tombol Edit --}}
        <button class="btn btn-outline-primary mb-3" id="btn-edit-profile">
            <i class="fa fa-edit me-1"></i>Edit Profil
        </button>

        {{-- Form Edit Profil --}}
        <div id="edit-form" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <form id="form-edit-profile" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->name }}">
                            <div id="error-nama" class="text-danger mt-1" style="display:none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username Baru</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ $user->username }}">
                            <div id="error-username" class="text-danger mt-1" style="display:none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil (jpg/png, max 2MB)</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil"
                                accept=".jpg,.jpeg,.png">
                            <div id="error-foto" class="text-danger mt-1" style="display:none;"></div>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" id="btn-cancel">Batal</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Informasi Akademik --}}
        <div id="academic-profile-section">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informasi Akademik</h5>
                    <table class="table table-bordered">
                        <thead style="background-color: #695fdf; color: white;">

                            <tr>
                                <th style="color: white;">Jenis</th>
                                <th style="color: white;">Isi</th>
                                <th style="color: white;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['keahlian' => 'Bidang Keahlian', 'sertifikasi' => 'Sertifikasi', 'pengalaman' => 'Pengalaman'] as $key => $label)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td id="td-{{ $key }}">
                                        <ul class="mb-0 ps-3">
                                            @foreach(explode(';', $user->$key) as $item)
                                                @if(trim($item) != '')
                                                    <li>{{ $item }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="showEditModal('{{ $key }}', '{{ $label }}')">
                                            <i class="fa fa-edit"></i> Edit
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
        <div class="modal fade" id="editAcademicModal" tabindex="-1" aria-labelledby="editAcademicModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-edit-academic" class="modal-content">
                    @csrf
                    <input type="hidden" id="academic-type" name="type">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAcademicModalLabel">Edit Akademik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <label for="academic-value" class="form-label">Isi (pisahkan dengan `;`)</label>
                        <textarea class="form-control" id="academic-value" name="value" rows="4" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>


        {{-- Form Edit Akademik --}}
        <div id="edit-academic-form" style="display:none;">
            <form id="form-edit-academic">
                @csrf
                <input type="hidden" id="academic-type" name="type">
                <div class="mb-3">
                    <label id="label-edit-academic" class="form-label"></label>
                    <textarea class="form-control" id="academic-value" name="value" rows="3" required></textarea>
                    <small class="text-muted">Pisahkan item dengan tanda titik koma ; jika lebih dari satu.</small>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="hideEditAcademicForm()">Batal</button>
            </form>
        </div>

        <div id="message-academic" class="mt-3"></div>


    </div>

    {{-- FontAwesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Script --}}
    <script>
        document.getElementById('btn-edit-profile').addEventListener('click', function () {
            document.getElementById('edit-form').style.display = 'block';
        });

        document.getElementById('btn-cancel').addEventListener('click', function () {
            document.getElementById('edit-form').style.display = 'none';
        });

        document.getElementById('form-edit-profile').addEventListener('submit', function (e) {
            e.preventDefault();
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
                            document.getElementById('error-nama').textContent = data.errors.nama[0];
                            document.getElementById('error-nama').style.display = 'block';
                        }
                        if (data.errors.username) {
                            document.getElementById('error-username').textContent = data.errors.username[0];
                            document.getElementById('error-username').style.display = 'block';
                        }
                        if (data.errors.foto_profil) {
                            document.getElementById('error-foto').textContent = data.errors.foto_profil[0];
                            document.getElementById('error-foto').style.display = 'block';
                        }
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(err => console.error(err));
        });

        function showEditAcademicForm(type, label) {
            document.getElementById('edit-academic-form').style.display = 'block';
            document.getElementById('academic-type').value = type;
            document.getElementById('label-edit-academic').textContent = "Edit " + label;
            document.getElementById('academic-value').value = document.getElementById('list-' + type).innerText.split('\n').join('; ');
        }

        function hideEditAcademicForm() {
            document.getElementById('edit-academic-form').style.display = 'none';
        }

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
                body: JSON.stringify({ type: type, value: value })
            })
                .then(res => res.json())
                .then(data => {
                    const messageEl = document.getElementById('message-academic');
                    if (data.success) {
                        const listEl = document.getElementById('list-' + type);
                        listEl.innerHTML = '';
                        const items = value.split(';');
                        items.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = item.trim();
                            listEl.appendChild(li);
                        });
                        messageEl.textContent = data.message;
                        messageEl.className = "alert alert-success";
                        hideEditAcademicForm();
                    } else {
                        messageEl.textContent = data.error;
                        messageEl.className = "alert alert-danger";
                    }
                })
                .catch(err => console.error(err));
        });

        let currentAcademicKey = '';

        function showEditModal(type, label) {
            currentAcademicKey = type;
            document.getElementById('academic-type').value = type;
            document.getElementById('editAcademicModalLabel').innerText = 'Edit ' + label;

            const items = Array.from(document.querySelectorAll(`#td-${type} li`)).map(li => li.textContent.trim());
            document.getElementById('academic-value').value = items.join('; ');

            const modal = new bootstrap.Modal(document.getElementById('editAcademicModal'));
            modal.show();
        }

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
                body: JSON.stringify({ type: type, value: value })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const td = document.getElementById('td-' + type);
                        const ul = document.createElement('ul');
                        ul.className = 'mb-0 ps-3';
                        value.split(';').forEach(item => {
                            if (item.trim() !== '') {
                                const li = document.createElement('li');
                                li.textContent = item.trim();
                                ul.appendChild(li);
                            }
                        });
                        td.innerHTML = '';
                        td.appendChild(ul);

                        const modal = bootstrap.Modal.getInstance(document.getElementById('editAcademicModal'));
                        modal.hide();
                    } else {
                        alert(data.error || 'Terjadi kesalahan');
                    }
                })
                .catch(err => console.error(err));
        });

    </script>
@endsection