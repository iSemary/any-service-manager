<?php
require_once __DIR__ . "/../../autoload.php";

use Isemary\AnyServiceManager\Logger\Logger;
use Isemary\AnyServiceManager\Manager\Manager;


$response = ['status' => 400, 'data' => null];

try {
    $package = $_POST['package'];
    $manager = new Manager();
    $isValidPackage =  $manager->isValidPackage($package);

    if (!$isValidPackage) {
        throw new InvalidArgumentException('Invalid package.');
    }

    $log = (new Logger)->returnLog($package);
    $response['status'] = 200;
    $response['data'] = str_replace(['\n', '\r'], "<br/>",  $log['data']);
} catch (InvalidArgumentException $e) {
    $response['status'] = 400;
    $response['error'] = $e->getMessage();
} catch (\Exception $e) {
    $response['status'] = 400;
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
