<?php
use config\Config;
use service\FunkoService;
use service\SessionService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/service/FunkoService.php';
require_once __DIR__ . '/models/Funkos.php';
require_once __DIR__ . '/service/SessionService.php';

$session = $sessionService = \service\SessionService::getInstance();
if (!$session->isAdmin()) {
    echo "<script>alert('No tienes permisos para acceder a esta página');window.location.href='index.php';</script>";
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$funko=null;

if ($id===null || $id===false) {
    echo "<script>alert('No se ha encontrado el funko');window.location.href='index.php';</script>";
    exit;
} else {
    $config = Config::getInstance();
    $funkoService = new FunkoService($config->db);
    $funko = $funkoService->findById($id);
    if ($funko===null) {
        echo "<script>alert('No se ha encontrado el funko');window.location.href='index.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Funko</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet"/>
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgb(255, 255, 255);
            margin-top: 50px;
        }

        h1 {
            color: #ffffff;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .card {
            background-color: #333;
            border: none;
            box-shadow: 0 4px 6px rgb(255, 255, 255);
            padding: 20px;
            margin-bottom: 20px;
        }
        .dl-horizontal{
            color: #dddddd;

        }
        .form-group label {
            color: #ffffff;
            font-weight: bold;
        }



        .card-title {
            color: #ffffff;
            font-weight: bold;
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
        }
    </style>
</head>
<body>
<?php require_once 'header.php' ?>
<main class="container">
    <h1>Actualizar Funko</h1>

    <div class="card">
        <h2 class="card-title">Datos del Funko</h2>
        <dl class="dl-horizontal">
            <dt>Nombre:</dt>
            <dd><?php echo htmlspecialchars($funko->nombre); ?></dd>
            <dt>Precio:</dt>
            <dd><?php echo htmlspecialchars($funko->precio); ?></dd>
            <dt>Cantidad:</dt>
            <dd><?php echo htmlspecialchars($funko->cantidad); ?></dd>
            <dt>Categoria:</dt>
            <dd><?php echo htmlspecialchars($funko->categoriaNombre); ?></dd>
            <dt>Imagen:</dt>
            <dd><img src="<?php echo htmlspecialchars($funko->imagen); ?>" alt="imagen"></dd>
        </dl>
        <form  action="update_image_file.php" enctype="multipart/form-data" method="post">
            <div class="form-group m-3 ">
                <label for="imagen">Imagen:</label>
                <input accept="image/*" class="form-control-file" id="imagen" name="imagen" required type="file">
                <small class="text-danger"></small>
                <input name="id" value="<?php echo $id; ?>" type="hidden">
            </div>

            <button class="btn btn-primary" type="submit">Actualizar</button>
            <a class="btn btn-secondary mx-2" href="index.php">Volver</a>

        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
></script>
</body>
</html>