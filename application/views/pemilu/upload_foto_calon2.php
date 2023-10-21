<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Upload Foto Calon</h4>
</div>
<div class="modal-body">
	<div class="row">
	  	<div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
	          <div class="x_content">
	            <form class="dropzone" id="uploadzone">
	            	<input type="hidden" value="<?=$recid;?>" name="recid">
	            	<input type="hidden" value="upload" name="action">
	            	
	            </form>
	            <br />
	            <br />
	            <br />
	            <br />
	          </div>
	        </div>
	  	</div>
	</div>
</div>
<div class="modal-footer">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
</div>

<script type="text/javascript">
	$("#uploadzone").dropzone({ 
		url: "<?=base_url();?>pnppj/upload_foto_calon2",
		uploadMultiple: false,
		maxFilesize: 6,
		acceptedFiles: 'image/*'

	});
</script>