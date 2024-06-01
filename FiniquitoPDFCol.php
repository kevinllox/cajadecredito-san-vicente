<?php

include("conexion.php");
date_default_timezone_set('America/El_Salvador');
$fecha_actual = date("Y-m-d h:i:s");
setlocale(LC_TIME, "spanish");
setlocale(LC_MONETARY, 'en_US');

$diaActual = strftime("%d");
$mesActual = strftime("%B");
$anioActual = strftime("%Y");

// Verificar si se ha enviado el ID de finiquito
if (isset($_POST['idFiniquito'])) {
// Obtener el ID de finiquito enviado desde la página anterior
$idFiniquito = $_POST['idFiniquito'];
// Ahora puedes usar $idFiniquito para realizar consultas u otras operaciones en la base de datos, o para mostrar información en la página
// Por ejemplo, para mostrar el ID de finiquito:
//echo "ID de Finiquito: " . $idFiniquito;
$sqlMostFiniGuard = "SELECT *  FROM `finiquito` WHERE `IdFiniquito` = $idFiniquito";
$result = mysqli_query($con, $sqlMostFiniGuard);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($datosGuard = mysqli_fetch_assoc($result)) {
        $fechaDesembolso = $datosGuard["FechaDesembolso"];
        $salidaPDF = $datosGuard["RefCredito"];
      //  $formatMonto = $datosGuard["MontoRef"];
        $formatFechaDesem = strtotime($fechaDesembolso);
        $diaDesem = date("d", $formatFechaDesem);
        $mesDesem = strftime("%B", $formatFechaDesem);
        $anioDesem = date("Y", $formatFechaDesem);


        require('./fpdf/fpdf.php');

        class PDF extends FPDF {

            function Header() {
                $this->SetFont('Arial', 'B', 22);
                $this->Ln(25);
                $this->Cell(0, 10, 'FINIQUITO', 0, 1, 'C');
                $this->Image('logo/CAJA DE CREDITO DE SAN VICENTE_1.gif', 10, 10, 60);
            }

            function Footer() {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
            }

        }

// Crear instancia de PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, utf8_decode(''), 0, 'J');
        $pdf->MultiCell(0, 10, utf8_decode('El Infrascrito Coordinador de Créditos de la Caja de Crédito de San Vicente, Sociedad Cooperativa de Responsabilidad Limitada de Capital Variable, CERTIFICA QUE:'), 0, 'J');
        $pdf->Ln(4);
        $pdf->MultiCell(0, 10, utf8_decode($datosGuard['Cliente'] . ', con DUI N° ' . $datosGuard['DUICliente'] . ', CANCELÓ, el día 04 de septiembre de 2023, el préstamo a su nombre, con referencia No. ' . $salidaPDF . '; que la Caja de Crédito de San Vicente, le otorgó el 18 de agosto de 2018, por un monto de $' . number_format($datosGuard["MontoRef"], 2) . '.'), 0, 'J');
        $pdf->MultiCell(0, 10, utf8_decode('Por no tener saldo pendiente relacionado al préstamo No. ' . $salidaPDF . '; Y en atención al Art. 27 de las Normas Técnicas para la Autorización, Registro y Funcionamiento dey Funcionamiento de las Agencias de Información de Datos y de los Servicios de Información Sobre el Historial de Crédito de las Personas (NPR-30), Se extiende el presente FINIQUITO, en la ciudad y departamento de San Vicente, el día ' . $diaActual . ' de ' . $mesActual . ' de ' . $anioActual . '.'), 0, 'J');
        $pdf->Ln(5);
        $pdf->MultiCell(0, 10, utf8_decode('Atentamente.'), 0, 'J');
        $pdf->MultiCell(0, 10, utf8_decode('Caja de Credito de San Vicente'), 0, 'J');
        $pdf->Image('Imagenes/FirmaSello.png', 70, 180);
        $pdf->Ln(30);
        $pdf->MultiCell(0, 10, utf8_decode('Ing. Nelson Iban Portillo Martínez'), 0, 'C');
        $pdf->MultiCell(0, 10, utf8_decode('Coordinador de Creditos'), 0, 'C');

// Salida del PDF
        $pdf->Output('I', $salidaPDF);
    }
}
mysqli_close($con);

} else {
    // Si no se ha enviado el ID de finiquito, muestra un mensaje de error o redirige a otra página
    echo "No se ha recibido el datos de Finiquito.";
}
?>