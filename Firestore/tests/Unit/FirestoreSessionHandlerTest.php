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

use Exception;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\FirestoreSessionHandler;
use Google\Cloud\Firestore\Transaction;
use InvalidArgumentException;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Iterator;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException;

/**
 * @group firestore
 * @group firestore-session
 */
class FirestoreSessionHandlerTest extends TestCase
{
    use ExpectException;
    use ExpectPHPException;

    const SESSION_SAVE_PATH = 'sessions';
    const SESSION_NAME = 'PHPSESSID';
    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $connection;
    private $valueMapper;
    private $documents;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->valueMapper = $this->prophesize(ValueMapper::class);
        $this->documents = $this->prophesize(Iterator::class);
    }

    public function testOpen()
    {
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => null]);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $ret = $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->assertTrue($ret);
    }

    public function testOpenWithException()
    {
        $this->expectWarning();

        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willThrow(new ServiceException(''));
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $ret = $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->assertFalse($ret);
    }

    public function testReadNotAllowed()
    {
        $this->expectException('InvalidArgumentException');

        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => null]);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $firestoreSessionHandler->open('invalid/savepath', self::SESSION_NAME);
        $firestoreSessionHandler->read('sessionid');
    }

    public function testClose()
    {
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => 123]);
        $this->connection->rollback(Argument::any())
            ->shouldBeCalledTimes(1);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->documents->current()
            ->shouldBeCalledTimes(1)
            ->willReturn(null);
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => null]);
        $this->connection->batchGetDocuments([
            'database' => $this->dbName(),
            'documents' => [$this->documentName()],
            'transaction' => null,
        ])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->documents->reveal());
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->expectWarning();

        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => null]);
        $this->connection->batchGetDocuments([
            'database' => $this->dbName(),
            'documents' => [$this->documentName()],
            'transaction' => null,
        ])
            ->shouldBeCalledTimes(1)
            ->willThrow((new ServiceException('')));
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->documents->current()
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'found' => [
                    'createTime' => date('Y-m-d'),
                    'updateTime' => date('Y-m-d'),
                    'readTime' => date('Y-m-d'),
                    'fields' => ['data' => 'sessiondata']
                ]
            ]);
        $this->valueMapper->decodeValues(['data' => 'sessiondata'])
            ->shouldBeCalledTimes(1)
            ->willReturn(['data' => 'sessiondata']);
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => null]);
        $this->connection->batchGetDocuments([
            'database' => $this->dbName(),
            'documents' => [$this->documentName()],
            'transaction' => null,
        ])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->documents->reveal());
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $phpunit = $this;
        $this->valueMapper->encodeValues(Argument::type('array'))
            ->will(function ($args) use ($phpunit) {
                $phpunit->assertEquals('sessiondata', $args[0]['data']);
                $phpunit->assertTrue(is_int($args[0]['t']));
                return ['data' => ['stringValue' => 'sessiondata']];
            });
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => null]);
        $this->connection->commit([
            'database' => $this->dbName(),
            'writes' => [
                [
                    'update' => [
                        'name' => $this->documentName(),
                        'fields' => [
                            'data' => ['stringValue' => 'sessiondata']
                        ]
                    ]
                ]
            ]
        ])
            ->shouldBeCalledTimes(1);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->expectWarning();

        $phpunit = $this;
        $this->valueMapper->encodeValues(Argument::type('array'))
            ->will(function ($args) use ($phpunit) {
                $phpunit->assertEquals('sessiondata', $args[0]['data']);
                $phpunit->assertTrue(is_int($args[0]['t']));
                return ['data' => ['stringValue' => 'sessiondata']];
            });
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => 123]);
        $this->connection->rollback([
            'database' => $this->dbName(),
            'transaction' => 123
        ])
            ->shouldBeCalledTimes(1);
        $this->connection->commit(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willThrow((new ServiceException('')));
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => 123]);
        $this->connection->commit([
            'database' => $this->dbName(),
            'writes' => [
                [
                    'delete' => $this->documentName()
                ]
            ],
            'transaction' => 123
        ])
            ->shouldBeCalledTimes(1);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->expectWarning();

        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => 123]);
        $this->connection->commit(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willThrow(new ServiceException(''));
        $this->connection->rollback([
            'database' => $this->dbName(),
            'transaction' => 123
        ])
            ->shouldBeCalledTimes(1);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(1)
            ->willReturn(['transaction' => 123]);
        $this->connection->commit()->shouldNotBeCalled();
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $phpunit = $this;
        $this->documents->valid()
            ->shouldBeCalledTimes(2)
            ->willReturn(true, false);
        $this->documents->current()
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'document' => [
                    'name' => $this->documentName(),
                    'fields' => [],
                    'createTime' => date('Y-m-d'),
                    'updateTime' => date('Y-m-d'),
                ],
                'readTime' => date('Y-m-d'),
            ]);
        $this->documents->next()
            ->shouldBeCalledTimes(1);
        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(2)
            ->willReturn(['transaction' => 123]);
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalledTimes(1)
            ->will(function ($args) use ($phpunit) {
                $options = $args[0];
                $phpunit->assertEquals(
                    $phpunit->dbName() . '/documents',
                    $options['parent']
                );
                $phpunit->assertEquals(499, $options['structuredQuery']['limit']);
                $phpunit->assertEquals(
                    self::SESSION_SAVE_PATH . ':' . self::SESSION_NAME,
                    $options['structuredQuery']['from'][0]['collectionId']
                );
                $phpunit->assertEquals(123, $options['transaction']);
                return $phpunit->documents->reveal();
            });
        $this->valueMapper->decodeValues([])
            ->shouldBeCalledTimes(1)
            ->willReturn(['data' => 'sessiondata']);
        $this->valueMapper->encodeValue(Argument::type('integer'))
            ->shouldBeCalledTimes(1);
        $this->connection->commit([
            'database' => $this->dbName(),
            'writes' => [
                [
                    'delete' => $this->documentName()
                ]
            ],
            'transaction' => 123
        ])
            ->shouldBeCalledTimes(1);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
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
        $this->expectWarning();

        $this->connection->beginTransaction(['database' => $this->dbName()])
            ->shouldBeCalledTimes(2)
            ->willReturn(['transaction' => 123]);
        $this->connection->runQuery(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willThrow(new ServiceException(''));
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE,
            ['gcLimit' => 500, 'query' => ['maxRetries' => 0]]
        );

        $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $ret = $firestoreSessionHandler->gc(100);

        $this->assertFalse($ret);
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
