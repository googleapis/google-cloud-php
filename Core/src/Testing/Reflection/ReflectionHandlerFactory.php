<?php

namespace Google\Cloud\Core\Testing\Reflection;

use phpDocumentor\Reflection\File\LocalFile;

/**
 * Class for determining if phpdocumentor/reflection v3 or v4 is being used.
 */
class ReflectionHandlerFactory
{
    /**
     * @return ReflectionHandlerV3|ReflectionHandlerV4
     */
    public static function create()
    {
        return class_exists(LocalFile::class)
            ? new ReflectionHandlerV4()
            : new ReflectionHandlerV3();
    }
}
