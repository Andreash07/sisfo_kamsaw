<?php $this->load->view('layout/header'); ?>

<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="x_panel">
        <?php $this->load->view('kpkp/add_and_filter'); ?>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h4>Data Blok Makam</h4>
        </div>
        <div style="display: flex; gap: 2rem;">
        </div>
        <table class="table">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Lokasi</th>
              <th class="text-center">Blok (kavling)</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $key => $d): ?>
              <tr>
                <td class="text-center"><?= $key+1; ?></td>
                <td class="text-center"><?= $d->lokasi ?></td>
                <td class="text-center">
                  <a href="<?= base_url(); ?>Data_Blok_Makam/detail?id=<?= $d->id ?>">
                    <button
                      class="btn btn-default btn-sm"
                      data-toggle="tooltip"
                      data-placement="bottom"
                      title="detail blok">
                      <?= $d->blok . $d->kavling ?>
                    </button>
                  </a>
                </td>
                <td class="text-center"><?= $d->jumlah_makam ?></td>
                <td class="text-center">
                  <?php if ($d->status == 1): ?>
                    Aktif
                  <?php else: ?>
                    Non Aktif
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <!-- button: edit data blok makam -->
                  <button
                    class="btn btn-warning btn-edit-blok-makam"
                    data-toggle="modal"
                    data-target="#modal-edit-blok-makam"
                    style="padding: 2px 12px 2px 2px"
                    id="<?= $d->id ?>"
                    lokasi="<?= $d->lokasi ?>"
                    blok="<?= $d->blok ?>"
                    kavling="<?= $d->kavling ?>">
                    <span class="fa fa-pencil" style="width:8.3%"></span>
                  </button>
                  <button delete-data-id="<?= $d->id ?>" class="btn btn-danger" style="padding: 2px 12px 2px 2px">
                    <span class="fa fa-trash " style="width:8.3%"></span>
                  </button>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal: tambah data blok makam -->
<div
  class="modal fade modal-blok-makam"
  tabindex="-1"
  role="dialog"
  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Tambah Data</h4>
      </div>
      <div class="modal-body" style="display:flex; flex-direction:column; gap:1rem;">
        <form style="display:flex; gap:1rem; align-items:center; margin-left:1rem;">
          <label class="control-label">Lokasi:</label>
          <select id="add-data-lokasi" class="form-control">
            <option value="TPK Jamblang">TPK Jamblang</option>
          </select>
          <label class="control-label">Blok:</label>
          <select
            id="add-data-blok"
            class="form-control"
            style="width:8rem;">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option>
            <option value="O">O</option>
          </select>
          <label class="control-label">Kavling:</label>
          <input
            type="number"
            id="add-data-kavling"
            class="form-control"
            style="width:6rem;" required />
        </form>
        <div style="display:flex; justify-content:flex-end;">
          <button
            class="btn btn-danger"
            style="width: 12rem;"
            data-dismiss="modal">
            Batal
          </button>
          <button
            id="tambah-data-blok-makam"
            class="btn btn-primary"
            style="width: 12rem;"
            data-dismiss="modal">
            Tambah
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal: edit data blok makam -->
<div id="modal-edit-blok-makam" class="modal">
  <div class="modal-dialog" style="width:32rem;">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Edit Data</h4>
      </div>
      <div class="modal-body" style="display:flex; gap:1rem;">
        <div>
          <label class="control-label" for="edit-lokasi">Lokasi</label>
          <select class="form-control" name="edit-lokasi" id="edit-lokasi">
            <option value="TPK Jamblang">TPK Jamblang</option>
          </select>
        </div>
        <div>
          <label class="control-label" for="edit-blok">Blok</label>
          <select id="edit-blok" class="form-control" name="edit-blok">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option>
            <option value="O">O</option>
          </select>
        </div>
        <div>
          <label class="control-label" for="edit-kavling">Kavling</label>
          <input
            id="edit-kavling"
            class="form-control"
            style="width:6rem;"
            type="number"
            name="edit-kavling">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger">Batal</button>
        <button
          id="edit-blok-makam-submit"
          data-id=""
          class="btn btn-success">
          Edit
        </button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('layout/footer'); ?>

<script type="text/javascript">
  $('#tambah-data-blok-makam').click(function() {
    $.ajax({
      url: '<?= base_url(); ?>Data_Blok_Makam',
      type: 'POST',
      data: {
        lokasi: $('#add-data-lokasi').val(),
        blok: $('#add-data-blok').val(),
        kavling: parseInt($('#add-data-kavling').val()),
      },
      success: function(data) {
        location.reload();
      }
    })
  });

  $('button[delete-data-id]').click(function() {
    $.ajax({
      url: '<?= base_url(); ?>Data_Blok_Makam',
      type: 'DELETE',
      data: {
        id: $(this).attr('delete-data-id'),
      },
      success: function(data) {
        location.reload();
      }
    })
  });

  $('#cari-data-makam').click(function() {
    const blok = $('#cari-data-makam-blok').val();
    const kavling = $('#cari-data-makam-kavling').val();
    const url = `<?= base_url(); ?>Data_Blok_Makam?blok=${blok}&kavling=${kavling}`;
    $.ajax({
      url,
      type: 'GET',
      success: function(data) {
        window.location.href = url;
      }
    });
  })

  $('.btn-edit-blok-makam').click(function() {
    $('#edit-blok-makam-submit').attr('data-id', $(this).attr('id'));
    $('#edit-lokasi').val($(this).attr('lokasi'));
    $('#edit-blok').val($(this).attr('blok'));
    $('#edit-kavling').val($(this).attr('kavling'));
  });

  $('#edit-blok-makam-submit').click(function() {
    $.ajax({
      url: '<?= base_url(); ?>Data_Blok_Makam',
      type: 'PATCH',
      data: {
        id: $(this).attr('data-id'),
        lokasi: $('#edit-lokasi').val(),
        blok: $('#edit-blok').val(),
        kavling: $('#edit-kavling').val(),
      },
      success: function(data) {
        location.reload();
      }
    });
  });
</script>