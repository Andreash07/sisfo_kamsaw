<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">

	<div class="row">

		<div class="col-xs-12">

	<?php

	if($this->input->get('add')){

		$wilayah=$this->m_model->select('wilayah', 'wilayah', 'ASC');

	?>

		<div class="x_panel">

			<form class="form-horizontal form-label-left" id="form_add_kk"  name="form_add_kk" method="POST" action="<?=base_url();?>admin/DataJemaat">

					<div class="x_title">

						<h4>Data Keluarga</h4>

				    </div>

					<div class="x_content">

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama KK<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <input type="text" id="nama_kk" name="nama_kk" required="required" class="form-control col-md-7 col-xs-12">

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Alamat<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <textarea id="alamat" name="alamat" required="required" class="form-control col-md-7 col-xs-12"></textarea>

							</div>

						</div>

						<div class="form-group">

							<label for="telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Telpon</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <input id="telepon" name="telepon" class="form-control col-md-7 col-xs-12" type="text">

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12">

								Wilayah

								<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <select class="form-control" name="wilayah" id="wilayah">

							  	<?php
							  		foreach ($wilayah as $keyWil => $Wil) {

							  			# code...

					  			?>

					  					<option value="<?=$Wil->wilayah;?>"><?=$Wil->wilayah;?></option>

					  			<?php

							  		}

							  	?>

							  </select>

							</div>

						</div>

					</div>

				<div class="form-group">

					<button type="submit" class="btn btn-default pull-right" id="save_kk" name="add" value="add">Add</button>

				</div>

			</form>

		</div>



		<div class="x_panel">

				<div class="x_title">

					<h4>Data Anggota Keluarga</h4>

			    </div>

				<div class="x_content">

					<table class="table table-striped" id="item_sj">

						<thead>

							<tr>

								<th class="text-center">#</th>

								<th class="text-center" style="width:30%">Nomor Anggota</th>

								<th class="text-center" colspan="2" style="width:25%">Data Diri</th>

								<th class="text-center" style="width:15%">Talenta/Hoby</th>

								<th class="text-center" style="width:20%">Profesi</th>

								<th class="text-center" style="width:5%">Action</th>

							</tr>

						</thead>

						<tbody>

						</tbody>

					</table>

				</div>

			</div>

	<?php

	}

	if($this->input->get('edit')){

		$wilayah=$this->m_model->select('wilayah', 'wilayah', 'ASC');

		$id=$this->input->get('id');

		$dataKK=$this->m_model->selectas('id', $id, 'keluarga_jemaat');

		if(isset($dataKK) && count($dataKK)>0){

	?>

		<div class="x_panel" style="position: relative;">

			<img id="img_qrcode_kk" src="<?=base_url().$dataKK[0]->qrcode;?>" style="position: absolute; width: 120px; height: auto; right: 17px; top: 65px;" class="img-thumbnail hidden-xs">

			<form class="form-horizontal form-label-left" id="form_add_kk"  name="form_add_kk" method="POST" action="">

					<div class="x_title">

						<h4>Data Keluarga</h4>

				    </div>

					<div class="x_content">

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">No KK<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <input class="form-control col-md-7 col-xs-12" type="text" id="kwg_no" name="kwg_no" required="required" value="<?=$dataKK[0]->kwg_no;?>" disabled>

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Nama KK<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <input type="hidden" id="keluarga_jemaat_id" name="keluarga_jemaat_id" required="required" value="<?=$dataKK[0]->id;?>">

							  <input type="hidden" id="kwg_no" name="kwg_no" required="required" value="<?=$dataKK[0]->kwg_no;?>">

							  <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-md-7 col-xs-12" value="<?=$dataKK[0]->kwg_nama;?>">

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_alamat">Alamat

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <textarea id="kwg_alamat" name="kwg_alamat" class="form-control col-md-7 col-xs-12"><?=$dataKK[0]->kwg_alamat;?></textarea>

							</div>

						</div>

						<div class="form-group">

							<label for="kwg_telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Telpon</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <input id="kwg_telepon" name="kwg_telepon" class="form-control col-md-7 col-xs-12" type="text" value="<?=$dataKK[0]->kwg_telepon;?>">

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12">

								Wilayah

								<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <select class="form-control" name="kwg_wil" id="kwg_wil">

							  	<?php

							  		foreach ($wilayah as $keyWil => $Wil) {

							  			# code...

					  			?>

					  					<option value="<?=$Wil->wilayah;?>"><?=$Wil->wilayah;?></option>

					  			<?php

							  		}

							  	?>

							  </select>

							</div>

						</div>

					</div>

				<div class="form-group">

					<a class="btn btn-warning pull-left" href="<?=base_url();?>admin/<?=$this->uri->segment(2);?>	">Cancle</a>

					<input type="submit" class="btn btn-default pull-right" id="SaveEditKeluarga" name="SaveEditKeluarga" value="Update">

					<a class="btn btn-success pull-right" href="<?=base_url();?>pdf/kkwithbarcode.php?id=<?=$this->input->get('id');?>" target="_BLANK"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak</a>
					<?php 
					if($dataKK[0]->qrcode == null){
					?>
						<a id="btn_qrcode" class="btn btn-danger pull-right" href="<?=base_url();?>tools/generate_qrcode/<?=$this->input->get('id');?>" target="_BLANK"><i class="fa fa-qrcode"></i>&nbsp;&nbsp;QRcode</a>
					<?php
					}
					?>

				</div>

			</form>

		</div>

		<script type="text/javascript">

			$('#kwg_wil').val('<?=$dataKK[0]->kwg_wil;?>');

		</script>

	<?php

			//kwg_no pada anggota_jemaat adalah value dari anggota_jemaat_id

			$anggota_KK=$this->m_model->selectas3('kwg_no', $dataKK[0]->id,'delete_user IS NULL', NULL, 'status', 1, 'anggota_jemaat', 'no_urut', 'ASC');
			$KategoriPelayanan=getKategoriPelayanan();
	?>
			<div class="x_panel">

				<div class="x_title">

					<h4 class="">Data Anggota Keluarga</h4>

					<a id="addAnggota" class="btn btn-primary" onclick="event.preventDefault()" href="<?= base_url().'/admin/'.$this->uri->segment(2).'?addAnggota=true';?>" data-toggle="modal" data-target="#myModal">

						<i class="fa fa-plus "></i> Anggota

					</a>

					<a class="btn btn-warning" onclick="event.preventDefault()" href="#!" data-toggle="modal" data-target="#myModal_mutasi">
						<i class="fa fa-plus "></i> Mutasi Anggota
					</a>

			    </div>

				<div class="x_content table-responsive">

					<table class="table table-striped" id="item_sj">

						<thead>

							<tr>

								<th class="text-center">#</th>

								<th class="text-center" colspan="2" style="width:20%">Nomor Anggota</th>

								<th class="text-center" style="width:30%">Data Diri</th>

								<th class="text-center" style="width:20%">Talenta/Hoby/Profesi</th>

								<th class="text-center" style="width:20%">Pelayanan</th>

								<th class="text-center" style="width:10%">Action</th>

							</tr>

						</thead>

						<tbody>

							<?php
							$kawin=lsKawin();
							$lsKawin=array();
							foreach($kawin as $key => $value){
								$lsKawin[$value->id]=$value->status_kawin;
							}

							if(isset($anggota_KK) && count($anggota_KK)>0){

								foreach ($anggota_KK as $keyAnggota_KK => $valueAnggota_KK) {

									//get hoby Jemaat

									$hoby=$this->m_model->selectas('anggota_jemaat_id', $valueAnggota_KK->id, 'hoby_jemaat');

									//get profesi Jemaat

									$profesi=$this->m_model->selectas('anggota_jemaat_id', $valueAnggota_KK->id, 'profesi_jemaat');

									# code...

									if($valueAnggota_KK->telepon == ''){

										$valueAnggota_KK->telepon= '-';

									}



									$baptis="Belum";

									$sidi="Belum";

									$nikah="Belum";

									if($valueAnggota_KK->status_baptis!= '' || $valueAnggota_KK->status_baptis!= null){

										$baptis=$valueAnggota_KK->tmpt_baptis.', '.convert_tgl_dMY($valueAnggota_KK->tgl_baptis);

									}



									if($valueAnggota_KK->status_sidi!= '' || $valueAnggota_KK->status_sidi!= null){

										$sidi=$valueAnggota_KK->tmpt_sidi.', '.convert_tgl_dMY($valueAnggota_KK->tgl_sidi);

									}



									if($valueAnggota_KK->sts_kawin!= '' || $valueAnggota_KK->sts_kawin!= null){

										$nikah=$valueAnggota_KK->tmpt_nikah.', '.convert_tgl_dMY($valueAnggota_KK->tgl_nikah);
										if($valueAnggota_KK->sts_kawin!=2){
											$nikah=$lsKawin[$valueAnggota_KK->sts_kawin];
										}

									}
									if($valueAnggota_KK->sts_anggota==1){

		            		$sts='<i class="fa fa-check-square text-success" title="Aktif"></i> Aktif';

			            }
			            else{
		            		$sts='<i class="fa fa-times text-danger" title="Tidak Aktif"></i> Tidak Aktif';
			            }
							?>

								<tr>

									<td class="text-center">
										<?=$keyAnggota_KK+1;?>
									</td>

									<td class="text-center" colspan="2" style="width:20%">

										<?= $valueAnggota_KK->no_anggota;?>
										<br>
										<?=$sts;?>
									</td>

									<td class="text-left" style="width:30%; line-height: 2">

										<b>Nama:</b> <?= $valueAnggota_KK->nama_lengkap;?>

										<br>

										<b>Tempat, TTL:</b> <?= $valueAnggota_KK->tmpt_lahir.', '.convert_tgl_dMY($valueAnggota_KK->tgl_lahir) ;?>

										<br>

										<b>Telp/HP:</b> <?= $valueAnggota_KK->telepon;?>

										<br>

										<b>Baptis:</b> <?= $baptis;?>

										<br>

										<b>Sidi:</b> <?=$sidi;?>

										<br>

										<b>Nikah:</b> <?= $nikah;?>

									</td>

									<td style="width:20%">

										<label>Talenta</label>

										<a id="editHobyProfesi" href="<?= base_url().'admin/'.$this->uri->segment(2).'?editHobyProfesi=true&';?>id=<?php echo $valueAnggota_KK->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal">

											<span class="fa fa-pencil pull-right" style="width:20%"></span>

										</a>

										<div class="clearfix"></div>

										<?php

											foreach ($hoby as $keyhoby => $valuehoby) {

												# code...

												echo '<span class="label label-success" style="margin-right:5px;">'.get_name('hoby', 'id', $valuehoby->hoby_id, 'name').'</span><div class="clearfix"></div>';

											}

										?>



										<div class="divider"></div>

										<label>Profesi</label>

										<a id="editHobyProfesi" href="<?= base_url().'admin/'.$this->uri->segment(2).'?editHobyProfesi=true&';?>id=<?php echo $valueAnggota_KK->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal">

											<span class="fa fa-pencil pull-right" style="width:20%"></span>

										</a>

										<div class="clearfix"></div>

										<?php

											foreach ($profesi as $keyprofesi => $valueprofesi) {

												# code...

												echo '<span class="label label-warning" style="margin-right:5px;">'.get_name('profesi', 'id', $valueprofesi->profesi_id, 'name').'</span><div class="clearfix"></div>';

											}

										?>

									</td>

									<td class="text-center" style="width:20%">
										<select id="KategoriPelayanan_angjem" recid="<?=$valueAnggota_KK->id;?>" class="form-control">
										<?php 
										foreach ($KategoriPelayanan as $keyKategoriPelayanan => $valueKategoriPelayanan) {
											# code...
											$selectKdGroup="";
											if($valueKategoriPelayanan->id==$valueAnggota_KK->kd_group_id){
												$selectKdGroup='selected';
											}
										?>
											<option value="<?=$valueKategoriPelayanan->id.'#'.$valueKategoriPelayanan->kd_group;?>" <?=$selectKdGroup;?>><?=$valueKategoriPelayanan->kd_group;?></option>
										<?php
										}
										?>
										</select>

										<div class="form-group">
											<div class="divider"></div>
											<label for="select_stst_kpkp<?=$valueAnggota_KK->id;?>">KPKP</label>
											<select class="form-control" id="select_stst_kpkp<?=$valueAnggota_KK->id;?>" name="select_stst_kpkp<?=$valueAnggota_KK->id;?>" recid="<?=$valueAnggota_KK->id;?>">
												<option value="0" <?php if($valueAnggota_KK->sts_kpkp==0){echo 'selected="selected"';}; ?>>Tidak Aktif</option>
												<option value="1" <?php if($valueAnggota_KK->sts_kpkp==1){echo 'selected="selected"';}; ?> >Aktif</option>
											</select>

											<select class="form-control" id="select_aturan_kpkp<?=$valueAnggota_KK->id;?>" name="select_aturan_kpkp<?=$valueAnggota_KK->id;?>" recid="<?=$valueAnggota_KK->id;?>">
												<option value="-1" <?php if($valueAnggota_KK->aturan_kpkp==-1){echo 'selected="selected"';}; ?>> Pilih Kategori Aturan KPKP</option>
												<option value="0" <?php if($valueAnggota_KK->aturan_kpkp==0){echo 'selected="selected"';}; ?>> < 2020 kebawah</option>
												<option value="1" <?php if($valueAnggota_KK->aturan_kpkp==1){echo 'selected="selected"';}; ?> > >= 2020 keatas</option>
											</select>
										</div>

									</td>

									<td class="text-center" style="width:10%">

										<a id="editAnggota" href="<?= base_url().'admin/'.$this->uri->segment(2).'?editAnggota=true&';?>id=<?php echo $valueAnggota_KK->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding: 2px 12px 2px 2px">

											<span class="fa fa-pencil" style="width:20%"></span>

										</a>

										<a id="delet" href="<?= base_url().'admin/'.$this->uri->segment(2).'?deleteanggota=true&id='.$valueAnggota_KK->id.'&kode='.md5(base64_encode($valueAnggota_KK->id.'delete')); ?>" class="confirm btn btn-danger" msg="Yakin ingin menghapus data ini?"  style="padding: 2px 12px 2px 2px">

											<span class="fa fa-trash" style="width:20%"></span>

										</a>
										<input type="text" name="no_urut" value="<?=$valueAnggota_KK->no_urut;?>" class="form-control text-center" recid="<?php echo $valueAnggota_KK->id; ?>">
									</td>

								</tr>

							<?php

								}

							}

							?>

						</tbody>

					</table>

				</div>

			</div>


			<!-- modal daftar jemaat yang bisa dimutasi -->
			<div class="modal fade" tabindex="-1" role="dialog" id="myModal_mutasi">
			    <div class="modal-dialog  modal-lg" role="document">
			        <div class="modal-content" id="modal-content_mutasi">
						<div class="row">
							<div class="col-sm-12 col-xs-12">
								<div class="x_panel tile" style="max-height: 550px; height: 550px;">
					                <div class="x_title">
					                  	<h2>Daftar Keluarga</h2>
					                  	<div class="clearfix"></div>
					                  	<form action="<?=base_url();?>ajax/get_keluarga" method="POST" id="form_search_kwg">
											<div class="form-group">
												<div class="col-sm-10 col-xs-8">
												  <input type="hidden" id="view" name="view" class="form-control" value="ajax/ls_keluarga">
												  <input type="hidden" id="add_mutasi_keluarga" name="add_mutasi_keluarga" class="form-control" value='1'>
												  <input type="text" id="keyword_keluarga" name="keyword_keluarga" class="form-control" placeholder="Ketik Nama Keluarga/Anggota Jemaat ...">
												</div>
												<div class="col-sm-2 col-xs-4">
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
						</div>
					</div>
			    </div>
			</div>
	<?php

		}
		else{

	?>

			<div class="x_panel">

				<div class="x_title">

					<h4>Data Keluarga</h4>

			    </div>

				<div class="x_content">

					<h4>Parameter Invalid</h4>	

				</div>

			</div>

	<?php

		}

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
				e.preventDefault();

				recid=$(this).attr('kwg_id');
				dataMap={}
				dataMap=$('#form_kwg'+recid).serialize();
				url='<?=base_url();?>admin/mutasi_keluarga/add_anggota_to_keluarga?kwg_new=<?=$dataKK[0]->id;?>';
				jemaat_name=$(this).attr('jemaat_name');
				var r = confirm("Apa yakin ingin menambahkan "+jemaat_name+" ke dalam keluarga <?=$dataKK[0]->kwg_nama;?>");
				if (r == false) {
				  return false;
				}
				$('#loading').show();
				$.post(url, dataMap, function(data){
					json=$.parseJSON(data)
					if(json.status==1){
						iziToast.success({
				            title: json.msg,
				            message: '',
				            position: "topRight",
				            class: "iziToast-success",
				        });
					}
					else if(json.status==0){
						iziToast.error({
				            title: json.msg,
				            message: 'Lakukan pengecekan pada Daftar Keluarga terlebih dulu!',
				            position: "topRight",
				            class: "iziToast-danger",

				        });
					}
					$('#loading').hide();
				})
			})

			$(document).on('change', '[group_input=hoby]', function(e){

				val=$(this).val();

				dataMap={}

				dataMap['anggota_jemaat']=$('#anggota_jemaat_talentaprofesi').val();

				dataMap['hoby_id']=val

				if($(this).is(':checked')==false){

					$.get('<?=base_url();?>admin/removeHoby/', dataMap, function(data){

						json=$.parseJSON(data);

						//window.location.href = "<?=$_SERVER['REQUEST_URI'];?>";

					})

				}

				else{

					$.get('<?=base_url();?>admin/addHoby/', dataMap, function(data){

						json=$.parseJSON(data);

						//window.location.href = "<?=$_SERVER['REQUEST_URI'];?>";

					})

				}



			})



			$(document).on('change', '[group_input=profesi]', function(e){

				val=$(this).val();

				dataMap={}

				dataMap['anggota_jemaat']=$('#anggota_jemaat_talentaprofesi').val();

				dataMap['profesi_id']=val

				if($(this).is(':checked')==false){

					$.get('<?=base_url();?>admin/removeProfesi/', dataMap, function(data){

						json=$.parseJSON(data);

						if(json.status==1){

							//window.location.href = "<?=$_SERVER['REQUEST_URI'];?>";

						}

					})

				}

				else{

					$.get('<?=base_url();?>admin/addProfesi/', dataMap, function(data){

						json=$.parseJSON(data);

						//window.location.href = "<?=$_SERVER['REQUEST_URI'];?>";

					})

				}



			})

			$(document).on('change', '[id=KategoriPelayanan_angjem]', function(e){
				e.preventDefault();
				dataMap={}
				dataMap['recid']=$(this).attr('recid')
				dataMap['value']=$(this).val()

				$.post('<?=base_url();?>admin/changeKategoryPelayanan', dataMap, function(data){
					json=$.parseJSON(data)
					if(json.status==1){
						iziToast.success({
				            title: '',

				            message: json.msg,

				            position: "topRight",

				        });
					}
					else{
						iziToast.error({
				            title: '',

				            message: json.msg,

				            position: "topRight",

				        });	
					}
				})

			})

		</script>

	<?php

	}

	else if(!$this->input->get('add') && !$this->input->get('edit')){

		if($this->session->userdata('status_remove')=='berhasil'){

	    $this->session->unset_userdata('status_remove');

	?>

	    <script type="text/javascript">

	        iziToast.show({

	            title: '',

	            message: 'Hapus Data Berhasil',

	            position: "topRight",

	            class: "iziToast-info",

	        });

	    </script>

	<?php

	  }

	  else if($this->session->userdata('status_remove')=='gagal'){

	    $this->session->unset_userdata('status_remove');

	?>

	    <script type="text/javascript">

	        iziToast.show({

	            title: '',

	            message: 'Hapus Data Gagal',

	            position: "topRight",

	            class: "iziToast-danger",

	        });

	    </script>

	<?php

	  }

	?>

		<?php

		if($this->uri->segment(2)!='DataJemaatOld'){

		?>

			

		<?php

		}

		$wilayah=$this->m_model->select('wilayah', 'wilayah', 'ASC');
		?>

		<div class="x_panel">

			<form class="form-horizontal form-label-left" method="GET" action="">

				<div class="x_title">

					<h4>Data Jemaat</h4>

			    </div>

				<div class="x_content">

					<div class="form-group">

						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Nama KK

						</label>

						<div class="col-md-6 col-sm-6 col-xs-12">

						  <input type="text" id="kwg_nama" name="kwg_nama" class="form-control col-md-7 col-xs-12" placeholder="Search Nama Keluarga" value="<?=$this->input->get('kwg_nama');?>">

						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-md-3 col-sm-3 col-xs-12">

							Wilayah

						</label>

						<div class="col-md-6 col-sm-6 col-xs-12">

						  <select class="form-control" name="wilayah" id="wilayah">

		  					<option value="">Pilih</option>

						  	<?php
						  		foreach ($wilayah as $keyWil => $Wil) {

						  			# code...
						  			$selected="";
							  		if($this->input->get('wilayah') == $Wil->wilayah){
						  				$selected="selected";
							  		}

				  			?>

				  					<option value="<?=$Wil->wilayah;?>" <?=$selected;?>><?=$Wil->wilayah;?></option>

				  			<?php

						  		}

						  	?>

						  </select>

						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-md-3 col-sm-3 col-xs-12">

							Status

						</label>

						<div class="col-md-6 col-sm-6 col-xs-12">

						  	<select class="form-control" name="status" id="status">

			  					<option value="" >Semua</option>
			  					<option value="1" <?php if($this->input->get('status') == 1){ echo "selected";} ?> >Aktif</option>
			  					<option value="-1" <?php if($this->input->get('status') == -1){ echo "selected";} ?> >Tidak Aktif</option>
						  	</select>

						</div>

					</div>

					<div class="form-group">

						<a href="<?=base_url().'admin/'.$this->uri->segment(2).'?add=true';?>" class="btn btn-success pull-left">Add</a>

						<a href="<?=base_url().'admin/mutasi_keluarga';?>" class="btn btn-warning pull-left">Mutasi Keluarga</a>

						<button type="submit" class="btn btn-default pull-right" name="search">Search</button>

					</div>

				</div>

			</form>

		</div>

			<?=$pagingnation;?>
		<div class="clearfix"></div>
		<div class="divider"></div>
		<div class="clearfix"></div>

		<div class="table-responsive">

			<table class="table table-striped" style="background:rgba(42, 63, 84, 0.1)">

				<thead>

					<tr>

						<th class="text-center">#</th>

						<th class="text-center" style="width:20%;">KK</th>

						<th class="text-center" style="width:30%;">Data Keluarga</th>

						<th class="text-center">Wilayah</th>

						<th class="text-center">Anggota KK</th>

						<th class="text-center" style="width:20%;">Action</th>

					</tr>

				</thead>

				<tbody>

			<?php

			if(isset($dataKK) && count($dataKK)>0){	

				foreach($dataKK as $key => $LsData){

					//check num_anggota keluarga

					//$LsData->num_anggota=count($this->m_model->selectas('kwg_no', $LsData->kwg_no, 'ags_kwg_detail_table'));

					//kasih pengecekan apakah keluarga tersebut masih akti atau tidak
					//biasanya keluarga yang tidak aktif dan masih muncul karena admin belum delete keluarga tersebut dan penonaktifkan kelurga tersebut dilakukan by system checker jadi tidak didelete. Itu terjadi karena anggota di dalam keluarga tersebut sudah tidak ada yang aktif jadi keluarga tersebut dinyatakan nonaktif by system tapi belum di delete tampilan admin.

					//pengecekan keluarga masih aktif atau nonaktif
					$lbl_sts_kwg='<label class="label label-success"><i class="fa fa-check-circle"></i> Aktif</label>';
					if($LsData->status <=0){
						$lbl_sts_kwg='<label class="label label-danger"><i class="fa fa-times"></i> Tidak Aktif</label>';
					}

			?>

					<tr>

						<td class="text-center"><?php echo $numStart+$key+1; ?></td>

						<td class="text-left">

							<a href="<?= base_url().'admin/'.$this->uri->segment(2).'?edit=true&';?>id=<?php echo $LsData->id; ?>">

								<?php echo $LsData->kwg_nama; ?>
								<br>
								<?php echo $lbl_sts_kwg; ?>

							</a>

						</td>

						<td class="text-left">

							<b>No KK</b>: <?=$LsData->kwg_no;?>

							<br>

							<b>Alamat</b>: <?=$LsData->kwg_alamat;?>

							<br>

							<b>Telepon</b>: <?=$LsData->kwg_telepon;?>

						</td>

						<td class="text-center">

							<?=$LsData->kwg_wil;?>

						</td>

						<td class="text-center">

							<?=$LsData->num_anggota;?>

						</td>

						<td class="text-center" class="text-center">

							<a href="<?= base_url().'admin/'.$this->uri->segment(2).'?edit=true&';?>id=<?php echo $LsData->id; ?>" class="btn btn-warning" style="padding: 2px 12px 2px 2px" ><span class="fa fa-pencil" style="width:8.3%"></span></a>

							<a id="delet" href="<?= base_url().'admin/'.$this->uri->segment(2).'?delete=true&id='.$LsData->id.'&kode='.md5(base64_encode($LsData->id.'delete')); ?>" msg="Apakah yakin menghapus data ini?" class="btn btn-danger confirm" style="padding: 2px 12px 2px 2px"><span class="fa fa-trash " style="width:8.3%"></span></a>

						</td>

					</tr>

			<?php

				}

			}

			else{

			?>

					<tr>

						<td>1</td>

						<td colspan=6 class="text-center">No Record</td>

					</tr>

			<?php

			}



			?>

				</tbody>

			</table>

			<div class="divider"></div>

			<?=$pagingnation;?>

		</div>

	<?php

	}

	?>



		</div>

	</div>

</div>

<!-- /page content -->





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



	$(document).on('click', '[id=addAnggota]', function(e){

		url=$(this).attr('href')

		$.get(url, function(data){

			$('#modal-content').html(data)

		})

	})



	$(document).on('click', '[id=editHobyProfesi]', function(e){

		url=$(this).attr('href')

		$.post(url, function(data){

			$('#modal-content').html(data)

		})

	})

	$(document).on('keyup', '[name=no_urut]', function(e){

		url=$(this).attr('href')
		dataMap={}
		dataMap['recid']=$(this).attr('recid')
		dataMap['no_urut']=$(this).val()


		$.post("<?=base_url();?>ajax/save_no_urut", dataMap, function(data){


		})

	})

	$(document).on('click touchstart', '[id^=btn_qrcode]', function(e){
		e.preventDefault();
		dataMap={}
		dataMap['generate']='admin'
		url=$(this).attr('href')
		$.post(url, dataMap, function(data){
			json=$.parseJSON(data)
			if(json.img!=null){
				$('#img_qrcode_kk').removeAttr('src')
				$('#img_qrcode_kk').attr('src', json.img)
			}
		})
	})

	$(document).on('change', '[id^=select_stst_kpkp]', function(e){
		dataMap={}
		dataMap['sts_kpkp']=$(this).val()
		dataMap['recid']=$(this).attr('recid')
		$.post('<?=base_url();?>admin/update_sts_kpkp', dataMap, function(data){

		})
	})

	$(document).on('change', '[id^=select_aturan_kpkp]', function(e){
		dataMap={}
		dataMap['aturan_kpkp']=$(this).val()
		dataMap['recid']=$(this).attr('recid')
		$.post('<?=base_url();?>admin/update_aturan_kpkp', dataMap, function(data){

		})
	})
</script>