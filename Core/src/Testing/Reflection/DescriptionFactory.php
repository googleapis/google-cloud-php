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

declare(strict_types=1);

/**
 * This file has been copied from PHP Documentor in order to override
 * some of the behavior which was resulting in unwanted behavior.
 * @see https://github.com/phpDocumentor/ReflectionDocBlock/issues/274
 *
 * @link      http://phpdoc.org
 */

namespace Google\Cloud\Core\Testing\Reflection;

use function count;
use function explode;
use function implode;
use function ltrim;
use function min;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory as BaseDescriptionFactory;
use phpDocumentor\Reflection\DocBlock\TagFactory;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use phpDocumentor\Reflection\Utils;
use const PREG_SPLIT_DELIM_CAPTURE;
use function str_replace;
use function strlen;
use function strpos;
use function substr;
use function trim;

/**
 * Creates a new Description object given a body of text.
 *
 * Descriptions in phpDocumentor are somewhat complex entities as they can contain one or more tags inside their
 * body that can be replaced with a readable output. The replacing is done by passing a Formatter object to the
 * Description object's `render` method.
 *
 * In addition to the above does a Description support two types of escape sequences:
 *
 * 1. `{@}` to escape the `@` character to prevent it from being interpreted as part of a tag, i.e. `{{@}link}`
 * 2. `{}` to escape the `}` character, this can be used if you want to use the `}` character in the description
 *    of an inline tag.
 *
 * If a body consists of multiple lines then this factory will also remove any superfluous whitespace at the beginning
 * of each line while maintaining any indentation that is used. This will prevent formatting parsers from tripping
 * over unexpected spaces as can be observed with tag descriptions.
 *
 * @internal
 */
class DescriptionFactory extends BaseDescriptionFactory
{
    /** @var TagFactory */
    private $tagFactory;

    /**
     * Initializes this factory with the means to construct (inline) tags.
     */
    public function __construct(TagFactory $tagFactory)
    {
        $this->tagFactory = $tagFactory;
    }

    public function getTagFactory()
    {
        return $this->tagFactory;
    }

    /**
     * Returns the parsed text of this description.
     */
    public function create(string $contents, ?TypeContext $context = null): Description
    {
        $tokens   = $this->lex($contents);
        $count    = count($tokens);
        $tagCount = 0;
        $tags     = [];

        for ($i = 1; $i < $count; $i += 2) {
            $tags[]     = $this->tagFactory->create($tokens[$i], $context);
            $tokens[$i] = '%' . ++$tagCount . '$s';
        }

        //In order to allow "literal" inline tags, the otherwise invalid
        //sequence "{@}" is changed to "@", and "{}" is changed to "}".
        //"%" is escaped to "%%" because of vsprintf.
        //See unit tests for examples.
        for ($i = 0; $i < $count; $i += 2) {
            // @TODO: Modified the following line so that "{}" is not replaced
            // with "}". So far we have not seen any adverse effects
            // $tokens[$i] = str_replace(['{@}', '{}', '%'], ['@', '}', '%%'], $tokens[$i]);
            $tokens[$i] = str_replace(['{@}', '%'], ['@', '%%'], $tokens[$i]);
        }

        return new Description(implode('', $tokens), $tags);
    }

    /**
     * Strips the contents from superfluous whitespace and splits the description into a series of tokens.
     *
     * @return string[] A series of tokens of which the description text is composed.
     */
    private function lex(string $contents): array
    {
        $contents = $this->removeSuperfluousStartingWhitespace($contents);

        // performance optimalization; if there is no inline tag, don't bother splitting it up.
        if (strpos($contents, '{@') === false) {
            return [$contents];
        }

        return Utils::pregSplit(
            '/\{
                # "{@}" is not a valid inline tag. This ensures that we do not treat it as one, but treat it literally.
                (?!@\})
                # We want to capture the whole tag line, but without the inline tag delimiters.
                (\@
                    # Match everything up to the next delimiter.
                    [^{}]*
                    # Nested inline tag content should not be captured, or it will appear in the result separately.
                    (?:
                        # Match nested inline tags.
                        (?:
                            # Because we did not catch the tag delimiters earlier, we must be explicit with them here.
                            # Notice that this also matches "{}", as a way to later introduce it as an escape sequence.
                            \{(?1)?\}
                            |
                            # Make sure we match hanging "{".
                            \{
                        )
                        # Match content after the nested inline tag.
                        [^{}]*
                    )* # If there are more inline tags, match them as well. We use "*" since there may not be any
                       # nested inline tags.
                )
            \}/Sux',
            $contents,
            0,
            PREG_SPLIT_DELIM_CAPTURE
        );
    }

    /**
     * Removes the superfluous from a multi-line description.
     *
     * When a description has more than one line then it can happen that the second and subsequent lines have an
     * additional indentation. This is commonly in use with tags like this:
     *
     *     {@}since 1.1.0 This is an example
     *         description where we have an
     *         indentation in the second and
     *         subsequent lines.
     *
     * If we do not normalize the indentation then we have superfluous whitespace on the second and subsequent
     * lines and this may cause rendering issues when, for example, using a Markdown converter.
     */
    private function removeSuperfluousStartingWhitespace(string $contents): string
    {
        $lines = explode("\n", $contents);

        // if there is only one line then we don't have lines with superfluous whitespace and
        // can use the contents as-is
        if (count($lines) <= 1) {
            return $contents;
        }

        // determine how many whitespace characters need to be stripped
        $startingSpaceCount = 9999999;
        for ($i = 1, $iMax = count($lines); $i < $iMax; ++$i) {
            // lines with a no length do not count as they are not indented at all
            if (trim($lines[$i]) === '') {
                continue;
            }

            // determine the number of prefixing spaces by checking the difference in line length before and after
            // an ltrim
            $startingSpaceCount = min($startingSpaceCount, strlen($lines[$i]) - strlen(ltrim($lines[$i])));
        }

        // strip the number of spaces from each line
        if ($startingSpaceCount > 0) {
            for ($i = 1, $iMax = count($lines); $i < $iMax; ++$i) {
                $lines[$i] = substr($lines[$i], $startingSpaceCount);
            }
        }

        return implode("\n", $lines);
    }
}
