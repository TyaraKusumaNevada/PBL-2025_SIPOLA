<div class="modal-dialog">
  <div class="modal-content">
    <form id="form-create-prodi" action="{{ url('admin/ManajemenProdi/store_ajax') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Program Studi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Prodi</label>
          <input type="text" name="nama_prodi" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Jenjang</label>
          <select name="jenjang" class="form-select" required>
            <option value="">-- Pilih Jenjang --</option>
            <option>D2</option>
            <option>D3</option>
            <option>D4</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
$('#form-create-prodi').on('submit', function(e) {
  e.preventDefault();
  const $f = $(this);
  $.ajax({
    url: $f.attr('action'),
    method: 'POST',
    data: $f.serialize(),
    success() {
      bootstrap.Modal.getInstance($('#myModal')[0]).hide();
      dataProdi.draw();
      Swal.fire('Berhasil','Program studi berhasil ditambahkan','success');
    },
    error(xhr) {
      const msg = xhr.responseJSON?.errors
                ? Object.values(xhr.responseJSON.errors).flat().join('<br>')
                : 'Terjadi kesalahan';
      Swal.fire('Gagal', msg, 'error');
    }
  });
});
</script>
