<?php
    use ventas\ventasController as ClassControllerInventario;
    require_once  __DIR__ ."/../../controllers/ventas/ventasController.php";

    $data = $_POST;

    $controller = new ClassControllerInventario\ventasController();
    $result = $controller->guardarDetalleVenta($data);
    echo $result;
?>