<?php

require_once "../autoload.php";

use Isemary\AnyServiceManager\Manager\Manager;

try {
    $packagesStatus = (new Manager)->checkPackagesStatus();

    $response['status'] = 200;
    $response['data'] = $packagesStatus;
} catch (\Exception $e) {
    $response['status'] = 400;
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
