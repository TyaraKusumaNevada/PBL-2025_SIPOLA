@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">Program Studi Terdaftar</h3>
    <div class="card-tools">
      <button onclick="modalAction('{{ url('admin/ManajemenProdi/create_ajax') }}')" class="btn btn-primary btn-sm">
        + Tambah Program Studi
      </button>
    </div>
  </div>
  <div class="card-body">
    <div id="filter" class="form-horizontal p-2 border-bottom mb-2">
      <div class="row g-2 align-items-center">
        <label class="col-auto col-form-label">Filter:</label>
        <div class="col-auto">
          <select class="form-select form-select-sm filter_jenjang">
            <option value="">- Semua -</option>
            <option>D4</option>
            <option>D3</option>
            <option>D2</option>
          </select>
        </div>
      </div>
    </div>

    <table id="program_studi" class="table table-bordered table-striped table-hover table-sm">
      <thead>
        <tr>
          <th class="text-center">NO</th>
          <th>NAMA PRODI</th>
          <th>JENJANG</th>
          <th class="text-center">AKSI</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  function modalAction(url) {
  $('#myModal').load(url, function() {
    $(this).modal('show');
  });
}

  async function deleteProdi(id) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    const res = await fetch(`{{ url('admin/ManajemenProdi') }}/${id}/delete_ajax`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    const json = await res.json();
    if (json.success) {
      dataProdi.draw();
      Swal.fire('Terhapus','Data berhasil dihapus','success');
    } else {
      Swal.fire('Gagal','Gagal menghapus data','error');
    }
  }

  let dataProdi;
  document.addEventListener('DOMContentLoaded', () => {
    dataProdi = $('#program_studi').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ url('admin/ManajemenProdi/list') }}",
        data: d => d.jenjang = $('.filter_jenjang').val()
      },
      columns: [
        { data: 'DT_RowIndex', className:'text-center', orderable:false, searchable:false },
        { data: 'nama_prodi' },
        { data: 'jenjang' },
        {
          data: null,
          className:'text-center',
          orderable: false,
          render: (_,__,row) => {
            const base = "{{ url('admin/ManajemenProdi') }}";
            return `
              <button onclick="modalAction('${base}/${row.id}/show_ajax')"  class="btn btn-sm btn-info">Detail</button>
              <button onclick="modalAction('${base}/${row.id}/edit_ajax')"  class="btn btn-sm btn-warning">Edit</button>
              <button onclick="deleteProdi(${row.id})"                      class="btn btn-sm btn-danger">Delete</button>
            `; 
          }
        }
      ]
    });

    $('.filter_jenjang').on('change', () => dataProdi.draw());
    $('#program_studi_filter input')
      .off('keyup')
      .on('keyup', e => { if (e.keyCode===13) dataProdi.search(e.target.value).draw(); });
  });
</script>
@endpush
