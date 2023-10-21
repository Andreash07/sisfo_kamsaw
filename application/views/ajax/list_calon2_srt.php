
<br><div class="row" >
  <div class="col-12 pull-right" >
<?php 
if(isset($pagingnation)){
  echo $pagingnation;
}
?>
  </div>
</div>
<div class="row" id="content_list_calon2">
<?php 
//print_r($calon);      die();
foreach ($calon as $key => $value) {
  # code...
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
      <div class="thumbnail" style="height: 215px;">
        <div class="image view view-first">
          <img style="width: 100%; display: block;" src="<?=$foto_thumb;?>" alt="image" />
          <div class="mask">
            <p><small class="font-weight-light"><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun | Wil. <?=$value->kwg_wil;?></small></p>
          </div>
        </div>
        <div class="caption text-center">
          <small class="d-block mb-0"><?=$title.ucwords($value->nama_lengkap);?></small>
          <small class="h5 font-weight-light text-muted"><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun | Wil. <?=$value->kwg_wil;?></small>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="calon_pn[]" id="calon_pn<?=$value->id;?>" value="<?=$value->id;?>#<?=$value->kwg_wil;?>" group_id="calon_pn" <?=$checked;?> <?=$disabled;?>  wil_calon="<?=$value->kwg_wil;?>" jns_kelamin="<?=strtolower($value->jns_kelamin);?>">
            <label class="custom-control-label" for="calon_pn<?=$value->id;?>"></label>
          </div>
        </div>
      </div>
    </div>

<?php 
  }
?>
</div>

<br><div class="row" >
  <div class="col-12 pull-right" >
  <?php 
  if(isset($pagingnation)){
    echo $pagingnation;
  }
  ?>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#content_list_calon2').css("min-height", 'unset');
    console.log($('#content_list_calon2').height())
    $('#content_list_calon2').css("min-height", $('#content_list_calon2').height());
  })
</script>