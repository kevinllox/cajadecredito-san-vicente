
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta http-equiv="cache-control" content="max-age=0" />
            <meta http-equiv="cache-control" content="no-cache" />
            <meta http-equiv="expires" content="0" />
            <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
            <meta http-equiv="pragma" content="no-cache" />
            
        <link rel="icon" type="image/png" href="logo/fede.ico" />
        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.css"/>
        <link rel="stylesheet" href="foundation-6.4.2-complete/css/app.css"/>
        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.min.css"/>
        <link rel="stylesheet"  href="foundation-6.4.2-complete/css/auxiliar.css"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="Validador/vanadium/vanadium.js"></script>
        <link rel="stylesheet" href="Validador/vanadium/style1.css"/>
        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/foundation.min.js"></script>
        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/what-input.js"></script>
          
        
	
</style>

        <!--
        To change this license header, choose License Headers in Project Properties.
        To change this template file, choose Tools | Templates
        and open the template in the editor.
        -->

        <meta charset="UTF-8">
            <title>FORMULARIO ACTUALIZACION BUSQUEDA</title>
    </head>
    <body>
        <div style="text-align:center;"> 
            <img src="Imagenes/LogoCaja.jpg"/>

            <h2>FORMULARIO DE BUSQUEDA DE INFORMACION</h2>
            <h4>INFORMACION DE CLIENTE PARA ACTUALIZACION</h4>
			<h4>FACTURA ELECRONICA</h4>
        </div>

        <form name="formIngresoInforPrestamoHipote" action="BusquedaDatos.php" method="POST">
            <fieldset>
                
                <label>Numero de DUI</label>
                <input type="text" name="NumBusquedaDUI"  placeholder="Ingresar numero de DUI" class=":required :max_length;9 :min_length;9 :number" id=":required" value=""/>
                </fieldset>
			<div style="text-align:center;"> 
                 <button type="submit" class="button">Enviar</button>
            </div>
        </form>
    </body>
</html>
