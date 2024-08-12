<?php
    namespace ventas\ventasController;
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    session_start();

    use ventas\ventasModel AS ClaseVentasModelo;
    require_once __DIR__ . '/../../models/ventas/ventasModel.php';
    
    class ventasController {
        function getConexionModelClass(){
            return $model_class = new ClaseVentasModelo\ventasModel();
        }

        function guardarHeaderVenta($data){
            $model_ventas = $this->getConexionModelClass();
            $result_model = $model_ventas->guardarHeaderVenta($data);
            return $result_model;
        }

        function guardarDetalleVenta($data){
            $model_ventas = $this->getConexionModelClass();
            $result_model = $model_ventas->guardarDetalleVenta($data);
            return $result_model;
        }
        
        function obtenerVentas($data){
            $model_ventas = $this->getConexionModelClass();
            $result_model = $model_ventas->obtenerVentas($data);
            return $result_model;
        }

        function obtenerVenta($data){
            $model_ventas = $this->getConexionModelClass();
            $result_model = $model_ventas->obtenerVenta($data);
            return $result_model;
        }
        
    }
?>