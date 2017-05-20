<?php

require __DIR__ . '/../../vendor/autoload.php';

function exception_error_handler($severity, $message, $file, $line) {
    //echo "Suppressed: $message\n";
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
//set_error_handler("exception_error_handler");
