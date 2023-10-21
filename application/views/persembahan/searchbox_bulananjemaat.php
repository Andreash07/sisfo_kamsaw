<form class="form-horizontal form-label-left" action="" method="GET">
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">
        	Nomor Kartu
      	</label>
      	<div class="col-md-9 col-sm-9 col-xs-12">
        	<input type="text" class="form-control" name="no_kartu" value="<?=$this->input->get('no_kartu');?>">
      	</div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Anggota<span class="required">*</span></label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
	        <input type="text" class="form-control" name="nama_anggota" value="<?=rawurldecode($this->input->get('nama_anggota'));?>">
	  	</div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
    	<label class="control-label col-md-3 col-sm-3 col-xs-12">Periode<span class="required">*</span></label>
    	<div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="periode_id" name="periode_id" >
            <?php
              foreach (lsPeriode() as $lsWil => $valueWil) {
                # code...
            ?>
              <option value='<?=$valueWil->id;?>' <?php if($tahun_periode==$valueWil->id){echo 'selected';}?>><?=$valueWil->tahun;?></option>
            <?php
              }
            ?>
          </select>
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
    <div class="form-group col-xs-12">
      <?php 
      if($NumKartu==0){
      ?>
        <div id="btn_generatekartu" class="btn btn-warning pull-left">Generate Kartu <i class="fa fa-warning" ></i></div>
      <?php
      }
      ?>
      <input type="submit" class="btn btn-primary pull-right" value="Cari" name="search">
    </div>
</form>