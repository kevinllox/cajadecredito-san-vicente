<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Insertar CSV para Generar Varios Finiquitos</title>
        <link rel="icon" type="image/png" href="logo/fede.ico" />
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.css"/>
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/app.css"/>
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.min.css"/>
                        <link rel="stylesheet"  href="foundation-6.4.2-complete/css/auxiliar.css"/>
                        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        
<?php



  include("conexion.php");
// Validar si se ha enviado un archivo CSV
if (isset($_FILES["archivoCSV"])) {

    // Cargar el archivo CSV
    $file = $_FILES["archivoCSV"]["tmp_name"];

    // Abrir el archivo CSV
    $fp = fopen($file, "r");

    // Leer cada fila del archivo CSV
    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {

        // Obtener los datos de la fila actual
        $cliente = $data[0];
        $dui = $data[1];
        $refcredito = $data[2];
        $montoRef = (int)$data[3]; // Convertir a entero
        $fechaDesembolso = date('Y-m-d', strtotime($data[4])); // Formatear fecha

        // Insertar los datos en la tabla MySQL
        $sql = "INSERT INTO `finiquito` (Cliente, DUICliente, RefCredito, MontoRef, FechaDesembolso) 
                VALUES ('$cliente', '$dui', '$refcredito', $montoRef, '$fechaDesembolso')";
        $con->query($sql);
    }

    // Cerrar el archivo CSV
    fclose($fp);

    // Mostrar un mensaje de éxito
    echo "Los datos del archivo CSV se han importado correctamente.";
}

?>

    </body>
</html>
