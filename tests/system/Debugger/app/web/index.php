<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OpenCensus\Trace\Tracer;
use OpenCensus\Trace\Exporter\StackdriverExporter;

$agent = new Google\Cloud\Debugger\Agent(['sourceRoot' => realpath('../')]);

Tracer::start(new StackdriverExporter());

require 'app.php';
