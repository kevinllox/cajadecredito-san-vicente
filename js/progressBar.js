/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {

    $("#formulario").submit(function(e) {

        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "insertarCSV.php",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(e) {
                    if (e.lengthComputable) {
                        var porcentaje = Math.floor((e.loaded / e.total) * 100);
                        actualizarProgreso(porcentaje);
                    }
                });
                return xhr;
            },
            success: function(data) {
                // Mostrar un mensaje de éxito
                alert("El archivo CSV se ha cargado correctamente.");
            }
        });
    });

    // Función para actualizar la barra de progreso
    function actualizarProgreso(porcentaje) {
        $("#progreso .progress-bar-inner").css("width", porcentaje + "%");
    }
});