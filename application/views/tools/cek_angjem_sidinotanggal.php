<table>
  <tr>
    <th>#</th>
    <th>Wilayah</th>
    <th>Keluarga</th>
    <th>Nama Lengkap</th>
    <th>Status Sidi</th>
    <th>Tgl Sidi</th>
  </tr>
  <?php 
  $last_kwg='';
    foreach ($angjem as $key => $value) {
      // code...
      $sidi='';
      $tglsidi='';
      if($value->status_sidi){
        $sidi='Sudah';
      }
      if($value->tgl_sidi!='' && $value->tgl_sidi!='0000-00-00'){
        $tglsidi=date('d M Y', strtotime($value->tgl_sidi));
      }

      $kwg='';
      if($last_kwg!=$value->kwg_no){
        $kwg=$value->kwg_nama;
      }
  ?>
      <tr>
        <td><?=$key+1;?></td>
        <td>Wil. <?=$value->kwg_wil;?></td>
        <td><?=$kwg;?></td>
        <td><?=$value->nama_lengkap;?></td>
        <td><?=$sidi;?></td>
        <td><?=$tglsidi ;?></td>
      </tr>
  <?php 
      $last_kwg=$value->kwg_no;
    }
  ?>
</table>