<?php
    use ventas\ventasController as ClassControllerVentas;
    require_once  __DIR__ ."/../../controllers/ventas/ventasController.php";

    $data = $_POST;
    
    $controller = new ClassControllerVentas\ventasController();
    $result = $controller->obtenerVenta($data);
    echo $result;
?>