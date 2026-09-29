<form class="form-horizontal form-label-left" action="" method="GET">
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Anggota<span class="required">*</span></label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
	        <input type="text" class="form-control" name="nama_anggota" value="<?=rawurldecode($this->input->get('nama_anggota'));?>">
	  	</div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
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
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Saldo<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="saldo" name="saldo" >
            <option value='' >Semua</option> 
            <option value='-1' <?php if($this->input->get('saldo')=='-1') echo "selected" ;?>>Ada Tunggakan</option>
            <option value='0' <?php if($this->input->get('saldo')=='-1') echo "selected" ;?>>Lunas</option>
          </select>
      </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Sort ([A-Z][0-9])<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="sort" name="sort" >
            <option value='' >Nama</option> 
            <option value='-1' <?php if($this->input->get('sort')=='-1') echo "selected" ;?> >Saldo (Terkecil)</option>
            <option value='0' <?php if($this->input->get('sort')=='0') echo "selected" ;?> >Saldo (Terbesar)</option>
          </select>
      </div>
    </div>
    <div class="form-group col-xs-12">
      <!--<a class="btn btn-warning pull-left" href="#modal_checkField" id="btn_checkFieldPrint"><i class="fa fa-print"></i> Print</a>-->
      <a class="btn btn-danger pull-left" href="<?=base_url();?>Pemakaman/laporan_saldo_anggota_kpkp/?<?=$_SERVER['QUERY_STRING'];?>&export=pdf" target="_BLANK"><i class="fa fa-file-pdf-o"></i> PDF</a>
    	<input type="submit" class="btn btn-primary pull-right" value="Cari" name="search">
    </div>
</form>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_checkField">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content" id="modal-content_print">
      <div class="modal-header">
        <h4>Pilih Data yang Akan Ditampilkan</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <form id="form_field" action="<?=base_url();?>report/anggota_jemaat/?<?=$_SERVER['QUERY_STRING'];?>&export=print" method="POST" target="_BLANK">
              <input name="param" type="hidden">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tgl_lahir#Tanggal Lahir">Tanggal Lahir
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tmpt_sidi#Tempat Baptis">Tempat Sidi
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tgl_sidi#Tanggal SIDI">Tanggal Sidi
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tmpt_baptis#Tempat Baptis">Tempat Baptis
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tgl_baptis#Tanggal Baptis">Tanggal Baptis
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tmpt_nikah#Tanggal Menikah">Tempat Menikah
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="tgl_nikah#Tanggal Menikah">Tanggal Menikah
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="telepon#Telepon">Telepon
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="field[]" value="kd_group_id#Kategory Pelayanan">Kategory Pelayanan
                </label>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn btn-warning pull-left" id="btn_exec_print" target="_BLANK"><i class="fa fa-print"></i> Print</div>
      </div>
    </div>
  </div>
</div>