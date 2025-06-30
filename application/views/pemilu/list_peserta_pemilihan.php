<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="x_panel">
        <?php
        $this->load->view('pemilu/searchbox_peserta_pemilihan');
        ?>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="text-success fa fa-mobile"></i></div>
            <div class="count" id="count_online"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            <h3>Online</h3>
          </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
              <div class="icon"><i class="text-danger fa fa-list-alt"></i></div>
              <div class="count" id="count_konven"><i class="fa fa-circle-o-notch fa-spin"></i></div>
              <h3>Konvensional</h3>
              <!--<p>Lorem ipsum psdea itgum rixt.</p>-->
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel">
        <span>Menampilakn <b><?=count($data_keluarga_jemaat);?></b> dari <b><?=$TotalOfData;?></b> <text class="text-danger">(Pemilihan Periode: <?=$tahun_pemilihan->periode;?>)</text></span>
        <?= $pagingnation; ?>
        <table class='table table-striped'>
          <thead>
            <tr>
              <th class='text-center'>#</th>
              <th class='text-center'>Nama</th>
              <th class='text-center' style="width: 30%;">Ulasan</th>
              <th class='text-center' style="width: 30%;">Action</th>
            </tr>
          </thead>
          <tbody>
        <?php
        $num_konvensional=0;
        $num_mobile=0;
        foreach ($data_keluarga_jemaat as $keykwg => $valuekwg) {
          $num_pemilih=0;
          if(!isset($data_jemaat[$valuekwg->kwg_no])){
            //ini bearti kwg no tersebut tidak ada anggota jemaat yang memiliki hak suara
            //hanya memastikan agar tidak ada error
            //continue;
          }
          $num_pemilih=count($data_jemaat[$valuekwg->kwg_no]);
          if($valuekwg->num_pemilih_konvensional == 0){
            //ini bearti memilih online
            $status_pemilihan="<span class='label label-success'>Memilih Secara Online - Aplikasi GKP Kp. Sawah</span>";
            $checked="checked";
          }
          else{
            $status_pemilihan="<span class='label label-danger'>Memilih Secara Konvensional - Mengisi Surat Suara</span>";
            $checked="";
          }
          ?>
              <tr>
                <td class='text-center'><?=$keykwg+$numStart+1;?></td>
                <td title="<?=$valuekwg->kwg_no;?>">
                  <?=$valuekwg->kwg_nama;?> (Wil. <?=$valuekwg->kwg_wil;?>) 
                  <br>
                  <b>No KK:</b> <?= $valuekwg->no_kk;?>
                  <br>
                  <b>Peserta Pemilihan: <?=$num_pemilih;?> </b>
                  <br>
                  <?=$status_pemilihan;?>
                </td>
                <td>
        <?php
          $ls_angjem_id=array();
          foreach ($data_jemaat[$valuekwg->kwg_no] as $key => $value) {
            # code...
            $ls_angjem_id[]=$value->id;
            if($value->jns_kelamin=='L'){
                      $jns_kelamin="Laki-laki";
                  }
                  else{
                      $jns_kelamin="Perempuan";
                  }
                  if($value->status_baptis=='1'){
                      $ico_status_baptis='<i class="fa fa-check-square text-success"></i>';
                  }
                  else{
                      $ico_status_baptis='<i class="fa fa-times text-danger"></i>';
                  }

                  if($value->status_sidi=='1'){
                      $ico_status_sidi='<i class="fa fa-check-square text-success"></i>';
                  }
                  else{
                      $ico_status_sidi='<i class="fa fa-times text-danger"></i>';
                  }

                  $status_seleksi=0;
                  $msg_seleksi='<label class="label label-danger"><i class="fa fa-times"></i> Tidak Termasuk Kriteria Dipilih</label>';
                  $tglCutoff="2026-04-03";
            if( $value->tgl_lahir == '0000-00-00'){
              $umurLahir=0;
              $umurLahir_lbl="<i style='color:white; background-color:red;'>-</i>";
            }else{
              $umurLahir=getUmur($tglCutoff, $value->tgl_lahir);
              $umurLahir_lbl=$umurLahir." th";
            }

            if( $value->tgl_sidi == '0000-00-00'){
              $umurSidi=0;
              $umurSidi_lbl="<i style='color:white; background-color:red;'>-</i>";
            }
            else{
              $umurSidi=getUmur($tglCutoff, $value->tgl_sidi);
              $umurSidi_lbl=$umurSidi." th";
            }
            if( $value->tgl_attestasi_masuk == '0000-00-00'){
              $umurAttesasi=0;
              $umurAttesasi_lbl="<i style='color:white; background-color:red;'>Lama</i>";
            }
            else{
              $umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);
              $umurAttesasi_lbl=$umurAttesasi." th";
            }


            if($value->status_seleksi==1){
              //cuma 1 karena hanya penyecekan sudah sidi apa belum
              $msg_seleksi='<label class="label label-success"><i class="fa fa-check-circle"></i> Memiliki Hak Suara</label>';
            }
          ?>
                  <b><?=$key+1;?>. </b>
                  <?=$value->nama_lengkap;?> (<b><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> Th</b>) - 
                  <b><?=$jns_kelamin;?></b>
                  <br>
                  <b><?=$value->hub_keluarga;?></b>
                  <br>
                  <b>Sidi: <?=$value->sidi_cocok;?> </b>
                  <br>
                  <?=$msg_seleksi;?>
                  <div class="divider"></div>
        <?php
          }

          $angjemid_pemilih=0;
          if(count($ls_angjem_id)>0){
            $angjemid_pemilih=implode(',', $ls_angjem_id);
          }

        ?>    
            </td>
            <td class='text-center' title="<?=$value->kwg_nama;?>">
              <div class="">
                <label>
                  <i class="fa fa-list-alt fa-2x " style="top: 8px; position: relative;" title="Konvensional"></i>&nbsp;&nbsp; 
                    <input type="checkbox" class="js-switch"  <?=$checked;?> recid="<?=$value->kwg_no;?>"  title="<?=$value->kwg_nama;?>"  angjemid_pemilih="<?=$angjemid_pemilih;?>" tahun_pemilihan="<?=$tahun_pemilihan->tahun;?>"  />
                  &nbsp;&nbsp; <i class="fa fa-mobile fa-2x text-success" style="top: 8px; position: relative;" title="Online"></i>
                </label>
              </div>
              </td>
            </tr>
        <?php
        }
        ?>
          </tbody>
        </table>
        <?= $pagingnation; ?>
      </div>
    </div>
  </div>
</div>
<?php
$this->load->view('layout/footer');
?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#count_konven').html('<?=$jemaatPesertaPemilihanKonvensional;?> &nbsp;<label style="font-size:12pt;">(<?=count($data_keluarga_jemaat_konvensional);?> KK)</label>')
    $('#count_online').html('<?=$jemaatPesertaPemilihanOnline;?> &nbsp;<label style="font-size:12pt;">(<?=count($data_keluarga_jemaat_online);?> KK)</label>')
  })


  $(document).on('click', '[id=editAnggota]', function(e){
    url=$(this).attr('href');
    $.get(url, function(data){
      $('#modal-content').html(data)
    })
  })
</script>

<script type="text/javascript">
  $(document).on('click', '[class=js-switch]', function(e){
    url="<?=base_url();?>pnppj/statusprosespemilihan";
    dataMap={}
    dataMap['recid']=$(this).attr('recid')
    dataMap['angjemid_pemilih']=$(this).attr('angjemid_pemilih')
    dataMap['tahun_pemilihan']=$(this).attr('tahun_pemilihan')
    if($(this).prop('checked') == true){
        //alert("checking");
          dataMap['locked']=0 //calon pemilih memilih secara ONLINE
          txt="Apakah Anda yakin Kel. "+$(this).attr('title')+" akan Melakukan Proses Pemilihan secara ONLINE (dengan Aplikasi)?";
      }else{
        //alert("unchecking");
          dataMap['locked']=1 //calon pemilih memilih secara offline
          txt="Apakah Anda yakin Kel. "+$(this).attr('title')+" akan Melakukan Proses Pemilihan secara KONVENSIONAL (dengan Surat Suara)?";
      } 

      var r = confirm(txt);
    if (r == false) {
      e.preventDefault();
      return false;
    } 

      $.post(url, dataMap, function(data){
        json=$.parseJSON(data)
    })
  })
</script>