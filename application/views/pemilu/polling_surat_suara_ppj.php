<?php
$this->load->view('layout/header');
?>
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
              <h3>Suara Masuk</h3>
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
              <th title="<?=$value->sn_surat_suara;?>">
                <?=$value->sn_surat_suara;?>
              </th>
              <!--<td class='text-center'>
                 <?=$value->kwg_wil;?>
              </td>-->
              <td class='text-center'>
                 <?=$value->calon;?>
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
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-default pull-right" id="check_sn" name="check_sn" onclick="event.preventDefault();"><i class="fa fa-lock"></i> Kirim</button>
            </div>
          </form>
          <div class="divider"></div>
          <div class="row" id="div_surat_suara">
            
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
    })

  })
</script>

<script type="text/javascript">
  /*$(document).on('click touchstart', '[id^=calon_pn]', function(e){
    num_checked=parseInt($('[group_id=calon_pn]:checkbox:checked').length)
    $('#num_pilihan').html(num_checked);
    hak_suara=parseInt($('#hak_suara').html());
    if(num_checked>hak_suara){
      alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara+" calon!");
    }
  })*/
  $(document).on('click touchstart', '[id=btn_kunciPilihan]', function(e){
    var r = confirm("Apakah anda yakin ingin Mengunci Pilihan Calon PPJ? (Peringatan: Jika OK, anda tidak dapat mengubah lagi!)");
    if (r == false) {
      return;
    }

    $('#loading').show();

    dataMap={}
    dataMap['token']=$('#token').val()
    dataMap['id_pemilih']=$('#id_pemilih').val()
    dataMap['wil_pemilih']=$('#wil_pemilih').val()
    $.post('<?=base_url();?>pnppj/kunciPilihan_ppj_konvensional', dataMap, function(data){
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
    //console.log(num_voted+"alskla")
    hak_suara=parseInt($('#hak_suara').html());

    if($(this).prop('checked') == true){
      //alert("checking");
      dataMap['vote']=1 //1 voted
       if(num_voted>=1){
      //ini bearti sudah 1 voting
        alert("Peringatan: Anda tidak dapat memilih lebih dari "+hak_suara+" calon!"); 
        $('#loading').hide();
        return false;
      }
    }else{
      //alert("unchecking");
      dataMap['vote']=2//2 unvote
    } 

    $.post('<?=base_url();?>pnppj/vote_tahap_ppj', dataMap, function(data){
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

      }
      else if(dataMap['vote']==1 && json.status==1){
        //bearti berhasil voting 
        num_voted=num_voted+1;
        $('#lbl_num_pilihan').html(num_voted)
        $('#num_voted').val(num_voted)
  console.log(num_voted+"mm")

      }

      $('#loading').hide();
    })

  })

  $('#count_konven').html('<?=count($konvensional);?> &nbsp;')
  $('#count_online').html('<?=$TotalOfData;?> &nbsp;')
</script>