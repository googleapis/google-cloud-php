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

namespace Google\Cloud\Tests\Snippets\Vision\Annotation;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation\Document;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group vision
 */
class DocumentTest extends SnippetTestCase
{
    private $info;
    private $document;

    public function setUp()
    {
        $this->info = [
            'pages' => [['foo' => 'bar']],
            'text' => 'hello world'
        ];
        $this->document = new Document($this->info);
    }

    public function testClass()
    {
        $connectionStub = $this->prophesize(ConnectionInterface::class);

        $connectionStub->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'fullTextAnnotation' => [[]]
                    ]
                ]
            ]);

        $snippet = $this->snippetFromClass(Document::class);
        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->replace(
            "__DIR__ . '/assets/the-constitution.jpg'",
            "'php://temp'"
        );
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($vision);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($vision, $connectionStub);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('document');
        $this->assertInstanceOf(Document::class, $res->returnVal());
    }

    public function testPages()
    {
        $snippet = $this->snippetFromMagicMethod(Document::class, 'pages');
        $snippet->addLocal('document', $this->document);

        $res = $snippet->invoke('pages');
        $this->assertEquals($this->info['pages'], $res->returnVal());
    }

    public function testText()
    {
        $snippet = $this->snippetFromMagicMethod(Document::class, 'text');
        $snippet->addLocal('document', $this->document);

        $res = $snippet->invoke('text');
        $this->assertEquals($this->info['text'], $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(Document::class, 'info');
        $snippet->addLocal('document', $this->document);

        $res = $snippet->invoke('info');
        $this->assertEquals($this->info, $res->returnVal());
    }
}
