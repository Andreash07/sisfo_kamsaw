<?php $this->load->view('layout/header'); ?>

<div class="right_col" role="main">
  <div class="x_panel">
    <div class="x_title">
      <h3>Ulasan Pengguna</h3>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">

      <div class="table-responsive">
        <table id="ulasan-table" class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">Nama </th>
              <th class="column-title">Module </th>
              <th class="column-title">Rating </th>
              <th class="column-title">Pesan </th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($ulasan as $u): ?>
              <tr>
                <td><?= htmlspecialchars($u->nama) ?></td>
                <td><?= htmlspecialchars($u->module) ?></td>
                <td><?= htmlspecialchars($u->rating) ?></td>
                <td><?= htmlspecialchars($u->pesan) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap.min.js"></script>

<script>
  $(function () {
    $('#ulasan-table').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      order: [],
      language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' }
    });
  });
</script>

<?php $this->load->view('layout/footer'); ?>