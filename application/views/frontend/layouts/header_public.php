<!DOCTYPE html>

<html>



<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="color-scheme" content="light"> <!-- untuk paksa tidak ikut dark mode -->

  <meta name="description" content="Sistem Informasi Jemaat - GKP Kampung Sawah. Sistem ini berfungsi membantu dalam perawatan, manajemen dan pembaruan data anggota jemaat GKP Kampung Sawah.">

  <meta name="author" content="#Ash07 - Creative Media">

  <title>Hasil Pemilihan Penatua Tahap 1 - GKP Kampung Sawah</title>

  <!-- Favicon -->

  <link rel="icon" href="<?=base_url();?>assets/images/logo-gkp_compressed.png" type="image/png">

  <!-- Fonts -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

  <!-- Icons -->

  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/nucleo/css/nucleo.css" type="text/css">

  <!--<link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">-->

  <link rel="stylesheet" href="<?=base_url();?>assets/font-awesome-4.7.0/css/font-awesome.min.css">

  <!-- Page plugins -->

  <!-- Argon CSS -->

  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/css/argon.css?v=<?=microtime();?>" type="text/css">



  <!-- iziToast CSS -->

  <link href="<?= base_url('assets/iziToast-master/dist/css/iziToast.min.css'); ?>" rel="stylesheet">



  <!--<link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/css/examples.css" />-->

  <link rel="stylesheet" href="<?=base_url();?>assets/frontend/vendor/sweetmodal/css/jquery.sweet-modal.min.css" />

</head>

<body>

<?php

if($this->session->userdata('sess_keluarga')){ //ini ke load jika sudah login saja

  $this->load->view('frontend/layouts/sidebar.php');

}

?>

  <!-- Main content -->

  <!-- close DIV ini ada di footer.php               Point A -->

  <div class="main-content" id="panel">

<?php

if($this->session->userdata('sess_keluarga')){ //ini ke load jika sudah login saja

  $this->load->view('frontend/layouts/topbar.php');

}

?>