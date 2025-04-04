<div class="col-xs-12">
  <h3>Data Tunggakan Iuran Perawatan Makam</h3>
</div>
<?php 
  foreach ($tunggakan_blok_makam as $key2 => $value2) {
    // code...
?>
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="tile-stats">
      <div class="icon" ><i class="fa fa-caret-square-o-right"></i></div>
      <div class="count"><?=$value2['num_blok'];?> Blok</div>
      <h3> <?=$value2['title'];?></h3>
      <span title="<?=$value2['description'];?>" id="detail_tunggakan" class="count_bottom pull-right" style="margin-right: 17px; cursor: pointer;" ls_kk="<?= implode(',', $value2['ls_blok_id']);?>"><i class="green">selengkapnya</i></span>
    </div>
  </div>
<?php
  }
?>