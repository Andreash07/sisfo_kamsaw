<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Search form -->
      <!--<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
        <div class="form-group mb-0">
          <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" placeholder="Search" type="text">
          </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </form>-->
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center  "> <!--ml-md-auto-->
        <li class="nav-item dropdown">
          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="<?=base_url();?>assets/images/icon_family-white-01_compressed.jpg">
              </span>
              <div class="media-body  ml-2  d-none d-lg-block">
                <span class="mb-0 text-sm  font-weight-bold"><?=ucfirst($this->session->userdata('sess_keluarga')->kwg_nama);?></span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu  dropdown-menu-right " style="left: unset;">
            <div class="dropdown-header noti-title">
              <h6 class="text-overflow m-0">Selamat Datang!</h6>
            </div>
            <a href="<?=base_url();?>beranda" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My Family</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Pengaturan</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Aktifitas</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Bantuan</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?=base_url();?>logout/keluarga" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Keluar</span>
            </a>
          </div>
        </li>
      </ul>

      <ul class="navbar-nav align-items-center ml-auto">
        <!--<li class="nav-item d-sm-none">
          <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
            <i class="ni ni-zoom-split-in"></i>
          </a>
        </li>-->
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
            <!-- Dropdown header -->
            <div class="px-3 py-3">
              <!--<h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>-->
            </div>
            <!-- List group -->
            <div class="list-group list-group-flush">
              <?php 
              if($this->session->userdata('sess_num_login')<10){
              ?>
              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="<?=base_url();?>assets/frontend/img/theme/team-1.jpg" class="avatar rounded-circle">
                  </div>
                  <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">Selamat Datang</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small><?=convert_time_NdMYHis(date('Y-m-d H:i:s'));?></small>
                      </div>
                    </div>
                    <p class="text-sm mb-0">Halo, Keluarga <b>Bpk/Ibu <?= $this->session->userdata('sess_nama_user');?></b> Anda berhasil login di SisFo GKP Kampung Sawah. Tuhan Yesus memberkati Anda dan Keluarga Anda selalu.</p>
                  </div>
                </div>
              </a>
              <?php
              }
              ?>
              <?php
              /*
              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="<?=base_url();?>assets/frontend/img/theme/team-1.jpg" class="avatar rounded-circle">
                  </div>
                  <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">John Snow</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small>2 hrs ago</small>
                      </div>
                    </div>
                    <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                  </div>
                </div>
              </a>
              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="<?=base_url();?>assets/frontend/img/theme/team-2.jpg" class="avatar rounded-circle">
                  </div>
                  <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">John Snow</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small>3 hrs ago</small>
                      </div>
                    </div>
                    <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                  </div>
                </div>
              </a>
              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="<?=base_url();?>assets/frontend/img/theme/team-3.jpg" class="avatar rounded-circle">
                  </div>
                  <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">John Snow</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small>5 hrs ago</small>
                      </div>
                    </div>
                    <p class="text-sm mb-0">Your posts have been liked a lot.</p>
                  </div>
                </div>
              </a>
              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="<?=base_url();?>assets/frontend/img/theme/team-4.jpg" class="avatar rounded-circle">
                  </div>
                  <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">John Snow</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small>2 hrs ago</small>
                      </div>
                    </div>
                    <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                  </div>
                </div>
              </a>
              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="<?=base_url();?>assets/frontend/img/theme/team-5.jpg" class="avatar rounded-circle">
                  </div>
                  <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">John Snow</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small>3 hrs ago</small>
                      </div>
                    </div>
                    <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                  </div>
                </div>
              </a>
            </div>
            <!-- View all -->
            <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
            */
            ?>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-ungroup"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">
            <div class="row shortcuts px-4">
              <!--<a href="#!" class="col-4 shortcut-item text-center">
                <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                  <i class="ni ni-calendar-grid-58"></i>
                </span>
                <small style="display: block;">Calendar</small>
              </a>
              <a href="#!" class="col-4 shortcut-item text-center">
                <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                  <i class="ni ni-email-83"></i>
                </span>
                <small style="display: block;">Email</small>
              </a>-->
              <a href="<?= base_url();?>pnppj" class="col-4 shortcut-item text-center">
                <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                  <i class="ni ni-bullet-list-67"></i>
                </span>
                <small style="display: block;"><b>Pnt - PPJ</b><br>2026-2030</small>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item d-xl-none">
          <!-- Sidenav toggler -->
          <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Header -->