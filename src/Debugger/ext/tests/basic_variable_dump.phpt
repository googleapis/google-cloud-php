--TEST--
Stackdriver Debugger: Basic variable dump
--FILE--
<?php

// set a snapshot for line 16 in common.php
stackdriver_debugger_add_snapshot('common.php', 16);

require_once(__DIR__ . '/common.php');

$sum = loop(10);

echo "Sum is {$sum}\n";
?>
--EXPECT--
Sum is 45
