<form method="POST" action="<?=base_url();?>Data_Blok_Makam/update_penghuni_makam" intarget="_BLANK" id="form_ubah_penghuni_makam">
  <?php 
    foreach ($penghuni_makam as $key => $value) {
      // code...
  ?>
  <input type="hidden" value="<?=$value->id;?>" name="recid" id="recid">
  <input type="hidden" value="<?=$value->kpkp_blok_makam_id;?>" name="kpkp_blok_makam_id" id="kpkp_blok_makam_id">
  <div class="col-xs-6">
    <h4>Data yang dimakamkan</h4>
    <div class="divider" style="margin-left:unset; margin-right:unset;"></div>
    <div class="form-group col-xs-3">
      <label for="gender">L/P</label>
      <select class="form-control" id="gender" name="gender">
        <option value='1' <?php if($value->gender==1) echo "selected"; ?>>Laki-laki</option>
        <option value='2' <?php if($value->gender==2) echo "selected"; ?>>Perempuan</option>
      </select>
    </div>
    <div class="form-group col-xs-9">
      <label for="nama_jenazah">Nama (Alm./Almh.)</label>
      <input class="form-control" type="text" name="nama_jenazah" id="nama_jenazah_update" placeholder="Sugeng Sumenep" value="<?=$value->nama;?>">
    </div>

    <div class="form-group">
      <label for="tgl_lahir">Tanggal Lahir</label>
      <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=date('d-m-Y', strtotime($value->tgl_lahir));?>">
      <span class="input-group-btn">
        <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
          <i class="fa fa-undo"></i>
        </button>
      </span>
    </div>

    <div class="form-group">
      <label for="sts_keanggotaan_jenazah_edit">Keanggotaan</label>
      <select id="sts_keanggotaan_jenazah_edit" name="sts_keanggotaan_jenazah" class="form-control">
        <option value="1" <?php if($value->sts_keanggotaan==1) echo "selected"; ?>>GKP Kampung Sawah</option>
        <option value="2" <?php if($value->sts_keanggotaan==2) echo "selected"; ?>>Non - GKP Kampung Sawah</option>
      </select>
      <input type="text" name="asal_gereja_jenazah" id="asal_gereja_jenazah_edit" class="form-control" value="<?=$value->asal_gereja;?>">
    </div>
    <div class="form-group">
      <label for="tgl_meninggal">Tanggal Meninggal</label>
      <input type="text" class="form-control datepicker" id="tgl_meninggal" name="tgl_meninggal" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=date('d-m-Y', strtotime($value->tgl_meninggal));?>">
      <span class="input-group-btn">
        <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal meninggal?" what="date">
          <i class="fa fa-undo"></i>
        </button>
      </span>
    </div>
    <div class="form-group">
      <label for="tgl_meninggal">Tanggal Dimakamkan</label>
      <input type="text" class="form-control datepicker" id="tgl_dimakamkan" name="tgl_dimakamkan" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=date('d-m-Y', strtotime($value->tgl_dimakamkan));?>">
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
      <input class="form-control" type="text" name="nama_ahli_waris" id="nama_ahli_waris" value="<?=$value->nama_ahli_waris;?>">
    </div>
    <div class="form-group">
      <label for="no_telp_ahli_waris">Nomor Telp./HP</label>
      <input class="form-control" type="text" name="no_telp_ahli_waris" id="no_telp_ahli_waris" value="<?=$value->no_telp_ahli_waris;?>">
    </div>
    <div class="form-group">
      <label for="alamat_ahli_waris">Alamat (Ahli Waris)</label>
      <textarea row="3" class="form-control" type="text" name="alamat_ahli_waris" id="alamat_ahli_waris"><?=$value->alamat_ahli_waris;?></textarea>
    </div>
    <div class="form-group">
      <label for="gereja_asal_ahli_waris">Gereja Asal (Ahli Waris)</label>
      <input class="form-control" type="text" name="gereja_asal_ahli_waris" id="gereja_asal_ahli_waris" value="<?=$value->gereja_asal_ahli_waris;?>">
    </div>
  </div>
  <?php
    }
  ?>
</form>