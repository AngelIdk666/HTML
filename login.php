<?php
session_start();
include 'lib/config.php';

// Redirigir al usuario si ya está logueado
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Procesar el formulario de inicio de sesión
if (isset($_POST['login'])) {
    $usuario = trim(strip_tags($_POST['usuario']));
    $contrasena = md5(trim(strip_tags($_POST['contrasena'])));

    // Preparar y ejecutar la consulta usando mysqli
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?");
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();
    $contar = $result->num_rows;

    // Validar credenciales del usuario
    if ($contar == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id'] = $row['id_use'];
        header('Location: index.php');
        exit();
    } else {
        // Mostrar mensaje de error si las credenciales no son válidas
        echo '
        <br><div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Los datos ingresados no son correctos.
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bienvenido a FOROTEC</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    
    <!-- Compatibilidad con IE9 o inferior -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>FOROTEC</b></a>
        </div>
        <!-- /.login-logo -->

        <div class="login-box-body">
            <p class="login-box-msg">Bienvenido a FOROTEC</p>

            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Usuario" name="usuario" pattern="[A-Za-z0-9_-]{1,20}" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" pattern="[A-Za-z0-9_-]{1,20}" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
                    </div>
                </div>
            </form>

            <br>

            <a href="#">Olvidé mi contraseña</a><br>
            <a href="registro.php" class="text-center">Registrarme en FOROTEC</a>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- Scripts -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // opcional
            });
        });
    </script>
</body>
</html>
