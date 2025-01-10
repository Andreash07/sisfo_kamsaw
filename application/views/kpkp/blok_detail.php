<?php $this->load->view('layout/header'); ?>
<div class="right_col" role="main">
  <div class="col-xs-12">
    <div class="x_panel">
      <div class="x_title" style="padding-bottom:2rem;">
        <h4>Detail Blok Makam</h4>
        <div style="display:flex; gap:1rem;">
          <div style="display:flex; flex-direction:column; gap:1rem;">
            <input
              class="form-control"
              style="width:12rem;"
              value="Lokasi"
              type="text"
              disabled>
            <input
              class="form-control"
              style="width:12rem;"
              value="Blok (kavling)"
              type="text"
              disabled>
          </div>
          <div style="display:flex; flex-direction:column; gap:1rem;">
            <input
              class="form-control"
              value="<?=$makam->lokasi;?>"
              type="text"
              disabled>
            <input
              class="form-control"
              value="<?=$makam->blok;?><?=$makam->kavling;?>"
              type="text"
              disabled>
          </div>
        </div>
      </div>
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
            <div class="btn btn-primary" data-toggle="modal" data-target=".modal-blok-formdimakamkan">Tambah Dimakamkan</div>
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
                if(count($penghuni_makam)==0){
              ?>
                <tr>
                  <th colspan="5" class="text-center">Tidak ada Penghuni Makam</td>
                </tr>
              <?php
                }

                foreach($penghuni_makam as $key => $value){
              ?>
                  <tr>
                    <th><?= $key+1;?></th>
                    <th><?= $value->nama;?></th>
                    <td>
                      <b>Status Anggota:</b> <?= $value->asal_gereja;?>
                      <br>
                      <b>Tgl Lahir:</b> <?= convert_tgl_dMY($value->tgl_lahir);?>
                      <br>
                      <b>Tgl Meninggal:</b> <?= convert_tgl_dMY($value->tgl_meninggal);?>
                      <br>
                      <b>Tgl Dimakamkan:</b> <?= convert_tgl_dMY($value->tgl_dimakamkan);?>
                    </td>
                    <td class="text-center"><?= $value->nama_ahli_waris;?></td>
                    <td>
                      <b>Status Anggota:</b> <?= $value->gereja_asal_ahli_waris;?>
                      <br>
                      <b>No. Telp.:</b> <?= $value->no_telp_ahli_waris;?>
                      <br>
                      <b>Alamat:</b> <?= $value->alamat_ahli_waris;?>
                    </td>
                    <td class="text-center">
                      <div class="btn btn-warning btn-sm" title="Ubah" data-toggle="modal" data-target=".modal-blok-formubahdimakamkan" inhref="<?=base_url();?>Data_Blok_Makam/view_penghuni_makam?auth=<?=md5('JHk1812#'.$value->id);?>" id="btn_ubah_penghuni_makam">
                        <i class="fa fa-pencil"></i>
                      </div>
                      <div id="delete_penghuni_makam" nama_penghuni="<?=$value->nama;?>" class="btn btn-danger btn-sm" title="Hapus" href="<?=base_url();?>Data_Blok_Makam/delete_penghuni_makam?auth=<?=md5($value->kpkp_blok_makam_id);?>&token=<?=md5($value->id);?>">
                        <i class="fa fa-trash"></i>
                      </div>
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
              if($makam->sts_dompet_digital == 1){
                if($makam->sts_keanggotaan_makam==1){ 
                  $pokok_iuran=$pokok_iuran->nilai_iuran_angjem; 
                }
                else{
                  $pokok_iuran=$pokok_iuran->nilai_iuran_non; 
                }
                $num_tahun_tercover=floor($makam->saldo/$pokok_iuran);
                $tahun_tercover=date('Y', strtotime($num_tahun_tercover.'year'));
            ?>  
            <form>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Tahun Terbayarkan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=$tahun_tercover;?>" disabled>
                </div>
              </div>
            </form>
              <table class="table table-bordered">
                <tr>
                  <td style="width:24rem;">
                    <strong>Tahun Terbayarkan</strong>
                  </td>
                  <td>2027 (+3 Tahun)</td>
                </tr>
                <tr>
                  <td style="width:24rem;">
                    <strong>Nominal Biaya Tahunan</strong>
                  </td>
                  <td>Rp. 150.000</td>
                </tr>
                <tr>
                  <td style="width:24rem;">
                    <strong>Kategori Anggota</strong>
                  </td>
                  <td>Non GKP Kampung Sawah</td>
                </tr>
                <tr>
                  <td style="width:24rem;">
                    <strong>Tanggal masuk pembayaran</strong>
                  </td>
                  <td>31 Desember 2020</td>
                </tr>
              </table>
            <?php 
              }
              else{
            ?>
                <span class="text-danger">Dompet Digital Iuran Perawatan Makam KPKP <b>belum Aktif</b>, Silahkan Hubungi Administrator/Pnt/Pengurus KPKP Terkait</span><br>
                <div class="btn btn-success" data-toggle="modal" data-target=".modal-dompetKPKP"><b>Aktifkan!</b> Dompet Iuran Perawatan Makam KPKP</div>
            <?php
              }
            ?>
            </div>
          </div>

          <!-- tab mutasi pembayaran -->
          <div role="tabpanel" class="tab-pane fade" id="mutasi-pembayaran-tab-pane">
            <table class="table">
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Tanggal</th>
                <th style="width:40rem;">Transaksi</th>
                <th class="text-center">Nominal</th>
                <th class="text-center">Action</th>
              </tr>
              <tr>
                <td class="text-center">1</td>
                <td class="text-center">31 Desember 2024</td>
                <td style="width:40rem;">Saldo Awal</td>
                <td class="text-center">450.000</td>
                <td class="text-center">tombol edit</td>
              </tr>
              <tr>
                <td class="text-center">2</td>
                <td class="text-center">01 Januari 2025</td>
                <td style="width:40rem;">
                  Pembayaran Iuran
                  <br>
                  Catatan: Tahun 2025 (Non GKP Kampung Sawah @150.000)
                </td>
                <td class="text-center">-150.000</td>
                <td class="text-center">tombol edit</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-blok-formdimakamkan" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Tambah Data Dimakamkan</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?=base_url();?>data_blok_makam/save_penghuni_makam" target="_BLANK" id="form_tambah_penghuni_makam">
          <div class="col-xs-12">
            <div class="col-xs-3">
              <input type="hidden" value="<?=$makam->id;?>" name="kpkp_blok_makam_id" id="kpkp_blok_makam_id">
              <input readonly value="<?=$makam->lokasi;?>" class="form-control" name="lokasi_makam" id="lokasi_makam">
            </div>
            <div class="col-xs-3">
              <input readonly value="<?=$makam->blok;?><?=$makam->kavling;?>" class="form-control" name="blokkavling_makam" id="blokkavling_makam">
            </div>
          </div>
          <div class="col-xs-6">
            <h4>Data yang dimakamkan</h4>
            <div class="divider" style="margin-left:unset; margin-right:unset;"></div>
            <div class="form-group col-xs-3">
              <label for="gender">L/P</label>
              <select class="form-control" id="gender" name="gender">
                <option value='1'>Laki-laki</option>
                <option value='2'>Perempuan</option>
              </select>
            </div>
            <div class="form-group col-xs-9">
              <label for="nama_jenazah">Nama (Alm./Almh.)</label>
              <input class="form-control" type="text" name="nama_jenazah" id="nama_jenazah" placeholder="Sugeng Sumenep">
            </div>

            <div class="form-group">
              <label for="tgl_lahir">Tanggal Lahir</label>
              <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=date('d-m-1990');?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>

            <div class="form-group">
              <label for="sts_keanggotaan_jenazah">Keanggotaan</label>
              <select id="sts_keanggotaan_jenazah" name="sts_keanggotaan_jenazah" class="form-control">
                <option value="1">GKP Kampung Sawah</option>
                <option value="2">Non - GKP Kampung Sawah</option>
              </select>
              <input type="text" name="asal_gereja_jenazah" id="asal_gereja_jenazah" value="GKP Kampung Sawah" class="form-control">
            </div>
            <div class="form-group">
              <label for="tgl_meninggal">Tanggal Meninggal</label>
              <input type="text" class="form-control datepicker" id="tgl_meninggal" name="tgl_meninggal" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=date('d-m-Y');?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal meninggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
            <div class="form-group">
              <label for="tgl_meninggal">Tanggal Dimakamkan</label>
              <input type="text" class="form-control datepicker" id="tgl_dimakamkan" name="tgl_dimakamkan" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=date('d-m-Y');?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal meninggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
          <div class="col-xs-6">
            <h4>Data Penanggung Jawab (Ahli Waris)</h4>
            <div class="divider" style="margin-left:unset; margin-right:unset;"></div>
            <div class="form-group">
              <label for="nama_ahli_waris">Nama (Ahli Waris)</label>
              <input class="form-control" type="text" name="nama_ahli_waris" id="nama_ahli_waris">
            </div>
            <div class="form-group">
              <label for="no_telp_ahli_waris">Nomor Telp./HP</label>
              <input class="form-control" type="text" name="no_telp_ahli_waris" id="no_telp_ahli_waris">
            </div>
            <div class="form-group">
              <label for="alamat_ahli_waris">Alamat (Ahli Waris)</label>
              <textarea row="3" class="form-control" type="text" name="alamat_ahli_waris" id="alamat_ahli_waris"></textarea>
            </div>
            <div class="form-group">
              <label for="gereja_asal_ahli_waris">Gereja Asal (Ahli Waris)</label>
              <input class="form-control" type="text" name="gereja_asal_ahli_waris" id="gereja_asal_ahli_waris">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">
          Batal
        </button>
        <button id="tambah-data-blok-makam" class="btn btn-success" data-dismiss="modal" onclick="$('#form_tambah_penghuni_makam').submit()">
          Tambah
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-blok-formubahdimakamkan" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Ubah Data Dimakamkan</h4>
      </div>
      <div class="modal-body" id="div_ubah_data_makam">
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">
          Batal
        </button>
        <button id="tambah-data-blok-makam" class="btn btn-success" data-dismiss="modal" onclick="update_penghuni_makam()">
          Simpan
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal-dompetKPKP modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Aktifasi Perawatan Iuran Makam KPKP</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="form_bukadompetkpkp" action="<?=base_url();?>/Data_Blok_Makam/aktifasi_dompet_iuran_makam" method="POST" target="_BLANK">
            <input type="hidden" value="<?=$makam->sts_keanggotaan_makam;?>" name="sts_keanggotaan_makam" id="sts_keanggotaan_makam">
            <input type="hidden" value="<?=$makam->id;?>" name="kpkp_blok_makam_id" id="kpkp_blok_makam_id">
            <div class="item form-group col-xs-12">
              <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="nominal">Keanggotaan <span class="required text-right">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="keanggotaan_makam_dompet" name="keanggotaan_makam" required="required" class="form-control" placeholder="GKP Kampung Sawah" value="<?= $makam->keanggotaan_makam; ?>" disabled readonly>
              </div>
            </div>
            <div class="item form-group col-xs-12">
              <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="nominal">Pokok Iuran (Rp.) <span class="required text-right">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="pokok_iuran" name="pokok_iuran" required="required" class="form-control" value="<?php if($makam->sts_keanggotaan_makam==1){ echo number_format($pokok_iuran->nilai_iuran_angjem,0,",","."); }else{echo number_format($pokok_iuran->nilai_iuran_non,0,",",".");}?>" readonly title="Pokok iuran ini berdasarkan status keanggotaan Penghuni Makam" style="cursor: not-allowed;">
              </div>
            </div>
            <div class="item form-group col-xs-12">
              <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="pilih_perhitungan_saldo">Perhitungan Saldo Awal<span class="required text-right">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <select name="pilih_perhitungan_saldo" id="pilih_perhitungan_saldo" class="form-control">
                  <option value="1" selected>Tahun Pembayaran Terakhir</option>
                  <option value="2">Jumlah Saldo Terakhir</option>
                  
                </select>
              </div>
            </div>
            <div class="item form-group col-xs-12" id="div_tahun_pembayaran_terakhir">
              <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="tahun_terakhir">Tahun Pembayaran Terakhir<span class="required text-right">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <select name="tahun_terakhir" id="tahun_terakhir" class="form-control">
                <?php 
                $maxYear= date('Y')+5;
                for ($i=2014; $i <= $maxYear; $i++) { 
                  // code...
                ?>
                  <option value="<?=$i;?>" <?php if($i==date('Y')) echo 'selected'; ?>> <?=$i;?></option>
                <?php
                }
                ?>
                </select>
              </div>
            </div>
            <div class="item form-group col-xs-12" id="div_saldo_terakhir">
              <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="nominal">Jumlah Saldo (Rp.) <span class="required text-right">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="nominal" name="nominal" required="required" class="form-control" placeholder="Contoh: <?=number_format(0,0,",",".");?>">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn_buat_dompetkppk" onclick="$('#form_bukadompetkpkp').submit()">Aktifasi</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
      $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
      });

      //$('#div_saldo_terakhir').hide();
      $('#nominal').val('Saldo terhitung otomatis!')
      $('#nominal').attr('disabled', 'disabled')
      $('#nominal').attr('Title', 'Tidak perlu memasukan Saldo, Saldo terhitung otomatis!')
    })

    $(document).on('click touchstart', '[id=btn_ubah_penghuni_makam]', function(){
      $('#div_ubah_data_makam').html('')
      dataMap={}
      href=$(this).attr('inhref')
      $.get(href, dataMap, function(data){
        $('#div_ubah_data_makam').html(data)
        $('.datepicker').datepicker({
          format: 'dd-mm-yyyy',
        });
      })
    })

    function update_penghuni_makam(){
      konfirm=confirm("Apakah Anda yakin ingin mengubah data "+$('#nama_jenazah_update').val()+' dari makam ini?')
      if(konfirm==false){
        iziToast.error({
          title: 'Proses Dibatalkan!',
          message: 'Data '+$('#nama_jenazah_update').val()+' tidak jadi diubah',
          position: "topRight",
          class: "",

        });
        return false;
      }

      $('#form_ubah_penghuni_makam').submit()
    }

    $(document).on('click touchstart', '[id=delete_penghuni_makam]', function(){
      konfirm=confirm("Apakah Anda yakin ingin menghapus "+$(this).attr('nama_penghuni')+' dari makam ini?')
      if(konfirm==false){
        iziToast.error({
          title: 'Proses Dibatalkan!',
          message: 'Data '+$(this).attr('nama_penghuni')+' tidak dihapus',
          position: "topRight",
          class: "",

        });
        return false;
      }
      window.location.href = $(this).attr('href');
    })
    
    $(document).on('change', '[id=sts_keanggotaan_jenazah]', function(){
      value=$(this).val()
      if(value==1){
        $('#asal_gereja_jenazah').val('GKP Kampung Sawah')
      }else if(value!=1){
        $('#asal_gereja_jenazah').val('')
      }
    })

    $(document).on('change', '[id=sts_keanggotaan_jenazah_edit]', function(){
      value=$(this).val()
      if(value==1){
        $('#asal_gereja_jenazah_edit').val('GKP Kampung Sawah')
      }else if(value!=1){
        $('#asal_gereja_jenazah_edit').val('')
      }
    })

    $(document).on('change', '[id=pilih_perhitungan_saldo]', function(){
      value=$(this).val()
      if(value==1){
        $('#div_tahun_pembayaran_terakhir').show()
        //$('#div_saldo_terakhir').hide()
        $('#nominal').val('Saldo terhitung otomatis!')
        $('#nominal').attr('disabled', 'disabled')
        $('#nominal').attr('Title', 'Tidak perlu memasukan Saldo, Saldo terhitung otomatis!')
      }else if(value==2){
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


    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
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
      return prefix == undefined ? rupiah : rupiah ? prefix+" " + rupiah : "";
    }

</script>
<?php
if($this->session->flashdata('sts_add')==1){
?>
  <script type="text/javascript">
    iziToast.success({
      title: '<?=$this->session->flashdata('Title_add');?>',
      message: '<?=$this->session->flashdata('msg_add');?>',
      position: "topRight",
      class: "<?=$this->session->flashdata('class');?>",

    });
  </script>
<?php
}
else if($this->session->flashdata('sts_add')==-1){
?>
  <script type="text/javascript">
    iziToast.error({
      title: '<?=$this->session->flashdata('Title_add');?>',
      message: '<?=$this->session->flashdata('msg_add');?>',
      position: "topRight",
      class: "<?=$this->session->flashdata('class');?>",

    });
  </script>
<?php
} 
?>
<?php $this->load->view('layout/footer'); ?>