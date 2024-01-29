<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Bulan</th>
      <th>Jumlah Iuran</th>
      <th>Tanggal </th>
    </tr>
  </thead>
  <tbody>
    <?php 
      foreach ($data as $key => $value) {
        // code...
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
              $name="Pembayaran Iuran";
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
          <th scope="row"><?=$key+1;?></th>
          <td><?=$name;?></td>
          <td><?=$nominal;?></td>
          <td><?=convert_tgl_dMY($value->tgl_bayar);?></td>
        </tr>
    <?php
      }
    ?>
  </tbody>
</table>