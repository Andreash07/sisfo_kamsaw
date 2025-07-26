<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/star-rating.css">

<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
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
          <div>
            <div class="rating-card">
              <div class="star-rating animated-stars">
                <input type="radio" id="star5" name="rating" value="5">
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
            <textarea class="form-control" id="feedbackText" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary">Kirim</button>
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