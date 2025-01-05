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
                <th class="text-center">Tanggal Lahir</th>
                <th class="text-center">Tanggal Meninggal</th>
                <th class="text-center">Penanggung Jawab</th>
                <th class="text-center">No Telepon</th>
                <th class="text-center">Alamat</th>
              </tr>
              <tr class="text-center">
                <td>1</td>
                <td>Bpk. V</td>
                <td>10 Januari 1938</td>
                <td>9 Juni 2010</td>
                <td>Bpk. A</td>
                <td>0812313423</td>
                <td>Kampung Sawah No.81 Rt02/04</td>
              </tr>
            </table>
          </div>

          <!-- tab rincian biaya -->
          <div role="tabpanel" class="tab-pane fade" id="rincian-biaya-tab-pane">
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
        <form action="<?=base_url();?>data_blok_makam/add_dimakamkan">
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
            <div class="form-group">
              <label for="nama_jenazah">Nama (Alm./Almh.)</label>
              <input class="form-control" type="text" name="nama_jenazah" id="nama_jenazah">
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
          </div>
          <div class="col-xs-6">
            <h4>Data Penanggung Jawab (Ahli Waris)</h4>
            <div class="divider" style="margin-left:unset; margin-right:unset;"></div>
            <div class="form-group">
              <label for="ahliwaris">Nama (Ahli Waris)</label>
              <input class="form-control" type="text" name="ahliwaris" id="ahliwaris">
            </div>
            <div class="form-group">
              <label for="ahliwaris">Nomor Telp./HP</label>
              <input class="form-control" type="text" name="ahliwaris" id="ahliwaris">
            </div>
            <div class="form-group">
              <label for="ahliwaris">Alamat (Ahli Waris)</label>
              <input class="form-control" type="text" name="ahliwaris" id="ahliwaris">
            </div>
            <div class="form-group">
              <label for="keanggotaan_ahliwaris">Gereja Asal (Ahli Waris)</label>
              <input class="form-control" type="text" name="keanggotaan_ahliwaris" id="keanggotaan_ahliwaris">
            </div>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">
          Batal
        </button>
        <button id="tambah-data-blok-makam" class="btn btn-success" data-dismiss="modal">
          Tambah
        </button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
      });
    })
    $(document).on('change', '[id=sts_keanggotaan_jenazah]', function(){
      value=$(this).val()
      if(value==1){
        $('#asal_gereja_jenazah').val('GKP Kampung Sawah')
      }else if(value!=1){
        $('#asal_gereja_jenazah').val('')
      }
    })

</script>
<?php $this->load->view('layout/footer'); ?>