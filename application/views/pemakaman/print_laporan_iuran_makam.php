<body >
<style type="text/css">
@media print {
  table{
    
  }
  th{
    border: 1px #000 solid !important; 
  }
  td{
    
  }

  table{
    border: 1px #000 solid;
    border-collapse: collapse
  }
  th{
    border: 1px #000 solid;
  }
  td{
    border: 1px #000 solid;
  }
}
table{
    border: 1px #000 solid;
    border-collapse: collapse
  }
  th{
    border: 1px #000 solid;
  }
  td{
    border: 1px #000 solid; 
  }

  .text-right{
    text-align: right;
  }
  .text-center{
    text-align: center;
  }
  .text-left{
    text-align: left;
  }
</style>
<button onclick="window.print();" style="width:100px; display:block;">Print</button>
<span>Menampilkan <b><?=count($iuran_anggota);?> (<?=date('d M Y', strtotime($datef));?> s/d <?=date('d M Y', strtotime($datet));?>)</b></b></span>
<table class='table table-striped' cellmargin="0" cellpadding="0" style="border: 1px #000 solid !important; border-collapse: collapse;">
  <thead>
    <tr>
      <th class='text-center'>#</th>
      <th class='text-center' >Tanggal</th>
      <th class='text-center'>Lokasi Blok</th>
      <th class='text-center'>Nama Makam</th>
      <th class='text-center' style="width: 20%;">Nominal</th>
      <th class='text-center' style="width: 20%;">Tahun Tercover</th>
    </tr>
  </thead>

  <tbody>
<?php
$i=1;
$total_iuran=0;
foreach ($iuran_anggota as $key => $value) {
  #print_r($value);
  # code...
  $total_iuran=$total_iuran+$value->nominal;
  $color_tahun='';
  if($value->tahun_tercover < date('Y')){
    $color_tahun=' red';
  }
  else if($value->tahun_tercover > date('Y')){
    $color_tahun=' green';
  }
?>

    <tr>

      <td class='text-center'><?=$i;?></td>
      <td class='text-center'><?=date('d-m-Y', strtotime($value->tgl_bayar));?></td>
      <td class='text-center'><?=$value->blok;?> <?=$value->kavling;?></td>
      <td>
        <b><?=$value->penghuni_makam;?></b><br>
        <span>asal Gereja: <b><?=$value->keanggotaan_makam;?></b></span>
      </td>
      <td class='text-right'><?=number_format($value->nominal,0,",",".");?></td>
      <td class='text-center' style="color:<?=$color_tahun;?>"><?=$value->tahun_tercover;?></td>

    </tr>

<?php
  $i++;
}

?>
  <th colspan="4" class="text-right">Total</th>
  <th class="text-right"><?=number_format($total_iuran,0,",",".");?></th>
  <th></th>

  </tbody>
</table>
</body>