<header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <?php if($favicon) {?>
                             <img src="../media/site/<?php echo $favicon; ?>" alt="homepage" class="dark-logo img-fluid" style="max-width:60px" />
                            <?php } ?>  
                            <!-- Light Logo icon -->
                            <?php if($favicon) {?>
                             <img src="../media/site/<?php echo $favicon; ?>" alt="homepage" class="light-logo img-fluid" style="max-width:60px" />
                            <?php } ?> 
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                       
                    </ul>
                </div>
            </nav>
        </header>