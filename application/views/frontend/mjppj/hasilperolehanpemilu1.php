<?php 

$this->load->view('frontend/layouts/header_public');

?>

<?php 

  $NumAngjem=0;

  $total_voted=0;

  if(isset($num_angjem[$kwg_wil])){

    $NumAngjem=$num_angjem[$kwg_wil]->num_angjem;

  }
?>

<style type="text/css">

  .cutline1{

    padding: unset;

    -webkit-box-orient: vertical;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: normal;

    -webkit-line-clamp: 1;

    display: -webkit-box !important;

  }

</style>

<div class="container-fluid mt-4" style="min-height: 600px; position: relative;">

  <div class="row align-items-center">

    <div class="col-12 text-center" style="margin: auto;">
      <label for="hasil_wil" style="margin-bottom: 17px;">Hasil dari Wilayah</label>
      <select id="hasil_wil" class="form-control" style="float: right; clear: both; margin-top:-15px;">
        <option value="">Pilih Wilayah</option>
        <option value="1" <?php if($kwg_wil==1){ echo "selected";} ?>>Wil 1</option>
        <option value="2" <?php if($kwg_wil==2){ echo "selected";} ?>>Wil 2</option>
        <option value="3" <?php if($kwg_wil==3){ echo "selected";} ?>>Wil 3</option>
        <option value="4" <?php if($kwg_wil==4){ echo "selected";} ?>>Wil 4</option>
        <option value="5" <?php if($kwg_wil==5){ echo "selected";} ?>>Wil 5</option>
        <option value="6" <?php if($kwg_wil==6){ echo "selected";} ?>>Wil 6</option>
        <option value="7" <?php if($kwg_wil==7){ echo "selected";} ?>>Wil 7</option>
      </select>


      <h2 style="display:block;clear: both;">Perolehan Suara<br>Penatua Tahap 1 (Wil. <?=$kwg_wil;?>)</h2>

    </div>

    <div class="col-12" style="margin: auto;">

      <span class="small" style="display:block;"><b>Peserta Pemilihan</b>: <?=$NumAngjem;?> ( @ <?=$slot_vote;?> Hak Suara)</span>
      <span class="small" style="display:block;"><b>Peserta yang Sudah Memilih</b>: <?=$peserta->peserta_pemilihan;?> / <?=$NumAngjem;?> (<b class="text-danger"><?= round($peserta->peserta_pemilihan/$NumAngjem *100, 2);?></b>%) </span>
      <span class="small" style="display:block;"><b>Total Suara Masuk</b>: <span id="lbl_indeks"><i class="fa fa-circle-o-notch fa-spin"></i> <i>menghitung suara...</i></span></span>



      <a href="<?=base_url();?>pnppj/hasilpemilu1?wil=<?=$kwg_wil?>" class="btn btn-sm btn-icon btn-danger float-right" title="Hasil Perolehan Suara Sementar"><span class="btn-inner--icon"><i class="fa fa-refresh  fa-spin fa-fw" style="top:unset;"></i></span></a>

    </div>

  </div>

  <div class="row">

    <div class="col-sm-12">

      <table class="table">

        <thead>

          <tr>

            <th class="text-center">#</th>

            <th class="text-center" style="width: 60% !important;">Nama Calon</th>

            <th class="text-center">Suara</th>

          </tr>

        </thead>

        <tbody>

          <?php 

            if(!isset($voted_wil[$kwg_wil])){

              $voted_wil[$kwg_wil]=array();

            }



            if(isset($voted_wil[$kwg_wil]) && count($voted_wil[$kwg_wil]) > 0){

              foreach ($voted_wil[$kwg_wil] as $keyvoted => $valuevoted) {

              // code...

              $ico_gender='<i class="fa fa-female" style="font-size:12pt;"></i>';

              $color_gender="bg-gradient-red";

              $title="Ibu ";

              if($valuevoted->sts_kawin==1){

                $title="Sdri. ";

              }



              if(mb_strtolower($valuevoted->jns_kelamin)=='l'){

                $color_gender="bg-gradient-blue";

                $ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';

                $title="Bp. ";

                if($valuevoted->sts_kawin==1){

                  $title="Sdr. ";

                }

              }



              $percent=$valuevoted->voted/$NumAngjem*100;

              $total_voted=$total_voted+$valuevoted->voted;

          ?>

              <tr>

                <td class="text-center" style=" vertical-align:middle;"><?=$keyvoted+1;?></td>

                <td style="width: 60% !important; font-size: 12px; white-space:unset;  vertical-align:middle;"><?=$title.$valuevoted->nama_lengkap;?></td>

                <td class="text-center">&nbsp;<?=$valuevoted->voted;?><br>(<?= round($percent,2);?>%)</td>

              </tr>

          <?php

              }

            }



            $index_voted=$total_voted/$max_suara_masuk*100;

          ?>

        </tbody>

      </table>

    </div>

  </div>

</div>



















<hr>

<?php 

$this->load->view('frontend/layouts/footer');

?>

<script type="text/javascript">

  $(document).ready(function(){

    setTimeout(function(){

      $('#lbl_indeks').html('<?=number_format($total_voted,0,",",".") ;?> / <?=number_format($max_suara_masuk,0,",",".");?> (<b class="text-danger"><?= round($index_voted,2);?>% </b>)')

    }, 1000)

  })

  $(document).on('change', '#hasil_wil', function(e){
    e.preventDefault();
    wil="";
    if($(this).val() !=0) {
      wil="?wil="+$(this).val()
    }
    window.location.href = "<?=base_url();?>pnppj/hasilpemilu1"+wil;
  })

</script>