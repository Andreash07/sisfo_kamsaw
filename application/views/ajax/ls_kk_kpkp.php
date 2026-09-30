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
        <th>Surat</th>
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
            <td>
              <a href="<?=base_url();?>Pdf/SuratPemberitahuanIuranWajibKPKP/<?=md5('*(2791bjaksdk'.$value->keluarga_jemaat_id);?>" class="btn btn-danger btn-sm" title="Surat Pemberitahuan Iuran" target="_BLANK"><i class="fa fa-file-pdf-o"></i></a>
            </td>
          </tr>


      <?php
        }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>