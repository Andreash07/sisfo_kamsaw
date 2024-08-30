<div class="container-fluid">
  <div class="col-xs-12">
    <form id="form_search_kwg" action="<?=base_url();?>ajax/get_keluarga" method="POST" >
      <div class="form-group">
        <div class="col-md-12">
          <label for="keyword_keluarga">Anggota Jemaat</label>
        </div>
        <div class="col-md-10 col-xs-8">
          <input type="hidden" id="view" name="view" class="form-control" value="ajax/ls_keluarga_kpkp">
          <input type="text" name="keyword_keluarga" id="keyword_keluarga" class="form-control">
        </div>
        <div class="col-md-2 col-xs-4">
          <button id="btn_search" class="btn btn-warning " onclick="event.preventDefault();"><i class="fa fa-search"></i> Cari</button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-xs-12">
    <div class="divider"></div>
  </div>
  <div class="col-xs-12" id="div_datakeluarga">
    
  </div>
</div>