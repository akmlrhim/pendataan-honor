@props(['action' => '', 'label' => 'Hapus'])

<!-- Tombol Hapus: kirim action final lewat data-action -->
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal"
  data-action="{{ $action }}">
  {{ $label }}
</button>

@once
  <!-- Modal konfirmasi (render sekali saja di halaman) -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          Apakah anda yakin ingin menghapus data ini?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

          <!-- form yang akan di-set action-nya secara dinamis -->
          <form id="confirmDeleteForm" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Script: saat modal dibuka, ambil data-action dari tombol yang klik, set ke form -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget); // tombol yang memicu modal
        const action = button.data('action'); // sudah berisi URL final dari blade (misal /mitra/5)
        $('#confirmDeleteForm').attr('action', action);
      });
    });
  </script>
@endonce
