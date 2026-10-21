<?php

$this->load->view('layout/header');

?>
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<form class="form-horizontal form-label-left" id="form_add_kk"  name="form_add_kk" method="POST" action="<?=base_url();?>Anggota_pengurus/save">
						<div class="x_title">
							<h4>Tambah Data Anggota Pengurus</h4>
					    </div>
						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="anggota_jemaat">Nama Anggota<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select id="anggota_jemaat" name="anggota_jemaat[]" required="required" class="form-control col-md-7 col-xs-12 js-example-data-ajax" required multiple="multiple">
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pelayanan<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="js-example-basic-single form-control col-md-7 col-xs-12" id="pelayanan" name="pelayanan" required>
										<option value="" selected disabled>Pilih</option>
										<option value="KPA">KPA</option>
										<option value="KTR">KTR</option>
										<option value="KOREM">KOREM</option>
										<option value="KOPEM">KOPEM</option>
										<option value="KKM">KKM</option>
										<option value="KOMPRI">KOMPRI</option>
										<option value="KPP">KPP</option>
										<option value="KOMLAN">KOMLAN</option>
										<option value="KLMG">KLMG</option>
										<option value="KHRG">KHRG</option>
										<option value="KOMBINA">KOMBINA</option>
										<option value="KOMDIKSOS">KOMDIKSOS</option>
										<option value="KOMSAK">KOMSAK</option>
										<option value="KOMPELKES">KOMPELKES</option>
										<option value="KPKP">KPKP</option>
										<option value="LITBANG">LITBANG</option>
										<option value="MIK">MIK</option>
										<option value="KPPJ">KPPJ</option>
										<option value="KRT">KRT</option>
										<option value="Pengurus Teritorial 1">Pengurus Teritorial 1</option>
										<option value="Pengurus Teritorial 2">Pengurus Teritorial 2</option>
										<option value="Pengurus Teritorial 3">Pengurus Teritorial 3</option>
										<option value="Pengurus Teritorial 4">Pengurus Teritorial 4</option>
										<option value="Pengurus Teritorial 5">Pengurus Teritorial 5</option>
										<option value="Pengurus Teritorial 6">Pengurus Teritorial 6</option>
										<option value="Pengurus Teritorial 7">Pengurus Teritorial 7</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Periode</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <select required class="js-example-basic-single form-control col-md-7 col-xs-12" id="periode" name="periode" >
								  	<option value="" disabled>Pilih</option>
								  	<?php
								  		foreach ($periode_pelayanan as $keyWil => $Wil) {
						  			?>
						  					<option value="<?=$Wil->id;?>"><?=$Wil->name;?></option>
						  			<?php
								  		}
								  	?>
								  </select>
								</div>
							</div>
							<div class="form-group">
								<label for="telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Nama diusulkan</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input required class="form-control col-md-7 col-xs-12" id="tgl_usulkan" name="tgl_usulkan" type="date">
								</div>
							</div>
						</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default pull-right" id="save_kk" name="add" value="add">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php

$this->load->view('layout/footer');

?>
<!-- select2 -->
<link href="<?=base_url();?>/vendors/select2/dist/css/select2.css" rel="stylesheet">

<!-- select2 -->
<script src="<?=base_url();?>vendors/select2/dist/js/select2.full.js"></script>

<script>
	$(document).ready(function() {
	    $('.js-example-basic-single').select2();

		$('.js-example-data-ajax').select2({
		    ajax: {
		        url: '<?=base_url();?>Anggota_pengurus/search_anggota_jemaat',
		        data: function(params) {
		            var query = {
		                search: params.term,
		            }

		            // Query parameters will be ?search=[term]&page=[page]
		            return query;
		        },
		        dataType: 'json'
		        // Additional AJAX parameters go here; see the end of this page for the full code of this example
		    }
		});

		//$('.js-example-data-ajax').select2();

	});
</script>