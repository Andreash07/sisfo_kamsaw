<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">Catatan Proses Anggota Pengurus Pelayanan</h4>
</div>
<div class="modal-body">
  	<div class="row">
    	<form id="form_note_anggota" action="<?=base_url();?>/Anggota_pengurus/save_note" method="POST">
            <div class="item form-group col-xs-12">
                <input type="text" name="nama" value="<?=$nama;?>" class="form-control" disabled>
            </div>
        <?php 
            foreach ($data as $key => $value) {
                // code...
        ?>
            <input type="hidden" name="auth" id="auth" value="<?=md5('JKAhk127(*1&'.$value->id);?>" class="form-control">
            <div class="item form-group col-xs-12">
            	<textarea type="text" id="notes" name="notes" required="required" class="form-control" placeholder="Masukan catatan dari yang bersangkutan selama proses pembentukan Anggota Pengurus Pelayanan"><?=$value->notes;?></textarea>
          	</div>
        <?php 
            }
        ?>
    	</form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-primary" id="btn_simpan_note_anggota">Simpan</button>
</div>