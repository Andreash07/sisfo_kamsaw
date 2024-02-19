<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th class="text-center" style="width: 150px;">Tanggal</th>
      <th class="text-center">Transaksi</th>
      <!--<th>Jumlah Iuran</th>-->
      <th class="text-center">Nominal</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      foreach ($data as $key => $value) {
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
          <th class="text-center" scope="row"><?=$key+1;?></th>
          <td class="text-center" style="width: 150px;"><?=convert_tgl_dMY($value->tgl_bayar);?></td>
          <td><?=$name;?></td>
          <td class="text-center"><?=$nominal;?></td>
        </tr>
    <?php
      }
    ?>
  </tbody>
</table>