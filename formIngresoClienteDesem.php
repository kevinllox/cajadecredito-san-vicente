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
                            <title>DESEMBOLSOS - INGRESO DE DATOS FINIQUITO</title>
                            </head>
                            <body>
                                <div style="text-align:center;"> 
                                    <img src="Imagenes/LogoCaja.jpg"/>

                                    <h2>FORMULARIO DE INGRESO DE INFORMACION</h2>
                                    <h4>PARA REGISTRAR Y CREAR FINIQUITO</h4>
                                    <h4>DESEMBOLSOS</h4>
                                </div>

                                <form name="formIngresoInforPrestamoHipote" action="FiniquitoDesemGenerar.php" method="POST">
                                    <fieldset>
                                        <label>Nombres y Apellidos del Cliente:</label>
                                        <input type="text" name="NomApeCliente"  placeholder="Ingrese nombres y Apellidos del cliente seg&uacute;n DUI" class=":required :alpha" id=":required" value="" onkeyup="mayus(this);"/>
                                        <label>Numero de DUI:</label>
                                         <input type="text" name="NumDUI"  placeholder="Ingresar n&uacute;mero de DUI sin guion" class=":required :min_length;9 :max_length;9 :number" id=":required" value=""/>
                                        <!-- <label>Fecha de Cancelacion del Prestamo:</label>
                                        <input type="text" name="FechaCancelacion"  placeholder="Ingresar fecha de expedici&oacute;n" class=":required :date_au"  value=""/>-->
                                        <label>Credito Cancelado</label>
                                        <input type="text" name="CreditCancelado"  placeholder="Ingresar direcci&oacute;n" class=":required :Prestamo :max_length;12" id=":required" value="" onkeyup="mayus(this);"/>
                                        <label>Monto de Credito Cancelado:</label>
                                        <input type="text" name="MontoCreditCance"  placeholder="Ingresar correo electr&oacute;nico" class=":required" id=":required" value=""/>
                                        <label>Correo Electr&oacute;nico:</label>
                                        <input type="text" name="CorreoElec"  placeholder="Ingresar correo electr&oacute;nico" class=":required :email" id=":required" value=""/>
                                        <label>Fecha de Desembolso del Prestamo Cancelado:</label>
                                        <input type="text" name="FechaDesembolso"  placeholder="Ingresar fecha de expedici&oacute;n" class=":required :date_au"  value=""/>
                                    </fieldset>
                                   
                                    <div style="text-align:center;"> 
                                        <button type="submit" class="button">Enviar</button>
                                    </div>
                                </form>
                            </body>
                            </html>
