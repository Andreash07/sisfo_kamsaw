<?php $this->load->view('layout/header'); ?>
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.0/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.css" rel="stylesheet" integrity="sha384-eZlplTHZHKCt8IkuN6tjrGBm+++iLYntms+lz6jkOUakaxdmjKxQswceH1LbirZr" crossorigin="anonymous">
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="x_panel">
        <?php $this->load->view('kpkp/filter_tahunan'); ?>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h4>Data Blok Makam</h4>
        </div>
        <div style="display: flex; gap: 2rem;">
        </div>
        <table class="table" id="table_blok_makam">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Lokasi</th>
              <th class="text-center">Blok (kavling)</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Penghuni</th>
              <th class="text-center">Saldo</th>
              <th class="text-center">Rincian</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $key => $d): ?>
              <?php 
                $sts_keanggotaan_makam='GKP Kampung Sawah';
                if($d->sts_keanggotaan_makam==2){
                  $sts_keanggotaan_makam='Non ('.$d->keanggotaan_makam.')';
                }else if($d->sts_keanggotaan_makam==0){
                  $sts_keanggotaan_makam='<b class="text-danger">Belum diketahui</b>';
                }
              ?>
              <tr>
                <td class="text-center"><?= $key+1; ?></td>
                <td class="text-center"><?= $d->lokasi ?></td>
                <td class="text-center">
                  <a href="<?= base_url(); ?>kpkp/detail_iuran_tahunan?id=<?= $d->id ?>">
                    <button
                      class="btn btn-default btn-sm"
                      data-toggle="tooltip"
                      data-placement="bottom"
                      title="detail blok">
                      <?= $d->blok . $d->kavling ?>
                    </button>
                  </a>
                </td>
                <td class="text-center"><?= $d->jumlah_makam ?></td>
                <td class="text-left">
                  <!-- penghuni blok makam-->
                  <ol style="padding-left: 10px;">
                  <?php
                  if(isset($penghuni_makam[$d->id])){
                    foreach ($penghuni_makam[$d->id] as $key2 => $value2) {
                    // code...
                  ?>
                      <li><?=$value2->nama;?></li>
                  <?php
                    } 
                  }
                  ?>
                  </ol>
                </td>
                <td class="text-center"><?=$d->saldo;?></td>
                <td class="text-left">
                  <!-- rincian blok makam-->
                  <b>Keanggotaan:</b> <?= $sts_keanggotaan_makam;?> 
                  <br>
                  <b>Tahun Tertampung:</b> <?= $d->tahun_tercover;?> 
                  <br>
                  <b>Tgl Penerimaan Iuran:</b> <?= $d->tgl_terakhir_bayar;?> 
                  <br>
                </td>
                <td class="text-center">
                  <?php if ($d->status == 1): ?>
                    Aktif
                  <?php else: ?>
                    Non Aktif
                  <?php endif; ?>
                </td>
                <td class="text-center">
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('layout/footer'); ?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.0/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.js" integrity="sha384-qjhFxzk66oKUXIYCVboqAL4Rltw1UDdDP5IHbsgDdH83uVKkvB+fFOwJcm9P7Nwb" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_blok_makam').DataTable({
      responsive: true,
      buttons: [
        'copy', 'excel', 'pdf'
      ],
      layout: {
          topStart: 'buttons'
      }
    });
  })
  $('#cari-data-makam').click(function() {
    const blok = $('#cari-data-makam-blok').val();
    const kavling = $('#cari-data-makam-kavling').val();
    const url = `<?= base_url(); ?>kpkp/iuran_tahunan?blok=${blok}&kavling=${kavling}`;
    $.ajax({
      url,
      type: 'GET',
      success: function(data) {
        window.location.href = url;
      }
    });
  })
</script>