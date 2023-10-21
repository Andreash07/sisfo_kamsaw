<div class="row">
  <?php 
    foreach ($anggota as $key => $value) {
      # code...
      $ico_gender='<i class="fa fa-female  fa-2x"></i>';
      $color_gender="bg-gradient-red";
      $title="Ibu ";
      if($value->sts_kawin==1){
        $title="Sdri. ";
      }
      if(mb_strtolower($value->jns_kelamin)=='l'){
        $color_gender="bg-gradient-blue";
        $ico_gender='<i class="fa fa-male fa-2x"></i>';
        $title="Bp. ";
        if($value->sts_kawin==1){
          $title="Sdr. ";
        }
      }
  ?>
      <div class="col-xl-6 col-md-6 col-sm-12">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-muted mb-0"><?=$title.ucwords($value->nama_lengkap);?></h5>
                <span class="h5 font-weight-bold mb-0"><i class="ni ni-calendar-grid-58 text-success"></i>&nbsp;<?=convert_tgl_dMY($value->tgl_lahir);?> (<?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun)</span> (<span class="h5 mb-0"><i class="fa fa-tint text-danger"></i>&nbsp;<?=$value->golongandarah;?></span>)
                <br>
                <span class="h5 mb-0">
                  <i class="ni ni-favourite-28 text-danger"></i>&nbsp;<?=$value->status_kawin;?>
                  <?php
                  if($value->sts_kawin==2){
                  ?>
                    <?= "-&nbsp;".convert_tgl_dMY($value->tgl_nikah);?>
                  <?php
                  }
                  ;?>
                </span>
                <br>
                <span class="h5 mb-0">
                 <?php
                  if($value->status_baptis==1){
                  ?>
                    <i class="fa fa-check-square text-success"></i>&nbsp; Sudah Baptis
                    <?= "-&nbsp;".convert_tgl_dMY($value->tgl_baptis);?>
                  <?php
                  }
                  else{
                  ?>
                    <i class="fa fa-times-square text-danger"></i>&nbsp; Belum Baptis
                  <?php 
                  }
                  ;?>
                </span>
                <br>
                <span class="h5 mb-0">
                 <?php
                  if($value->status_sidi==1){
                  ?>
                    <i class="fa fa-check-square text-success"></i>&nbsp; Sudah Sidi
                    <?= "-&nbsp;".convert_tgl_dMY($value->tgl_sidi);?>
                  <?php
                  }
                  else{
                  ?>
                    <i class="fa fa-times-square text-danger"></i>&nbsp; Belum Sidi
                  <?php 
                  }
                  ;?>
                </span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape  <?=$color_gender;?> text-white rounded-circle shadow">
                  <?=$ico_gender;?>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              <a id="btn_ajax_modal" href="<?=base_url();?>keluarga/view_anggota/<?=md5($value->id);?>" class="btn btn-info btn-sm text-nowrap float-right" data-toggle="modal" data-target="#exampleModal" onclick="event.preventDefault();"><b>Detil & Perbaruhi Data</b>!</a>
            </p>
          </div>
        </div>
      </div>
  <?php
    }
  ?>
</div>