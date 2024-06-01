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
        <meta http-equiv="Expires" content="0">
            <meta http-equiv="Last-Modified" content="0">
                <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
                    <meta http-equiv="Pragma" content="no-cache">
                        <meta http-equiv="cache-control" content="max-age=0" />
                        <meta http-equiv="cache-control" content="no-cache" />

                        <link rel="icon" type="image/png" href="logo/fede.ico" />
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.css"/>
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/app.css"/>
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.min.css"/>
                        <link rel="stylesheet"  href="foundation-6.4.2-complete/css/auxiliar.css"/>
                        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
                        <script type="text/javascript" src="Validador/vanadium/vanadium.js"></script>
                        <link rel="stylesheet" href="Validador/vanadium/style1.css"/>
                        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/foundation.js"></script>
                        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/what-input.js"></script>

                        <script>
                            function mayus(e) {
                                e.value = e.value.toUpperCase();
                            }
                            $(document).foundation();

                        </script>  
                        <script src = "../js/jquery-3.3.1.js"></script>

                        <style>

                        </style>

                        <!--
                        To change this license header, choose License Headers in Project Properties.
                        To change this template file, choose Tools | Templates
                        and open the template in the editor.
                        -->

                        <meta charset="UTF-8">
                            <title>COLOCACIONES- INGRESO DE DATOS FINIQUITO</title>
                            </head>
                            <body>
                                <div style="text-align:center;"> 
                                    <img src="Imagenes/LogoCaja.jpg"/>

                                    <h2>FORMULARIO DE BUSQUEDA DE FINIQUITOS</h2>
                                    <h4>REGISTRADOS</h4>
                                    <h4>CREDITOS</h4>
                                </div>

                                <form name="formIngresoInforPrestamoHipote" action="GridFiniquitosClienteCol.php" method="POST">
                                    <fieldset>
                                        <label>Numero de DUI:</label>
                                        <input type="text" name="NumDUI"  placeholder="Ingresar n&uacute;mero de DUI sin guion" class=":required :min_length;9 :max_length;9 :number" id=":required" value=""/>

                                    </fieldset>

                                    <div style="text-align:center;"> 
                                        <button type="submit" class="button">Enviar</button>
                                    </div>
                                </form>
                            </body>
                            </html>
