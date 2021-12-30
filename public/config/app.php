<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

// load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../../.env');
$dotenv->load();
