<form class="form-horizontal form-label-left" action="" method="GET">
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Anggota<span class="required">*</span></label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
	        <input type="text" class="form-control" name="nama_anggota" value="<?=rawurldecode($this->input->get('nama_anggota'));?>">
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
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Metode Pemilihan<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="methode_pemilihan" name="methode_pemilihan" >
            <option value='-1' >Semua</option>
            <option value='0' <?php if($this->input->get('methode_pemilihan')=='0'){echo "selected";}?>>Online</option>
            <option value='1' <?php if($this->input->get('methode_pemilihan')=='1'){echo "selected";}?>>Konvensional</option>
          </select>
      </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Pemilihan<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <select class="form-control" id="tahunpemilihan" name="tahunpemilihan" >
            <?php 
            foreach ($tahun_pemilihan_semua as $key => $value) {
              // code...
            ?>
              <option value='<?=$value->tahun;?>' <?php if($value->tahun == $tahunpemilihan){ echo 'selected'; } ?> ><?=$value->tahun;?> (<?=$value->periode;?>)</option>
            <?php 
            }
            ?>
          </select>
      </div>
    </div>
    <div class="form-group col-xs-12">
    	<input type="submit" class="btn btn-primary pull-right" value="Cari" name="search">
      <a class="btn btn-danger pull-right" inasdk="<?=base_url();?>pnppj/penetapan_peserta_pemilihan?tahun_pemilihan=<?=$tahunpemilihan;?>" id="btn_penetapan_peserta" tahun_pemilihan="<?=$tahunpemilihan;?>" title="Penetapan Peserta Pemilihan <?=$tahunpemilihan;?>"><i class="fa fa-lock"></i>&nbsp;&nbsp;Penetapan</a>

      <a class="btn btn-warning pull-left" href="<?=base_url();?>pdf/suratsuarappj.php?tahunpemilihan=<?=$tahunpemilihan;?>" target="_BLANK"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak Surat Suara PPJ</a>
      <a class="btn btn-success pull-left" href="<?=base_url();?>pdf/suratsuarapnt1.php?tahunpemilihan=<?=$tahunpemilihan;?>" target="_BLANK"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak Surat Suara PNT-I</a>
      <a class="btn btn-danger pull-left" href="<?=base_url();?>pdf/suratsuarapnt2.php?tahunpemilihan=<?=$tahunpemilihan;?>" target="_BLANK"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak Surat Suara PNT-II</a>
    </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
    });
  })
</script>