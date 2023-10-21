<?php
//get data anggota jemaat
$AnggotaJemaat=$this->m_model->selectas('id', $AnggotaId, 'anggota_jemaat');
if(count($AnggotaJemaat)>0){
  $value=$AnggotaJemaat[0];
  //get hoby Jemaat
  $hoby=$this->m_model->selectas('anggota_jemaat_id', $value->id, 'hoby_jemaat');
  //get profesi Jemaat
  $profesi=$this->m_model->selectas('anggota_jemaat_id', $value->id, 'profesi_jemaat');
?>
<form class="form-horizontal form-label-left" action="" method="POST">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Hoby/Telenta - Profesi: <?=$value->nama_lengkap;?></h4>
  </div>
  <div class="modal-body">
    <?php
      $this->load->view('admin/check_box_hoby-talenta');
    ?>
  </div>
  <div class="modal-footer">
    <!--<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
      <input type="submit" class="btn btn-warning" value="Migrasi" name="migrasi_anggota">
      <button type="button" class="btn btn-primary">Cancel</button>
      <input type="reset" class="btn btn-primary" value="Reset">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>-->
  </div>
</form>
<?php
  foreach ($hoby as $key => $valueHoby) {
    # code...
?>
    <script type="text/javascript">
      $('#hoby<?=$valueHoby->hoby_id;?>').attr('checked','checked');
    </script>
<?php
  }
  foreach ($profesi as $keyprofesi => $valueprofesi) {
    # code...
?>
    <script type="text/javascript">
      $('#profesi<?=$valueprofesi->profesi_id;?>').attr('checked','checked');
    </script>
<?php
  }
}
?>
