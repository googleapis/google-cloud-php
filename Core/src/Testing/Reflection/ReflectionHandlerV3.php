<?php

namespace Google\Cloud\Core\Testing\Reflection;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\FileReflector;

class ReflectionHandlerV3
{
    public function createDocBlock($class)
    {
        return new DocBlock($class);
    }

    /**
     * @return string
     */
    public function getDocBlockText(DocBlock $docBlock)
    {
        return  $docBlock->getText();
    }

    public function classes(array $files)
    {
        $classes = [];
        foreach ($files as $file) {
            $f = new FileReflector($file);
            $f->process();
            foreach ($f->getClasses() as $class) {
                $classes[] = $class->getName();
            }
        }
        return $classes;
    }
}