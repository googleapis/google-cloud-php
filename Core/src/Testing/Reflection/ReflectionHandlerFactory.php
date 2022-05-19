<?php

namespace Google\Cloud\Core\Testing\Reflection;

use phpDocumentor\Reflection\File\LocalFile;

class ReflectionHandlerFactory
{
    public static function create()
    {
        return class_exists(LocalFile::class)
            ? new ReflectionHandlerV4()
            : new ReflectionHandlerV3();
    }
}
