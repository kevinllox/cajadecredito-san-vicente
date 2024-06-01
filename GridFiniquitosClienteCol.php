<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: formulario_login.html");
    exit();
}

echo "Bienvenido, " . $_SESSION['username'];
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="CSS/MostrarTabla.css">
        <link rel="stylesheet" href="CSS/ImagFonFirm.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Capturar clic en el botón para enviar el ID de finiquito
                $('.enviarID').click(function (event) {
                    var idFiniquito = $(this).data('id'); // Obtener el ID de finiquito del atributo data-id del botón

                    // Mostrar el ID de finiquito
                    alert('ID de Finiquito: ' + idFiniquito);
                    // Crear un formulario oculto con el ID de finiquito y enviarlo mediante POST
                    var form = $('<form action="FiniquitoPDFCol.php" method="POST">' +
                            '<input type="hidden" name="idFiniquito" value="' + idFiniquito + '">' +
                            '</form>');
                    $('body').append(form); // Agregar el formulario al cuerpo del documento
                    form.submit(); // Enviar el formulario
                });
            });
        </script>
    </head>
    <body>
        <div style="text-align:center;"> 
            <img src="Imagenes/LogoCaja.jpg"/>

            <h2>FORMULARIO DE BUSQUEDA DE FINIQUITOS</h2>
            <h4>REGISTRADOS</h4>
            <h4>CREDITOS CANCELADOS</h4>
        </div>   

        <?php
        include("conexion.php");
        $numeroDUI = ($_POST['NumDUI']);

        $sqlMostrar = "SELECT *  FROM `finiquito` WHERE `DUICliente` = '$numeroDUI' ORDER BY `finiquito`.`FechaDesembolso`  DESC";
        $result = mysqli_query($con, $sqlMostrar);
        if (mysqli_num_rows($result) > 0) {
            // Si se encontraron resultados, mostrarlos en una tabla HTML
            echo "<table border='1'>";
            echo "<tr><th>Id Finiquito</th><th>Cliente</th><th>Crédito</th><th>Monto</th><th>Fecha Desembolso</th></tr>";
            while ($datos = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><button class='enviarID' data-id='" . $datos["IdFiniquito"] . "'>Finiquito</button></td>"; // Mostramos la palabra "Finiquito" en el botón y almacenamos el ID de finiquito en el atributo data-id
                echo "<td>" . $datos["Cliente"] . "</td>";
                echo "<td>" . $datos["RefCredito"] . "</td>";
                echo "<td>" . $datos["MontoRef"] . "</td>";
                echo "<td>" . $datos["FechaDesembolso"] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Si no se encontraron resultados
            echo "<p>No existen registros de finiquito para este cliente</p>";
        }

        mysqli_close($con); // Cierra la conexión a la base de datos
        ?>

    </body>
</html>