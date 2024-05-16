<aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                              <div class="pull-left image">
                                        <img src="<?php echo base_url(); ?>assets/img/<?php echo $userdata->foto; ?>"
                                                  class="img-circle" alt="User Image">
                              </div>
                              <div class="pull-left info">
                                        <p><?php echo $userdata->nama; ?></p>
                                        <!-- Status -->
                                        <a href="<?php echo base_url(); ?>assets/#"><i
                                                            class="fa fa-circle text-success"></i> Online</a>
                              </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                              <li class="header">LIST MENU</li>
                              <!-- Optionally, you can add icons to the links -->

                              <li <?php if ($page == 'home') {
                         echo 'class="active"';
                    } ?>>
                                        <a href="<?php echo base_url('Home'); ?>">
                                                  <i class="fa fa-home"></i>
                                                  <b>Home</b>
                                        </a>
                              </li>

                              <li <?php if ($page == 'report') {
                         echo 'class="active"';
                    } ?>>
                                        <a href="<?php echo base_url('Report'); ?>">
                                                  <i class="fa fa-server"></i>
                                                  <span>Data Edc Bca Online</span>
                                        </a>
                              </li>

                              <li <?php if ($page == 'report') {
                         echo 'class="active"';
                    } ?>>
                                        <a href="<?php echo base_url(); ?>">
                                                  <i class="fa fa-server"></i>
                                                  <span>Comming Soon</span>
                                        </a>
                              </li>




                    </ul>
                    <!-- /.sidebar-menu -->
          </section>
          <!-- /.sidebar -->
</aside>