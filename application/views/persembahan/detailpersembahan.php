<?php 
$title="Ibu ";
if($data->sts_kawin==1){
	$title="Sdri. ";
}
if(mb_strtolower($data->jns_kelamin)=='l'){
	$color_gender="bg-gradient-blue";
	$ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';
	$title="Bp. ";
	if($data->sts_kawin==1){
	  $title="Sdr. ";
	}
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Persembahan Bulanan</h4>
</div>
	<div class="modal-body">
  	<div class="row">
		<div class="col-xs-12">
			<table class="table">
				<tbody>
					<tr>
						<th style="border:0;">Nomor Kartu</th>
						<th style="border:0;">:</th>
						<td style="border:0;"><?=$data->no_kartu;?></td>
						<th style="border:0;">Periode</th>
						<th style="border:0;">:</th>
						<td style="border:0;"><label class="label label-success"><?=$data->tahun;?></label></td>
					</tr>
					<tr>
						<th style="border:0;">Wil</th>
						<th style="border:0;">:</th>
						<td style="border:0;">Wil. <?=$data->kwg_wil;?></td>
						<th style="border:0;">Nama</th>
						<th style="border:0;">:</th>
						<td style="border:0;" colspan="4"><?=$title.singkat_nama($data->nama_lengkap, 15);?></td>
					</tr>
				</tbody>
			</table>
			<div class="divider"></div>
		</div>
		<div class="col-xs-12">
			<table class="table table-striped table-border">
				<thead>
					<tr>
						<th>Bulan</th>
						<th>Nominal</th>
						<th>Diterima</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($bulan_periode as $key => $value) {
						// code...
						$locked=0;
						$nominal="";
						$penerimaan="";
						$lbl="";
						switch ($value['id']) {
							case '1':
								// code...
								if($data->penerimaan_1 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_1."</small>";
								}
								$locked=$data->lock1;
								$nominal=$data->b1;
								$penerimaan=$data->penerimaan_1;
								break;
							case '2':
								// code...
								if($data->penerimaan_2 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_2."</small>";
								}
								$locked=$data->lock2;
								$nominal=$data->b2;
								$penerimaan=$data->penerimaan_2;
								break;
							case '3':
								// code...
								if($data->penerimaan_3 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_3."</small>";
								}
								$locked=$data->lock3;
								$nominal=$data->b3;
								$penerimaan=$data->penerimaan_3;
								break;
							case '4':
								// code...
								if($data->penerimaan_4 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_4."</small>";
								}
								$locked=$data->lock4;
								$nominal=$data->b4;
								$penerimaan=$data->penerimaan_4;
								break;
							case '5':
								// code...
								if($data->penerimaan_5 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_5."</small>";
								}
								$locked=$data->lock5;
								$nominal=$data->b5;
								$penerimaan=$data->penerimaan_5;
								break;
							case '6':
								// code...
								if($data->penerimaan_6 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_6."</small>";
								}
								$locked=$data->lock6;
								$nominal=$data->b6;
								$penerimaan=$data->penerimaan_6;
								break;
							case '7':
								// code...
								if($data->penerimaan_7 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_7."</small>";
								}
								$locked=$data->lock7;
								$nominal=$data->b7;
								$penerimaan=$data->penerimaan_7;
								break;
							case '8':
								// code...
								if($data->penerimaan_8 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_8."</small>";
								}
								$locked=$data->lock8;
								$nominal=$data->b8;
								$penerimaan=$data->penerimaan_8;
								break;
							case '9':
								// code...
								if($data->penerimaan_9 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_9."</small>";
								}
								$locked=$data->lock9;
								$nominal=$data->b9;
								$penerimaan=$data->penerimaan_9;
								break;
							case '10':
								// code...
								if($data->penerimaan_10 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_10."</small>";
								}
								$locked=$data->lock10;
								$nominal=$data->b10;
								$penerimaan=$data->penerimaan_10;
								break;
							case '11':
								// code...
								if($data->penerimaan_11 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_11."</small>";
								}
								$locked=$data->lock11;
								$nominal=$data->b11;
								$penerimaan=$data->penerimaan_11;
								break;
							case '12':
								// code...
								if($data->penerimaan_12 !=null){
									$lbl="<small>Diterima oleh: ".$data->created_by_12."</small>";
								}
								$locked=$data->lock12;
								$nominal=$data->b12;
								$penerimaan=$data->penerimaan_12;
								break;
							
							default:
								// code...
									$lbl="";
								break;
						}

						$disabled="";
						if($locked==1){
							$disabled='disabled="disabled"';
						}
					?>
						<tr>
							<th id="bulan<?=$value['id'];?>"><?=$value['name'];?></th>
							<td>
								<input class="form-control" name="b<?=$value['id'];?>" id="b<?=$value['id'];?>" value="<?=$nominal;?>" placeholder="contoh: 100000" <?=$disabled;?>>
							</td>
							<td>
								<input class="form-control datepicker" name="penerimaan_<?=$value['id'];?>" id="penerimaan_<?=$value['id'];?>" value="<?=$penerimaan;?>" placeholder="contoh: 25-12-2021" <?=$disabled;?>>
								<?=$lbl;?>
							</td>
							<td>
								<?php 
								if($locked==0){
								?>
									<div class="btn btn-warning" id="btn_terimapersembahan" recid="<?=$data->id;?>" id_field='<?=$value['id'];?>'>
										Terima
									</div>
								<?php 
								}
								else{
								?>
									<label class="label label-danger">Dikunci</label>
								<?php
								}
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
  	<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>

<script type="text/javascript">
$(document).ready(function(){	
	$('.datepicker').datepicker({
	    format: 'dd-mm-yyyy',
	});
})
</script>