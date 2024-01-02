<?php
require_once __DIR__ . "/../../autoload.php";

use Isemary\AnyServiceManager\Manager\Manager;

try {
    $package = $_POST['package'];
    $manager = new Manager();
    $checkPackage =  $manager->isValidPackage($package);

    if ($checkPackage) {
        $packageNamespace = $manager->packagesNamespace . $package;
        $packageInstance = new $packageNamespace();
        $purgeStatus = $packageInstance->purge();

        $response['status'] = 200;
        $response['data'] = $purgeStatus;
    } else {
        $response['status'] = 404;
        $response['data'] = [];
    }
} catch (\Exception $e) {
    $response['status'] = 400;
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
