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

							  <input type="hidden" id="keluarga_jemaat_id" name="keluarga_jemaat_id" required="required" value="<?=$dataKK[0]->id;?>" disabled>

							  <input type="hidden" id="kwg_no" name="kwg_no" required="required" value="<?=$dataKK[0]->kwg_no;?>" disabled>

							  <input type="text" id="kwg_nama" name="kwg_nama" required="required" class="form-control col-md-7 col-xs-12" value="<?=$dataKK[0]->kwg_nama;?>" disabled>

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kwg_alamat">Alamat

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <textarea id="kwg_alamat" name="kwg_alamat" class="form-control col-md-7 col-xs-12" disabled><?=$dataKK[0]->kwg_alamat;?></textarea>

							</div>

						</div>

						<div class="form-group">

							<label for="kwg_telepon" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Telpon</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <input id="kwg_telepon" name="kwg_telepon" class="form-control col-md-7 col-xs-12" type="text" value="<?=$dataKK[0]->kwg_telepon;?>" disabled>

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12">

								Wilayah

								<span class="required">*</span>

							</label>

							<div class="col-md-6 col-sm-6 col-xs-12">

							  <select class="form-control" name="kwg_wil" id="kwg_wil" disabled>

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

					<a class="btn btn-warning pull-left" href="<?=base_url();?>Pemakaman/anggota_jemaat">Keluar</a>

					<!--<input type="submit" class="btn btn-default pull-right" id="SaveEditKeluarga" name="SaveEditKeluarga" value="Update">

					<a class="btn btn-success pull-right" href="<?=base_url();?>pdf/kkwithbarcode.php?id=<?=$this->input->get('id');?>" target="_BLANK"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak</a> -->
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

			//$anggota_KK=$this->m_model->selectas3('kwg_no', $dataKK[0]->id,'delete_user IS NULL', NULL, 'status', 1, 'anggota_jemaat', 'no_urut', 'ASC');
			$s10="select Z.* from ( select *, '1' as keluarga_inti 
						from anggota_jemaat A 
						where A.kwg_no='".$dataKK[0]->id."'
						UNION ALL 
						select *, '0' as keluarga_inti 
						from anggota_jemaat A
						where A.kwg_no_kpkp='".$dataKK[0]->id."') Z
						where Z.delete_user IS NULL && Z.status
						order by Z.keluarga_inti DESC, Z.no_urut ASC";
			//die(nl2br($s10));
			$anggota_KK=$this->m_model->selectcustom($s10); 


			//get_dompet kpkp
			$dompet_kpkp=$this->m_model->selectas('keluarga_jemaat_id', $dataKK[0]->id, 'kpkp_keluarga_jemaat');
			$sq="select * from kpkp_bayar_bulanan where keluarga_jemaat_id='".$dataKK[0]->id."' order by tgl_bayar ASC, type ASC,  created_at ASC";
			$mutasiiuran_kpkp=$this->m_model->selectcustom($sq);


			$num_anggotaKPKP=0;
	?>


	<div class="x_panel">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> KPKP </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Data Anggota Keluarga</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Rincian data KPKP</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">iuran KPKP</a>
                        </li>
                        <!--<li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Form Lain</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Form Lain-Lain</a>
                        </li>-->
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                          
			<div class="">
				<div class="x_title">
					<div class="btn btn-warning" data-toggle="modal" data-target="#myModal" id="btn_form_tautanangjem" href="<?=base_url()."pemakaman/form_tautaangjem?id=".$dataKK[0]->id;?>">Tautkan Angjem Lain</div>
				</div>
							<div class="x_content table-responsive">
								<table class="table table-striped" id="item_sj">
									<thead>
										<tr>
											<th class="text-center" style="max-width:20px;">#</th>
											<th class="text-center" colspan="2" style="width:20%">Nomor Anggota</th>
											<th class="text-center" style="width:40%">Data Diri</th>
											<th class="text-center" style="width:20%">Data KPKP</th>
											<th class="text-center" style="width:15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$lsKawin=array();

										if(isset($anggota_KK) && count($anggota_KK)>0){

											foreach ($anggota_KK as $keyAnggota_KK => $valueAnggota_KK) {
												# code...
												//print_r($valueAnggota_KK);

												if($valueAnggota_KK->telepon == ''){

													$valueAnggota_KK->telepon= '-';

												}

												if($valueAnggota_KK->sts_anggota==1){

					            		$sts='<i class="fa fa-check-square text-success" title="Aktif"></i> Aktif';

						            }
						            else{
					            		$sts='<i class="fa fa-times text-danger" title="Tidak Aktif"></i> Tidak Aktif';
						            }

						            //echo ($valueAnggota_KK->kwg_no);
						            //die($dataKK[0]->id);
						            if($valueAnggota_KK->sts_kpkp==1 && ($valueAnggota_KK->kwg_no_kpkp==0 || $dataKK[0]->id == $valueAnggota_KK->kwg_no_kpkp) ){
						            	$total_biayaKPKP=$total_biayaKPKP+$iuranKpkpp;

						            	$num_anggotaKPKP++;
						            }
										?>
										<?php 
											if($valueAnggota_KK->keluarga_inti==1){
										?>

											<tr>

												<td class="text-center" style="max-width:20px;">
													<?=$keyAnggota_KK+1;?>
												</td>

												<td class="text-center" colspan="2" style="width:20%">

													<?= $valueAnggota_KK->no_anggota;?>
													<br>
													<?=$sts;?>
												</td>

												<td class="text-left" style="width:40%; line-height: 2">

													<b>Nama:</b> <?= $valueAnggota_KK->nama_lengkap;?>

													<br>

													<b>Tempat, TTL:</b> <?= $valueAnggota_KK->tmpt_lahir.', '.convert_tgl_dMY($valueAnggota_KK->tgl_lahir) ;?>

													<br>

													<b>Telp/HP:</b> <?= $valueAnggota_KK->telepon;?>

													<br>

													<!-- <b>Baptis:</b> <?= $baptis;?>

													<br>

													<b>Sidi:</b> <?=$sidi;?>

													<br>

													<b>Nikah:</b> <?= $nikah;?> -->

												</td>

												<td class="text-center" style="width:20%">
													<div class="form-group">
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

												<td class="text-center" style="width:15%">

													<!--<a id="editAnggota" href="<?= base_url().'admin/'.$this->uri->segment(2).'?editAnggota=true&';?>id=<?php echo $valueAnggota_KK->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding: 2px 12px 2px 2px">

														<span class="fa fa-pencil" style="width:20%"></span>

													</a>

													<a id="delet" href="<?= base_url().'admin/'.$this->uri->segment(2).'?deleteanggota=true&id='.$valueAnggota_KK->id.'&kode='.md5(base64_encode($valueAnggota_KK->id.'delete')); ?>" class="confirm btn btn-danger" msg="Yakin ingin menghapus data ini?"  style="padding: 2px 12px 2px 2px">

														<span class="fa fa-trash" style="width:20%"></span>

													</a>
													<input type="text" name="no_urut" value="<?=$valueAnggota_KK->no_urut;?>" class="form-control text-center" recid="<?php echo $valueAnggota_KK->id; ?>">-->
												</td>

											</tr>
											<?php 
												}else{
											?>
													<tr>
														<td class="text-center" style="max-width:20px;">
															<?=$keyAnggota_KK+1;?>
														</td>

														<td class="text-center" colspan="2" style="width:20%">

															<?= $valueAnggota_KK->no_anggota;?>
															<br>
															<?=$sts;?>
														</td>

														<td class="text-left" style="width:40%; line-height: 2">

															<b>Nama:</b> <?= $valueAnggota_KK->nama_lengkap;?>

															<br>

															<b>Tempat, TTL:</b> <?= $valueAnggota_KK->tmpt_lahir.', '.convert_tgl_dMY($valueAnggota_KK->tgl_lahir) ;?>

															<br>

															<b>Telp/HP:</b> <?= $valueAnggota_KK->telepon;?>

															<br>

															<!-- <b>Baptis:</b> <?= $baptis;?>

															<br>

															<b>Sidi:</b> <?=$sidi;?>

															<br>

															<b>Nikah:</b> <?= $nikah;?> -->

														</td>

														<td class="text-center" style="width:20%">
															<div class="form-group">
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
															<label class="label label-danger">Anggota KPKP Tambahan!</label>
															<div id="btn_copot_tautan" href="<?=base_url();?>pemakaman/copot_tautan" kwg_no_kpkp="<?=$valueAnggota_KK->kwg_no_kpkp;?>" kwg_no="<?=$valueAnggota_KK->kwg_no;?>" jemaat_name="<?=$valueAnggota_KK->nama_lengkap;?>" keluarga_tautan="<?=$dataKK[0]->kwg_nama;?>" angjem_id="<?=$valueAnggota_KK->id;?>"  bulan_tercover="0" dana_kpkp="0" class="btn btn-danger btn-sm" style="margin-top: 5px;"> <i class="fa  fa-unlink"></i> Copot Tautan </div>


														</td>

														<td class="text-center" style="width:15%">

															<!--<a id="editAnggota" href="<?= base_url().'admin/'.$this->uri->segment(2).'?editAnggota=true&';?>id=<?php echo $valueAnggota_KK->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding: 2px 12px 2px 2px">

																<span class="fa fa-pencil" style="width:20%"></span>

															</a>

															<a id="delet" href="<?= base_url().'admin/'.$this->uri->segment(2).'?deleteanggota=true&id='.$valueAnggota_KK->id.'&kode='.md5(base64_encode($valueAnggota_KK->id.'delete')); ?>" class="confirm btn btn-danger" msg="Yakin ingin menghapus data ini?"  style="padding: 2px 12px 2px 2px">

																<span class="fa fa-trash" style="width:20%"></span>

															</a>
															<input type="text" name="no_urut" value="<?=$valueAnggota_KK->no_urut;?>" class="form-control text-center" recid="<?php echo $valueAnggota_KK->id; ?>">-->
														</td>

													</tr>

											<?php 
												}
											?>



										<?php

											}

										}

										?>
									</tbody>
								</table>
							</div>
						</div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
						<div class="x_content text-center">
							<?php 
								$dataKpkp['data']=array();
								$dataKpkp2=array();
								$dataKpkp['total_biayaKPKP']='0';
								if(count($dompet_kpkp)==0){
							?>
									<span class="text-danger">Belum memiliki Data Pembayaran KPKP, Silahkan Hubungi Administrator/Pnt/Pengurus KPKP Terkait</span>
									<div class="btn btn-success" data-toggle="modal" data-target=".modal-dompetKPKP">Buat Dompet KPKP</div>
							<?php
								}
								else{
									$dataKpkp['data']=$dompet_kpkp[0];
									$dataKpkp['total_biayaKPKP']=$total_biayaKPKP;
									$dataKpkp['num_anggotaKPKP']=$num_anggotaKPKP;

									$dataKpkp2=$dompet_kpkp[0]; 
									$this->load->view('pemakaman/rincian_kpkp', $dataKpkp);
								}
							?>
						</div>	     
          </div>
          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                	<ul class="nav navbar-right panel_toolbox">

                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-pembayaranKPKP">Tambah Pembayaran </button>

                   <a class="btn btn-warning" href="<?=base_url();?>pemakaman/transaksi_mutasi/print?id=<?=$dataKK[0]->id;?>" target="_BLANK">
                   	<i class="fa fa-print"></i> Cetak Rekap
                   </a>
                   	</ul>
          
                  <div class="x_content">
									<?php
										$mutasiiuran_kpkp['data']=$mutasiiuran_kpkp;
										$mutasiiuran_kpkp['dataKpkp2']=$dataKpkp2;
										$mutasiiuran_kpkp['total_biayaKPKP']=$dataKpkp['total_biayaKPKP'];
										$this->load->view('pemakaman/iuran_kpkp.php', $mutasiiuran_kpkp);
									?>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<!--modal nekat -->
    <div class="modal-pembayaranKPKP modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Pembayaran Iuran KPKP (Bulanan)</h4>
          </div>
          <div class="modal-body">
          	<div class="row">
            	<form id="form_pembayaran" action="<?=base_url();?>/pemakaman/simpan_pembayaran" method="POST">
                <div class="item form-group col-xs-12">
                  <label class="text-right control-label col-md-3 col-sm-6 col-xs-6" for="tgl_bayar">Tanggal Pembayaran <span class="required text-right"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="hidden" id="keluarga_jemaat_id_pembayaran" name="keluarga_jemaat_id" value="<?=$id;?>">
                    <input type="hidden" id="num_anggota_kpkp" name="num_anggota_kpkp" value="<?=$num_anggotaKPKP;?>">
                    <input type="date" id="tgl_bayar" name="tgl_bayar" required="required" class="form-control col-md-6 col-xs-6">
                  </div>
                </div>
                <div class="item form-group col-xs-12">
                  <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="nominal">Nominal <span class="required text-right">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" id="nominal" name="nominal" required="required" class="form-control" placeholder="Contoh: <?=number_format($total_biayaKPKP,0,",",".");?>">
                  </div>
              	</div>
              	<div class="item form-group col-xs-12">
                  <label class="control-label col-md-3 col-sm-6 col-xs-6 text-right" for="nominal">Iuran Sukarela <span class="required"></span><br>
                  	<span style="font-weight: 400;">Jika "<b class="text-danger text-sm">Ya</b>" akan memotong dari nilai <b class="text-danger text-sm">Nominal</b></span>
                  </label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <select class="form-control" id="option_sukarela" name="option_sukarela">
                    	<option value="0">Tidak, Terimakasih!</option>
                    	<option value="1">Ya, dengan nominal tertentu!</option>
                    	<option value="2">Ya, dipotong otomatis dari sistem!</option>
                    </select>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-6">
                    <input type="text" name="nominal_sukarela" id="nominal_sukarela" class="form-control" style="display: none;" placeholder="Contoh: 10.000">
                  </div>
              	</div>
              	<div class="item form-group col-xs-12">
                  <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="note">Catatan Pembayaran <span class="required text-right">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" id="note" name="note" class="form-control" placeholder="ex:Ada kurang pembayaran">
                  </div>
              	</div>
            	</form>
            </div>
        	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="btn_simpan_bayar">Simpan</button>
          </div>
        </div>
      </div>
    </div>


     <div class="modal-dompetKPKP modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Pembukaan Dompet KPKP</h4>
          </div>
          <div class="modal-body">
          	<div class="row">
            	<form id="form_bukadompetkpkp" action="<?=base_url();?>/pemakaman/bukadompetkpkp" method="POST">
                <div class="item form-group col-xs-12">
                  <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="nominal">Jumlah Jiwa <span class="required text-right">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="hidden" id="keluarga_jemaat_id_pembayaran" name="recid" value="<?=$id;?>">
                    <input readonly type="text" id="num_anggota_kpkp" name="num_anggota_kpkp" class="form-control" value="<?=$num_anggotaKPKP;?>">
                  </div>
              	</div>
              	<div class="item form-group col-xs-9">
                  <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="nominal">Saldo Awal <span class="required text-right">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" id="nominal" name="nominal" required="required" class="form-control" placeholder="Contoh: <?=number_format($total_biayaKPKP,0,",",".");?>">
                  </div>
              	</div>
            	</form>
            </div>
        	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="btn_buat_dompetkppk">Buat</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal-perbaikanMutasi modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		        </button>
		        <h4 class="modal-title" id="myModalLabel">Form Perbaikan Mutasi</h4>
		      </div>
		      <div class="modal-body" id="div_form_perbaikan">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		        <button type="button" class="btn btn-warning" id="btn_save_perbaikan" form="form_perbaikan">Simpan</button>
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
			$(document).on('click touchstart', '[id=btn_buat_dompetkppk]', function(e){
				$('#form_bukadompetkpkp').submit();
			})

			$(document).on('click touchstart', '[id=btn_simpan_bayar]', function(e){
				$('#form_pembayaran').submit();
				//dataMap={}
				//dataMap=$('#form_bayar').serialize()
				//url=$('#form_bayar').attr('action') 
				//console.log(url)
				//$.post(url, dataMap, function(data){

				//})
			})

			$(document).on('click', '[id=btn_save_perbaikan]', function(e){
				e.preventDefault()
				dataMap={}
				dataMap=$('#form_perbaikan').serialize()
				url=$('#form_perbaikan').attr('action')
				$.post(url, dataMap, function(data){
					$('.modal-perbaikanMutasi').modal('hide')	
					alert('Perbaikan transaksi berhasil!')
					location.reload();
				})


			})

			$(document).on('click', '[id=btn_approve_perbaikan]', function(e){
				e.preventDefault()
				conf=confirm('Apakah anda yakin melakukan perbaikan Saldo KPKP keluarga ini?')
				if(conf==false){
					return;
				}
				dataMap={}
				dataMap['kk_id']=$(this).attr('kk_id')
				dataMap['nominal_baru']=$(this).attr('total_mutasi')
				url=$(this).attr('href')
				$.post(url, dataMap,function(data){
					alert('Perbaikan saldo KPKP Keluarga berhasil!')
					location.reload();
				})
			})


			$(document).on('click', '[id^=btn_edit-Mutasi]', function(e){
				e.preventDefault()
				$('.modal-perbaikanMutasi').modal('show')
				dataMap={}
				url=$(this).attr('form')
				$.get(url, dataMap,function(data){
					$('#div_form_perbaikan').html(data)
				})
			})

			$(document).on('click', '[id^=btn_hapus-Mutasi]', function(e){
				e.preventDefault()
				conf=confirm('Apakah anda yakin melakukan Pembatalan Mutasi ini?')
				if(conf==false){
					return;
				}
				dataMap={}
				url=$(this).attr('href')
				$.get(url, dataMap,function(data){
					alert('Pembatalan Mutasi KPKP Keluarga berhasil!');
					location.reload();
				})
			})

			$(document).on('click', '[id=btn_choose_kwg]', function(e){
				e.preventDefault();

				recid=$(this).attr('kwg_id');
				dataMap={}
				dataMap=$('#form_kwg'+recid).serialize();
				url='<?=base_url();?>pemakaman/mutasi_keluarga/tautkanangjemKPKP?kwg_new=<?=$dataKK[0]->id;?>';
				jemaat_name=$(this).attr('jemaat_name');
				var r = confirm("Apa yakin ingin menambahkan "+jemaat_name+" ke dalam anggota KPKP Keluarga <?=$dataKK[0]->kwg_nama;?>");
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
				            message: 'Lakukan pengecekan pada Daftar Keluarga KPKP terlebih dulu!',
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

	$(document).on('click', '[id=btn_form_tautanangjem]', function(e){
		e.preventDefault()

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

	$(document).on('keyup', '[id=nominal_sukarela]', function(e){
		dataMap={}
		value=parseFloat($(this).val().replace('.',''))
		max=parseFloat($(this).attr('max').replace('.',''))
		console.log(value);
		console.log(max);
		if(value>=max){
			alert("Peringatan: \nNominal Sukarela lebih besar dari Nominal Setoran!");
			$(this).val(max-1)
		}

	})


	$(document).on('change', '[id=option_sukarela]', function(e){
		dataMap={}
		dataMap['option']=$(this).val() //1:tidak dipotong; 2:dipotong nominal tertentu; 3:dipotong oleh sisfo dari sisa yg dibayarkan.
		dataMap['recid']=$(this).attr('recid')
		nominal_setor=$('#nominal').val().replace('.','')
		console.log('option '+dataMap['option']+' | '+nominal_setor)

		if(dataMap['option']=='0'){
			$('#nominal_sukarela').hide();
		}
		else if(dataMap['option']=='1'){
			$('#nominal_sukarela').attr('max',nominal_setor);
			$('#nominal_sukarela').show();
		}
		else if(dataMap['option']=='2'){
			//nominal_sukarela
			beban_iuran_perbulan=parseFloat($('#beban_iuran_perbulan').val().replace(".", "") )
			console.log(beban_iuran_perbulan);
			if(nominal_setor<beban_iuran_perbulan){
				alert("Nominal Setoran lebih kecil daripada Beban Iuran per Bulan ("+beban_iuran_perbulan+")");
				e.preventDefault()
			}
		}
		
	})

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

	$(document).on('click', '[id=btn_copot_tautan]', function(e){
		nama_angjem=$(this).attr('jemaat_name')
		keluarga_tautan=$(this).attr('keluarga_tautan')
		confirm1=confirm("Apakah anda yakin akan melepaskan tautan "+nama_angjem+" dari "+keluarga_tautan+" ?")
		if(confirm1==false){
			return;
		}
		confirm2=confirm("Apakah anda ingin memutasikan dana KPKP "+nama_angjem+" ke Keluarga barunya ?")

		dana_pindah=1
		if(confirm2==false){
			dana_pindah=0
		}

		dataMap={}
		dataMap['angjem_id']=$(this).attr('angjem_id');
		dataMap['kwg_no']=$(this).attr('kwg_no');
		dataMap['kwg_no_kpkp']=$(this).attr('kwg_no_kpkp');
		dataMap['bulan_tercover']=$(this).attr('bulan_tercover');
		dataMap['dana_kpkp']=$(this).attr('dana_kpkp');
		dataMap['jemaat_name']=$(this).attr('jemaat_name');
		dataMap['dana_pindah']=dana_pindah;

		url=$(this).attr('href')
		$.post(url, dataMap, function(data){
			//$('#div_datakeluarga').html(data);
		})
	})

	var rupiah = document.getElementById("nominal");
  rupiah.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, "");
  });

  var rupiah1 = document.getElementById("nominal_sukarela");
  rupiah1.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah1.value = formatRupiah1(this.value, "");
  });


  /* Fungsi formatRupiah */
  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? prefix + " " + rupiah : "";
  }

  function formatRupiah1(angka1, prefix1) {
    var number_string = angka1.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah1 = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah1 += separator + ribuan.join(".");
    }

    rupiah1 = split[1] != undefined ? rupiah1 + "," + split[1] : rupiah1;
    return prefix1 == undefined ? rupiah1 : rupiah1 ? prefix1 + " " + rupiah1 : "";
  }
</script>