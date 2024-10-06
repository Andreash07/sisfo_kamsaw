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
</style>
<button onclick="window.print();" style="width:100px; display:block;">Print</button>
<span>Menampilkan <b><?=count($iuran_anggota);?> (<?=date('d M Y', strtotime($datef));?> s/d <?=date('d M Y', strtotime($datet));?>)</b></b></span>
<table class='table table-striped' cellmargin="0" cellpadding="0" style="border: 1px #000 solid !important; border-collapse: collapse;">
  <thead>
    <tr>
      <th class='text-center'>#</th>
      <th class='text-center' >Tanggal</th>
      <th class='text-center'>Nama Keluarga</th>
      <th class='text-center' style="width: 20%;">Iuran Wajib (IDR)</th>
      <th class='text-center' style="width: 20%;">Iuran Sukarela (IDR)</th>
      <th class='text-center' style="width: 20%;">Total Nominal (IDR)</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
      $total_wajib=0;
      $total_sukarela=0;
      foreach ($iuran_anggota as $key => $value) {
        //print_r($value);
        # code...
        $total_wajib=$total_wajib+$value['wajib'];
        $total_sukarela=$total_sukarela+$value['sukarela'];
      ?>

          <tr>

              <td class='text-center'><?=$i;?></td>
              <td ><?=date('d-m-Y', strtotime($value['tgl_bayar']));?></td>
              <td style="width: 20%;"><?=$value['kwg_nama'];?></td>

              <td class='text-center'><?=number_format($value['wajib'],0,",",".");?></td>
              <td class='text-center'><?=number_format($value['sukarela'],0,",",".");?></td>
              <td class='text-center'><?=number_format($value['total'],0,",",".");?></td>

            </tr>

      <?php
        $i++;
      }

      ?>
      <tr>
        <th colspan="3" class="text-right">Total</th>
        <th class="text-center"><?=number_format($total_wajib,0,",",".");?></th>
        <th class="text-center"><?=number_format($total_sukarela,0,",",".");?></th>
        <th class="text-center"><?=number_format($total_wajib+$total_sukarela,0,",",".");?></th>
      </tr>
  </tbody>
</table>
</body>