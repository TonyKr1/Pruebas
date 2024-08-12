$(document).ready(function () {
    $(document).on("keypress", function (e) {
        /*if(e.which == 13) {
            login();
        }*/
    });

    $("#btn_sesion").click(() => {
        login();
    });
});

function login() {
    let usuario = $("#inp_usua").val();
    let contrasena = $("#inp_pass").val();

    if (usuario.length == 0 || contrasena.length == 0) {
        Swal.fire({
            icon: "warning",
            title: "Aviso",
            text: "Ingresa tus credenciales.",
        });
        validarCampos();
    } else {
        validarLogin(usuario, contrasena);
    }
}

function validarCampos() {
    $("#div_login  > div > input").each(function () {
        valor = $(this).val();
        if (valor.length == 0) {
            $(this).css("border", "1.5px solid #f00");
        } else {
            $(this).css("border", "1px solid #ccc");
        }
    });
}

function validarLogin(usuario, contrasena) {
    $.ajax({
        method: "POST",
        dataType: "json",
        url: "views/login/validarLogin.php",
        data: { usuario, contrasena },
    })
        .done(function (result) {
            let login = result.success;
            let results = result.result;
            let code = result.code;
            switch (login) {
                case true:
                    if (code == 202) {
                        Swal.fire({
                            icon: "warning",
                            title: "Aviso",
                            text: results,
                        });
                    } else if (code == 200) {
                        creaSession(usuario);
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: "Aviso",
                            text: "Algo salió mal.",
                        });
                    }

                    break;
                case false:
                    Swal.fire({
                        icon: "warning",
                        title: "Aviso",
                        text: "Algo salió mal.",
                    });

                    break;
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("accesoUsuarioView  - Server: " + jqXHR.responseText + "\nEstatus: " + textStatus + "\nError: " + errorThrown);
        });
}

function creaSession(usuario) {
    $.ajax({
        method: "POST",
        dataType: "json",
        url: "views/login/creaSession.php",
        data: { usuario },
    })
        .done(function (result) {
            let login = result.success;
            switch (login) {
                case true:
                    window.location.href = "dashboard.php";

                    break;
                case false:
                    Swal.fire({
                        icon: "warning",
                        title: "Aviso",
                        text: "Algo salió mal.",
                    });

                    break;
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log("accesoUsuarioView  - Server: " + jqXHR.responseText + "\nEstatus: " + textStatus + "\nError: " + errorThrown);
        });
}
