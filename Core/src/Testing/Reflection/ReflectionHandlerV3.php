<?php
/**
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
        return $docBlock->getText();
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
