<?php

$this->load->view('layout/header');

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				$this->load->view('pemakaman/searchbox_laporan_saldo'); 
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
							<th class='text-center'>Nama KK</th>
							<th class='text-center'>Jumlah Jiwa</th>
							<th class='text-center'>Wil</th>
							<th class='text-center'>Iuran Wajib Per Bulan (Rp)</th>
							<th class='text-center'>Jumlah Bulan (Ter-Bayarkan)</th>
							<th class='text-right' >Nominal</th>
							<th class='text-center' >Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach ($data_jemaat as $key => $value) {
								// code...
								$total_biayaKPKP=0;
								$total_biayaKPKP=$total_biayaKPKP+($value->num_anggota_kpkp*$pokok_iuran );
								$est_bulanTercover=countBulanTercover($total_biayaKPKP, $value->saldo_akhir, date('Y-m'));
						?>
							<tr>
								<td class='text-center' ><?=$row++;?></td>
								<td class='text-left' ><?=$value->kwg_nama;?></td>
								<td class='text-center' ><?=$value->num_anggota_kpkp;?></td>
								<td class='text-center' ><?=$value->kwg_wil;?></td>
								<td class='text-right' ><?=number_format($pokok_iuran * $value->num_anggota_kpkp,0,",",".");?></td>
								<td class='text-center' ><?=$est_bulanTercover['num_month'];?> (<?=$est_bulanTercover['month'];?>)</td>
								<td class='text-right' ><?= number_format($value->saldo_akhir,0,",",".");?></td>
								<td>
									<a href="<?=base_url();?>Pdf/SuratPemberitahuanIuranWajibKPKP/<?=md5('*(2791bjaksdk'.$value->keluarga_jemaat_id);?>" class="btn btn-danger btn-sm" title="Surat Pemberitahuan Iuran" target="_BLANK"><i class="fa fa-file-pdf-o"></i></a>
								</td>
							</tr>
						<?php 
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
//echo round(memory_get_peak_usage() / 1024, 2).'/'.round(memory_get_usage(true) / 1024, 2);
$this->load->view('layout/footer');

?>