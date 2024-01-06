<?php

require_once __DIR__ . "/../../autoload.php";

use Isemary\AnyServiceManager\Configuration\Ini\FileConfigurator;
use Isemary\AnyServiceManager\Configuration\Ini\FileManager;

try {
    $file = $_POST['file'];
    $fileManager = new FileManager();

    $checkFileExists =  $fileManager->checkFileExists($file);

    if ($checkFileExists) {
        $fileConfigurator = new FileConfigurator();
        $fileOptions = $fileConfigurator->returnOptions($file);

        $response['status'] = 200;
        $response['data'] = $fileOptions;
    } else {
        $response['status'] = 404;
        $response['data'] = [];
    }
} catch (\Exception $e) {
    $response['status'] = 400;
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
