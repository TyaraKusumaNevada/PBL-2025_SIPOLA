<div class="modal-dialog">
  <div class="modal-content">
    <form id="form-edit-prodi"
          action="{{ url('admin/ManajemenProdi/'.$prodi->id.'/update_ajax') }}"
          method="PUT">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Edit Program Studi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Prodi</label>
          <input type="text"
                 name="nama_prodi"
                 class="form-control"
                 value="{{ $prodi->nama_prodi }}"
                 required>
          <small id="error-nama_prodi" class="error-text form-text text-danger"></small>
        </div>
        <div class="mb-3">
          <label class="form-label">Jenjang</label>
          <select name="jenjang"
                  class="form-select"
                  required>
            <option value="">-- Pilih Jenjang --</option>
            <option value="D2" {{ $prodi->jenjang=='D2' ? 'selected':'' }}>D2</option>
            <option value="D3" {{ $prodi->jenjang=='D3' ? 'selected':'' }}>D3</option>
            <option value="D4" {{ $prodi->jenjang=='D4' ? 'selected':'' }}>D4</option>
          </select>
          <small id="error-jenjang" class="error-text form-text text-danger"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
  // bind AJAX submit untuk form edit
  $('#form-edit-prodi').on('submit', function(e) {
    e.preventDefault();
    const $f = $(this);

    // reset error teks
    $('.error-text').text('');

    $.ajax({
      url:    $f.attr('action'),
      method: 'PUT',
      data:   $f.serialize(),
      success() {
        // tutup modal & refresh DataTable
        $('#myModal').modal('hide');
        dataProdi.draw();
        Swal.fire('Berhasil','Program studi berhasil di-update','success');
      },
      error(xhr) {
        if (xhr.responseJSON?.errors) {
          // tampilkan error per-field
          const errs = xhr.responseJSON.errors;
          Object.keys(errs).forEach(field => {
            $(`#error-${field}`).text(errs[field][0]);
          });
        }
        const msg = xhr.responseJSON?.message || 'Terjadi kesalahan';
        Swal.fire('Gagal', msg, 'error');
      }
    });
  });
</script>
