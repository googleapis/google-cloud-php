<?php
/*
 * Copyright 2016, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\GAX;

use Exception;
use Countable;
use Jison\Segment;
use Jison\JisonParser;

require_once 'Segment.php';
require_once 'JisonParser.php';

// define globals so they can be accessed from JisonParser.php
$GLOBALS['gax_path_template_segment_count'] = 0;
$GLOBALS['gax_path_template_binding_count'] = 0;

class ValidationException extends Exception
{
}

class PathTemplate implements Countable
{
    private $segments;
    private $segmentCount;

    public function __construct($data)
    {
        $parser = new Parser();
        $this->segments = $parser->parse($data);
        $this->segmentCount = $parser->segmentCount;
    }

    public function __toString()
    {
        return self::format($this->segments);
    }

    public function count()
    {
        return $this->segmentCount;
    }

    /**
     * Renders a path template using the provided bindings.
     *
     * @param array $bindings An array matching var names to binding strings.
     *
     * @throws ValidationException if a key isn't provided or if a sub-template
     *    can't be parsed.
     *
     * @return string A rendered representation of this path template.
     */
    public function render($bindings)
    {
        $out = [];
        $binding = false;
        foreach ($this->segments as $segment) {
            if ($segment->kind == Segment::BINDING) {
                if (!array_key_exists($segment->literal, $bindings)) {
                    throw new ValidationException(
                        sprintf(
                            'render error: value for key "%s" not '.
                            'provided',
                            $segment->literal));
                }
                $out = array_merge($out,
                    (new self($bindings[$segment->literal]))->segments);
                $binding = true;
            } elseif ($segment->kind == Segment::END_BINDING) {
                $binding = false;
            } else {
                if ($binding) {
                    continue;
                }
                array_push($out, $segment);
            }
        }
        $path = self::format($out);
        $this->match($path);

        return $path;
    }

    /**
     * Matches a fully qualified path template string.
     *
     * @param string $path A fully qualified path template string.
     *
     * @throws ValidationException if path can't be matched to the template.
     *
     * @return array Array matching var names to binding values.
     */
    public function match($path)
    {
        $segments = $this->segments;
        $pathList = explode('/', $path);
        $currentVar = null;
        $bindings = [];
        $segmentCount = $this->segmentCount;
        $pathIndex = 0;
        foreach ($segments as $segment) {
            if ($pathIndex >= count($pathList)) {
                break;
            }
            if ($segment->kind == Segment::TERMINAL) {
                $pathItem = $pathList[$pathIndex];
                if ($segment->literal == '*') {
                    $bindings[$currentVar] = $pathItem;
                    $pathIndex += 1;
                } elseif ($segment->literal == '**') {
                    $length = count($pathList) - $segmentCount + 1;
                    $segmentCount += count($pathList) - $segmentCount;
                    $bindings[$currentVar] = implode('/',
                        array_slice($pathList, $pathIndex, $length));
                    $pathIndex += $length;
                } elseif ($segment->literal != $pathItem) {
                    throw new ValidationException(
                        sprintf(
                            'mismatched literal: "%s" != "%s"',
                            $segment->literal,
                            $pathItem));
                } else {
                    $pathIndex += 1;
                }
            } elseif ($segment->kind == Segment::BINDING) {
                $currentVar = $segment->literal;
            }
        }
        if (($pathIndex != count($pathList)) || ($pathIndex != $segmentCount)) {
            throw new ValidationException(
                sprintf(
                    'match error: could not render a path template '.
                    'from %s',
                    $path));
        }

        return $bindings;
    }

    private static function format($segments)
    {
        $template = '';
        $slash = true;
        foreach ($segments as $segment) {
            if ($segment->kind == Segment::TERMINAL) {
                if ($slash) {
                    $template .= '/';
                }
                $template .= $segment->literal;
            }
            $slash = true;
            if ($segment->kind == Segment::BINDING) {
                $template .= sprintf('/{%s=', $segment->literal);
                $slash = false;
            }
            if ($segment->kind == Segment::END_BINDING) {
                $template .= sprintf('%s}', $segment->literal);
            }
        }
        // Remove leading '/'
        return substr($template, 1);
    }
}

class Parser
{
    private $parser = null;

    public $segmentCount = 0;
    public $bindingVarCount = 0;

    public function __construct()
    {
        $this->parser = new JisonParser();
    }

    /**
     * Returns an array of path template segments parsed from data.
     *
     * @param string $data A path template string
     *
     * @throws ValidationException when $data cannot be parsed
     *
     * @return array An array of Segment
     */
    public function parse($data)
    {
        try {
            $GLOBALS['gax_path_template_segment_count'] = 0;
            $GLOBALS['gax_path_template_binding_count'] = 0;
            $segments = $this->parser->parse($data);
            $this->segmentCount = $GLOBALS['gax_path_template_segment_count'];
            $this->bindingVarCount = $GLOBALS['gax_path_template_binding_count'];
            // Validation step: checks that there are no nested bindings.
            $pathWildcard = false;
            foreach ($segments as $segment) {
                if ($segment->kind == Segment::TERMINAL &&
                        $segment->literal == '**') {
                    if ($pathWildcard) {
                        throw new ValidationException(
                            'validation error: path template cannot contain '.
                            'more than one path wildcard');
                    }
                    $pathWildcard = true;
                }
            }

            return $segments;
        } catch (Exception $e) {
            throw new ValidationException('Exception in parser', 0, $e);
        }
    }
}
