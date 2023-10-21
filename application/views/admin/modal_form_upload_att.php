<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Upload Lampiran</h4>
</div>
<div class="modal-body">
  <div class="form-group">
    <div class="row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
        Nomor Anggota
      </label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" disabled="disabled" value="<?=$no_Anggota;?>" placeholder="Auto">
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Lengkap<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input disabled="disabled" type="text" class="form-control" placeholder="Nama Anggota Jemaat" name="nama_lengkap" value="<?=$nama_Anggota;?>">
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col-md-6 col-sm-4 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <label class="text-danger"><b>* Max size file File (MegaByte): 10 MB</b></label>
            <form class="dropzone" id="uploadzone1">
              <select name="kategori_lampiran" id="kategori_lampiran">
                <option value="1">Surat Baptis</option>
                <option value="2">Surat SIDI</option>
                <option value="3">Surat Nikah</option>
                <option value="4">KTP</option>
                <option value="5">KK</option>
              </select>
              <input type="hidden" value="<?=$angjem_id;?>" name="recid" id="recid_uploadLampiran">
              <input type="hidden" value="upload" name="action">
            </form>
            <br />
            <br />
            <br />
            <br />
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-8 col-xs-12">
        <H4>File Lampiran </H4>
        <div class="row" id="content_lampiran">
        </div>

      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" >Close</button>
  </div>
</div>

<script type="text/javascript">
  $("#uploadzone1").dropzone({ 
    url: "<?=base_url();?>admin/upload_lampiran",
    uploadMultiple: false,
    maxFilesize: 6,
    acceptedFiles: 'image/*'

  });
</script>