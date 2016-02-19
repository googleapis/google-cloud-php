<?php

require 'DocGenerator.php';

$files = [
    'src/Storage/Bucket.php'
];

$generator = new DocGenerator($files);
$generator->generate();
