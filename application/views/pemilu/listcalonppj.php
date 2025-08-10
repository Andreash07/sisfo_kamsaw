<table class="table table-stripped">
	<thead>
		<tr>
			<th class="text-center" style="width: 5%" >#</th>
			<th class="text-center" style="width: 20%">Nama Lengkap</th>
			<th class="text-center" style="width: 7%">Foto</th>
			<th class="text-center" style="width: 30%">Rincian Singkat</th>
			<th class="text-center" style="width: 15%">Action</th>
		</tr>
	</thead>
	<tbody>
<?php 
//print_r($calon);      die();
foreach ($calon as $key => $value) {
	if($value->jns_kelamin=='L'){
  		$jns_kelamin="Laki-laki";
    }
    else{
      	$jns_kelamin="Perempuan";
    }

    $foto_thumb=base_url().'assets/images/default-user.png';
	$foto=base_url().'assets/images/default-user.png';
    if($value->foto != null){
    	$foto_thumb=base_url().$value->foto_thumb;
    	$foto=base_url().$value->foto;
    	if(strpos($value->foto, 'https://') >=0 ){
        $foto_thumb=$value->foto_thumb;
        $foto=$value->foto;
      }
    }
?>
		<tr>
			<th class="text-center"><?=$key+$numStart+1;?></th>
			<td>
				<?=$value->nama_lengkap;?> - 
				<b><?=$value->hub_keluarga;?></b>
				<br>
				<b>No Anggota:</b> <?= $value->no_anggota;?>
				<br>
				<b><?=$jns_kelamin;?></b>
			</td>
			<td class="text-center">
				<div class="image view view-first">
					<img src="<?=$foto_thumb;?>" data-caption="<?=$value->nama_lengkap;?>" alt="<?=$value->nama_lengkap;?>" class="img-circle img-responsive" style="width: 77px;height: 77px;object-fit: cover;">
					<div class="mask">
	                  <div class="tools tools-bottom">
	                    <a href="<?=$foto;?>" title="Lihat Foto" href="image.jpg" data-fancybox="images" data-caption="<?=$value->nama_lengkap;?>"><i class="fa fa-eye" recid="<?=$value->id;?>"></i></a>
	                    <a href="!#" title="Ubah Foto" data-toggle="modal" data-target="#myModal" onclick="event.preventDefault();" recid="<?=$value->id;?>" id="uploadFoto"><i class="fa fa-upload"></i></a>
	                  </div>
	                </div>
	            </div>
			</td>
			<td>
				<!--rincian singkat-->
				<b>Keluarga:</b> <?= $value->kwg_nama;?>
				<br>
				<b>Wilayah:</b> <?= $value->kwg_wil;?> 
				<br>
				<b>Tempat, TTL:</b> <?= $value->tmpt_lahir.', '.convert_tgl_dMY($value->tgl_lahir) ;?>
				<br>
				<b>Telp/HP:</b> <?= $value->telepon;?>
				<br>
				<b>Alamat:</b> <?= $value->kwg_alamat;?>
			</td>
			<td class="text-center">
				<!--<a id="editAnggota" href="<?= base_url().'admin/DataJemaat?viewAnggota=true&';?>id=<?php echo $value->id; ?>" class="btn btn-success" style="padding: 2px 12px 2px 8px" title="Rincian Data Calon" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal"><span class="fa fa-info" style="width:8.3%"></span></a>-->

				<a href="!#" title="Ubah Foto" data-toggle="modal" data-target="#myModal" onclick="event.preventDefault();" recid="<?=$value->id;?>" id="uploadFoto"  class="btn btn-warning" style="padding: 2px 12px 2px 2px"><span class="fa fa-upload" style="width:8.3%"></span></a>

				<?php 
				//print_r($this->session->userdata()); die();
				$checked='';
				if($value->status_acc==1){
					$checked='checked="checked"';
				}
				if(in_array($this->session->userdata('userdata')->id, array(10, 16)) ){
				?>
					<div class="">
		        <label>
		        	<i class="fa fa-times text-danger"></i>
		          	<input type="checkbox" class="js-switch"  <?=$checked;?> anggota_jemaat="<?=$value->id;?>" recid="<?=$value->terpilih1;?>" title="<?=$value->nama_lengkap;?> (<?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> Th)" />
		        	<i class="fa fa-check-circle text-success"></i>
		        </label>
		    	</div>
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