<?php

require_once __DIR__ . '/../vendor/autoload.php';

$configuration = require_once __DIR__ . '/../config/dev.php';
$application = require __DIR__ . '/../app.php';
$application->run();