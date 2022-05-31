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

namespace Google\Cloud\Datastore\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Prophecy\Argument;

/**
 * @group datastore
 */
class EntityTest extends SnippetTestCase
{
    private $options;
    private $entity;
    private $key;

    public function set_up()
    {
        $this->options = [
            'cursor' => 'foo',
            'baseVersion' => 1234,
            'populatedByService' => true,
            'meanings' => ['foo']
        ];

        $this->key = new Key('my-awesome-project', [
            'path' => [
                'kind' => 'Person',
                'name' => 'Bob'
            ]
        ]);

        $this->entity = new Entity($this->key, [], $this->options);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Entity::class);

        $res = $snippet->invoke('entity');
        $this->assertInstanceOf(Entity::class, $res->returnVal());
    }

    public function testClassEntityType()
    {
        $client = TestHelpers::stub(DatastoreClient::class, [], [
            'operation'
        ]);

        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->commit(Argument::any())->shouldBeCalled()->willReturn(['mutationResults' => [['version' => 1]]]);
        $connection->lookup(Argument::any())->shouldBeCalled()->willReturn([
            'found' => [
                [
                    'entity' => [
                        'key' => [
                            'path' => [['kind' => 'Business', 'name' => 'Google']]
                        ],
                        'properties' => [
                            'name' => [
                                'stringValue' => 'Google'
                            ],
                            'parent' => [
                                'entityValue' => [
                                    'properties' => [
                                        'name' => [
                                            'stringValue' => 'Alphabet'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $operation = new Operation(
            $connection->reveal(),
            'example_project',
            'foo',
            new EntityMapper('example_project', false, false)
        );

        $client->___setProperty('operation', $operation);

        $snippet = $this->snippetFromClass(Entity::class, 1);
        $snippet->addLocal('datastore', $client);
        $this->assertEquals("BusinessBusiness", $snippet->invoke()->output());
    }

    public function testGet()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'get');
        $snippet->addLocal('entity', $this->entity);

        $this->entity['firstName'] = 'Bob';

        $res = $snippet->invoke('data');
        $this->assertEquals(['firstName' => 'Bob'], $res->returnVal());
    }

    public function testGetProperty()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'getProperty');
        $snippet->addLocal('entity', $this->entity);

        $this->entity['firstName'] = 'Bob';

        $res = $snippet->invoke('value');
        $this->assertEquals('Bob', $res->returnVal());
    }

    public function testSet()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'set');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals('Dave', $this->entity['firstName']);
    }

    public function testSetProperty()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'setProperty');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals('Bob', $this->entity['firstName']);
    }

    public function testKey()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'key');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('key');
        $this->assertEquals($this->key, $res->returnVal());
    }

    public function testCursor()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'cursor');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('cursor');
        $this->assertEquals($this->options['cursor'], $res->returnVal());
    }

    public function testBaseVersion()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'baseVersion');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('baseVersion');
        $this->assertEquals($this->options['baseVersion'], $res->returnVal());
    }

    public function testPopulatedByService()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'populatedByService');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('populatedByService');
        $this->assertEquals($this->options['populatedByService'], $res->returnVal());
    }

    public function testSetExcludeFromIndexes()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'setExcludeFromIndexes');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke();
        $this->assertEquals(['birthDate'], $this->entity->excludedProperties());
    }

    public function testExcludedProperties()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'excludedProperties');
        $snippet->addLocal('entity', $this->entity);

        $exclude = ['birthDate'];
        $this->entity->setExcludeFromIndexes($exclude);

        $res = $snippet->invoke('excludedFromIndexes');
        $this->assertEquals($exclude, $res->returnVal());
    }

    public function testMeanings()
    {
        $snippet = $this->snippetFromMethod(Entity::class, 'meanings');
        $snippet->addLocal('entity', $this->entity);

        $res = $snippet->invoke('meanings');
        $this->assertEquals($this->options['meanings'], $res->returnVal());
    }
}
