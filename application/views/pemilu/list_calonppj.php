<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				$this->load->view('pemilu/searchbox_calonppj.php');
				?>
			</div>
		</div>
		<div class="col-xs-12">
          	<div class="x_panel tile">
          		<span>Menampilakn <b><?=count($calon);?></b> dari <b><?=$totalofData;?></b></span>
				<?= $pagingnation; ?>
	            <div class="x_title h3">
	            	Daftar Calon PPJ
	            </div>
		        <div class="x_content" style="overflow-y: auto;" id="div_content">
	            	<?php $this->load->view('pemilu/listcalonppj', array('calon'=>$calon));?>
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
		url='<?=base_url();?>pnppj/upload_foto_ppj';
		$.post(url, dataMap, function(data){
			$('#modal-content').html(data)
		})
	})

	$(document).on('click', '[class=js-switch]', function(e){
		url="<?=base_url();?>pnppj/statusppj";
		dataMap={}
      	dataMap['recid']=$(this).attr('recid') //per 27 juni 2025 recidnya itu bakal_calon_id dari table anggota_jemaat_bakal_calon
		if($(this).prop('checked') == true){
	      //alert("checking");
	      	dataMap['locked']=1 //1 menerima Bakal Calon
	      	txt="Apakah Anda yakin ingin menerima "+$(this).attr('title')+" sebagai Bakal Calon PPJ?";
	    }else{
	      //alert("unchecking");
	      	dataMap['locked']=-1//-1 membatalkan Bakal Calon
	      	txt="Apakah Anda yakin ingin membatalkan "+$(this).attr('title')+" sebagai Bakal Calon PPJ?";
	    } 

	    var r = confirm(txt);
		if (r == false) {
			e.preventDefault();
			return false;
		} 

	    $.post(url, dataMap, function(data){
	    	json=$.parseJSON(data)
		})
	})


</script>