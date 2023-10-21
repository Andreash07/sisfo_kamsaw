<?php 
$this->load->view('frontend/layouts/header');
?>
	<!-- Main content -->
<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
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
    <!-- Page content -->
    <div class="container mt--9 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Masuk dengan ID Pengguna</small>
              </div>
              <form role="form" method="POST" action="<?=base_url();?>login/auth_user_keluarga">
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
                <!--<div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div>-->
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Masuk</button>
                </div>
              </form>
            </div>
          </div>
          <!--<div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="#" class="text-light"><small>Create new account</small></a>
            </div>
          </div>-->
        </div>
      </div>
    </div>
</div>

<?php 
$this->load->view('frontend/layouts/footer');
?>

<?php 
if($this->session->userdata('sess_token_valid') ==-1 ){
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