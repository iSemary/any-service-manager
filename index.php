<?php
require_once "./autoload.php";

$template = $twig->load('index.twig');


echo $template->render([
    'title' => 'Dashboard'. $_ENV['ROOT_PASSWORD'],
    'content' => 'This is a simple example of using Twig in PHP.'
]);