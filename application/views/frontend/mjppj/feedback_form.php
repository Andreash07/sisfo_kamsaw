<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/star-rating.css">

<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true" indata-backdrop="static" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModalLabel">Form Ulasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="feedbackForm">
          <input type="hidden" name="auth_review" value="<?=md5($this->session->userdata('sess_keluarga')->id.'(71hkas37%');?>">
          <input type="hidden" name="user_idUlasan" id="user_idUlasan" value="">
          <input type="hidden" name="moduleUlasan" id="moduleUlasan" value="">
          <div class="form-group">
            <label for="feedbackText">Nama Keluarga</label>
            <input type="text" id="nama_pengguna_ulasan" name="nama_pengguna" class="form-control" readonly value="<?=$this->session->userdata('sess_keluarga')->kwg_nama;?>">
          </div>
          <div>
            <div class="rating-card">
              <div class="star-rating animated-stars">
                <input type="radio" id="star5" name="rating" value="5" checked  >
                <label for="star5" class="bi bi-star-fill"></label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4" class="bi bi-star-fill"></label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3" class="bi bi-star-fill"></label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2" class="bi bi-star-fill"></label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1" class="bi bi-star-fill"></label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="feedbackText">Tuliskan tanggapan/saran anda</label>
            <textarea class="form-control" id="feedbackText" name="feedbackText" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display:none;">Batal</button>
        <button type="button" class="btn btn-primary" onclick="event.preventDefault(); submitUlasan();">Kirim</button>
      </div>
    </div>
  </div>
</div>

<!-- star rating click effect -->
<script type="text/javascript">
  document.querySelectorAll('.star-rating:not(.readonly) label').forEach(star => {
    star.addEventListener('click', function() {
      this.style.transform = 'scale(1.2)';
      setTimeout(() => {
        this.style.transform = 'scale(1)';
      }, 200);
    });
  });
</script>