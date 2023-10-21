<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
	      	<div class="x_panel tile">
	            <div class="x_title">
	              	<h2>Suara Tahap 2</h2><h2 class="pull-right"> Total Suara Masuk <b id="tot_suara">menghitung...</b></h2>
	              	<div class="clearfix"></div>
	            </div>
	            <div class="x_content" id="div_perolehansuara">
	            	<?php $this->load->view('pemilu/perolehansuara', array('voted'=>$voted, 'NumAngjem'=>$num_angjem));?>
	            </div>
	          	<div class="clearfix"></div>
	      	</div>
        </div>
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
				load_get_pemilu2(wilayah, tahun_pemilihan);
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
				load_get_pemilu2(wilayah, tahun_pemilihan);
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

	function load_get_pemilu2(wilayah, tahun){
		dataMap2={}
		dataMap2['wilayah']=wilayah
		dataMap2['tahun']=tahun
		$.post('<?=base_url();?>pnppj/load_get_pemilu2', dataMap2, function(data){
			$('#div_perolehansuara').html(data)
		})
	}
</script>