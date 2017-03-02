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
use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group vision
 */
class EntityTest extends SnippetTestCase
{
    private $entityData;
    private $entity;

    public function setUp()
    {
        $this->entityData = [
            'mid' => 'testMid',
            'locale' => 'testLocale',
            'description' => 'testDescription',
            'score' => 'testScore',
            'confidence' => 'testConfidence',
            'topicality' => 'testTopicality',
            'boundingPoly' => 'testBoundingPoly',
            'locations' => 'testLocations',
            'properties' => 'testProperties'
        ];

        $this->entity = new Entity($this->entityData);
    }

    public function testClass()
    {
        $connectionStub = $this->prophesize(ConnectionInterface::class);

        $connectionStub->annotate(Argument::any())
            ->willReturn([
                'responses' => [
                    [
                        'textAnnotations' => [[]]
                    ]
                ]
            ]);

        $snippet = $this->snippetFromClass(Entity::class);
        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->replace(
            "__DIR__ . '/assets/family-photo.jpg'",
            "'php://temp'"
        );
        $snippet->insertAfterLine(3, '$reflection = new \ReflectionClass($vision);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($vision, $connectionStub);
            $property->setAccessible(false);'
        );

        $res = $snippet->invoke('text');
        $this->assertInstanceOf(Entity::class, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'info');
        $snippet->addLocal('text', $this->entity);
        $this->assertEquals($this->entityData, $snippet->invoke('info')->returnVal());
    }

    public function testMid()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'mid');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['mid'], $res->output());
    }

    public function testLocale()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'locale');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['locale'], $res->output());
    }

    public function testDescription()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'description');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['description'], $res->output());
    }

    public function testScore()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'score');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['score'], $res->output());
    }

    public function testConfidence()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'confidence');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['confidence'], $res->output());
    }

    public function testTopicality()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'topicality');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['topicality'], $res->output());
    }

    public function testBoundingPoly()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'boundingPoly');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['boundingPoly'], $res->output());
    }

    public function testLocations()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'locations');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['locations'], $res->output());
    }

    public function testProperties()
    {
        $snippet = $this->snippetFromMagicMethod(Entity::class, 'properties');
        $snippet->addLocal('text', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals($this->entityData['properties'], $res->output());
    }
}
