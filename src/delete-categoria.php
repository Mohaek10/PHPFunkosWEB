<?php
use config\Config;
use service\SessionService;
use service\CategoriaService;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/service/CategoriaService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/models/Categoria.php';
require_once __DIR__ . '/service/SessionService.php';

$session = $sessionService = \service\SessionService::getInstance();
if (!$session->isAdmin()) {
    echo "<script>alert('No tienes permisos para acceder a esta página');window.location.href='index.php';</script>";
    exit;
}

$config = Config::getInstance();
$categoriaService = new CategoriaService($config->db);
$id = filter_input(INPUT_GET, 'id');
$categoria = null;

if ($id===false) {
    echo "<script>alert('ID no válido');window.location.href='index.php';</script>";
    exit;
} else{
    $categoria = $categoriaService->findById($id);
    if ($categoria===false) {
        echo "<script>alert('Categoría no encontrada');window.location.href='index.php';</script>";
        exit;
    }
    $categoriaService->deleteLogical($id);
    echo "<script>alert('Categoría eliminada correctamente');window.location.href='index.php';</script>";
}
