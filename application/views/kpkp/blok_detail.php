<?php $this->load->view('layout/header'); ?>
      <?php #print_r($_SERVER); die($_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']);?>
<?php 
$backurl=base_url().'Data_Blok_Makam';
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null && $_SERVER['HTTP_REFERER'] != $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ){
  $backurl=$_SERVER['HTTP_REFERER'];
}
  
  if(!isset($makam->lokasi)){
?>
  <div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h4>Detail Blok Makam</h4>
        </div>
        <div class="x_content" style="display:flex; flex-direction:column; align-items:center; gap:1rem;">
          <div class="col-xs-12 text-center" >
          <?= '<b class="text-danger" >Data tidak ditemukan!</b><br> Silahkan kembali ke Halaman <a href="'.base_url().'Data_Blok_Makam">Blok Makam</a> '; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php 
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
              <div class="btn btn-primary" data-toggle="modal" data-target=".modal-blok-formdimakamkan">Tambah Dimakamkan</div>
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
                      <div class="btn btn-warning btn-xs" title="Ubah" data-toggle="modal" data-target=".modal-blok-formubahdimakamkan" inhref="<?= base_url(); ?>Data_Blok_Makam/view_penghuni_makam?auth=<?= md5('JHk1812#' . $value->id); ?>" id="btn_ubah_penghuni_makam">
                        <i class="fa fa-pencil"></i>
                      </div>
                      <div id="delete_penghuni_makam" nama_penghuni="<?= $value->nama; ?>" class="btn btn-danger btn-xs" title="Hapus" href="<?= base_url(); ?>Data_Blok_Makam/delete_penghuni_makam?auth=<?= md5($value->kpkp_blok_makam_id); ?>&token=<?= md5($value->id); ?>">
                        <i class="fa fa-trash"></i>
                      </div>
                      <div class="divider"></div>
                      <?php 
                        if($num_penghuni_aktif==0){
                          if($value->sts==1){
                            $num_penghuni_aktif++;
                          }
                      ?>  
                        <select class="form-control" name="sts_penghuniMakan<?=$value->id;?>" id="sts_penghuniMakan<?=$value->id;?>" inhref="<?=base_url();?>Data_Blok_Makam/update_sts" recid="<?=$value->id;?>">
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
                  #$hitung_bulan_iuran_makam=countTahunTercover_new($makam->saldo, $pokok_iuran_all, $makam->sts_keanggotaan_makam, date('Y'));
                  #$hitung_bulan_iuran_makam=countTahunTercover($makam->saldo, $pokok_iuran_all, $makam->sts_keanggotaan_makam, date('Y'));

                  $sts_keanggotaan_penghuni_makam="Non GKP Kampung Sawah";
                  if ($makam->sts_keanggotaan_makam == 1) {
                    $pokok_iuran_summary = $pokok_iuran->nilai_iuran_angjem;
                    $sts_keanggotaan_penghuni_makam="GKP Kampung Sawah";
                  } else {
                    $pokok_iuran_summary = $pokok_iuran->nilai_iuran_non;
                  }
                  #$num_tahun_tercover = floor($makam->saldo / $pokok_iuran_summary);
                  #$tahun_tercover = date('Y', strtotime($num_tahun_tercover . 'year'));
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
                  <div class="btn btn-success" data-toggle="modal" data-target=".modal-dompetKPKP"><b>Aktifkan!</b> Dompet Iuran Perawatan Makam KPKP</div>
                <?php
                }
                ?>
              </div>
            </div>

            <!-- tab mutasi pembayaran -->
            <div role="tabpanel" class="tab-pane fade" id="mutasi-pembayaran-tab-pane">
              <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
                <div class="btn btn-primary" data-toggle="modal" data-target=".tambah-pembayaran">Tambah Pembayaran</div>
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

                      if(!is_numeric($value7->nominal)){
                        $value7->nominal=0;
                      }
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
                          <a class="btn btn-danger btn-xs" title="Hapus Transaksi ini (<?=convert_tgl_dMY($value7->tgl_bayar);?> | <?=number_format($value7->nominal,0,",",".");?>)" id="btn_delet-Mutasi<?=$value7->id;?>" href="<?=base_url().'Data_Blok_Makam/delete_trx?token='.md5('jkla178$@'.$value7->id);?>"><i class="fa fa-trash"></i></a>
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
                          <div class="btn btn-danger" id="btn_approve_perbaikan" makam_id="<?=$makam->id;?>" href="<?=base_url().'Data_Blok_Makam/approve';?>" total_mutasi='<?=$total_mutasi;?>'>Setujui Perbaikan</div>
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

<!-- modal: Tambah Pembayaran -->
<div class="modal fade tambah-pembayaran" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width:400px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Pembayaran</h4>
      </div>
      <div class="modal-body">
        <form id="form_add_pambayaran" method="POST" action="<?=base_url();?>Data_Blok_Makam/add_pembayaran" intarget="_BLANK">
          <input type="hidden" value="<?= $makam->id; ?>" name="kpkp_blok_makam_id" id="kpkp_blok_makam_id">
          <input type="hidden" id="pokok_iuran" name="pokok_iuran" required="required" class="form-control" value="<?php if ($makam->sts_keanggotaan_makam == 1) {echo $pokok_iuran->nilai_iuran_angjem ;} else {echo $pokok_iuran->nilai_iuran_non;} ?>">

          <div class="form-group">
            <label for="tgl_pembayaran">Tanggal Pembayaran</label>
            <input type="text" class="form-control datepicker" id="tgl_pembayaran" name="tgl_pembayaran" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?= date('d-m-Y'); ?>">
          </div>
          <div class="form-group">
            <label for="nominal_pembayaran" >Nominal</label>
            <input class="form-control" type="text" name="nominal_pembayaran" id="nominal_pembayaran">
          </div>
          <div class="form-group">
            <label for="ls_metode_pembayaran">Metode Pambayaran</label>
            <select name="ls_metode_pembayaran" id="ls_metode_pembayaran" class="form-control" >
              <option value='Kartu iuran'>Kartu Iuran</option>
              <?php 
                foreach ($ls_ahli_waris as $key1 => $value1) {
                  // code...
              ?> 
                <option value="<?=$value1['nama_ahli_waris'];?>">Transfer - <?=$value1['nama_ahli_waris'];?> (<?=$value1['gereja_asal_ahli_waris'];?>)</option>
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <input class="form-control" name="metode_pembayaran" id="metode_pembayaran" value="Pembayaran dengan Kartu iuran">
          </div>
          <div class="form-group">
            <label for="catatan" >Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" style="width: 250px;"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="$('#form_add_pambayaran').submit()" >Simpan</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
        <form method="POST" action="<?= base_url(); ?>Data_Blok_Makam/save_penghuni_makam" intarget="_BLANK" id="form_tambah_penghuni_makam">
          <div class="col-xs-12">
            <div class="col-xs-3">
              <input type="hidden" value="<?= $makam->id; ?>" name="kpkp_blok_makam_id" id="kpkp_blok_makam_id">
              <input readonly value="<?= $makam->lokasi; ?>" class="form-control" name="lokasi_makam" id="lokasi_makam">
            </div>
            <div class="col-xs-3">
              <input readonly value="<?= $makam->blok; ?><?= $makam->kavling; ?>" class="form-control" name="blokkavling_makam" id="blokkavling_makam">
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
              <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?= date('d-m-1990'); ?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning btn-xs" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
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
              <input type="text" class="form-control datepicker" id="tgl_meninggal" name="tgl_meninggal" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?= date('d-m-Y'); ?>">
              <span class="input-group-btn">
                <button type="button" class="btn-xs reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal meninggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
            <div class="form-group">
              <label for="tgl_meninggal">Tanggal Dimakamkan</label>
              <input type="text" class="form-control datepicker" id="tgl_dimakamkan" name="tgl_dimakamkan" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?= date('d-m-Y'); ?>">
              <span class="input-group-btn">
                <button type="button" class="btn-xs reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal meninggal?" what="date">
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
          <form id="form_bukadompetkpkp" action="<?= base_url(); ?>/Data_Blok_Makam/aktifasi_dompet_iuran_makam" method="POST" intarget="_BLANK">
            <input type="hidden" value="<?= $makam->sts_keanggotaan_makam; ?>" name="sts_keanggotaan_makam" id="sts_keanggotaan_makam">
            <input type="hidden" value="<?= $makam->id; ?>" name="kpkp_blok_makam_id" id="kpkp_blok_makam_id">
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
                <input type="text" id="pokok_iuran" name="pokok_iuran" required="required" class="form-control" value="<?php if ($makam->sts_keanggotaan_makam == 1) {echo number_format($pokok_iuran->nilai_iuran_angjem, 0, ",", ".");} else {echo number_format($pokok_iuran->nilai_iuran_non, 0, ",", ".");} ?>" readonly title="Pokok iuran ini berdasarkan status keanggotaan Penghuni Makam" style="cursor: not-allowed;">
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
                  $maxYear = date('Y') + 30;
                  for ($i = 2000; $i <= $maxYear; $i++) {
                    // code...
                  ?>
                    <option value="<?= $i; ?>" <?php if ($i == date('Y')) echo 'selected'; ?>> <?= $i; ?></option>
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
                <input type="text" id="nominal" name="nominal" required="required" class="form-control" placeholder="Contoh: <?= number_format(0, 0, ",", "."); ?>">
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

  $(document).on('click touchstart', '[id^=btn_delet-Mutasi]', function() {
    konfirm = confirm("Apakah Anda yakin "+$(this).attr('title')+" dari mutasi transaksi makam ini?")
    if (konfirm == false) {
      iziToast.error({
        title: 'Proses Dibatalkan!',
        message: 'Data Transaksi '+$(this).attr('title')+' tidak dihapus',
        position: "topRight",
        class: "",

      });
      return false;
    }
    window.location.href = $(this).attr('href');
  })


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

  $(document).on('click', '[id=btn_approve_perbaikan]', function(e){
    e.preventDefault()
    conf=confirm('Apakah anda yakin melakukan perbaikan Saldo KPKP Makam ini?')
    if(conf==false){
      return;
    }
    dataMap={}
    dataMap['makam_id']=$(this).attr('makam_id')
    dataMap['nominal_baru']=$(this).attr('total_mutasi')
    url=$(this).attr('href')
    $.post(url, dataMap,function(data){
      alert('Perbaikan saldo KPKP Makam ini berhasil!')
      location.reload();
    })
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