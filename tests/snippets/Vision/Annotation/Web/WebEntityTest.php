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

namespace Google\Cloud\Tests\Snippets\Vision\Annotation\Web;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation\Web\WebEntity;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group vision
 */
class WebEntityTest extends SnippetTestCase
{
    private $info;
    private $entity;

    public function setUp()
    {
        $this->info = [
            'entityId' => 'foo',
            'score' => 0.1,
            'description' => 'bar'
        ];
        $this->entity = new WebEntity($this->info);
    }

    public function testClass()
    {
        $connectionStub = $this->prophesize(ConnectionInterface::class);

        $connectionStub->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'webDetection' => [
                            'webEntities' => [
                                []
                            ]
                        ]
                    ]
                ]
            ]);

        $snippet = $this->snippetFromClass(WebEntity::class);
        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->replace(
            "__DIR__ . '/assets/eiffel-tower.jpg'",
            "'php://temp'"
        );
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($vision);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($vision, $connectionStub);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('firstEntity');
        $this->assertInstanceOf(WebEntity::class, $res->returnVal());
    }

    public function testEntityId()
    {
        $snippet = $this->snippetFromMagicMethod(WebEntity::class, 'entityId');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('id');
        $this->assertEquals($this->info['entityId'], $res->returnVal());
    }

    public function testScore()
    {
        $snippet = $this->snippetFromMagicMethod(WebEntity::class, 'score');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('score');
        $this->assertEquals($this->info['score'], $res->returnVal());
    }

    public function testDescription()
    {
        $snippet = $this->snippetFromMagicMethod(WebEntity::class, 'description');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('description');
        $this->assertEquals($this->info['description'], $res->returnVal());
    }
}
