<?php

use config\Config;
use service\SessionService;
use service\UsersService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/service/SessionService.php';
require_once __DIR__ . '/service/UsersService.php';
require_once __DIR__ . '/config/Config.php';

$session = SessionService::getInstance();
$config = Config::getInstance();
$errorMessage = '';
$usersService = new UsersService($config->db);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if(!$username || !$password) {
        $errorMessage = 'Todos los campos son obligatorios';
    } else {
        try {
            $user = $usersService->authenticate($username, $password);
            if ($user){
                $isAdmin = in_array('ADMIN', $user->roles);
                $session->login($user->username, $isAdmin);
                header('Location: index.php');
            } else {
                $errorMessage = 'Usuario o contraseña no válidos';
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet"/>
    <title>Login</title>
</head>
<body>
<?php require_once 'header.php'?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
                <?php if($errorMessage): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
