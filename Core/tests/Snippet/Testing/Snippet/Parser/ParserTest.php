<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Snippets\Core\Testing\Snippet\Parser;

use Google\Cloud\Core\Testing\Snippet\Parser\Parser;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use phpDocumentor\Reflection\DocBlock;

/**
 * @group core
 */
class ParserTest extends SnippetTestCase
{
    private $parser;
    private $docBlock;
    private $classSnippet;
    private $methodSnippet;
    private $secondMethodSnippet;
    private $classExamples;
    private $methodExamples;
    private $allExamples;

    public function setUp()
    {
        $this->parser = new Parser();
        $this->docBlock = new DocBlock(null);
        $this->classSnippet = $this->parser->classExample(Parser::class);
        $this->methodSnippet = $this->parser->methodExample(Parser::class, 'methodExample');
        $this->secondMethodSnippet = $this->parser->methodExample(
            Parser::class, 'methodExample', 1);
        $this->classExamples = $this->parser->examplesFromClass($this->parser);
        $this->methodExamples = $this->parser->examplesFromMethod($this->parser, 'examplesFromMethod');
        $this->allExamples = $this->parser->allExamples($this->parser);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Parser::class);
        $res = $snippet->invoke('parser');
        $this->assertInstanceOf(Parser::class, $res->returnVal());
    }

    public function testClassExample()
    {
        $snippet = $this->snippetFromMethod(Parser::class, 'classExample');
        $snippet->addLocal('parser', $this->parser);

        $res = $snippet->invoke('snippet');
        $this->assertEquals($this->classSnippet, $res->returnVal());
    }

    public function testMethodExample()
    {
        $snippet = $this->snippetFromMethod(Parser::class, 'methodExample');
        $snippet->addLocal('parser', $this->parser);

        $res = $snippet->invoke('snippet');
        $this->assertEquals($this->methodSnippet, $res->returnVal());
    }

    public function testSecondMethodExample()
    {
        $snippet = $this->snippetFromMethod(Parser::class, 'methodExample', 1);
        $snippet->addLocal('parser', $this->parser);

        $res = $snippet->invoke('snippet');
        $this->assertEquals($this->secondMethodSnippet, $res->returnVal());
    }

    public function testExamplesFromClass()
    {
        $snippet = $this->snippetFromMethod(Parser::class, 'examplesFromClass');
        $snippet->addLocal('parser', $this->parser);

        $res = $snippet->invoke('examples');
        $this->assertEquals($this->classExamples, $res->returnVal());
    }

    public function testExamplesFromMethod()
    {
        $snippet = $this->snippetFromMethod(Parser::class, 'examplesFromMethod');
        $snippet->addLocal('parser', $this->parser);

        $res = $snippet->invoke('examples');
        $this->assertEquals($this->methodExamples, $res->returnVal());
    }

    public function testAllExamples()
    {
        $snippet = $this->snippetFromMethod(Parser::class, 'allExamples');
        $snippet->addLocal('parser', $this->parser);

        $res = $snippet->invoke('examples');
        $this->assertEquals($this->allExamples, $res->returnVal());
    }
}
