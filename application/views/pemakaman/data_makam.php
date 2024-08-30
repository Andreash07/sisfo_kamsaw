<?php

$this->load->view('layout/header');

?>

<div class="right_col" role="main">
<div class="row">
    

  <div class="col-xs-12">
    

      <div class="x_panel">
        <div class="x_title">

            <h4>Data Makam</h4>

            </div>
        <ul class="nav navbar-right panel_toolbox">

                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Tambah Data </button>
                    </ul>

 <!--  modalah    -->               
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Data Pemakaman</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <form id="form_pembayaran" action="" method="POST">
                      <div class="item form-group col-xs-12">
                        <label class="control-label text-right col-md-3 col-sm-6 col-xs-6" for="blok">Blok <span class="required text-right"></span>
                        </label>
                        <select>
                          <?php 
                            foreach ($blok as $key => $value) {
                              // code...
                          ?>
                              <option value="<?= $value->id;?>"><?=$value->blok;?><?=$value->blok;?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                      
                    </form>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="btn_simpan_bayar">Simpan</button>
                </div>
              </div>
            </div>
          </div>



      <span></span>

        <table class='table table-striped'>

          <thead>

            <tr>

              <th class='text-center'>#</th>

              <th class='text-center'>Lokasi</th>

              <th class='text-center' >Nama Blok</th>

              <th class='text-center' >Jumlah Makam</th>

              <th class='text-center' >Status</th>

             

              <!-- <th class='text-center' >Action</th> -->

            </tr>

          </thead>

          <tbody>

        
           

            <tr>

              <td class='text-center'>1</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok A</td>
              <td class='text-center'>5</td>
              <td class='text-center'>Aktif</td>



              <!-- <td class='text-center'>
                <a id="editKebaktian" href="" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal" class="btn btn-warning" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Anggota">

                  <span class="fa fa-pencil" style="width:20%; display: unset;"></span>

                </a>



                <a href="" class="btn btn-success" style="padding:unset; padding: 3px 7px 3px 7px;" title="Lihat Keluarga">

                  <span class="fa fa-trash" style="width:20%; display: unset;"></span>

                </a>

               
              </td> -->

            </tr>
            <tr>
              <td class='text-center'>2</td>
              <td class='text-center'>TPK Jati Sari</td>
              <td class='text-center'>Blok B</td>
              <td class='text-center'>7</td>
              <td class='text-center'>Aktif</td>
            </tr>
              <tr>
              <td class='text-center'>3</td>
              <td class='text-center'>TPK Bitung</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>8</td>
              <td class='text-center'>Aktif</td>
            </tr>
              <tr>
              <td class='text-center'>4</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok H</td>
              <td class='text-center'>3</td>
              <td class='text-center'>Aktif</td>
            </tr>
              <tr>
              <td class='text-center'>5</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok N</td>
              <td class='text-center'>21</td>
              <td class='text-center'>Aktif</td>
            </tr>
              <tr>
              <td class='text-center'>6</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>
                <tr>
              <td class='text-center'>7</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>
                <tr>
              <td class='text-center'>8</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>
                <tr>
              <td class='text-center'>9</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>
                <tr>
              <td class='text-center'>10</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>
                <tr>
              <td class='text-center'>11</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>
                <tr>
              <td class='text-center'>12</td>
              <td class='text-center'>TPK Jamblang</td>
              <td class='text-center'>Blok C</td>
              <td class='text-center'>11</td>
              <td class='text-center'>Aktif</td>
            </tr>



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