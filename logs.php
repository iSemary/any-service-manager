<?php
require_once "./autoload.php";

$template = $twig->load('pages/logs.twig');
echo $template->render([
    'title' => 'Logs',
]);
