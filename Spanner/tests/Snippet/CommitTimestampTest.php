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
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\Session;
use Google\Protobuf\Timestamp as TimestampProto;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-committimestamp
 */
class CommitTimestampTest extends SnippetTestCase
{
    use ProphecyTrait;
    use GrpcTestTrait;

    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

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

        $this->spannerClient->createSession(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Session(['name' => self::SESSION]));
        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();
        $this->spannerClient->addMiddleware(Argument::type('callable'))
            ->shouldBeCalledOnce();

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
            'gapicSpannerClient' => $this->spannerClient->reveal()
        ]);

        $snippet = $this->snippetFromClass(CommitTimestamp::class);
        $snippet->addLocal('id', $id);
        $snippet->addLocal('spanner', $client);
        $snippet->replace("\$spanner = new SpannerClient(['projectId' => 'my-project']);", '');

        $snippet->invoke();
    }
}
