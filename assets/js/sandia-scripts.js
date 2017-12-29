/*
 * SUBIR ARCHIVOS
 */

$(document).ready(function (e) {

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
                    $("#imagen-preview").css('background-image', 'url(' + window.baseUrl + '/uploads/' + response.nombre_archivo + ')').addClass("activo");
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

    $(".validate-change").on("change keyup", function () {
        var permitirSubir = true;

        if (!$("textarea[name=texto]").val()) {
            permitirSubir = false;
        }
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


  