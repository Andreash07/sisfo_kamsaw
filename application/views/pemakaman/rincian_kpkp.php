<?php 
//hitung estimasi bulan terkover
$est_bulanTercover=countBulanTercover($total_biayaKPKP, $data->saldo_akhir, date('Y-m'));
?>

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Saldo Akhir<span class="required">*</span>
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input class="form-control col-md-7 col-xs-12" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=number_format($data->saldo_akhir,0,",",".");?>" disabled>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Saldo Akhir (Sukarela)<span class="required">*</span>
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-md-7 col-xs-12" value="<?=number_format($data->saldo_akhir_sukarela,0,",",".");?>" disabled>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_alamat">Estimasi Bulan Tercover
  </label>

  <div class="col-md-6 col-sm-6 col-xs-12">
    <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-md-7 col-xs-12" value="<?=$est_bulanTercover['num_month'];?> Bulan (<?=$est_bulanTercover['month'];?>)" disabled>
  </div>
</div>

<div class="form-group">
  <label for="kwg_telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Beban Iuaran per Bulan</label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input id="kwg_telepon" name="kwg_telepon" class="form-control col-md-7 col-xs-12" type="text" value="<?= number_format($total_biayaKPKP,0,",",".");?>" disabled>
  </div>
</div>

<?php
  if($data->last_pembayaran!=null && $data->last_pembayaran !='0000-00-00'){
    $data->last_pembayaran=convert_tgl_dMY($data->last_pembayaran);
  }
  else{
    $data->last_pembayaran='-';
  }
?>
<div class="form-group">
  <label for="kwg_telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Terakkhir Pembayaran</label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input id="kwg_telepon" name="kwg_telepon" class="form-control col-md-7 col-xs-12" type="text" value="<?=$data->last_pembayaran;?>" disabled>
  </div>
</div>