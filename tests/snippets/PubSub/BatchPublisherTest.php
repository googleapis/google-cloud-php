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

namespace Google\Cloud\Tests\Snippets\PubSub;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class BatchPublisherTest extends SnippetTestCase
{
    private $batchPublisher;

    public function setUp()
    {
        $this->batchPublisher = $this->prophesize(BatchPublisher::class);
        $this->batchPublisher->publish([
            'data' => 'An important message.'
        ])
            ->willReturn(true);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(BatchPublisher::class);
        $topic = $this->prophesize(Topic::class);
        $topic->batchPublisher()
            ->willReturn($this->batchPublisher->reveal());
        $pubsub = $this->prophesize(PubSubClient::class);
        $pubsub->topic(Argument::type('string'))
            ->willReturn($topic->reveal());
        $snippet->setLine(2, '');
        $snippet->addLocal('pubsub', $pubsub->reveal());

        $snippet->invoke();
    }

    public function testPublish()
    {
        $snippet = $this->snippetFromMethod(BatchPublisher::class, 'publish');
        $snippet->addLocal('batchPublisher', $this->batchPublisher->reveal());

        $snippet->invoke();
    }
}
