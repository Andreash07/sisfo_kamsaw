<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">

  <div class="row">

    <div class="col-xs-12">

      <div class="x_panel">

        <?php

        $this->load->view('pemakaman/searchbox_laporan_makam');

        ?>

      </div> 

    </div>

    <div class="col-xs-12">

      <div class="x_panel">

        <span>Menampilkan <b><?=count($iuran_anggota);?> (<?=date('d M Y', strtotime($datef));?> s/d <?=date('d M Y', strtotime($datet));?>)</b></b></span>

        <table class='table table-striped'>

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
            $color_tahun=' text-danger';
          }
          else if($value->tahun_tercover > date('Y')){
            $color_tahun=' text-success';
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
              <td class='text-center <?=$color_tahun;?>'><?=$value->tahun_tercover;?></td>

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

      </div>

    </div>

  </div>

</div>

<?php

$this->load->view('layout/footer');

?>

<script type="text/javascript">

  $(document).on('click', '[id=btn_exec_print]', function(e){
    $('#form_field').submit();
  })

  $(document).on('click', '[id=btn_checkFieldPrint]', function(e){
    e.preventDefault()
    $('#modal_checkField').modal('show');
  })

  $(document).on('click', '[id=editAnggota]', function(e){

    url=$(this).attr('href');

    $.get(url, function(data){

      $('#modal-content').html(data)

    })

  })

</script>