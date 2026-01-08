<div class="row">
  <div class="col-xl-6 col-md-6 col-sm-12">


<div class="alert alert-warning" role="alert">
    <span class="alert-icon mr-0"><i class="ni ni-check-bold"></i></span>
    <span class="alert-text" style="display: unset;">Keluarga Anda memiliki <?= count($anggota_sidi);?> pemilih yang sah. Silahkan gunakan Hak Memilih dengan Bijak!</span>
</div>
  </div>
  <?php 
    foreach ($anggota_sidi as $key => $value) {
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

      $sisa_suara=8;
      $belum_kunci=0;
      $i_lock=0;
      if(isset($pemilih_voting[$value->id])){
        foreach ($pemilih_voting[$value->id] as $keyVoted => $valueVoted) {
          // code...
          #print_r($valueVoted);
          if($valueVoted->locked != 1){
            $voted_sts='<label class="text-warning text-sm"> Pengingat: Suara untuk Calon PNT (II) belum di <b>Kunci Pilihan</b> </label>';
            $belum_kunci++;
          }
          else{
            $i_lock++;
          }

        }

        $sisa_suara=$sisa_suara-$i_lock-$belum_kunci;
        if(count($pemilih_voting[$value->id]) <8){
          $voted_sts='<label class="text-danger text-sm" >';
          $voted_sts.='Pengingat: Belum menggunakan <b>'.$sisa_suara.' Hak Suara</b>';
          if($belum_kunci>0){
            $voted_sts.=' & <b>'.$belum_kunci.' Suara Belum dikunci</b>';
          }
          $voted_sts.='!</label>';
        }
        else{
          if($i_lock == 8){
            $voted_sts='<label class="text-success text-sm"> Hatur Nuhun, Calon PNT (II) pilihan sudah di <b>Kunci Pilihan</b>! </label>';
          }
          else{
            $voted_sts='<label class="text-warning text-sm"> Pengingat: Suara untuk '.$sisa_suara.' Calon Penatua belum di <b>Kunci Pilihan</b> </label>';
          }
        }
      }else{
        $voted_sts='<label class="text-danger text-sm" >Pengingat: Belum menggunakan <b>'.$sisa_suara.' Hak Suara</b>! </label>';
      }

      $ulasan_sts=0;
      if(isset($ulasan[$value->id])){
        $ulasan_sts=1;
      }
  ?>
      <div class="col-xl-6 col-md-6 col-sm-12">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-muted mb-0"><?=$title.ucwords($value->nama_lengkap);?></h5>
                <span class="h5 font-weight-bold mb-0"><i class="ni ni-calendar-grid-58 text-success"></i>&nbsp;<?=convert_tgl_dMY($value->tgl_lahir);?> (<?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun)</span>
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
              <h5 class="text-muted mb-0">Pemilihan</h5>
              <div class="divider" style="width: 100%; border-bottom: 1px #8898aa solid; clear: both; margin-bottom: 5px; margin-top:1px;"></div>
              <a id="btn_ajax_modal" href="<?=base_url();?>ajax/list_calon_penatua2/?kwg_wil=<?=$value->kwg_wil;?>&id=<?=$value->id;?>&nama=<?=rawurlencode($title.ucwords($value->nama_lengkap));?>" class="col-12 btn btn-info btn-sm text-nowrap float-left" data-toggle="modal" data-target="#exampleModal" onclick="event.preventDefault();"><i class="ni ni-bullet-list-67"></i><b>Surat Suara Penatua Tahap II</b></a>


              <?=$voted_sts;?>
            </p>
          </div>
        </div>
      </div>
  <?php
    }
  ?>
</div>