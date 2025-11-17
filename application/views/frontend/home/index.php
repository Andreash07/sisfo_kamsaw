<?php 

$this->load->view('frontend/layouts/header');

?>



<?php

if($this->session->userdata('status_action') == 1){

?>

	<div class="alert-status-action alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; right:0; top: 0; z-index: 1;">

	    <span class="alert-icon"><i class="ni ni-like-2"></i></span>

	    <span class="alert-text"><?=$this->session->userdata('msg');?>

	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

	        <span aria-hidden="true">&times;</span>

	    </button>

	</div>

<?php

}else if(in_array($this->session->userdata('status_action'), array(-1,-2))){

?>

	<div class="alert-status-action alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute; right:0; top: 0;  z-index: 1;">

	    <span class="alert-icon"><i class="ni ni-like-2"></i></span>

	    <span class="alert-text"><?=$this->session->userdata('msg');?>

	    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

	        <span aria-hidden="true">&times;</span>

	    </button>

	</div>

<?php

}



$this->session->unset_userdata('status_action');

$this->session->unset_userdata('msg');

$this->session->unset_userdata('module');

//$open="2021-08-30 00:00:00"; //ppj

$open="2022-01-10 00:00:00";//pnt

$close="2022-01-26 23:59:59";

$open="2025-07-01 00:00:00";//pnt

$close="2025-07-06 00:00:00";

foreach ($lockpemilihan as $key => $value) {
  // code...
  $open=$value->start_at;
  $close=$value->end_at;
}

$timestamp = strtotime($open);

$countDown=date('Y-m-d H:i:s', $timestamp);





?>



<!-- Header -->

<div class="header bg-primary pb-6">

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

      <div class="row">

        <div class="col-12">

          <div class="card card-stats">

            <!-- Card body -->

            <div class="card-body" style="padding:unset; position:relative;">
                <img src="<?=base_url();?>/assets/images/poster-mobile-pnt2-01_26-30.jpg" class="img-fluid" instyle="border-bottom-left-radius: .375rem;border-bottom-right-radius: .375rem;"> 
                <?php 

                  #if(strtotime($open)< strtotime(date('Y-m-d H:i:s')) ){
                  if(strtotime($open)< strtotime(date('Y-m-d H:i:s')) && strtotime($close)>= strtotime(date('Y-m-d H:i:s')) ) {
                    $sts_open=1;

                ?>

                    <a class="btn btn-info" href="<?=base_url();?>pnppj" style="width: 100%; border-top-left-radius: 0;border-top-right-radius: 0; font-size: 1.2rem;">Nyok Milih Di sini!</a>

                <?php
                    #(Uji Coba)
                  }
                  else if(strtotime($open)< strtotime(date('Y-m-d H:i:s')) && strtotime($close)< strtotime(date('Y-m-d H:i:s')) ){
                    $sts_open=0;
                  ?>
                    <a class="btn btn-warning" href="<?=base_url();?>pnppj" style="width: 100%; border-top-left-radius: 0;border-top-right-radius: 0; font-size: 1.2rem;">Sudah ditutup! Cek hasil.</a>
                  <?php
                  }
                  else{
                    $sts_open=0;

                  /*  <a id="btn_ajax_modal" data-toggle="modal" data-target="#exampleModal" href="<?=base_url();?>ajax/list_calon_penatua_review/?token=<?=md5('hasg2&^!#'.$this->session->userdata('sess_keluarga')->kwg_wil);?>&kwg_wil=<?=$this->session->userdata('sess_keluarga')->kwg_wil;?>" class="btn btn-warning btn-sm" onclick="event.preventDefault();" style="position:absolute; left:0; bottom:50px; box-shadow: 0px 0px 7px #666;">Nyok Lihat Calonnya</a>*/
                ?>

                    <div class="btn btn-danger btn-sm" href="#!" style="width: 100%; border-bottom-left-radius: 0;border-bottom-right-radius: 0;" onclick="event.preventDefault(); Pemiluclose('<b>Maaf Pemilihan Penatua Tahap II masih ditutup.</b><br><span class=\'text-warning\'>Akan dibuka pada <?=date('d M Y H:i:s', strtotime($open));?></span>', 'timer')">

                      <span style="font-size: 0.65rem; font-style: italic;">

                          Akan Dibuka Dalam:

                      </span>

                      <span id="timer">

                        <i class="fa fa-circle-o-notch fa-spin" style="color: #fff;" aria-hidden="true" ></i>

                      </span>

                    </div>

                <?php

                  }

                ?>
            </div>

          </div>

        </div>



        <div class="col-xl-4 col-md-4 col-sm-6">

          <div class="card card-stats">

            <!-- Card body -->

            <div class="card-body">

              <div class="row">

                <div class="col">

                  <h5 class="card-title text-uppercase text-muted mb-0">Anggota Keluarga</h5>

                  <span class="h2 font-weight-bold mb-0"><?=$this->session->userdata('sess_keluarga')->num_anggota;?></span>

                </div>

                <div class="col-auto">

                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">

                    <i class="ni ni-single-02"></i>

                  </div>

                </div>

              </div>

              <p class="mt-2 mb-0 text-sm">

              	<small class="text-success mr-2"><i class="fa fa-user"></i> </small><small class="h5 font-weight-bold mb-0"> Username: <?=$this->session->userdata('sess_username');?></small>

                <br>

                <small class="text-success mr-2"><i class="fa fa-lock"></i> </small><small class="h5 font-weight-bold mb-0"> Password: ******* <i class="text-danger h6" style="display:block;">*Username = Password </i></small>

                <span class="text-success mr-2"><i class="fa fa-hashtag"></i> </span><span class="h4 font-weight-bold mb-0"> <?=$this->session->userdata('sess_keluarga')->kwg_no;?></span>

                <!--<span class="text-success mr-2"><i class="ni ni-bullet-list-67"></i> </span>Lihat Anggota Keluarga.

                <a id="btn_ajax_modal" href="<?=base_url();?>keluarga/anggota_keluarga" class="btn btn-warning btn-sm text-nowrap" data-toggle="modal" data-target="#exampleModal" onclick="event.preventDefault();"><b>Klik</b>!</a>-->

                <!--<a id="btn_ajax_modal" href="<?=base_url();?>keluarga/akun_kk" class="btn btn-warning btn-sm text-nowrap" data-toggle="modal" data-target="#exampleModal" onclick="event.preventDefault();"><i class=""></i> <b>Lihat User Pengguna KK Anda</b>!</a>-->

              </p>

            </div>

          </div>

        </div>

        <div class="col-xl-4 col-md-4 col-sm-6">

          <div class="card card-stats">

            <!-- Card body -->

            <div class="card-body">

              <div class="row">

                <div class="col">

                  <h5 class="card-title text-uppercase text-muted mb-0">Status</h5>

                  <?php 

                  	$status="Tidak Aktif";

                  	if($this->session->userdata('sess_keluarga')->status==1){

                  		$status="Anggota Jemaat Aktif";

                  	}

                  ?>

                  <span class="h3 font-weight-bold mb-0"><?=$status;?></span>

                </div>

                <div class="col-auto">

                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">

                    <i class="ni ni-check-bold"></i>

                  </div>

                </div>

              </div>

              <p class="mt-3 mb-0 text-sm">

              	<a target="_BLANK" href="<?=base_url();?>pdf/kkwithbarcode.php?id=<?=$this->session->userdata('sess_keluarga')->id;?>" class="btn btn-warning btn-sm text-nowrap float-lef"><i class="ni ni-paper-diploma"></i><b>Cetak KK</b></a>

                <a id="btn_ajax_modal" href="<?=base_url();?>keluarga/view" class="btn btn-info btn-sm text-nowrap float-right" data-toggle="modal" data-target="#exampleModal" onclick="event.preventDefault();"><i class="ni ni-bullet-list-67"></i><b>Data KK</b>!</a>

              	<br>

              	<br>

                <span class="text-success mr-2"><i class="fa fa-clock"></i> <?=convert_time_HiMdY($this->session->userdata('sess_keluarga')->last_modified);?></span>

                <span class="text-nowrap">Terakhir Update</span>

              </p>

            </div>

          </div>

        </div>

        <div class="col-xl-4 col-md-4 col-sm-12">

          <div class="card card-stats">

            <!-- Card body -->

            <div class="card-body">

              <div class="row">

                <div class="col">

                  <h5 class="card-title text-uppercase text-muted mb-0">Wilayah</h5>

                  <span class="h2 font-weight-bold mb-0"><?=$this->session->userdata('sess_keluarga')->kwg_wil;?></span>

                </div>

                <div class="col-auto">

                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">

                    <i class="ni ni-square-pin"></i>

                  </div>

                </div>

              </div>

              <p class="mt-3 mb-0 text-sm">

                <span class="text-warning mr-2"><i class="fa fa-home"></i></span> <?=$this->session->userdata('sess_keluarga')->kwg_alamat;?>

                <?php 

                	if($this->session->userdata('sess_keluarga')->kwg_telepon != '' || $this->session->userdata('sess_keluarga')->kwg_telepon != null){

        		?>

                &nbsp;&nbsp;-&nbsp;<span class="text-success mr-2"><i class="fa fa-phone"></i></span> <a href="tel:<?=$this->session->userdata('sess_keluarga')->kwg_telepon;?>"><?=$this->session->userdata('sess_keluarga')->kwg_telepon;?></a></phone>

        		<?php

                	}

                ?>

                <span class="text-nowrap"></span>

              </p>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>



<div class="container-fluid mt--6" style="min-height: 400px;">

	<div class="row">

		<div class="col-md-12" style="z-index: 1;">

		  <h3 class="text-white" >Anggota keluarga</h3>

      <div class="row" style="position: relative; border-top: 1px solid #fff; z-index: 1"></div>

		</div>

	</div>

	<div id="div_content" class="mt-3">

		<i class="fa fa-circle-o-notch  fa-spin fa-3x"></i>

	</div>

</div>



<?php 

$this->load->view('frontend/layouts/footer');

?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.2/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/rg-1.1.3/sb-1.2.1/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>



<?php 

  if(strtotime($close)> strtotime(date('Y-m-d H:i:s')) ){

?>

    <script type="text/javascript">

      $(document).ready(function(){

        scriptCountDown('<?=$countDown;?>', 'timer', 'open', '<?=$sts_open;?>');

      })

    </script>

<?php

  }else{

?>

  <script type="text/javascript">

        $(document).ready(function(){

      scriptCountDown('<?=$countDown;?>', 'timer', 'close' , '<?=$sts_open;?>');

    })

    </script>

<?php

  }

?>



<script type="text/javascript">

	$(document).ready(function(){

    //scriptCountDown('<?=$countDown;?>');



		function get_anggotaKeluarga(){

			dataMap={}

			href='<?=base_url();?>keluarga/anggota_keluarga';

			$.post(href, dataMap, function(data){

				$('#div_content').html(data)

			})

		}



		get_anggotaKeluarga();



		/*$(document).on('click', '[id=btn_ajax_modal]', function(){

			dataMap={}

			href=$(this).attr('href');

			$.post(href, dataMap, function(data){

				$('#div_modal_content').html(data)

			})

		})*/



		setTimeout(function(){$('.alert-status-action').fadeOut(750)}, 5000)

	})

</script>