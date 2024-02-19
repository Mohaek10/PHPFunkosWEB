<?php

use config\Config;
use service\SessionService;
use service\UsersService;
use models\User;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/service/SessionService.php';
require_once __DIR__ . '/service/UsersService.php';
require_once __DIR__ . '/config/Config.php';

$session = SessionService::getInstance();
$config = Config::getInstance();
$errorMessage = [];
$usersService = new UsersService($config->db);
//Crear usuario si no hay una sesion activa
if ($session->isLoggedIn()) {
    header('Location: index.php');
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

        if (empty($username) || empty($password) || empty($nombre) || empty($apellidos) || empty($email)) {
            $errorMessage['datos'] = 'Todos los campos son obligatorios';
        }
        if ($password !== $password2) {
            $errorMessage['password'] = 'Las contraseñas no coinciden';
        }
        if (strlen($password) < 8) {
            $errorMessage['password'] = 'La contraseña debe tener al menos 8 caracteres';
        }
        if (count($errorMessage) === 0) {
            $usuarioNuevo = new User();
            $usuarioNuevo->username = $username;
            $usuarioNuevo->password = $password;
            $usuarioNuevo->nombre = $nombre;
            $usuarioNuevo->apellidos = $apellidos;
            $usuarioNuevo->email = $email;

            try {
                $usersService->registrarse($usuarioNuevo);
                echo '<div class="modal fade" id="loginSuccessModal" tabindex="-1" aria-labelledby="loginSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginSuccessModalLabel">Inicio de sesión exitoso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Has iniciado sesión correctamente.
      </div>
      <div class="modal-footer">
        <a href="index.php" class="btn btn-secondary">Cerrar</a>
      </div>
    </div>
  </div>
</div>';
                unset($_SESSION['loggedIn']);
            } catch (Exception $e) {
                $error = $e->getMessage();
                $errorMessage['error'] = $error;
                echo "<script>
                alert('Error en el registro' . $error);  
                </script>";
            }


        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet"/>
</head>
<body>
<?php require_once 'header.php' ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Registro de Usuario</h2>
            <form action="SignUp.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="text-danger">
                    <?php
                    if (isset($errorMessage['datos'])) {
                        echo $errorMessage['datos'];
                    }
                    ?>
                    <?php
                    if (isset($errorMessage['password'])) {
                        echo $errorMessage['password'];
                    }
                    ?>
                    <?php
                    if (isset($errorMessage['error'])) {
                        echo $errorMessage['error'];
                    }
                    ?>

                </div>
                <button type="submit" class="btn btn-primary">Registrarse</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        let loginSuccessModal = document.getElementById('loginSuccessModal');
        if (loginSuccessModal) {
            let bsModal = new bootstrap.Modal(loginSuccessModal);
            bsModal.show();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
</body>
</html>

