<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">

  <div class="row">

    <div class="col-xs-12">

      <div class="x_panel">

        <?php

        $this->load->view('pemakaman/searchbox_laporan');

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
              <th class='text-center'>Nama Keluarga</th>
              <th class='text-center' style="width: 20%;">Iuran Wajib (IDR)</th>
              <th class='text-center' style="width: 20%;">Iuran Sukarela (IDR)</th>
              <th class='text-center' style="width: 20%;">Total Nominal (IDR)</th>
              <th class='text-center' style="width: 20%;">Kurang/Lebih Bayar (IDR)</th>

            </tr>

          </thead>

          <tbody>

        <?php
        $i=1;
        $total_wajib=0;
        $total_sukarela=0;
        $total_kuranglebihbayar=0;

        foreach ($iuran_anggota as $key => $value) {
          //print_r($value);
          # code...
          $bulan_tercover='-';
          $total_wajib=$total_wajib+$value['wajib'];
          $total_sukarela=$total_sukarela+$value['sukarela'];
          $total_kuranglebihbayar=$total_kuranglebihbayar+$value['saldo_akhir'];

          if(isset($num_anggota[$value['keluarga_jemaat_id']])){
            $total_biayaKPKP=$num_anggota[$value['keluarga_jemaat_id']]->num_kpkp * 5000;
            $est_tercover=countBulanTercover($total_biayaKPKP, $value['saldo_akhir'], date('Y-m')) ;
            $bulan_tercover=$est_tercover['month'];
          }
        ?>

            <tr>

              <td class='text-center'><?=$i;?></td>
              <td ><?=date('d-m-Y', strtotime($value['tgl_bayar']));?></td>
              <td style="width: 20%;"><?=$value['kwg_nama'];?></td>

              <td class='text-center'><?=number_format($value['wajib'],0,",",".");?></td>
              <td class='text-center'><?=number_format($value['sukarela'],0,",",".");?></td>
              <td class='text-center'><?=number_format($value['wajib']+$value['sukarela'],0,",",".");?></td>
              <td class='text-center'><?=number_format($value['saldo_akhir'],0,",",".");?> <br> (<?=$bulan_tercover;?>)</td>

            </tr>

        <?php
          $i++;
        }

        ?>
          <th colspan="3" class="text-right">Total</th>
          <th class="text-center"><?=number_format($total_wajib,0,",",".");?></th>
          <th class="text-center"><?=number_format($total_sukarela,0,",",".");?></th>
          <th class="text-center"><?=number_format($total_wajib+$total_sukarela,0,",",".");?></th>
          <th class="text-center"><?php //echo number_format($total_kuranglebihbayar,0,",",".");?></th>

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