<?php
$conn = new mysqli('localhost', 'root', '', 'bdactualizacion') or die(mysqli_error());	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta http-equiv="Expires" content="0">
                <meta http-equiv="Last-Modified" content="0">
                <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
                <meta http-equiv="Pragma" content="no-cache">
                <meta http-equiv="cache-control" content="max-age=0" />
                <meta http-equiv="cache-control" content="no-cache" />
                
        <link rel="icon" type="image/png" href="logo/fede.ico" />
        <link rel="stylesheet" href="../foundation-6.4.2-complete/css/foundation.css"/>
        <link rel="stylesheet" href="../foundation-6.4.2-complete/css/app.css"/>
        <link rel="stylesheet" href="../foundation-6.4.2-complete/css/foundation.min.css"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="Validador/vanadium/vanadium.js"></script>
        <link rel="stylesheet" href="Validador/vanadium/style1.css"/>
        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/foundation.js"></script>
        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/what-input.js"></script>
        
      
	<style>
	#cat
{  
float: left;
width:100 px;
height:50 px;   
}
</style>

        <!--
        To change this license header, choose License Headers in Project Properties.
        To change this template file, choose Tools | Templates
        and open the template in the editor.
        -->

        <meta charset="UTF-8">
            <title>FORMULARIO DE ACTUALIZACION INGRESO</title>
    </head>
    <body>
        <div style="text-align:center;"> 
            <img src="../Imagenes/LogoCaja.jpg"/>

            <h2>FORMULARIO DE INGRESO DE INFORMACION</h2>
            <h4>INFORMACION DE CLIENTE PARA ACTUALIZACION</h4>
			<h4>FACTURA ELECTRONICA</h4>
        </div>

        <form name="formIngresoInforPrestamoHipote" action="EnviaPruebasDatos.php" method="POST">
            <fieldset>
                <label>Fecha de Expedicion de DUI</label>
                <input type="text" name="FechaExpedeDUI"  placeholder="Ingresar fecha de expedicion" class=":required :date_au" id=":required"  value=""/>
                
			
			</fieldset>
  			
			<div style="text-align:center;"> 
                <button type="submit">Enviar</button>
            </div>
                   
        </form>
    </body>
</html>
