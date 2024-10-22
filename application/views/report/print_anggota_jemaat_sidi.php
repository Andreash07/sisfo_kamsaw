<body >
<style type="text/css">
@media print {
	table{
		
	}
	th{
		border: 1px #000 solid !important; 
	}
	td{
		
	}
}
</style>
<button onclick="window.print();" style="width:100px; display:block;">Print</button>
<span>Menampilakn <b><?=count($data_jemaat);?></b> dari <b><?=$TotalOfData;?></b></span>
<table class='table table-striped' cellmargin="0" cellpadding="0" style="border: 1px #000 solid !important; border-collapse: collapse;">
	<thead>
		<tr>
			<th class='text-center' style="width: 7%; border: 1px #000 solid !important;" rowspan="2">#</th>
			<th class='text-center' style="width: 15%; border: 1px #000 solid !important;" rowspan="2">Nama</th>
			<th class='text-center' style="width: 8%; border: 1px #000 solid !important;" rowspan="2">Wilayah</th>
			<th class='text-center' style="width: 35%; border: 1px #000 solid !important;" colspan="3">Baptis</th>
			<th class='text-center' style="width: 35%; border: 1px #000 solid !important;" colspan="3">Sidi</th>
		</tr>
		<tr>
			<th>Status</th>
			<th>Tempat</th>
			<th>Tanggal</th>
			<th>Status</th>
			<th>Tempat</th>
			<th>Tanggal</th>
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

	$color_baptis="";
    if($value->tgl_baptis =='0000-00-00'){
    	$color_baptis="red";
    }

    $color_sidi="";
    if($value->tgl_sidi =='0000-00-00'){
    	$color_sidi="red";
    }

    $status_baptis="<i style='color:red;'>Belum</i>";
    if($value->status_baptis==1){
    	$status_baptis="Sudah";
    }
    $status_sidi="<i style='color:red;'>Belum</i>";
    if($value->status_sidi==1){
    	$status_sidi="Sudah";
    }
?>
		<tr>
			<td class='text-center' style="border: 1px #000 solid !important;"><?=$key+$numStart+1;?></td>
			<td style="width: 15%; border: 1px #000 solid;">
				<?=$value->nama_lengkap;?> (<b><?=getUmur(date('Y-m-d'), $value->tgl_lahir);?> Th</b>)- 
				<b><?=$value->hub_keluarga;?></b>
				<?= $value->telepon;?>
			</td>
			<td style="border: 1px #000 solid !important;">
				<?= $value->kwg_wil;?> 
			</td>
			<td style="border: 1px #000 solid !important;">
				<?= $status_baptis; ?>
			</td>
			<td style="border: 1px #000 solid !important;">
				<?= $value->tmpt_baptis; ?>
			</td>
			<td style="border: 1px #000 solid !important; background: <?=$color_baptis;?>;">
				<?= convert_tgl_dMY($value->tgl_baptis) ;?>
			</td>
			<td style="border: 1px #000 solid !important;">
				<?= $status_sidi; ?>
			</td>
			<td style="border: 1px #000 solid !important;">
				<?= $value->tmpt_sidi; ?>
			</td>
			<td style="border: 1px #000 solid !important;  background: <?=$color_sidi;?>;">
				<?= convert_tgl_dMY($value->tgl_sidi) ;?>
			</td>
		</tr>
<?php
}
?>
	</tbody>
</table>
</body>