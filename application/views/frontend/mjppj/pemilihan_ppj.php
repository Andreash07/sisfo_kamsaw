<?php $this->load->view('frontend/layouts/header'); ?>
<?php $this->load->view('frontend/mjppj/feedback_form'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid mt-4">
  <div class="row align-items-center">
    <div class="col-12 text-center" style="margin: auto;">
      <h2>Pemilihan PPJ</h2>
    </div>
  </div>
  <?php $this->load->view('frontend/mjppj/peserta_pemilih_ppj', array('anggota_sidi' => $anggota_sidi, 'pemilih_voting' => $pemilih_voting, 'ulasan'=> $ulasan, 'lockpemilihan'=> $lockpemilihan )); ?>
</div>

<hr>

<?php $this->load->view('frontend/layouts/footer'); ?>

<div class="modal fade" id="pemberitahuanModal" tabindex="9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">



  <div class="modal-dialog modal-lg" role="document" style="margin-top: 15%;">

    <div class="modal-content" style="padding:10px;">

      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #333; float:right;">

        <span aria-hidden="true">×</span>

      </button>

      <div class="container-fluid">

        <h2 class="text-danger text-center blink_me">Informasi!</h2>
        <br>
        Dalam pemilihan <b>Pengawas Perbendaharaan Jemaat Periode 2026-2030</b>, mengacu pada <b>TG Bab XIV Pasal 35 dan PPTG Bab XIV Pasal 80 tentang Kelengkapan Pelayanan Jemaat</b>, maka penetapan Calon Pengawas Perbendaharaan Jemaat adalah berdasarkan <b>rekomendasi Majelis Jemaat</b> dengan memperhatikan kriteria yang dibutuhkan sesuai fungsi dan tugas Pengawas Perbendaharaan Jemaat.

        <br>

        <b>Tuhan memberkati kita semua!<br>😇🙏</b>

        </div>

        <hr style="margin-top:1rem; margin-bottom:1rem;">

        <h5 class="text-danger" style="margin-top:0px;margin-bottom:0px;">Ketentuan:</h5>

        <ol>

          <li>Silahkan Gunakan Hak Suara Anda dan <b>Pilih 1 Calon PPJ</b> yang tersedia!</li>

        </ol>

        <div class="modal-footer">
          <button class="btn btn-primary btn-sm pull-right" type="button" data-dismiss="modal" aria-label="Close">
            Ya, Saya Mengerti!
          </button>
        </div>
      </div>

    </div>



  </div>



</div>



<script type="text/javascript">

  $(document).ready(function(){

    $('#pemberitahuanModal').modal('show');

    setTimeout(function(){
    $('#pemberitahuanModal').modal('hide');

    }, 10000)

  })


  $(document).on('click touchstart', '[id=btn_kunciPilihan]', function(e) {
    var r = confirm("Apakah anda yakin ingin Mengunci Pilihan Calon PPJ? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");
    if (r == false) {
      return;
    } else {
      //show formnya pindah ke bawah aja setelah sudah kelar process kunci
    }

    $('#loading').show();

    setTimeout(function(){
      $('#exampleModal').modal('hide');
      $('#loading').hide();
    }, 20000)

    dataMap = {}
    dataMap['id_pemilih'] = $('#id_pemilih').val()
    dataMap['wil_pemilih'] = $('#wil_pemilih').val()
    dataMap['nama_pemilih_suratsuara'] = $('#nama_pemilih_suratsuara').val()
    $('#nama_pengguna_ulasan').val(dataMap['nama_pemilih_suratsuara'])
    $('#user_idUlasan').val(dataMap['id_pemilih'])
    $('#moduleUlasan').val('Pemilihan PPJ <?=$tahun_pemilihan;?>')

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
      if($('#ulasan_sts'+dataMap['id_pemilih']).val() != '1'){
        //ulasan muncul kalau belum kasih ulasan..
        $('#feedbackModal').modal('show');
      }
      else{
        setTimeout(function(){
          location.reload();
        }, 2000)
      }
    })
  })

  function submitUlasan(){
    $('#loading').show();

    formUlasan=$('#feedbackForm')
    dataMap=formUlasan.serialize();
    url="<?=base_url();?>/api/submitReview"
    setTimeout(function(){
      $('#feedbackModal').modal('hide');
      $('#loading').hide();
      location.reload();
    }, 20000)
    $.post(url, dataMap, function(data){
      json=$.parseJSON(data)
      if (json.sts == 1) {
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
      $('#feedbackModal').modal('hide');
      $('#loading').hide();
      location.reload();
    })
  }

  $(document).on('click touchstart', '[id^=calon_pn]', function(e) {
  //$(document).on('change', '[id^=calon_pn]', function(e) {
    $('#loading').show();
    id_ini = $(this).attr('id');
    ini = $(this);
    dataMap = {}
    dataMap['id_pemilih'] = $('#id_pemilih').val()
    dataMap['wil_pemilih'] = $('#wil_pemilih').val()
    dataMap['val_calon'] = $('#'+id_ini).val()
    num_voted = parseInt($('#num_voted').val());
    //console.log(num_voted+"alskla")
    hak_suara = parseInt($('#hak_suara').html());

    if ($('#'+id_ini).prop('checked') == true) {
      //alert("checking");
      dataMap['vote'] = 1 //1 voted
      if (num_voted >= 1) {
        //ini bearti sudah 1 voting
        alert("Peringatan: Anda tidak dapat memilih lebih dari " + hak_suara + " calon!");
        $('#loading').hide();
        e.preventDefault();

        $('#'+id_ini).prop('checked', false);
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
      } else if (dataMap['vote'] == 1 && json.status == 4) {
        //bearti gagal voting jadi tidak jadi voted, karena sudah di pakai di device lain diwaktu yg bersamaan
        ini.prop('checked', false);
        alert("Gagal, Silahkan Pilih ulang!")
        setTimeout(function(){
          window.location.reload();
        },2000)
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

  $(document).on('click', '[id=triger_calon_pn]', function(e) {
    e.preventDefault();
    div=$(this).attr('value');

    $('#'+div).click();


  })
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>