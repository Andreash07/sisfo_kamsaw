<?php
  $hub_kwg=$this->m_model->select('ags_hub_kwg');
?>

<?php
  if(isset($type) && $type=='addAnggota'){
?>
    <form class="form-horizontal form-label-left" action="" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Anggota Jemaat</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Nomor Anggota
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" class="form-control" disabled="disabled" value="" placeholder="Auto">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Lengkap<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" class="form-control" placeholder="Nama Anggota Jemaat" name="nama_lengkap" value="">
          </div>
        </div>
        <div class="form-group">
          <?php
            $checked1="";
            $checked0="";
          ?>
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kelamin<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <label>
                <input type="radio" value="P" id="jns_kelamin0" name="jns_kelamin" <?=$checked0;?>>Perempuan
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="L" id="jns_kelamin1" name="jns_kelamin" <?=$checked1;?>>Laki-laki
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Hubungan Keluarga<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" required id="hub_kwg" name="hub_kwg">
              <option value='' disabled selected>Pilih</option>
              <?php
                foreach ($hub_kwg as $keyHub_kwg => $valueHub_kwg) {
                  # code...
              ?>
                <option value='<?=$valueHub_kwg->idhubkel;?>'><?=$valueHub_kwg->hub_keluarga;?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Wilayah<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" required id="kwg_wil" name="kwg_wil" >
              <option value='' >Pilih</option>
              <option value='0'>Belum Diketahui</option>
              <?php
                foreach (lsWil() as $lsWil => $valueWil) {
                  # code...
              ?>
                <option value='<?=$valueWil->id;?>'>Wilayah <?=$valueWil->wilayah;?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Lahir <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_lahir " name="tmpt_lahir" value="" placeholder="Bekasi/Jakarta/Semarang, dll">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lahir <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Baptis<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <?php
                $checked1="";
                $checked0="";
              ?>
              <label>
                <input type="radio" value="0" id="optionsRadios2" name="status_baptis" <?=$checked0;?> >Belum
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" id="optionsRadios1" name="status_baptis" <?=$checked1;?>>Sudah
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Baptis<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_baptis" name="tmpt_baptis" value="" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Baptis<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_baptis" name="tgl_baptis" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <?php
            $checked1="";
            $checked0="";
          ?>
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Sidi<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <label>
                <input type="radio" value="0" id="optionsRadios2" name="status_sidi" <?=$checked0;?>>Belum
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" id="optionsRadios1" name="status_sidi" <?=$checked1;?>>Sudah
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Sidi<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_sidi" name="tmpt_sidi" value="" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Sidi <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_sidi" name="tgl_sidi" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kawin<span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select class="form-control" name="sts_kawin" id="sts_kawin" required>
                <option value='' disabled selected >Pilih</option>
                <?php
                  foreach ( lsKawin() as $keyKawin => $valueKawin) {
                    # code...
                ?>
                  <option value='<?=$valueKawin->id;?>'><?=$valueKawin->status_kawin;?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Menikah<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_nikah " name="tmpt_nikah" value="" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Menikah<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_nikah" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" name="tgl_nikah" value="">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Attestasi Masuk<span class="required">**</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input class="form-control datepicker" id="tgl_attestasi_masuk" name="tgl_attestasi_masuk" value="" placeholder="Tanggal-Bulan-Tahun">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Agama/Gereja Asal<span class="required">**</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="pindah_dari" name="pindah_dari" placeholder="GKP Cawang atau Islam" value="">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Telepon/HP<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="telepon" name="telepon" value="" placeholder="081122334456678 atau 0218466232">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Gol. Darah
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" id="golongandarah" name="golongandarah" value="" class="form-control" placeholder="A/B/O/AB atau A+/A-/B+/B-/O+/O-/AB+/AB-">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Pendidikan Terakhir<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="pndk_akhir_new" name="pndk_akhir_new" placeholder="SD/SMP/SMA/ Khusus Sarjana > 1: S1 S.Kom; S1 S.Psi; S1 S.E">
            <select class="form-control" id="pndk_akhir" name="pndk_akhir">
              <option value='' disabled selected>Pilih</option>
              <option value='Tidak Diketahui' >Tidak Diketahui</option>
              <?php
                foreach (lsPendidikan() as $keyPendidikan => $valuePendidikan) {
                  # code...
              ?>
                <option value='<?=$valuePendidikan->pndk_akhir;?>'><?=$valuePendidikan->pndk_akhir;?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Pekerjaan
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" id="sts_pekerjaan" name="sts_pekerjaan">
              <option disabled="" selected="" value="">Pilih</option>
              <option value="1">Sudah Bekerja</option>
              <option value="0">Belum Bekerja</option>
              <option value="2">Pensiun</option>
              <?php
               /* $lsPekerjaan=lsPekerjaan();
                foreach ($lsPekerjaan as $keyPekerjaan => $valuePekerjaan) {
              ?>
                  <option value="<?=$valuePekerjaan->pekerjaan;?>"><?=$valuePekerjaan->pekerjaan;?></option>
              <?php
                }*/
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <?php
            $checked1="";
            $checked0="";
          ?>
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Keanggotaan<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <label>
                <input type="radio" value="0" id="optionsRadios2" name="sts_anggota" <?=$checked0;?>>Tidak Aktif
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" id="optionsRadios1" name="sts_anggota" <?=$checked1;?>>Aktif
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Meninggal
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input class="form-control datepicker" id="tgl_meninggal" name="tgl_meninggal" value="" placeholder="Tanggal-Bulan-Tahun">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi Pemakaman
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="tmpt_meninggal" name="tmpt_meninggal" placeholder="TPU, Jamblang" value="">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Lampiran Terkait
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="flat" name="lampiran_baptis" value="1" > Surat Baptis
              </label>
            &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_sidi" value="1" > Surat Sidi
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_nikah" value="1" > Surat Nikah
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_ktp" value="1" > Surat KTP
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_kk" value="1" > Surat KK
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Catatan Khusus" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" >Close</button>
          <input type="reset" class="btn btn-primary" value="Reset">
          <input type="submit" class="btn btn-success" value="Add" name="SaveAddAnggota">
        </div>
      </div>
    
    </form>
<?php
  }
  else if(isset($type) && $type=='editAnggota'){
    //get data anggota jemaat
    $AnggotaJemaat=$this->m_model->selectas('id', $AnggotaId, 'anggota_jemaat');
    if(count($AnggotaJemaat)>0){
      $value=$AnggotaJemaat[0];
?>
    <form class="form-horizontal form-label-left" action="<?=base_url();?>admin/DataJemaat/" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Anggota Jemaat</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Nomor Anggota
            <label class="label label-info">New</label>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" class="form-control" disabled="disabled" value="<?=$value->no_anggota;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Lengkap<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="hidden" class="form-control" name="ags_kwg_detail_id" value="<?=$value->id;?>">
            <input type="hidden" class="form-control" name="no_urut" value="<?=$value->no_urut;?>">
            <input type="hidden" class="form-control" name="kwg_no" value="<?=$value->kwg_no;?>">
            <input type="text" class="form-control" placeholder="Nama Anggota Jemaat" name="nama_lengkap" value="<?=$value->nama_lengkap;?>">
          </div>
        </div>
        <div class="form-group">
          <?php
            $checked1="";
            $checked0="";
            if($value->jns_kelamin=='L'){
              $checked1="checked";
            }
            else{
              $checked0="checked";
            }
          ?>
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kelamin<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <label>
                <input type="radio" value="P" id="jns_kelamin0" name="jns_kelamin" <?=$checked0;?>>Perempuan
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="L" id="jns_kelamin1" name="jns_kelamin" <?=$checked1;?>>Laki-laki
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Hubungan Keluarga<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" required id="hub_kwg" name="hub_kwg">
              <option value='' disabled selected>Pilih</option>
              <?php
                foreach ($hub_kwg as $keyHub_kwg => $valueHub_kwg) {
                  # code...
              ?>
                <option value='<?=$valueHub_kwg->idhubkel;?>' <?php if($value->hub_kwg==$valueHub_kwg->id){echo 'selected';}?>><?=$valueHub_kwg->hub_keluarga;?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Wilayah<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" required id="kwg_wil" name="kwg_wil" >
              <option value='' >Pilih</option>
              <option value='0'>Belum Diketahui</option>
              <?php
                foreach (lsWil() as $lsWil => $valueWil) {
                  # code...
              ?>
                <option value='<?=$valueWil->id;?>' <?php if($value->kwg_wil==$valueWil->id){echo 'selected';}?>>Wilayah <?=$valueWil->wilayah;?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Lahir <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_lahir " name="tmpt_lahir" value="<?=$value->tmpt_lahir;?>" placeholder="Bekasi/Jakarta/Semaran, dll">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lahir <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=convert_time_dmy($value->tgl_lahir);?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Baptis<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <?php
                $checked1="";
                $checked0="";
                if($value->status_baptis==1){
                  $checked1="checked";
                }
                elseif($value->status_baptis==0){
                  $checked0="checked";
                }
              ?>
              <label>
                <input type="radio" value="0" id="optionsRadios2" name="status_baptis" <?=$checked0;?> >Belum
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" id="optionsRadios1" name="status_baptis" <?=$checked1;?>>Sudah
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Baptis<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_baptis" name="tmpt_baptis" value="<?=$value->tmpt_baptis;?>" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Baptis<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_baptis" name="tgl_baptis" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=convert_time_dmy($value->tgl_baptis);?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <?php
            $checked1="";
            $checked0="";
            if($value->status_sidi==1){
              $checked1="checked";
            }
            else{
              $checked0="checked";
            }
          ?>
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Sidi<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <label>
                <input type="radio" value="0" id="optionsRadios2" name="status_sidi" <?=$checked0;?>>Belum
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" id="optionsRadios1" name="status_sidi" <?=$checked1;?>>Sudah
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Sidi<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_sidi" name="tmpt_sidi" value="<?=$value->tmpt_sidi;?>" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Sidi <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_sidi" name="tgl_sidi" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="<?=convert_time_dmy($value->tgl_sidi);?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kawin<span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select class="form-control" name="sts_kawin" id="sts_kawin" required>
                <option value='' disabled selected >Pilih</option>
                <?php
                  foreach ( lsKawin() as $keyKawin => $valueKawin) {
                    # code...
                ?>
                  <option value='<?=$valueKawin->id;?>'><?=$valueKawin->status_kawin;?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Menikah<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="tmpt_nikah " name="tmpt_nikah" value="<?=$value->tmpt_nikah;?>" placeholder="GKP Kampung Sawah">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Menikah<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input type="text" class="form-control datepicker" id="tgl_nikah" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" name="tgl_nikah" value="<?=convert_time_dmy($value->tgl_nikah);?>">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Attestasi Masuk<span class="required">**</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input class="form-control datepicker" id="tgl_attestasi_masuk" name="tgl_attestasi_masuk" value="<?=convert_time_dmy($value->tgl_attestasi_masuk);?>" placeholder="Tanggal-Bulan-Tahun">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Agama/Gereja Asal<span class="required">**</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="pindah_dari" name="pindah_dari" placeholder="GKP Cawang atau Islam" value="<?=$value->pindah_dari;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Telepon/HP<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="telepon" name="telepon" value="<?=$value->telepon;?>" placeholder="081122334456678 atau 0218466232">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Gol. Darah
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" id="golongandarah" name="golongandarah" value="<?=$value->golongandarah;?>" class="form-control" placeholder="A/B/O/AB atau A+/A-/B+/B-/O+/O-/AB+/AB-">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Pendidikan Terakhir<span class="required">*</span></label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input class="form-control" id="pndk_akhir_new" name="pndk_akhir_new" placeholder="SD/SMP/SMA/ Khusus Sarjana > 1: S1 S.Kom; S1 S.Psi; S1 S.E">
            <select class="form-control" id="pndk_akhir" name="pndk_akhir">
              <option value='' disabled selected>Pilih</option>
              <option value='Tidak Diketahui' >Tidak Diketahui</option>
              <?php
                foreach (lsPendidikan() as $keyPendidikan => $valuePendidikan) {
                  # code...
              ?>
                <option value='<?=$valuePendidikan->pndk_akhir;?>'><?=$valuePendidikan->pndk_akhir;?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Pekerjaan
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select class="form-control" id="sts_pekerjaan" name="sts_pekerjaan">
              <option disabled="" selected="" value="">Pilih</option>
              <option value="1">Sudah Bekerja</option>
              <option value="0">Belum Bekerja</option>
              <option value="2">Pensiun</option>
              <?php
               /* $lsPekerjaan=lsPekerjaan();
                foreach ($lsPekerjaan as $keyPekerjaan => $valuePekerjaan) {
              ?>
                  <option value="<?=$valuePekerjaan->pekerjaan;?>"><?=$valuePekerjaan->pekerjaan;?></option>
              <?php
                }*/
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <?php
            $checked1="";
            $checked0="";
            if(strtolower($value->sts_anggota)=='1'){
              $checked1="checked";
            }
            else{
              $checked0="checked";
            }
          ?>
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Keanggotaan<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="radio">
              <label>
                <input type="radio" value="0" id="optionsRadios2" name="sts_anggota" <?=$checked0;?>>Tidak Aktif
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" value="1" id="optionsRadios1" name="sts_anggota" <?=$checked1;?>>Aktif
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Meninggal
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group">
              <input class="form-control datepicker" id="tgl_meninggal" name="tgl_meninggal" value="<?=convert_time_dmy($value->tgl_meninggal);?>" placeholder="Tanggal-Bulan-Tahun">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi Pemakaman
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="tmpt_meninggal" name="tmpt_meninggal" placeholder="TPU, Jamblang" value="<?=$value->tmpt_meninggal;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Lampiran Terkait
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="flat" name="lampiran_baptis" value="1" <?php if($value->lampiran_baptis==1){echo "checked='checked'";}?>> Surat Baptis
              </label>
            &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_sidi" value="1" <?php if($value->lampiran_sidi==1){echo "checked='checked'";}?>> Surat Sidi
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_nikah" value="1" <?php if($value->lampiran_nikah==1){echo "checked='checked'";}?>> Surat Nikah
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_ktp" value="1" <?php if($value->lampiran_ktp==1){echo "checked='checked'";}?>> Surat KTP
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label>
                <input type="checkbox" class="flat" name="lampiran_kk" value="1" <?php if($value->lampiran_kk==1){echo "checked='checked'";}?>> Surat KK
              </label>
              <div id="btn-formuploadlampiran" class="btn btn-warning btn-sm pull-right" noAnggota="<?=$value->no_anggota;?>" namaAnggota="<?=$value->nama_lengkap;?>" href="<?=base_url();?>admin/form_upload_att/<?=$value->id;?>">
                <i class="fa fa-upload "></i>&nbsp;
                Upload
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan
          </label>
          <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Catatan Khusus" value="<?=$value->remarks;?>">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" >Close</button>
          <input type="reset" class="btn btn-primary" value="Reset">
          <input type="submit" class="btn btn-success" value="Save" name="SaveEditAnggota">
        </div>
      </div>
    </form>
    <script type="text/javascript">
      $('#pekerjaan').val('<?=$value->pekerjaan;?>');
      $('#hub_kwg').val('<?=$value->hub_kwg;?>');
      $('#sts_kawin').val('<?=$value->sts_kawin;?>');
      $('#pndk_akhir').val('<?=$value->pndk_akhir;?>');
      $('#kwg_wil').val('<?=$value->kwg_wil;?>');
    </script>
<?php
    }
  }
?>

<script type="text/javascript">
  /*$('.single_cal1').daterangepicker({
    singleDatePicker: true,
    singleClasses: "picker_1",
    locale: {
      format: 'DD-MM-YYYY'
    }, 
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });*/
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
  });
</script>

<?php
  if(isset($type) && $type=='editAnggota'){
    if($value->tgl_nikah == null || $value->tgl_nikah == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_nikah').val('');
    </script>
<?php
    }
    if($value->tgl_baptis == null || $value->tgl_baptis == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_baptis').val('');
    </script>
<?php
    }
    if($value->tgl_sidi == null || $value->tgl_sidi == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_sidi').val('');
    </script>
<?php
    }
    if($value->tgl_lahir == null || $value->tgl_lahir == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_lahir').val('');
    </script>
<?php
    }
    if($value->tgl_meninggal == null || $value->tgl_meninggal == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_meninggal').val('');
    </script>
<?php
    }
    if($value->tgl_attestasi_masuk == null || $value->tgl_attestasi_masuk == '0000-00-00'){
?>
    <script type="text/javascript">
      $('#tgl_attestasi_masuk').val('');
    </script>
<?php
    }
  }
?>