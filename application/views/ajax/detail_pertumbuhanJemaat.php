<div class="row">
	<div class="col-xs-12">
	<div class="col-xs-12 col-md-6">
		<h4>Data Kelahiran</h4>	
		<table class="table table-striped table-border">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Anak</th>
					<th class="text-center">Tempat & Tgl<br>Lahir</th>
					<th class="text-center">Keluarga</th>
					<th class="text-center">Wilayah</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($lahir as $key =>$value){
					$ortu="";
					$title="Bp. ";
					if($value->ortu1 !=''){
						if(strtolower($value->jns_kelamin1)=='p'){
							$title="Ibu ";
						}
						$ortu.=$title.$value->ortu1;
					}

					$title="Bp. ";
					if($value->ortu2 !=''){
						if(strtolower($value->jns_kelamin2)=='p'){
							$title="Ibu ";
						}
						$ortu.="<br>&<br>".$title.$value->ortu2;
					}

					$jns_kelamin='Laki-Laki';
					if(strtolower($value->jns_kelamin) =='p'){
						$jns_kelamin='Perempuan';
					}
				?>
				<tr>
					<td class="text-center"><?=$key+1;?></td>
					<td><?=$value->nama_lengkap;?><br><small>(<?=$jns_kelamin;?>)</small></td>
					<td class="text-center"><?=$value->tmpt_lahir;?> <br> <?=convert_tgl_MdY($value->tgl_lahir);?></td>
					<td class="text-center"><?=$ortu;?></td>
					<td class="text-center">Wil. <?=$value->kwg_wil;?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="col-xs-12 col-md-6">
		<h4>Data Meninggal</h4>	
		<table class="table table-striped table-border">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Nama</th>
					<th class="text-center">Tempat & Tgl<br>Meninggal</th>
					<th class="text-center">Wilayah</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($meninggal as $key =>$value){
					$jns_kelamin='Bp. ';
					if(strtolower($value->jns_kelamin) =='p'){
						$jns_kelamin='Ibu ';
					}
				?>
				<tr>
					<td class="text-center"><?=$key+1;?></td>
					<td><?=$jns_kelamin;?><?=$value->nama_lengkap;?></td>
					<td class="text-center"><?=$value->tmpt_meninggal;?> <br> <?=convert_tgl_MdY($value->tgl_meninggal);?></td>
					<td class="text-center">Wil. <?=$value->kwg_wil;?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</div>