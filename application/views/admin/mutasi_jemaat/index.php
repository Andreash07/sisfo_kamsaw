<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<div class="x_panel tile" style="max-height: 550px; height: 550px;">
                <div class="x_title">
                  	<h2>Daftar Keluarga</h2>
                  	<form action="<?=base_url();?>ajax/get_keluarga" method="POST" id="form_search_kwg">
						<div class="form-group">
							<div class="col-md-10 col-xs-8">
							  <input type="hidden" id="view" name="view" class="form-control" value="ajax/ls_keluarga">
							  <input type="text" id="keyword_keluarga" name="keyword_keluarga" class="form-control" placeholder="Ketik Nama Keluarga/Anggota Jemaat ...">
							</div>
							<div class="col-md-2 col-xs-4">
							  	<button id="btn_search" class="btn btn-warning " onclick="event.preventDefault();"><i class="fa fa-search"></i> Cari</button>
						  	</div>
						</div>
                	</form>
              		<div class="clearfix"></div>
                </div>
                <div class="x_content" id="div_datakeluarga">
                	
                </div>
          	</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="x_panel tile" style="max-height: 550px; height: 550px; overflow: auto;">
                <div class="x_title">
                  	<h2 style="display: flex;">Form Keluarga Baru</h2>
                  	<button id="btn_add_mutasi" class="btn btn-success pull-right" onclick="event.preventDefault();"><i class="fa fa-save"></i> Simpan</button>
              		<div class="clearfix"></div>
                </div>
                <div class="x_content" id="div_mutasikeluarga">
                	<form action="<?=base_url();?>admin/mutasi_keluarga/add" method="POST" id="form_kwg_mutasi">
                		<div class="row">
	                		<div class="form-group col-xs-12">
								<label class="control-label" for="nama_kk">Nama Keluarga<span class="required">*</span>
								</label>
								  <input id="nama_kk" name="nama_kk" required="required" class="form-control " readonly style="cursor: not-allowed;" placeholder="Nama akan generate otomatis saat kepala Keluarga dipilih">
							</div>
						</div>
						<div class="row">
	                		<div class="form-group col-xs-12">
								<label class="control-label" for="alamat">Alamat<span class="required">*</span>
								</label>
								  <textarea id="alamat" name="alamat" required="required" class="form-control "></textarea>
							</div>
						</div>
                		<div class="row">
							<div class="form-group col-xs-7 col-sm-8 col-md-9" >
								<label for="telepon" class="control-label">Nomor Telpon</label>
								<input id="telepon" name="telepon" class="form-control col-md-7 col-xs-12" type="text">
							</div>
							<div class="form-group col-xs-5 col-sm-4 col-md-3">
								<label class="control-label">
									Wilayah
									<span class="required">*</span>
								</label>
								<select class="form-control" name="wilayah" id="wilayah" required>
				  					<option value="0">Pilih</option>
								  	<?php
								  		foreach ($ls_wilayah as $keyWil => $Wil) {
								  			# code...
						  			?>
						  					<option value="<?=$Wil->wilayah;?>"><?=$Wil->wilayah;?></option>
						  			<?php
								  		}
								  	?>
							  	</select>
							</div>
						</div>
						<div class="divider"></div>
                	</form>
                </div>
          	</div>
		</div>
	</div>
</div>
<?php
$this->load->view('layout/footer');
?>
<script type="text/javascript">
	$(document).on('click', '[id=btn_search]', function(e){
		$('#div_datakeluarga').html('<i class="fa fa-circle-o-notch fa-spin fa-2x"></i> Memuat Data ...');
		e.preventDefault();
		dataMap={}
		dataMap=$('#form_search_kwg').serialize();
		url=$('#form_search_kwg').attr('action')
		$.post(url, dataMap, function(data){
			$('#div_datakeluarga').html(data);
		})
	})

	$(document).on('click', '[id=btn_choose_kwg]', function(e){
		$('#form_kwg_mutasi').append('<span id="loading_formMutasi" ><i class="fa fa-circle-o-notch fa-spin fa-2x"></i> Memuat Data ...</span>');
		e.preventDefault();
		recid=$(this).attr('kwg_id');
		dataMap={}
		dataMap=$('#form_kwg'+recid).serialize();
		url=$('#form_kwg'+recid).attr('action')
		$.post(url, dataMap, function(data){
			$('#form_kwg_mutasi').append(data);
			$('#loading_formMutasi').remove()
		})
	})

	$(document).on('click', '[id=btn_cancle_addlist_angjem]', function(e){
		e.preventDefault();
		row_id=$(this).attr('rowid')
		$('#'+row_id).remove()


	})


	$(document).on('click', '[id=btn_add_mutasi]', function(e){
		e.preventDefault()
		$('#loading').show();
		url=$('#form_kwg_mutasi').attr('action')
		dataMap={}
		dataMap=$('#form_kwg_mutasi').serialize();
		$.post(url, dataMap, function(data){
			json=$.parseJSON(data)
			if(json.status==1){
				iziToast.success({
		            title: json.msg,
		            message: '',
		            position: "topRight",
		            class: "iziToast-success",
		        });
		        setTimeout(function(){window.location.replace("<?=base_url();?>admin/mutasi_keluarga");}, 3000)
			}
			else if(json.status==0){
				iziToast.error({
		            title: json.msg,
		            message: 'Lakukan pengecekan pada Daftar Keluarga terlebih dulu!',
		            position: "topRight",
		            class: "iziToast-danger",

		        });
		        setTimeout(function(){window.location.replace("<?=base_url();?>admin/mutasi_keluarga");}, 3000)
			}
		})
		setTimeout(function(){$('#loading').hide();}, 10000)

	})

	$(document).on('change', '[id^=hub_keluarga]', function(e){
		value=$(this).val()
		if(value==1){
			recid=$(this).attr('recid')
			//console.log(value)
			//console.log(recid)
			nama=$('#name_lengkap'+recid).val()
			//console.log(nama)
		}
		else{
			return;

		}
			//get nama 
			$('#nama_kk').val(nama)
	})
</script>