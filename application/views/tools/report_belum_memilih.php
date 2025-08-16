<?php
$this->load->view('layout/header');
?>
<body class="login">
  <br>
  <div class="container-fluid">
    <a id="btn_menu" class="btn btn-primary" inurl="<?=base_url();?>tools/report_belum_memilih_ppj" auth="<?=$token;?>">PPJ</a>
    <a id="btn_menu" class="btn btn-warning" inurl="<?=base_url();?>tools/report_belum_memilih_pnt1" auth="<?=$token;?>" >PNT Tahap1</a>
    <a id="btn_menu" class="btn btn-success" inurl="<?=base_url();?>tools/report_belum_memilih_pnt2" auth="<?=$token;?>">PNT Tahap2</a>
    <div class="row" id="div_report">
    </div>
  </div>
</body>

<script type="text/javascript">
  $(document).on('click touchstart', "[id=btn_menu]", function(e){
    e.preventDefault()
    url=$(this).attr('inurl')
    dataMap={}
    dataMap['token']=$(this).attr('auth');
    $.post(url, dataMap, function(data){
      $('#div_report').html(data)
    })
  })
</script>