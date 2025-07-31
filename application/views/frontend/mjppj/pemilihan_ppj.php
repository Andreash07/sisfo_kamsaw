<?php $this->load->view('frontend/layouts/header'); ?>
<?php $this->load->view('frontend/mjppj/feedback_form'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid mt-4">
  <div class="row align-items-center">
    <div class="col-12 text-center" style="margin: auto;">
      <h2>Pemilihan PPJ</h2>
    </div>
  </div>
  <?php $this->load->view('frontend/mjppj/peserta_pemilih_ppj', array('anggota_sidi' => $anggota_sidi, 'pemilih_voting' => $pemilih_voting, 'ulasan'=> $ulasan )); ?>
</div>

<hr>

<?php $this->load->view('frontend/layouts/footer'); ?>

<script type="text/javascript">
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