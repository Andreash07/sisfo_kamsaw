

<?php
  if(isset($type) && $type=='editKebaktian'){
    //get data anggota jemaat
    $KebaktianJemaat=$this->m_model->selectas('id_kebaktian', $KebaktianId, 'kebaktian');
    
   
      $value=$KebaktianJemaat[0];

?>
        <form class="form-horizontal form-label-left" action="<?=base_url();?>kebaktian/kebaktian_gereja/saveEditKebaktian/" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" class="form-control" name="id" value="<?=$value->id_kebaktian;?>">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Kebaktian <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_kebaktian" name="tgl_kebaktian" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=$value->tgl_kebaktian;?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
        
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Ibadah<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" required id="hub_kwg" name="jns_ibadah">
             
              
              
              <option value='6' selected>Ibadah Subuh</option>
              <option value='9'  selected>Ibadah Pagi</option>
              <option value='18' selected>Ibadah Sore</option>
              <option value='2' selected>Ibadah Spesial</option>
               <option value='' disabled selected>Pilih</option>
              
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Pria<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_baptis" name="jml_pria" value="<?=$value->pria_kebaktian;?>" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Wanita<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_baptis" name="jml_wanita" value="<?=$value->wanita_kebaktian;?>" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan<span class="required">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12">
          <textarea class="form-control" name="ket_kebaktian" value=""><?=$value->ket_kebaktian;?></textarea>
          </div>
        </div>


      </div>
    </div>
      <div class="modal-footer">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" >Close</button>
          <input type="reset" class="btn btn-primary" value="Reset">
          <input type="submit" class="btn btn-success" value="Save" name="saveEditKebaktian">
        </div>
      </div>
    </form>

<?php
 
    
  }

?>

<script type="text/javascript">
  /*$('.single_cal1').daterangepicker({
    singleDatePicker: true,
    singleClasses: "picker_1",
    locale: {
      format: 'DD-MM-YYYY'
    }, 
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });*/
  $('.datepicker').datepicker({

    format: 'dd-mm-yyyy',
  });
</script>

<?php
  if(isset($type) && $type=='editKebaktian'){
    if($value->tgl_kebaktian == null || $value->tgl_kebaktian == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_kebaktian').val('');
    </script>

<?php
    }
  }
?>