<?php
$tgl31;
$tgl30;
$tgl29;
$months=array('Bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
?>
<!DOCTYPE html>

<html>



<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="Sistem Informasi Jemaat - GKP Kampung Sawah. Sistem ini berfungsi membantu dalam perawatan, manajemen dan pembaruan data anggota jemaat GKP Kampung Sawah.">

  <meta name="author" content="#Ash07 - Creative Media">

  <title>Sistem Informasi Jemaat - GKP Kampung Sawah</title>

  <!-- Favicon -->

  <link rel="icon" href="<?=base_url();?>assets/images/logo-gkp_compressed.png" type="image/png">

  <!-- Fonts -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

  <!-- Icons -->

  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/nucleo/css/nucleo.css" type="text/css">

  <!--<link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">-->

  <link rel="stylesheet" href="<?=base_url();?>assets/font-awesome-4.7.0/css/font-awesome.min.css">

  <!-- Page plugins -->

  <!-- Argon CSS -->

  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/css/argon.css?v=<?=microtime();?>" type="text/css">



  <!-- iziToast CSS -->

  <link href="<?= base_url('assets/iziToast-master/dist/css/iziToast.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('vendors/select2/dist/css/select2.min.css'); ?>" rel="stylesheet">



  <!--<link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/css/examples.css" />-->

  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/css/jquery.sweet-modal.min.css" />
  <style type="text/css">
    .select2-selection--single{
      height: 90% !important;
    }
  </style>

</head>

<body style="min-height: unset !important;">

  <!-- Main content -->

  <!-- close DIV ini ada di footer.php               Point A -->

<div class="main-content" id="panel">
<!-- Header -->

<div class="header bg-primary pb-6" style="min-height: 100vh;">

  <div class="container-fluid">

    <div class="header-body">

      <!--<div class="row align-items-center py-4">

        <div class="col-lg-6 col-7">

          <h6 class="h2 text-white d-inline-block mb-0">Default</h6>

          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">

              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>

              <li class="breadcrumb-item"><a href="#">Dashboards</a></li>

              <li class="breadcrumb-item active" aria-current="page">Default</li>

            </ol>

          </nav>

        </div>

        <div class="col-lg-6 col-5 text-right">

          <a href="#" class="btn btn-sm btn-neutral">New</a>

          <a href="#" class="btn btn-sm btn-neutral">Filters</a>

        </div>

      </div>-->

      <!-- Card stats -->

      <div class="row" style="padding-top:10px;">
        <div class="col-xl-4 col-md-4 col-sm-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <h3 class="card-title text-uppercase text-muted mb-0">Cek KPKP Keluargamu</h3>
                </div>
              </div>
              <!--<div class="row">
                <div class="col-sm-12">
                  <h5 class="card-title text-uppercase text-muted mb-0">NIK Anggota Jemaat</h5>
                </div>
              </div>
              <form method="post" id="form1" >
                <div class="row">
                  <div class="col-sm-12">
                    <input type="text" name="nik" id="nik" value="" class="form-control" placeholder="Masukan No Induk Anggota Jemaat">
                  </div>
                  <div class="col-sm-12" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary btn-sm pull-right" id="cek1" onclick="event.preventDefault();">CEK</button>
                  </div>
                </div>
              </form>-->
              <div class="row">
                <!--<div class="col-sm-12">
                  <h6 class="card-title text-danger mb-0">atau dengan</h6>
                </div>-->
                <div class="col-sm-12">
                  <h5 class="card-title text-uppercase text-muted mb-0">NAMA LENGKAP & TGL Lahir</h5>
                </div>
              </div>
              <form method="post" id="form2" >
                <div class="row">
                  <div class="col-sm-12">
                    <input type="text" name="namalengkap" id="namalengkap" value="" class="form-control" placeholder="Masukan Nama Lengkap Anggota Jemaat">
                  </div>
                  <div class="col-sm-12" style="display:flex;">
                    <!--<input type="date" name="tgl_lahir" id="tgl_lahir" value="" class="form-control" placeholder="Tanggal Lahir">-->
                    <select id="tgl_lahir" name="tgl_lahir[2]" class="form-control col-4">
                      <option>Tanggal</option>
                      <?php
                      $i=1;
                      while ($i <= 31) {
                        // code...
                      ?>
                      <option value="<?=$i;?>"><?=$i;?></option>

                      <?php
                        $i++;
                      }
                      ?>
                    </select>

                    <select id="bulan_lahir" name="tgl_lahir[1]" class="form-control col-4">
                      <?php
                      $i=0;
                      while ($i <= 12) {
                        // code...
                      ?>
                      <option value="<?=$i;?>"><?= $months[$i] ; ?></option>

                      <?php
                        $i++;
                      }
                      ?>
                    </select>

                    <select id="tahun_lahir" name="tgl_lahir[0]" class="form-control col-4" sty>
                      <option>Tahun</option>
                      <?php
                      $i=1900;
                      while ($i <= date('Y')) {
                        // code...
                      ?>
                      <option value="<?=$i;?>"><?= $i ; ?></option>

                      <?php
                        $i++;
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-12" style="margin-top:10px;">
                    <div class="btn btn-warning btn-sm pull-left" id="btn_opening" onclick="event.preventDefault();"> <i class="ni ni-collection"></i> Himbauan KPKP</div>
                    <button type="button" class="btn btn-success btn-sm pull-right" id="cek2" onclick="event.preventDefault();">CEK</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>


        <div class="col-xl-4 col-md-4 col-sm-6" style="display: none;" id="card_result">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <h5 class="card-title text-uppercase text-muted mb-0">Hasil Cek KPKP</h5>
                </div>
                <div class="col-sm-12" id="div_result" style="text-align:justify !important;">
                </div>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
</div>


      <div class="container-fluid">
      <!-- Footer -->

        <footer class="footer pt-0">

          <div class="row align-items-center justify-content-lg-between">

            <div class="col-lg-6">

              <div class="copyright text-center  text-lg-left  text-muted">

                <small>Ver. 0.99 Beta</small>

                <br>

                &copy; <?= date('Y');?> <a href="https://gkpkampungsawah.org/" class="font-weight-bold ml-1" target="_blank">GKP Kampung Sawah</a>

              </div>

            </div>

            <div class="col-lg-6">

              <ul class="nav nav-footer justify-content-center justify-content-lg-end">

                <li class="nav-item">

                  <a href="https://kedaikite.gkpkampungsawah.org/" class="nav-link" target="_blank"><i class="ni ni-bag-17"></i> Kedai Kite</a>

                </li>

              </ul>

            </div>

          </div>

        </footer>

      </div>

    </div>


    <!-- Argon Scripts -->

    <!-- Core -->

    <script src="<?=base_url();?>assets/frontend/vendor/jquery/dist/jquery.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/select2/dist/js/select2.min.js"></script>
    <script src="<?=base_url();?>assets/frontend/vendor/js-cookie/js.cookie.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>

    <!-- Optional JS -->

    <script src="<?=base_url();?>assets/frontend/vendor/chart.js/dist/Chart.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/chart.js/dist/Chart.extension.js"></script>

    <!-- Argon JS -->

    <!--<script src="<?=base_url();?>assets/frontend/js/argon.js?v=1.2.0"></script>-->



    <!-- fancybox.js-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>



  <script src="<?=base_url();?>assets/frontend/vendor/sweetmodal/js/jquery.sweet-modal.min.js"></script>

    



    <script type="text/javascript">
      $(document).ready(function(){
         //alert('<?=$this->session->tempdata('opening');?>')
        if('<?=$this->session->tempdata('opening');?>' !='1'){
          $('#openingModal').modal('show')
        }
        $('#tgl_lahir').select2();
        $('#bulan_lahir').select2();
        $('#tahun_lahir').select2();
      })

      $(document).on('click touchstart', '[id=cek1]', function(e){
        $('#div_result').html('');
        $('#card_result').show();
        $('#div_result').append('Sistem sedang memeriksa data, Mohon Tunggu!');
        dataMap={}
        dataMap=$('[id=form1]').serialize()
        $.post('<?=base_url();?>kpkp/cek', dataMap, function(data){
          setTimeout(function(){
            $('#div_result').html(data);
            $('#sanksiModal').modal('show')
          },500)
        })

      })

      var flag = false;
      /*$(document).bind('touchstart click', '[id=cek2]', function(e){
        if (!flag) {
          flag = true;
          setTimeout(function(){ flag = false; }, 100);
          // do something
          $('#div_result').html('');
          $('#card_result').show();
          $('#div_result').append('Sistem sedang memeriksa data, Mohon Tunggu!');
          dataMap={}
          dataMap=$('[id=form2]').serialize()
          $.post('<?=base_url();?>kpkp/cek', dataMap, function(data){
            setTimeout(function(){
              $('#div_result').html(data);
              $('#sanksiModal').modal('show')
            },500)
          })
        }

        return false  
      });*/

      $(document).on('touchstart click', '[id=btn_close_modal]', function(e){
        $('.modal').modal('hide')
      })

      $(document).on('touchstart click', '[id=btn_opening]', function(e){
        if (!flag) {
          flag = true;
          setTimeout(function(){ flag = false; }, 100);
          $('#openingModal').modal('show')
        }
        return false  
      })

      $(document).on('touchstart click', '[id=cek2]', function(e){
        if (!flag) {
          flag = true;
          setTimeout(function(){ flag = false; }, 100);
          // do something
          $('#div_result').html('');
          $('#card_result').show();
          $('#div_result').append('Sistem sedang memeriksa data, Mohon Tunggu!');
          dataMap={}
          dataMap=$('[id=form2]').serialize()
          $.post('<?=base_url();?>kpkp/cek', dataMap, function(data){
            setTimeout(function(){
              $('#div_result').html(data);
              $('#sanksiModal').modal('show')
            },500)
          })
        }

        return false  

      })

      $(document).on('touchstart click', '[id=btn_agree]', function(e){
        if (!flag) {
          flag = true;
          setTimeout(function(){ flag = false; }, 100);
          // do something
          dataMap={}
          dataMap['opening']='1'
          $.post('<?=base_url();?>kpkp/agree_opening', dataMap, function(data){
          })
        }

        return false  

      })

      $(document).on('touchstart click', '[id=btn_sanksiModal]', function(e){
        if (!flag) {
          flag = true;
          setTimeout(function(){ flag = false; }, 100);
          // do something
          $('#sanksiModal').modal('show')
        }

        return false  

      })


      $(document).on('click', '[id=btn_ajax_modal]', function(e){

        e.preventDefault();

        dataMap={}

        href=$(this).attr('href');

        $.post(href, dataMap, function(data){

          $('#div_modal_content').html(data)

        })

      })



      $(document).ready(function(){

        $('#loading').hide();

      })



      $(document).on('click', '[id=kirimPesan]', function(e){

        dataMap={};

        dataMap=$('#form_pesan').serialize();

        $.post('<?=base_url();?>/ajax/kirimPesan', dataMap, function(data){

          $('#kotakPesanModal').modal('hide')

          $('#txt_pengguna').val('')

          $('#pesan').val('')

        })

      })



      

    </script>

    

    <!-- izy Toastt-->

    <script src="<?= base_url('assets/iziToast-master/dist/js/iziToast.js'); ?>"></script>

    <div class="modal fade" id="openingModal" tabindex="9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="div_modal_content">
          <div class="modal-header" style="padding-bottom: unset;">
            <h5 class="modal-title">Himbauan KPKP</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Komisi Pelayanan Kedukaan dan Pemakaman (KPKP) <b style="font-weight: 800;">menghimbau dan mengingatkan</b> kembali kepada <b style="font-weight: 800;">seluruh Anggota Jemaat GKP Kampung Sawah yang Terdaftar dalam Pelayanan KPKP</b> (khususnya kepada Kepala Keluarga), bahwa untuk tertib dan kelancaran pelayanan pemakaman serta <b style="font-weight:800;" class="text-danger">menghindari sanksi administratif</b>, diharapkan peran aktif Anggota Jemaat (KPKP) dalam hal pembayaran iuran wajib.</p>
            <p>
              Bagi Anggota Jemaat (KPKP) yang <b style="font-weight:800;" class="text-danger">belum memenuhi kewajibannya selama 3 bulan berturut – turut diharapkan dapat memenuhi kewajibannya</b>. Dan kepada ahli waris yang keluarganya dimakamkan di pemakaman GKP Kampung Sawah dan belum memenuhi kewajibannya dalam pembayaran Iuran Perawatan Makam, dapat menghubungi Pengurus KPKP :
              <ol>
                <li>Ibu Natalia Saian (<a href="tel:081287565026">0812 8756 5026</a>) <br><a aria-label="Chat on WhatsApp" href="https://wa.me/6281287565026?text=Halo%2C+saya+ingin+bertanya+mengenai+KPKP." title="Chat on Whatsapp"><img style="width:30px;" src="<?=base_url();?>assets/images/wa-ico.png"></a> <a href="tel:081287565026"><img style="width:30px;" src="<?=base_url();?>assets/images/phone-ico.png"></a> <br></li>

                <li>Bp. Karnain Niman (<a href="tel:085899567015">0858 9956 7015</a>) <br><a aria-label="Chat on WhatsApp" href="https://wa.me/6285899567015?text=Halo%2C+saya+ingin+bertanya+mengenai+KPKP." title="Chat on Whatsapp"><img style="width:30px;" src="<?=base_url();?>assets/images/wa-ico.png"></a> <a href="tel:085899567015"><img style="width:30px;" src="<?=base_url();?>assets/images/phone-ico.png"></a> </li>
              </ol>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_agree">Saya Memahami!</button>
          </div>
        </div>
      </div>
    </div>

  </body>

</html>