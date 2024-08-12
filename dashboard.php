<?php
    session_start();
if(isset ( $_SESSION['ID_usuario'] ) ){
    $ID_usuario = $_SESSION['ID_usuario']; 
    if($ID_usuario == ''){
        $boolean_session = false;
    } else {
        $boolean_session = true;
    }
} else {
    $boolean_session = false;
}

if( !$boolean_session ){
    session_unset(); 
    session_destroy();
    header("Location: /Brummy/");
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Brummy</title>
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" /> -->
        <link href="./css/CDN/Material_Icons.css" rel="stylesheet">
        <link href="./css/CDN/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" media="all" href="./css/ispinner.prefixed.css" />
        <!-- plugins:css -->
        <link rel="stylesheet" href="./vendors/feather/feather.css" />
        <link rel="stylesheet" href="./vendors/ti-icons/css/themify-icons.css" />
        <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css" />
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="./vendors/select2/select2.min.css" />
        <link rel="stylesheet" href="./vendors/select2-bootstrap-theme/select2-bootstrap.min.css" />
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="./css/vertical-layout-light/style.css" />
        <link rel="stylesheet" href="./css/brummy.css" />
        <!-- endinject -->
        <link rel="shortcut icon" href="./images/cuadrado_sin_fondo.png" />

        <link rel="stylesheet" href="./libraries/datatables-1.12.1/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="./libraries/datatables-1.12.1/responsive/2.3.0/responsive.dataTables.min.css" />
        <link rel="stylesheet" href="./libraries/jsCalendar/jsCalendar.min.css" />
    </head>

    <style>
        .card {
            box-shadow: none;
            background-color: transparent;
        }
        .table.dashTable thead > tr > th {
            background-color: #009071;
            color: #fff;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        
    </style>
    <body>
        <div class="modal modals fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="width: 48px">
                    <div class="ispinner ispinner-large">
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                        <div class="ispinner-blade"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('./templates/components/modalAlert.php'); ?>
        <div class="container-scroller">
            <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row" style="user-select: none;">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                    <div class="me-3">
                        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                            <span class="material-icons"> menu </span>
                        </button>
                    </div>
                    <div>
                        <a class="navbar-brand brand-logo" href="./dashboard.php">
                            <img src="./images/large.png" alt="logo" />
                        </a>
                        <a class="navbar-brand brand-logo-mini" href="./dashboard.php">
                            <img src="./images/cuadrado_sin_fondo.png" alt="logo" />
                        </a>
                    </div>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-top">
                    <ul class="navbar-nav">
                        <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                            <h1 class="welcome-text">Hola!, <span class="text-black fw-bold"><?php echo $_SESSION['nombre']." ".$_SESSION['apellidoPaterno']; ?></span></h1>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto"></ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas" id="btnHideDash">
                        <span class="material-icons"> menu </span>
                    </button>
                </div>
            </nav>
            <div class="container-fluid page-body-wrapper">
                <nav class="sidebar sidebar-offcanvas" id="sidebar" style="position: fixed; user-select: none;">
                    <ul class="nav" id="navSide">
                        <li class="nav-item">
                            <a class="nav-link" href="./dashboard.php">
                                <span class="material-icons me-2"> dashboard </span>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item nav-category" style="padding-top: 0px"><hr style="margin: 5px 0px" /></li>
                        
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel" style="margin-left: auto">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card p-0">
                                <div class="card">
                                    <div class="card-body" id="contenido" style="padding: 1rem;">
                                        <div class="row dahsboardContenido" style="display:none;">
                                            <div class="col-md-6 grid-margin stretch-card">
                                                <div class="card2 mb-2">
                                                    <div class="card-body">
                                                        <h4 class="statistics-title">TOP 5</h4>
                                                        <div id="div_citas">
                                                            <canvas id="bar-chart2" width="800" height="450"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 grid-margin stretch-card">
                                                <div class="card2 mb-2">
                                                    <div class="card-body">
                                                        <h4 class="statistics-title">Satisfacción</h4>
                                                        <div id="div_citas">
                                                            <canvas id="bar-chart" width="800" height="450"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"> &nbsp; </span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2024. All rights reserved.</span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="./vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="./vendors/select2/select2.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="./js/off-canvas.js"></script>
        <script src="./js/hoverable-collapse.js"></script>
        <script src="./js/template.js"></script>
        <script src="./js/settings.js"></script>
        <script src="./js/configGlobal.js"></script>
        <script src="./js/principal.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="./js/select2.js"></script>
        <!-- End custom js for this page-->
        <script type="text/javascript" src="./libraries/datatables-1.12.1/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="./libraries/datatables-1.12.1/responsive/2.3.0/dataTables.responsive.min.js"></script>
        <script src="./libraries/sweetalert2.all.min.js"></script>
        <script src="./libraries/jsCalendar/jsCalendar.lang.es.js"></script>
        <script src="./libraries/jsCalendar/jsCalendar.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </body>
</html>
