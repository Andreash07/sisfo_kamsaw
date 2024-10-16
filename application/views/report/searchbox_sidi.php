<form class="form-horizontal form-label-left" action="" method="GET">
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Anggota<span class="required">*</span></label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
	        <input type="text" class="form-control" name="nama_anggota" value="<?=rawurldecode($this->input->get('nama_anggota'));?>">
	  	</div>
    </div>
    <div class="form-group col-md-3 col-xs-12">
        <label class="control-label col-md-6 col-sm-6 col-xs-12">Jenis Kelamin<span class="required">*</span>
        </label>
	  	<div class="col-md-6 col-sm-6 col-xs-12">
	      	<select class="form-control" id="jns_kelamin" name="jns_kelamin">
	          	<option value='' >Semua</option>
	        	<option value='L' <?php if(strtolower($this->input->get('jns_kelamin'))=='l'){echo "selected";};?>>Laki-laki</option>
	         	<option value='P' <?php if(strtolower($this->input->get('jns_kelamin'))=='p'){echo "selected";};?>>Perempuan</option>
	        </select>
	    </div>
    </div>
    <div class="form-group col-md-3 col-xs-12">
    	<label class="control-label col-md-3 col-sm-3 col-xs-12">Wilayah<span class="required">*</span></label>
    	<div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="kwg_wil" name="kwg_wil" >
            <option value='' >Semua</option>
            <option value='0'>Belum Diketahui</option>
            <?php
              foreach (lsWil() as $lsWil => $valueWil) {
                # code...
            ?>
              <option value='<?=$valueWil->id;?>' <?php if($this->input->get('kwg_wil')==$valueWil->id){echo 'selected';}?>>Wilayah <?=$valueWil->wilayah;?></option>
            <?php
              }
            ?>
          </select>
    	</div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Baptis<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="status_sidi" name="status_baptis" >
            <option value='' >Semua</option>
            <option value='Sudah' <?php if($this->input->get('status_baptis')=='Sudah'){echo "selected";}?>>Sudah</option>
            <option value='Belum' <?php if($this->input->get('status_baptis')=='Belum'){echo "selected";}?>>Belum</option>
          </select>
      </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Baptis<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="input-group">
          <input type="text" class="form-control datepicker" id="tgl_baptis" name="tgl_baptis" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=$this->input->get('tgl_baptis');?>">
          <span class="input-group-btn">
            <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Tanggal akan menjadi '00-00-0000'" what="date">
              <i class="fa fa-undo"></i>
            </button>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Sidi<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="status_sidi" name="status_sidi" >
            <option value='' >Semua</option>
            <option value='Sudah' <?php if($this->input->get('status_sidi')=='Sudah'){echo "selected";}?>>Sudah</option>
            <option value='Belum' <?php if($this->input->get('status_sidi')=='Belum'){echo "selected";}?>>Belum</option>
          </select>
      </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Sidi<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="input-group">
          <input type="text" class="form-control datepicker" id="tgl_sidi" name="tgl_sidi" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=$this->input->get('tgl_sidi');?>">
          <span class="input-group-btn">
            <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Tanggal akan menjadi '00-00-0000'" what="date">
              <i class="fa fa-undo"></i>
            </button>
          </span>
        </div>
      </div>
    </div>

    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Lahir<span class="required">*</span></label>
      <div class="col-md-4 col-sm-4 col-xs-5">
        <input class="form-control" id="tahun_dari" name="tahun_dari" placeholder="dari (1990)" value="<?=$this->input->get('tahun_dari');?>">
      </div>
      <div class="col-md-4 col-sm-4 col-xs-5">
        <input class="form-control" id="tahun_sampai" name="tahun_sampai"  placeholder="sampai (1990)" value="<?=$this->input->get('tahun_sampai');?>">
      </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="sts_angjem" name="sts_angjem" >
            <option value='1' <?php if($sts_angjem=='1'){echo 'selected';}?> >Aktif</option>
            <option value='0' <?php if($sts_angjem=='0'){echo 'selected';}?> >Tidak Aktif</option>
          </select>
      </div>
    </div>
    <div class="form-group col-xs-12">
    	<a class="btn btn-warning pull-left" href="<?=base_url();?>report/anggota_jemaat/baptis_sidi?<?=$_SERVER['QUERY_STRING'];?>&export=print" target="_BLANK"><i class="fa fa-print"></i> Print</a>
      <input type="submit" class="btn btn-primary pull-right" value="Cari" name="search">
    </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
    });
  })
</script>