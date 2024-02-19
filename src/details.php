<?php
use config\Config;
use service\SessionService;
use service\FunkoService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/service/SessionService.php';
require_once __DIR__ . '/service/FunkoService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/models/Funkos.php';

$session = $sessionService = \service\SessionService::getInstance();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$funko=null;

if ($id===false) {
    header('Location: index.php');
} else{
    $config = Config::getInstance();
    $funkoService = new FunkoService($config->db);
    $funko = $funkoService->findById($id);
    if (!$funko){
        header('Location: index.php');
        exit;
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
    <title>Detalles</title>
</head>
<body>
<?php require_once 'header.php'?>
<main>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($funko->imagen); ?>" class="img-fluid rounded shadow" alt="imagen">
            </div>
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($funko->nombre); ?></h2>
                <div class="details">
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($funko->id); ?></p>
                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($funko->categoriaNombre); ?></p>
                    <p><strong>Precio:</strong> <?php echo htmlspecialchars($funko->precio); ?></p>
                    <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($funko->cantidad); ?></p>
                    <p><strong>Fecha de creación:</strong> <?php echo htmlspecialchars($funko->createdat); ?></p>
                    <p><strong>Fecha de actualización:</strong> <?php echo htmlspecialchars($funko->updatedat); ?></p>
                </div>
                <a href="index.php" class="btn btn-primary">Volver</a>
            </div>
        </div>
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
<style>

    .container {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgb(255, 255, 255);
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

</style>
</body>
</html>

