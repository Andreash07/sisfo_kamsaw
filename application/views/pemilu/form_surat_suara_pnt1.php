<div class="col-xs-12">
	<div class="col-xs-12">
		<h5>SN Surat Suara: <?=$token;?> <i class="fa fa-check-circle text-success"></i></h5>
	</div>
	<div class="col-xs-12">
	<label class="text-muted" style="font-size:1em;">Anda sudah memilih <b id="lbl_num_pilihan">0</b> dari <b id="hak_suara"><?=$hak_suara;?></b> (<b id="lbl_num_pilihan_wanita"><?= $num_voted_wanita;?></b> dari <b id="hak_suara_wanita"><?=$hak_suara_wanita;?></b><b> Perempuan </b> dan <b id="lbl_num_pilihan_pria"><?= $num_voted_pria;?></b> dari <b id="hak_suara_pria"><?=$hak_suara_pria;?></b><b> Laki-laki</b>)
  </label>
  <div class="form-group row">
    <div class="col-xs-7">
      <label for="search-nama">Pencarian</label>
      <input type="text" name="search-nama" id="search-nama" class="form-control" placeholder="Ketik nama Calon">
    </div>
    <div class="col-xs-5">
      <label for="search-nama">&nbsp;</label>
      <select id="jns_kelamin" name="jns_kelamin" class="form-control">
        <option value="">Semua</option>
        <option value="laki-laki">Laki-laki</option>
        <option value="perempuan">Perempuan</option>
      </select>
    </div>
  </div>
	<form id="form_pemilihan" action="<?=base_url();?>pnppj/submit_pemilihan">
    <input type="hidden" name="token" id="token" value="<?=$token;?>">
    <input type="hidden" name="id_pemilih" id="id_pemilih" value="<?=$id_pemilih;?>">
    <input type="hidden" name="wil_pemilih" id="wil_pemilih" value="<?=$wil_pemilih;?>">
    <table id="tbl_calon_penatua" class="table table-striped">

      <thead>

        <tr>

          <th>#</th>

          <th>Nama Calon</th>
          <th>Jenis Kelamin</th>
        </tr>

      </thead>

      <?php 

      $num_voted=0;

      foreach ($calon as $key => $value) {

        # code...

        $ico_gender='<i class="fa fa-female text-danger" style="font-size:12pt;"></i>';

        $color_gender="bg-gradient-red";

        $title="Ibu ";
        $jns_kelamin="perempuan";

        if($value->sts_kawin==1){

          $title="Sdri. ";

        }

        if(mb_strtolower($value->jns_kelamin)=='l'){

          $color_gender="bg-gradient-blue";

          $ico_gender='<i class="fa fa-male text-primary" style="font-size:12pt;"></i>';

          $title="Bp. ";

          if($value->sts_kawin==1){

            $title="Sdr. ";

          }
          $jns_kelamin="laki-laki";

        }



        $checked="";

        if($value->voted>0){

          $checked='checked="checked"';

          $num_voted++;

        }



        $disabled="";
        $note_lock="";
        if($value->locked==1){

          $disabled="disabled";
          //<span class="badge badge-pill badge-danger">Danger</span>
          $note_lock='<span class="text-danger h6">Sudah Dikunci</span>';

        }

      ?>

        <tr>

          <td>

            <div class="custom-control custom-checkbox">

              <input type="checkbox" class="custom-control-input" name="calon_pn[]" id="calon_pn<?=$value->id;?>" value="<?=$value->id;?>#<?=$value->kwg_wil;?>" group_id="calon_pn" <?=$checked;?> <?=$disabled;?> jns_kelamin="<?=strtolower($value->jns_kelamin);?>">

              <label class="custom-control-label" for="calon_pn<?=$value->id;?>"></label>

            </div>

          </td>

          <td style="font-size:12px;" >
            <?=$ico_gender;?>
            <?=$title.ucwords($value->nama_lengkap);?>
            <br>
            <label class="text-muted"><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> tahun | Wilayah <?=$value->kwg_wil;?></label>&nbsp;&nbsp;<?= $note_lock;?>

          </td>
          <td>
            <?=$jns_kelamin;?>
          </td>
        </tr>

      <?php

      }

      ?>

    </table>

    <input type="hidden" name="num_voted" id="num_voted" value="<?=$num_voted;?>">
    <input type="hidden" name="num_voted_wanita" id="num_voted_wanita" value="<?=$num_voted_wanita;?>">
    <input type="hidden" name="num_voted_pria" id="num_voted_pria" value="<?=$num_voted_pria;?>">
	</form>
</div>
	<div class="col-xs-12">
		<button type="button" class="btn btn-primary" id="btn_kunciPilihan" onclick="event.preventDefault()">Kunci Pilihan</button>
	</div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    $('#lbl_num_pilihan').html('<?=$num_voted;?>');

    var table = $('#tbl_calon_penatua').DataTable({

      "lengthChange": false,
      "pageLength": 20,
      "columnDefs": [{
                "targets": [ 2 ],
                "visible": false
              }],
      "searching":true,
      "dom": 'lrtip'
    } );




    $('#jns_kelamin').on( 'change', function (e) {
       if (e.keyCode == 13) {
        e.preventDefault();
        return false;
      }

      jns_kelamin=$('#jns_kelamin').val();
      keyword=$('#search-nama').val()
      if(jns_kelamin!='' && jns_kelamin!=undefined){
        rebuild_table(keyword+' '+jns_kelamin)
      }
      else{
        rebuild_table(keyword)
      }
    });

    $('#search-nama').on( 'keyup change', function () {
      jns_kelamin=$('#jns_kelamin').val();
      keyword=$(this).val()
      if(jns_kelamin!='' && jns_kelamin!=undefined){
        rebuild_table(keyword+' '+jns_kelamin)
      }
      else{
        rebuild_table(keyword)
      }
    });

    function rebuild_table(param){
      console.log(param);
      $('#tbl_calon_penatua').DataTable().search(param).draw();
    }
  })

</script>