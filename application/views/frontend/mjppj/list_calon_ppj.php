<div class="modal-header">

  <h6 class="modal-title" id="modal-title-default">List Calon PPJ</h6>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

    <span aria-hidden="true">×</span>

  </button>

</div>

<div class="modal-body" style="padding-top: unset; border-top: 1px #ededed solid;">
  <b style="display:block;"><?=$nama_pemilih;?></b>
  <label class="text-muted">Anda sudah memilih <b id="lbl_num_pilihan">0</b> dari <b id="hak_suara"><?=$hak_suara;?></b></label>

  <div class="clearfix"></div>

  <small class="text-danger">* Tolong klik tombol <b>Kunci Pilihan</b>. Agar suara pilihan Anda dianggap Sah.</small>
  <button type="button" class="btn btn-primary pull-right" id="btn_kunciPilihan" onclick="event.preventDefault()">Kunci Pilihan</button>
  <div class="clearfix"></div>

  <form id="form_pemilihan" action="<?=base_url();?>pnppj/submit_pemilihan">
<br>
    <input type="hidden" name="id_pemilih" id="id_pemilih" value="<?=$id_pemilih;?>">
    <input type="hidden" name="nama_pemilih_suratsuara" id="nama_pemilih_suratsuara" value="<?=$nama_pemilih;?>">

    <input type="hidden" name="wil_pemilih" id="wil_pemilih" value="<?=$wil_pemilih;?>">
    <div class="row" id="content_list_calon2">
      <?php 
      #print_r($calon);      die();
      $num_voted=0;
      shuffle($calon);
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

          #if(strpos($value->foto, 'https://') >=0 ){
           # $foto_thumb=$value->foto_thumb;
           # $foto=$value->foto;
          #}else{
            $foto_thumb=base_url().$value->foto_thumb;
            $foto=base_url().$value->foto;
          #}

        }

        $checked="";
        if($value->voted>0){
          $checked='checked="checked"';
          $num_voted++;
        }

        $disabled="";
        $ket_pilih="";
        if($value->locked==1){
          $disabled="disabled";
          #$ket_pilih="<small class='text-danger'>Dipilih</small>";
        }

      ?>


          <div class="col-6">
            <div class="card">
              <!-- Card body -->
              <div class="card-body" style="padding:0.5rem;">
                <a href="#!" id="triger_calon_pn" value="calon_pn<?=$value->id;?>" style="text-decoration: none; color: #32325d;">
                  <img src="<?=$foto_thumb;?>" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 117px; height: 117px;object-fit: cover;">
                </a>
                <div class="pt-2 text-center">
                  <div class="col-12" style="border-top: solid 1px #ececec;"></div>
                  <h5 class="h3 title">
                    <a id="triger_calon_pn" value="calon_pn<?=$value->id;?>" style="text-decoration: none; color: #32325d;">
                      <small class="d-block mb-0"><?=$title.ucwords($value->nama_lengkap);?></small>
                    </a>
                    <small class="h5 font-weight-light text-muted"><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun</small> <!-- | Wil. <?=$value->kwg_wil;?> -->
                    <?=$ket_pilih;?>
                  </h5>
                  <div>
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
        }
      ?>
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