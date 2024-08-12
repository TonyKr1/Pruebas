<html lang="es">
    <head>
        <title>Brummy</title>
        <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="./css/main.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link href="./css/CDN/sweetalert2.min.css" rel="stylesheet">
    </head>
    <body class="body-cisa">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt" style="transform: perspective(300px) rotateX(0deg) rotateY(0deg)">
                        <img src="../files_cloud/TMS_HERMOSILLO.png" alt="IMG" id="logo" class="img-100" />
                    </div>
                    <div class="login100-form validate-form" id="div_login">
                        <span class="login100-form-title"> Inicio de sesi&oacute;n </span>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" id="inp_usua" placeholder="Usuario" />
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <span class="material-icons"> person </span>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" id="inp_pass" placeholder="Password" />
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <span class="material-icons"> key </span>
                            </span>
                        </div>
                        <div id="err"></div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" id="btn_sesion">
                                Ingresar
                                <i class="bi bi-box-arrow-in-right" style="margin-left: 20px" aria-hidden="true"></i>
                            </button>
                            <button class="login100-form-btn" id="btn_primer_login" style="display: none">
                                Guardar Contraseña Nueva
                                <i class="bi bi-box-arrow-in-right" style="margin-left: 20px" aria-hidden="true"></i>
                            </button>

                            <!-- <a href="#" class="text-decoration-none olvide-pass" id="a_recu_pswd">¿Olvidaste tu contraseña?</a> -->
                        </div>
                    </div>
                    <div class="login100-form validate-form" id="div_recupera" style="display: none">
                        <span class="login100-form-title"> ¿Cambiar su contraseña? </span>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" id="inp_correo_recuperar" placeholder="Correo" />
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="bi bi-at icon-login" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" id="btn_enviar_mail">
                                Enviar
                                <i class="bi bi-envelope-at" style="margin-left: 20px" aria-hidden="true"></i>
                            </button>

                            <a href="#" class="text-decoration-none olvide-pass" id="a_login">Iniciar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <footer>
            <p class="text-center text-muted" style="color: #ffffff !important; font-size: large !important">
                © 2024 CISA. Todos los derechos reservados
                <br />
                <a style="color: #ffffff !important" target="_blank" href="http://ci-sa.com.mx/politica-de-privacidad/" rel="noopener">
                    POLÍTICA DE PRIVACIDAD
                </a>
            </p>
        </footer> -->
    </body>
</html>
<script src="./libraries/sweetalert2.all.min.js"></script>
<script src="./vendors/js/vendor.bundle.base.js"></script>
<script src="./js/login.js"></script>
