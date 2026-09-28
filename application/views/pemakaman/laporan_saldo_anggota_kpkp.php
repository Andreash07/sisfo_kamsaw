<?php

$this->load->view('layout/header');

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				//$this->load->view('pemakaman/searchbox_laporan_saldo'); 
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
							<th class='text-center'>Nama KK</th>
							<th class='text-center'>Wil</th>
							<th class='text-center'>Iuran Wajib Per Bulan (Rp)</th>
							<th class='text-center' colspan="2">Jumlah Bulan (Ter-Bayar-kan)</th>
							<th class='text-right' >Nominal</th>
							<th class='text-center' >Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach ($data_jemaat as $key => $value) {
								// code...
						?>
							<tr>
								<td class='text-center' ><?=$row++;?></td>
								<td class='text-left' ><?=$value->kwg_nama;?></td>
								<td class='text-center' ><?=$value->kwg_wil;?></td>
								<td class='text-right' ><?=$pokok_iuran * $value->num_anggota_kpkp;?></td>
								<td class='text-center' >0</td>
								<td class='text-center' >Des 2026</td>
								<td class='text-right' ><?=$value->saldo_akhir;?></td>
								<td></td>
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