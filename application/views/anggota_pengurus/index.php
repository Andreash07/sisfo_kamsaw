<?php

$this->load->view('layout/header');

?>
<!-- page content -->

<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<form class="form-horizontal form-label-left" method="GET" action="">
					<div class="x_title">
						<h4>Data Anggota Pengurus Pelayanan</h4>
				    </div>
					<div class="x_content">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_nama">Nama Anggota
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="text" id="kwg_nama" name="kwg_nama" class="form-control col-md-7 col-xs-12" placeholder="Search Nama Anggota Pengurus" value="<?=$this->input->get('kwg_nama');?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Periode Pelayanan
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="form-control" name="periode" id="periode">
			  					<option value="">Pilih</option>
							  	<?php
							  		foreach ($periode_pelayanan as $keyWil => $Wil) {
							  			# code...
							  			$selected="";
								  		if($this->input->get('periode') == $Wil->id){
							  				$selected="selected";
								  		}
					  			?>
					  					<option value="<?=$Wil->id;?>" <?=$selected;?>><?=$Wil->name;?></option>
					  			<?php
							  		}
							  	?>
							  </select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Pelayanan
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  	<select class="form-control" name="pelayanan" id="pelayanan">
				  					<option value="" >Semua</option>
				  					<?php 
				  					foreach ($pelayanan as $key => $value) {
				  						// code...
				  						$selected="";
								  		if($this->input->get('pelayanan') == $value){
							  				$selected="selected";
								  		}
				  					?>
				  						<option <?=$selected;?>><?=$value;?></option>
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
				  					<option value="-1" <?php if($this->input->get('status') == -1){ echo "selected";} ?> >Usulan</option>
				  					<option value="0" <?php if($this->input->get('status') == '0'){ echo "selected";} ?> >Pendekatan</option>
				  					<option value="1" <?php if($this->input->get('status') == 1){ echo "selected";} ?> >Bersedia</option>
				  					<option value="2" <?php if($this->input->get('status') == 2){ echo "selected";} ?> >Tidak Bersedia</option>
							  	</select>
							</div>
						</div>
						<div class="form-group">
							<a href="<?=base_url().'Anggota_pengurus/form_add';?>" class="btn btn-success pull-left">Add</a>
							<button type="submit" class="btn btn-default pull-right">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="divider"></div>
		<div class="clearfix"></div>

		<div class="col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama Anggota</th>
									<th>Periode</th>
									<th>Komisi</th>
									<th>Tanggal Diusulkan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=1;
								foreach ($data as $key => $value) {
									// code...
									switch ($value->status) {
										case '-1':
											// code...
											$sts="<label class='label label-default'>Usulan</label>";
											break;
										case '0':
											// code...
											$sts="<label class='label label-warning'>Proses Pendekatan</label>";
											break;
										case '1':
											// code...
											$sts="<label class='label label-success'>Bersedia</label>";
											break;
										case '2':
											// code...
											$sts="<label class='label label-danger'>Tidak Bersedia</label>";
											break;
										
										default:
											// code...
											$sts="-";
											break;
									}
								?>
								<tr>
									<td><?=$i;?></td>
									<td><?=$value->nama_lengkap;?></td>
									<td><?=$value->periode;?></td>
									<td><?=$value->pelayanan;?></td>
									<td><?php if($value->diusulkan_tgl !='' && $value->diusulkan_tgl !='0000-00-00'){ echo date('d M Y', strtotime($value->diusulkan_tgl)); } ?></td>
									<td><?=$sts;?></td>
								</tr>
								<?php
									$i++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

$this->load->view('layout/footer');

?>