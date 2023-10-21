<div class="col-xs-12">
  <h5>Surat Baptis
    <?php 
      if(!isset($lampiran[1])){
    ?>
        <i class="fa fa-times text-danger"></i>
    <?php 
      }
      else{
    ?>
        <i class="fa fa-check-square-o text-success"></i>
    <?php 
      }
    ?>
  </h5>
</div>
<?php 
if(isset($lampiran[1])){
  foreach ($lampiran[1] as $key => $value) {
    // code...
    //print_r($value);die();
    //https://drive.google.com/uc?export=view&id= ini untuk load direct in page html
    $path=base_url().$value->path;
    $path_compress=base_url().$value->path_compress;
    if($value->new_path){
      $path="https://drive.google.com/uc?export=view&id=".$value->new_path;
      $path_compress="https://drive.google.com/uc?export=view&id=".$value->new_path_compress;
    }
?>
  <div class="col-xs-6 col-md-3">
    <img href="<?=$path ;?>" data-fancybox="images" data-caption="Surat Baptis" src="<?= $path_compress;?>" class="img-responsive img-thumbnail" alt="Responsive image">
    <i href="<?=base_url();?>admin/delete_lampiran?id=<?=$value->id;?>&kategori_lampiran=<?=$value->kategori_lampiran;?>&lampiran=lampiran_baptis&angjem_id=<?=$value->anggota_jemaat_id;?>" id="btn_delete_lampiran" class="fa fa-times btn btn-sm btn-danger" style="position: absolute; right: 7px;"></i>
  </div>
<?php
  }
}
?>

<div class="col-xs-12">
  <div class="divider"></div>
</div>
<div class="col-xs-12">
  <h5>Surat SIDI
    <?php 
      if(!isset($lampiran[2])){
    ?>
        <i class="fa fa-times text-danger"></i>
    <?php 
      }
      else{
    ?>
        <i class="fa fa-check-square-o text-success"></i>
    <?php 
      }
    ?>
  </h5>
</div>
<?php 
if(isset($lampiran[2])){
  foreach ($lampiran[2] as $key => $value) {
    // code...
    //https://drive.google.com/uc?export=view&id= ini untuk load direct in page html
    $path=base_url().$value->path;
    $path_compress=base_url().$value->path_compress;
    if($value->new_path){
      $path="https://drive.google.com/uc?export=view&id=".$value->new_path;
      $path_compress="https://drive.google.com/uc?export=view&id=".$value->new_path_compress;
    }
?>
  <div class="col-xs-6 col-md-3">
    <img href="<?= $path;?>" data-fancybox="images" data-caption="Surat SIDI" src="<?= $path_compress;?>" class="img-responsive img-thumbnail" alt="Responsive image">
    <i href="<?=base_url();?>admin/delete_lampiran?id=<?=$value->id;?>&kategori_lampiran=<?=$value->kategori_lampiran;?>&lampiran=lampiran_sidi&angjem_id=<?=$value->anggota_jemaat_id;?>" id="btn_delete_lampiran" class="fa fa-times btn btn-sm btn-danger" style="position: absolute; right: 7px;"></i>
  </div>
<?php
  }
}
?>

<div class="col-xs-12">
  <div class="divider"></div>
</div>
<div class="col-xs-12">
  <h5>Surat Nikah
    <?php 
      if(!isset($lampiran[3])){
    ?>
        <i class="fa fa-times text-danger"></i>
    <?php 
      }
      else{
    ?>
        <i class="fa fa-check-square-o text-success"></i>
    <?php 
      }
    ?>
  </h5>
</div>
<?php 
if(isset($lampiran[3])){
  foreach ($lampiran[3] as $key => $value) {
    // code...
    //https://drive.google.com/uc?export=view&id= ini untuk load direct in page html
    $path=base_url().$value->path;
    $path_compress=base_url().$value->path_compress;
    if($value->new_path){
      $path="https://drive.google.com/uc?export=view&id=".$value->new_path;
      $path_compress="https://drive.google.com/uc?export=view&id=".$value->new_path_compress;
    }
?>
  <div class="col-xs-6 col-md-3">
    <img href="<?= $path;?>" data-fancybox="images" data-caption="Surat Nikah" src="<?= $path_compress;?>" class="img-responsive img-thumbnail" alt="Responsive image">
    <i href="<?=base_url();?>admin/delete_lampiran?id=<?=$value->id;?>&kategori_lampiran=<?=$value->kategori_lampiran;?>&lampiran=lampiran_nikah&angjem_id=<?=$value->anggota_jemaat_id;?>" id="btn_delete_lampiran" class="fa fa-times btn btn-sm btn-danger" style="position: absolute; right: 7px;"></i>
  </div>
<?php
  }
}
?>

<div class="col-xs-12">
  <div class="divider"></div>
</div>
<div class="col-xs-12">
  <h5>KTP
    <?php 
      if(!isset($lampiran[4])){
    ?>
        <i class="fa fa-times text-danger"></i>
    <?php 
      }
      else{
    ?>
        <i class="fa fa-check-square-o text-success"></i>
    <?php 
      }
    ?>
  </h5>
</div>
<?php 
if(isset($lampiran[4])){
  foreach ($lampiran[4] as $key => $value) {
    // code...
    //https://drive.google.com/uc?export=view&id= ini untuk load direct in page html
    $path=base_url().$value->path;
    $path_compress=base_url().$value->path_compress;
    if($value->new_path){
      $path="https://drive.google.com/uc?export=view&id=".$value->new_path;
      $path_compress="https://drive.google.com/uc?export=view&id=".$value->new_path_compress;
    }
?>
  <div class="col-xs-6 col-md-3">
    <img href="<?= $path;?>" data-fancybox="images" data-caption="KTP" src="<?= $path_compress;?>" class="img-responsive img-thumbnail" alt="Responsive image">
    <i href="<?=base_url();?>admin/delete_lampiran?id=<?=$value->id;?>&kategori_lampiran=<?=$value->kategori_lampiran;?>&lampiran=lampiran_ktp&angjem_id=<?=$value->anggota_jemaat_id;?>" id="btn_delete_lampiran" class="fa fa-times btn btn-sm btn-danger" style="position: absolute; right: 7px;"></i>
  </div>
<?php
  }
}
?>

<div class="col-xs-12">
  <div class="divider"></div>
</div>
<div class="col-xs-12">
  <h5>KK
    <?php 
      if(!isset($lampiran[5])){
    ?>
        <i class="fa fa-times text-danger"></i>
    <?php 
      }
      else{
    ?>
        <i class="fa fa-check-square-o text-success"></i>
    <?php 
      }
    ?>
  </h5>
</div>
<?php 
if(isset($lampiran[5])){
  foreach ($lampiran[5] as $key => $value) {
    // code...
    //https://drive.google.com/uc?export=view&id= ini untuk load direct in page html
    $path=base_url().$value->path;
    $path_compress=base_url().$value->path_compress;
    if($value->new_path){
      $path="https://drive.google.com/uc?export=view&id=".$value->new_path;
      $path_compress="https://drive.google.com/uc?export=view&id=".$value->new_path_compress;
    }
?>
  <div class="col-xs-6 col-md-3">
    <img href="<?= $path;?>" data-fancybox="images" data-caption="Kartu Keluarga" src="<?= $path_compress;?>" class="img-responsive img-thumbnail" alt="Responsive image">
    <i href="<?=base_url();?>admin/delete_lampiran?id=<?=$value->id;?>&kategori_lampiran=<?=$value->kategori_lampiran;?>&lampiran=lampiran_kk&angjem_id=<?=$value->anggota_jemaat_id;?>" id="btn_delete_lampiran" class="fa fa-times btn btn-sm btn-danger" style="position: absolute; right: 7px;"></i>
  </div>
<?php
  }
}
?>