  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Data Keluarga</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="row">
      <?php 
      if(count($keluarga)==0){
        echo "Akses Ditolak, Parameter Invalid!";
      }
      else{
        $keluarga=$keluarga[0];
        $sts_approve="";
        if($keluarga->kwg_wil_approve==0){
          $sts_approve='<span class="text-warning">Perubahan belum disetujui, harap menunggu!</span>';
        }
      ?>
      <form class="form-horizontal form-label-left" id="form_edit_kk"  name="form_edit_kk" method="POST"style="width: 100%;" action="<?=base_url();?>keluarga/update">
        <div class="row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">No KK<span class="required"></span>
          </label>
          <div class="col-md-6 col-sm-9 col-xs-12">
            <input class="form-control" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=$keluarga->kwg_no;?>" disabled>
          </div>
        </div>
        <div class="row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Nama KK<span class="required"></span>
          </label>
          <div class="col-md-6 col-sm-9 col-xs-12">
            <input type="hidden" id="keluarga_jemaat_id" name="keluarga_jemaat_id" required="required" value="<?=$keluarga->id;?>">
            <input type="hidden" id="kwg_no" name="kwg_no" required="required" value="<?=$keluarga->kwg_no;?>">
            <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control" value="<?=$keluarga->kwg_nama;?>">
          </div>
        </div>
        <div class="row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_alamat">Alamat
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="kwg_alamat" name="kwg_alamat" class="form-control"><?=$keluarga->kwg_alamat;?></textarea>
          </div>
        </div>
        <div class="row">
          <label for="kwg_telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Telpon</label>
          <div class="col-md-6 col-sm-9 col-xs-12">
            <input id="kwg_telepon" name="kwg_telepon" class="form-control" type="text" value="<?=$keluarga->kwg_telepon;?>">
          </div>
        </div>
        <div class="row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Wilayah
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-9 col-xs-12">
            <select class="form-control" name="kwg_wil" id="kwg_wil">
              <?php
                foreach ($wilayah as $keyWil => $Wil) {
                  # code...
                  $selected="";
                  if($Wil->wilayah == $keluarga->kwg_wil){
                    $selected="selected";
                  }
              ?>
                  <option <?=$selected;?> value="<?=$Wil->wilayah;?>"><?=$Wil->wilayah;?></option>
              <?php
                }
              ?>
            </select>
            <?=$sts_approve;?>
          </div>
        </div>
      </form>
      <?php
      }
      ?>
    </div>
  </div>
  <div class="modal-footer">
    <div class="form-group">
        <span class="text-danger">* Perlu persetujuan admin setelah perubahan data!</span>
        <a class="btn btn-warning pull-left" href="!#" data-dismiss="modal" onclick="event.preventDefault()">Close</a>
        <button class="btn btn-default pull-right" value="" onclick="event.preventDefault(); document.getElementById('form_edit_kk').submit();">Update</button>
      </div>
  </div>