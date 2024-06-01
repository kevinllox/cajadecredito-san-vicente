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
        <link rel="stylesheet" href="CSS/MostrarAdvertencias.css"/>
             
        
    </head>
    <div style="text-align:center;"> 
                                    <img src="Imagenes/LogoCaja.jpg"/>

                                    <h2>FINIQUITO GUARDADO Y REGISTRADO</h2>
                                 
                                    <h4>DESEMBOLSOS</h4>
                                </div>
    <body>
        <?php
        include("conexion.php");
        //Establece la zona horaria a "America/El_Salvador" y 
        //obtiene la fecha y hora actual en el formato "Y-m-d h:i:s".
        date_default_timezone_set('America/El_Salvador');
        $fecha_actual = date("Y-m-d h:i:s");
        //Configura el locale a español.
        setlocale(LC_TIME, "spanish");
        //Obtiene los datos enviados por el método POST desde un formulario web, 
        //incluyendo el nombre y apellido del cliente, 
        //el número de DUI, el crédito cancelado, el monto del crédito cancelado, 
        //el correo electrónico, y la fecha de desembolso del crédito.
        $nombreApeClient = ($_POST['NomApeCliente']);
        $numeroDUI = ($_POST['NumDUI']);
        $creditCancelado = ($_POST['CreditCancelado']);
        $montoCreditCance = ($_POST['MontoCreditCance']);
        $correoElec = ($_POST['CorreoElec']);
        $fechaDesembolso = ($_POST['FechaDesembolso']);
        $formatFechaDesem = strtotime($fechaDesembolso);
        $fechaInserDesembolso = date('Y-m-d', $formatFechaDesem);
        $diaDesem = date("d", $formatFechaDesem);
        $mesDesem = strftime("%B", $formatFechaDesem);
        $anioDesem = date("Y", $formatFechaDesem);
//Valida 
        if ($fecha_actual <= $fechaInserDesembolso) {
            echo '<p class="alert alert-danger">La fecha de desembolso del crédito cancelado no puede ser posterior a la fecha actual.</p>';
            echo '<p class="alert alert-danger">Por favor, verifica en Bankworks la fecha en la que se otorgó el crédito referencia ' . $creditCancelado . '</p>';
        } else {


            //Valida si ya existe un registro en la base de datos para el crédito cancelado. 
            //Si existe, muestra un mensaje de alerta.
            $sqlValidar = "SELECT `RefCredito` FROM `finiquito` WHERE `RefCredito`= '$creditCancelado'";
            $resultVal = mysqli_query($con, $sqlValidar);
            if (mysqli_num_rows($resultVal) > 0) {
                echo '<p class="alert alert-danger">Ya existe un finiquito para este credito ' . $creditCancelado . '</p>';
                echo'<p class="alert alert-warning"> Si deseas consultarlo puedes dar click al siguiente enlace <a href="formFiniquitoClienteDesem.php">Buscar</a> ;</p>';
            } else {
                //Si no existe un registro para el crédito cancelado, realiza una inserción en la 
                //tabla "finiquito" de la base de datos con los datos proporcionados.
                $sqlInserFiniDesem = "INSERT INTO `finiquito` (`Cliente`, `DUICliente`, `RefCredito`, `MontoRef`, `FechaDesembolso`, `FechaCancelacion`, `CorreoCliente`) VALUES"
                        . " ('$nombreApeClient', '$numeroDUI', '$creditCancelado', '$montoCreditCance', '$fechaInserDesembolso', '$fecha_actual', '$correoElec')";

                if (mysqli_query($con, $sqlInserFiniDesem)) {
                    //Si la inserción es exitosa, muestra un mensaje indicando que el finiquito para el crédito fue generado,
                    // y proporciona un enlace para consultar el finiquito generado.
                    echo'<p alert alert-warning> El finiquito para el credito ' . $creditCancelado . ' esta generado.</p>';
                    echo'<p class="alert alert-warning"> Si deseas consultarlo puedes dar click al siguiente enlace <a href="formFiniquitoClienteDesem.php">Buscar</a> ;</p>';
                } else {
                    //Si ocurre un error durante la inserción, 
                    //muestra un mensaje de error junto con detalles del error.
                    echo "Error: " . $sqlInserFiniDesem . "<br>" . mysqli_error($con);
                }

                mysqli_close($con);
            }
            ?>


        </body>
    </html>
    <?php
} 