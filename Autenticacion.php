<?php
session_start();

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las variables POST existen
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM userfini WHERE User = '$username'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Asumiendo que las contraseñas no están hashadas en la base de datos, comentar la siguiente línea
            // if (password_verify($password, $user['Pass'])) {
            if ($password == $user['Pass']) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "No existe el usuario.";
        }
    } else {
        echo "Por favor, rellene ambos campos.";
    }
}

mysqli_close($con);
?>
