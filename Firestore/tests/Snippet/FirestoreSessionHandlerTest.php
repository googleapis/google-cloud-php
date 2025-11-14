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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\FirestoreSessionHandler;
use Google\Cloud\Firestore\Tests\Unit\GenerateProtoTrait;
use Google\Cloud\Firestore\Tests\Unit\ServerStreamMockTrait;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\BeginTransactionResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as GapicFirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-session
 * @runTestsInSeparateProcesses
 */
class FirestoreSessionHandlerTest extends SnippetTestCase
{
    use GenerateProtoTrait;
    use ServerStreamMockTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

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
        self::snippetFromClass(FirestoreSessionHandler::class);
        self::snippetFromClass(FirestoreSessionHandler::class, 1);
        self::snippetFromMethod(FirestoreClient::class, 'sessionHandler');
    }

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->gapicClient = $this->prophesize(GapicFirestoreClient::class);
        $this->client = new FirestoreClient([
            'projectId' => 'test',
            'firestoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(FirestoreSessionHandler::class);
        $snippet->replace('$firestore = new FirestoreClient();', '');

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => '',
                'fields' => []
            ]
        ]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertNotEmpty($request->getDocuments());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new BeginTransactionResponse(['transaction' => self::TRANSACTION]));

        $value = 'name|' . serialize('Bob');
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) use ($value){
                $this->assertNotFalse(strpos($request->getWrites()[0]->getUpdate()->getName(), ':PHPSESSID'));
                $this->assertEquals(
                    $request->getWrites()[0]->getUpdate()->getFields()['data']->getStringValue(),
                    $value
                );
                $this->assertNotEmpty($request->getWrites()[0]->getUpdate()->getFields()['t']->getIntegerValue());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(new CommitResponse());

        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testSessionHandlerMethod()
    {
        $snippet = $this->snippetFromMethod(FirestoreClient::class, 'sessionHandler');

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => '',
                'fields' => []
            ]
        ]);

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertNotEmpty($request->getDocuments());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new BeginTransactionResponse([
                'transaction' => self::TRANSACTION
            ]));

        $value = 'name|' . serialize('Bob');
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) use ($value) {
                $this->assertNotFalse(strpos($request->getWrites()[0]->getUpdate()->getName(), ':PHPSESSID'));
                $this->assertEquals($request->getWrites()[0]->getUpdate()->getFields()['data']->getStringValue(), $value);
                $this->assertNotEmpty($request->getWrites()[0]->getUpdate()->getFields()['t']->getIntegerValue());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(new CommitResponse());

        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();
        session_write_close();

        $this->assertEquals('Bob', $res->output());
    }

    public function testClassErrorHandler()
    {
        $this->expectException(\RuntimeException::class);

        $snippet = $this->snippetFromClass(FirestoreSessionHandler::class, 1);
        $snippet->replace('$firestore = new FirestoreClient();', '');

        $protoResponse = self::generateProto(BatchGetDocumentsResponse::class, [
            'found' => [
                'name' => '',
                'fields' => []
            ]
        ]);

        $this->gapicClient->batchGetDocuments(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->getServerStreamMock([$protoResponse]));

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new BeginTransactionResponse(['transaction' => self::TRANSACTION]));

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->will(function () {
                trigger_error('oops!', E_USER_WARNING);
            });

        $snippet->addLocal('firestore', $this->client);

        $res = $snippet->invoke();

        $this->assertEquals('Bob', $res->output());
    }
}
