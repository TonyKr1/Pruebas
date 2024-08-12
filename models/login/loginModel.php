<?php
namespace login\loginModel;
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    use conexionDB\Code AS ClaseConexionDB;
    require_once ( __DIR__ . './../../conexion/dataBase.php' );
    class loginModel{ 

        function validarLogin($data){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $usuario = $data['usuario'];
            $pass = $data['contrasena'];

            $sql = "SELECT usuario_usua,contrasena_usua FROM usuariosbrummy WHERE usuario_usua = '$usuario'";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        while($row = mysqli_fetch_assoc($stmt)) {
                            $pw = $row['contrasena_usua'];
                            $pwd = md5($pass);
                            if($pwd == $pw){
                                $result = array('success' => true, 'result' => 'OK', 'code' => 200 );
                            } else{
                                $result = array('success' => true, 'result' => 'Contraseña Incorrecta', 'code' => 202 );
                            }
                        }
                    } else {
                        $result = array('success' => true, 'result' => 'Usuario No encontrado', 'code' => 202 );
                    }
                } else {
                    $result = array('success' => false, 'result' => false, "result_query_sql_error"=>"Error no conocido" );
                }
            } catch (mysqli_sql_exception $e) {
                $result = array('success' => false, 'result' => false, "result_query_sql_error"=>$e->getMessage() );
            }
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }

        function creaSession($data){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $usuario = $data['usuario'];
            
            $sql = "SELECT ID, correo_usua, contacto_usua, usuario_usua, tipo_usua, estatus_usua, flag_visible_usua, fecha_vencimiento, nombre, apellidoPaterno, apellidoMaterno FROM usuariosbrummy WHERE usuario_usua = '$usuario'";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        @session_start();
                        while($row = mysqli_fetch_assoc($stmt)) {
                            $_SESSION['ID_usuario'] = $row['ID'];
                            $_SESSION['correo_usua'] = $row['correo_usua'];
                            $_SESSION['contacto_usua'] = $row['contacto_usua'];
                            $_SESSION['usuario_usua'] = $row['usuario_usua'];
                            $_SESSION['tipo_usua'] = $row['tipo_usua'];
                            $_SESSION['estatus_usua'] = $row['estatus_usua'];
                            $_SESSION['flag_visible_usua'] = $row['flag_visible_usua'];
                            $_SESSION['fecha_vencimiento'] = $row['fecha_vencimiento'];
                            $_SESSION['nombre'] = $row['nombre'];
                            $_SESSION['apellidoPaterno'] = $row['apellidoPaterno'];
                            $_SESSION['apellidoMaterno'] = $row['apellidoMaterno'];
                            $_SESSION["token"] = base64_encode($row['ID'].strtotime("now").rand(0,100).$row['usuario_usua']);
                            $result = array('success' => true, 'result' => 'OK', 'code' => 200 );
                        }
                    } else {
                        $result = array('success' => true, 'result' => 'Usuario No encontrado', 'code' => 202 );
                    }
                } else {
                    $result = array('success' => false, 'result' => false, "result_query_sql_error"=>"Error no conocido" );
                }
            } catch (mysqli_sql_exception $e) {
                $result = array('success' => false, 'result' => false, "result_query_sql_error"=>$e->getMessage() );
            }
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }

        function cargaPermisos($ID_usuario){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $sql = "SELECT * FROM vw_usuariosmodulo WHERE estatus = 1 AND FK_usuario = $ID_usuario AND FK_aplicativo = 1";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        while($row = mysqli_fetch_assoc($stmt)) {
                            $array[] =$row;
                        }
                        $result = array('success' => true, 'result' => $array);
                    } else{
                        $result = array('success' => true, 'result' => 'Sin Datos');
                    }
                } else {
                    $result = array('success' => false, 'result' => false, "result_query_sql_error"=>"Error no conocido" );
                }
            } catch (mysqli_sql_exception $e) {
                $result = array('success' => false, 'result' => false, "result_query_sql_error"=>$e->getMessage() );
            }
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }

        function dataHeader(){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $success = 200;
            $errores = '';
            
            $sql = "SELECT COUNT(ID) as cuentaAgenda,fechaCita FROM citas WHERE fechaCita = CURRENT_DATE();";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        $row = mysqli_fetch_assoc($stmt);
                    } else{
                        $result = array('success' => true, 'result' => 'Sin Datos');
                    }
                }
            } catch (mysqli_sql_exception $e) {
                $success = 500;
                $errores = $errores.$e->getMessage();
            }

            $sql1 = "SELECT COUNT(ID) as cuentaAtendidas,fechaCita FROM citas WHERE estatus = 2 AND fechaCita = CURRENT_DATE();";
            try{
                $stmt1 = mysqli_query($conexion, $sql1);
                if($stmt1){
                    $rowcount1=mysqli_num_rows($stmt1);   
                    if ( $rowcount1 ) {
                        $row1 = mysqli_fetch_assoc($stmt1);
                    }
                } 
            } catch (mysqli_sql_exception $e) {
                $success = 500;
                $errores = $errores.$e->getMessage();
            }

            $sql2 = "SELECT SUM(price) as cuenta FROM ventaheader WHERE DATE(fechaCreacion) = CURRENT_DATE();";
            try{
                $stmt2 = mysqli_query($conexion, $sql2);
                if($stmt2){
                    $rowcount2=mysqli_num_rows($stmt2);
                    if ( $rowcount2 ) {
                        $row2 = mysqli_fetch_assoc($stmt2);
                    } 
                }
            } catch (mysqli_sql_exception $e) {
                $success = 500;
                $errores = $errores.$e->getMessage();
            }

            $array[] = array(
                'cuentaAgenda' => $row['cuentaAgenda'],
                'cuentaAtendidas' => $row1['cuentaAtendidas'],
                'cuenta' => $row2['cuenta'],
                'fechaCita' => $row['fechaCita'],
            );

            $result = array('success' => true, 'result' => $array);
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }

        function getProximasCitas(){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $sql = "SELECT nombreCita, FKnombreMascota, nombreMascota FROM citas WHERE fechaCita = CURRENT_DATE() AND estatus = 1 LIMIT 5;";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        while($row = mysqli_fetch_assoc($stmt)) {
                            $array[] =$row;
                        }
                        $result = array('success' => true, 'result' => $array);
                    } else{
                        $result = array('success' => true, 'result' => 'Sin Datos');
                    }
                } else {
                    $result = array('success' => false, 'result' => false, "result_query_sql_error"=>"Error no conocido" );
                }
            } catch (mysqli_sql_exception $e) {
                $result = array('success' => false, 'result' => false, "result_query_sql_error"=>$e->getMessage() );
            }
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }

        function getLastVentas(){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $sql = "SELECT ID, FlagProducto, FKProducto, total FROM ventadetalle WHERE YEAR(fechaCreacion) = YEAR(CURRENT_DATE()) AND MONTH(fechaCreacion) = MONTH(CURRENT_DATE()) GROUP BY FKProducto ORDER BY ID DESC LIMIT 5;";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        while($row = mysqli_fetch_assoc($stmt)) {
                            $array[] =$row;
                        }
                        $result = array('success' => true, 'result' => $array);
                    } else{
                        $result = array('success' => true, 'result' => 'Sin Datos');
                    }
                } else {
                    $result = array('success' => false, 'result' => false, "result_query_sql_error"=>"Error no conocido" );
                }
            } catch (mysqli_sql_exception $e) {
                $result = array('success' => false, 'result' => false, "result_query_sql_error"=>$e->getMessage() );
            }
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }
             
        function topProductos(){
            $db = new ClaseConexionDB\ConexionDB();
            $conexion = $db->getConectaDB();

            $sql = "SELECT SUM(cantidad) as suma, FlagProducto, FKProducto FROM ventadetalle WHERE YEAR(fechaCreacion) = YEAR(CURRENT_DATE()) AND MONTH(fechaCreacion) = MONTH(CURRENT_DATE()) GROUP BY FKProducto ORDER BY suma DESC LIMIT 5;";
            try{
                $stmt = mysqli_query($conexion, $sql);
                if($stmt){
                    $rowcount=mysqli_num_rows($stmt);   
                    if ( $rowcount ) {
                        while($row = mysqli_fetch_assoc($stmt)) {
                            $array[] =$row;
                        }
                        $result = array('success' => true, 'result' => $array);
                    } else{
                        $result = array('success' => true, 'result' => 'Sin Datos');
                    }
                } else {
                    $result = array('success' => false, 'result' => false, "result_query_sql_error"=>"Error no conocido" );
                }
            } catch (mysqli_sql_exception $e) {
                $result = array('success' => false, 'result' => false, "result_query_sql_error"=>$e->getMessage() );
            }
            
            mysqli_close( $conexion );
            $resultJson = json_encode( $result );
            return $resultJson;
        }
    }
?>