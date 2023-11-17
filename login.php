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

    //Consulta
    $consulta = "SELECT username, passwords FROM users WHERE username = '$usuario' AND passwords = '$contrasena'";

    //Variable para comparar el resultado
    $resultado = mysqli_query($conexion, $consulta);
    $validacion = mysqli_num_rows($resultado);

    if($validacion) {
        header("Location: prueba.html");
    } else {
        echo "$hash";
        header("Location: index.html");
    }
?>