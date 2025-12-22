<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">
	<div class="row">

		<?php 
		foreach ($ls_wil as $key => $value) {
			# code...
			$NumAngjem=0;
    		if(isset($num_angjem)){
				$NumAngjem=$num_angjem->num_angjem;
    		}
    		if(!isset($voted_wil[$value->id])){
    			$voted_wil[$value->id]=array();
    		}
		?>
		<div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>Wilayah <?=$value->id;?> (Tahap 2)</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content fixed_height_390" style="overflow-y: auto; height: 600px;" id="div_perolehansuaraWilayah<?=$value->id;?>">
            	<?php $this->load->view('pemilu/perolehansuaraWilayah', array('voted_wil'=>$voted_wil[$value->id], 'NumAngjem'=>$NumAngjem));?>
            </div>
          	<div class="clearfix"></div>
          </div>
        </div>
        <?php
		}
		?>
	</div>
</div>



<?php

$this->load->view('layout/footer');

?>
<script type="text/javascript">
	$(document).on('click', '[id=btn_AcceptPemilihan]', function(e){
		e.preventDefault()
		var r = confirm("Apakah anda yakin ingin Menerima Calon Penatua terpilih (Tahap 2)? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");
	    if (r == false) {
	      return;
	    }
	    $('#loading').show()
	    wilayah=$(this).attr('wilayah');
	    tahun_pemilihan=$(this).attr('tahun_pemilihan');
		id_calon=$(this).attr('id_calon');
		dataMap={};
		dataMap['id_calon']=id_calon;
		dataMap['note']=$('#txt_note_'+dataMap['id_calon']).val();
		dataMap['tahun_pemilihan']=tahun_pemilihan;
		dataMap['wilayah']=wilayah;
		$.post('<?=base_url();?>pnppj/acceptJemaatTerpilih2', dataMap, function(data){
			json=$.parseJSON(data)
			if(json.status=1){
				iziToast.info({
		            title: '',
		            message: json.msg,
		            position: "topRight",
		            class: "iziToast-success",
		        });
				load_get_pemilu2_perwil(wilayah, tahun_pemilihan);
			}
			else{
				iziToast.error({
		            title: '',
		            message: json.msg,
		            position: "topRight",
		            class: "iziToast-danger",
		        });
			}
			//console.log("asdasda")
			//$('.modal').modal('hide')
			$('#loading').hide()
		})
	})
	$(document).on('click', '[id=btn_CancelPemilihan]', function(e){
		e.preventDefault()
		var r = confirm("Apakah anda yakin ingin Membatalkan Calon Penatua terpilih (Tahap 2)? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");
	    if (r == false) {
	      return;
	    }
	    $('#loading').show()
	    wilayah=$(this).attr('wilayah');
	    tahun_pemilihan=$(this).attr('tahun_pemilihan');
	    id_calon=$(this).attr('id_calon');
		dataMap={};
		dataMap['id_calon']=id_calon;
		dataMap['note']=$('#txt_note_'+dataMap['id_calon']).val();
		dataMap['tahun_pemilihan']=tahun_pemilihan;
		dataMap['wilayah']=wilayah;
		$.post('<?=base_url();?>pnppj/cancelJemaatTerpilih2', dataMap, function(data){
			json=$.parseJSON(data)
			if(json.status=1){
				iziToast.info({
		            title: '',
		            message: json.msg,
		            position: "topRight",
		            class: "iziToast-success",
		        });
				load_get_pemilu2_perwil(wilayah, tahun_pemilihan);
			}
			else{
				iziToast.error({
		            title: '',
		            message: json.msg,
		            position: "topRight",
		            class: "iziToast-danger",
		        });
			}
			//console.log("asdasda")
			//$('.modal').modal('hide')
			$('#loading').hide()
		})
	})

	function load_get_pemilu2_perwil(wilayah, tahun){
		dataMap2={}
		dataMap2['wilayah']=wilayah
		dataMap2['tahun']=tahun
		$.post('<?=base_url();?>pnppj/load_get_pemilu2_perwil', dataMap2, function(data){
			$('#div_perolehansuaraWilayah'+wilayah).html(data)
		})
	}
</script>