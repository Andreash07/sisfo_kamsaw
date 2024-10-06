<body style="width:874px; padding-left:17px; padding-right:17px;">
  
<table cellpadding="0" cellspacing="0" style="border:1px solid #000; width: 100%; border-radius: 7px 7px 7px 7px ;">
<?php 
foreach ($KK as $key => $value) {
  // code...
?>  
  <tr>
    <th style="text-align: right; padding-bottom: 2px; padding-top: 5px;">Nama Keluarga</th>
    <th>:</th>
    <th style="text-align: left;"><?=$value->kwg_nama?></th>
  </tr>
  <tr>
    <th style="text-align: right; padding-bottom: 2px; padding-top: 5px;">Jumlah Jiwa</th>
    <th>:</th>
    <th style="text-align: left;"><?=$value->num_jiwa?></th>
  </tr>
  <tr>
    <th style="text-align: right; padding-bottom: 2px; padding-top: 5px;">Saldo Akhir*</th>
    <th>:</th>
    <th style="text-align: left;">Rp. <?=number_format($value->saldo_akhir,0,",",".") ?></th>
  </tr>
  <tr>
    <th style="text-align: right; padding-bottom: 2px; padding-top: 5px;">Saldo Akhir (Sukarela)*</th>
    <th>:</th>
    <th style="text-align: left;">Rp. <?=number_format($value->saldo_akhir_sukarela,0,",",".") ?></th>
  </tr>
<?php 
} 
?>
</table>

<h3>Rekap Transaksi Iuran KPKP</h3>
<table cellpadding="0" cellspacing="0" style="border:0px solid #000; width: 100%;">
  <thead>
    <tr>
      <th style="border:1px solid #000; border-radius: 7px 0px 0px 0px ;">#</th>
      <th style="width: 150px; border:1px solid #000;">Tanggal</th>
      <th style="border:1px solid #000;">Transaksi</th>
      <th style="border:1px solid #000; border-radius: 0px 7px 0px 0px ;">Nominal</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      foreach ($mutasi_transaksi as $key => $value) {
        // code...
        if($value->note!=''){
          $value->note="<br><label style='font-size:9pt; font-weight: 700;'>".$value->note."</label>";
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
              $name="Pembayaran Iuran".$value->note;
            break;
          case '3':
            // code...
              $name="Setor Sukarela";
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
        <td style="text-align: center; padding-bottom: 2px; padding-top: 5px;"><?=$key+1;?></td>
        <td style="text-align: center; width: 150px; padding-bottom: 2px; padding-top: 5px;"><?=convert_tgl_dMY($value->tgl_bayar);?></td>
        <td style="text-align: left; padding-bottom: 2px; padding-top: 5px;"><?=$name;?></td>
        <td style="text-align: right; padding-bottom: 2px; padding-top: 5px;"><?=$nominal;?></td>
      </tr>
    <?php 
      }
    ?>
  </tbody>
</table>
</body>
<script type="text/javascript">
  window.print();
</script>