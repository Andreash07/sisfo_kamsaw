<?php 

$this->load->view('frontend/layouts/header');

?>

<?php $this->load->view('frontend/mjppj/feedback_form'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">



<div class="container-fluid mt-4">

  <div class="row align-items-center">

    <div class="col-12 text-center" style="margin: auto;">

      <h2>Pemilihan Penatua <br>Tahap 2</h2>

    </div>

  </div>

<?php 

$this->load->view('frontend/mjppj/peserta_pemilih2', array('anggota_sidi'=>$anggota_sidi));

?>













</div>



<hr>

<?php 

$this->load->view('frontend/layouts/footer');

?>



<div class="modal fade" id="pemberitahuanModal" tabindex="9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">







  <div class="modal-dialog modal-lg" role="document" style="margin-top: 15%;">



    <div class="modal-content" style="padding:10px;">



      <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close" >



        <span aria-hidden="true" class="text-danger" style="float:right; text-align: right; font-size:25pt;">×</span>



      </button>



      <div class="container-fluid">



        <h2 class="text-danger text-center blink_me">Pemberitahuan!</h2>
        
        <br>


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

          <!--

          <li>Silahkan Gunakan Hak Suara Bpk/Ibu/Sdr/i dan <b>Pilih 8 Calon Penatua</b> yang tersedia dengan ketentuan <b>4 calon</b> (<b>2 Perempuan</b> & <b>2 Laki-Laki</b>) dari <b>Wilayah <?=$wil_angjem;?></b> (Wilayah Bpk/Ibu/Sdr/i) & <b>4 calon</b> (<b>2 Perempuan</b> & <b>2 Laki-Laki</b>) dari <b>Wilayah Lainnya</b>!</li>



        <li>Peserta Pemilihan hanya diperbolehkan memilih <b>8 Calon</b> saja sesuai ketentuan pada <b>nomor 1</b> di atas, jika lebih maka kelebihan nama tersebut tidak akan dihitung.</li>



        <li>Tuliskan <b>Nama Calon</b> yang Bpk/Ibu/Sdr/i <b>Pilih</b> pada bagian kolom tabel yang telah disediakan dan isi sesuai dengan ketentuan pada <b>nomor 1</b> di atas</li>

      -->

        <li>Silahkan Gunakan Hak Suara Bpk/Ibu/Sdr/i dan <b>Pilih 8 Calon Penatua</b> yang tersedia dengan ketentuan <b>4 calon</b> (<b>2 Perempuan</b> & <b>2 Laki-Laki</b>) dari <b>Wilayah Bpk/Ibu/Sdr/i</b> & <b>4 calon</b> (<b>2 Perempuan</b> & <b>2 Laki-Laki</b>) dari <b>Wilayah Lainnya</b>!</li>



        <li>Peserta Pemilihan hanya diperbolehkan memilih <b>8 Calon</b> saja sesuai ketentuan pada <b>nomor 1</b> di atas, jika lebih maka kelebihan nama tersebut tidak akan dihitung.</li>



        </ol>



      </div>

      <div data-dismiss="modal" aria-label="Close" class="btn btn-success">

        Baik, Saya mengerti!

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

    $.post('<?=base_url();?>pnppj/kunciPilihan2', dataMap, function(data){

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

    dataMap['wil_calon']=$(this).attr('wil_calon')

    dataMap['val_calon']=$(this).val()

    dataMap['jns_kelamin']=$(this).attr('jns_kelamin')

    

    jns_kelamin=$(this).attr('jns_kelamin')

    console.log(jns_kelamin)



    num_voted=parseInt($('#num_voted').val());

    num_voted_wil_pemilih=parseInt($('#num_voted_wil_pemilih').val());

    num_voted_wil_l=parseInt($('#num_voted_wil_l').val());

    num_voted_wil_p=parseInt($('#num_voted_wil_p').val());



    hak_suara_wil=parseInt($('#hak_suara_wil').html());

    hak_suara_wil_l=parseInt($('#hak_suara_wil_l').val());

    hak_suara_wil_p=parseInt($('#hak_suara_wil_p').val());





    num_voted_wil_mix=parseInt($('#num_voted_wil_mix').val());

    num_voted_wil_mix_l=parseInt($('#num_voted_wil_mix_l').val());

    num_voted_wil_mix_p=parseInt($('#num_voted_wil_mix_p').val());



    hak_suara_mix=parseInt($('#hak_suara_mix').html());

    hak_suara_mix_l=parseInt($('#hak_suara_mix_l').val());

    hak_suara_mix_p=parseInt($('#hak_suara_mix_p').val());



    //console.log(num_voted+"alskla")

    hak_suara=parseInt($('#hak_suara').html());



    if($(this).prop('checked') == true){

      //alert("checking");

      dataMap['vote']=1 //1 voted

      if(num_voted>=hak_suara){

      //ini bearti sudah 5 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara+" calon!"); 

        $('#loading').hide();

        return false;

      }



      if(num_voted_wil_pemilih>=hak_suara_wil && dataMap['wil_pemilih'] == dataMap['wil_calon']){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_wil+" calon Wil. "+dataMap['wil_pemilih']+"!");

        $('#loading').hide(); 

        return false;

      }



      if(num_voted_wil_l>=hak_suara_wil_l && dataMap['wil_pemilih'] == dataMap['wil_calon'] && jns_kelamin=='l'){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_wil_l+" calon Laki-laki dari Wil. "+dataMap['wil_pemilih']+"!"); 

        $('#loading').hide();

        return false;

      }



      if(num_voted_wil_p>=hak_suara_wil_p && dataMap['wil_pemilih'] == dataMap['wil_calon'] && jns_kelamin=='p'){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_wil_p+" calon Perempuan dari Wil. "+dataMap['wil_pemilih']+"!"); 

        $('#loading').hide();

        return false;

      }



      if(num_voted_wil_pemilih>=hak_suara_wil && dataMap['wil_pemilih'] == dataMap['wil_calon']){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_wil+" calon Wil. "+dataMap['wil_pemilih']+"!"); 

        $('#loading').hide();

        return false;

      }



      if(num_voted_wil_mix>=hak_suara_mix && dataMap['wil_pemilih'] != dataMap['wil_calon']){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_mix+" calon Wil. Lain!");

        $('#loading').hide(); 

        return false;

      }



      if(num_voted_wil_mix_l>= hak_suara_mix_l && dataMap['wil_pemilih'] != dataMap['wil_calon'] && jns_kelamin=='l'){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_mix_l+" calon Laki-laki dari Wil. Lain!"); 

        $('#loading').hide();

        return false;

      }



      if(num_voted_wil_mix_p >=hak_suara_mix_p && dataMap['wil_pemilih'] != dataMap['wil_calon'] && jns_kelamin=='p'){

      //ini bearti sudah 2 voting

        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara_mix_p+" calon Perempuan dari Wil. Lain!"); 

        $('#loading').hide();

        return false;

      }





    }else{

      //alert("unchecking");

      dataMap['vote']=2//2 unvote

    } 



    $.post('<?=base_url();?>pnppj/vote_tahap2', dataMap, function(data){

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



        if(dataMap['wil_pemilih'] == dataMap['wil_calon']){

          num_voted_wil_pemilih=num_voted_wil_pemilih-1;

          $('#lbl_num_pilihan_wil').html(num_voted_wil_pemilih)

          $('#num_voted_wil_pemilih').val(num_voted_wil_pemilih)



          if(jns_kelamin=='l'){

            num_voted_wil_l=num_voted_wil_l-1;

            $('#num_voted_wil_l').val(num_voted_wil_l)

          }

          else if(jns_kelamin=='p'){

            num_voted_wil_p=num_voted_wil_p-1;

            $('#num_voted_wil_p').val(num_voted_wil_p)

          }



        }

        

        if(dataMap['wil_pemilih'] != dataMap['wil_calon']){

          num_voted_wil_mix=num_voted_wil_mix-1;

          $('#lbl_num_pilihan_mix').html(num_voted_wil_mix)

          $('#num_voted_wil_mix').val(num_voted_wil_mix)



          if(jns_kelamin=='l'){

            num_voted_wil_mix_l=num_voted_wil_mix_l-1;

            $('#num_voted_wil_mix_l').val(num_voted_wil_mix_l)

          }

          else if(jns_kelamin=='p'){

            num_voted_wil_mix_p=num_voted_wil_mix_p-1;

            $('#num_voted_wil_mix_p').val(num_voted_wil_mix_p)

          }

        }



        console.log(num_voted+"akl")



      }

      else if(dataMap['vote']==1 && json.status==1){

        //bearti berhasil voting 

        num_voted=num_voted+1;

        $('#lbl_num_pilihan').html(num_voted)

        $('#num_voted').val(num_voted)



        if(dataMap['wil_pemilih'] == dataMap['wil_calon']){

          num_voted_wil_pemilih=num_voted_wil_pemilih+1;

          $('#lbl_num_pilihan_wil').html(num_voted_wil_pemilih)

          $('#num_voted_wil_pemilih').val(num_voted_wil_pemilih)



          if(jns_kelamin=='l'){

            num_voted_wil_l=num_voted_wil_l+1;

            $('#num_voted_wil_l').val(num_voted_wil_l)

          }

          else if(jns_kelamin=='p'){

            num_voted_wil_p=num_voted_wil_p+1;

            $('#num_voted_wil_p').val(num_voted_wil_p)

          }

        }

        if(dataMap['wil_pemilih'] != dataMap['wil_calon']){

          num_voted_wil_mix=num_voted_wil_mix+1;

          $('#lbl_num_pilihan_mix').html(num_voted_wil_mix)

          $('#num_voted_wil_mix').val(num_voted_wil_mix)



          if(jns_kelamin=='l'){

            num_voted_wil_mix_l=num_voted_wil_mix_l+1;

            $('#num_voted_wil_mix_l').val(num_voted_wil_mix_l)

          }

          else if(jns_kelamin=='p'){

            num_voted_wil_mix_p=num_voted_wil_mix_p+1;

            $('#num_voted_wil_mix_p').val(num_voted_wil_mix_p)

          }

        }





        console.log(num_voted+"mm")



      }



      $('#loading').hide();

    })



  })

  

  $(document).on('click touchstart', '[id=btn_filter]', function(e){

    $('[id=keyword]').change()

  })



  $(document).on('change', '[id=filter_wilayah]', function(e){

    $('[id=keyword]').change()

  })



  $(document).on('change', '[id=keyword]', function(e){



    e.preventDefault();



    dataMap={}



    dataMap['view']='search'

    dataMap['id']=$('#id_pemilih').val()

    dataMap['kwg_wil']=$('#wil_pemilih').val()

    dataMap['filter_wilayah']=$('#filter_wilayah').val()



    dataMap['keyword']=$(this).val()







    $('#content_list_calon2').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw" style="color:#f2f4fa; margin:auto; margin-top:10px; margin-bottom:10px;"></i>')



    $.get('<?=base_url();?>ajax/list_calon_penatua2', dataMap, function(data){



      $('#div_list_calon2').html(data)



    })







  })







  $(document).on('click touchstart', '[id=num_page]', function(e){

    $('#content_list_calon2').css("min-height", $('#content_list_calon2').height());

    e.preventDefault();



    $("li.page-item.active" ).attr('class', 'page-item');

    

    page_id=$(this).closest( "li.page-item" ).attr('page_id');



    //olddom.attr('class', 'page-item')



    dataMap={}



    dataMap['view']='search'

    dataMap['id']=$('#id_pemilih').val()

    dataMap['kwg_wil']=$('#wil_pemilih').val()

    //dataMap['filter_wilayah']=$('#filter_wilayah').val()

    //dataMap['keyword']=$('[id=keyword]').val()



    url=$(this).attr('href')

    console.log(page_id)

    $("li[page_id="+page_id+"]").attr('class', 'page-item active');







    $('#content_list_calon2').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw" style="color:#f2f4fa; margin:auto; margin-top:10px; margin-bottom:10px;"></i>')



    $.get(url, dataMap, function(data){



      $('#content_list_calon2').html(data)



    })







  })





</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>