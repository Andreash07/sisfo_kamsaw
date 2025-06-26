<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				$this->load->view('pemilu/searchbox_pnt');
				?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                <div class="tile-stats">
	                  	<div class="icon"><i class="text-success fa fa-user"></i></div>
	                  	<div class="count"><?=$jemaatDapatDipilih;?></div>
	                  	<h3>Dapat Dipilih</h3>
	                  	<!--<p>Lorem ipsum psdea itgum rixt.</p>-->
	                </div>
            	</div>
          	    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                <div class="tile-stats">
						<div class="icon"><i class="text-danger fa fa-user-times"></i></div>
						<div class="count"><?=$jemaatNonDipilih;?></div>
						<h3>Tidak Dapat Dipilih</h3>
	                </div>
	            </div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<span>Menampilakn <b><?=count($data_jemaat);?></b> dari <b><?=$TotalOfData;?></b> <text class="text-danger">(Pemilihan Periode: <?=$tahun_pemilihan->periode;?>)</text></span>
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

		            $status_seleksi=0;
		            $msg_seleksi='<label class="label label-danger"><i class="fa fa-times"></i> Tidak Termasuk Kriteria Dipilih</label>';
		            $tglCutoff="2022-04-03";
		            $tglCutoff=$tahun_pemilihan->tgl_peneguhan;
					if( $value->tgl_lahir == '0000-00-00'){
						$umurLahir=0;
						$umurLahir_lbl="<i style='color:white; background-color:red;'>-</i>";
					}else{
						$umurLahir=getUmur($tglCutoff, $value->tgl_lahir);
						$umurLahir_lbl=$umurLahir." th";
					}

					if( $value->tgl_sidi == '0000-00-00'){
						$umurSidi=0;
						$umurSidi_lbl="<i style='color:white; background-color:red;'>-</i>";
					}
					else{
						$umurSidi=getUmur($tglCutoff, $value->tgl_sidi);
						$umurSidi_lbl=$umurSidi." th";
					}
					if( $value->tgl_attestasi_masuk == '0000-00-00'){
						$umurAttesasi=0;
						$umurAttesasi_lbl="<i style='color:white; background-color:red;'>Lama</i>";
					}
					else{
						$umurAttesasi=getUmur($tglCutoff, $value->tgl_attestasi_masuk);
						$umurAttesasi_lbl=$umurAttesasi." th";
					}

					if($umurLahir<=65 && $umurLahir>=25){
						$status_seleksi=$status_seleksi+1;
					}

					if($umurSidi<2 || ($umurAttesasi <1 && $value->tgl_attestasi_masuk != '0000-00-00') ){
						//continue;
						$status_seleksi=0;
					}
					else{
						$status_seleksi=$status_seleksi+1;
					}

					if($status_seleksi==2){
	            		$msg_seleksi='<label class="label label-success"><i class="fa fa-check-circle"></i> Termasuk Kriteria Dipilih</label>';
					}

					if($value->status_pn1==1){
						$checked="checked";
					}
					else{
						$checked="";
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
								<br>
								<b>Umur >=25 <=65: <?=$value->umur_cocok;?> </b>
								<br>
								<b>Sidi >2Th: <?=$value->sidi_cocok;?> </b>
								<br>
								<b>Attestasi >1Th: <?=$value->attestasi_cocok;?></b>
								<br>
								
								<?=$msg_seleksi;?>
							</td>
							<td style="width: 30%;">
								<b>Keluarga Keluarga:</b> <a href="<?=base_url();?>admin/DataJemaat?edit=true&id=<?=$value->kwg_no;?>"><?= $value->kwg_nama;?></a>
								<br>
								<b>Wilayah:</b> <?= $value->kwg_wil;?> 
								<br>
								<b>Tempat, Tgl Lahir:</b> <?= $value->tmpt_lahir.', '.convert_tgl_dMY($value->tgl_lahir) ;?>
								<br>
								<b>Tempat, Tgl Baptis:</b> <?= $value->tmpt_baptis.', '.convert_tgl_dMY($value->tgl_baptis) ;?>&nbsp;&nbsp;<?=$ico_status_baptis;?>
								<br>
								<b>Tempat, Tgl Sidi:</b> <?= $value->tmpt_sidi.', '.convert_tgl_dMY($value->tgl_sidi) ;?>&nbsp;&nbsp;<?=$ico_status_sidi;?>
								<br>
								<b>Attestasi Masuk:</b> <?= $value->pindah_dari.', '.convert_tgl_dMY($value->tgl_attestasi_masuk) ;?>
								<br>
								<b>Telp/HP:</b> <?= $value->telepon;?>
							</td>
							<td class='text-center'>
								<?php 
				                //print_r($this->session->userdata()); die();
				                if(in_array($this->session->userdata('userdata')->id, array(10, 16)) ){
				                ?>
								<div class="">
		                            <label>
		                            	<i class="fa fa-times text-danger"></i>
		                              	<input type="checkbox" class="js-switch"  <?=$checked;?> anggota_jemaat="<?=$value->id;?>" recid="<?=$value->bakal_calon_id;?>" title="<?=$value->nama_lengkap;?> (<?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> Th)" />
		                            	<i class="fa fa-check-circle text-success"></i>
		                            </label>
	                          	</div>
	                          	<?php 
	                          	}
	                          	?>
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

<script type="text/javascript">
	$(document).on('click', '[class=js-switch]', function(e){
		url="<?=base_url();?>pnppj/statuspn";
		dataMap={}
      	dataMap['recid']=$(this).attr('recid') //per 27 juni 2025 recidnya itu bakal_calon_id dari table anggota_jemaat_bakal_calon
		if($(this).prop('checked') == true){
	      //alert("checking");
	      	dataMap['locked']=1 //1 menerima Bakal Calon
	      	txt="Apakah Anda yakin ingin menerima "+$(this).attr('title')+" sebagai Bakal Calon Dipilih?";
	    }else{
	      //alert("unchecking");
	      	dataMap['locked']=-1//-1 membatalkan Bakal Calon
	      	txt="Apakah Anda yakin ingin membatalkan "+$(this).attr('title')+" sebagai Bakal Calon Dipilih?";
	    } 

	    var r = confirm(txt);
		if (r == false) {
			e.preventDefault();
			return false;
		} 

	    $.post(url, dataMap, function(data){
	    	json=$.parseJSON(data)
		})
	})
</script>