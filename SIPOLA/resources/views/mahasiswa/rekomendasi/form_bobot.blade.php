{{-- @csrf

@foreach ($kriterias as $kriteria)
<div class="mb-3">
    <label for="bobot_{{ $kriteria->id }}" class="form-label">
        Bobot {{ $kriteria->nama_kriteria }}
    </label>
    <input type="number" name="bobot[{{ $kriteria->id }}]" id="bobot_{{ $kriteria->id }}" 
        class="form-control" min="0" max="100" step="1" required placeholder="Masukkan bobot (%)">
</div>
@endforeach --}}

{{-- @csrf
@php
    $data = $bobot ?? null;
@endphp

@foreach ([
    'bobot_biaya' => 'Bobot Biaya Pendaftaran',
    'bobot_hadiah' => 'Bobot Hadiah',
    'bobot_tingkat' => 'Bobot Tingkat Lomba',
    'bobot_sisa_hari' => 'Bobot Sisa Hari Pendaftaran',
    'bobot_format' => 'Bobot Format Lomba',
    'bobot_minat' => 'Bobot Kesesuaian Minat',
] as $field => $label)
    <div class="mb-3">
        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
        <input type="number" name="{{ $field }}" id="{{ $field }}" class="form-control"
            min="0" max="100" value="{{ old($field, $data->$field ?? '') }}" required>
    </div>
@endforeach

<button type="submit" class="btn btn-primary">Simpan</button> --}}
{{-- <form id="formPreferensi" action="{{ route('preferensi.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Sesuaikan Bobot Preferensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body row g-3">
        @php
            $fields = [
                'bobot_biaya' => 'Biaya Pendaftaran',
                'bobot_hadiah' => 'Hadiah',
                'bobot_tingkat' => 'Tingkat Lomba',
                'bobot_sisa_hari' => 'Sisa Hari',
                'bobot_format' => 'Format Lomba',
                'bobot_minat' => 'Kesesuaian Minat'
            ];
        @endphp

        @foreach ($fields as $key => $label)
            <div class="col-md-6">
                <label for="{{ $key }}" class="form-label">{{ $label }} (1–10)</label>
                <input type="number" class="form-control" name="{{ $key }}" id="{{ $key }}" min="1" max="10" required>
            </div>
        @endforeach
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $('#formPreferensi').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);

        $.post(form.attr('action'), form.serialize(), function(response) {
            alert(response.success);
            $('#myModal').modal('hide');
        }).fail(function(xhr) {
            alert('Gagal menyimpan preferensi. Periksa input.');
        });
    });
</script> --}}
<!-- resources/views/mahasiswa/rekomendasi/form_bobot.blade.php -->
{{-- <form id="formPreferensi" action="{{ route('mahasiswa.rekomendasi.bobot.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Sesuaikan Bobot Preferensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body row g-3">
        @php
            $fields = [
                'bobot_biaya' => 'Biaya Pendaftaran',
                'bobot_hadiah' => 'Hadiah',
                'bobot_tingkat' => 'Tingkat Lomba',
                'bobot_sisa_hari' => 'Sisa Hari',
                'bobot_format' => 'Format Lomba',
                'bobot_minat' => 'Kesesuaian Minat'
            ];
        @endphp

        @foreach ($fields as $key => $label)
            <div class="col-md-6">
                <label for="{{ $key }}" class="form-label">{{ $label }} (1–10)</label>
                <input type="number" class="form-control" name="{{ $key }}" id="{{ $key }}" min="1" max="10" required>
            </div>
        @endforeach
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $('#formPreferensiBobot').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(response) {
            window.location.href = "{{ route('mahasiswa.rekomendasi.index') }}";
        }).fail(function() {
            alert('Gagal menyimpan bobot.');
        });
    });
</script> --}}
<form id="formPreferensiBobot" action="{{ route('mahasiswa.rekomendasi.bobot.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Sesuaikan Bobot Preferensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body row g-3">
        @php
            $fields = [
                'bobot_biaya' => 'Biaya Pendaftaran',
                'bobot_hadiah' => 'Hadiah',
                'bobot_tingkat' => 'Tingkat Lomba',
                'bobot_sisa_hari' => 'Sisa Hari',
                'bobot_format' => 'Format Lomba',
                'bobot_minat' => 'Kesesuaian Minat',
                'bobot_tipe_lomba' => 'Tipe Lomba',
            ];
        @endphp

        @foreach ($fields as $key => $label)
            <div class="col-md-6">
                <label for="{{ $key }}" class="form-label">{{ $label }} (0–1)</label>
                <input type="number" step="0.01" min="0" max="1" class="form-control bobot-input" name="{{ $key }}" id="{{ $key }}" required>
            </div>
        @endforeach

        <div class="col-12 mt-2">
            <div class="alert alert-info p-2">
                Total bobot saat ini: <span id="totalBobot">0.00</span> / Maksimal: 1.00
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
    </div>
</form>

<script>
    function updateTotalBobot() {
        let total = 0;
        $('.bobot-input').each(function() {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) total += val;
        });

        $('#totalBobot').text(total.toFixed(2));

        if (total > 1) {
            $('#totalBobot').parent().removeClass('alert-info').addClass('alert-danger');
            $('#btnSubmit').prop('disabled', true);
        } else {
            $('#totalBobot').parent().removeClass('alert-danger').addClass('alert-info');
            $('#btnSubmit').prop('disabled', false);
        }
    }

    $('.bobot-input').on('input', updateTotalBobot);

    $('#formPreferensiBobot').on('submit', function(e) {
        e.preventDefault();

        let total = 0;
        $('.bobot-input').each(function() {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) total += val;
        });

        if (total > 1) {
            alert('Total bobot melebihi 1.00. Harap sesuaikan.');
            return false;
        }

        $.post($(this).attr('action'), $(this).serialize(), function(response) {
            window.location.href = "{{ route('mahasiswa.rekomendasi.hasil') }}";
        }).fail(function(xhr) {
            console.log(xhr.responseText);
            alert('Gagal menyimpan bobot: ' + xhr.statusText);
        });
        // }).fail(function() {
        //     alert('Gagal menyimpan bobot.');
        // });
    });
</script>