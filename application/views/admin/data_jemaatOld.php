<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
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
							<th class="text-center" colspan="2" style="width:20%">Nomor Anggota</th>
							<th class="text-center" style="width:30%">Data Diri</th>
							<th class="text-center" style="width:20%">Talenta/Hoby/Profesi</th>
							<th class="text-center" style="width:20%">Migrasi</th>
							<th class="text-center" style="width:10%">Action</th>
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
	$kwg_no=$this->input->get('id');
	$dataKK=$this->m_model->selectas('kwg_no', $kwg_no, 'ags_kwg_table');
	if(isset($dataKK) && count($dataKK)>0){
?>
	<div class="x_panel">
		<form class="form-horizontal form-label-left" id="form_add_kk"  name="form_add_kk" method="POST" action="">
				<div class="x_title">
					<h4>Data Keluarga</h4>
			    </div>
				<div class="x_content">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Nama KK<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
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
				<?php
				if($dataKK[0]->status_migration==0){
				?>
					<button type="submit" class="btn btn-default pull-right" id="migrasi_keluarga" name="migrasi_keluarga" value="edit">Migrasi</button>
				<?php
				}else{
				?>
					<div class="btn btn-warning disabled pull-right"><i class="fa fa-warning"></i> Sudah dimigrasi</div>
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
		$anggota_KK=$this->m_model->selectas('kwg_no', $dataKK[0]->kwg_no, 'ags_kwg_detail_table');
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

	<div class="x_panel">
		<div class="x_title">
			<h4 class="">Data Anggota Keluarga</h4>
			<!--<a id="addAnggota" class="btn btn-primary" onclick="event.preventDefault()" href="<?= base_url().'/admin/'.$this->uri->segment(2).'?addAnggota=true';?>" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-plus "></i>Anggota
			</a>-->
	    </div>
		<div class="x_content table-responsive">
			<table class="table table-striped" id="item_sj">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center" colspan="2" style="width:20%">Nomor Anggota</th>
						<th class="text-center" style="width:30%">Data Diri</th>
						<th class="text-center" style="width:20%">Talenta/Hoby/Profesi</th>
						<th class="text-center" style="width:20%">Migrasi</th>
						<th class="text-center" style="width:10%">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($anggota_KK) && count($anggota_KK)>0){
						foreach ($anggota_KK as $keyAnggota_KK => $valueAnggota_KK) {
							# code...
							if($valueAnggota_KK->telepon == ''){
								$valueAnggota_KK->telepon= '-';
							}

							$baptis="Belum";
							$sidi="Belum";
							$nikah="Belum";
							$status_migration='Belum';
							if($valueAnggota_KK->status_baptis!= '' || $valueAnggota_KK->status_baptis!= null){
								$baptis=$valueAnggota_KK->tmpt_baptis.', '.convert_tgl_dMY($valueAnggota_KK->tgl_baptis);
							}

							if($valueAnggota_KK->status_sidi!= '' || $valueAnggota_KK->status_sidi!= null){
								$sidi=$valueAnggota_KK->tmpt_sidi.', '.convert_tgl_dMY($valueAnggota_KK->tgl_sidi);
							}

							if($valueAnggota_KK->status_nikah!= '' || $valueAnggota_KK->status_nikah!= null){
								$nikah=$valueAnggota_KK->tmpt_nikah.', '.convert_tgl_dMY($valueAnggota_KK->tgl_nikah);
							}

							if($valueAnggota_KK->status_migration== '1'){
								$status_migration='Sudah';
							}
					?>
						<tr>
							<td class="text-center"><?=$keyAnggota_KK+1;?></td>
							<td class="text-center" colspan="2" style="width:20%">
								<?= $valueAnggota_KK->no_anggota;?>
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
							<td class="text-center" style="width:20%">Talenta/Hoby/Profesi</td>
							<td class="text-center" style="width:20%"><?=$status_migration;?></td>
							<td class="text-center" style="width:10%">
								<a id="editAnggota" href="<?= base_url().'admin/'.$this->uri->segment(2).'?editAnggota=true&';?>id=<?php echo $valueAnggota_KK->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal">
									<span class="fa fa-pencil" style="width:20%"></span>
								</a>
								<!--<a id="delet" href="delete.php?recid=<?php echo $valueAnggota_KK->id; ?>&kode=<?php echo md5(base64_encode('deleteAnggota')); ?>" class="confirm" msg="Yakin ingin menghapus data ini?">
									<span class="fa fa-trash" style="width:20%"></span>
								</a>-->
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
	<script type="text/javascript">
		$(document).on('change', '[group_input=hoby]', function(e){
			val=$(this).val();
			dataMap={}
			dataMap['anggota_jemaat']='<?=$valueAnggota_KK->id;?>'
			dataMap['hoby_id']=val
			if($(this).is(':checked')==false){
				$.get('<?=base_url();?>admin/removeHoby/', function(data){
					json=$.parseJSON(data);
				})
			}

		})

		$(document).on('change', '[group_input=profesi]', function(e){
			val=$(this).val();
			dataMap={}
			dataMap['anggota_jemaat']='<?=$valueAnggota_KK->id;?>'
			dataMap['profesi_id']=val
			if($(this).is(':checked')==false){
				$.get('<?=base_url();?>admin/removeProfesi/', function(data){
					json=$.parseJSON(data);
				})
			}

		})
	</script>
<?php
}
else if(!$this->input->get('add') && !$this->input->get('edit')){
	$wilayah=$this->m_model->select('wilayah', 'wilayah', 'ASC');

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
		<a href="<?=base_url().'admin/'.$this->uri->segment(2).'?add=true';?>" class="btn btn-success pull-right">Add</a>
	<?php
	}
	?>
	<div class="x_panel">
		<form class="form-horizontal form-label-left" method="GET" action="">
			<div class="x_title">
				<h4>Data Jemaat Lama</h4>
		    </div>
			<div class="x_content">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Nama KK
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-md-7 col-xs-12" placeholder="Search Nama Keluarga" value="<?=$this->input->get('kwg_nama');?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">
						Wilayah
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control" name="wil" id="wil">
	  					<option value="">Pilih</option>
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
				<div class="form-group">
					<button type="submit" class="btn btn-default pull-right" name="search">Search</button>
				</div>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>
	<div class="divider"></div>
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
				$LsData->num_anggota=count($this->m_model->selectas('kwg_no', $LsData->kwg_no, 'ags_kwg_detail_table'));
		?>
				<tr>
					<td class="text-center"><?php echo $key+1; ?></td>
					<td class="text-left">
						<a href="<?= base_url().'admin/'.$this->uri->segment(2).'?edit=true&';?>id=<?php echo $LsData->kwg_no; ?>">
							<?php echo $LsData->kwg_nama; ?>
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
						<a href="<?= base_url().'admin/'.$this->uri->segment(2).'?edit=true&';?>id=<?php echo $LsData->kwg_no; ?>"><span class="fa fa-pencil" style="width:8.3%"></span></a>
						<!--<a id="delet" href="<?= base_url().'admin/'.$this->uri->segment(2).'?delete=true&id='.$LsData->kwg_no.'&kode='.md5(base64_encode($LsData->kwg_no.'delete')); ?>" class="confirm" msg="Apakah yakin menghapus data ini?"><span class="fa fa-trash " style="width:8.3%"></span></a>-->
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
<!-- /page content -->


<?php
$this->load->view('layout/footer');
?>
<script type="text/javascript">
	$(document).on('click', '[id=editAnggota]', function(e){
		url=$(this).attr('href')
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
</script>