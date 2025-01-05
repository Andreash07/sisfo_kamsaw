<?php
if(count($keluarga)==0){
?>
<h4 style="font-style: italic; font-weight: thin;" >Oooppss... Pencarian <b><?=$keyword;?></b> tidak ditemukan, Coba dengan nama yang lain!</h4>
<?php
die();
}
?>
<div class="row " style="overflow-y: auto; max-height: 440px;">
	<div class="col-xs-12">
		<ul class="list-unstyled msg_list">
		<?php
		foreach ($keluarga as $key => $value) {
			# code...
			$umur=0;
			if($value->tgl_lahir!= null && $value->tgl_lahir!='0000-00-00'){
				$umur=getUmur(date('Y-m-d'), $value->tgl_lahir);
			}
			
			$saldo_KPKP_angjem=0;
			$id_KPKP_kelangjem=0;

			if($value->sts_kpkp == 1){
				//get KPKP data dulu, sekalian di pindahin jika dia anggota KPKP
				$skpkp="select A.saldo_akhir, A.id, COUNT(B.id)  as num_anggota_KPKP
									from kpkp_keluarga_jemaat A 
									left join anggota_jemaat B on B.kwg_no = A.keluarga_jemaat_id && B.sts_kpkp=1
									where A.keluarga_jemaat_id='".$value->id."'";
				$rkpkp=$this->m_model->selectcustom($skpkp); //die(nl2br($skpkp));
				foreach ($rkpkp as $key2 => $value2) {
					// code...
					if($value2->id!=null && $value2->id!=0){
						$saldo_KPKP_angjem=$value2->saldo_akhir/$value2->num_anggota_KPKP;
						$id_KPKP_kelangjem=$value2->id;
					}
				}
			}
		?>
		<li>
			<a style="width: 100%">
		        <span>
		          	<span><b><?=$value->nama_lengkap;?> (<i><?=$umur;?>th - <?=$value->hub_keluarga;?></i>)</b></span>
		          	<span class="time">
		          		<button id="btn_choose_kwg" class="btn btn-info" kwg_id="<?=$value->id;?>" jemaat_name="<?=$value->nama_lengkap;?>" onclick="event.preventDefault();">Pilih</button>
		          	</span>
		          	<form id="form_kwg<?=$value->id;?>" action="<?=base_url();?>ajax/get_angjem" method="POST">
		          		<input type="hidden" name="view" value="ajax/data_jemaat">
		          		<input type="hidden" name="kwg_id" value="<?=$value->id;?>">
		          		<input type="hidden" name="jemaat_id" value="<?=$value->jemaat_id;?>">
		          		<input type="hidden" name="kwg_name" value="<?=$value->kwg_nama;?>">
		          		<input type="hidden" name="jemaat_name" value="<?=$value->nama_lengkap;?>">
		          		<input type="hidden" name="tgl_lahir" value="<?=$value->tgl_lahir;?>">
		          		<input type="hidden" name="umur" value="<?=$umur;?>">
		          		<input type="hidden" name="sts_kpkp" value="<?=$value->sts_kpkp ;?>">
		          		<input type="hidden" name="saldo_KPKP_angjem" value="<?=$saldo_KPKP_angjem;?>">
		          		<input type="hidden" name="id_KPKP_kelangjem" value="<?=$id_KPKP_kelangjem;?>">

		          		<?php 
		          			if($this->input->post('add_mutasi_keluarga')== TRUE && $value->sts_kpkp ==1){
          				?>
										<div class="checkbox">
						          <label class="text-danger">
						            <input type="checkbox" class="flat" checked="checked" id="konfirmasiKPKP<?=$value->jemaat_id;?>" name="konfirmasiKPKP<?=$value->jemaat_id;?>" > Dana KPKP ikut dipindahkan (Sesuai bulan tertampung saat ini)!
						          </label>
						        </div>
          				<?php
		          			}
		          		?>
		          	</form>
		        </span>
		        <span class="message" style="max-width: 95%">
		          Ditemukan pada Keluarga <b><?=$value->kwg_nama;?></b><br>di Wilayah <?=$value->wilayah;?>
		        </span>
		  	</a>
		</li>
		<?php
		}
		?>
		</ul>
	</div>
</div>