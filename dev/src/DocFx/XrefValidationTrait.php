<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Dev\DocFx;

use Google\Cloud\Core\Logger\AppEngineFlexFormatter;
use Google\Cloud\Core\Logger\AppEngineFlexFormatterV2;

/**
 * @internal
 */
trait XrefValidationTrait
{
    /**
     * Verifies that all class references and @see tags are properly formatted
     * with either an FQSEN (Fully Qualified Structural Element Name), or a URL.
     */
    private function getInvalidXrefs(string $description): array
    {
        $invalidRefs = [];
        preg_replace_callback(
            '/<xref uid="([^ ]*)"/',
            function ($matches) use (&$invalidRefs) {
                // Valid external reference
                if (0 === strpos($matches[1], 'http')) {
                    return;
                }
                // Invalid reference format (not an FQSEN)
                if ('\\' !== $matches[1][0]) {
                    $invalidRefs[] = $matches[1];
                    return;
                }
                // Invalid FQSEN (If it contains "\Google\" more than once, it wasn't properly imported)
                if (substr_count($matches[1], '\Google\\') > 1) {
                    $invalidRefs[] = $matches[1];
                    return;
                }
            },
            $description
        );

        return $invalidRefs;
    }

    /**
     * Verifies that all class references and @see tags contain references to classes, methods, and
     * constants which actually exist.
     */
    private function getBrokenXrefs(string $description): array
    {
        $brokenRefs = [];
        preg_replace_callback(
            '/<xref uid="([^ ]*)"/',
            function ($matches) use (&$brokenRefs) {
                // Valid external reference
                if (0 === strpos($matches[1], 'http')) {
                    return;
                }
                // We cannot run "class_exists" on these classes because they will throw a fatal error.
                if (in_array(
                    $matches[1],
                    ['\\' . AppEngineFlexFormatter::class, '\\' . AppEngineFlexFormatterV2::class]
                )) {
                    return;
                }
                // Valid class reference
                if (class_exists($matches[1]) || interface_exists($matches[1] || trait_exists($matches[1]))) {
                    return;
                }
                // Valid method, magic method, andd constant references
                if (false !== strpos($matches[1], '::')) {
                    if (false !== strpos($matches[1], '()')) {
                        list($class, $method) = explode('::', str_replace('()', '', $matches[1]));
                        // Valid method reference
                        if (method_exists($class, $method)) {
                            return;
                        }

                        // Assume it's a magic Async method
                        if ('Async' === substr($method, -5)) {
                            return;
                        }

                    } elseif (defined($matches[1])) {
                        // Valid constant reference
                        return;
                    }
                }
                // Invalid reference!
                if ($matches[1] === '\\\\') {
                    // empty hrefs show up as "\\"
                    $brokenRefs[] = null;
                } else {
                    $brokenRefs[] = $matches[1];
                }
            },
            $description
        );

        return $brokenRefs;
    }
}
