<?php 
$this->load->view('frontend/layouts/header');
?>
<div class="container-fluid mt-4" style="min-height: 600px;">
	<div class="row">
		<div class="card " style="width: 18rem; margin: auto;">
			<img class="card-img-top" src="<?=base_url();?>assets/images/img-1-1000x600.jpg" alt="Card image cap">
			<div class="card-body" style="padding: 0.75rem">
				<h3 class="card-title">Daftar Penatua dan PPJ 2018-2022</h3>
				<p class="card-text"></p>
				<a href="#" class="btn btn-primary float-right">Lihat <i class="ni ni-badge"></i></a>
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

				<p class="card-text text-danger">
					*Proses dan Hasil Pemilihan masih proses Uji Coba kepada Anggota Jemaat
				</p>
				<?php 
				//if($setting['1']->locked==0 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
					<a href="<?=base_url();?>pnppj/perolehansuarappj" class="btn btn-success float-left" title="Hasil Perolehan Suara Sementar">Hasil <i class="ni ni-bullet-list-67"></i></a>
				<?php
				//}
				?>

				<?php 
				if($setting['3']->locked==0 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
				<a href="<?=base_url();?>pnppj/pemilihan_ppj" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>
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
				<p class="card-text text-danger">
					*Proses dan Hasil Pemilihan masih proses Uji Coba kepada Anggota Jemaat
				</p>
				<?php 
				if($setting['1']->locked==0 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
					<a href="<?=base_url();?>pnppj/pemilihan" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>
				<?php
				}
				?>
				<?php 
				//if($setting['1']->locked==0 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
					<a href="<?=base_url();?>pnppj/perolehansuarapemilu1" class="btn btn-success float-left" title="Hasil Perolehan Suara Sementar">Hasil <i class="ni ni-bullet-list-67"></i></a>
				<?php
				//}
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
				<p class="card-text text-danger">
					*Proses dan Hasil Pemilihan masih proses Uji Coba kepada Anggota Jemaat
				</p>
				<?php 
				//if($setting['1']->locked==0 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
					<a href="<?=base_url();?>pnppj/perolehansuarapemilu2" class="btn btn-success float-left" title="Hasil Perolehan Suara Sementar">Hasil <i class="ni ni-bullet-list-67"></i></a>
				<?php
				//}
				?>

				<?php 
				if($setting['2']->locked==0 ){
					//ini beari masih di buka untuk pemungutan suara
				?>
				<a href="<?=base_url();?>pnppj/pemilihan2" class="btn btn-primary float-right">Masuk <i class="ni ni-bullet-list-67"></i></a>
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