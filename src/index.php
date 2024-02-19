<?php
use config\Config;
use service\FunkoService;
use services\CategoriaService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/service/FunkoService.php';
require_once __DIR__ . '/service/CategoriaService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/models/Funkos.php';
require_once __DIR__ . '/service/SessionService.php';

$session = $sessionService = \service\SessionService::getInstance();
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
    <title>Funkos</title>
</head>
<body>
<?php require_once 'header.php'?>
<?php
$config = Config::getInstance();
?>

<main>
    <div class="container mt-3">

        <div class="row">
            <?php
            $search= $_GET['search'] ?? null;
            $funkoService = new FunkoService($config->db);
            $funkos = $funkoService->findAllWithCategoryName($search);
            ?>
            <?php foreach ($funkos as $funko): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($funko->imagen); ?>" class="card-img-top" alt="imagen">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($funko->nombre); ?></h5>
                            <span class="badge bg-primary">ID: <?php echo htmlspecialchars($funko->id); ?></span>
                            <p class="card-text">Categoria: <?php echo htmlspecialchars($funko->categoriaNombre); ?></p>
                            <p class="card-text">Precio: <?php echo htmlspecialchars($funko->precio); ?></p>
                            <p class="card-text">Cantidad: <?php echo htmlspecialchars($funko->cantidad); ?></p>
                            <a href="details.php?id=<?php echo $funko->id; ?>" class="btn btn-primary">Detalles</a>
                            <?php if($_SESSION['isAdmin']): ?>
                                <a href="edit.php?id=<?php echo $funko->id; ?>" class="btn btn-warning">Editar</a>
                                <a href="cambiar-imagen.php?id=<?php echo $funko->id; ?>" class="btn btn-warning">Cambiar Imagen</a>
                                <a href="delete.php?id=<?php echo $funko->id; ?>" class="btn btn-danger">Eliminar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if($_SESSION['isAdmin']): ?>
                <div class="col-md-12 mb-4 text-center">
                    <a href="add.php" class="btn btn-success">Añadir nuevo Funko</a>
                </div>
            <?php endif; ?>
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
</body>
</html>