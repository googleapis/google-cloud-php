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

namespace Google\Cloud\Language\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Language\Annotation;
use Google\Cloud\Language\Connection\ConnectionInterface;
use Google\Cloud\Language\LanguageClient;
use Prophecy\Argument;

/**
 * @group language
 */
class AnnotationTest extends SnippetTestCase
{
    private $annotation;
    private $info;

    public function set_up()
    {
        $this->info = [
            'categories' => [
                [
                    'name' => 'my-category',
                    'confidence' => .99
                ]
            ],
            'sentences' => [
                [
                    'text' => [
                        'content' => 'hello world'
                    ]
                ]
            ],
            'tokens' => [
                [
                    'text' => [
                        'content' => 'hello world'
                    ],
                    'partOfSpeech' => [
                        'tag' => 'NOUN'
                    ],
                    'dependencyEdge' => [
                        'label' => 'P'
                    ],
                    'lemma' => 'foo'
                ]
            ],
            'entities' => [
                [
                    'type' => 'PERSON',
                    'name' => 'somebody'
                ]
            ],
            'language' => 'en-us',
            'documentSentiment' => [
                'score' => 999
            ]
        ];
        $this->annotation = new Annotation($this->info);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Annotation::class);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->annotateText(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $language = TestHelpers::stub(LanguageClient::class);
        $language->___setProperty('connection', $connection->reveal());

        $snippet->replace('$language = new LanguageClient();', '');
        $snippet->addLocal('language', $language);

        $res = $snippet->invoke('annotation');
        $this->assertInstanceOf(Annotation::class, $res->returnVal());
    }

    public function testSentences()
    {
        $snippet = $this->snippetFromMagicMethod(Annotation::class, 'sentences');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['sentences'][0]['text']['content'], $res->output());
    }

    public function testTokens()
    {
        $snippet = $this->snippetFromMagicMethod(Annotation::class, 'tokens');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['tokens'][0]['text']['content'], $res->output());
    }

    public function testEntities()
    {
        $snippet = $this->snippetFromMagicMethod(Annotation::class, 'entities');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['entities'][0]['type'], $res->output());
    }

    public function testCategories()
    {
        $snippet = $this->snippetFromMagicMethod(Annotation::class, 'categories');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['categories'][0]['name'], $res->output());
    }

    public function testLanguage()
    {
        $snippet = $this->snippetFromMagicMethod(Annotation::class, 'language');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['language'], $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'info');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke('info');

        $this->assertEquals($this->info, $res->returnVal());
    }

    public function testSentiment()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'sentiment');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals('This is a positive message.', $res->output());
    }

    public function testTokensByTag()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'tokensByTag');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['tokens'][0]['lemma'], $res->output());
    }

    public function testTokensByLabel()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'tokensByLabel');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['tokens'][0]['lemma'], $res->output());
    }

    public function testEntitiesByType()
    {
        $snippet = $this->snippetFromMethod(Annotation::class, 'entitiesByType');
        $snippet->addLocal('annotation', $this->annotation);
        $res = $snippet->invoke();
        $this->assertEquals($this->info['entities'][0]['name'], $res->output());
    }
}
