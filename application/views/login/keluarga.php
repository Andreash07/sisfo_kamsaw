<?php $this->load->view('frontend/layouts/header'); ?>
<style>
  .input-group {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      border-left:1px solid #8898aa;
      z-index: 9999;
    }
</style>
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
              <small>Ver. 1.0</small>
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
  <input type="hidden" value="<?=base_url();?>" name="url_response" id="url_response">
  <div class="container pt-5 pb-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">

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
                  <input class="form-control" placeholder="Kata Sandi" type="password" name="password" id="password" >
                  <span class="toggle-password" onclick="togglePassword()"><i id="ico_see" class="fa fa-eye" style="padding-left: 5px;"></i></span>
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

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/qrCodeScanner.css">
<!--<script src="https://unpkg.com/html5-qrcode"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/frontend/js/scanner-qrcode.js?v=<?= microtime();?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/frontend/js/qrCodeScanner.js?v=<?= microtime();?>"></script>
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

  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const toggle = document.querySelector(".toggle-password");
    
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggle.innerHTML = '<i id="ico_see" class="fa fa-eye-slash" style="padding-left: 5px;"></i>'; // Ganti ikon
    } else {
      passwordInput.type = "password";
      toggle.innerHTML = '<i id="ico_see" class="fa fa-eye" style="padding-left: 5px;"></i>';
    }
  }
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