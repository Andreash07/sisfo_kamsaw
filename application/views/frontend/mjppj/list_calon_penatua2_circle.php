<div class="modal-header">
  <h6 class="modal-title" id="modal-title-default">List Calon Penatua</h6>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<div class="modal-body" >
  <!--<label class="text-muted">Anda sudah memilih <b id="lbl_num_pilihan">0</b> dari <b id="hak_suara"><?=$hak_suara;?></b></label>-->
  <div class="clearfix"></div>
  <small class="text-danger">* Tolong klik tombol <b>Kunci Pilihan</b>. Agar suara pilihan Anda dianggap Sah.</small>
  <div class="clearfix"></div>
  <form id="form_pemilihan" action="<?=base_url();?>pnppj/submit_pemilihan">
    <input type="hidden" name="id_pemilih" id="id_pemilih" value="<?=$id_pemilih;?>">
    <input type="hidden" name="wil_pemilih" id="wil_pemilih" value="<?=$wil_pemilih;?>">
    <div class="row">
    <!--<table id="tbl_calon_penatua">
      <thead>
        <tr>
          <th>Nama Calon</th>
          <th></th>
        </tr>
      </thead>-->
      <?php 
      $num_voted=0;
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

        $checked="";

        $disabled="";
      ?>


          <div class="col-6">
            <div class="card">
              <!-- Card body -->
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <a href="#" class="avatar avatar-xl rounded-circle">
                      <img alt="Image placeholder" src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/theme/team-2.jpg">
                    </a>
                  </div>
                  <div class="col ml--2">
                    <h4 class="mb-0">
                      <a href="#!">John Snow</a>
                    </h4>
                    <p class="text-sm text-muted mb-0">Working remoteley</p>
                    <span class="text-success">●</span>
                    <small>Active</small>
                  </div>
                  <div class="col-auto">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="calon_pn[]" id="calon_pn<?=$value->id;?>" value="<?=$value->id;?>#<?=$value->kwg_wil;?>" group_id="calon_pn" <?=$checked;?> <?=$disabled;?>>
                      <label class="custom-control-label" for="calon_pn<?=$value->id;?>"></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php
      /*
      <tr>
          <td>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="calon_pn[]" id="calon_pn<?=$value->id;?>" value="<?=$value->id;?>#<?=$value->kwg_wil;?>" group_id="calon_pn" <?=$checked;?> <?=$disabled;?>>
              <label class="custom-control-label" for="calon_pn<?=$value->id;?>"></label>
            </div>
          </td>
          <td style="font-size:12px;">
            <div class="icon icon-shape  <?=$color_gender;?> text-white rounded-circle shadow" style="width: 1rem; height: 1rem;">
              <?=$ico_gender;?>
            </div>
            <?=$title.ucwords($value->nama_lengkap);?>
            <br>
            <label class="text-muted"><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun | Wilayah <?=$value->kwg_wil;?></label>
          </td>
          <td>
            <!--<a id="btn_ajax_modal" href="<?=base_url();?>ajax/list_calon_ppj/?kwg_wil=<?=$value->kwg_wil;?>&id=<?=$value->id;?>" class="col-4  btn btn-warning btn-sm text-nowrap float-right" data-toggle="modal" data-target="#exampleModal" onclick="event.preventDefault();"><i class="ni ni-badge"></i><b></b></a>-->
          </td>
        </tr>
      */
      }
      ?>
    <!--</table>-->
    </div>
    <input type="hidden" name="num_voted" id="num_voted" value="<?=$num_voted;?>">
  </form>
</div>
<div class="modal-footer">
  <small class="text-danger">* Tolong klik tombol <b>Kunci Pilihan</b>. Agar suara pilihan Anda dianggap Sah.</small>
  <div class="clearfix"></div>
  <button type="button" class="btn btn-primary" id="btn_kunciPilihan" onclick="event.preventDefault()">Kunci Pilihan</button>
</div>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#lbl_num_pilihan').html('<?=$num_voted;?>');
    $('#tbl_calon_penatua').DataTable({
      "lengthChange": false
    });

  })
</script>