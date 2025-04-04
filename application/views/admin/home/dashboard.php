  <?php
$this->load->view('layout/header');
?>
<div class="right_col" role="main">
  <div class="row tile_count">
    <h4><i class="fa fa-users"></i> Jumlah Keluarga per-Wilayah</h4>
    <?php
      foreach ($wilayah as $keywilayah => $valuewilayah) {
        # code...
        if(isset($perwilayah[$valuewilayah->wilayah])){
          $numKK=$perwilayah[$valuewilayah->wilayah]->NUM_keluarga;
          $numJiwa=$perwilayah[$valuewilayah->wilayah]->NUM_jiwa;
        }
        else{
          $numKK=0; 
          $numJiwa=0;
        }
    ?>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
          <span class="count_top"> Wilayah <?=$valuewilayah->wilayah;?></span>
          <div class="count">
            <?=$numKK;?> KK
          </div>
          <span class="count_bottom"><i class="green"><?=$numJiwa;?></i> Jiwa</span>
        </div>
    <?php
      }
    ?>
    
  </div>
  <div class="row">
    <div class="col-sm-6 col-xs-12">
      <div class="x_panel tile fixed_height_320" style="overflow-y: auto; height: 500px;">
        <div class="x_title">
          <h2>Input Terakhir</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="dashboard-widget-content">
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-xs-6">
                <h5 class="text-center" style="padding: unset; margin: unset;">KK</h5>
                <canvas id="chart_gauge_01" style="width:100%; "></canvas>
                <div class="goal-wrapper">
                  <span id="gauge-text" class="gauge-value pull-left" sumKKOld='<?=$sumKKOld;?>' sumKK='<?=$sumKK;?>' sumjiwa='<?=$sumjiwa;?>' sumjiwaOld='<?=$sumjiwaOld;?>'>0</span>
                  <span class="gauge-value pull-left"></span>
                  <span id="goal-text" class="goal-value pull-right"><?=$sumKKOld;?></span>
                </div>
              </div>

              <div class="col-xs-6">
                <h5 class="text-center" style="padding: unset;  margin: unset;">Anggota Keluarga</h5>
                <canvas id="chart_gauge_02" style="width:100%; "></canvas>
                <div class="goal-wrapper">
                  <span id="gauge-text2" class="gauge-value pull-left" sumKKOld='<?=$sumKKOld;?>' sumKK='<?=$sumKK;?>' sumjiwa='<?=$sumjiwa;?>' sumjiwaOld='<?=$sumjiwaOld;?>'>0</span>
                  <span class="gauge-value pull-left"></span>
                  <span id="goal-text2" class="goal-value pull-right"><?=$sumjiwaOld;?></span>
                </div>
              </div>
            </div>

            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>
                    #
                  </th>
                  <th>
                    Keluarga
                  </th>
                  <th>
                    Admin
                  </th>
                  <th>
                    Waktu
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach($lastinput as $keylastinput => $valuelastinput){
                ?>
                    <tr>
                      <td>
                        <?=$keylastinput+1;?>
                      </td>
                      <td>
                        <?=$valuelastinput->kwg_nama;?>
                      </td>
                      <td>
                        <?=$valuelastinput->name;?>
                      </td>
                      <td>
                        <?=$valuelastinput->created_at;?>
                      </td>
                    </tr>
                <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile " style="overflow-y: auto; height: 500px;">
        <div class="x_title">
          <h2>Anggota Jemaat yang Berulang Tahun</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="dashboard-widget-content">
            <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" aria-expanded="true" >Minggu Ini</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Minggu Depan</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
              <span>Minggu ini (<?=$date_name_from;?> s/d <?=$date_name_to;?>)</span>
              <div class="clearfix"></div>
              <ul class="list-unstyled timeline">
                <?php 
                foreach ($ls_date as $key => $value) {
                  # code...
                  $today="";

                  if($value->tgl_ulang_tahun  == date('d M') ){
                    $today='<span class="label label-danger">Hari ini</span>';
                  }
                ?>
                  <li>
                    <div class="block">
                      <div class="tags">
                        <a href="" class="tag">
                          <span><?=$key;?></span>
                        </a>
                        <?=$today;?>
                      </div>
                      <div class="block_content">
                        <?php 
                        foreach ($ls_hbd[$key] as $keyls_hbd => $valuels_hbd) {
                          # code...
                          $title="Ibu ";
                          if($valuels_hbd->sts_kawin==1){
                            $title="Sdri. ";
                          }
                          if(mb_strtolower($valuels_hbd->jns_kelamin)=='l'){
                            $color_gender="bg-gradient-blue";
                            $ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';
                            $title="Bp. ";
                            if($valuels_hbd->sts_kawin==1){
                              $title="Sdr. ";
                            }
                          }
                          $umur=getUmur($valuels_hbd->year.'-'.$valuels_hbd->date_lahir, $valuels_hbd->tgl_lahir);
                        ?>
                          <span class="excerpt">
                            <?= $title.$valuels_hbd->nama_lengkap;?>
                            <div class="byline" style="padding-top: unset; padding-bottom: 0.75em;">
                              <span>Umur <b><?=$umur;?> tahun</b></span> | Wilayah <?= $valuels_hbd->kwg_wil;?>
                            </div>
                          </span>
                          <div class="clearfix"></div>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </li>
                <?php
                }
                ?>
                </ul>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <span>Minggu ini (<?=$date_name_from1;?> s/d <?=$date_name_to1;?>)</span>
                <ul class="list-unstyled timeline">
                <?php 
                foreach ($ls_date1 as $key => $value) {
                  # code...
                  $today="";

                  if($value->tgl_ulang_tahun  == date('d M') ){
                    $today='<span class="label label-danger">Hari ini</span>';
                  }
                ?>
                  <li>
                    <div class="block">
                      <div class="tags">
                        <a href="" class="tag">
                          <span><?=$key;?></span>
                        </a>
                        <?=$today;?>
                      </div>
                      <div class="block_content">
                        <?php 
                        foreach ($ls_hbd1[$key] as $keyls_hbd => $valuels_hbd) {
                          # code...
                          $title="Ibu ";
                          if($valuels_hbd->sts_kawin==1){
                            $title="Sdri. ";
                          }
                          if(mb_strtolower($valuels_hbd->jns_kelamin)=='l'){
                            $color_gender="bg-gradient-blue";
                            $ico_gender='<i class="fa fa-male" style="font-size:12pt;"></i>';
                            $title="Bp. ";
                            if($valuels_hbd->sts_kawin==1){
                              $title="Sdr. ";
                            }
                          }
                          $umur=getUmur($valuels_hbd->year.'-'.$valuels_hbd->date_lahir, $valuels_hbd->tgl_lahir);
                        ?>
                          <span class="excerpt">
                            <?= $title.$valuels_hbd->nama_lengkap;?>
                            <div class="byline" style="padding-top: unset; padding-bottom: 0.75em;">
                              <span>Umur <b><?=$umur;?> tahun</b></span> | Wilayah <?= $valuels_hbd->kwg_wil;?>
                            </div>
                          </span>
                          <div class="clearfix"></div>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </li>
                <?php
                }
                ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Pertumbuhan Anggota Jemaat<small> Tahun <?=date('Y');?></small></h2>
            <div id="btn_detail_get_pertumbuhanJemaat" url="<?=base_url();?>ajax/detail_get_pertumbuhanJemaat/<?=date('Y');?>" class="btn btn-warning pull-right" onclick="event.preventDefault();" data-toggle="modal" data-target="#myModal">Detail</div>
            <!--<div class="col-xs-4" style="float: right;">
              <select id="ls_tahun_pertumbuhanAngJem" name="ls_tahun_pertumbuhanAngJem" class="form-control">
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021" selected>2021</option>
              </select>
            </div>-->
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="position: relative;">
            <div id="loading_grap1" class="row">
              <div class="col s12 center" style="position: absolute; background:rgba(0, 0, 0, 0.4); z-index:9999; width:100%; height:100%; left:0; top:0; text-align:center; color: #fff;">
                <i class="fa fa-circle-o-notch fa-spin fa-2x" style="margin-top:10%; " aria-hidden="true" ></i><br>
                Memuat Data ...
              </div>
            </div>
            <canvas id="lineChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Pertumbuhan Anggota Jemaat<small> 5 Tahun Terakhir</small></h2>
            <!--<div class="col-xs-4" style="float: right;">
              <select id="ls_tahun_pertumbuhanAngJem" name="ls_tahun_pertumbuhanAngJem" class="form-control">
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021" selected>2021</option>
              </select>
            </div>-->
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="position: relative;">
            <div id="loading_grap2" class="row">
              <div class="col s12 center" style="position: absolute; background:rgba(0, 0, 0, 0.4); z-index:9999; width:100%; height:100%; left:0; top:0; text-align:center; color: #fff;">
                <i class="fa fa-circle-o-notch fa-spin fa-2x" style="margin-top:10%; " aria-hidden="true" ></i><br>
                Memuat Data ...
              </div>
            </div>
            <canvas id="lineChart_pertahun"></canvas>
          </div>
        </div>
      </div>

    </div>


    <div class="row top_tiles">
      <div class="col-md-4 col-sm-4 ">
        <div class="x_panel tile fixed_height_320 overflow_hidden">
          <div class="x_title">
            <h2>Iuran Bulanan KPKP</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Settings 1</a>
                    <a class="dropdown-item" href="#">Settings 2</a>
                  </div>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table class="" style="width:100%">
              <tr>
                <th style="width:37%;">
                  <p></p>
                </th>
                <th>
                  <div class="col-lg-7 col-md-7 col-sm-7 ">
                    <p class="">Data Tunggakan</p>
                  </div>
                  <div class="col-lg-5 col-md-5 col-sm-5 ">
                    <p class="">Persentasi</p>
                  </div>
                </th>
              </tr>
              <tr>
                <td>
                  <canvas class="canvasIuranBulanan" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                </td>
                <td>
                  <table class="tile_info">
                    <tr>
                      <td>
                        <p><i class="fa fa-square blue"></i><= 3 Bulan </p>
                      </td>
                      <td>3%</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square green"></i><= 3 Bulan </p>
                      </td>
                      <td>40%</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square purple"></i>> 1 Tahun </p>
                      </td>
                      <td>20%</td>
                    </tr>
                    <tr>
                      <td>
                        <p><i class="fa fa-square aero"></i>> 3 Tahun </p>
                      </td>
                      <td>15%</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="col-xs-12">
        <h3>Data Tunggakan Iuran Bulanan KPKP</h3>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon" ><i class="fa fa-caret-square-o-right"></i></div>
          <div class="count"><?=$kpkpbulan3;?> KK</div>
          <h3> <= 3 Bulan</h3>
          <span title="Tunggakan kurang dari sama dengan 3 Bulan" id="detail_tunggakan" class="count_bottom pull-right" style="margin-right: 17px; cursor: pointer;" ls_kk="<?= implode(',', $kpkpbulan3_ls);?>"><i class="green">selengkapnya</i></span>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
          <div class="count"><?=$kpkpbulan6;?> KK</div>
          <h3> <= 12 Bulan</h3>
          <p title="Tunggakan kurang dari 12 Bulan" id="detail_tunggakan" class="count_bottom pull-right" style="margin-right: 17px;  cursor: pointer;" ls_kk="<?= implode(',', $kpkpbulan6_ls);?>"><i class="green">selengkapnya</i> </p>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
          <div class="count"><?=$kpkpbulan12;?> KK</div>
          <h3>>1 Tahun</h3>
          <p title="Tunggakan lebih  dari sama dengan 12 Bulan" id="detail_tunggakan" class="count_bottom pull-right" style="margin-right: 17px;  cursor: pointer;" ls_kk="<?= implode(',', $kpkpbulan12_ls);?>"><i class="green">selengkapnya</i> </p>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
          <div class="count"><?=$kpkpbulan36;?> KK</div>
          <h3>>3 Tahun</h3>
          <p title="Tunggakan lebih dari sama dengan 36 Bulan" id="detail_tunggakan" class="count_bottom pull-right" style="margin-right: 17px;  cursor: pointer;" ls_kk="<?= implode(',', $kpkpbulan36_ls);?>"><i class="green">selengkapnya</i> </p>
          <p></p>
        </div>
      </div>
    </div>

    <div class="row top_tiles">
      <div class="col-xs-12">
        <h3>Data Tunggakan Iuran Perawatan Makam</h3>
      </div>      
      <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
      <span class="sr-only">Loading...</span><br><br><br>
    </div>

  </div>

</div>
<?php
$this->load->view('layout/footer');
?>
<?php
  if($this->session->userdata('status_login')=='success'){
    $this->session->unset_userdata('status_login');
?>
    <script type="text/javascript">
        iziToast.info({
            title: '',
            message: 'Login Berhasil, Hallo <b><?=$this->session->userdata('userdata')->name;?></b>!',
            position: "topRight",
        });
    </script>
<?php
  }
  ?>
  <script type="text/javascript">
    $(document).ready(function(){
      get_pertumbuhanJemaat();
      get_pertumbuhanJemaat_perTahun();
      init_chart_iuranBulanan();
    })

    $(document).on('click', '[id=btn_detail_get_pertumbuhanJemaat]', function(e){
      e.preventDefault();
      url=$(this).attr('url')
      dataMap={}
      $.post(url, dataMap, function(data){
        $('#modal-content').html(data)
      })
    })

    $(document).on('click', '[id=detail_tunggakan]', function(e){
      e.preventDefault();
      url='<?=base_url();?>ajax/detail_keluarga_kpkp'
      $('#myModal').modal('show')
      dataMap={}
      dataMap['ls_kk_id']=$(this).attr('ls_kk')
      dataMap['title']=$(this).attr('title')
      $.post(url, dataMap, function(data){
        $('#modal-content').html(data)
      })
    })

    function init_chart_iuranBulanan(){
        
      if( typeof (Chart) === 'undefined'){ return; }
      
      console.log('init_chart_iuranBulanan');
     
      if ($('.canvasIuranBulanan').length){
        
      var chart_doughnut_settings = {
          type: 'doughnut',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: {
            labels: [
              "<= 3 Bulan",
              "<= 12 Bulan",
              "> 1 Tahun",
              "> 3 Tahun"
            ],
            datasets: [{
              data: [15, 20, 30, 10],
              backgroundColor: [
                "#BDC3C7",
                "#9B59B6",
                "#E74C3C",
                "#3498DB"
              ],
              hoverBackgroundColor: [
                "#CFD4D8",
                "#B370CF",
                "#E95E4F",
                "#49A9EA"
              ]
            }]
          },
          options: { 
            legend: false, 
            responsive: false 
          }
        }
      
        $('.canvasIuranBulanan').each(function(){
          
          var chart_element = $(this);
          var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
          
        });     
      
      }  
       
    }
  </script>