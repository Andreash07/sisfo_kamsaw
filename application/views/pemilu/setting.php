<?php

$this->load->view('layout/header');
?>

<!-- page content -->

<div class="right_col" role="main">
	<div class="row">
		<div class="col-xs-12">
          	<div class="x_panel tile">
	            <div class="x_title h3">
	            	Pengaturan Pemilihan
	            </div>
		        <div class="x_content" style="overflow-y: auto;" id="div_content">
		        	<table class="table table-stripped">
		        		<thead>
		        			<tr>
			        			<th class="text-center">#</th>
			        			<th class="text-center">Pemilihan</th>
			        			<th class="text-center">Tahun Pemilihan</th>
			        			<th class="text-center">Kunci / Buka</th>
			        			<th class="text-center">Action</th>
			        		</tr>
		        		</thead>
		        		<tbody>
		        			<?php 
		        			foreach ($lock_pemilihan as $key => $value) {
		        				# code...

		        				$checked="";
		        				if($value->locked==1){
		        					$checked="";
		        				}
		        				else if($value->locked==0){
		        					$checked="checked";
		        				}
	        				?>
	        					<tr>
				        			<td class="text-center"><?=$key+1;?></td>
				        			<td><?=$value->pemilihan;?></td>
				        			<td class="text-center"><?=$value->tahun_pemilihan;?></td>
				        			<td class="text-center">
				                        <div class="">
				                            <label>
				                            	<i class="fa fa-lock"></i>
				                              	<input type="checkbox" class="js-switch"  <?=$checked;?> recid="<?=$value->id;?>" title="<?=$value->pemilihan;?> <?=$value->tahun_pemilihan;?> " />
				                            	<i class="fa fa-unlock"></i>
				                            </label>
			                          	</div>
				        			</td>
				        			<td class="text-center">
				        			</td>
				        		</tr>
	        				<?php
		        			}
		        			?>
		        		</tbody>
		        		
		        	</table>
		        </div>
            </div>
    	</div>
	</div>
</div>



<?php

$this->load->view('layout/footer');

?>
<script type="text/javascript">
	$(document).on('click', '[class=js-switch]', function(e){
		url="<?=base_url();?>pemilu/lockunlock";
		dataMap={}
      	dataMap['recid']=$(this).attr('recid')
		if($(this).prop('checked') == true){
	      //alert("checking");
	      	dataMap['locked']=0 //0 open
	      	txt="Apakah Anda yakin ingin membuka "+$(this).attr('title')+"?";
	    }else{
	      //alert("unchecking");
	      	dataMap['locked']=1//1 lock
	      	txt="Apakah Anda yakin ingin menutup "+$(this).attr('title')+"?";
	    } 

	    var r = confirm(txt);
		if (r == false) {
			e.preventDefault();
			return false;
		} 

	    $.post('<?=base_url();?>pemilu/lockunlock', dataMap, function(data){
	    	json=$.parseJSON(data)
		})
	})
</script>