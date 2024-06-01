<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: formulario_login.html");
    exit();
}

echo "Bienvenido, " . $_SESSION['username'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Expires" content="0"/>
        <meta http-equiv="Last-Modified" content="0"/>
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"/>
        <meta http-equiv="Pragma" content="no-cache">
            <meta http-equiv="cache-control" content="max-age=0" />
            <meta http-equiv="cache-control" content="no-cache" />

            <link rel="icon" type="image/png" href="logo/fede.ico" />
            <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.css"/>
            <link rel="stylesheet" href="foundation-6.4.2-complete/css/app.css"/>
            <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.min.css"/>
            <link rel="stylesheet"  href="foundation-6.4.2-complete/css/auxiliar.css"/>
            <link rel="stylesheet" href="CSS/CentrarCSV.css"/>
            <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>


            <!--
            To change this license header, choose License Headers in Project Properties.
            To change this template file, choose Tools | Templates
            and open the template in the editor.
            -->

            <meta charset="UTF-8"/>
            <title>DESEMBOLSOS - INGRESO DE DATOS FINIQUITO</title>
    </head>
    <body>
        <div style="text-align:center;"> 
            <img src="Imagenes/LogoCaja.jpg"/>

            <h2>FORMULARIO DE BUSQUEDA DE FINIQUITOS</h2>
            <h4>REGISTRADOS</h4>
            <h4>DESEMBOLSOS</h4>
        </div>
       <div style="text-align:center;">
    <p>Importar CSV a MySQL</p>
    <form action="InsertarCSVCol.php" method="post" enctype="multipart/form-data" style="display: inline-block;">
        <label for="csvFile" style="display: block; text-align: center;">Selecciona un archivo CSV:</label>
        <input type="file" id="csvFile" name="archivoCSV" accept=".csv" style="display: block; margin: 0 auto;"/><br>
        <input type="submit" class="button" value="Cargar CSV"/> 
    </form>
</div>

                            </body>
                            </html>
