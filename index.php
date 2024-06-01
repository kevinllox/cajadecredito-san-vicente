<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: formulario_login.html");
    exit();
}

echo "Bienvenido, " . $_SESSION['username'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="CSS/Botones.css"/>
    </head>
    <body>
         <a href="cerrarsesion.php">Cerrar sesión</a>
          <div style="text-align:center;"> 
                                    <img src="Imagenes/LogoCaja.jpg"/>
                                     <h2>BIENVENIDOS AL APLICATIVO FINIQUITO EXPRESS</h2>
          </div>
       
        <div id="outer">
            <div class="button_slide slide_down"><a class="fcc-btn" href="formIngresoClienteDesem.php">Finiquito Desembolso</a></div>
            <br /> <br /><br />
            <div class="button_slide slide_right"><a class="fcc-btn" href="formCargarCSVCol.php">Finiquito Lotes</a></div>
            <br /> <br /><br />
            <div class="button_slide slide_left"><a class="fcc-btn" href="formFiniquitoClienteCol.php">Buscar Finiquito</a></div>
            <br /> <br /><br />
<!--            <div class="button_slide slide_diagonal">BUTTON: SLIDE DIAGONAL </div>
            <br /> <br /><br />-->
        </div>
       
    </body>
</html>
