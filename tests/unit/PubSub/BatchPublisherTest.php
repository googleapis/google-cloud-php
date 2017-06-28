<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\PubSub;

use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class BatchPublisherTest extends \PHPUnit_Framework_TestCase
{
    const TOPIC_NAME = 'my-topic';

    public function testPublish()
    {
        $message = ['data' => 'Hello, world!'];
        $runner = $this->prophesize(BatchRunner::class);
        $runner->submitItem('pubsub-topic-' . self::TOPIC_NAME, $message)
            ->willReturn(true)
            ->shouldBeCalledTimes(1);
        $runner->registerJob(
            Argument::type('string'),
            Argument::type('array'),
            Argument::type('array')
        )
            ->willReturn(true)
            ->shouldBeCalledTimes(1);

        $publisher = new BatchPublisher(self::TOPIC_NAME, [
            'batchRunner' => $runner->reveal()
        ]);

        $publisher->publish($message);
    }

    public function testGetCallback()
    {
        $callbackArray = (new TestBatchPublisher(self::TOPIC_NAME))
            ->getCallbackArray();

        $this->assertInstanceOf(Topic::class, $callbackArray[0]);
        $this->assertEquals('publishBatch', $callbackArray[1]);
    }
}

class TestBatchPublisher extends BatchPublisher
{
    public function getCallbackArray()
    {
        return $this->getCallback();
    }
}
