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
        <title>Insertar CSV para Generar Varios Finiquitos</title>
        <link rel="icon" type="image/png" href="logo/fede.ico" />
        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.css"/>
        <link rel="stylesheet" href="foundation-6.4.2-complete/css/app.css"/>
        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.min.css"/>
        <link rel="stylesheet"  href="foundation-6.4.2-complete/css/auxiliar.css"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <div style="text-align:center;"> 
            <img src="Imagenes/LogoCaja.jpg"/>

            <h2>GENERACION DE FINIQUITOS POR MEDIO DE CSV</h2>
        </div>
        <div style="text-align:center;">
            <?php
            include("conexion.php");

// Función para verificar si un RefCredito ya existe en la tabla finiquito
            function verificarDuplicado($refCredito, $con) {
                $sql = "SELECT COUNT(*) AS count FROM finiquito WHERE RefCredito = '$refCredito'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['count'] > 0;
            }

// Función para eliminar el BOM de un archivo
            function eliminarBOM($str) {
                if (substr($str, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
                    return substr($str, 3);
                }
                return $str;
            }

// Validar si se ha enviado un archivo CSV
            if (isset($_FILES["archivoCSV"])) {
                // Cargar el archivo CSV
                $file = $_FILES["archivoCSV"]["tmp_name"];
                // Abrir el archivo CSV y eliminar el BOM si está presente
                if (($fp = fopen($file, "r")) !== FALSE) {
                    $content = fread($fp, filesize($file));
                    fclose($fp);

                    $content = eliminarBOM($content);

                    // Volver a escribir el archivo sin el BOM
                    if (($fp = fopen($file, "w")) !== FALSE) {
                        fwrite($fp, $content);
                        fclose($fp);
                    }
                }

                // Reabrir el archivo CSV después de eliminar el BOM
                if (($fp = fopen($file, "r")) !== FALSE) {
                    // Inicializar un arreglo para almacenar los RefCreditos del archivo CSV
                    $refCreditosCSV = array();

                    // Leer cada fila del archivo CSV y almacenar los RefCreditos en el arreglo
                    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                        $refCreditosCSV[] = $data[2]; // Suponiendo que el RefCredito está en la tercera columna (índice 2)
                    }

                    // Cerrar el archivo CSV
                    fclose($fp);

                    // Iterar sobre los RefCreditos del archivo CSV y verificar si existen en la tabla finiquito
                    foreach ($refCreditosCSV as $refCredito) {
                        if (verificarDuplicado($refCredito, $con)) {
                            echo "<h4>El RefCredito '$refCredito' ya está registrado. La carga del archivo CSV ha sido detenida.</h4>";
                            echo '<a href="formCargarCSV.php" class="button">Regresar</a>';
                            exit; // Detener la ejecución del script si se encuentra un duplicado
                        }
                    }

                    // Si no se encuentra ningún duplicado, continuar con la inserción de los datos en la tabla MySQL
                    // Volver a abrir el archivo CSV
                    if (($fp = fopen($file, "r")) !== FALSE) {
                        // Configurar la codificación del archivo CSV
                       // stream_filter_append($fp, 'convert.iconv.ISO-8859-1/UTF-8');
                        // Leer cada fila del archivo CSV
                        while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                            // Obtener los datos de la fila actual
                            $cliente = strtoupper($data[0]);
                            $dui = $data[1];
                            $refcredito = $data[2];
                            $montoRef = (int) $data[3]; // Convertir a entero
                            $fechaDesembolso = date('Y-m-d', strtotime($data[4])); // Formatear fecha, fecha de desembolso
                            $fechaDesemCance = date('Y-m-d', strtotime($data[5])); // Formatear fecha, fecha de cancelacion
                            // Insertar los datos en la tabla MySQL
                            $sql = "INSERT INTO `finiquito` (Cliente, DUICliente, RefCredito, MontoRef, FechaDesembolso, FechaCancelacion) 
                        VALUES ('$cliente', '$dui', '$refcredito', $montoRef, '$fechaDesembolso','$fechaDesemCance')";
                            mysqli_query($con, $sql);
                        }
                        mysqli_close($con);
                        // Cerrar el archivo CSV
                        fclose($fp);

                        // Mostrar un mensaje de éxito
                        echo "<h4>Los datos del archivo CSV se han importado correctamente.</h4>";
                        ?>
                        <script language="JavaScript">
                            function redireccionar() {
                                window.location.href = "index.php";
                            }
                            setTimeout("redireccionar()", 6000);
                        </script>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </body>
</html>