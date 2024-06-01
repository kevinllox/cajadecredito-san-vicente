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
            <link rel="stylesheet" href="CSS/ImagFonFirm.css">
        </head>
<?php
include("conexion.php");
date_default_timezone_set('America/El_Salvador');
$fecha_actual = date("Y-m-d h:i:s");
setlocale(LC_TIME, "spanish");
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


$sqlValidar = "SELECT `RefCredito` FROM `finiquito` WHERE `RefCredito`= '$creditCancelado'";
$resultVal = mysqli_query($con, $sqlValidar);
if (mysqli_num_rows($resultVal) > 0) {
    echo '<p class="alertdupli">Ya existe un finiquito para este credito '.$creditCancelado.'</p>';
} else {
    $sqlInserFiniDesem = "INSERT INTO `finiquito` (`Cliente`, `DUICliente`, `RefCredito`, `MontoRef`, `FechaDesembolso`, `FechaCancelacion`, `CorreoCliente`) VALUES"
            . " ('$nombreApeClient', '$numeroDUI', '$creditCancelado', '$montoCreditCance', '$fechaInserDesembolso', '$fecha_actual', '$correoElec')";

    if (mysqli_query($con, $sqlInserFiniDesem)) {
        echo'<script type="text/javascript"> alert("Finiquito Generado y Guardado");</script>';
    } else {
        echo "Error: " . $sqlInserFiniDesem . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);
    ?>
    

        <body class="finiquito">
            <img src="logo/CAJA DE CREDITO DE SAN VICENTE_1.gif" />

            <h2>FINIQUITO</h2>

            <p class="finiquito">El Infrascrito Coordinador de Créditos de la Caja de Crédito de San Vicente, Sociedad Cooperativa de Responsabilidad Limitada de Capital Variable, CERTIFICA QUE:</p>

            <p class="finiquito"><?php echo $nombreApeClient ?>; con DUI N°. <?php echo $numeroDUI ?>, CANCELO, el dia <?php echo strftime("%d") ?> de <?php echo strftime("%B") ?>
                del <?php echo strftime("%Y") ?>, el préstamo a su nombre, con referencia No. <?php echo $creditCancelado ?>; que la Caja de Crédito de San Vicente, 
                le otorgó en fecha <?php echo $diaDesem ?> de <?php echo $mesDesem ?> del <?php echo $anioDesem ?>, por un monto de $ <?php echo $montoCreditCance ?>.00</p>

            <p class="finiquito">Por no tener saldo pendiente relacionado al préstamo No. <?php echo $creditCancelado ?>; Y en atención al Art. 27 de las Normas Técnicas para la Autorización, 
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

        </body>
    </html>
    <?php
} 