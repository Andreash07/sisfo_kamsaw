<style>
	.text-center{
		text-align: center;
	}.text-left{
		text-align: left;
	}.text-right{
		text-align: right;
	}
	.table-bordered{
		border: 1px solid #000;

	}
	.table-bordered th{
		border: 1px solid #000;
		padding: 3px 5px 3px 5px;
    	font-size: 11px;
	}
	.table-bordered td{
		border: 1px solid #000;
		padding: 3px 5px 3px 5px;
    	/*font-size: 9px !important;*/
	}
	.table{
		border-collapse: collapse;
    	border-spacing: 0;
    	font-size: 10px;
	}

	.unset-td{
		border: 0px solid #000;
		padding: 0px 5px 1px 5px;
    	/*font-size: 9px !important;*/
	}
	.change {
    padding: 0 !important;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.change .sign {
	border: 1px solid #000;
    text-align: left !important;
}

.change .number {
    text-align: right !important;
}

.change.zero {
    text-align: right;
    display: table-cell;
}
</style>
<page>
	<h4 class="text-center">DATA IURAN ANGGOTA KPKP TERITORIAL <?=$kwg_wil;?><br>
		(HASIL KROSCEK BUKU BESAR DAN SISFO KPKP PERIODE <?=date('F Y');?>)<br>
	</h4>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th class='text-center' style="width: 5mm;">#</th>
				<th class='text-center' style="width: 60mm;">Nama KK</th>
				<th class='text-center' style="width: 5mm;">Wil</th>
				<th class='text-center' style="width: 20mm;">Iuran Wajib Per Bulan (Rp)</th>
				<th class='text-center' style="width: 25mm;" colspan="3">Jumlah Bulan (Ter-Bayarkan)</th>
				<th class='text-center' style="width: 15mm;" colspan="2">Nominal (Rp)</th>
				<th class='text-center' style="width: 20mm;">Nominal di Buku Besar</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($data_jemaat as $key => $value) {
					// code...
					$total_biayaKPKP=0;
					$total_biayaKPKP=$total_biayaKPKP+($value->num_anggota_kpkp*$pokok_iuran );
					$est_bulanTercover=countBulanTercover($total_biayaKPKP, $value->saldo_akhir, date('Y-m'));

					$lbl_neg_pos='+';
					$num_month=$est_bulanTercover['num_month'];
					$color='';
					if($est_bulanTercover['num_month'] < 0){
						$num_month=$est_bulanTercover['num_month']*-1;
						$lbl_neg_pos='-';
						$color=' color:red;';
					}
					else if($est_bulanTercover['num_month'] == 0){
						$lbl_neg_pos='';
					}

					$lbl_neg_pos2='+';
					$num_saldo=$value->saldo_akhir;
					$color2='';
					if($value->saldo_akhir < 0){
						$num_saldo=$value->saldo_akhir*-1;
						$lbl_neg_pos2='-';
						$color2=' color: red;';

					}
					else if($value->saldo_akhir == 0){
						$lbl_neg_pos2='';
					}
			?>
				<tr>
					<td class='text-center' style="width: 5mm;"><?=$row++;?></td>
					<td class='text-left' style="width: 60mm;"><?=$value->kwg_nama;?> (<i><?=$value->num_anggota_kpkp;?> Jiwa</i>)</td>
					<td class='text-center' style="width: 5mm;"><?=$value->kwg_wil;?></td>
					<td class='text-right' style="width: 20mm;"><?=number_format($pokok_iuran * $value->num_anggota_kpkp,0,",",".");?></td>
					<td class='text-left' style="border-right: 0px; inpadding: 0; <?=$color;?>">
						<?= $lbl_neg_pos ?>
					</td>
					<td class='text-right' style="<?=$color;?>">
			         	<?=$num_month;?>
					</td>
				 	<td class='text-center' style="width: 12mm; <?=$color;?>"><?=$est_bulanTercover['month'];?></td>
					<td class='text-left' style="border-right: 0px; inpadding: 0; <?=$color2;?>">
						<?=$lbl_neg_pos2;?>
					</td>
					<td class='text-right' style="width: 15mm; <?=$color2;?>"><?= number_format($num_saldo,0,",",".");?></td>
					<td></td>
				</tr>
			<?php 
				}
			?>
		</tbody>
	</table>
	<span style="margin-top:7px; font-size: 10px; font-style: italic;">tercetak: <?=date('d F Y | H:i:s');?></span>
</page>