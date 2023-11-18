<?php
    //Conexion con base de datos
    $servername = 'localhost';
    $database = 'login';
    $username = 'root';
    $password = '';
    $conexion = mysqli_connect($servername, $username, $password, $database);

    if(!$conexion) {
        die("Conexion fallida: ".mysqli_connect_error());
    }

    //Registro
    $usuario = $_POST['user'];
    $contrasena = md5($_POST['password']);
    $correo = $_POST['email'];
    // Generar un código de verificación
    $otp_secret = bin2hex(random_bytes(8));

    //Insercion
    $consulta = "INSERT INTO users (username, passwords, email, otp_secret) VALUES ('$usuario', '$contrasena', '$correo', '$otp_secret');";

    //Variable para comparar el resultado
    $resultado = mysqli_query($conexion, $consulta);

    if($resultado) {
        header("Location: index.html");
    }
?>