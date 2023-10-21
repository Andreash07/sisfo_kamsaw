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
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="x_panel tile fixed_height_320">
        <div class="x_title">
          <h2>Progress Input Sensus - KK</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="dashboard-widget-content">
            <!--<ul class="quick-list">
              <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
              </li>
              <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
              </li>
              <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
              <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
              </li>
              <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
              <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
              </li>
              <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
              </li>
            </ul>-->
            <div >
                <!--style="width: 160px; height: 100px;"-->
                <canvas id="chart_gauge_01" style="width:100%; "></canvas>
                <div class="goal-wrapper">
                  <span id="gauge-text" class="gauge-value pull-left" sumKKOld='<?=$sumKKOld;?>' sumKK='<?=$sumKK;?>' sumjiwa='<?=$sumjiwa;?>' sumjiwaOld='<?=$sumjiwaOld;?>'>0</span>
                  <span class="gauge-value pull-left"></span>
                  <span id="goal-text" class="goal-value pull-right"><?=$sumKKOld;?></span>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="x_panel tile fixed_height_320">
        <div class="x_title">
          <h2>Progress Input Sensus - Anngota</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="dashboard-widget-content">
            <!--<ul class="quick-list">
              <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
              </li>
              <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
              </li>
              <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
              <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
              </li>
              <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
              <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
              </li>
              <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
              </li>
            </ul>-->
            <div >
                <!--style="width: 160px; height: 100px;"-->
                <canvas id="chart_gauge_02" style="width:100%; "></canvas>
                <div class="goal-wrapper">
                  <span id="gauge-text2" class="gauge-value pull-left" sumKKOld='<?=$sumKKOld;?>' sumKK='<?=$sumKK;?>' sumjiwa='<?=$sumjiwa;?>' sumjiwaOld='<?=$sumjiwaOld;?>'>0</span>
                  <span class="gauge-value pull-left"></span>
                  <span id="goal-text2" class="goal-value pull-right"><?=$sumjiwaOld;?></span>
                </div>
            </div>
          </div>
        </div>
      </div>
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