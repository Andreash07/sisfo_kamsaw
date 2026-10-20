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
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Periode Pelayanan
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="form-control" name="wilayah" id="wilayah">
			  					<option value="">Pilih</option>
							  	<?php
							  		foreach ($periode_pelayanan as $keyWil => $Wil) {
							  			# code...
							  			$selected="";
								  		if($cur_periode == $Wil->id){
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
								Kriteria
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="form-control" name="filter" id="filter">
			  					<option value="">Semua</option>
			  					<option value="1" <?php if($this->input->get('filter') == '1'){ echo "selected";} ?>>1 orang diusulkan 1 Komisi</option>
			  					<option value="2" <?php if($this->input->get('filter') == '2'){ echo "selected";} ?>>1 orang diusulkan >1 Komisi</option>
			  					<option value="3" <?php if($this->input->get('filter') == '3'){ echo "selected";} ?>>yang sudah menyatakan bersedia</option>
			  					<!--<option value="4" <?php if($this->input->get('filter') == '4'){ echo "selected";} ?>>Komisi belum mengusulkan nama</option>-->
			  					<option value="5" <?php if($this->input->get('filter') == '5'){ echo "selected";} ?>>yang belum bersedia sama sekali</option>
			  					<option value="6" <?php if($this->input->get('filter') == '6'){ echo "selected";} ?>>Komisi belum ada yang bersedia</option>
			  					<option value="7" <?php if($this->input->get('filter') == '7'){ echo "selected";} ?>>Komisi sudah ada yang bersedia</option>
							  </select>
							</div>
						</div>
						<div class="form-group" style="display: none;">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
								Status
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  	<select class="form-control" name="status" id="status">
				  					<option value="" >Semua</option>
				  					<option value="-1" <?php if($this->input->get('status') == -1){ echo "selected";} ?> >Usulan</option>
				  					<option value="0" <?php if($this->input->get('status') == 0){ echo "selected";} ?> >Pendekatan</option>
				  					<option value="1" <?php if($this->input->get('status') == 1){ echo "selected";} ?> >Bersedia</option>
				  					<option value="2" <?php if($this->input->get('status') == 2){ echo "selected";} ?> >Tidak Bersedia</option>
							  	</select>
							</div>
						</div>
						<div class="form-group">
							<a href="<?=base_url().'Anggota_pengurus/form_add';?>" class="btn btn-success pull-left">Add</a>
							<button type="submit" class="btn btn-default pull-right" name="search">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="divider"></div>
		<div class="clearfix"></div>

		<div class="col-xs-12">
			<?php 
			foreach ($pelayanan as $key => $value) {
				// code...
				if($this->input->get('filter')!=''){
					//kalau ada filter gini, komisi yg tidak belum ada samasekali, di lewati saja
					if(!isset($data[$value]) || count($data[$value]) ==0 ){
						continue;
					}
				}
			?>
				<div class="col-md-4 col-sm-4 col-xs-12">
		            <div class="x_panel">
		              <div class="x_title">
		                <h2><?=$value;?></h2>
		                <div class="clearfix"></div>
	              		</div>
	              		<div class="x_content">
	              			<table class="table table-striped">
	              				<thead>
	              					<tr>
	              						<th class="text-center">#</th>
	              						<th class="text-center">Nama</th>
	              						<th class="text-center">Tanggal Diusulkan</th>
	              						<th class="text-center">Status</th>
	              					</tr>
	              				</thead>
	              				<tbody>
	              					<?php 
	              						if(isset($data[$value]) && count($data[$value]) >0 ){
	              							foreach ($data[$value] as $key1 => $value1) {
	              								// code...
	              								switch ($value1->status) {
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

												$lbl_offer_perorang="";
												if(isset($offer_perorang[$value1->anggota_jemaat_id]) && count($offer_perorang[$value1->anggota_jemaat_id])>0 ){
													foreach ($offer_perorang[$value1->anggota_jemaat_id] as $key2 => $value2) {
														// code...
														switch ($value2->status) {
															case '-1':
																// code...
																$lbl_offer_perorang.='<label class="label label-default">'.$value2->pelayanan.'</label>&nbsp;';
																break;
															case '0':
																// code...
																$lbl_offer_perorang.='<label class="label label-warning">'.$value2->pelayanan.'</label>&nbsp;';
																break;
															case '1':
																// code...
																$lbl_offer_perorang.='<label class="label label-success">'.$value2->pelayanan.'</label>&nbsp;';
																break;
															case '2':
																// code...
																$lbl_offer_perorang.='<label class="label label-danger">'.$value2->pelayanan.'</label>&nbsp;';
																break;
															
															default:
																// code...
																$lbl_offer_perorang.='<label class="label label-default">Tidak diketahui</label>&nbsp;';
																break;
														}

														if(($key2+1)%5 == 0){
															$lbl_offer_perorang.="<br>";
														}

													}
												}
	              					?>
	              								<tr>
	              									<td class="text-center"><?=$key1+1;?></td>
	              									<td><?=$value1->nama_lengkap;?><br><?=$lbl_offer_perorang;?></td>
	              									<td class="text-center"><?php if($value1->diusulkan_tgl !='' && $value1->diusulkan_tgl !='0000-00-00'){ echo date('d M Y', strtotime($value1->diusulkan_tgl)); } ?></td>
	              									<td class="text-center"><?=$sts;?></td>
	              								</tr>
	              					<?php 
	              							}
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
</div>
<?php

$this->load->view('layout/footer');

?>