<?php
foreach ($angjem as $key => $value) {
	# code...
?>
	<div class="form-group" id="div_input<?=$value->jemaat_id;?>">
		<div class="row">
			<div class="col-md-8 col-xs-6">
			  <input type="text" id="name_lengkap<?=$value->jemaat_id;?>" name="name_lengkap<?=$value->jemaat_id;?>" value="<?=$value->jemaat_name;?>" class="form-control" disabled>
			  <input type="hidden" id="kwg_id<?=$value->jemaat_id;?>" name="kwg_id<?=$value->jemaat_id;?>" value="<?=$value->kwg_id;?>" class="form-control" >
			  <input type="hidden" id="tgl_lahir<?=$value->jemaat_id;?>" name="tgl_lahir<?=$value->jemaat_id;?>" value="<?=$value->tgl_lahir;?>" class="form-control" >
			  <input type="hidden" id="jemaat_id<?=$value->jemaat_id;?>" name="jemaat_id[<?=$value->jemaat_id;?>]" value="<?=$value->jemaat_id;?>" class="form-control" >
			</div>
			<div class="col-md-4 col-xs-6">
			  <input type="text" id="umur<?=$value->jemaat_id;?>" name="umur<?=$value->jemaat_id;?>" value="<?=$value->umur;?> Tahun" class="form-control" disabled>
			</div>
		</div>
		<div class="clearfix" style="margin-bottom: 10px;"></div>
		<div class="row">
			<div class="col-xs-5">
				<select class="form-control" id="status_kawin<?=$value->jemaat_id;?>" name="status_kawin<?=$value->jemaat_id;?>">
					<?php 
					foreach ($ls_kawin as $key => $value1) {
						# code...
					?>
						<option value="<?=$value1->id;?>"><?=$value1->status_kawin;?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="col-xs-4">
				<select class="form-control"  id="hub_keluarga<?=$value->jemaat_id;?>" name="hub_keluarga<?=$value->jemaat_id;?>" required recid="<?=$value->jemaat_id;?>">
					<option value="0">Pilih</option>
					<?php 
					foreach ($ls_hubkwg as $key => $value1) {
						# code...
					?>
						<option value="<?=$value1->idhubkel;?>"><?=$value1->hub_keluarga;?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="col-xs-3">
				<button href="" class="btn btn-warning">Hapus</button>
			</div>
		</div>
	</div>
<?php
}
?>