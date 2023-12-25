<?php
require_once "./autoload.php";

$template = $twig->load('pages/logs.twig');
echo $template->render([
    'title' => 'Logs',
    'content' => 'This is a simple example of using Twig in PHP.'
]);
