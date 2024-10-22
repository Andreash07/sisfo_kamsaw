<?php $this->load->view('layout/header'); ?>
<div class="right_col" role="main">
  <div class="col-xs-12">
    <div class="x_panel">
      <div class="x_title" style="padding-bottom:2rem;">
        <h4>Detail Blok Makam</h4>
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
      <div class="x_content">
        <!-- Nav tabs -->
        <ul style="padding:0;" class="nav nav-tabs bar_tabs" role="tablist">
          <li role="presentation" class="active">
            <a
              href="#daftar-dimakamkan-tab-pane"
              role="tab"
              id="daftar-dimakamkan-nav-tab"
              data-toggle="tab">
              Daftar Dimakamkan</a>
          </li>
          <li role="presentation">
            <a
              href="#rincian-biaya-tab-pane"
              role="tab"
              id="rincian-biaya-nav-tab"
              data-toggle="tab">
              Rincian Biaya</a>
          </li>
          <li role="presentation">
            <a
              href="#mutasi-pembayaran-tab-pane"
              role="tab"
              id="mutasi-pembayaran-nav-tab"
              data-toggle="tab">
              Mutasi Pembayaran</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade active in" id="daftar-dimakamkan-tab-pane">
            <h1>Daftar Dimakamkan</h1>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="rincian-biaya-tab-pane">
            <h1>Rincian Biaya</h1>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="mutasi-pembayaran-tab-pane">
            <h1>Mutasi Pembayaran</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('layout/footer'); ?>