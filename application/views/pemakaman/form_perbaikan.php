<div class="row">
  <div class="col-xs-12">
    <form class="form-horizontal form-label-left input_mask" action="<?=base_url();?>pemakaman/submit_perbaikan?id=<?=$recid;?>" method="POST" id="form_perbaikan">
      <?php
      foreach ($data as $key => $value) {
        // code...
      ?>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" class="form-control" placeholder="Tanggal" name="tanggal" id="tanggal" disabled value="<?= date('d M Y', strtotime($value->tgl_bayar)) ;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Transaksi</label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" class="form-control" placeholder="Deskripsi Transaksi" name="note" id="note" value="<?=$value->note;?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Nominal</label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" class="form-control" placeholder="10000" name="nominal" id="nominal" value="<?=$value->nominal;?>">
          </div>
        </div>
      <?php
      }
      ?>
    </form>
  </div>
</div>