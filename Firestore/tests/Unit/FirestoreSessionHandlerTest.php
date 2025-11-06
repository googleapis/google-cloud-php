<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Firestore\Tests\Unit;

use ArrayIterator;
use Exception;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\FirestoreSessionHandler;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\BeginTransactionRequest;
use Google\Cloud\Firestore\V1\BeginTransactionResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\RollbackRequest;
use Google\Cloud\Firestore\V1\RunQueryRequest;
use Google\Cloud\Firestore\V1\RunQueryResponse;
use Google\Cloud\Firestore\V1\Value;
use Google\Cloud\Firestore\V1\Write;
use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-session
 */
class FirestoreSessionHandlerTest extends TestCase
{
    use GenerateProtoTrait;
    use ProphecyTrait;

    const SESSION_SAVE_PATH = 'sessions';
    const SESSION_NAME = 'PHPSESSID';
    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $gapicClient;
    private $valueMapper;
    private $documents;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(FirestoreClient::class);
        $this->valueMapper = $this->prophesize(ValueMapper::class);
        $this->documents = $this->prophesize(Iterator::class);
    }

    public function testOpen()
    {
        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => null]));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $ret = $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->assertTrue($ret);
    }

    public function testOpenWithException()
    {
        $this->expectWarningUsingErrorhandler();

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willThrow(new ServiceException(''));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $ret = $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->assertFalse($ret);
    }

    public function testReadNotAllowed()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => null]));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open('invalid/savepath', self::SESSION_NAME);
        $firestoreSessionHandler->read('sessionid');
    }

    public function testClose()
    {
        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => 123]));

        $this->gapicClient->rollback(Argument::type(RollbackRequest::class), Argument::any())
            ->shouldBeCalledTimes(1);

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->close();
        $this->assertTrue($ret);
    }

    public function testReadNothing()
    {
        $serverStream = $this->prophesize(ServerStream::class);
        $serverStream->readAll()
            ->willReturn(new ArrayIterator([
                new BatchGetDocumentsResponse()
            ]));

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => null]));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $this->assertEmpty($request->getTransaction());
                $this->assertEquals([$this->documentName()], iterator_to_array($request->getDocuments()));
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn($serverStream->reveal());

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadWithException()
    {
        $this->expectWarningUsingErrorhandler();

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => null]));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $this->assertEquals([$this->documentName()], iterator_to_array($request->getDocuments()));
                $this->assertEmpty($request->getTransaction());

                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willThrow((new ServiceException('')));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadEntity()
    {
        $serverStream = $this->prophesize(ServerStream::class);
        $serverStream->readAll()
            ->willReturn(new ArrayIterator([
                self::generateProto(BatchGetDocumentsResponse::class, [
                    'found' => [
                        'fields' => [
                            'data' => [
                                'stringValue' => 'sessiondata'
                            ]
                        ]
                    ]
                ])
            ]));

        // $this->documents->current()
        //     ->shouldBeCalledTimes(1)
        //     ->willReturn([
        //         'found' => [
        //             'createTime' => date('Y-m-d'),
        //             'updateTime' => date('Y-m-d'),
        //             'readTime' => date('Y-m-d'),
        //             'fields' => ['data' => 'sessiondata']
        //         ]
        //     ]);

        $this->valueMapper->decodeValues(['data' => ['stringValue' => 'sessiondata']])
            ->shouldBeCalledTimes(1)
            ->willReturn(['data' => 'sessiondata']);

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => null]));

        $this->gapicClient->batchGetDocuments(
            Argument::that(function (BatchGetDocumentsRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $this->assertEquals([$this->documentName()], iterator_to_array($request->getDocuments()));
                $this->assertEmpty($request->getTransaction());

                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($serverStream->reveal());

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->read('sessionid');

        $this->assertEquals('sessiondata', $ret);
    }

    public function testWrite()
    {
        $this->valueMapper->encodeValues(
            Argument::that(function (array $array) {
                $this->assertEquals('sessiondata', $array['data']);
                $this->assertTrue(is_int($array['t']));
                return true;
            })
        )
            ->willReturn(['data' => ['stringValue' => 'sessiondata']]);

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => null]));

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());

                $expectedWrites = [
                    self::generateProto(Write::class,  [
                        'update' => [
                            'name' => $this->documentName(),
                            'fields' => [
                                'data' => ['stringValue' => 'sessiondata']
                            ]
                        ]
                    ])
                ];

                $writes = iterator_to_array($request->getWrites());

                $this->assertEquals($expectedWrites, $writes);
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->write('sessionid', 'sessiondata');
        $firestoreSessionHandler->close();

        $this->assertTrue($ret);
    }

    public function testWriteWithException()
    {
        $this->expectWarningUsingErrorhandler();

        $phpunit = $this;
        $this->valueMapper->encodeValues(
            Argument::that(function (array $array) {
                $this->assertEquals('sessiondata', $array['data']);
                $this->assertTrue(is_int($array['t']));

                return true;
            })
        )
            ->willReturn(['data' => ['stringValue' => 'sessiondata']]);

            $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => 123]));

        $this->gapicClient->rollback(
            Argument::that(function (RollbackRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $this->assertEquals('123', $request->getTransaction());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalledTimes(1);

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(1)
            ->willThrow((new ServiceException('')));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->write('sessionid', 'sessiondata');
        $firestoreSessionHandler->close();

        $this->assertFalse($ret);
    }

    public function testDestroy()
    {
        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => 123]));

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $this->assertEquals('123', $request->getTransaction());

                $expectedWrites = self::generateProto(Write::class, [
                    'delete' => $this->documentName()
                ]);

                $this->assertEquals([$expectedWrites], iterator_to_array($request->getWrites()));
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(new CommitResponse());

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->destroy('sessionid');
        $firestoreSessionHandler->close();

        $this->assertTrue($ret);
    }

    public function testDestroyWithException()
    {
        $this->expectWarningUsingErrorhandler();

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => 123]));

        $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(1)
            ->willThrow(new ServiceException(''));

        $this->gapicClient->rollback(
            Argument::that(function (RollbackRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $this->assertEquals('123', $request->getTransaction());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1);

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->destroy('sessionid');
        $firestoreSessionHandler->close();

        $this->assertFalse($ret);
    }

    public function testDefaultGcDoesNothing()
    {
        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => 123]));

        $this->gapicClient->commit()->shouldNotBeCalled();

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->gc(100);

        $this->assertTrue($ret);
    }

    public function testGc()
    {
        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(2)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => '123']));


        $serverStream = $this->prophesize(ServerStream::class);
        $serverStream->readAll()->willReturn(new ArrayIterator([
            new RunQueryResponse([
                'document' => new Document(['name' => $this->documentName()])
            ])
        ]));

        $this->gapicClient->runQuery(
            Argument::that(function(RunQueryRequest $request) {
                $this->assertEquals($this->dbName() . '/documents', $request->getParent());
                $this->assertEquals(499, $request->getStructuredQuery()->getLimit()->getValue());
                $this->assertEquals(
                    self::SESSION_SAVE_PATH . ':' . self::SESSION_NAME,
                    $request->getStructuredQuery()->getFrom()[0]->getCollectionId()
                );
                $this->assertEquals('123', $request->getTransaction());

                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn($serverStream->reveal());

        $this->valueMapper->decodeValues([])
            ->shouldBeCalledTimes(1)
            ->willReturn(['data' => 'sessiondata']);

        $this->valueMapper->encodeValue(Argument::type('integer'))
            ->shouldBeCalledTimes(1)
            ->willReturn(['integerValue' => 10]);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                $expectedWrites = self::generateProto(Write::class,  [
                    'delete' => $this->documentName()
                ]);
                $this->assertEquals([$expectedWrites], iterator_to_array($request->getWrites()));
                $this->assertEquals('123', $request->getTransaction());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE,
            ['gcLimit' => 499, 'query' => ['maxRetries' => 0]]
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->gc(100);

        $this->assertEquals(1, $ret);
    }

    public function testGcWithException()
    {
        $this->expectWarningUsingErrorhandler();

        $this->valueMapper->encodeValue(Argument::type('integer'))
            ->shouldBeCalledTimes(1)
            ->willReturn(['integerValue' => 10]);

        $this->gapicClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($this->dbName(), $request->getDatabase());
                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(2)
            ->willReturn(self::generateProto(BeginTransactionResponse::class, ['transaction' => 123]));

        $this->gapicClient->runQuery(Argument::any(), Argument::any())
            ->shouldBeCalledTimes(1)
            ->willThrow(new ServiceException(''));

        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->gapicClient->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE,
            ['gcLimit' => 500, 'query' => ['maxRetries' => 0]]
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->gc(100);

        $this->assertFalse($ret);
    }

    private function expectWarningUsingErrorhandler()
    {
        set_error_handler(static function (int $errno, string $errstr): never {
            throw new Exception($errstr, $errno);
        }, E_USER_WARNING);
        $this->expectException(Exception::class);
    }

    private function dbName()
    {
        return sprintf(
            'projects/%s/databases/%s',
            self::PROJECT,
            self::DATABASE
        );
    }

    private function documentName()
    {
        return sprintf(
            '%s/documents/%s:%s/sessionid',
            $this->dbName(),
            self::SESSION_SAVE_PATH,
            self::SESSION_NAME
        );
    }
}
