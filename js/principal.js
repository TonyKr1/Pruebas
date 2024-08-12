$(document).ready(() => {
    $.ajax({
        method: "POST",
        dataType: "json",
        url: "views/login/cargaPermisos.php",
        data: {},
    })
        .done(function (result) {
            let success = result.success;
            let results = result.result;
            switch (success) {
                case true:
                    results.forEach((data, index) => {
                        if (data.ID_modulo == 1) {
                            $(".dahsboardContenido").css("display", "flex");
                            cargaDataDash();
                        }

                        if (data.ID_modulo != 1 && data.ID_modulo != 2) {
                            $("#navSide").append(`
                                <li class="nav-item" id="${data.id_element}_li">
                                    <a class="nav-link tagAMenu" href="#" id="${data.id_element}" onclick="cargaTemplate(this.id, '${data.permiso}')">
                                        <span class="material-icons me-2"> ${data.icono} </span>
                                        <span class="menu-title">${data.titulo}</span>
                                    </a>
                                </li>
                            `);
                        }
                    });
                    let name = $(".welcome-text span").text();

                    $("#navSide").append(`
                        <li class="nav-item nav-category" style="padding-top: 0px"><hr style="margin: 5px 0px" /></li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#userOptions" aria-expanded="false" aria-controls="userOptions">
                                <span class="material-icons" style="margin-right: 10px;"> account_circle </span>
                                <span class="menu-title">${name}</span>
                            </a>
                            <div class="collapse" id="userOptions">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item tagAMenu"><a class="nav-link" href="#">My Profile</a></li>
                                    <!-- <li class="nav-item tagAMenu"><a class="nav-link" href="#">FAQ</a></li> -->
                                    <li class="nav-item tagAMenu"><a class="nav-link" href="#" onclick="cerrarSesion()">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        </li>
                    `);

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
});

function cargaDataDash() {
    new Chart(document.getElementById("bar-chart"), {
        type: "bar",
        data: {
            labels: ["1 estrellas", "2 estrellas", "3 estrellas", "4 estrellas", "5 estrellas"],
            datasets: [
                {
                    label: "Calificaciones",
                    backgroundColor: ["#009071", "#009071", "#009071", "#009071", "#009071"],
                    data: [0, 0, 0, 2, 3, 5],
                },
            ],
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "",
            },
        },
    });
}

function activeSubmenu(id_element_submenu) {
    $(".nav-item").attr("class", "nav-item");
    $("#" + id_element_submenu + "_li").attr("class", "nav-item active");
}

function cargaTemplate(id, permiso) {
    preloader.show();
    switch (id) {
        case "apps_menu":
            cargarTemplateCatalogos();
            activeSubmenu(id);
            break;

        default:
            preloader.hide();
            console.log("sin menu");
            // Swal.fire({ icon: "warning", title: "", text: "Algo salio mal vuelve a intentarlo." })
            break;
    }
}

function cargarTemplateCatalogos() {
    $("#contenido").load("templates/catalogos/catalogos.php", function (responseTxt, statusTxt, xhr) {
        if (statusTxt != "error") {
            changeViewMenuIcon();
            // documentReadyVacantes();
        }
    });
}
