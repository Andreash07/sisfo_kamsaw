<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				$this->load->view('report/searchbox_sidi');
				?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<span>Menampilakn <b><?=count($data_jemaat);?></b> dari <b><?=$TotalOfData;?></b></span>
				<?= $pagingnation; ?>
				<table class='table table-striped'>
					<thead>
						<tr>
							<th class='text-center'>#</th>
							<th class='text-center'>Nama</th>
							<th class='text-center' style="width: 30%;">Ulasan</th>
							<th class='text-center' style="width: 30%;">Action</th>
						</tr>
					</thead>
					<tbody>
				<?php
				foreach ($data_jemaat as $key => $value) {
					# code...
					if($value->golongandarah==null){
						$value->golongandarah='<i>Data tidak ada</i>';
					}

					if($value->jns_kelamin=='L'){
	              		$jns_kelamin="Laki-laki";
		            }
		            else{
		              	$jns_kelamin="Perempuan";
		            }
		            if($value->status_baptis=='1'){
	              		$ico_status_baptis='<i class="fa fa-check-square text-success"></i>';
		            }
		            else{
	              		$ico_status_baptis='<i class="fa fa-times text-danger"></i>';
		            }

		            if($value->status_sidi=='1'){
	              		$ico_status_sidi='<i class="fa fa-check-square text-success"></i>';
		            }
		            else{
	              		$ico_status_sidi='<i class="fa fa-times text-danger"></i>';
		            }
				?>
						<tr>
							<td class='text-center'><?=$key+$numStart+1;?></td>
							<td>
								<?=$value->nama_lengkap;?> (<b><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> Th</b>)- 
								<b><?=$value->hub_keluarga;?></b>
								<br>
								<b>No Anggota:</b> <?= $value->no_anggota;?>
								<br>
								<b><?=$jns_kelamin;?></b>
							</td>
							<td style="width: 30%;">
								<b>Keluarga:</b> <a href="<?=base_url();?>admin/DataJemaat?edit=true&id=<?=$value->kwg_no;?>"><?= $value->kwg_nama;?></a>
								<br>
								<b>Wilayah:</b> <?= $value->kwg_wil;?> 
								<br>
								<b>Tempat, TTL:</b> <?= $value->tmpt_lahir.', '.convert_tgl_dMY($value->tgl_lahir) ;?>
								<br>
								<b>Tempat, Tgl Baptis:</b> <?= $value->tmpt_baptis.', '.convert_tgl_dMY($value->tgl_baptis) ;?>&nbsp;&nbsp;<?=$ico_status_baptis;?>
								<br>
								<b>Tempat, Tgl Sidi:</b> <?= $value->tmpt_sidi.', '.convert_tgl_dMY($value->tgl_sidi) ;?>&nbsp;&nbsp;<?=$ico_status_sidi;?>
								<br>
								<b>Telp/HP:</b> <?= $value->telepon;?>
							</td>
							<td class='text-center'>
								<a id="editAnggota" href="<?= base_url().'admin/DataJemaat?editAnggota=true&';?>id=<?php echo $value->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Anggota">
									<span class="fa fa-pencil" style="width:20%; display: unset;"></span>
								</a>

								<a href="<?=base_url();?>admin/DataJemaat?edit=true&id=<?=$value->kwg_no;?>" class="btn btn-success" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Keluarga">
									<span class="fa fa-users" style="width:20%; display: unset;"></span>
								</a>
							</td>
						</tr>
				<?php
				}
				?>
					</tbody>
				</table>
				<?= $pagingnation; ?>
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
</script>