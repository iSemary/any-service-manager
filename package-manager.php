<?php
require_once "./autoload.php";

$template = $twig->load('pages/package-manager.twig');
echo $template->render([
    'title' => 'Package Manager',
]);
