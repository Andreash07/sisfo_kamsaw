<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content" id="section_form_login">
          <form action="" name="form_login" method="POST">
            <h1>Login <br>SisFo GKP Kampung Sawah</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" name="Username" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" name="Password" required="" />
            </div>
            <div>
              <input type="submit" class="btn btn-default submit" name="btn_login" value="Log in">
              <!--<a class="reset_pass" href="#">Lupa <i>Password</i>?</a>-->
            </div>

            <div class="clearfix"></div>
          </form>
        </section>
      </div>
    </div>
</div>
<!-- /page content -->

<?php
$this->load->view('layout/footer');
?>

<?php
  if($this->session->userdata('status_login')=='failed'){
    $this->session->unset_userdata('status_login');
?>
    <script type="text/javascript">
        iziToast.error({
            title: '',
            message: 'Login gagal, silahkan ulangi lagi!',
            position: "topRight",
        });
    </script>
<?php
  }
?>