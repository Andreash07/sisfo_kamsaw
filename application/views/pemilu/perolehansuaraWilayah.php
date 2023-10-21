<?php 

$percent=0;

$Tot_percent=0;

$Tot_masuk=0;

$Tot_banyaksuara=0;

$slot=6;



if(isset($voted_wil) && count($voted_wil) > 0){

	foreach ($voted_wil as $keyvoted => $valuevoted) {

		# code...

		$percent=$valuevoted->voted/$NumAngjem*100;

		//$Tot_masuk=$Tot_masuk+$valuevoted;

		$btn_Slot="";

		$btn_Process="";

		if($valuevoted->status_terpilih ==1 || $valuevoted->status_terpilih == NULL){

			//inibeart

			$slot=$slot-1;

		}



		if($slot>=0 && $valuevoted->status_terpilih == null){

			$btn_Process='<button class="btn btn-info btn-small" id="btn_ProsesPemilihan" id_calon="'.$valuevoted->id.'"  tahun_pemilihan="'.$valuevoted->tahun_pemilihan.'"  wilayah="'.$valuevoted->kwg_wil.'" data-toggle="modal" data-target="#modal'.$valuevoted->id.'" >Proses</button>';



			$btn_Slot.='<button class="btn btn-success btn-small" id="btn_AcceptPemilihan" id_calon="'.$valuevoted->id.'"  tahun_pemilihan="'.$valuevoted->tahun_pemilihan.'"  wilayah="'.$valuevoted->kwg_wil.'" data-dismiss="modal" title="Terima"><i class="fa fa-check"></i></button>';

			$btn_Slot.='<button class="btn btn-danger btn-small" id="btn_CancelPemilihan" id_calon="'.$valuevoted->id.'" tahun_pemilihan="'.$valuevoted->tahun_pemilihan.'" wilayah="'.$valuevoted->kwg_wil.'" data-dismiss="modal" title="Batal"><i class="fa fa-times"></i></button>';



		}

		else{

				$btn_Process.="<label class='btn label label-warning disabled'><i class='fa fa-info'></i> Tidak Terpilih</label>";

		}

		

		if($valuevoted->status_terpilih == 1){

			$btn_Process="<label class='btn label label-success' data-toggle='modal' data-target='#modal".$valuevoted->id."' ><i class='fa fa-success'></i> Diterima</label>";

		}

		else if($valuevoted->status_terpilih == 2){

			$btn_Process="<label class='btn label label-danger' data-toggle='modal' data-target='#modal".$valuevoted->id."'><i class='fa fa-times'></i> Dibatalkan</label>";

		}



		$disTextArea="";

		if($valuevoted->status_terpilih != null){

			$disTextArea="disabled";

		}

//$this->m_model->updateas('id', $valuevoted->id_terpilih, array('persen_vote'=>$percent,'last_vote'=>$valuevoted->last_vote), 'jemaat_terpilih1');

	?>

		<div class="widget_summary">

            <div class="w_left w_55">

              <span><?=$keyvoted+1;?>. <?=$valuevoted->nama_lengkap;?></span>

            </div>

            <div class="w_center w_15 text-center">

              <div class="progress" style="margin-bottom: 0px;">

                <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="<?=$percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent;?>%;">

                  <span class="sr-only"><?=$valuevoted->voted;?></span>

                </div>

              </div>

              <small class="">

              	&nbsp;<?=$valuevoted->voted;?> (<?= round($percent,2);?>%)

              </small>

              <div class="clearfix"></div>

            </div>
            <div class="w_right w_30">
            <?php 
            if(isset($this->session->userdata('userdata')->username)){
            ?>
	             <?=$btn_Process;?>

            <?php 
						}else{
            ?>
							
            <?php 
						}
            ?>
            </div>

            <div class="clearfix"></div>

        </div>

        <div class="divider"></div>



        <div id="modal<?=$valuevoted->id;?>" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">

	        <div class="modal-dialog modal-sm">

	          <div class="modal-content">



	            <div class="modal-header">

	              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>

	              </button>

	              <h4 class="modal-title" id="myModalLabel2"><?=$valuevoted->nama_lengkap;?></h4>

	            </div>

	            <div class="modal-body">

	              <h4>Catatan</h4>

	              <textarea id="txt_note_<?=$valuevoted->id;?>" name="txt_note_<?=$valuevoted->id;?>" class="form-control" rows="3" placeholder="Ketikan catatan Calon Terpilih jika ada..." style="resize: none;" <?=$disTextArea;?>><?= $valuevoted->note;?></textarea>

	            </div>

	            <div class="modal-footer">

	              <?=$btn_Slot;?>

	            </div>



	          </div>

	        </div>

	      </div>

	<?php

	}

}

else{

?>

Belum ada data pemilihan masuk.

<?php

}



//$Tot_percent=($NumAngjem-$Tot_masuk)/$NumAngjem*100;

?>