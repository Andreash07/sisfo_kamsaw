<?php 

$this->load->view('frontend/layouts/header');



$open="2021-08-30 00:00:00";

$close="2021-09-09 23:59:59";

if(strtotime($open)> strtotime(date('Y-m-d H:i:s'))){

	$timestamp = strtotime($open);

}else{

	$timestamp = strtotime($close);

}

$countDown=date('Y-m-d H:i:s', $timestamp);



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

	                <img src="<?=base_url();?>/assets/images/poster-mobile-ppj-01_compressed.jpg" class="img-fluid" style="border-top-left-radius: .375rem;border-top-right-radius: .375rem;">

	                <?php 

	                  if(strtotime($open)<strtotime(date('Y-m-d H:i:s'))){

	                ?>

	                    <div class="btn btn-success btn-sm" href="#!" style="width: 100%; border-top-left-radius: 0;border-top-right-radius: 0;" onclick="event.preventDefault(); Pemiluopen('<b>Proses Pemilihan PPJ Telah Dibuka.<br>Silahkan Masuk pada layanan Pemilihan PPJ 2022-2026</b><br><span class=\'text-success\'>Akan dibuka sampai<br>9 September 2021</span>', 'timer')">

	                    	<span style="font-size: 0.65rem; font-style: italic;">

		                    	Buka sampai:

		                    </span>

	                    	<span id="timer">

	                      		<i class="fa fa-circle-o-notch fa-spin" style="color: #fff;" aria-hidden="true" ></i>

	                    	</span>

	                    </div>

	                <?php

	                  }else{

	                ?>

	                    <div class="btn btn-danger btn-sm" href="#!" style="width: 100%; border-top-left-radius: 0;border-top-right-radius: 0;" onclick="event.preventDefault(); Pemiluclose('<b>Maaf Pemilihan PPJ masih ditutup.</b><br><span class=\'text-warning\'>Akan dibuka pada 30 Agustus 2021</span>')">

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



		<?php 

		if(isset($setting['3']) && ($setting['3']->show == 1)){

				//ini berati sedang di buka pemilihannya

		?>

		<div class="card mt-4" style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/51842-Pemilu-ppj.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Pemilihan PPJ 2022-2026</h3>



				<p class="card-text text-danger small">

					<?php 

					if($setting['3']->locked==0){

					?>

						<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung (30 Ags - 9 Sep '21) .</label>

					<?php

					}

					?>

					<?php 

					if(count($offline) > 0){

					?>

						*Keluarga Anda terdaftar sebagai Peserta Pemilihan Konvensional!

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

				if($setting['3']->locked==0 && count($offline) == 0){

					//ini beari masih di buka untuk pemungutan suara

				?>

				<a href="<?=base_url();?>pnppj/pemilihan_ppj" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>

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



		

		<?php 

		if(isset($setting['1']) && $setting['1']->show == 1 ){

				//ini berati sedang di buka pemilihannya

		?>

		<div class="card mt-4" style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/51842-Pemilu.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Pemilihan Penatua 2022-2026<br>Tahap I</h3>

				<p class="card-text text-danger small">

					<?php 

					if($setting['1']->locked==0){

					?>

						<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung.</label>

					<?php

					}

					?>

					<?php 

					if(count($offline) > 0){

					?>

						*Keluarga Anda terdaftar sebagai Peserta Pemilihan Konvensional!

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

				if($setting['1']->locked==0 && count($offline) == 0){

					//ini beari masih di buka untuk pemungutan suara

				?>

					<a href="<?=base_url();?>pnppj/pemilihan" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>

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



		<?php 

		if(isset($setting['2']) && ($setting['2']->show == 1)){

				//ini berati sedang di buka pemilihannya

		?>

		<div class="card mt-4" style="width: 18rem; margin: auto;">

			<img class="card-img-top" src="<?=base_url();?>assets/images/51842-Pemilu2.jpg" alt="Card image cap">

			<div class="card-body" style="padding: 0.75rem">

				<h3 class="card-title">Pemilihan Penatua 2022-2026<br>Tahap II</h3>

				<p class="card-text text-danger small">

					<?php 

					if($setting['2']->locked==0){

					?>

						<label class="text-success" style="border-bottom: 1px solid #ededed;">Proses Pemungutan Suara sedang berlangsung (30 Ags - 9 Sep '21) .</label>

					<?php

					}

					?>

					<?php 

					if(count($offline) > 0){

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

				if($setting['2']->locked==0 && count($offline) == 0){

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

			scriptCountDown('<?=$countDown;?>', 'timer');

		})

    </script>

<?php

  }else{

?>

	<script type="text/javascript">

      	$(document).ready(function(){

			scriptCountDown('<?=$countDown;?>', 'timer', 'close');

		})

    </script>

<?php

  }

?>

