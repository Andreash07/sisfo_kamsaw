<?php

$this->load->view('layout/header');

?>
<!-- page content -->

<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="divider"></div>
		<div class="clearfix"></div>
		<?php 
		foreach ($periode as $key => $value) {
			// code...
		?>
		<div class="col-xs-12">
			<div class="x_panel">
				<h4><?=$value->name; ?></h4>
				<div class="x_content">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Pelayanan</th>
								<th>Summary</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($pelayanan as $key1 => $value1) {
								// code...
								$tot_keseluruhan='<label class="label label-primary">0</label>';
								$tot_usulan='<label class="label label-warning">0</label>';
								$tot_pdkt='<label class="label label-primary">0</label>';
								$tot_bersedia='<label class="label label-success">0</label>';
								$tot_tidak_bersedia='<label class="label label-danger">0</label>';
								if(isset($anggota_perpelayanan[$value->id][$value1])){
									if($anggota_perpelayanan[$value->id][$value1]->tot_nama >0 ){
										$tot_keseluruhan='<label class="label label-primary">'.$anggota_perpelayanan[$value->id][$value1]->tot_nama.'</label>';
									}
									if($anggota_perpelayanan[$value->id][$value1]->tot_usulan >0 ){
										$tot_usulan='<label class="label label-warning">'.$anggota_perpelayanan[$value->id][$value1]->tot_usulan.'</label>';
									}
									if($anggota_perpelayanan[$value->id][$value1]->tot_pdkt >0 ){
										$tot_pdkt='<label class="label label-primary">'.$anggota_perpelayanan[$value->id][$value1]->tot_pdkt.'</label>';
									}
									if($anggota_perpelayanan[$value->id][$value1]->tot_bersedia >0 ){
										$tot_bersedia='<label class="label label-success">'.$anggota_perpelayanan[$value->id][$value1]->tot_bersedia.'</label>';
									}
									if($anggota_perpelayanan[$value->id][$value1]->tot_tidak_bersedia >0 ){
										$tot_tidak_bersedia='<label class="label label-danger">'.$anggota_perpelayanan[$value->id][$value1]->tot_tidak_bersedia.'</label>';
									}
								}
							?>
							<tr>
								<td><?=$key1+1;?></td>
								<td><?=$value1;?></td>
								<td>Total: <?=$tot_keseluruhan;?> (Berstatus Usulan: <?=$tot_usulan;?> | Pendekatan: <?=$tot_pdkt;?> | Bersedia: <?=$tot_bersedia;?> | Tidak Bersedia: <?=$tot_tidak_bersedia;?>)</td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php 
		}
		?>
	</div>
</div>
<?php

$this->load->view('layout/footer');

?>