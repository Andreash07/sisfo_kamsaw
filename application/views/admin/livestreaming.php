<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">
  	<h2>Live Streaming</h2>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<a class="btn btn-primary" data-toggle="modal" data-target="#myModal_addsteaming">Add</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Tanggal</th>
						<th>Link</th>
						<th>Image</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				foreach ($livestreaming as $key => $value) {
					// code...\
					$checked="";
					if($value->status==1){
						$checked="checked";
					}
				?>
					<tr>
						<td><?=$key+1;?></td>
						<td><?=$value->date;?></td>
						<td><?=$value->url;?></td>
						<td><img src="<?=$value->img;?>" style="width: 150px; height:auto;"></td>
						<td>
							<label>
			                    <input type="checkbox" class="js-switch"  <?=$checked;?> recid="<?=$value->id;?>" />
			                </label>
			                <br>
							<a id="btn_ls" class="btn btn-warning" href="<?=base_url();?>ajax/get_content_yt?recid=<?=$value->id;?>&yt_id=<?=str_replace('https://youtu.be/', '', $value->url);?>">Get Content</a>
							<a id="btn_ls" class="btn btn-danger" href="<?=base_url();?>notification/sendNotification_livestreaming?recid=<?=$value->id;?>&yt_id=<?=$value->url;?>">Push Notification</a>
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

<div class="modal fade" tabindex="-1" role="dialog" id="myModal_addsteaming">

    <div class="modal-dialog  modal-lg" role="document">

        <div class="modal-content" id="modal-content">
        	<form action="<?=base_url();?>admin/addlivestreaming" method="POST">
        		<div class="form-group">
	        		<label for="date">date</label>
	        		<input type="date" name="date" id="date" class="form-control">
	        	</div>
	        	<div class="form-group">
	        		<label for="url">URL</label>
	        		<input type="text" name="url" id="url" class="form-control">
	        	</div>
	        	<button type="submit">Save</button>
        	</form>

        </div>
    </div>
</div>
<?php

$this->load->view('layout/footer');

?>

<script type="text/javascript">
	$(document).on('click', '#btn_ls', function(e){
		e.preventDefault()
		dataMap={}
		url=$(this).attr('href')
		$.post(url, dataMap, function(data){

		})
	})

 $(document).on('click', '[class=js-switch]', function(e){
    url="<?=base_url();?>admin/udpatestatus_link";
    dataMap={}
    dataMap['recid']=$(this).attr('recid')

    if($(this).prop('checked') == true){
        //alert("checking");
      	dataMap['locked']=1 //calon pemilih memilih secara offline
  	}else{
    //alert("unchecking");
      	dataMap['status']=0 //calon pemilih memilih secara ONLINE
  	} 

  	$.post(url, dataMap, function(data){
        //json=$.parseJSON(data)
    })
  })
</script>