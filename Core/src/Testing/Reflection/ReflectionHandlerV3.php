<?php

namespace Google\Cloud\Core\Testing\Reflection;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\FileReflector;

/**
 * Class for running snippets using phpdocumentor/reflection:v3
 */
class ReflectionHandlerV3
{
    /**
     * @param string $class
     * @return DocBlock
     */
    public function createDocBlock($class)
    {
        return new DocBlock($class);
    }

    /**
     * @param DocBlock $docBlock
     * @return string
     */
    public function getDocBlockText(DocBlock $docBlock)
    {
        return  $docBlock->getText();
    }

    /**
     * @param array $files
     * @return string[]
     */
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