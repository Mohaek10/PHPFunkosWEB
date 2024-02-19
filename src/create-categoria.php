<?php
use config\Config;
use service\FunkoService;
use service\CategoriaService;
use models\Funkos;
use models\Categoria;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/service/FunkoService.php';
require_once __DIR__ . '/service/CategoriaService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/models/Funkos.php';
require_once __DIR__ . '/service/SessionService.php';

$session = $sessionService = \service\SessionService::getInstance();
if (!$session->isAdmin()) {
    echo "<script>alert('No tienes permisos para acceder a esta página');window.location.href='index.php';</script>";
    exit;
}

$config = Config::getInstance();
$categoriaService = new CategoriaService($config->db);
$categorias = $categoriaService->findAll();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    if (empty($nombre)) {
        $errores[] = 'El nombre es obligatorio';
    }


    if (empty($errores)) {
        $categoria = new Categoria();
        $categoria->nombre = $nombre;
        try {
            $categoriaService->create($categoria);
            echo "<script>alert('Categoría creada correctamente');window.location.href='index.php';</script>";
            exit;
        } catch (Exception $e) {
            $errores[] = $e->getMessage();

        }

    }
}
?>

<!DOCTYPE html>
<html lang="es">
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
    <title>Crear Funko</title>
</head>
<body>
<?php require_once 'header.php'?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Crear Categoría</h1>
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
></script>
<style>
    @import url("https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800;900&display=swap");

    *,
    *::after,
    *::before {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html,
    body {
        height: 100%;
        min-height: 100vh;
    }

    body {
        font-family: "League Spartan", system-ui, sans-serif;
        font-size: 1.1rem;
        line-height: 1.2;
        background-color: #212121;
        color: #ddd;
    }



    .container {
        max-width: 960px;
    }
</style>
</body>
</html>



