<?php
    // Incluir el archivo de autoloading de Composer para cargar las clases de PHPMailer
    require_once 'vendor/autoload.php';
    // Importar las clases necesarias de PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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
    $consulta = "SELECT username, passwords, email, otp_secret FROM users WHERE username = '$usuario' AND passwords = '$contrasena'";

    //Variable para comparar el resultado
    $resultado = mysqli_query($conexion, $consulta);
    $validacion = mysqli_num_rows($resultado);

    if($validacion) {
        // Obtener la primera fila del resultado como un array asociativo
        $fila = mysqli_fetch_assoc($resultado);
        // Acceder [a los valores de 'email' y 'otp_secret'
        $us = $fila['username'];
        $co = $fila['email'];
        $os = $fila['otp_secret'];

        $mail = new PHPMailer();  // Crear una nueva instancia de PHPMailer
        $mail->isSMTP();  // Indicar que se usará SMTP
        $mail->Host       = 'sandbox.smtp.mailtrap.io';  // Cambiar dirección de servidor SMTP
        $mail->SMTPAuth   = true;  // Habilitar la autenticación SMTP
        $mail->Username   = '030eee859d8a7a';  // Cambiar nombre de usuario SMTP
        $mail->Password   = 'd2b485f437dbb7';  // Cambiar contraseña SMTP
        $mail->SMTPSecure = 'tls';  
        $mail->Port       = 2525;  // Puerto SMTP

        $mail->setFrom('noreply@test', 'SegundoFactor');  // Correo y nombre del remitente
        $mail->addAddress($co, $us);  // Correo y nombre del destinatario

        $mail->isHTML(true);  // El cuerpo del mensaje será HTML
        $mail->Subject = 'Codigo de verificacion';  // Asunto del correo
        $mail->Body    = 'Este es tu codigo de verificacion: ' . $os;  // Cuerpo del mensaje

        // Si el mensaje no fue enviado mostrar el error
        if (!$mail->send()) {
            return $mail->ErrorInfo;
        } else {
            $query = "UPDATE users SET is_verified = 1 WHERE username = '$usuario'"; // Cambiar a codigo verificado
            $resultado2 = mysqli_query($conexion, $query);
            header("Location: start.html");
        }
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
        header("Location: index.html");
    }
?>