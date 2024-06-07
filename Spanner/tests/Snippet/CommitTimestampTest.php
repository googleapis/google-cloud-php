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
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-committimestamp
 */
class CommitTimestampTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use RequestHandlingTestTrait;

    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    private $requestHandler;
    private $serializer;

    public function setUp(): void
    {
        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->checkAndSkipGrpcTests();
    }

    public function testClass()
    {
        $id = 'abc';

        $client = TestHelpers::stub(
            SpannerClient::class,
            [['projectId' => 'my-project']],
            ['requestHandler', 'serializer']
        );

        $this->mockSendRequest(
            GapicSpannerClient::class,
            'createSession',
            null,
            ['name' => self::SESSION]
        );
        $this->mockSendRequest(
            GapicSpannerClient::class,
            'deleteSession',
            null,
            null
        );
        $mutation = [
            'insert' => [
                'table' => 'myTable',
                'columns' => ['id', 'commitTimestamp'],
                'values' => [[$id, CommitTimestamp::SPECIAL_VALUE]]
            ]
        ];
        $this->mockSendRequest(
            GapicSpannerClient::class,
            'commit',
            function ($args) use ($mutation) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['mutations'][0], $mutation);
                return true;
            },
            [
                'commitTimestamp' => \DateTime::createFromFormat('U', (string) time())->format(Timestamp::FORMAT)
            ]
        );

        $client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $client->___setProperty('serializer', $this->serializer);

        $snippet = $this->snippetFromClass(CommitTimestamp::class);
        $snippet->addLocal('id', $id);
        $snippet->addLocal('spanner', $client);
        $snippet->replace("\$spanner = new SpannerClient(['projectId' => 'my-project']);", '');

        $snippet->invoke();
    }
}
