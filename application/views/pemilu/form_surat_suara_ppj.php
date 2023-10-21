<div class="col-xs-12">
	<div class="col-xs-12">
		<h5>SN Surat Suara: <?=$token;?> <i class="fa fa-check-circle text-success"></i></h5>
	</div>
	<b id="hak_suara" style="display: none;"><?=$hak_suara;?></b>
	<form id="form_pemilihan" action="<?=base_url();?>pnppj/submit_pemilihan">
	    <input type="hidden" name="token" id="token" value="<?=$token;?>">
	    <input type="hidden" name="id_pemilih" id="id_pemilih" value="<?=$id_pemilih;?>">
	    <input type="hidden" name="wil_pemilih" id="wil_pemilih" value="<?=$wil_pemilih;?>">
	<?php 
	$num_voted=0;
	foreach ($calon as $key => $value) {
		// code...
		$ico_gender='<i class="fa fa-female" style="font-size:12pt;"></i>';
        $color_gender="bg-gradient-red";
        $title="Ibu ";
        if($value->sts_kawin==1){
          $title="Sdri. ";
        }
        if(mb_strtolower($value->jns_kelamin)=='l'){
          $color_gender="bg-gradient-blue";
          $ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';
          $title="Bp. ";
          if($value->sts_kawin==1){
            $title="Sdr. ";
          }
        }

        $foto_thumb=base_url().'assets/images/default-user.png';
        $foto=base_url().'assets/images/default-user.png';
        if($value->foto != null){
          $foto_thumb=base_url().$value->foto_thumb;
          $foto=base_url().$value->foto;
        }

        $checked="";
        if($value->voted>0){
          $checked='checked="checked"';
          $num_voted++;
        }

        $disabled="";
        if($value->locked==1){
          $disabled="disabled";
        }
	?>
	<div class="col-md-55">
	    <div class="thumbnail">
	      <div class="image view view-first">
	        <img style="width: 100%; display: block;" src="<?=$foto_thumb;?>" alt="image" />
	        <div class="mask">
	          <p><small class="font-weight-light"><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun | Wil. <?=$value->kwg_wil;?></small></p>
	        </div>
	      </div>
	      <div class="caption text-center">
	      	<input type="checkbox" class="custom-control-input" name="calon_pn[]" id="calon_pn<?=$value->id;?>" value="<?=$value->id;?>#<?=$value->kwg_wil;?>" group_id="calon_pn" <?=$checked;?> <?=$disabled;?>>
	        <p>
	        	<small class="d-block mb-0" style="display:block;"><?=$title.ucwords($value->nama_lengkap);?></small>
            </p>
	      </div>
	    </div>
  	</div>
	<?php
	}
	?>
	<input type="hidden" name="num_voted" id="num_voted" value="<?=$num_voted;?>">
	</form>
	<div class="col-xs-12">
		<button type="button" class="btn btn-primary" id="btn_kunciPilihan" onclick="event.preventDefault()">Kunci Pilihan</button>
	</div>
</div>