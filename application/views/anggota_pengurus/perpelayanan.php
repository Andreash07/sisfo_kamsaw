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
			  					<option value="5" <?php if($this->input->get('filter') == '5'){ echo "selected";} ?>>yang belum bersedia sama sekali dan diusulkan >1 komisi</option>
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
							<!--<a href="<?=base_url().'Anggota_pengurus/form_add';?>" class="btn btn-success pull-left">Add</a>-->
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
			$ipel=0;
			foreach ($pelayanan as $key => $value) {
				// code...
				if($this->input->get('filter')!='' || $this->input->get('kwg_nama')!=''){
					//kalau ada filter gini, komisi yg tidak belum ada samasekali, di lewati saja
					if(!isset($data[$value]) || count($data[$value]) ==0 ){
						continue;
					}
				}
			?>
				<div class="col-md-6 col-sm-6 col-xs-12">
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
	              						<th class="text-center">Tgl<br>Diusulkan</th>
	              						<th class="text-center"></th>
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

														if(($key2+1)%2 == 0){
															$lbl_offer_perorang.="<br>";
														}

													}
												}
	              					?>
	              								<tr>
	              									<td class="text-center"><?=$key1+1;?></td>
	              									<td><?=$value1->nama_lengkap;?> (Ter. <?=$value1->wilayah;?>)<br><?=$lbl_offer_perorang;?></td>
	              									<td class="text-center"><?php if($value1->diusulkan_tgl !='' && $value1->diusulkan_tgl !='0000-00-00'){ echo date('d M Y', strtotime($value1->diusulkan_tgl)); } ?></td>
	              									<td class="text-center">
	              										<?php 
	              										if(((count($approve_pdkt[$value1->anggota_jemaat_id]) >0 || count($bersedia[$value1->anggota_jemaat_id])>0) && in_array($value1->status, array('-1','2')) ) #|| in_array($value1->status, array('2')) 
			              									){
	              										?>
	              											<?=$sts;?>
	              										<?php 
	              										}else{
	              										?>
	              											<select class="form-control" id="status_perorang<?=$value1->id;?>" name="status_perorang" recid="<?=$value1->id;?>">
	              												<option value="-1" <?php if($value1->status == '-1'){ echo "selected";} ?> >Usulan</option>
	              												<option value="0" <?php if($value1->status == '0'){ echo "selected";} ?>>Proses Pendekatan</option>
	              												<option value="1" <?php if($value1->status == '1'){ echo "selected";} ?>>Bersedia</option>
	              												<option value="2" <?php if($value1->status == '2'){ echo "selected";} ?>>Tidak Bersedia</option>
	              											</select>
              											<?php
	              										}
	              										?>
	              										<br>
	              										<div class="btn btn-info btn-xs" title="Catatan Anggota Pengurus" id="btn_note_anggota<?=$value1->id;?>" form="<?=base_url().'Anggota_pengurus/form_note_anggota?auth='.md5('jasdhk289!*&'.$value1->id);?>" nama="<?=$value1->nama_lengkap;?> (Ter. <?=$value1->wilayah;?>) - <?=$value1->pelayanan;?>"><i class="fa fa-commenting"></i></div>
              										</td>
	              								</tr>
	              					<?php 
	              							}
	              						}
	              						else{
          							?>
          								<tr>
          									<td colspan="4" class="text-danger">Belum ada nama yang diusulkan/bersedia!</td>
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
				$ipel++;			
			}
			?>

			<?php 
				if($ipel==0){
			?>
				<div class="x_panel">
	              	<div class="x_title">
						<h4 class="text-danger">Oooops Maaf, Tidak ada yang ditemukan!</h4>		
					</div>
				</div>
			<?php 
				}
			?>
		</div>
	</div>
</div>

<!--modal nekat -->
<div class="modal-note_anggota modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="div_content_note_anggota">
      
    </div>
  </div>
</div>


<?php

$this->load->view('layout/footer');

?>

<script type="text/javascript">
	$(document).on('change', '[id^=status_perorang]', function(e){
		dataMap={}
		dataMap['recid']=$(this).attr('recid')
		dataMap['value']=$(this).val()

		console.log($(this).attr('recid'))
		console.log($(this).val())

		$.post('<?=base_url();?>Anggota_pengurus/save_status', dataMap, function(data){
			json=$.parseJSON(data)
			if(json.sts==1){
				//window.location.reload();
				url = new URL(window.location.href);
			  	window.location.href = url;
			}
		})

	})

	$(document).on('click touchstart', '[id^=btn_note_anggota]', function(e){
		e.preventDefault()
		$('.modal-note_anggota').modal('show');
		dataMap={}
		dataMap['nama']=$(this).attr('nama')
		url=$(this).attr('form')
		$.post(url, dataMap, function(data){
			$('#div_content_note_anggota').html(data)
		})
	})

	$(document).on('click touchstart', '[id=btn_simpan_note_anggota]', function(e){
		e.preventDefault()
		dataMap={}
		dataMap=$('#form_note_anggota').serialize()
		url=$('#form_note_anggota').attr('action')
		$.post(url, dataMap, function(data){
			json=$.parseJSON(data)
			if(json.sts==1){
				iziToast.success({
		            title: json.msg,
		            message: '',
		            position: "topRight",
		            class: "iziToast-success",
		        });
			}
			else if(json.sts==0){
				iziToast.error({
		            title: json.msg,
		            message: 'Hubungi Sekretaris MJ / Administrator!',
		            position: "topRight",
		            class: "iziToast-danger",

		        });
			}

			$('.modal-note_anggota').modal('hide');
			$('#div_content_note_anggota').html('')
		})
	})
</script>