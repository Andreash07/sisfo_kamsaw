<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">

	<div class="row">

		<div class="col-xs-12">

			<div class="x_panel">

				<?php

				$this->load->view('report/searchbox'); 

				?>

			</div>

		</div>

		<div class="col-xs-12">

			<div class="x_panel">

				<span>Menampilakn <b><?=count($data_jemaat);?></b> dari <b><?=$TotalOfData;?></b></span>

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

        		if($value->sts_anggota==1){

            		$sts='<i class="fa fa-check-square text-success" title="Aktif"></i>';

            }

            else{
            		$sts='<i class="fa fa-times text-danger" title="Tidak Aktif"></i>';

            }

            if($value->sts_kpkp==1){

            		$sts_kpkp='<i class="fa fa-check-square text-success" title="Aktif"></i>';
            		if($value->sts_kpkp==1){
            			$sts_kpkp.='- <label class="label label-success">Aturan < 2020 (kebawah)</label>';
            		}
            		else if($value->sts_kpkp==0){
            			$sts_kpkp.='- <label class="label label-warning">Aturan >= 2020 (keatas)</label>';
            		}
            		else{
            			$sts_kpkp.='- <label class="label label-danger">Belum ditentukan</label>';
            		}

            }

            else{
            		$sts_kpkp='<i class="fa fa-times text-danger" title="Tidak Aktif"></i><label class="text-danger">Tidak Aktif</label';

            }

				?>

						<tr>

							<td class='text-center'><?=$key+$numStart+1;?></td>

							<td>

								<?=$value->nama_lengkap;?> (<b><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> Th</b>)- 

								<b><?=$value->hub_keluarga;?></b> <?=$sts;?>

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

								<b>Telp/HP:</b> <?= $value->telepon;?>

								<br>

								<b>Alamat:</b> <?= $value->kwg_alamat;?>

								<br>

								<b>KPKP</b> <?= $sts_kpkp;?>

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

	$(document).on('click', '[id=btn_exec_print]', function(e){
		$('#form_field').submit();
	})

	$(document).on('click', '[id=btn_checkFieldPrint]', function(e){
		e.preventDefault()
		$('#modal_checkField').modal('show');
	})

	$(document).on('click', '[id=editAnggota]', function(e){

		url=$(this).attr('href');

		$.get(url, function(data){

			$('#modal-content').html(data)

		})

	})

</script>