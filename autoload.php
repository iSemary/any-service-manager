<?php

include_once './vendor/autoload.php';

// Create a Twig loader and environment
$loader = new \Twig\Loader\FilesystemLoader('resources/template');
$twig = new \Twig\Environment($loader);

