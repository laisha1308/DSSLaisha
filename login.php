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

    //Inicio de sesion
    $usuario = $_POST['userlogin'];
    $contrasena = md5($_POST['passwordlogin']);
    $code = $_POST['otp'];

    //Consulta
    $consulta = "SELECT username, passwords, is_verified FROM users WHERE username = '$usuario' AND passwords = '$contrasena' AND is_verified = 1";

    //Variable para comparar el resultado
    $resultado = mysqli_query($conexion, $consulta);
    $validacion = mysqli_num_rows($resultado);

    if($validacion) {
        header("Location: prueba.html");
    } else {
        header("Location: index.html");
    }
?>