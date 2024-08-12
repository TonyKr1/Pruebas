<?php
    namespace login\loginController;
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    session_start();
    use login\loginModel AS ClaseLoginModelo;
    require_once __DIR__ . '/../../models/login/loginModel.php';
    
    class loginController {
        function getConexionModelClass(){
            return $model_class = new ClaseLoginModelo\loginModel();
        }

        function validarLogin($data){
            $model_login = $this->getConexionModelClass();
            $result_model = $model_login->validarLogin($data);
            return $result_model;
        }

        function creaSession($data){
            $model_login = $this->getConexionModelClass();
            $result_model = $model_login->creaSession($data);
            return $result_model;
        }

        function cargaPermisos(){
            $model_login = $this->getConexionModelClass();
            $ID_usuario = $_SESSION['ID_usuario'];
            $result_model = $model_login->cargaPermisos($ID_usuario);
            return $result_model;
        }

        function dataHeader(){
            $model_login = $this->getConexionModelClass();
            $result_model = $model_login->dataHeader();
            return $result_model;
        }

        function getProximasCitas(){
            $model_login = $this->getConexionModelClass();
            $result_model = $model_login->getProximasCitas();
            return $result_model;
        }

        function getLastVentas(){
            $model_login = $this->getConexionModelClass();
            $result_model = $model_login->getLastVentas();
            return $result_model;
        }

        function topProductos(){
            $model_login = $this->getConexionModelClass();
            $result_model = $model_login->topProductos();
            return $result_model;
        }
        
    }
?>