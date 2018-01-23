<?php

require_once __DIR__ . '/../vendor/autoload.php';

$agent = new Google\Cloud\Debugger\Agent(['sourceRoot' => realpath('../')]);

require 'app.php';
