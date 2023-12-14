<?php
/**
 * Copyright 2022 Google Inc.
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
     * Verifies that protobuf references and @see tags are properly formatted.
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
                // Invalid reference format
                if ('\\' !== $matches[1][0] || substr_count($matches[1], '\Google\\') > 1) {
                    $invalidRefs[] = $matches[1];
                }
            },
            $description
        );

        return $invalidRefs;
    }

    /**
     * Verifies that protobuf references and @see tags reference classes that exist.
     */
    private function getBrokenXrefs(string $description): array
    {
        $brokenRefs = [];
        preg_replace_callback(
            '/<xref uid="([^ ]*)"/',
            function ($matches) use (&$brokenRefs) {
                if (0 === strpos($matches[1], 'http')) {
                    return; // Valid external reference
                }
                if (in_array(
                    $matches[1],
                    ['\\' . AppEngineFlexFormatter::class, '\\' . AppEngineFlexFormatterV2::class])
                ) {
                    return; // We cannot run "class_exists" on these because they will throw a fatal error.
                }
                if (class_exists($matches[1]) || interface_exists($matches[1] || trait_exists($matches[1]))) {
                    return; // Valid class reference
                }
                if (false !== strpos($matches[1], '::')) {
                    if (false !== strpos($matches[1], '()')) {
                        list($class, $method) = explode('::', str_replace('()', '', $matches[1]));
                        if (method_exists($class, $method)) {
                            return; // Valid method reference
                        }
                        if ('Async' === substr($method, -5)) {
                            return; // Skip magic Async methods
                        }
                    } elseif (defined($matches[1])) {
                        return; // Valid constant reference
                    }
                }
                // empty hrefs show up as "\\"
                if ($matches[1] === '\\\\') {
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
