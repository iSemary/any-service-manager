<?php
// Include vendor autoload
require_once __DIR__.'/vendor/autoload.php';

// Load .env file from the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create a Twig loader and environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/resources/template');
$twig = new \Twig\Environment($loader);
