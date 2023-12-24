<?php
require_once "./autoload.php";

$template = $twig->load('index.twig');
echo $template->render([
    'title' => 'Twig Example',
    'content' => 'This is a simple example of using Twig in PHP.'
]);
