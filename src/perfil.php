<?php
use config\Config;
use service\SessionService;
use service\UsersService;
use models\User;
require_once 'vendor/autoload.php';

require_once 'config/Config.php';
require_once 'service/SessionService.php';
require_once 'service/UsersService.php';
$session = SessionService::getInstance();
$config = Config::getInstance();
$userService = new UsersService($config->db);
$user =new User();

if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$username = $session->getUsername();
$user = $userService->showUserInfo($username);
$lastLoginDate = $session->getLastLoginDate();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil</title>
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
            <h2 class="text-center mb-4">Perfil de Usuario</h2>
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>"
                       disabled>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $user->nombre; ?>"
                       disabled>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos"
                       value="<?php echo $user->apellidos; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>"
                       disabled>
            </div>
            <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <input type="text" class="form-control" id="roles" name="roles"
                       value="<?php echo implode(', ', $user->roles); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="createdDate" class="form-label text-muted">Fecha de creación</label>
                <input type="text" class="form-control" id="createdDate" name="createdDate"
                       value="<?php echo $user->createdAt; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="lastLoginDate" class="form-label text-muted">Último acceso</label>
                <input type="text" class="form-control" id="lastLoginDate" name="lastLoginDate"
                       value="<?php echo $lastLoginDate; ?>" disabled>
            </div>
        </div>
    </div>
</div>
</body>
</html>
