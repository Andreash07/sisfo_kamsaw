<div class="modal-header">

  <h6 class="modal-title" id="modal-title-default">List Calon Penatua</h6>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

    <span aria-hidden="true">×</span>

  </button>

</div>

<div class="modal-body" style="padding-top: unset; border-top: 1px #ededed solid;">
  <b style="display:block;"><?=$nama_pemilih;?></b>

  <label class="text-muted">Anda sudah memilih <b id="lbl_num_pilihan">0</b> dari <b id="hak_suara"><?=$hak_suara;?></b> <br>(<b id="lbl_num_pilihan_wil"><?= $num_voted_wil_pemilih;?></b> dari <b id="hak_suara_wil"><?=$hak_suara_wil;?></b><b> Wil. <?=$this->session->userdata('sess_keluarga')->kwg_wil;?></b> dan <b id="lbl_num_pilihan_mix"><?= $num_voted_wil_mix;?></b> dari <b id="hak_suara_mix"><?=$hak_suara_mix;?></b><b> Wil. Lain</b>)</label>

  <div class="clearfix"></div>

  <small class="text-danger">* Tolong klik tombol <b>Kunci Pilihan</b>. Agar suara pilihan Anda dianggap Sah.</small>

  <div class="clearfix"></div>
  <div class="row">
    <div class="col-6">
      <input type="text" name="keyword" id="keyword" value="" class="form-control" placeholder="Ketik Nama  Calon...">
    </div>
    <div class="col-4" >
      <select class="form-control" id="filter_wilayah" name="filter_wilayah">
        <option value="">Wilayah</option>
        <option value="1">Wil. 1</option>
        <option value="2">Wil. 2</option>
        <option value="3">Wil. 3</option>
        <option value="4">Wil. 4</option>
        <option value="5">Wil. 5</option>
        <option value="6">Wil. 6</option>
        <option value="7">Wil. 7</option>
      </select>
    </div>
    <div class="col-2 btn btn-warning" id="btn_filter">
        <i class="fa fa-search"></i>
    </div>
  </div>
  <form id="form_pemilihan" action="<?=base_url();?>pnppj/submit_pemilihan">
    <input type="hidden" name="hak_suara_wil_l" id="hak_suara_wil_l" value="<?=$hak_suara_wil_l;?>">
    <input type="hidden" name="hak_suara_wil_p" id="hak_suara_wil_p" value="<?=$hak_suara_wil_p;?>">

    <input type="hidden" name="hak_suara_mix_l" id="hak_suara_mix_l" value="<?=$hak_suara_mix_l;?>">
    <input type="hidden" name="hak_suara_mix_p" id="hak_suara_mix_p" value="<?=$hak_suara_mix_p;?>">

    <input type="hidden" name="id_pemilih" id="id_pemilih" value="<?=$id_pemilih;?>">

    <input type="hidden" name="wil_pemilih" id="wil_pemilih" value="<?=$wil_pemilih;?>">

    <br>
    <button type="button" class="btn btn-primary" id="btn_kunciPilihan" onclick="event.preventDefault()">Kunci Pilihan</button>
    <div id="div_list_calon2">
      <?php $this->load->view('ajax/list_calon2', array('calon'=>$calon, 'pagingnation'=>$pagingnation));?>

    </div>

    <input type="hidden" name="num_voted_wil_pemilih" id="num_voted_wil_pemilih" value="<?=$num_voted_wil_pemilih;?>">

    <input type="hidden" name="num_voted_wil_l" id="num_voted_wil_l" value="<?=$num_voted_wil_l;?>">
    <input type="hidden" name="num_voted_wil_p" id="num_voted_wil_p" value="<?=$num_voted_wil_p;?>">

    <input type="hidden" name="num_voted_wil_mix" id="num_voted_wil_mix" value="<?=$num_voted_wil_mix;?>">
    
    <input type="hidden" name="num_voted_wil_mix_l" id="num_voted_wil_mix_l" value="<?=$num_voted_wil_mix_l;?>">
    <input type="hidden" name="num_voted_wil_mix_p" id="num_voted_wil_mix_p" value="<?=$num_voted_wil_mix_p;?>">

    <input type="hidden" name="num_voted" id="num_voted" value="<?=$num_voted;?>">

  </form>

</div>

<div class="modal-footer">

  <small class="text-danger">* Tolong klik tombol <b>Kunci Pilihan</b>. Agar suara pilihan Anda dianggap Sah.</small>

  <div class="clearfix"></div>

  <button type="button" class="btn btn-primary" id="btn_kunciPilihan" onclick="event.preventDefault()">Kunci Pilihan</button>

</div>  



<script type="text/javascript">

  $(document).ready(function(){

    $('#lbl_num_pilihan').html('<?=$num_voted;?>');
  })
</script>