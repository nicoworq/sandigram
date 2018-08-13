/*
 * SUBIR ARCHIVOS
 */

$(document).ready(function (e) {

    /*
     * POLLS CONTROLS     
     */

    $("#id_tipo").change(function (e) {

        var selected = $(this).val();
        var form = $("#form-post");

        form.removeClass("form-timeline form-story form-poll");

        // 1 timeline | 2 story | 3 poll

        switch (parseInt(selected)) {
            case 1:
                form.addClass("form-timeline");
                break;
            case 2:
                form.addClass("form-story");
                break;
            case 3:
                form.addClass("form-poll");
                break;
        }

    });

    /*
     * POLLS TEXT UPDATE     
     */

    $("input[name=respuesta_1").keyup(function () {
        var texto = $(this).val();
        $("#poll-respuesta1").html(texto);
    });
    $("input[name=respuesta_2").keyup(function () {
        var texto = $(this).val();
        $("#poll-respuesta2").html(texto);
    });

    /*
     * POLL DRAGGGGGG     
     */

    var x = 0.5;
    var y = 0.5;

    var xMax = 0.7;
    var xMin = 0.3;
    var yMax = 0.85;
    var yMin = 0.15;



    var xStart;
    var yStart;
    var xEnd;
    var yEnd;
    $("#poll-preview").on("dragstart", function (event) {
        console.log("dragstart");

        xStart = event.clientX;
        yStart = event.clientY;

        console.log(xStart, "X");
        console.log(yStart, "Y");
    });


    $("#poll-preview").on("dragend", function (event) {
        console.log("dragend");

        var poll = $(this);

        xEnd = event.clientX;
        yEnd = event.clientY;

        offsetX = xEnd - xStart;
        offsetY = yEnd - yStart;

        var pollMarginTop = parseInt(poll.css("top"));
        var pollMarginLeft = parseInt(poll.css("left"));

        poll.css("top", pollMarginTop + offsetY);
        poll.css("left", pollMarginLeft + offsetX);

        console.log(transpolarX(pollMarginLeft + offsetX), "X");
        console.log(transpolarY(pollMarginTop + offsetY), "Y");

        $("#form-post input[name=pos_x]").val(transpolarX(pollMarginLeft + offsetX));
        $("#form-post input[name=pos_y]").val(transpolarY(pollMarginTop + offsetY));

    });

    function transpolarX(marginLeft) {
        return (0.002758 * (marginLeft - 1) + 0.3).toFixed(2);
    }

    function transpolarY(marginTop) {
        return (0.00150862 * (marginTop - 1) + 0.15).toFixed(2);
    }

    function transpolarYaPx(pos_y) {
        return (662.8571 * (pos_y - .15) + 1);
    }


    function transpolarXaPx(pos_x) {
        return (362.5 * (pos_x - 0.3) + 1);
    }

    if ($("#form-post input[name=pos_x]").val()) {
        console.log("transpolo x")
        $("#poll-preview").css("left", transpolarXaPx(parseFloat($("#form-post input[name=pos_x]").val())));
    }

    if ($("#form-post input[name=pos_y]").val()) {
        console.log("transpolo y")
        $("#poll-preview").css("top", transpolarYaPx(parseFloat($("#form-post input[name=pos_y]").val())));
    }

    /*
     * CHECK SANDIGRAM SERVICE
     */

    function actualizarEstadoServidor() {

        $.get(window.appDir + '/service/last_seen', function (response) {

            var tiempo_publicacion = (5 - response.last_seen.toFixed(2)).toFixed(2);

            if (response.servicio_activo) {

                $("#service-status").removeClass("offline").addClass("online").html("Todos los sistemas operativos | Proxima publicacion en : " + tiempo_publicacion + " minutos");
            } else {
                $("#service-status").removeClass("online").addClass("offline").html("El servidor se encuentra offline. No se realizarán publicaciones.");
            }

        }, "json");
    }

    actualizarEstadoServidor();

    setInterval(function () {
        actualizarEstadoServidor();
    }, 5000);


    $("#file").on('change', function () {
        // $("#input-file-sandigram #upload").addClass("activo");

        setTimeout(function () {
            $("#upload").click();
        }, 500);


    });

    $('#upload').on('click', function () {
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: window.appDir + '/media/upload_file', // point to server-side controller method
            dataType: 'json', // what to expect back from the server
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {

                if (response.subido) {
                    UIkit.notification('Archivo subido correctamente!', {pos: 'top-center', status: 'success'});
                    $("#id_medio").val(response.id_medio);

                    if (!response.es_imagen) {
                        $("#imagen-preview").html("");
                        $("#imagen-preview").html($("<video/>", {controls: true, src: window.baseUrl + '/uploads/' + response.nombre_archivo}));
                    } else {
                        $("#imagen-preview").css('background-image', 'url(' + window.baseUrl + '/uploads/' + response.nombre_archivo + ')');
                    }
                    $("#imagen-preview").addClass("activo");

                    archivoSubido = true;
                } else {
                    UIkit.notification('Error al subir archivo!', {pos: 'top-center', status: 'danger'});
                }

            },
            error: function (response) {
                UIkit.notification('Error al subir archivo!', {pos: 'top-center', status: 'danger'});
            }
        });
    });

    // valido si fue subido algun archivo
    var archivoSubido = false;


    // si image-preview tiene activo, significa q estamos en en edit post

    if ($("#imagen-preview").hasClass("activo")) {
        archivoSubido = true;
    }

    $("#eliminar-publicacion").click(function (e) {
        if (!confirm("Estas seguro?")) {
            e.preventDefault();
        }
    });

    $(".validate-change").on("change keyup", function () {
        var permitirSubir = true;
        /*
         if (!$("textarea[name=texto]").val()) {
         permitirSubir = false;
         }
         */
        if (!$("input[name=fecha_publicacion]").val()) {
            permitirSubir = false;
        }
        if (!archivoSubido) {
            permitirSubir = false;
        }

        if (permitirSubir) {
            $("#subir-publicacion").removeAttr("disabled");
        } else {
            $("#subir-publicacion").attr("disabled", true);
        }
        console.log("changeee");

    });

    //usuario nuevo

    $(".validate-input").keyup(function () {
        console.log("keydown")
        var formValid = true;

        $(".validate-input").each(function (i, input) {

            if ($(input).val() == "") {
                formValid = false;
            }
                       

        });

        if (formValid) {
            $("button").removeAttr("disabled");
        } else {
            $("button").attr("disabled", true);
        }
        
        
        
    });


});



/* flatpickr v4.1.4, @license MIT */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
            typeof define === 'function' && define.amd ? define(['exports'], factory) :
            (factory((global.es = {})));
}(this, (function (exports) {
    'use strict';

    var fp = typeof window !== "undefined" && window.flatpickr !== undefined
            ? window.flatpickr
            : {
                l10ns: {},
            };
    var Spanish = {
        weekdays: {
            shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
            longhand: [
                "Domingo",
                "Lunes",
                "Martes",
                "Miércoles",
                "Jueves",
                "Viernes",
                "Sábado",
            ],
        },
        months: {
            shorthand: [
                "Ene",
                "Feb",
                "Mar",
                "Abr",
                "May",
                "Jun",
                "Jul",
                "Ago",
                "Sep",
                "Oct",
                "Nov",
                "Dic",
            ],
            longhand: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
        },
        ordinal: function () {
            return "º";
        },
        firstDayOfWeek: 1,
    };
    fp.l10ns.es = Spanish;
    var es = fp.l10ns;

    exports.Spanish = Spanish;
    exports['default'] = es;

    Object.defineProperty(exports, '__esModule', {value: true});

})));

if (typeof flatpickr !== 'undefined') {
    flatpickr("#picker-publicacion", {locale: "es",
        enableTime: true,
        minDate: "today",
        altInput: true,
    });
}


  