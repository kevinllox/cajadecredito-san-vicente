<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />
    <body>
        <?php
        require("conexion.php");


        date_default_timezone_set('America/El_Salvador');
        $fecha_actual = date("Y-m-d h:i:s");

        $nombreClien = ($_POST['NomCliente']);
        $apellidoClien = ($_POST['ApellCliente']);
        $numeroDUI = ($_POST['NumDUI']);

        //Recibimos campo fecha de formulario y la pasamos
        //de string a date
        $rebexpeFechaDUIClien = ($_POST['FechaExpedeDUI']);
        $expeFechaDUI = strtotime($rebexpeFechaDUIClien);
        $formatExpDUIFecha = date('Y-m-d', $expeFechaDUI);
        //Calculamos fecha de expiracion
        $fecha = date_create($rebexpeFechaDUIClien);
        date_add($fecha, date_interval_create_from_date_string('2921 days'));
        $expiFechaDUI = date_format($fecha, 'Y-m-d');

        $direccionClien = ($_POST['Direccion']);
        $departaClien = ($_POST['id_deparatamento']);
        $muniClien = ($_POST['municipio']);
        $correoClien = ($_POST['CorreoElec']);
        $telefonoClien = ($_POST['Telefono']);
        if (isset($_POST['Ahorro'])) {
            $ahorroCliente = 1;
        } else {
            $ahorroCliente = 0;
        }
        if (isset($_POST['DepoPlazo'])) {
            $depoplazoCliente = 2;
        } else {
            $depoplazoCliente = 0;
        }
        if (isset($_POST['Credito'])) {
            $creditoCliente = 3;
        } else {
            $creditoCliente = 0;
        }
        if (isset($_POST['Remesa'])) {
            $remesaCliente = 4;
        } else {
            $remesaCliente = 0;
        }
        if (isset($_POST['TarjCredi'])) {
            $tarjCrediCliente = 5;
        } else {
            $tarjCrediCliente = 0;
        }
        if (isset($_POST['Acciones'])) {
            $accionCliente = 6;
        } else {
            $accionCliente = 0;
        }

        switch ($departaClien) {
            case 1:
                $departaClien = 'Ahuachapan';
                break;
            case 2:
                $departaClien = 'Santa Ana';
                break;
            case 3:
                $departaClien = 'Sonsonate';
                break;
            case 4:
                $departaClien = 'La Libertad';
                break;
            case 5:
                $departaClien = 'Chalatenango';
                break;
            case 6:
                $departaClien = 'San Salvador';
                break;
            case 7:
                $departaClien = 'Cuscatlan';
                break;
            case 8:
                $departaClien = 'La Paz';
                break;
            case 9:
                $departaClien = 'Cabañas';
                break;
            case 10:
                $departaClien = 'San Vicente';
                break;
            case 11:
                $departaClien = 'Usulutan';
                break;
            case 12:
                $departaClien = 'Morazan';
                break;
            case 13:
                $departaClien = 'San Miguel';
                break;
            case 14:
                $departaClien = 'La Union';
                break;
        }

            echo "Fecha de proceso " . $fecha_actual . "<br>";
            echo "Nombres del Cliente " . $nombreClien . "<br>";
            echo "Apellidos del Cliente " . $apellidoClien . "<br>";
            echo "Numero de DUI " . $numeroDUI . "<br>";
            echo "Fecha de Expedicion de DUI " . $formatExpDUIFecha . "<br>";
            echo "Fecha de Expiracion de DUI " . $expiFechaDUI . "<br>";
            echo "Direccion de Cliente " . $direccionClien . "<br>";
            echo "Departamento de Cliente " . strtoupper($departaClien) . "<br>";
            echo "Municipio de Cliente " . utf8_decode(strtoupper($muniClien)) . "<br>";
            echo "Correo Electronico " . $correoClien . "<br>";
            echo "Telefono de Cliente " . $telefonoClien . "<br>";
            echo "Valor de Ahorro " . $ahorroCliente . "<br>";
            echo "Valor de Deposito a plazo " . $depoplazoCliente . "<br>";
            echo "Valor de Credito " . $creditoCliente . "<br>";
            echo "Valor de Remesa " . $remesaCliente . "<br>";
            echo "Valor de Tarjeta de Credito " . $tarjCrediCliente . "<br>";
            echo "Valor de Acciones " . $accionCliente . "<br>";
            
           

            $sql = "INSERT INTO `bdactualizacion`.`datosclientes` (`NomCliente`, `ApeCliente`, `NumDUI`, `DUIFechaExpe`, `DUIFechaExpi`, `DirecCliente`, `Departamento`, `Municipio`, `CorreoCliente`, `TelMovilCliente`,`AhorroCliente`,`CrediCliente`, `TarjCrediCliente`, `DepoPlazoCliente`, `RemeCliente`, `AccioCliente`,`User`, `FechaIngreso`) VALUES "
                    . "('$nombreClien','$apellidoClien', '$numeroDUI', '$formatExpDUIFecha', '$expiFechaDUI', '$direccionClien','$departaClien', '$muniClien','$correoClien','$telefonoClien','$ahorroCliente','$creditoCliente','$tarjCrediCliente','$depoplazoCliente','$remesaCliente','$accionCliente','BEACASTILLO','$fecha_actual')";

            if (mysqli_query($con, $sql)) {
                echo "Registros del cliente " . $numeroDUI . " se a registrado para actualizacion";
                $sec=5;
                header("refresh: $sec; url = formBusquedaClienteWebPage.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
        



        mysqli_close($con);
        ?>
    </head>
</body>
</html>