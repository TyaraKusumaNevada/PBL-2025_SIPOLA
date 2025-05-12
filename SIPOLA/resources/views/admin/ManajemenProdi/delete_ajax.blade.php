<script>
  function modalAction(url) {
    // cek apakah delete
    if (url.includes('/delete_ajax')) {
      Swal.fire({
        title: 'Hapus data?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            type: 'DELETE',
            data: {
              _token: "{{ csrf_token() }}"
            },
            success() {
              dataProdi.draw();
              Swal.fire('Berhasil', 'Data berhasil dihapus', 'success');
            },
            error() {
              Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus', 'error');
            }
          });
        }
      });
    } else {
      // Jika bukan delete_ajax, muat modal via fetch
      fetch(url)
        .then(res => res.text())
        .then(html => {
          document.getElementById('myModal').innerHTML = html;
          new bootstrap.Modal(document.getElementById('myModal')).show();
        });
    }
  }
</script>
