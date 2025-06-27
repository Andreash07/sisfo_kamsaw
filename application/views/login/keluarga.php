<?php $this->load->view('frontend/layouts/header'); ?>
<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-primary">
    <div class="container">
      <div class="header-body text-center">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 py-6">
            <h1 class="text-white">Selamat Datang</h1>
            <p class="text-lead text-white">
              Apps Keluarga Jemaat
              <br>
              GKP Kampung Sawah
              <br>
              <small>Ver. 0.99 Beta</small>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
      <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
      </svg>
    </div>
  </div>
  <!-- End Header -->
  <!-- Page content -->
  <div class="container pt-6 pb-2">
    <div class="row justify-content-center">
      <div class="col-lg-4">

        <div class="card bg-secondary">
          <div class="card-body p-lg-5">

            <!-- qr code scanner -->
            <div id="my-qr-reader"></div>

            <!-- user id login form -->
            <form class="d-none" role="form" method="POST" action="<?= base_url(); ?>login/auth_user_keluarga">
              <div class="form-group mb-3">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                  </div>
                  <input class="form-control" placeholder="ID Pengguna" type="text" name="username">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input class="form-control" placeholder="Kata Sandi" type="password" name="password">
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Masuk</button>
              </div>
            </form>

            <div class="text-center">
              <div class="my-4">
                <bold">atau masuk dengan...</bold>
              </div>
              <button class="btn btn-danger" id="change-login-btn">User ID</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('frontend/layouts/footer'); ?>

<script src="https://unpkg.com/html5-qrcode"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/frontend/js/qrCodeScanner.js"></script>
<script>
  const myQRReader = document.getElementById('my-qr-reader');
  const form = document.querySelector('form');
  const changeLoginBtn = document.getElementById('change-login-btn');

  changeLoginBtn.addEventListener('click', function() {
    // Toggle visibility of QR reader and form
    myQRReader.classList.toggle('d-none');
    form.classList.toggle('d-none');

    if (changeLoginBtn.innerText === 'User ID') {
      changeLoginBtn.innerText = 'Scan QR';
    } else {
      changeLoginBtn.innerText = 'User ID';
    }
  });
</script>

<?php
if ($this->session->userdata('sess_token_valid') == -1) {
  //ini bearti login gagal
?>
  <script type="text/javascript">
    iziToast.error({
      title: '',
      message: 'Maaf, Proses Login Gagal! (ID Penggunan dan Kata Sandi tidak cocok)',
      position: "topRight",
    });
  </script>
<?php
  $this->session->unset_userdata('sess_token');
  $this->session->unset_userdata('sess_token_valid');
  $this->session->unset_userdata('sess_keluarga');
  $this->session->unset_userdata('sess_nama_user');
  $this->session->unset_userdata('sess_id_user');
  $this->session->unset_userdata('sess_num_login');
}
?>