<?php
include("conexion.php");
date_default_timezone_set('America/El_Salvador');
$fecha_actual = date("Y-m-d h:i:s");
setlocale(LC_TIME, "spanish");

// Verificar si se ha enviado el ID de finiquito
if (isset($_POST['idFiniquito'])) {
    // Obtener el ID de finiquito enviado desde la página anterior
    $idFiniquito = $_POST['idFiniquito'];

    // Verifica si se recibieron los datos de fecha
    if (isset($_POST['fecha'])) {
        // Recupera la fecha enviada
        $fechaCancelacion = $_POST['fecha'];
        $fechaActuaCance = date('Y-m-d', strtotime($fechaCancelacion));


        // Realiza la actualización en la base de datos aquí usando $idFiniquito y $fecha
        // Por ejemplo:
        // $sql = "UPDATE tabla SET fecha = '$fecha' WHERE id = $idFiniquito";
        // Escapar la fecha y colocarla entre comillas simples en la consulta SQL
        $fechaEscapada = mysqli_real_escape_string($con, $fechaActuaCance);
        $sqlActualizar = "UPDATE `finiquito` SET `FechaCancelacion` = '$fechaEscapada' WHERE `finiquito`.`IdFiniquito` = $idFiniquito";
        // Ejecuta la consulta y maneja cualquier resultado o error según sea necesario
        if (mysqli_query($con, $sqlActualizar)) {
            // Mostrar mensaje de éxito como alerta en JavaScript
            echo '<script>alert("Fecha actualizada correctamente");</script>';
        } else {
            // Mostrar mensaje de error como alerta en JavaScript
            echo '<script>alert("Error updating record: ' . mysqli_error($con) . '");</script>';
        }
    } else {
        // Si no se recibió la fecha, mostrar un mensaje de advertencia como alerta en JavaScript
        echo '<script>alert("Error: Fecha faltante");</script>';
    }

    // Ahora puedes usar $idFiniquito para realizar consultas u otras operaciones en la base de datos, o para mostrar información en la página
    // Por ejemplo, para mostrar el ID de finiquito:
    //echo "ID de Finiquito: " . $idFiniquito;
    $sqlMostFiniGuard = "SELECT *  FROM `finiquito` WHERE `IdFiniquito` = $idFiniquito ORDER BY `FechaDesembolso`  DESC";
    $result = mysqli_query($con, $sqlMostFiniGuard);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($datosGuard = mysqli_fetch_assoc($result)) {
            // echo "id: " . $datosGuard["Cliente"] . " - Name: " . $datosGuard["MontoRef"] . " " . $datosGuard["RefCredito"] . "<br>";
            $fechaDesembolso = $datosGuard["FechaDesembolso"];
            $formatFechaDesem = strtotime($fechaDesembolso);
            $diaDesem = date("d", $formatFechaDesem);
            $mesDesem = strftime("%B", $formatFechaDesem);
            $anioDesem = date("Y", $formatFechaDesem);
            $fechaCancelActu = $datosGuard["FechaCancelacion"];
            $formatFechaCancel = strtotime($fechaCancelActu);
            $diaCancel = date("d", $formatFechaCancel);
            $mesCancel = strftime("%B", $formatFechaCancel);
            $anioCancel = date("Y", $formatFechaCancel);
            ?> 
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title></title>
                    <link rel="stylesheet" href="CSS/ImagFonFirm.css">
                </head>
                <body class="finiquito">
                    <img src="logo/CAJA DE CREDITO DE SAN VICENTE_1.gif" />

                    <h2>FINIQUITO</h2>

                    <p class="finiquito">El Infrascrito Coordinador de Créditos de la Caja de Crédito de San Vicente, Sociedad Cooperativa de Responsabilidad Limitada de Capital Variable, CERTIFICA QUE:</p>

                    <p class="finiquito"><?php echo $datosGuard["Cliente"] ?>; con DUI N°. <?php echo $datosGuard["DUICliente"] ?>, CANCELO, el dia <?php echo $diaCancel ?> de <?php echo $mesCancel ?>
                        del <?php echo $anioCancel ?>, el préstamo a su nombre, con referencia No. <?php echo $datosGuard["RefCredito"] ?>; que la Caja de Crédito de San Vicente, 
                        le otorgó en fecha <?php echo $diaDesem ?> de <?php echo $mesDesem ?> del <?php echo $anioDesem ?>, por un monto de $ <?php echo $datosGuard["MontoRef"] ?>.00</p></p>

                <p class="finiquito">Por no tener saldo pendiente relacionado al préstamo No. <?php echo $datosGuard["RefCredito"] ?>; Y en atención al Art. 27 de las Normas Técnicas para la Autorización, 
                    Registro y Funcionamiento de las Agencias de Información de Datos y de los Servicios de Información Sobre el Historial de Crédito de las Personas 
                    (NPR-30), Se extiende el presente FINIQUITO, en la ciudad y departamento de San Vicente, el dia <?php echo strftime("%d") ?> de <?php echo strftime("%B") ?>
                    del <?php echo strftime("%Y") ?>.</p>


                <p class="finiquito">Atentamente</p>
                <p class="finiquito">Caja de Credito de San Vicente</p>
                <div class="container">
                    <div class="firma">
                        <div class="imagen-firma">
                            <div class="texto">
                                <p>Ing. Nelson Iban Portillo Martinez</p>
                                <p>Coordinador de Créditos</p>
                            </div>
                        </div>
                    </div>
                </div>

            </body>
            </html>
            <?php
        }
    } else {
        echo "0 results";
    }

    mysqli_close($con);
} else {
    // Si no se ha enviado el ID de finiquito, muestra un mensaje de error o redirige a otra página
    echo "No se ha recibido el datos de Finiquito.";
}
?>
