<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendors/icons-1.8.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="vendors/jQuery-Smart-Wizard/wizard/style.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/fontawesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- Dropzone.js -->
  <link href="vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">

  <!-- the fileinput plugin styling CSS file -->
  <link href="vendors/fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
  <link href="vendors/fileinput/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css" />

<!-- the fileinput plugin styling CSS file -->
<link href="vendors/fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

  <!-- bootstrap-progressbar -->
  <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <title>Correspondencia UCAD</title>

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">


  <!-- bootstrap-progressbar -->
  <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="build/css/custom.min.css" rel="stylesheet">
  <link href="vendors/sweetalert2/sweetalert2.css" rel="stylesheet">

  <!-- Form Wizar (Formulario para agregar persona, contacto y usuario) -->

  <link href="vendors/Smartwizard/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

  <link href="vendors/Smartwizard/examples/css/animate.min.css" rel="stylesheet" />


  <!-- Include SmartWizard CSS -->
  <link href="vendors/Smartwizard/examples/css/demo.css" rel="stylesheet" type="text/css" />
  <link href="vendors/Smartwizard/dist/css/smart_wizard_all.css" rel="stylesheet" type="text/css" />


</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?= base_url() . route_to('homeMenu') ?>" class="site_title">
              <span>
                <P style="font-size:19px;">Correspondencia <b>UCAD</b></P>
              </span>
            </a>
          </div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic center">
              <img src="images/logo.jpeg" alt="..." class="img" width="70" style="float: right; margin:0px auto; border-radius: 7px">
            </div>
            <div class="profile_info">
              <span>Bienvenido,</span>
              <h2 style="font-size: 20px;"><?php echo session('usuario'); ?> </h2>
            </div>
          </div>
          <!-- /menu profile quick info -->
          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Men??</h3>
              <?php

              use App\Models\modAdministracion\SubmenuModel;
              use App\Models\modAdministracion\MenuSubmenuModel;
              use App\Models\modAdministracion\ModuloModel;
              use App\Models\modAdministracion\RolModMenuModel;
              use App\Models\modUsuario\UsuarioModel;

              ?>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i>Inicio<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="homeMenu">Inicio</a></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav side-menu">

                <?php

                $session = session();
                $menu     = new MenuSubmenuModel();
                $submenu  = new SubmenuModel();
                $obtenerRol = new UsuarioModel();

                $rol =  $obtenerRol->asArray()->select('r.nombreRol')->from('wk_usuario u')
                  ->join('wk_rol r', 'u.rolId=r.rolId')->where('u.usuario', $session->usuario)->first();
                $rolMenu  = new RolModMenuModel();
                $menu     = $rolMenu->asObject()->select('m.menuId, m.nombreMenu, i.nombreIcono')
                  ->from('co_rol_modulo_menu rmm')
                  ->join('wk_rol r', 'rmm.rolId= r.rolId')
                  ->join('co_modulo_menu mm', 'rmm.moduloMenuId= mm.moduloMenuId')
                  ->join('co_modulo mo', 'mm.moduloId=mo.moduloId')
                  ->join('co_menu m', 'mm.menuId=m.menuId')
                  ->join('wk_icono i', 'm.iconoId=i.iconoId')
                  ->where('r.nombreRol', $rol)
                  ->where('mo.moduloId', $session->modulo)
                  ->groupBy('menuId')
                  ->findAll();

                foreach ($menu as $key => $u) :
                  $submenus  = $submenu->asObject()->select()->where('menuId', $u->menuId)->findAll();
                ?>
                  <?php if ($u->nombreMenu) : ?>
                    <li><a><i class="<?php echo $u->nombreIcono ?>"></i> <?= $u->nombreMenu ?><span class="fa fa-chevron-down"></span></a>
                    <?php endif ?>
                    <ul class="nav child_menu">
                      <?php foreach ($submenus as $s) : ?>
                        <li><a href=<?= $s->nombreArchivo ?>><?php echo $s->nombreSubMenu ?> </a></li>
                      <?php endforeach; ?>
                    </ul>
                    </li>
                  <?php endforeach; ?>
              </ul>
              </ul>
            </div>


          </div>
          <!-- /sidebar menu -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/user.png" alt=""><?php echo session('usuario'); ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="<?php echo base_url('/salir') ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="row"><br>
          <h6>Navegaci??n&nbsp;&nbsp;<i class="fa fa-angle-right"> </i></h6>
          <h6><a href="<?= base_url() . route_to('homeModulos') ?>">&nbsp;&nbsp;M??dulos&nbsp;&nbsp;<i class="fa fa-angle-right"></i></a>&nbsp;&nbsp;</h6>
          <h6>
            <a href="homeMenu">
              <?php
              $modulo = new ModuloModel();
              $mod = $modulo->asArray()->select('m.nombre')->from('co_modulo m')->where('m.moduloId', $session->modulo)->first();
              echo $mod['nombre'] ?>
            </a>
          </h6>
        </div>
        <?= $this->renderSection('content'); ?>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="text-center">
          Sistema de Correspondencia &copy; <?= date('Y'); ?>
          <br>
          <p>Universidad Cristiana de las Asambleas de Dios</p> <a href="https://colorlib.com"></a>
        </div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>

  <!-- Dropzone.js -->
  <script src="vendors/dropzone/dist/min/dropzone.min.js"></script>


  <!--KRAJEE
    <script src="vendors/kartik/js/locales/LANG.js"></script> -->

  <!-- jQuery -->
  <script src="vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="vendors/nprogress/nprogress.js"></script>
  <!-- Chart.js -->
  <script src="vendors/chart.js-3.8.0/package/dist/chart.min.js"></script>

  <!-- gauge.js -->
  <script src="vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="vendors/iCheck/icheck.min.js"></script>
  <!-- Datatables -->
  <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="vendors/jszip/dist/jszip.min.js"></script>
  <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
  <!-- Skycons -->
  <script src="vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="vendors/Flot/jquery.flot.js"></script>
  <script src="vendors/Flot/jquery.flot.pie.js"></script>
  <script src="vendors/Flot/jquery.flot.time.js"></script>
  <script src="vendors/Flot/jquery.flot.stack.js"></script>
  <script src="vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="vendors/moment/min/moment.min.js"></script>
  <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- jQuery Smart Wizard -->
  <script src="vendors/jQuery-Smart-Wizard/wizard/script.js"></script>
  <!-- FastClick -->
  <script src="vendors/fastclick/lib/fastclick.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="build/js/custom.min.js"></script>

  <!--SweetAlert-->
  <script src="vendors/sweetalert2/sweetalert2.min.js"></script>
  <script src="vendors/sweetalert2/sweetalert.min.js"></script>


  <!-- Smartwizard -->
  <script src="vendors/Smartwizard/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

  <script src="vendors/Smartwizard/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
</body>

</html>