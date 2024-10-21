<?php $this->load->view('layout/header'); ?>
<div class="right_col" role="main">
  <div class="col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h4>Detail Blok Makam</h4>
      </div>
      <div style="display:flex; gap:1rem;">
        <div style="display:flex; flex-direction:column; gap:1rem;">
          <input
            class="form-control"
            style="width:12rem;"
            value="Lokasi"
            type="text"
            disabled>
          <input
            class="form-control"
            style="width:12rem;"
            value="Blok (kavling)"
            type="text"
            disabled>
        </div>
        <div style="display:flex; flex-direction:column; gap:1rem;">
          <input
            class="form-control"
            value="TPK Jamblang"
            type="text"
            disabled>
          <input
            class="form-control"
            value="A1"
            type="text"
            disabled>
        </div>
      </div>
    </div>
  </div>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#">Active</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" aria-disabled="true">Disabled</a>
    </li>
  </ul>
</div>
<?php $this->load->view('layout/footer'); ?>