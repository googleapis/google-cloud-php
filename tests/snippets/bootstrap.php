<?php

use Google\Cloud\Dev\Snippet\Container;
use Google\Cloud\Dev\Snippet\Coverage\Coverage;
use Google\Cloud\Dev\Snippet\Coverage\Scanner;
use Google\Cloud\Dev\Snippet\Parser\Parser;

require __DIR__ . '/../../vendor/autoload.php';

$parser = new Parser;
$scanner = new Scanner($parser, __DIR__ .'/../../src');
$coverage = new Coverage($scanner);
$coverage->buildListToCover();

Container::$coverage = $coverage;
Container::$parser = $parser;

register_shutdown_function(function () {
    $uncovered = Container::$coverage->uncovered();

    file_put_contents(__DIR__ .'/../../build/snippets-uncovered.json', json_encode($uncovered, JSON_PRETTY_PRINT));

    if (!empty($uncovered)) {
        echo sprintf('ERROR: %s uncovered snippets! See build/snippets-uncovered.json for a report.', count($uncovered));
        exit(1);
    }
});
