<!DOCTYPE html>
<html>
    <head>
        <title>EyesFood | <?php echo $title;?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url();?>script/classes/templates/bootstrap/css/bootstrap.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url();?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="<?php echo base_url();?>dist/css/skins/skin-green.min.css">      
    </head>
    
    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url();?>Usuarios" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>E</b>F</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Eyes</b>Food</span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                  <!-- Sidebar toggle button-->
                  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                  </a>
                  <!-- Navbar Right Menu -->
                  <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                      <!-- Control Sidebar Toggle Button -->
                      <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                      </li>
                    </ul>
                  </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                      <div class="pull-left image">
                          <img src="<?php echo base_url();?>dist/img/default-user.png" class="img-circle" alt="User Image">
                      </div>
                      <div class="pull-left info">
                          <p>
                            <?php echo $username;?>
                          </p>
                          <p>
                            <?php echo $nombreApellido;?>
                          </p>
                        <!-- Status -->
                        <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                      </div>
                    </div>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                      <li class="header">MENU</li>
                      <!-- Optionally, you can add icons to the links -->
                      <li class="" <?php if ($rol != 1){ echo 'style="display:none;"'; } ?>>
                            <a href="<?php echo base_url();?>Usuarios"><i class="fa fa-users"></i> <span>Usuarios</span></a>
                        </li>
                      <li class="" <?php if ($rol != 1){ echo 'style="display:none;"'; } ?>>
                            <a href="<?php echo base_url();?>Notificaciones"><i class="fa fa-bullhorn"></i> <span>Notificaciones</span></a>
                        </li>
                        <li class="treeview" <?php if ($rol ==4 or $rol ==3){ echo 'style="display:none;"'; } ?>>
                            <a href="#">
                                <i class="fa fa-apple"></i> <span>Alimentos</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Alimentos/todos"><i class="fa fa-list"></i> <span>Todos</span></a></li>
                                <li class="treeview">
                                  <a href="#"><i class="fa fa-upload"></i> Subidos
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url();?>Alimentos/aceptados"><i class="fa fa-check"></i> Aceptados</a></li>
                                    <li><a href="<?php echo base_url();?>Alimentos/pendientes"><i class="fa fa-hourglass-start"></i> Pendientes</a></li>
                                    <li><a href="<?php echo base_url();?>Alimentos/rechazados"><i class="fa fa-times"></i> Rechazados</a></li>
                                  </ul>
                                <a href="#"><i class="fa fa-edit"></i> Editados
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url();?>Alimentos/aceptadosEdit"><i class="fa fa-check"></i> Aceptados</a></li>
                                    <li><a href="<?php echo base_url();?>Alimentos/pendientesEdit"><i class="fa fa-hourglass-start"></i> Pendientes</a></li>
                                    <li><a href="<?php echo base_url();?>Alimentos/rechazadosEdit"><i class="fa fa-times"></i> Rechazados</a></li>
                                  </ul>
                                </li>
                                <li><a href="<?php echo base_url();?>Alimentos/imagenes"><i class="fa fa-image"></i> <span>Imagenes</span></a></li>
                                <li><a href="<?php echo base_url();?>Recomendaciones/index"><i class="fa fa-medkit"></i> <span>Recomendaciones</span></a></li>
                                <!--<li><a href="<?php echo base_url();?>Peligros/index"><i class="fa fa-exclamation-triangle"></i> <span>Peligros</span></a></li>-->
                            </ul>
                        </li>
                        <li class="" <?php if ($rol != 3 and $rol!=2 and $rol!=1){ echo 'style="display:none;"'; } ?>>
                            <a href="<?php echo base_url();?>Consultas"><i class="fa fa-file"></i> <span>Consultas</span></a>
                        </li>
                        <li <?php if ($rol != 1){ echo 'style="display:none;"'; } ?>><a href="<?php echo base_url();?>Expertos/Nutricionistas"><i class="fa fa-user-md"></i> <span>Nutricionistas</span></a></li>
                        <li <?php if ($rol != 1){ echo 'style="display:none;"'; } ?>><a href="<?php echo base_url();?>Expertos/Coachs"><i class="fa fa-user-md"></i> <span>Coach</span></a></li>
                        <li <?php if ($rol != 1){ echo 'style="display:none;"'; } ?>><a href="<?php echo base_url();?>Tiendas/listTiendas"><i class="fa fa-home"></i> <span>Tiendas</span></a></li>
                        <li <?php if ($rol != 4){ echo 'style="display:none;"'; } ?>><a href="<?php echo base_url();?>Alimento_tienda"><i class="fa fa-apple"></i> <span>Alimentos</span></a></li>
                        <li class="treeview" <?php if ($rol != 4) { echo 'style="display:none;"'; } ?>>
                            <a href="#">
                                <i class="fa fa-list"></i> <span>Solicitudes</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Alimento_tienda/pendientes"><i class="fa fa fa-hourglass-start"></i> <span>Pendientes</span></a></li>
                                <li><a href="<?php echo base_url();?>Alimento_tienda/rechazados"><i class="fa fa-times"></i> <span>Rechazados</span></a></li>
                            </ul>
                        </li>
                    </ul><!-- /.sidebar-menu -->    
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
              <!-- Create the tabs -->
              <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane active" id="control-sidebar-home-tab">
                  <h3 class="control-sidebar-heading">Opciones</h3>
                  <ul class="control-sidebar-menu">
                    <li>
                        <a href="<?php echo base_url();?>Tiendas" <?php if ($rol != 4){ echo 'style="display:none;"'; } ?>>Perfil</a>
                        <a href="<?php echo base_url();?>Expertos/perfil" <?php if ($rol != 2 and $rol !=3 ){ echo 'style="display:none;"'; } ?>>Perfil</a>
                        <a href="<?php echo base_url();?>Usuarios/perfil" <?php if ($rol != 1){ echo 'style="display:none;"'; } ?>>Perfil</a>
                        <a href="<?php echo base_url();?>Login/logout">Cerrar Sesion</a>
                    </li>
                  </ul><!-- /.control-sidebar-menu -->
                  <ul class="control-sidebar-menu">
                  </ul><!-- /.control-sidebar-menu -->

                </div><!-- /.tab-pane -->
              </div>
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <h1>
                  <?php echo $titleContent;?>
                  <small><?php echo $subTitleContent;?></small>
                </h1>
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Nivel</a></li>
                  <li class="active"><?php echo $level;?></li>
                </ol>
              </section>

              <!-- Main content -->
              <section class="content">
                  <?php echo $contents;?>
              </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <!-- Main Footer -->
            <footer class="main-footer">
              <!-- To the right -->
              <div class="pull-right hidden-xs">
                EyesFood 2019
              </div>
              <!-- Default to the left -->
              <strong>Copyright &copy; 2019 <a href="#">EyesFood</a>.</strong> Todos los derechos reservados.
            </footer>
        </div><!-- ./wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!--Bootstrap 3.3.5--> 
        <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.min.js" ></script>
        <!--jQuery 2.1.4--> 
        <!--<script type="text/javascript" src="<?php echo base_url();?>js/JQuery-2.1.4.min.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
        <!--AdminLTE App -->
        <script type="text/javascript" src="<?php echo base_url();?>js/app.min.js"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
            Both of these plugins are recommended to enhance the
            user experience. Slimscroll is required when using the
            fixed layout. -->
    </body>
</html>