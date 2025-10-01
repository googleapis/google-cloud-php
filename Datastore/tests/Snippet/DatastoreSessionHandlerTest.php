<?php
/**
 * Copyright 2019 Google LLC.
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

use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreSessionHandler;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 * @group datastore-session
 * @runTestsInSeparateProcesses
 */
class DatastoreSessionHandlerTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ProtoEncodeTrait;

    const TRANSACTION = 'transaction-id';

    private $gapicClient;
    private $client;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Since the tests in this class must run in isolation, they won't be
        // recognized as having been covered, and will cause a CI error.
        // We can call `snippetFromClass` in the parent process to mark the
        // snippets as having been covered.
        self::snippetFromClass(DatastoreSessionHandler::class);
        self::snippetFromClass(DatastoreSessionHandler::class, 1);
    }

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);
        $this->client = new DatastoreClient([
            'datastoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(DatastoreSessionHandler::class);
        $snippet->replace('$datastore = new DatastoreClient();', '');

        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
            $this->assertEquals('sessions', $request->getKeys()[0]->getPartitionId()->getNamespaceId());
            $this->assertEquals('PHPSESSID', $request->getKeys()[0]->getPath()[0]->getKind());
            $this->assertNotEmpty($request->getKeys()[0]->getPath()[0]->getName());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, []));

        $this->gapicClient->beginTransaction(Argument::that(function (BeginTransactionRequest $request) {
            $this->assertNotEmpty($request->getTransactionOptions()->getReadWrite());
            return true;
        }), Argument::any())->shouldBeCalled()->willReturn(self::generateProto(BeginTransactionResponse::class, [
            'transaction' => base64_encode(self::TRANSACTION),
        ]));

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $value = 'name|'.serialize('Bob');

            $this->assertEquals('sessions', $request->getMutations()[0]->getUpsert()->getKey()->getPartitionId()->getNamespaceId());
            $this->assertEquals('PHPSESSID', $request->getMutations()[0]->getUpsert()->getKey()->getPath()[0]->getKind());
            $this->assertEquals($value, $request->getMutations()[0]->getUpsert()->getProperties()['data']->getStringValue());
            $this->assertNotEmpty($request->getMutations()[0]->getUpsert()->getProperties()['t']);
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testClassErrorHandler()
    {
        $this->expectException(\RuntimeException::class);

        $snippet = $this->snippetFromClass(DatastoreSessionHandler::class, 1);
        $snippet->replace('$datastore = new DatastoreClient();', '');

        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            $this->assertEquals('sessions', $request->getKeys()[0]->getPartitionId()->getNamespaceId());
            $this->assertEquals('PHPSESSID', $request->getKeys()[0]->getPath()[0]->getKind());
            $this->assertNotEmpty($request->getKeys()[0]->getPath()[0]->getName());

            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, []));

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertNotEmpty($request->getTransactionOptions());
                $this->assertNotEmpty($request->getTransactionOptions()->getReadWrite());

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(BeginTransactionResponse::class, [
            'transaction' => base64_encode(self::TRANSACTION),
        ]));

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->will(function () {
                trigger_error('oops!', E_USER_WARNING);
            });

        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }
}
