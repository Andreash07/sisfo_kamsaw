<div class="row">
<div class="col-xs-12">
<div class="col-xs-12">
  <h2 id="title_list_kpkp"><?=$title;?></h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama KK</th>
        <th>Wilayah</th>
        <th>Jumlah Bulan</th>
        <th>Nomimal (IDR)</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        foreach ($kk as $key => $value) {
          // code...
      ?>
          <tr>
            <td><?=$key+1;?></td>
            <td><?=$value->kwg_nama;?> (<?=$value->num_kpkp;?> Jiwa)</td>
            <td><?=$value->kwg_wil;?></td>
            <td><?=$value->bulan_tertampung;?> (<?=$value->nama_bulan_tertampung;?>)</td>
            <td><?=number_format($value->saldo_akhir,0,",",".");?></td>
          </tr>


      <?php
        }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>