@empty($user)
    <div id="modal-master" class="modal modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    @php
        $id = $role === 'mahasiswa' ? $user->id_mahasiswa : ($role === 'dosen' ? $user->id_dosen : $user->id_admin);
    @endphp
    <form action="{{ url('/user/' . $id . '/' . $role . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="id_role" class="form-label">Role</label>
                        <select name="id_role" id="id_role" class="form-select" readonly>
                            @foreach ($roles as $r)
                                <option value="{{ $r->id_role }}" {{ $r->id_role == $user->id_role ? 'selected' : '' }}>
                                    {{ $r->role_nama }}</option>
                            @endforeach
                        </select>
                        <div id="error-id_role" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{ $user->nama }}" class="form-control"
                            required>
                        <div id="error-nama" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control"
                            required>
                        <div id="error-email" class="form-text text-danger"></div>
                    </div>

                    @if ($user->id_role == 3)
                        <div class="mb-3">
                            <label for="nim_nidn" class="form-label">NIM</label>
                            <input type="text" name="nim_nidn" id="nim_nidn" value="{{ $user->nim }}"
                                class="form-control" required>
                            <div id="error-nim_nidn" class="form-text text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="id_prodi" class="form-label">Program Studi</label>
                            <select name="id_prodi" id="id_prodi" class="form-select" required>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->id_prodi }}"
                                        {{ $prodi->id_prodi == $user->id_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                            <div id="error-id_prodi" class="form-text text-danger"></div>
                        </div>
                    @elseif($user->id_role == 2)
                        <div class="mb-3">
                            <label for="nim_nidn" class="form-label">NIDN</label>
                            <input type="text" name="nim_nidn" id="nim_nidn" value="{{ $user->nidn }}"
                                class="form-control" required>
                            <div id="error-nim_nidn" class="form-text text-danger"></div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    nama: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    nim_nidn: {
                        required: function() {
                            return $('#id_role').val() == 2 || $('#id_role').val() == 3;
                        }
                    },
                    id_prodi: {
                        required: function() {
                            return $('#id_role').val() == 3;
                        }
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                const modalElement = document.getElementById('modal-master')
                                    .closest('.modal');
                                const modalInstance = bootstrap.Modal.getInstance(
                                    modalElement);
                                modalInstance.hide();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataUser.ajax.reload();
                            } else {
                                $('.form-text.text-danger').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Terjadi kesalahan pada server. Silakan coba lagi.'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.mb-3').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
