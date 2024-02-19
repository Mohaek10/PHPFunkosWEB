<?php

use config\Config;
use service\FunkoService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/service/FunkoService.php';
require_once __DIR__ . '/models/Funkos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $config = Config::getInstance();

        $id = $_POST['id'];
        $uploadDir = $config->uploadPath;

        $archivo = $_FILES['imagen'];

        $nombre = $archivo['name'];
        $tipo = $archivo['type'];
        $tmpPath = $archivo['tmp_name'];
        $error = $archivo['error'];

        $allowedTypes = ['image/jpeg', 'image/png'];
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedType = finfo_file($fileInfo, $tmpPath);
        $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

        if (in_array($detectedType, $allowedTypes) && in_array($extension, $allowedExtensions)) {
            // Buscamos el producto por id

            $funcosService = new FunkoService($config->db);
            $funko = $funcosService->findById($id);
            if ($funko === null) {
                header('Location: index.php');
                exit;
            }
            $newName = uniqid() . '.' . $extension;

            move_uploaded_file($tmpPath, $uploadDir . $newName);
            $funko->imagen = $config->uploadUrl . $newName;
            $funcosService->update($funko);

            header('Location: update-image.php?id=' . $id);
            exit;
        }
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
