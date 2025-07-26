<?php $this->load->view('frontend/layouts/header'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/star-rating.css">

<div class="container-fluid mt-4">
  <div class="row align-items-center">
    <div class="col-12 text-center" style="margin: auto;">
      <h2>Pemilihan PPJ</h2>
    </div>
  </div>
  <?php $this->load->view('frontend/mjppj/peserta_pemilih_ppj', array('anggota_sidi' => $anggota_sidi)); ?>
</div>

<!-- Feedback Modal -->
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

<hr>
<?php $this->load->view('frontend/layouts/footer'); ?>

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

<script type="text/javascript">
  $(document).on('click touchstart', '[id=btn_kunciPilihan]', function(e) {
    var r = confirm("Apakah anda yakin ingin Mengunci Pilihan Calon PPJ? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");
    if (r == false) {
      return;
    } else {
      $('#feedbackModal').modal('show');
    }

    $('#loading').show();

    dataMap = {}
    dataMap['id_pemilih'] = $('#id_pemilih').val()
    dataMap['wil_pemilih'] = $('#wil_pemilih').val()
    $.post('<?= base_url(); ?>pnppj/kunciPilihan_ppj', dataMap, function(data) {
      json = $.parseJSON(data)
      if (json.status == 1) {
        iziToast.success({
          title: '',
          message: json.msg,
          position: "topRight",
        });
        $('#exampleModal').modal('hide')
      } else {
        iziToast.error({
          title: '',
          message: json.msg,
          position: "topRight",
        });
      }
      $('#loading').hide();
    })
  })

  $(document).on('click touchstart', '[id^=calon_pn]', function(e) {
    $('#loading').show();
    ini = $(this);
    dataMap = {}
    dataMap['id_pemilih'] = $('#id_pemilih').val()
    dataMap['wil_pemilih'] = $('#wil_pemilih').val()
    dataMap['val_calon'] = $(this).val()
    num_voted = parseInt($('#num_voted').val());
    //console.log(num_voted+"alskla")
    hak_suara = parseInt($('#hak_suara').html());

    if ($(this).prop('checked') == true) {
      //alert("checking");
      dataMap['vote'] = 1 //1 voted
      if (num_voted >= 1) {
        //ini bearti sudah 1 voting
        alert("Peringatan: Anda tidak dapat memilih lebih dari " + hak_suara + " calon!");
        $('#loading').hide();
        return false;
      }
    } else {
      //alert("unchecking");
      dataMap['vote'] = 2 //2 unvote
    }

    $.post('<?= base_url(); ?>pnppj/vote_tahap_ppj', dataMap, function(data) {
      json = $.parseJSON(data)
      if (dataMap['vote'] == 2 && json.status == 3) {
        //bearti gagal delet jadi tidak jadi unvoted
        ini.prop('checked', true);
      } else if (dataMap['vote'] == 1 && json.status == 0) {
        //bearti gagal voting jadi tidak jadi voted
        ini.prop('checked', false);
      } else if (dataMap['vote'] == 2 && json.status == 2) {
        //bearti berhasil delet
        num_voted = num_voted - 1;
        $('#lbl_num_pilihan').html(num_voted)
        $('#num_voted').val(num_voted)
        console.log(num_voted + "akl")
      } else if (dataMap['vote'] == 1 && json.status == 1) {
        //bearti berhasil voting 
        num_voted = num_voted + 1;
        $('#lbl_num_pilihan').html(num_voted)
        $('#num_voted').val(num_voted)
        console.log(num_voted + "mm")
      }
      $('#loading').hide();
    })
  })
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>