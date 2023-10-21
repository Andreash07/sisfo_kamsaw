<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">

	<div class="row">
    

		<div class="col-xs-12">

			<div class="x_panel">
        

				<form class="form-horizontal form-label-left" action="<?=base_url();?>kebaktian/kebaktian_gereja" method="POST">
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">
        	Tanggal Kebaktian
      	</label>
      	 <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="input-group" style="margin-bottom: 0!important">
              <input type="text" class="form-control datepicker" id="tgl_kbt" name="tgl_kbt" placeholder="Tanggal-Bulan-Tahun" aria-describedby="inputSuccess2Status" value="">
              <span class="input-group-btn">
                <button type="button" class="reset btn btn-warning" title="Reset Tanggal" msg="Yakin ingin mengreset data tanggal?" what="date">
                  <i class="fa fa-undo"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
    
    
    <div class="form-group col-md-6 col-xs-12">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Ibadah<span class="required">*</span>
        </label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
	      	<select class="form-control" id="jns_ibadah" name="jns_ibadah">
	          	
	        	<option value='6' selected>Ibadah Subuh</option>
	          	<option value='9'  selected>Ibadah Pagi</option>
	          	<option value='18' selected>Ibadah Sore</option>
	          	<option value='2' selected>Ibadah Spesial</option>
	          	<option value='0' disabled selected>Semua</option>
	        </select>
	    </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Pria<span class="required">*</span></label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
	        <input type="number" class="form-control" name="jml_pria" value="">
	  	</div>
    </div>
    
    <div class="form-group col-md-6 col-xs-12">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">
        Jumlah Wanita<span class="required">*</span>
      </label>
	  	<div class="col-md-9 col-sm-9 col-xs-12">
      	<input type="number" class="form-control" name="jml_wanita" value="">
	    </div>
    </div>

    <div class="form-group col-md-6 col-xs-12">
    	<label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan<span class="required">*</span></label>
    	<div class="col-md-9 col-sm-9 col-xs-12">
          <textarea class="form-control" name="ket_kebaktian"></textarea>
    	</div>
    </div>

    <div class="form-group col-xs-12">
      <!--<a class="btn btn-warning pull-left" href="#modal_checkField" id="btn_checkFieldPrint"><i class="fa fa-print"></i> Print</a>-->
      
    	<input type="submit" class="btn btn-primary pull-right" value="Submit" name="Add_kebaktian">
    </div>
</form>

			</div>

		</div>

		

	</div>


      <div class="x_panel">

      <span>Menampilakn <b><?=count($datakebaktian);?></b> dari <b><?=$TotalOfData;?></b></span>

        <table class='table table-striped'>

          <thead>

            <tr>

              <th class='text-center'>#</th>

              <th class='text-center'>Tanggal Kebaktian</th>

              <th class='text-center' >Jenis Ibadah</th>

              <th class='text-center' >Jumlah Pria</th>

              <th class='text-center' >Jumlah Wanita</th>

              <th class='text-center' >keterangan</th>

              <th class='text-center' >Action</th>

            </tr>

          </thead>

          <tbody>

        <?php

        foreach ($datakebaktian as $key => $value) {

          # code...


          if($value->jam_kebaktian=='6'){

                    $jam_kebaktian="Ibadah Subuh";

                }
            else if($value->jam_kebaktian=='9'){

                    $jam_kebaktian="Ibadah Pagi";

                }
            else if($value->jam_kebaktian=='18'){

                    $jam_kebaktian="Ibadah Sore";

                }

                else{

                    $jam_kebaktian="Ibadah Spesial";

                }

         ?>
           

            <tr>

              <td class='text-center'><?=$key+$numStart+1;?></td>

              <td class='text-center'>

                <?=$value->tgl_kebaktian;?> 

              </td>

              <td class='text-center'>

                <?=$jam_kebaktian;?> 


              </td>
              <td class='text-center'>

                <?=$value->pria_kebaktian;?> 


              </td>
              <td class='text-center'>

                <?=$value->wanita_kebaktian;?> 


              </td>
              <td class='text-center'>

                <?=$value->ket_kebaktian;?> 


              </td>

              <td class='text-center'>
                <a id="editKebaktian" href="<?= base_url().'kebaktian/kebaktian_gereja?editKebaktian=true&';?>id=<?php echo $value->id_kebaktian; ?>" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Anggota">

                  <span class="fa fa-pencil" style="width:20%; display: unset;"></span>

                </a>



                <a href="<?=base_url();?>kebaktian/kebaktian_gereja?hapusKebaktian=true&';?>id=<?php echo $value->id_kebaktian;?>" class="btn btn-success" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Keluarga">

                  <span class="fa fa-trash" style="width:20%; display: unset;"></span>

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

<?php

$this->load->view('layout/footer');

?>

<script type="text/javascript">


  /*$('.single_cal1').daterangepicker({
    singleDatePicker: true,
    singleClasses: "picker_1",
    locale: {
      format: 'DD-MM-YYYY'
    }, 
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });*/
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
  });


	$(document).on('click', '[id=btn_exec_print]', function(e){
		$('#form_field').submit();
	})

	$(document).on('click', '[id=btn_checkFieldPrint]', function(e){
		e.preventDefault()
		$('#modal_checkField').modal('show');
	})

	$(document).on('click', '[id=editKebaktian]', function(e){

		url=$(this).attr('href');

		$.get(url, function(data){

			$('#modal-content').html(data)

		})

	})

</script>