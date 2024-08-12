<?php
    use login\loginController as ClassControllerLogin;
    require_once  __DIR__ ."/../../controllers/login/loginController.php";

    $data = $_POST;
    $controller = new ClassControllerLogin\loginController();
    $result = $controller->validarLogin($data);
    echo $result;
?>