$(document).ready(() => {
    // preloader.hide();
    let fechaNow = new Date().toLocaleString("sv-SE").split(" ")[0];
    let mes = fechaNow.split("-")[1];
    let anio = fechaNow.split("-")[0];

    const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    for (let i = 0; i < months.length; i++) {
        let m = i;
        m++;
        if (mes == m) {
            $("#mesVentas").append(`<option value="${m}" selected>${months[i]}</option>`);
        } else {
            $("#mesVentas").append(`<option value="${m}">${months[i]}</option>`);
        }
    }

    for (let i = 3; i > 0; i--) {
        let new_anio = Number(anio) - i;
        $("#anioVentas").append(`<option value="${new_anio}">${new_anio}</option>`);
    }
    $("#anioVentas").append(`<option value="${anio}" selected>${anio}</option>`);

    for (let i = 1; i < 4; i++) {
        let new_anio = Number(anio) + i;
        $("#anioVentas").append(`<option value="${new_anio}">${new_anio}</option>`);
    }

    obtenerVentas(mes, anio);

    $("#mesVentas").change(() => {
        obtenerVentas($("#mesVentas").val(), $("#anioVentas").val());
    });
    $("#anioVentas").change(() => {
        obtenerVentas($("#mesVentas").val(), $("#anioVentas").val());
    });
});

function obtenerVentas(mes, anio) {
    preloader.show();
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "./views/ventas/obtenerVentas.php",
        data: { mes, anio },
    })
        .done(function (results) {
            let success = results.success;
            let result = results.result;
            let html = "";
            switch (success) {
                case true:
                    if (result == "Sin Datos") {
                        dataTableDestroy();
                        $("#ventasBody").html(html);
                        dataTableCreateDes();
                        preloader.hide();
                    } else {
                        dataTableDestroy();
                        let html, codigo, stock;
                        result.forEach((data, index) => {
                            codigo = data.codigo;
                            stock = data.stockReal;
                            if (data.Flagtipo == "Servicio") {
                                codigo = String(codigo) + String(data.ID);
                                stock = "N/A";
                            }
                            html += `<tr>
                                <td>VTA-${data.ID}</td>
                                <td class="capitalize">${data.nombreCompleto}</td>
                                <td>${data.cantidad}</td>
                                <td>${FormatDate(data.Fecha)}</td>
                                <td>$${data.price}</td>
                                <td>
                                    <div style="display: flex; flex-direction: row;">
                                        <div class="buttom-blue buttom button-sinText mx-1" title="Ver Detalle" onclick="verDetalleVenta(${data.ID})">
                                            <span class="text-sm mb-0"><i class="material-icons"> shopping_cart </i></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>`;
                        });
                        $("#ventasBody").html(html);
                        dataTableCreateDes();
                    }
                    break;
                case false:
                    preloader.hide();
                    msj.show("Aviso", "Algo salió mal", [{ text1: "OK" }]);
                    break;
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            preloader.hide();
            msj.show("Aviso", "Algo salió mal", [{ text1: "OK" }]);
            console.log("error: " + jqXHR.responseText + "\nEstatus: " + textStatus + "\nError: " + errorThrown);
        });
}

function irNuevaVenta() {
    preloader.show();
    $("#contenido").load("templates/ventas/nuevaVenta.php", function (responseTxt, statusTxt, xhr) {
        if (statusTxt != "error") {
            // documentReadyVacantes();
        }
    });
}

function verDetalleVenta(ID) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "./views/ventas/obtenerVenta.php",
        data: { ID },
    })
        .done(function (results) {
            let success = results.success;
            let result = results.result;
            let html = "",
                nombreCliente,
                cambio,
                efectivo,
                price,
                Fecha;
            switch (success) {
                case true:
                    if (result == "Sin Datos") {
                        msj.show("Aviso", "Algo salió mal", [{ text1: "OK" }]);
                        preloader.hide();
                    } else {
                        result.forEach((data, index) => {
                            console.log(data);
                            let random = genRandom();
                            nombreCliente = data.nombreCliente;
                            Fecha = data.Fecha;
                            cambio = data.cambio;
                            if (Number(cambio) <= 0) {
                                efectivo = data.price;
                            } else {
                                efectivo = data.efectivo;
                            }
                            price = data.price;
                            html += `
                            <div id="${random}_product">
                                <div class="product" style="grid-template-columns: 1fr 80px 1fr 100px;">
                                    <div>
                                        <span class="capitalize" id="${random}_FlagProducto">${data.FlagProducto}</span>
                                        <p class="capitalize">${data.tipo}</p>
                                    </div>
                                    <div class="quantity">
                                        <label style="color: #009071;" id="${random}_label">${data.cantidad}</label>
                                    </div>
                                    <label class="price small my-auto" id="${random}_totals">$${data.precioVenta} c/u</label>
                                    <label class="price small my-auto" id="${random}_total">$${data.total}</label>
                                </div>
                                <hr>
                            </div>`;
                        });
                        $("#labelModal").html(`Detalle Venta`);

                        $("#body_modal").html(`<br>
                            <div>
                                <div style="display: flex;flex-direction: row;">
                                    <h4 class="card-title me-3" style="font-weight: 400;">Cliente:</h4>
                                    <h4 class="card-title subtitle">${nombreCliente}</h4>
                                </div>
                                <div style="display: flex;flex-direction: row;">
                                    <h4 class="card-title me-3" style="font-weight: 400;">Fecha:</h4>
                                    <h4 class="card-title subtitle">${Fecha}</h4>
                                </div>
                                <hr>
                                <h4 class="card-title mt-2">Carrito</h4>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="master-container">
                                            <div class="cart">
                                                <div class="products">
                                                    ${html}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="checkout">
                                            <div class="details">
                                                <span>Subtotal:</span>
                                                <span id="totalSubtotal">$${price}</span>
                                            </div>
                                            <div class="details">
                                                <span>Descuentos de productos:</span>
                                                <span id="totalDescuentos">$0.00</span>
                                            </div>
                                            <hr>
                                            <div class="checkout--footer">
                                                <label class="price" id="priceTotal_text"><sup>$</sup>${price}</label>
                                            </div>
                                            <hr>
                                            <div class="details">
                                                <span>Efectivo:</span>
                                                <span>$${efectivo}</span>
                                            </div>
                                            <div class="details">
                                                <span>Cabmio:</span>
                                                <span id="totalDescuentos">$${cambio}</span>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        $("#modalTemplate").modal({
                            backdrop: "static",
                            keyboard: false,
                        });

                        $("#modalTemplate").modal("show");

                        $("#btnClose").on("click", () => {
                            $("#modalTemplate").modal("hide");
                            $("#btnClose").off("click");
                        });

                        preloader.hide();
                    }
                    break;
                case false:
                    preloader.hide();
                    msj.show("Aviso", "Algo salió mal", [{ text1: "OK" }]);
                    break;
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            preloader.hide();
            msj.show("Aviso", "Algo salió mal", [{ text1: "OK" }]);
            console.log("error: " + jqXHR.responseText + "\nEstatus: " + textStatus + "\nError: " + errorThrown);
        });
}
