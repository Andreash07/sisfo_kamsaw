<?php
$this->load->view('layout/header');

$arr_color=array('success', 'info', 'warning', 'danger', 'primary','default');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="x_panel">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="text-danger fa fa-list-alt"></i></div>
            <div class="count" id="count_konven"><i class="fa fa-circle-o-notch fa-spin"></i></div>
            <h3>Surat Suara</h3>
          </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
              <div class="icon"><i class="text-success fa fa-check-square-o"></i></div>
              <div class="count" id="count_online"><i class="fa fa-circle-o-notch fa-spin"></i></div>
              <h3>Surat Suara Masuk</h3>
          </div>
        </div>
        <?php
        //$this->load->view('pemilu/searchbox_peserta_pemilihan');
        ?>
        <div class="col-xs-12">
          <a id="addSuratSuara" class="btn btn-primary" onclick="event.preventDefault()" href="#!" data-toggle="modal" data-target="#modalSuratSuara">
            <i class="fa fa-sign-in "></i> Surat Suara
          </a>
        </div>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel">
        <span>Menampilakn <b><?=count($voting);?></b> dari <b><?=$TotalOfData;?></b></span>
        <?= $pagingnation; ?>
        <table class='table table-striped'>
          <thead>
            <tr>
              <th class='text-center'>#</th>
              <th class='text-center'>SN Surat Suara</th>
              <!--<th class='text-center'>Wilayah Pemilih</th>-->
              <th class='text-center' style="/*width: 30%;*/">Calon Dipilih</th>
              <th class='text-center' style="/*width: 30%;*/">Dimasukan oleh</th>
            </tr>
          </thead>
          <tbody>
        <?php
        if(count($voting)>0){

        foreach ($voting as $key => $value) {
          ?>
            <tr>
              <td class='text-center'><?=$key+$numStart+1;?></td>
              <th class='text-center' title="<?=$value->sn_surat_suara;?>">
                <?=$value->sn_surat_suara;?>
              </th>
              <!--<td class='text-center'>
                 <?=$value->kwg_wil;?>
              </td>-->
              <td class='text-center' style="width:40%;">
                <?php 
                  if(isset($calon_vote[$value->sn_surat_suara])){
                    foreach ($calon_vote[$value->sn_surat_suara] as $key1 => $value1) {
                     // code...
                ?>
                      <span class="label label-<?=$arr_color[rand(0, 5)];?>" style="font-size:85%; font-weight: unset; line-height: 2;"><?=$value1->calon;?></span>
                <?php
                    }
                  ?>
                    <br>Sudah Memilih <?=count($calon_vote[$value->sn_surat_suara]);?>
                  <?php
                  }
                  else{
                ?>
                  -
                  <br>Sudah Memilih 0
                <?php
                  }
                ?>
              </td>
              <td class='text-center'>
                User: <i><?=$value->admin;?></i>
              </td>
            </tr>
          <?php 
          }
        }
        else{
        ?>
            <tr>
              <td class='text-center' colspan="4">Tidak Ada Surat Suara yang tercatat!</td>
            </tr>
        <?php
        }
          ?>
          </tbody>
        </table>
        <?= $pagingnation; ?>
      </div>
    </div>
  </div>
</div>

<!-- frame modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modalSuratSuara">

    <div class="modal-dialog  modal-lg" role="document">

        <div class="modal-content" id="modal-contentSuratSuara">
          <form id="form_sn_surat_suara" method="POST" action="<?=base_url();?>pnppj/check_token_ppj">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">SN Surat Suara<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="sn_surat_suara" name="sn_surat_suara" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" name ="tipe_pemilihan" value="2">
              </div>
            </div>
            <div class="form-group">
              <div class="btn btn-warning pull-right" onclick="$('#div_surat_suara').html('')"><i class="fa fa-trash"></i> Bersihkan</div>
              <button type="submit" class="btn btn-default pull-right" id="check_sn" name="check_sn" onclick="event.preventDefault();"><i class="fa fa-lock"></i> Kirim</button>
            </div>
          </form>
          <div class="divider"></div>
          <div class="row" >
            <div class="col-xs-12" id="div_surat_suara">
              
            </div>
          </div>
          <br>
          <br>
          <br>
        </div>

    </div>

</div>

<!-- frame modal -->
<?php
$this->load->view('layout/footer');
?>
<script type="text/javascript">
  $(document).on('click', '#check_sn', function(e){
    e.preventDefault()
    sn_surat_suara=$('#sn_surat_suara').val().replace(" ", "").replace("  ", "").trim()
    if(sn_surat_suara ==''){
      iziToast.error({
        title: 'Peringatan, SN Surat Suara tidak boleh kosong!',
        message: '',
        position: "topRight",
        class: "iziToast-danger",
      });
      return
    }
    $('#div_surat_suara').html('<i class= "fa fa-circle-o-notch fa-spin fa-2x"></i> Autentikasi SN Surat Suara')

    dataMap={}
    dataMap=$('#form_sn_surat_suara').serialize()
    url=$('#form_sn_surat_suara').attr('action')
    $.post(url, dataMap, function(data){
      $('#div_surat_suara').html(data)
      $('#sn_surat_suara').val('');
    })

  })
</script>

<script type="text/javascript">
  $(document).on('click touchstart', '[id=btn_kunciPilihan]', function(e){
    var r = confirm("Apakah anda yakin ingin Mengunci Pilihan Calon Pnt? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");
    if (r == false) {
      return;
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
    dataMap['token']=$('#token_pnt2').val()
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
    dataMap['surat_suara']=1



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

  $('#count_konven').html('<?=count($konvensional);?> &nbsp;')
  $('#count_online').html('<?=$TotalOfData;?> &nbsp;')
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.2/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/rg-1.1.3/sb-1.2.1/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>