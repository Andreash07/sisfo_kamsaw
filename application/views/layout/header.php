<!DOCTYPE html>

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>GKP KamSaw</title>



    <!-- Bootstrap -->

    <link href="<?=base_url();?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="<?=base_url();?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- NProgress -->

    <link href="<?=base_url();?>/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- iCheck -->

    <link href="<?=base_url();?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

	

    <!-- bootstrap-progressbar -->

    <link href="<?=base_url();?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- JQVMap -->

    <link href="<?=base_url();?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- bootstrap-daterangepicker -->

    <!--<link href="<?=base_url();?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">-->



    <!-- bootstrap-datepicker -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" rel="stylesheet">





    <!-- Custom Theme Style -->

    <link href="<?=base_url();?>/build/css/custom.min.css" rel="stylesheet">



    <!-- jQuery -->

    <script src="<?=base_url();?>/vendors/jquery/dist/jquery.min.js"></script>

    <!-- izy Toastt-->

    <script src="<?= base_url('assets/iziToast-master/dist/js/iziToast.js'); ?>"></script>

    <link href="<?= base_url('assets/iziToast-master/dist/css/iziToast.min.css'); ?>" rel="stylesheet">



    <!-- NProgress -->

    <link href="<?=base_url();?>vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Dropzone.js -->

    <link href="<?=base_url();?>vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">



    <!-- Switchery -->

    <link href="<?=base_url();?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">





    <!-- fancybox.js-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>



  </head>

  <?php

    if($this->session->userdata('userdata') && $this->uri->segment(1) !='tools'){

      $this->load->view('layout/sidebar');

    }

    else{

?>

      <body class="login">

        <div class="container body">

<?php

    }

  ?>