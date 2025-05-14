<!-- Modal Edit User -->
<div class="modal fade" id="modal-edit-user" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-edit-user">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="jenis_user" id="edit-jenis-user">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="email" id="edit-email" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Role</label>
                        <select name="id_role" id="edit-role" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id_role }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
