<?php

function getInputArgs()
{
    global $argv;

    if (!isset($argv[1])) {
        throw new \RuntimeException('must provide database name.');
    }

    if (!isset($argv[2])) {
        throw new \RuntimeException('must provide table name.');
    }

    if (!isset($argv[3])) {
        throw new \RuntimeException('must provide row id.');
    }

    array_shift($argv);
    return $argv;
}

function setupIterationTracker($tmpFile)
{
    $pid = getmypid();
    register_shutdown_function(function () use ($tmpFile, $pid) {
        if ($pid !== getmypid()) return;

        $h = fopen($tmpFile, 'r+');
        flock($h, LOCK_UN);

        unlink($tmpFile);
    });

    file_put_contents($tmpFile, '0');
}

function updateIterationTracker($tmpFile, $iterations)
{
    $fp = fopen($tmpFile, 'c+');
    if (flock($fp, LOCK_EX)) {
        fseek($fp, 0);
        $val = (int) fread($fp, 900);
        $val = $val + $iterations;

        fseek($fp, 0);
        fwrite($fp, $val);

        flock($fp, LOCK_UN);
    }
}
