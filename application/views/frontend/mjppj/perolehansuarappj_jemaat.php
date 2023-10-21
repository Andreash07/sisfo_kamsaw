<?php 
$this->load->view('frontend/layouts/header');
?>
<?php 
	$NumAngjem=0;
	$total_voted=0;
	if(isset($num_angjem)){
		$NumAngjem=$num_angjem;
	}
?>
<style type="text/css">
	.cutline1{
		padding: unset;
		-webkit-box-orient: vertical;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: normal;
		-webkit-line-clamp: 1;
		display: -webkit-box !important;
	}
</style>
<div class="container-fluid mt-4" style="min-height: 600px;">
	<div class="row align-items-center" style="position: relative;">
	  <div class="col-12 text-center" style="margin: auto;">
	  	<a href="<?=base_url();?>pnppj/" class="btn btn-icon btn-warning float-left" title="Hasil Perolehan Suara Sementar" style="position: absolute; top: -15px; left:10px;"><span class="btn-inner--icon"><i class="fa fa-chevron-left  " style="top:unset;"></i></span></a>

	    <h2>Perolehan Suara <br> PPJ</h2>
	  </div>
	  <div class="col-12" style="margin: auto;">
	  	<span class="small"><b>Total Suara Masuk</b>: <span id="lbl_indeks"><i class="fa fa-circle-o-notch fa-spin"></i> <i>menghitung suara...</i></span></span>

	  	<a href="<?=base_url();?>pnppj/perolehansuarappj" class="btn btn-sm btn-icon btn-danger float-right" title="Hasil Perolehan Suara Sementar"><span class="btn-inner--icon"><i class="fa fa-refresh  fa-spin fa-fw" style="top:unset;"></i></span></a>
	  </div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center" colspan="2" >Nama Calon</th>
						<th class="text-center">Suara</th>
					</tr>
				</thead>
				<tbody>
					<?php 
		    		if(!isset($voted)){
		    			$voted=array();
		    		}

		    		if(isset($voted) && count($voted) > 0){
							foreach ($voted as $keyvoted => $valuevoted) {
							// code...
							$title="Ibu ";
				      if($valuevoted->sts_kawin==1){
				        $title="Sdri. ";
				      }

				      if(mb_strtolower($valuevoted->jns_kelamin)=='l'){
				        $title="Bp. ";
				        if($valuevoted->sts_kawin==1){
				          $title="Sdr. ";
				        }
				      }

			        $foto_thumb=base_url().'assets/images/default-user.png';
					    $foto=base_url().'assets/images/default-user.png';
					    if($valuevoted->foto != null){
					    	$foto_thumb=base_url().$valuevoted->foto_thumb;
					    	$foto=base_url().$valuevoted->foto;
					    }

							$percent=$valuevoted->voted/$NumAngjem*100;
							$total_voted=$total_voted+$valuevoted->voted;
					?>
							<tr>
								<td class="text-center" style=" vertical-align:middle;"><?=$keyvoted+1;?></td>
								<td class="text-center" style="width: 20% !important; font-size: 12px; white-space:unset;  vertical-align:middle; padding: unset;">
									<span class="avatar avatar-sm rounded-circle">
										<img src="<?=$foto_thumb;?>" data-caption="<?=$title?><?=$valuevoted->nama_lengkap;?>" alt="<?=$title?><?=$valuevoted->nama_lengkap;?>" class="img-circle img-responsive" style="object-fit: cover; cursor: pointer; margin-right: 0px; display: inline;" href="<?=$foto;?>" data-fancybox="images<?=$valuevoted->id;?>" data-caption="<?=$title.$valuevoted->nama_lengkap;?>">
                  </span>
								</td>
								<td style="width: 60% !important; font-size: 12px; white-space:unset;  vertical-align:top;">
									<?=$title.$valuevoted->nama_lengkap;?></td>
								<td class="text-center">&nbsp;<?=$valuevoted->voted;?><br>(<?= round($percent,2);?>%)</td>
							</tr>
					<?php
							}
						}

						$index_voted=$total_voted/$NumAngjem*100;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>









<hr>
<?php 
$this->load->view('frontend/layouts/footer');
?>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){
			$('#lbl_indeks').html('<?=$total_voted;?>/<?=$NumAngjem;?> (<b class="text-danger"><?= round($index_voted,2);?>% </b>)')
		}, 1000)
	})
</script>