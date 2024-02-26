<form class="form-horizontal form-label-left" action="" method="GET">
    <div class="form-group col-md-6 col-xs-12">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
          dari Tanggal
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" name="datef" value="<?=$datef;?>" type="date">
        </div>
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">sampai Tanggal<span class="required">*</span></label>
      <div class="col-md-9 col-sm-9 col-xs-12">
          <input class="form-control" name="datet" value="<?=$datet;?>" type="date">
      </div>
    </div>

    <div class="form-group col-xs-12">
      <!--<a class="btn btn-warning pull-left" href="#modal_checkField" id="btn_checkFieldPrint"><i class="fa fa-print"></i> Print</a>-->
      <a class="btn btn-warning pull-left" href="<?=base_url();?>pemakaman/laporan_iuran_anggota/?<?=$_SERVER['QUERY_STRING'];?>&export=print" target="_BLANK"><i class="fa fa-print"></i> Print</a>
      <input type="submit" class="btn btn-primary pull-right" value="Cari" name="search">
    </div>
</form>