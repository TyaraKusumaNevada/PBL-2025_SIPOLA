{{-- @csrf

@foreach ($kriterias as $kriteria)
<div class="mb-3">
    <label for="preferensi_{{ $kriteria->id }}" class="form-label">
        {{ $kriteria->nama_kriteria }}
    </label>
    <select name="preferensi[{{ $kriteria->id }}]" id="preferensi_{{ $kriteria->id }}" class="form-select" required>
        <option value="">-- Pilih Preferensi --</option>
        <option value="1">Sangat Rendah</option>
        <option value="2">Rendah</option>
        <option value="3">Sedang</option>
        <option value="4">Tinggi</option>
        <option value="5">Sangat Tinggi</option>
    </select>
</div>
@endforeach --}}

{{-- <form id="formPreferensi" action="{{ route('mahasiswa.rekomendasi.preferensi.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Input Preferensi Lomba</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body row g-3">
        <!-- Isi input preferensi -->
        <input type="text" name="bidang_minat" class="form-control" placeholder="Bidang Minat" required>
        <input type="text" name="prefer_format" class="form-control" placeholder="Format (Online/Offline)" required>
        <input type="number" name="max_biaya" class="form-control" placeholder="Maksimal Biaya" required>
        <!-- Tambah input lain sesuai kebutuhan -->
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Lanjut ke Bobot</button>
    </div>
</form>

<script>
    $('#formPreferensi').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(response) {
            openFormBobot();
        }).fail(function() {
            alert('Gagal menyimpan preferensi.');
        });
    });
</script> --}}

<form id="formPreferensi" action="{{ route('mahasiswa.rekomendasi.preferensi.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Input Preferensi Lomba</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body row g-3">
        <div class="col-md-6">
            <label for="bidang_minat_id" class="form-label">Bidang Minat</label>
            <select name="bidang_minat_id" id="bidang_minat_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Bidang Minat --</option>
                @foreach($bidangMinat as $minat)
                    <option value="{{ $minat->id }}">{{ $minat->nama_minat }}</option>
                @endforeach
            </select>
            <div id="error-bidang_minat_id" class="form-text text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="prefer_format" class="form-label">Format Lomba</label>
            <select name="prefer_format" id="prefer_format" class="form-select" required>
                <option value="" disabled selected>-- Pilih Format --</option>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
                <option value="bebas">Bebas</option>
            </select>
            <div id="error-prefer_format" class="form-text text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="prefer_tipe_lomba" class="form-label">Tipe Lomba</label>
            <select name="prefer_tipe_lomba" id="prefer_tipe_lomba" class="form-select" required>
                <option value="" disabled selected>-- Pilih Tipe --</option>
                <option value="individu">Individu</option>
                <option value="tim">Tim</option>
                <option value="bebas">Bebas</option>
            </select>
            <div id="error-prefer_tipe_lomba" class="form-text text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="max_biaya" class="form-label">Maksimal Biaya (Rp)</label>
            <input type="number" name="max_biaya" id="max_biaya" class="form-control" required>
            <div id="error-max_biaya" class="form-text text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="min_hadiah" class="form-label">Minimal Hadiah (Rp)</label>
            <input type="number" name="min_hadiah" id="min_hadiah" class="form-control" required>
            <div id="error-min_hadiah" class="form-text text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="min_tingkat" class="form-label">Minimal Tingkat</label>
            <select name="min_tingkat" id="min_tingkat" class="form-select" required>
                <option value="" disabled selected>-- Pilih Minimal Tingkat --</option>
                <option value="politeknik">Politeknik</option>
                <option value="kota">Kota</option>
                <option value="provinsi">Provinsi</option>
                <option value="nasional">Nasional</option>
                <option value="internasional">Internasional</option>
            </select>
            <div id="error-min_tingkat" class="form-text text-danger"></div>
        </div>

        <div class="col-md-6">
            <label for="min_sisa_hari" class="form-label">Minimal Sisa Hari Tersisa</label>
            <input type="number" name="min_sisa_hari" id="min_sisa_hari" class="form-control" required>
            <div id="error-min_sisa_hari" class="form-text text-danger"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Lanjut ke Bobot</button>
    </div>
</form>

<script>
    $('#formPreferensi').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(response) {
            openFormBobot(); // Panggil form bobot setelah preferensi disimpan
        }).fail(function() {
            alert('Gagal menyimpan preferensi. Silakan cek kembali input Anda.');
        });
    });
</script>

