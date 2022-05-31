<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Storage\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\Lifecycle;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;

/**
 * @group storage
 */
class LifecycleTest extends SnippetTestCase
{
    const PROJECT_ID = 'project';

    private $lifecycle;
    private static $condition = [
        'age' => 50,
        'isLive' => true
    ];

    public function set_up()
    {
        $this->lifecycle = new Lifecycle;
    }

    public function testClass()
    {
        $connection = $this->prophesize(Rest::class);
        $connection->projectId()
            ->willReturn(self::PROJECT_ID);
        $connection->getBucket(Argument::any())
            ->willReturn([
                'lifecycle' => ['test' => 'test']
            ]);
        $client = TestHelpers::stub(StorageClient::class);
        $client->___setProperty('connection', $connection->reveal());

        $snippet = $this->snippetFromClass(Lifecycle::class);
        $snippet->setLine(4, '');
        $snippet->addLocal('storage', $client);
        $res = $snippet->invoke('lifecycle');

        $this->assertInstanceOf(Lifecycle::class, $res->returnVal());
    }

    public function testClassStatic()
    {
        $snippet = $this->snippetFromClass(Lifecycle::class, 1);
        $res = $snippet->invoke('lifecycle');

        $this->assertInstanceOf(Lifecycle::class, $res->returnVal());
    }

    public function testAddDeleteRule()
    {
        $snippet = $this->snippetFromMethod(Lifecycle::class, 'addDeleteRule');
        $snippet->addLocal('lifecycle', $this->lifecycle);

        $returnVal = $snippet->invoke('lifecycle')
            ->returnVal();

        $this->assertInstanceOf(Lifecycle::class, $returnVal);
        $this->assertEquals(
            [
                'rule' => [
                    [
                        'action' => [
                            'type' => 'Delete'
                        ],
                        'condition' => self::$condition
                    ]
                ]
            ],
            $returnVal->toArray()
        );
    }

    public function testAddSetStorageClassRule()
    {
        $snippet = $this->snippetFromMethod(Lifecycle::class, 'addSetStorageClassRule');
        $snippet->addLocal('lifecycle', $this->lifecycle);

        $returnVal = $snippet->invoke('lifecycle')
            ->returnVal();

        $this->assertInstanceOf(Lifecycle::class, $returnVal);
        $this->assertEquals(
            [
                'rule' => [
                    [
                        'action' => [
                            'type' => 'SetStorageClass',
                            'storageClass' => 'COLDLINE'
                        ],
                        'condition' => self::$condition
                    ]
                ]
            ],
            $returnVal->toArray()
        );
    }

    public function testAddSetStorageClassRuleWithObjectCustomTime()
    {
        $dt = (new \DateTime)->add(\DateInterval::createFromDateString('+10 days'));

        $object = $this->prophesize(StorageObject::class);
        $object->update(['metadata' => [
            'customTime' => '2020-08-17'
        ]])->shouldBeCalled();

        $bucket = $this->prophesize(Bucket::class);
        $bucket->object('my-object')->shouldBeCalled()->willReturn($object->reveal());
        $bucket->update(Argument::that(function ($arg) use ($dt) {
            return $arg['lifecycle']->toArray()['rule'][0]['condition']['customTimeBefore'] == $dt->format('Y-m-d');
        }))->shouldBeCalled();

        $snippet = $this->snippetFromMethod(Lifecycle::class, 'addSetStorageClassRule', 1);
        $snippet->addLocal('lifecycle', $this->lifecycle);
        $snippet->addLocal('bucket', $bucket->reveal());
        $snippet->addLocal('objectName', 'my-object');

        $snippet->invoke('lifecycle');
    }

    public function testClearRules()
    {
        $this->lifecycle
            ->addDeleteRule(self::$condition);
        $snippet = $this->snippetFromMethod(Lifecycle::class, 'clearRules');
        $snippet->addLocal('lifecycle', $this->lifecycle);

        $returnVal = $snippet->invoke('lifecycle')
            ->returnVal();

        $this->assertInstanceOf(Lifecycle::class, $returnVal);
        $this->assertEmpty($returnVal->toArray());
    }

    public function testClearRulesWithString()
    {
        $this->lifecycle
            ->addDeleteRule(self::$condition);
        $snippet = $this->snippetFromMethod(Lifecycle::class, 'clearRules', 1);
        $snippet->addLocal('lifecycle', $this->lifecycle);

        $returnVal = $snippet->invoke('lifecycle')
            ->returnVal();

        $this->assertInstanceOf(Lifecycle::class, $returnVal);
        $this->assertEmpty($returnVal->toArray());
    }

    public function testClearRulesWithCallable()
    {
        $this->lifecycle
            ->addDeleteRule(self::$condition);
        $snippet = $this->snippetFromMethod(Lifecycle::class, 'clearRules', 2);
        $snippet->addLocal('lifecycle', $this->lifecycle);

        $returnVal = $snippet->invoke('lifecycle')
            ->returnVal();

        $this->assertInstanceOf(Lifecycle::class, $returnVal);
        $this->assertEmpty($returnVal->toArray());
    }
}
