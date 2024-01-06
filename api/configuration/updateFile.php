<?php

require_once __DIR__ . "/../../autoload.php";

use Isemary\AnyServiceManager\Configuration\Ini\FileConfigurator;
use Isemary\AnyServiceManager\Configuration\Ini\FileManager;

try {
    $file = $_POST['file'];
    $fileManager = new FileManager();

    $checkFileExists =  $fileManager->checkFileExists($file);

    if ($checkFileExists) {
        $options = $_POST['options'];
        $fileConfigurator = new FileConfigurator();

        $writeFileStatus = $fileConfigurator->writeFile($file, $options);

        $response['status'] = 200;
        $response['message'] = $writeFileStatus['message'];
    } else {
        $response['status'] = 404;
        $response['message'] = [];
    }
} catch (\Exception $e) {
    $response['status'] = 400;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
