<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php
// Verifica si se ha enviado un archivo
if(isset($_POST["submit"])) {
    // Ruta donde se almacenará el archivo CSV
    $directorio = "uploads/";
    $archivo_csv = $directorio . basename($_FILES["archivo"]["name"]);
    $tipo_archivo = strtolower(pathinfo($archivo_csv,PATHINFO_EXTENSION));

    // Verifica si el archivo es un archivo CSV
    if($tipo_archivo == "csv") {
        // Mueve el archivo al directorio de uploads
        if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo_csv)) {
            // Procesa el archivo CSV
            if (($gestor = fopen($archivo_csv, "r")) !== FALSE) {
                // Abre la conexión a la base de datos (modificar según tus credenciales)
               include("conexion.php");

                // Prepara la consulta para insertar los datos en la base de datos
                $consulta = "INSERT INTO `finiquito` (`Cliente`, `DUICliente`, `RefCredito`, `MontoRef`, `FechaDesembolso`, `FechaCancelacion`, `CorreoCliente`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $declaracion = mysqli_prepare($con, $consulta);
                mysqli_stmt_bind_param($declaracion, "sssssssss", $nombre, $cliente, $dui_cliente, $ref_credito, $monto_ref, $fecha_desembolso, $fecha_cancelacion, $correo_cliente);

                // Itera sobre cada línea del archivo CSV
                while (($fila = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                    $nombre = $fila[0];
                    $cliente = $fila[1];
                    $dui_cliente = $fila[3];
                    $ref_credito = $fila[4];
                    $monto_ref = $fila[5];
                    $fecha_desembolso = $fila[6];
                    $fecha_cancelacion = $fila[7];
                    $correo_cliente = $fila[8];
                    
                    // Ejecuta la consulta
                    mysqli_stmt_execute($declaracion);
                }

                // Cierra la declaración y la conexión
                mysqli_stmt_close($declaracion);
                mysqli_close($con);

                echo "Archivo CSV subido y procesado correctamente.";
            } else {
                echo "Error al abrir el archivo CSV.";
            }
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "El archivo no es un archivo CSV válido.";
    }
}
?>


    </body>
</html>
