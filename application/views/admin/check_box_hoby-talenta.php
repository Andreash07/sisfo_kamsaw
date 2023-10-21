<input type="hidden" id="anggota_jemaat_talentaprofesi" name="anggota_jemaat_talentaprofesi" value="<?=$this->input->get('id');?>">
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">Talenta/Hoby
  </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <?php
      foreach (ls_Hoby() as $keyHoby => $valueHoby) {
        # code...
    ?>
        <div class="checkbox col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <label>
            <input group_input='hoby' type="checkbox" class="flat" id="hoby<?=$valueHoby->id;?>" name="hoby[]" value="<?=$valueHoby->id;?>"><?=$valueHoby->name;?>
          </label>
        </div>
    <?php
      }
    ?>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">Profesi
  </label>
  <div class="col-md-9 col-sm-9 col-xs-12">
    <?php
      foreach (ls_Profesi() as $keyProfesi => $valueProfesi) {
        # code...
    ?>
        <div class="checkbox col-xs-6 col-sm-4 col-md-4 col-lg-4">
          <label>
            <input type="checkbox" group_input='profesi' class="flat" id="profesi<?=$valueProfesi->id;?>" name="profesi[]" value="<?=$valueProfesi->id;?>"><?=$valueProfesi->name;?>
          </label>
        </div>
    <?php
      }
    ?>
  </div>
</div>