<!-- Modal Hapus User -->
<div class="modal fade" id="modal-delete-user" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-delete-user">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete-id">
                    <input type="hidden" id="delete-jenis">
                    <p>Apakah Anda yakin ingin menghapus user ini?</p>
                    <p><strong>Nama:</strong> <span id="delete-nama"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
