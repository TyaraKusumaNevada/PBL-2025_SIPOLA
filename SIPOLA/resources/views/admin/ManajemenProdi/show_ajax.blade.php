<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Detail Program Studi</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
      <p><strong>Nama Prodi:</strong> {{ $prodi->nama_prodi }}</p>
      <p><strong>Jenjang:</strong> {{ $prodi->jenjang }}</p>
      <hr>
      <p><strong>Dibuat pada:</strong>
        {{ $prodi->created_at->translatedFormat('d F Y H:i') }}</p>
      <p><strong>Diubah pada:</strong>
        {{ $prodi->updated_at->translatedFormat('d F Y H:i') }}</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
  </div>
</div>