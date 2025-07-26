<?php 

$this->load->view('frontend/layouts/header');

?>

<?php $this->load->view('frontend/mjppj/feedback_form'); ?>

<style type="text/css">

  .blink_me {

  animation: blinker 2s linear infinite;

}



@keyframes blinker {

  30% {

    opacity: 0;

  }

}

</style>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">



<div class="container-fluid mt-4">

  <div class="row align-items-center">

    <div class="col-12 text-center" style="margin: auto;">

      <h2>Pemilihan Penatua <br>Tahap 1</h2>

    </div>

  </div>

<?php 

$this->load->view('frontend/mjppj/peserta_pemilih', array('anggota_sidi'=>$anggota_sidi));

?>













</div>



<hr>

<?php 

$this->load->view('frontend/layouts/footer');

?>

<div class="modal fade" id="pemberitahuanModal" tabindex="9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">



  <div class="modal-dialog modal-lg" role="document" style="margin-top: 15%;">

    <div class="modal-content" style="padding:10px;">

      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #333; float:right;">

        <span aria-hidden="true">×</span>

      </button>

      <div class="container-fluid">

        <h2 class="text-danger text-center blink_me">Pemberitahuan!</h2>

        Selamat memilih Penatua GKP Kampung Sawah.

        <br>

        Sebelum kita memilih, mintalah tuntunan Roh Kudus dalam doa dan ingatlah Firman Tuhan yang melandasi pemilihan yang kita lakukan, <div style="display: block;" class="text-center"><i class="text-center">"Apa yang telah engkau dengar dari padaku di depan banyak saksi, percayakanlah itu kepada orang-orang yang dapat dipercayai, yang juga cakap mengajar orang lain"</i>

        <br><b>(2 Timotius 2:2)</b>

        <br>

        <b>Tuhan memberkati kita semua!<br>😇🙏</b>

        </div>

        <hr style="margin-top:1rem; margin-bottom:1rem;">

        <h5 class="text-danger" style="margin-top:0px;margin-bottom:0px;">Ketentuan:</h5>

        <ol>

          <li>Silahkan Gunakan Hak Suara Anda dan <b>Pilih 8 Calon Penatua</b> yang tersedia (<b>4 Perempuan</b> & <b>4 Laki-Laki</b>)!</li>

          <li>Peserta Pemilihan hanya diperbolehkan memilih 8 Calon saja</li>

          <li>Peserta Pemilihan hanya diperbolehkan memilih Calon dari wilayahnya masing-masing.</li>

        </ol>

      </div>
      <div class="modal-footer">
        <button class="btn btn-primary btn-sm pull-right" type="button" data-dismiss="modal" aria-label="Close">
          Ya, Saya Mengerti!
        </button>
      </div>

    </div>



  </div>



</div>

<script type="text/javascript">



  $(document).ready(function(){

    $('#pemberitahuanModal').modal('show');

  })

  /*$(document).on('click touchstart', '[id^=calon_pn]', function(e){

    num_checked=parseInt($('[group_id=calon_pn]:checkbox:checked').length)

    $('#num_pilihan').html(num_checked);

    hak_suara=parseInt($('#hak_suara').html());

    if(num_checked>hak_suara){

      alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara+" calon!");

    }

  })*/

  $(document).on('click touchstart', '[id=btn_kunciPilihan]', function(e){

    var r = confirm("Apakah anda yakin ingin Mengunci Pilihan Calon Pnt? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");

    if (r == false) {

      return;

    } else {
      $('#feedbackModal').modal('show');
    }



    $('#loading').show();



    dataMap={}

    dataMap['id_pemilih']=$('#id_pemilih').val()

    dataMap['wil_pemilih']=$('#wil_pemilih').val()

    $.post('<?=base_url();?>pnppj/kunciPilihan', dataMap, function(data){

      json=$.parseJSON(data)

      if(json.status==1){

        iziToast.success({

          title: '',

          message: json.msg,

          position: "topRight",

        });

        $('#exampleModal').modal('hide')

      }

      else{

        iziToast.error({

          title: '',

          message: json.msg,

          position: "topRight",

        });

      }

      $('#loading').hide();

    })



  })

  

  $(document).on('click touchstart', '[id^=calon_pn]', function(e){

    $('#loading').show();

    ini=$(this);

    dataMap={}

    dataMap['id_pemilih']=$('#id_pemilih').val()

    dataMap['wil_pemilih']=$('#wil_pemilih').val()

    dataMap['val_calon']=$(this).val()

    num_voted=parseInt($('#num_voted').val());

    num_voted_wanita=parseInt($('#num_voted_wanita').val());

    num_voted_pria=parseInt($('#num_voted_pria').val());

    //console.log(num_voted+"alskla")

    hak_suara=parseInt($('#hak_suara').html());

    hak_suara_wanita=parseInt($('#hak_suara_wanita').html());

    hak_suara_pria=parseInt($('#hak_suara_pria').html());



    vote_jns_kelamin=$(this).attr('jns_kelamin')



    if($(this).prop('checked') == true){

      //alert("checking");

      dataMap['vote']=1 //1 voted

      if(num_voted>=8){

      //ini bearti sudah 10 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara+" calon!");

        $('#loading').hide();

        $(ini).prop('checked', false)

        return false;

      }

      

      if(num_voted_wanita>=hak_suara_wanita && vote_jns_kelamin=='p'){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_wanita+" calon Perempuan !"); 

        $('#loading').hide();

        $(ini).prop('checked', false)

        return false;

      }



      if(num_voted_pria>=hak_suara_pria  && vote_jns_kelamin=='l'){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_pria+" calon Laki-laki !"); 

        $('#loading').hide();

        $(ini).prop('checked', false)

        return false;

      }







    }else{

      //alert("unchecking");

      dataMap['vote']=2//2 unvote

    } 



    $.post('<?=base_url();?>pnppj/vote_tahap1', dataMap, function(data){

      json=$.parseJSON(data)

      if(dataMap['vote']==2 && json.status==3){

        //bearti gagal delet jadi tidak jadi unvoted

        ini.prop('checked', true);

      }

      else if(dataMap['vote']==1 && json.status==0){

        //bearti gagal voting jadi tidak jadi voted

        ini.prop('checked', false);

      }

      else if(dataMap['vote']==2 && json.status==2){

        //bearti berhasil delet

        num_voted=num_voted-1;

        $('#lbl_num_pilihan').html(num_voted)

        $('#num_voted').val(num_voted)

        console.log(num_voted+"akl")



        if(vote_jns_kelamin=='l'){

          num_voted_pria=num_voted_pria-1;

          $('#lbl_num_pilihan_pria').html(num_voted_pria)

          $('#num_voted_pria').val(num_voted_pria)

          console.log('l'+num_voted_pria)

        }

        else if(vote_jns_kelamin=='p'){

          num_voted_wanita=num_voted_wanita-1;

          console.log('p'+num_voted_wanita)

          $('#lbl_num_pilihan_wanita').html(num_voted_wanita)

          $('#num_voted_wanita').val(num_voted_wanita)

        }



      }

      else if(dataMap['vote']==1 && json.status==1){

        //bearti berhasil voting 

        num_voted=num_voted+1;

        $('#lbl_num_pilihan').html(num_voted)

        $('#num_voted').val(num_voted)

        console.log(num_voted+"mm")



        console.log(vote_jns_kelamin)



        if(vote_jns_kelamin=='l'){

          num_voted_pria=num_voted_pria+1;

          $('#lbl_num_pilihan_pria').html(num_voted_pria)

          $('#num_voted_pria').val(num_voted_pria)

          console.log('l'+num_voted_pria)

        }

        else if(vote_jns_kelamin=='p'){

          num_voted_wanita=num_voted_wanita+1;

          console.log('p'+num_voted_wanita)

          $('#lbl_num_pilihan_wanita').html(num_voted_wanita)

          $('#num_voted_wanita').val(num_voted_wanita)

        }



      }



      $('#loading').hide();

    })



  })



  $(document).on('click touchstart', '[id=col_nama_calon]', function(e){

    recid=$(this).attr('recid');

    if(recid!=undefined && recid!=0){

      $('#calon_pn'+recid).click()

    }

  })



  $(document).on('click touchstart', '[id=btn_filter]', function(e){

    val=$(this).attr('value')

    $('#filter_active').val(val)

  })

</script>

<!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>-->

 

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.2/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/rg-1.1.3/sb-1.2.1/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>