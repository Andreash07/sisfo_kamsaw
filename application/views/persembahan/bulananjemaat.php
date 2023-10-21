<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
				<?php
				$this->load->view('persembahan/searchbox_bulananjemaat');
				?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="x_panel">
				<span>Menampilkan <b><?=count($data_jemaat);?></b> dari <b><?=$TotalOfData;?></b></span>
				<table class='table table-striped'>
					<thead>
						<tr>
							<th class='text-center'>#</th>
							<th class='text-center'>Nomor Kartu</th>
							<th class='text-center'>Nama</th>
							<th class='text-center' style="width: 30%;">Ulasan</th>
							<th class='text-center' style="width: 30%;">Action</th>
						</tr>
					</thead>
					<tbody>
				<?php
				foreach ($data_jemaat as $key => $value) {
					# code...
					if($value->jns_kelamin=='L'){
	              		$jns_kelamin="Laki-laki";
		            }
		            else{
		              	$jns_kelamin="Perempuan";
		            }

		            $title="Ibu ";
					if($value->sts_kawin==1){
						$title="Sdri. ";
					}
					if(mb_strtolower($value->jns_kelamin)=='l'){
						$color_gender="bg-gradient-blue";
						$ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';
						$title="Bp. ";
						if($value->sts_kawin==1){
						  $title="Sdr. ";
						}
					}

					$partisipasi=0;
					if($value->b4>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b5>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b6>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b7>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b8>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b9>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b10>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b11>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b12>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b1>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b2>0){
						$partisipasi=$partisipasi+1;
					}
					if($value->b3>0){
						$partisipasi=$partisipasi+1;
					}
					$persetasi=$partisipasi/12*100;
					$color="danger";
					if($persetasi>30 && $persetasi<75){
						$color="warning";
					}else{
						$color="success";
					}
				?>
						<tr>
							<td class='text-center'><?=$key+$numStart+1;?></td>
							<td class='text-center'>
								<?=$value->no_kartu;?>
							</td>
							<td>
								<?=$title.$value->nama_lengkap;?>
							</td>
							<td style="width: 30%;" class="text-center">
								<small><?= round($persetasi,2);?>%</small>
								<div class="progress progress-striped">
			                        <div class="progress-bar progress-bar-<?=$color;?>" data-transitiongoal="<?=$persetasi;?>"></div>
		                      	</div>
							</td>
							<td class='text-center'>
								<a id="btn_detailpersembahan_<?php echo $value->id; ?>" href="<?= base_url().'persembahan/detailpersembahan';?>/<?php echo $value->id; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Anggota">
									<span class="fa fa-pencil" style="width:20%; display: unset;"></span>
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
	$(document).on('click touchstart', '[id^=btn_detailpersembahan_]', function(e){
		e.preventDefault()
		$('#myModal').modal('show')
		dataMap={}
		$('#loading').show();
		url=$(this).attr('href')
		$.post(url, dataMap, function(data){
			$('#modal-content').html(data);
			$('#loading').hide();
		})
	})
	$(document).on('click touchstart', '[id=btn_generatekartu]', function(e){
		e.preventDefault()
		dataMap={}
		dataMap['periode_id']=parseInt($('#periode_id').val())
		tahun_old=dataMap['periode_id']-1;
		var r=confirm("Apakah Anda yakin ingin Generate Kartu 20"+tahun_old+"/20"+dataMap['periode_id']+"?");
		if(r==false){
			return false
		}
		$('#loading').show();
		$.post('<?= base_url();?>ajax/generatenomorkartu', dataMap, function(data){
			json=$.parseJSON(data)
			if(json.sts==1){
				location.reload(); 
			}
			$('#loading').hide();
		})
	})


	$(document).on('click touchstart', '[id=btn_terimapersembahan]', function(e){
	e.preventDefault()
	dataMap={}
	dataMap['id_field']=$(this).attr('id_field')
	dataMap['recid']=$(this).attr('recid')
	dataMap['nominal']=parseInt($('#b'+dataMap['id_field']).val())
	dataMap['penerimaan']=$('#penerimaan_'+dataMap['id_field']).val()

	if(Number.isInteger(dataMap['nominal']) == false || dataMap['nominal']<=0){
        $('#b'+dataMap['id_field']).focus()
		iziToast.error({
            title: "Masukan Nilai Salah, Masukan Jumlah Nominal ("+$('#bulan'+dataMap['id_field']).html()+") dengan benar!",
            message: '',
            position: "topRight",
            class: "iziToast-error",
        });
        return;
	}

	if(dataMap['penerimaan'] == null || dataMap['penerimaan'] ==''){
        $('#penerimaan_'+dataMap['id_field']).focus()
		iziToast.error({
            title: "Masukan Tanggal Penerimaan ("+$('#bulan'+dataMap['id_field']).html()+")!",
            message: '',
            position: "topRight",
            class: "iziToast-error",
        });
        return;
	}
	var r=confirm("Apakah Anda yakin dengan penerimaan Persembahaan yang dimasukan?");
	if(r==false){
		iziToast.error({
            title: "Proses dibatalkan, Data belum disimpan!",
            message: '',
            position: "topRight",
            class: "iziToast-error",
        });
        return;
	}


	$.post('<?=base_url();?>persembahan/terimapersembahan', dataMap, function(data){
		json=$.parseJSON(data)
		if(json.sts==0){
			iziToast.error({
	            title: json.msg,
	            message: '',
	            position: "topRight",
	            class: "iziToast-error",
	        });
		}
		else if(json.sts==1){
			$('#myModal').modal('hide')
			iziToast.success({
	            title: json.msg,
	            message: '',
	            position: "topRight",
	            class: "iziToast-success",
	        });
	        setTimeout(function(){
	        	$('#btn_detailpersembahan_'+dataMap['recid']).click()
	        }, 1000)

		}
	})
})
</script>