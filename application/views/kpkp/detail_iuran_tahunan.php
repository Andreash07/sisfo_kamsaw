<?php $this->load->view('layout/header'); ?>
      <?php #print_r($_SERVER); die($_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']);?>
<?php 
$backurl=base_url().'kpkp';
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null && $_SERVER['HTTP_REFERER'] != $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ){
  $backurl=$_SERVER['HTTP_REFERER'];
}

?>
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h4>Detail Blok Makam</h4>
        </div>
        <div class="x_content" style="display:flex; flex-direction:column; align-items:center; gap:1rem;">
          <div style="display:flex; flex-direction:column; gap:1rem;">
            <div style="display:flex; align-items:center;">
              <label style="margin-bottom: 0; min-width: 10rem;">Lokasi</label>
              <input
                class="form-control"
                value="<?= $makam->lokasi; ?>"
                type="text"
                disabled>
            </div>
            <div style="display:flex; align-items:center;">
              <label style="margin-bottom: 0; min-width: 10rem;">Blok (kavling)</label>
              <input
                class="form-control"
                value="<?= $makam->blok; ?><?= $makam->kavling; ?>"
                type="text"
                disabled>
            </div>
          </div>
          <div class="col-xs-12">
            <a href="<?=$backurl;?>" class="btn btn-default">Keluar</a>
          </div>
        </div>

      </div>

      <div class="x_panel">
        <div class="x_content">
          <!-- Nav tabs -->
          <ul style="padding:0;" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active">
              <a
                href="#daftar-dimakamkan-tab-pane"
                role="tab"
                id="daftar-dimakamkan-nav-tab"
                data-toggle="tab">
                Daftar Dimakamkan</a>
            </li>
            <li role="presentation">
              <a
                href="#rincian-biaya-tab-pane"
                role="tab"
                id="rincian-biaya-nav-tab"
                data-toggle="tab">
                Rincian Biaya</a>
            </li>
            <li role="presentation">
              <a
                href="#mutasi-pembayaran-tab-pane"
                role="tab"
                id="mutasi-pembayaran-nav-tab"
                data-toggle="tab">
                Mutasi Pembayaran</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <!-- tab daftar dimakamkan -->
            <div role="tabpanel" class="tab-pane fade active in" id="daftar-dimakamkan-tab-pane">
              <span class="text-danger">Catatan: <b>Hanya diperbolehkan 1 Penghuni makam yg Aktif!</b></span> 
              <table class="table table-striped">
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Rincian</th>
                  <th class="text-center">Penanggung Jawab/Ahli Waris</th>
                  <th class="text-center">Rincian Ahli Waris</th>
                  <th class="text-center">Action</th>
                </tr>
                <?php
                if (count($penghuni_makam) == 0) {
                ?>
                  <tr>
                    <th colspan="5" class="text-center">Tidak ada Penghuni Makam</td>
                  </tr>
                <?php
                }
                $ls_ahli_waris=array();
                $num_penghuni_aktif=0;
                foreach ($penghuni_makam as $key => $value) {
                  $ls_ahli_waris[$value->nama_ahli_waris]=array('nama_ahli_waris'=>$value->nama_ahli_waris, 'gereja_asal_ahli_waris'=>$value->gereja_asal_ahli_waris);
                ?>
                  <tr>
                    <th><?= $key + 1; ?></th>
                    <th><?= $value->nama; ?></th>
                    <td>
                      <b>Status Anggota:</b> <?= $value->asal_gereja; ?>
                      <br>
                      <b>Tgl Lahir:</b> <?= convert_tgl_dMY($value->tgl_lahir); ?>
                      <br>
                      <b>Tgl Meninggal:</b> <?= convert_tgl_dMY($value->tgl_meninggal); ?>
                      <br>
                      <b>Tgl Dimakamkan:</b> <?= convert_tgl_dMY($value->tgl_dimakamkan); ?>
                    </td>
                    <td class="text-center"><?= $value->nama_ahli_waris; ?></td>
                    <td>
                      <b>Status Anggota:</b> <?= $value->gereja_asal_ahli_waris; ?>
                      <br>
                      <b>No. Telp.:</b> <?= $value->no_telp_ahli_waris; ?>
                      <br>
                      <b>Alamat:</b> <?= $value->alamat_ahli_waris; ?>
                    </td>
                    <td class="text-center">
                       <?php 
                        if($num_penghuni_aktif==0){
                          if($value->sts==1){
                            $num_penghuni_aktif++;
                          }
                      ?>  
                        <select class="form-control" disabled>
                          <option value="0" <?php if($value->sts==0){echo "selected";}?>>Tidak Aktif</option>
                          <option value="1" <?php if($value->sts==1){echo "selected";}?>>Aktif</option>
                        </select>
                      <?php 
                        }else{
                      ?>
                      <?php 
                        }
                      ?>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </table>
            </div>

            <!-- tab rincian biaya -->
            <div role="tabpanel" class="tab-pane fade" id="rincian-biaya-tab-pane">
              <div class="x_content text-center">
                <?php
                if ($makam->sts_dompet_digital == 1) {
                  $sts_keanggotaan_penghuni_makam="Non GKP Kampung Sawah";
                  if ($makam->sts_keanggotaan_makam == 1) {
                    $pokok_iuran_summary = $pokok_iuran->nilai_iuran_angjem;
                    $sts_keanggotaan_penghuni_makam="GKP Kampung Sawah";
                  } else {
                    $pokok_iuran_summary = $pokok_iuran->nilai_iuran_non;
                  }
                  $num_tahun_tercover = floor($makam->saldo / $pokok_iuran_summary);
                  $tahun_tercover = date('Y', strtotime($num_tahun_tercover . 'year'));

                  if($makam->tgl_terakhir_bayar!=null && $makam->tgl_terakhir_bayar !='0000-00-00'){
                    $makam->tgl_terakhir_bayar=convert_tgl_dMY($makam->tgl_terakhir_bayar);
                  }
                  else{
                    $makam->tgl_terakhir_bayar='-';
                  }

                  $saldo_akhir=number_format($makam->saldo,0,",",".");
                  if($makam->saldo<0){
                    $New_saldo_akhir=$makam->saldo*-1;
                    $saldo_akhir="(".number_format($New_saldo_akhir,0,",",".").")";
                  }

                ?>
                  <form class="form-horizontal form-label-left">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="saldo_sisa_dis">Lebih/(Kurang) Bayar<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" id="saldo_sisa_dis" name="saldo_sisa_dis" required="required" value="<?= $saldo_akhir ; ?>" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun_terbayarkan_dis">Tahun Terbayarkan<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" id="tahun_terbayarkan_dis" name="tahun_terbayarkan_dis" required="required" value="<?= $tahun_tercover; ?> (<?=$num_tahun_tercover;?> Tahun)" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nominal_biaya_tahunan_dis">Nominal Biaya Tahunan<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" id="nominal_biaya_tahunan_dis" name="nominal_biaya_tahunan_dis" required="required" value="<?= number_format($pokok_iuran_summary,0,",","."); ?>" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori_anggota_dis">Kategori Anggota<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" id="kategori_anggota_dis" name="kategori_anggota_dis" required="required" value="<?= $sts_keanggotaan_penghuni_makam; ?>" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tanggal_terakhir_bayar_dis">Tanggal Pembayaran Terakhir<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" type="text" id="tanggal_terakhir_bayar_dis" name="tanggal_terakhir_bayar_dis" required="required" value="<?= $makam->tgl_terakhir_bayar; ?>" disabled>
                      </div>
                    </div>
                  </form>
                <?php
                } else {
                ?>
                  <span class="text-danger">Dompet Digital Iuran Perawatan Makam KPKP <b>belum Aktif</b>, Silahkan Hubungi Administrator/Pnt/Pengurus KPKP Terkait</span><br>
                <?php
                }
                ?>
              </div>
            </div>

            <!-- tab mutasi pembayaran -->
            <div role="tabpanel" class="tab-pane fade" id="mutasi-pembayaran-tab-pane">
              <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
                
              </div>
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Tanggal</th>
                    <th style="width:40rem;">Transaksi</th>
                    <th class="text-center">Nominal</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $total_mutasi=0;
                    foreach ($kpkp_bayar_tahunan as $key7 => $value7) {
                      // code...
                      $tipe_transaksi='Saldo Awal';
                      $note="";
                      if($value7->type==1){
                        $tipe_transaksi='Setor Iuran';
                        $note='Catatan: '.$value7->note;
                      }
                      else if($value7->type==2){
                        $tipe_transaksi='Pembayaran Iuran';
                        $note='Catatan: '.$value7->note;
                      }
                      else if($value7->type==3){
                        $tipe_transaksi='Setor Sukarela';
                        $note='Catatan: '.$value7->note;
                      }
                      $total_mutasi=$total_mutasi+$value7->nominal;
                  ?>  
                      <tr>
                        <td class="text-center"><?=$key7+1;?></td>
                        <td class="text-left"><?=convert_tgl_dMY($value7->tgl_bayar);?></td>
                        <td style="width:40rem;">
                          <?=$tipe_transaksi;?><br>
                          <b><?=$note;?></b>
                        </td>
                        <td class="text-right"><?=number_format($value7->nominal,0,",",".");?></td>
                        <td class="text-center">
                          <div class="btn btn-warning btn-xs" title="Perbaikan Mutasi" id="btn_edit-Mutasi<?=$value7->id;?>" form="<?=base_url().'pemakaman/form_perbaikan?id='.$value7->id;?>"><i class="fa fa-pencil"></i></div>
                        </td>
                      </tr>
                  <?php 
                    }
                  ?>
                  <tr>
                    <th colspan="3" class="text-right">Jumlah Mutasi</th>
                    <th class="text-right"><?=number_format($total_mutasi,0,",",".");?></th>
                    <th class="text-right">
                      <?php 
                        if( $total_mutasi!=$makam->saldo){
                          //echo ($total_mutasi."<br>".$value7->nominal);

                      ?>
                          ada perbedaan Total Mutasi Iuran<br>
                          <div class="btn btn-danger" id="btn_approve_perbaikan" kk_id="<?=$value7->kpkp_blok_makam_id;?>" href="<?=base_url().'Data_Blok_Makam/approve';?>" total_mutasi='<?=$total_mutasi;?>'>Setujui Perbaikan</div>
                      <?php
                        }
                      ?>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
    });

    //$('#div_saldo_terakhir').hide();
    $('#nominal').val('Saldo terhitung otomatis!')
    $('#nominal').attr('disabled', 'disabled')
    $('#nominal').attr('Title', 'Tidak perlu memasukan Saldo, Saldo terhitung otomatis!')
  })

  $(document).on('change', '[id^=sts_penghuniMakan]', function() {
    sts=$(this).val();
    recid=$(this).attr('recid');
    dataMap = {}
    dataMap['sts'] = sts
    dataMap['recid'] = recid
    href = $(this).attr('inhref')
    $.post(href, dataMap, function(data) {
      json=$.parseJSON(data)
      if(json.sts=='1'){
        iziToast.success({
          title: json.title,
          message: json.msg,
          position: "topRight",
          class: "",

        });
      }
      else {
        iziToast.error({
          title: json.title,
          message: json.msg,
          position: "topRight",
          class: "",

        });
      }
      setTimeout(function(){
        window.location.reload()
      }, 500)

    })
  })

  $(document).on('click touchstart', '[id=btn_ubah_penghuni_makam]', function() {
    $('#div_ubah_data_makam').html('')
    dataMap = {}
    href = $(this).attr('inhref')
    $.get(href, dataMap, function(data) {
      $('#div_ubah_data_makam').html(data)
      $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
      });
    })
  })

  function update_penghuni_makam() {
    konfirm = confirm("Apakah Anda yakin ingin mengubah data " + $('#nama_jenazah_update').val() + ' dari makam ini?')
    if (konfirm == false) {
      iziToast.error({
        title: 'Proses Dibatalkan!',
        message: 'Data ' + $('#nama_jenazah_update').val() + ' tidak jadi diubah',
        position: "topRight",
        class: "",

      });
      return false;
    }

    $('#form_ubah_penghuni_makam').submit()
  }

  $(document).on('click touchstart', '[id=delete_penghuni_makam]', function() {
    konfirm = confirm("Apakah Anda yakin ingin menghapus " + $(this).attr('nama_penghuni') + ' dari makam ini?')
    if (konfirm == false) {
      iziToast.error({
        title: 'Proses Dibatalkan!',
        message: 'Data ' + $(this).attr('nama_penghuni') + ' tidak dihapus',
        position: "topRight",
        class: "",

      });
      return false;
    }
    window.location.href = $(this).attr('href');
  })

  $(document).on('change', '[id=ls_metode_pembayaran]', function() {
    value = $(this).val()
    if (value == 'Kartu iuran') {
      $('#metode_pembayaran').val('Pembayaran dengan '+value)
    } else if (value != 1) {
      $('#metode_pembayaran').val('Pembayaran ditransfer oleh '+value)
    }
  })

  $(document).on('change', '[id=sts_keanggotaan_jenazah]', function() {
    value = $(this).val()
    if (value == 1) {
      $('#asal_gereja_jenazah').val('GKP Kampung Sawah')
    } else if (value != 1) {
      $('#asal_gereja_jenazah').val('')
    }
  })

  $(document).on('change', '[id=sts_keanggotaan_jenazah_edit]', function() {
    value = $(this).val()
    if (value == 1) {
      $('#asal_gereja_jenazah_edit').val('GKP Kampung Sawah')
    } else if (value != 1) {
      $('#asal_gereja_jenazah_edit').val('')
    }
  })

  $(document).on('change', '[id=pilih_perhitungan_saldo]', function() {
    value = $(this).val()
    if (value == 1) {
      $('#div_tahun_pembayaran_terakhir').show()
      //$('#div_saldo_terakhir').hide()
      $('#nominal').val('Saldo terhitung otomatis!')
      $('#nominal').attr('disabled', 'disabled')
      $('#nominal').attr('Title', 'Tidak perlu memasukan Saldo, Saldo terhitung otomatis!')
    } else if (value == 2) {
      $('#div_saldo_terakhir').show()
      $('#div_tahun_pembayaran_terakhir').hide()
      $('#nominal').removeAttr('disabled')
      $('#nominal').val('')
    }
  })


  var rupiah = document.getElementById("nominal");
  rupiah.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, "");
  });

  var rupiah1 = document.getElementById("nominal_pembayaran");
  rupiah1.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah1.value = formatRupiah1(this.value, "");
  });


  /* Fungsi formatRupiah */
  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? prefix + " " + rupiah : "";
  }

  function formatRupiah1(angka1, prefix1) {
    var number_string = angka1.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah1 = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah1 += separator + ribuan.join(".");
    }

    rupiah1 = split[1] != undefined ? rupiah1 + "," + split[1] : rupiah1;
    return prefix1 == undefined ? rupiah1 : rupiah1 ? prefix1 + " " + rupiah1 : "";
  }
</script>
<?php
if ($this->session->flashdata('sts_add') == 1) {
?>
  <script type="text/javascript">
    iziToast.success({
      title: '<?= $this->session->flashdata('Title_add'); ?>',
      message: '<?= $this->session->flashdata('msg_add'); ?>',
      position: "topRight",
      class: "<?= $this->session->flashdata('class'); ?>",

    });
  </script>
<?php
} else if ($this->session->flashdata('sts_add') == -1) {
?>
  <script type="text/javascript">
    iziToast.error({
      title: '<?= $this->session->flashdata('Title_add'); ?>',
      message: '<?= $this->session->flashdata('msg_add'); ?>',
      position: "topRight",
      class: "<?= $this->session->flashdata('class'); ?>",

    });
  </script>
<?php
}
?>
<?php $this->load->view('layout/footer'); ?>