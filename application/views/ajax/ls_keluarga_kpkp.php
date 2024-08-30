<?php
if(count($keluarga)==0){
?>
<h4 style="font-style: italic; font-weight: thin;" >Oooppss... Pencarian <b><?=$keyword;?></b> tidak ditemukan, Coba dengan nama yang lain!</h4>
<?php
die();
}
?>
<div class="row " style="overflow-y: auto; max-height: 440px;">
  <div class="col-xs-12">
    <ul class="list-unstyled msg_list">
    <?php
    foreach ($keluarga as $key => $value) {
      # code...
      $umur=0;
      if($value->tgl_lahir!= null && $value->tgl_lahir!='0000-00-00'){
        $umur=getUmur(date('Y-m-d'), $value->tgl_lahir);
      }
    ?>
    <li>
      <a style="width: 100%">
            <span>
                <span><b><?=$value->nama_lengkap;?> (<i><?=$umur;?>th - <?=$value->hub_keluarga;?></i>)</b></span>
                <span class="time">
                  <button id="btn_choose_kwg" class="btn btn-info" kwg_id="<?=$value->id;?>" jemaat_name="<?=$value->nama_lengkap;?>" onclick="event.preventDefault();">Pilih</button>
                </span>
                <form id="form_kwg<?=$value->id;?>" action="<?=base_url();?>ajax/get_angjem" method="POST">
                  <input type="hidden" name="view" value="ajax/data_jemaat">
                  <input type="hidden" name="kwg_id" value="<?=$value->id;?>">
                  <input type="hidden" name="jemaat_id" value="<?=$value->jemaat_id;?>">
                  <input type="hidden" name="kwg_name" value="<?=$value->kwg_nama;?>">
                  <input type="hidden" name="jemaat_name" value="<?=$value->nama_lengkap;?>">
                  <input type="hidden" name="tgl_lahir" value="<?=$value->tgl_lahir;?>">
                  <input type="hidden" name="umur" value="<?=$umur;?>">
                </form>
            </span>
            <span class="message" style="max-width: 95%">
              Ditemukan pada Keluarga <b><?=$value->kwg_nama;?></b><br>di Wilayah <?=$value->wilayah;?>
            </span>
        </a>
    </li>
    <?php
    }
    ?>
    </ul>
  </div>
</div>