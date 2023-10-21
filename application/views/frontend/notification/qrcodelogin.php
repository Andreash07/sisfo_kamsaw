<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistem Informasi Jemaat - GKP Kampung Sawah. Sistem ini berfungsi membantu dalam perawatan, manajemen dan pembaruan data anggota jemaat GKP Kampung Sawah.">
  <meta name="author" content="#Ash07 - Creative Media">
  <title>Sistem Informasi Jemaat - GKP Kampung Sawah</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Architects+Daughter" />
  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/clear-sans/stylesheet.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/font-hack/2.019/css/hack.min.css" />
  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/css/examples.css" />
  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/css/jquery.sweet-modal.min.css" />

  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js" async></script>
  <script src="<?=base_url();?>assets/frontend/vendor/sweetmodal/js/jquery.min.js"></script>
  <script src="<?=base_url();?>assets/frontend/vendor/sweetmodal/js/jquery.sweet-modal.min.js"></script>
</head>
<body>
  <?php
  if($this->session->userdata('sess_token_valid')==1){
  ?>
    <script type="text/javascript">
      $.sweetModal({
        content: 'QRCode dikenali dan valid.<br><b>Login Anda Berhasil!</b>',
        icon: $.sweetModal.ICON_SUCCESS
      });
      setTimeout(function(){
        window.location.href = "<?=base_url();?>beranda";
      }, 1500);
    </script>
  <?php
  }
  else{
  ?>
    <script type="text/javascript">
      $.sweetModal({
        content: 'Ooppss... Maaf, QRCode tidak dikenali.<br><b>Login Anda Gagal!</b>',
        icon: $.sweetModal.ICON_ERROR
      });
    </script>
  <?php
  }
  ?>
</body>
</html>