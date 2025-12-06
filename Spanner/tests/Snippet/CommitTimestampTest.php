<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\Session;
use Google\Protobuf\Timestamp as TimestampProto;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group spanner
 * @group spanner-committimestamp
 */
class CommitTimestampTest extends SnippetTestCase
{
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    use ProphecyTrait;
    use GrpcTestTrait;

    private $spannerClient;
    private $serializer;

    public function setUp(): void
    {
        $this->serializer = new Serializer();
        $this->spannerClient = $this->prophesize(GapicSpannerClient::class);
        $this->checkAndSkipGrpcTests();
    }

    public function testClass()
    {
        $id = 'abc';

        $this->spannerClient->addMiddleware(Argument::type('callable'))
            ->shouldBeCalledOnce();
        $this->spannerClient->prependMiddleware(Argument::type('callable'))
            ->shouldBeCalledOnce();

        // ensure cache hit
        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->isHit()->shouldBeCalled()->willReturn(true);
        $cacheItem->get()->shouldBeCalled()->willReturn((new Session([
            'name' => self::SESSION,
            'multiplexed' => true,
            'create_time' => new TimestampProto(['seconds' => time()]),
        ]))->serializeToString());
        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem(Argument::type('string'))
            ->shouldBeCalledOnce()
            ->willReturn($cacheItem->reveal());

        $mutation = [
            'insert' => [
                'table' => 'myTable',
                'columns' => ['id', 'commitTimestamp'],
                'values' => [[$id, CommitTimestamp::SPECIAL_VALUE]]
            ]
        ];
        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) use ($mutation) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['mutations'][0], $mutation);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $client = new SpannerClient([
            'projectId' => 'my-project',
            'gapicSpannerClient' => $this->spannerClient->reveal(),
            'cacheItemPool' => $cacheItemPool->reveal(),
        ]);

        $snippet = $this->snippetFromClass(CommitTimestamp::class);
        $snippet->addLocal('id', $id);
        $snippet->addLocal('spanner', $client);
        $snippet->replace("\$spanner = new SpannerClient(['projectId' => 'my-project']);", '');

        $snippet->invoke();
    }
}
