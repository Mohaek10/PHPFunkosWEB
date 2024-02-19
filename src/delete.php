<?php

use config\Config;
use models\Funkos;
use service\FunkoService;
use service\SessionService;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/service/FunkoService.php';
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
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$funko = null;

if ($id===false) {
    echo "<script>alert('ID no válido');window.location.href='index.php';</script>";
    exit;
} else{
    $funko = $funkoService->findById($id);
    if ($funko===false) {
        echo "<script>alert('Funko no encontrado');window.location.href='index.php';</script>";
        exit;
    }
    if ($funko->imagen !== 'https://via.placeholder.com/150') {
        $imageUrl = $funko->imagen;
        $basePath = $config->uploadPath;
        $imagePathInUrl = parse_url($imageUrl, PHP_URL_PATH);
        $imageFile = basename($imagePathInUrl);
        $imageFilePath = $basePath . $imageFile;
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath);
        }
    }
    $funkoService->delete($id);
    echo "<script>alert('Funko eliminado correctamente');window.location.href='index.php';</script>";
}