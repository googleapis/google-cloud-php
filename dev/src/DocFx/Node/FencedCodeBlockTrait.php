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

namespace Google\Cloud\Dev\DocFx\Node;

/**
 * @internal
 */
trait FencedCodeBlockTrait
{
    /**
     * Adds "php" to an open fenced codeblock which does not have a language
     * (e.x. ``` => ```php)
     */
    private function addPhpLanguageHintToFencedCodeBlock(string $description): string
    {
        return preg_replace_callback(
            '/^(\s+)?```(\w+)?\n((.|\n)*)\n^(\s+)?```$/mU',
            function ($matches) {
                list($codeblock, $leadingWhitespace, $existingTypehint, $contents, $_, $trailingWhitespace) = $matches + [5 => ''];
                if ($existingTypehint) {
                    return $codeblock;
                }
                return sprintf("%s```php\n%s\n%s```",
                    $leadingWhitespace,
                    $contents,
                    $trailingWhitespace
                );
            },
            $description
        );
    }
}
