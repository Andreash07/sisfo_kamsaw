 <body class="nav-md">

  <div class="container body">

    <div class="main_container">

      <div class="col-md-3 left_col">

        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">

            <a href="<?=base_url();?>" class="site_title"><img src="<?=base_url();?>/assets/images/GKP PNG-35.png" alt="iamges" class="img-circle"> <span><small style="font-size:80%;">SisFo GKP KAMSAW</small></span></a>

          </div>



          <div class="clearfix"></div>



          <!-- menu profile quick info -->

          <div class="profile clearfix">

            <div class="profile_pic">

              <img src="<?=base_url();?>/assets/images/img.jpg" alt="iamges" class="img-circle profile_img">

            </div>

            <div class="profile_info">

              <span>Welcome,</span>

              <h2><?=$this->session->userdata('userdata')->name;?></h2>

            </div>

          </div>

          <!-- /menu profile quick info -->



          <br />



          <!-- sidebar menu -->

          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">

              <h3>General</h3>

              <ul class="nav side-menu">

                <!--<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="index.html">Dashboard</a></li>

                    <li><a href="index2.html">Dashboard2</a></li>

                    <li><a href="index3.html">Dashboard3</a></li>

                  </ul>

                </li>

                <li><a><i class="fa fa-archive"></i> Master <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="form.html">Data Profesi</a></li>

                    <li><a href="form_advanced.html">Data Hobi</a></li>

                  </ul>

                </li>-->
                <?php 
                //print_r($this->session->userdata()); die();
                if(!in_array($this->session->userdata('userdata')->id, array(22)) ){
                  if(!in_array($this->session->userdata('userdata')->id, array(23,24)) ){
                ?>
                <li><a><i class="fa fa-edit"></i> Admin <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li>

                      <a href="<?=base_url();?>admin/DataJemaat">

                        Data Jemaat

                        <span class="label label-primary pull-right">New</span>

                      </a>

                    </li>

                    <li>

                      <a href="<?=base_url();?>admin/DataJemaatOld">

                        Data Jemaat

                        <span class="label label-warning pull-right">Old</span>

                      </a>

                    </li>

                    <li>

                      <a href="<?=base_url();?>admin/livestreaming">
                        Live Streaming
                      </a>

                    </li>

                  </ul>

                </li>

                <li><a><i class="fa fa-file-text"></i> Report <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li>

                      <a href="<?=base_url();?>report/anggota_jemaat">

                        Anggota Jemaat

                      </a>

                    </li>

                    <li>

                      <a href="<?=base_url();?>report/anggota_jemaat/baptis_sidi">

                        Baptis-Sidi

                      </a>

                    </li>

                    <!--<li>

                      <a href="<?=base_url();?>report/anggota_jemaat/profesi">

                        Anggota Jemaat Profesi

                      </a>

                    </li>-->

                  </ul>

                </li>
                <li>
                  <a><i class="fa fa-envelope"></i> Persembahan <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li>
                      <a href="<?=base_url();?>persembahan/bulananjemaat">
                        Bulanan Jemaat
                      </a>
                    </li>
                    <li>
                      <a href="<?=base_url();?>persembahan/peribadah">
                        Per-Ibadah
                      </a>
                    </li>
                  </ul>
                </li>
                <?php 
                  }
                ?>

                <?php 
                  if(!in_array($this->session->userdata('userdata')->id, array(22)) ){
                ?>
                <li><a><i class="fa fa-clone"></i> KPKP <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li>

                      <a href="<?=base_url();?>pemakaman/anggota_jemaat">

                        Iuran Bulanan

                      </a>

                    </li>


                    <li>

                      <a href="<?=base_url();?>pemakaman/laporan_iuran_anggota">

                        Laporan Iuran Anggota

                      </a>

                    </li> 

                    <li>

                      <a href="<?=base_url();?>Data_Blok_Makam/" >

                        Data Blok Makam

                      </a>

                    </li>
                    <li>

                      <a href="<?=base_url();?>pemakaman/data_makam">

                        Data Makam

                      </a>

                    </li>
                    <!--<li>

                      <a href="<?=base_url();?>report/anggota_jemaat/profesi">

                        Anggota Jemaat Profesi

                      </a>

                    </li>-->

                  </ul>

                </li>
                <?php 
                }
                ?>
                 <?php 
                  if(!in_array($this->session->userdata('userdata')->id, array(23,24)) ){
                ?>

                <li><a><i class="fa fa-bar-chart-o"></i> Chart Ibadah<span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li>

                      <a href="<?=base_url();?>kebaktian/kebaktian_gereja">

                        Data Ibadah

                      </a>

                    </li>
                    <?php 
                }
                ?>

                    <!-- <li>

                      <a href="<?=base_url();?>report/anggota_jemaat/baptis_sidi">

                        Baptis-Sidi

                      </a>

                    </li> -->

                    <!--<li>

                      <a href="<?=base_url();?>report/anggota_jemaat/profesi">

                        Anggota Jemaat Profesi

                      </a>

                    </li>-->

                  </ul>

                </li>

                <?php
                }
                ?>

                <?php 
                //print_r($this->session->userdata()); die();
                if(in_array($this->session->userdata('userdata')->id, array(22, 10, 16)) ){
                ?>

                <li><a><i class="fa fa-file-text"></i> Pemilihan PN & PPJ <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li>

                      <a href="<?=base_url();?>pemilu/setting">Pengaturan Pemilihan</span></a>

                    </li>
                    <li>

                      <a href="<?=base_url();?>pnppj/list_peserta_pemilhan">Daftar Peserta Pemilihan</span></a>

                    </li>

                    <li>

                      <a>Tahap 1<span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">

                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/list_calon_penatua">

                            Bakal Calon PN

                          </a>

                        </li>
                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/statistik_pnt1">

                            Statistik

                          </a>

                        </li>

                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/pemilu1">

                            Perolehan Suara PN

                          </a>

                        </li>
                        <li class="sub_menu">
                          <a href="<?=base_url();?>pnppj/polling_surat_suara_pnt1">Pemungutan Surat Suara</span></a>
                        </li>

                      </ul>

                    </li>

                    <li>

                      <a>Tahap 2<span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">

                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/list_calon_penatua2">

                            Calon PN

                          </a>

                        </li>
                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/statistik_pnt2">

                            Statistik

                          </a>

                        </li>

                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/pemilu2">

                            Perolehan Suara

                          </a>

                        </li>

                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/pemilu2_per_wil">

                            Perolehan Suara per Wilayah

                          </a>

                        </li>
                        <li class="sub_menu">
                          <a href="<?=base_url();?>pnppj/polling_surat_suara_pnt2">Pemungutan Surat Suara</span></a>
                        </li>

                      </ul>

                    </li>

                    <li>

                      <a>PPJ<span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">

                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/statistik_ppj">

                            Statistik

                          </a>

                        </li>
                        <li class="sub_menu">

                          <a href="<?=base_url();?>pnppj/pemilu_ppj">

                            Perolehan Suara

                          </a>

                        </li>
                        <li class="sub_menu">
                          <a href="<?=base_url();?>pnppj/polling_surat_suara_ppj">Pemungutan Surat Suara</span></a>
                        </li>

                      </ul>

                    </li>

                  </ul>

                </li>
              <?php
              }
              ?>

			  <!--<li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="form.html">General Form</a></li>

                    <li><a href="form_advanced.html">Advanced Components</a></li>

                    <li><a href="form_validation.html">Form Validation</a></li>

                    <li><a href="form_wizards.html">Form Wizard</a></li>

                    <li><a href="form_upload.html">Form Upload</a></li>

                    <li><a href="form_buttons.html">Form Buttons</a></li>

                  </ul>

                </li>-->

                <!--<li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="general_elements.html">General Elements</a></li>

                    <li><a href="media_gallery.html">Media Gallery</a></li>

                    <li><a href="typography.html">Typography</a></li>

                    <li><a href="icons.html">Icons</a></li>

                    <li><a href="glyphicons.html">Glyphicons</a></li>

                    <li><a href="widgets.html">Widgets</a></li>

                    <li><a href="invoice.html">Invoice</a></li>

                    <li><a href="inbox.html">Inbox</a></li>

                    <li><a href="calendar.html">Calendar</a></li>

                  </ul>

                </li>

                <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="tables.html">Tables</a></li>

                    <li><a href="tables_dynamic.html">Table Dynamic</a></li>

                  </ul>

                </li>

                <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="chartjs.html">Chart JS</a></li>

                    <li><a href="chartjs2.html">Chart JS2</a></li>

                    <li><a href="morisjs.html">Moris JS</a></li>

                    <li><a href="echarts.html">ECharts</a></li>

                    <li><a href="other_charts.html">Other Charts</a></li>

                  </ul>

                </li>

                <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>

                    <li><a href="fixed_footer.html">Fixed Footer</a></li>

                  </ul>

                </li>

              </ul>

            </div>

            <div class="menu_section">

              <h3>Live On</h3>

              <ul class="nav side-menu">

                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="e_commerce.html">E-commerce</a></li>

                    <li><a href="projects.html">Projects</a></li>

                    <li><a href="project_detail.html">Project Detail</a></li>

                    <li><a href="contacts.html">Contacts</a></li>

                    <li><a href="profile.html">Profile</a></li>

                  </ul>

                </li>

                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                    <li><a href="page_403.html">403 Error</a></li>

                    <li><a href="page_404.html">404 Error</a></li>

                    <li><a href="page_500.html">500 Error</a></li>

                    <li><a href="plain_page.html">Plain Page</a></li>

                    <li><a href="login.html">Login Page</a></li>

                    <li><a href="pricing_tables.html">Pricing Tables</a></li>

                  </ul>

                </li>

                <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>

                  <ul class="nav child_menu">

                      <li><a href="#level1_1">Level One</a>

                      <li><a>Level One<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">

                          <li class="sub_menu"><a href="level2.html">Level Two</a>

                          </li>

                          <li><a href="#level2_1">Level Two</a>

                          </li>

                          <li><a href="#level2_2">Level Two</a>

                          </li>

                        </ul>

                      </li>

                      <li><a href="#level1_2">Level One</a>

                      </li>

                  </ul>

                </li>

                <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>-->

              </ul>

            </div>



          </div>

          <!-- /sidebar menu -->



          <!-- /menu footer buttons -->

          <div class="sidebar-footer hidden-small">

            <a data-toggle="tooltip" data-placement="top" title="Settings">

              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>

            </a>

            <a data-toggle="tooltip" data-placement="top" title="FullScreen">

              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>

            </a>

            <a data-toggle="tooltip" data-placement="top" title="Lock">

              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>

            </a>

            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url().'logout';?>">

              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>

            </a>

          </div>

          <!-- /menu footer buttons -->

        </div>

      </div>



      <!-- top navigation -->

      <div class="top_nav">

        <div class="nav_menu">

          <nav>

            <div class="nav toggle">

              <a id="menu_toggle"><i class="fa fa-bars"></i></a>

            </div>



            <ul class="nav navbar-nav navbar-right">

              <li class="">

                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                  <img src="<?=base_url();?>/assets/images/img.jpg" alt=""><?=$this->session->userdata('userdata')->name;?>

                  <span class=" fa fa-angle-down"></span>

                </a>

                <ul class="dropdown-menu dropdown-usermenu pull-right">

                  <!--<li><a href="javascript:;"> Profile</a></li>

                  <li>

                    <a href="javascript:;">

                      <span class="badge bg-red pull-right">50%</span>

                      <span>Settings</span>

                    </a>

                  </li>

                  <li><a href="javascript:;">Help</a></li>-->

                  <li><a href="<?=base_url().'logout';?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>

                </ul>

              </li>



              <li role="presentation" class="dropdown">

                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                  <i class="fa fa-envelope-o"></i>

                  <span class="badge bg-green">6</span>

                </a>

                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

                  <li>

                    <a>

                      <span class="image"><img src="<?=base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>

                      <span>

                        <span>John Smith</span>

                        <span class="time">3 mins ago</span>

                      </span>

                      <span class="message">

                        Film festivals used to be do-or-die moments for movie makers. They were where<?=base_url();?>.

                      </span>

                    </a>

                  </li>

                  <li>

                    <a>

                      <span class="image"><img src="<?=base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>

                      <span>

                        <span>John Smith</span>

                        <span class="time">3 mins ago</span>

                      </span>

                      <span class="message">

                        Film festivals used to be do-or-die moments for movie makers. They were where...

                      </span>

                    </a>

                  </li>

                  <li>

                    <a>

                      <span class="image"><img src="<?=base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>

                      <span>

                        <span>John Smith</span>

                        <span class="time">3 mins ago</span>

                      </span>

                      <span class="message">

                        Film festivals used to be do-or-die moments for movie makers. They were where...

                      </span>

                    </a>

                  </li>

                  <li>

                    <a>

                      <span class="image"><img src="<?=base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>

                      <span>

                        <span>John Smith</span>

                        <span class="time">3 mins ago</span>

                      </span>

                      <span class="message">

                        Film festivals used to be do-or-die moments for movie makers. They were where...

                      </span>

                    </a>

                  </li>

                  <li>

                    <div class="text-center">

                      <a>

                        <strong>See All Alerts</strong>

                        <i class="fa fa-angle-right"></i>

                      </a>

                    </div>

                  </li>

                </ul>

              </li>

            </ul>

          </nav>

        </div>

      </div>

      <!-- /top navigation -->