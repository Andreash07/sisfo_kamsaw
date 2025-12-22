<?php

$this->load->view('frontend/layouts/header');


$open="2022-01-10 00:00:00";
$open2="2022-01-10 00:00:00";
$open3="2022-01-10 00:00:00";
//$open="2022-01-08 16:44:00";

$close="2022-01-26 23:59:59";
$close2="2022-01-26 23:59:59";
$close3="2022-01-26 23:59:59";
//$close="2022-01-26 22:41:30";
$label="Penatua & PPJ";
$timestamp=date('Y-m-d H:i:s');
$timestamp_open=date('Y-m-d H:i:s');
foreach ($setting as $key => $value) {
	// code...
	switch ($value->tipe_pemilihan) {
		case '1':
			// code...
			$open=$value->start_at;
			$close=$value->end_at;
			break;
		case '2':
			// code...
			$open2=$value->start_at;
			$close2=$value->end_at;
			break;
		case '3':
			// code...
			$open3=$value->start_at;
			$close3=$value->end_at;
			break;
	}
	#print_r( $value);
	if($value->locked == 0 && $value->tipe_pemilihan =='3'){
		#$timestamp_open=strtotime($open3);	
		#$timestamp=strtotime($close3);	
		#$label="PPJ";
	}
	if($value->locked == 0 && $value->tipe_pemilihan =='1'){
		$timestamp=strtotime($close);	
		$timestamp_open=strtotime($open);	
		$label="Penatua Tahap 1";
	}
	if($value->locked == 0 && $value->tipe_pemilihan =='2'){
		$timestamp_open=strtotime($open2);	
		$timestamp=strtotime($close2);	
		$label="Penatua Tahap 2";
	}
}

?>

<div class="container-fluid mt-4" style="min-height: 600px;">

	<div class="row">

		<!--<div class="card " style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/img-1-1000x600.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Daftar Penatua dan PPJ 2018-2022</h3>

				<p class="card-text"></p>

				<a href="#" class="btn btn-primary float-right">Lihat <i class="ni ni-badge"></i></a>

			</div>

		</div>-->

		<div class="col-12" style="z-index: 1;">

			<div class="card card-stats">

	            <!-- Card body -->

	            <div class="card-body" style="padding:unset; position:relative;">
	                <img src="<?=base_url();?>/assets/images/poster-mobile-pnt2-01_26-30.jpg" class="img-fluid" instyle="border-top-left-radius: .375rem;border-top-right-radius: .375rem;">

	               <?php 

	                  if($timestamp_open<strtotime(date('Y-m-d H:i:s')) && $timestamp>strtotime(date('Y-m-d H:i:s')) ){
	                  	$sts_open=1;
	                  	$countDown=date('Y-m-d H:i:s', $timestamp);
	                ?>

	                    <!--<div class="btn btn-success btn-sm" href="#!" style="width: 100%; border-top-left-radius: 0;border-top-right-radius: 0;" onclick="event.preventDefault(); Pemiluopen('<b>Proses Pemilihan Penatua Tahap 2 Telah Dibuka.<br>Silahkan Masuk pada layanan Pemilihan Penatua 2022-2026</b><br><span class=\'text-success\'>Akan dibuka sampai<br>26 January 2022</span>', 'timer')">-->

                    	<div class="btn btn-success btn-sm" href="#!" style="width: 100%; border-top-left-radius: 0;border-top-right-radius: 0;" onclick="event.preventDefault(); Pemiluopen('<b>Proses Pemilihan <?=$label;?> Telah Dibuka.<br>Silahkan Masuk pada layanan Pemilihan <?=$label;?> <?=$tahun_pemilihan->periode;?></b>', 'timer')">

	                    	<span style="font-size: 0.65rem; font-style: italic;">

		                    	Buka sampai:

		                    </span>

	                    	<span id="timer">

	                      		<i class="fa fa-circle-o-notch fa-spin" style="color: #fff;" aria-hidden="true" ></i>

	                    	</span>

	                    </div>

	                <?php

	                  }else if($timestamp_open>strtotime(date('Y-m-d H:i:s')) &&  $timestamp > strtotime(date('Y-m-d H:i:s')) ){
	                  	$sts_open=0;
	                  	$countDown=date('Y-m-d H:i:s', $timestamp_open);
	                ?>

	                    <div class="btn btn-danger btn-sm" href="#!" style="width: 100%; border-bottom-left-radius: 0;border-bottom-right-radius: 0;" onclick="event.preventDefault(); Pemiluclose('<b>Maaf Pemilihan <?=$label;?> masih ditutup.</b><br><span class=\'text-warning\'>Akan dibuka pada <?=date('d M Y H:i:s', $timestamp_open) ;?></span>')">

	                    	<span style="font-size: 0.65rem; font-style: italic;">

	                          Akan Dibuka Dalam:

	                      	</span>

	                    	<span id="timer">

	                      		<i class="fa fa-circle-o-notch fa-spin" style="color: #fff;" aria-hidden="true" ></i>

	                    	</span>

	                    </div>

	                <?php

	                  }
	                  else{
	                  	$sts_open=0;
	                  	#echo $timestamp_open;
	                ?>

	                    <div class="btn btn-danger btn-sm" href="#!" style="width: 100%; border-bottom-left-radius: 0;border-bottom-right-radius: 0;" onclick="event.preventDefault(); Pemiluclose('<b>Maaf Pemilihan <?=$label;?> sudah ditutup.</b>')">

	                    	<span style="font-size: 0.65rem; font-style: italic;">

	                          Sudah Ditutup

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

		<?php 

		if(isset($setting['3']) && ($setting['3']->show == 1)){

				//ini berati sedang di buka pemilihannya

		?>

		<div class="card mt-4" style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/51842-Pemilu-ppj.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Pemilihan PPJ <?=$tahun_pemilihan->periode;?></h3>



				<p class="card-text text-danger small">

					<?php 

					#if($setting['3']->locked==0){
					if(strtotime($open3) <= strtotime(date('Y-m-d H:i:s')) && strtotime($close3) >= strtotime(date('Y-m-d H:i:s'))  ){

					?>

						<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung.</label>

					<?php
					}
					else if(strtotime($open3) <= strtotime(date('Y-m-d H:i:s')) && strtotime($close3) <= strtotime(date('Y-m-d H:i:s'))  ){
					?>
						<label class="text-danger" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sudah ditutup.</label>
						<br>
						<label class="text-warning">Hasil pemilihan akan keluar setelah proses verifikasi selesai dilakukan.</label>
					<?php
					}

					?>

					<?php 

					if(isset($offline[3]) ){

					?>

						*Keluarga Anda terdaftar sebagai Peserta Pemilihan Konvensional!

					<?php

					}

					?>

				<?php 
				if($setting['3']->approve==1 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
						*Hasil Perolehan Suara sudah dapat dilihat.

				<?php 
				}
				?>

				</p>

				<?php 

				if($setting['3']->approve==1 ){

					//ini beari sudah di approve dan hasil akan di keluarkan

				?>

					<a href="<?=base_url();?>pnppj/perolehansuarappj" class="btn btn-success float-left" title="Hasil Perolehan Suara Sementar">Hasil <i class="ni ni-bullet-list-67"></i></a>

				<?php

				}

				?>



				<?php 

				#if($setting['3']->locked==0 && !isset($offline[3])){
				if(strtotime($open3) <= strtotime(date('Y-m-d H:i:s')) && strtotime($close3) >= strtotime(date('Y-m-d H:i:s'))  ){

					//ini beari masih di buka untuk pemungutan suara

				?>

				<a href="<?=base_url();?>pnppj/pemilihan_ppj" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>

				<?php 

				}
				else if(strtotime($open3) <= strtotime(date('Y-m-d H:i:s')) && strtotime($close3) <= strtotime(date('Y-m-d H:i:s'))  ){
				?>
					
				<?php 
				}
				else{

				?>
				<label class="text-sm text-danger" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara belum dimulai.</label>
				<label class="text-sm ">Dimulai pada <b><?=date('d M Y H:i:s', $timestamp_open) ;?></b></label>
				<br>
				<?php

				}

				?>

			</div>

		</div>

		<?php

		}

		?>



		

		<?php 

		if(isset($setting['1']) && $setting['1']->show == 1 ){

				//ini berati sedang di buka pemilihannya

		?>

		<div class="card mt-4" style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/51842-Pemilu.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Pemilihan Penatua <?=$tahun_pemilihan->periode;?><br>Tahap I</h3>
				<p class="card-text text-danger" style="display:none;">
					*Proses dan Hasil Pemilihan masih proses Uji Coba kepada Anggota Jemaat
				</p>

				<p class="card-text text-danger small" style="indisplay:none;">

					<?php 

					if(strtotime($open) <= strtotime(date('Y-m-d H:i:s')) &&  strtotime($close) >= strtotime(date('Y-m-d H:i:s'))){

					?>

						<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung.</label>


					<?php
						/*<label class="text-danger" style="border-bottom: 1px solid #ededed;"><b>Dalam Proses sosialisai</b>.<br>Proses Pemungutan Suara <b>belum dibuka</b></label>*/

					}
					else if(strtotime($open) < strtotime(date('Y-m-d H:i:s')) && strtotime($close) < strtotime(date('Y-m-d H:i:s'))  ){
					?>
						<label class="text-danger" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sudah ditutup.</label>
						<br>
						<label class="text-warning">Hasil pemilihan akan keluar setelah proses verifikasi selesai dilakukan.</label>
					<?php
					}
					else if(strtotime($open) <= strtotime(date('Y-m-d H:i:s')) && strtotime($close) <= strtotime(date('Y-m-d H:i:s'))  ){
					?>
						
					<?php 
					}
					else{

					?>
					<label class="text-sm text-danger" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara belum dimulai.</label>
					<label class="text-sm ">Dimulai pada <b><?=date('d M Y H:i:s', $timestamp_open) ;?></b></label>
					<br>
					<?php

					}

					?>

					<?php 

					if(isset($offline[1])){

					?>

						*Keluarga Anda terdaftar sebagai Peserta Pemilihan Konvensional!

					<?php

					}

					?>
				<?php 
				if($setting['1']->approve==1 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
						*Hasil Perolehan Suara sudah dapat dilihat.

				<?php 
				}
				?>

				</p>

				<?php 

				if($setting['1']->approve==1 ){

					//ini beari masih di buka untuk pemungutan suara

				?>

					<a href="<?=base_url();?>pnppj/perolehansuarapemilu1" class="btn btn-success float-left" title="Hasil Perolehan Suara Sementar">Hasil <i class="ni ni-bullet-list-67"></i></a>

				<?php

				}

				?>

				<?php 

				if($setting['1']->locked==0 && !isset($offline[1]) ){

					//ini beari masih di buka untuk pemungutan suara

				?>

					<a href="<?=base_url();?>pnppj/pemilihan" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>

				<?php 

				}else{

				?>


				<?php

				}

				?>

			</div>

		</div>

		<?php

		}

		?>

		<?php 

		if(isset($setting['2']) && ($setting['2']->show == 1)){

				//ini berati sedang di buka pemilihannya

		?>

		<div class="card mt-4" style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/51842-Pemilu2.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Pemilihan Penatua <?=$tahun_pemilihan->periode;?> <br>Tahap II</h3>

				<p class="card-text text-danger small">

					<?php 

					if( (strtotime($open2)>strtotime(date('Y-m-d H:i:s'))) && strtotime($close2)>strtotime(date('Y-m-d H:i:s')) ){

					//	<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung (30 Ags - 9 Sep '21) .</label>

					//<label class="text-danger" style="border-bottom: 1px solid #ededed;"><b>Dalam Proses sosialisai</b>.<br>Proses Pemungutan Suara <b>belum dibuka</b></label>
					?>
						<label class="text-danger" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara belum dimulai akan dimulai pada <?=date('d M y', strtotime($open2));?> - <?=date('d M y', strtotime($close2));?>.</label>
					<?php

					}
					else if( ( strtotime($open2)<strtotime(date('Y-m-d H:i:s'))) && strtotime($close2)>strtotime(date('Y-m-d H:i:s')) ){
					?>
						<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung (<?=date('d M y', strtotime($open2));?> - <?=date('d M y', strtotime($close2));?>) .</label>
					<?php
					}
					else if(strtotime($open2) < strtotime(date('Y-m-d H:i:s')) && strtotime($close2) < strtotime(date('Y-m-d H:i:s'))  ){
					?>
						<label class="text-danger" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sudah ditutup.</label>
						<br>
						<label class="text-warning">Hasil pemilihan akan keluar setelah proses verifikasi selesai dilakukan.</label>
					<?php
					}
					else if(strtotime($open2) <= strtotime(date('Y-m-d H:i:s')) && strtotime($close2) <= strtotime(date('Y-m-d H:i:s'))  ){
					?>
						
					<?php 
					}

					?>

					<?php 

					if(isset($offline[2])){

					?>

						*Keluarga Anda terdaftar sebagai Peserta Pemilihan Konvensional!

					<?php

					}

					?>

				</p>

				<?php 

				if($setting['2']->approve==1 ){

				?>

					<a href="<?=base_url();?>pnppj/perolehansuarapemilu2" class="btn btn-success float-left" title="Hasil Perolehan Suara Sementar">Hasil <i class="ni ni-bullet-list-67"></i></a>

				<?php

				}

				?>



				<?php 

				if((($setting['2']->locked==0 && !isset($offline[2]) ) ) ){

					//ini beari masih di buka untuk pemungutan suara

				?>

				<a href="<?=base_url();?>pnppj/pemilihan2" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>

				<?php 

				}else{

				?>

				<br>

				<br>

				<br>

				<?php

				}

				?>

			</div>

		</div>

		<?php

		}

		?>

	</div>

</div>



















<hr>



<?php 

$this->load->view('frontend/layouts/footer');

?>

<?php 

  if(strtotime($close)> strtotime(date('Y-m-d H:i:s')) ){

?>

    <script type="text/javascript">

      	$(document).ready(function(){

			scriptCountDown('<?=$countDown;?>', 'timer', '', '<?=$sts_open;?>');

		})

    </script>

<?php

  }else{

?>

	<script type="text/javascript">

      	$(document).ready(function(){

			scriptCountDown('<?=$countDown;?>', 'timer', 'close', '<?=$sts_open;?>');

		})

    </script>

<?php

  }

?>

