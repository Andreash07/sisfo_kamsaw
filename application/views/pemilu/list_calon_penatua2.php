<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				$this->load->view('pemilu/searchbox_pnt2');
				?>
			</div>
		</div>
		<div class="col-xs-12">
          	<div class="x_panel tile">
          		<span>Menampilakn <b><?=count($calon);?></b> dari <b><?=$totalofData;?></b></span>
				<?= $pagingnation; ?>
	            <div class="x_title h3">
	            	Daftar Calon PN (Tahap 2)
	            </div>
		        <div class="x_content" style="overflow-y: auto;" id="div_content">
	            	<?php $this->load->view('pemilu/list_calon2', array('calon'=>$calon));?>
		        </div>
            	<?=$pagingnation;?>
            </div>
    	</div>
	</div>
</div>



<?php

$this->load->view('layout/footer');

?>
<script type="text/javascript">
	$(document).on('click', '[id=editAnggota]', function(e){
		url=$(this).attr('href');
		$.get(url, function(data){
			$('#modal-content').html(data)
		})
	})

	$(document).on('click', '[id=uploadFoto]', function(e){
		$('#modal-content').html('')
		dataMap={}
		dataMap['recid']=$(this).attr('recid')
		url='<?=base_url();?>pnppj/upload_foto_calon2';
		$.post(url, dataMap, function(data){
			$('#modal-content').html(data)
		})
	})
</script>