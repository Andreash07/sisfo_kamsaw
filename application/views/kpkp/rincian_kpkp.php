<form class="form-horizontal form-label-left" style="font-size: 11px;">
  <?php 
  //hitung estimasi bulan terkover
  $est_bulanTercover=countBulanTercover($total_biayaKPKP, $data->saldo_akhir, date('Y-m'));
  ?>

  <div class="form-group row" style="margin-bottom: 0.5rem; height: 30px;">
    <label class="control-label col-4" for="kwg_nama">Nama KK<span class="required">*</span>
    </label>
    <div class="col-8">
      <input class="form-control col-12" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=$nama_kk;?>" disabled style="font-size: 16px;  height: 30px;">
    </div>
  </div>
  <div class="form-group row" style="margin-bottom: 0.5rem; height: 30px;">
    <label class="control-label col-4" for="kwg_nama">Jumlah Anggota KPKP<span class="required">*</span>
    </label>
    <div class="col-8">
      <input class="form-control col-12" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=number_format($num_anggota,0,",",".");?>" disabled style="font-size: 16px;  height: 30px;">
    </div>
  </div>

  <div class="form-group row" style="margin-bottom: 0.5rem; height: 30px;">
    <label class="control-label col-4" for="kwg_nama">Saldo Akhir<span class="required">*</span>
    </label>
    <div class="col-8">
      <input class="form-control col-12" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=number_format($data->saldo_akhir,0,",",".");?>" disabled style="font-size: 16px;  height: 30px;">
    </div>
  </div>

  <div class="form-group row" style="margin-bottom: 0.5rem;  height: 30px;">
    <label class="control-label col-4" for="kwg_nama">Saldo Akhir (Sukarela)<span class="required">*</span>
    </label>
    <div class="col-8">
      <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-12" value="<?=number_format($data->saldo_akhir_sukarela,0,",",".");?>" disabled style="font-size: 16px; height: 30px;">
    </div>
  </div>

  <div class="form-group row" style="margin-bottom: 0.5rem;  height: 30px;">
    <label class="control-label col-4" for="kwg_alamat">Estimasi Bulan Tertampung
    </label>

    <div class="col-8">
      <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-12" value="<?=$est_bulanTercover['num_month'];?> Bulan (<?=$est_bulanTercover['month'];?>)" disabled style="font-size: 16px; height: 30px; ">
    </div>
  </div>

  <div class="form-group row" style="margin-bottom: 0.5rem;  height: 30px;">
    <label for="beban_iuran_perbulan" class="control-label col-4">Beban Iuaran per Bulan</label>
    <div class="col-8">
      <input id="beban_iuran_perbulan" name="beban_iuran_perbulan" class="form-control col-12" type="text" value="<?= number_format($total_biayaKPKP,0,",",".");?>" disabled style="font-size: 16px; height: 30px;">
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
  <div class="form-group row" style="margin-bottom: 0.5rem; height: 30px;">
    <label for="kwg_telepon" class="control-label col-4">Tanggal Terakkhir Penyetoran</label>
    <div class="col-8">
      <input id="kwg_telepon" name="kwg_telepon" class="form-control col-12" type="text" value="<?=$data->last_pembayaran;?>" disabled style="font-size: 16px; height: 30px;">
    </div>
  </div>
</form>



<table class="table table-striped" style="padding: .25rem; font-size: 11px;">
  <thead>
    <tr>
      <th class="text-center" style="padding: .25rem; font-size: 11px;">#</th>
      <th class="text-center" style="padding: .25rem; font-size: 11px;">Tanggal</th>
      <th class="text-center" style="padding: .25rem; font-size: 11px;">Transaksi</th>
      <!--<th>Jumlah Iuran</th>-->
      <th class="text-center" style="padding: .25rem; font-size: 11px;">Nominal</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      foreach ($mutasiiuran_kpkp as $key => $value) {
        // code...
        if($value->note!=''){
          $value->note="<br><label style='font-size:9pt;'>".$value->note."</label>";
        }
        switch ($value->type) {
          case '0':
            // code...
              $name="Saldo Awal";
            break;
          case '1':
            // code...
              $name="Setor Iuran";
            break;
          case '2':
            // code...
              $name="Pembayaran Iuran ".$value->note;
            break;
          case '3':
            // code...
              $name="Setor Sukarela".$value->note;
            break;
          default:
            // code...
              $name="<i class='text-danger'>Tidak diketahui</i>";
            break;
        }

        $nominal=number_format($value->nominal,0,",",".");
        if($value->nominal>0){
          $nominal='<span class="text-success">+'.number_format($value->nominal,0,",",".")."</span>";
        }
        else if($value->nominal<0){
          $nominal='<span class="text-danger">'.number_format($value->nominal,0,",",".")."</span>";
        }
    ?>
        <tr>
          <th class="text-center" scope="row" style="padding: .25rem; font-size: 11px;"><?=$key+1;?></th>
          <td class="text-center" style="padding: .25rem; font-size: 11px;"><?=convert_tgl_dMY($value->tgl_bayar);?></td>
          <td style="padding: .25rem; font-size: 11px;"><?=$name;?></td>
          <td class="text-center" style="padding: .25rem; font-size: 11px;"><?=$nominal;?></td>
        </tr>
    <?php
      }
    ?>
  </tbody>
</table>