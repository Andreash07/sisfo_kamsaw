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

      <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Bakal Calon<span class="required">*</span></label>

      <div class="col-md-9 col-sm-9 col-xs-12">

          <select class="form-control" id="status_pn1" name="status_pn1" >

            <option value='' >Semua</option>

            <option value='1' <?php if($this->input->get('status_pn1')=='1'){echo "selected";}?>>Dapat Dipilih</option>

            <option value='-1' <?php if($this->input->get('status_pn1')=='-1'){echo "selected";}?>>Tidak Dapat Dipilih</option>

          </select>

      </div>

    </div>

    <div class="form-group col-md-6 col-xs-12">

      <label class="control-label col-md-3 col-sm-3 col-xs-12">Seleksi Kriteria<span class="required">*</span></label>

      <div class="col-md-9 col-sm-9 col-xs-12">

          <select class="form-control" id="seleksi_status" name="seleksi_status" >

            <option value='' >Semua</option>

            <option value='1' <?php if($this->input->get('seleksi_status')=='1'){echo "selected";}?>>Termasuk Kriteria</option>

            <option value='-1' <?php if($this->input->get('seleksi_status')=='-1'){echo "selected";}?>>Tidak Termasuk Kriteria</option>

          </select>

      </div>

    </div>

    <div class="form-group col-xs-12">

      <a class="btn btn-warning pull-left" href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/print?'.$_SERVER['QUERY_STRING'];?>"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</a>

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