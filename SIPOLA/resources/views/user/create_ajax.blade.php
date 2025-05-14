<form id="formTambahUser">
    @csrf
    <div class="mb-3">
        <label for="id_role" class="form-label">Role User</label>
        <select name="id_role" id="id_role" class="form-control" required>
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->id_role }}">{{ ucfirst($role->role_nama) }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3" id="form_nim_nidn">
        <label for="nim_nidn" class="form-label">NIM / NIDN</label>
        <input type="text" name="nim_nidn" id="nim_nidn" class="form-control">
    </div>
    <div class="mb-3" id="form_prodi" style="display: none;">
        <label for="id_prodi" class="form-label">Program Studi</label>
        <select name="id_prodi" id="id_prodi" class="form-control" required>
            <option value="" disabled selected>-- Pilih Prodi --</option>
            @foreach($prodis as $prodi)
                <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
            @endforeach
        </select>
</div>


    <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $('#formTambahUser').on('submit', function(e) {
    e.preventDefault();

    const role = $('#id_role').val();
    const prodi = $('#id_prodi').val();

    if (role == 3 && (!prodi || prodi === "")) {
        alert('Program Studi wajib diisi untuk Mahasiswa.');
        return;
    }

    let form = $(this);

    $.ajax({
        url: "{{ route('user.store_ajax') }}",
        method: 'POST',
        data: form.serialize(),
        success: function(res) {
            alert(res.success);
            $('#modalUser').modal('hide');
            $('#userTable').DataTable().ajax.reload();
        },
        error: function(xhr) {
            console.log(xhr);

            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let pesan = Object.values(xhr.responseJSON.errors).join('\n');
                alert(pesan);
            } else if (xhr.responseText) {
                alert('Error: ' + xhr.responseText);
            } else {
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        }
    });
});

</script>

<script>
    $('#id_role').on('change', function () {
        const selected = $(this).val();
        if (selected == 3) { // 3 = Mahasiswa
            $('#form_prodi').show();
        } else {
            $('#form_prodi').hide();
            $('#id_prodi').val('');
        }

        // Nampilin NIM/NIDN kalo role Dosen dan Mahasiswa
        if (selected === "2" || selected === "3") {
        $('#form_nim_nidn').show();
        } else {
            $('#form_nim_nidn').hide();
            $('#nim_nidn').val('');
        }
    });
</script>
