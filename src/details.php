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
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($funko->imagen); ?>" class="img-fluid" alt="imagen">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($funko->nombre); ?></h2>
                <p>ID: <?php echo htmlspecialchars($funko->id); ?></p>
                <p>Categoria: <?php echo htmlspecialchars($funko->categoria); ?></p>
                <p>Precio: <?php echo htmlspecialchars($funko->precio); ?></p>
                <p>Cantidad: <?php echo htmlspecialchars($funko->cantidad); ?></p>
                <a href="index.php" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
