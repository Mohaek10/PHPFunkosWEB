<?php

use config\Config;
use service\SessionService;
use service\FunkoService;
use models\Funkos;
use models\Categoria;
use service\CategoriaService;

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
$funkoService = new FunkoService($config->db);
$categoriaService = new CategoriaService($config->db);
$categorias = $categoriaService->findAll();
$errores = [];
$funko = null;

$funkoId = -1;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $funkoId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!$funkoId) {
        echo "<script>alert('No se ha encontrado el funko');window.location.href='index.php';</script>";
        exit;
    }
    try {
        $funko = $funkoService->findById($funkoId);
    } catch (Exception $e) {
        echo "<script>alert('No se ha encontrado el funko');window.location.href='index.php';</script>";
        exit;
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $funkoId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $categoria = $categoriaService->findByName($categoria);
    if (!$categoria) {
        $errores['categoria'] = 'La categoria no existe';
    }
    if (empty($nombre)) {
        $errores['nombre'] = 'El nombre no puede estar vacío';
    }

    if (!isset($precio) || $precio === '') {
        $errores['precio'] = 'El precio es obligatorio.';
    } elseif ($precio < 0) {
        $errores['precio'] = 'El precio no puede ser negativo.';
    }
    if (!isset($cantidad) || $cantidad === '') {
        $errores['cantidad'] = 'La cantidad es obligatoria.';
    } elseif ($cantidad < 0) {
        $errores['cantidad'] = 'La cantidad no puede ser negativa.';
    }

    if (count($errores) === 0) {
        $funko = new Funkos();
        $funko->nombre = $nombre;
        $funko->precio = $precio;
        $funko->cantidad = $cantidad;
        $funko->categoriaId = $categoria->id;
        $funko->id = $funkoId;
        $imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING);
        $funko->imagen = $imagen;

        try {
            $funkoService->update($funko);
            echo "<script>alert('Funko actualizado correctamente');window.location.href='index.php';</script>";
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Ha ocurrido un error al actualizar el funko ' );</script>";
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
    <title>Editar Funko</title>
</head>
<body>
<?php require_once 'header.php' ?>

<main class="main flow">
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <h1>Editar Funko con ID: <?php echo $funko->id ?> </h1>
                <form action="edit.php" method="post">

                    <input type="hidden" name="id" value="<?php echo $funkoId ?>">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                               value="<?php echo htmlspecialchars($funko->nombre); ?>">
                        <?php if (isset($errores['nombre'])): ?>
                            <small class="text-danger"><?php echo $errores['nombre']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" min="0" class="form-control" id="precio" name="precio"
                               value="<?php echo htmlspecialchars($funko->precio); ?>">
                        <?php if (isset($errores['precio'])): ?>
                            <small class="text-danger"><?php echo $errores['precio']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad"  class="form-label">Cantidad</label>
                        <input type="number" min="0" step="0.0 " required class="form-control" id="cantidad" name="cantidad"
                               value="<?php echo htmlspecialchars($funko->cantidad); ?>">
                        <?php if (isset($errores['cantidad'])): ?>
                            <small class="text-danger"><?php echo $errores['cantidad']; ?></small>
                        <?php endif; ?>
                    </div>
                    <!--Imagen -->
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="text" disabled readonly required class="form-control" id="imagen" name="imagen"
                               value="<?php echo htmlspecialchars($funko->imagen); ?>">
                        <?php if (isset($errores['imagen'])): ?>
                            <small class="text-danger"><?php echo $errores['imagen']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="categoria"  class="form-label">Categoria</label>
                        <select class="form-select" required id="categoria" name="categoria">
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->nombre; ?>"
                                    <?php if ($funko->categoriaNombre === $categoria->nombre) {
                                        echo 'selected';
                                    } ?>
                                ><?php echo $categoria->nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errores['categoria'])): ?>
                            <small class="text-danger"><?php echo $errores['categoria']; ?></small>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="index.php" class="btn btn-secondary">Volver</a>
                </form>
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

        line-height: 1.2;
        background-color: #212121;
        color: #ddd;
    }


    .main {
        max-width: 75rem;
        padding: 3em 1.5em;
    }


</style>
</body>
</html>




