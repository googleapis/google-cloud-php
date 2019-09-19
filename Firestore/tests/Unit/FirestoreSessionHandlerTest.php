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
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Iterator;

/**
 * @group firestore
 * @group firestore-session
 */
class FirestoreSessionHandlerTest extends TestCase
{
    const SESSION_SAVE_PATH = 'sessions';
    const SESSION_NAME = 'PHPSESID';
    const PROJECT = 'example_project';
    const DATABASE = '(default)';

    private $connection;
    private $valueMapper;
    private $documents;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->valueMapper = $this->prophesize(ValueMapper::class);
        $this->documents = $this->prophesize(Iterator::class);
    }

    public function testOpen()
    {
        $db = sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
        $this->connection->beginTransaction(['database' => $db])
            ->shouldBeCalledTimes(1);
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $ret = $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->assertTrue($ret);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testReadNotAllowed()
    {
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
        $firestoreSessionHandler = new FirestoreSessionHandler(
            $this->connection->reveal(),
            $this->valueMapper->reveal(),
            self::PROJECT,
            self::DATABASE
        );
        $ret = $firestoreSessionHandler->close();
        $this->assertTrue($ret);
    }

    public function testReadNothing()
    {
        $db = sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
        $doc = sprintf('%s/documents/%s/%s:sessionid', $db, self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->documents->current()
            ->shouldBeCalledTimes(1)
            ->willReturn(null);
        $this->connection->beginTransaction(['database' => $db])
            ->shouldBeCalledTimes(1);
        $this->connection->batchGetDocuments([
            'database' => $db,
            'documents' => [$doc],
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

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testReadWithException()
    {
        $db = sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
        $doc = sprintf('%s/documents/%s/%s:sessionid', $db, self::SESSION_SAVE_PATH, self::SESSION_NAME);
        $this->connection->beginTransaction(['database' => $db])
            ->shouldBeCalledTimes(1);
        $this->connection->batchGetDocuments([
            'database' => $db,
            'documents' => [$doc],
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
        $db = sprintf('projects/%s/databases/%s', self::PROJECT, self::DATABASE);
        $doc = sprintf('%s/documents/%s/%s:sessionid', $db, self::SESSION_SAVE_PATH, self::SESSION_NAME);
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
        $this->connection->beginTransaction(['database' => $db])
            ->shouldBeCalledTimes(1);
        $this->connection->batchGetDocuments([
            'database' => $db,
            'documents' => [$doc],
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

    // public function testWrite()
    // {
    //     $id = self::SESSION_NAME . ':sessionid';
    //     $docRef = $this->prophesize(DocumentReference::class);
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($this->collection->reveal());
    //     $phpunit = $this;
    //     $this->firestore->runTransaction(Argument::type('closure'))
    //         ->shouldBeCalledTimes(1)
    //         ->will(function ($args) use ($phpunit, $docRef) {
    //             $transaction = $phpunit->prophesize(Transaction::class);
    //             $transaction->set($docRef, Argument::type('array'))
    //                 ->will(function ($args) use ($phpunit) {
    //                     $phpunit->assertEquals('sessiondata', $args[1]['data']);
    //                     $phpunit->assertInternalType('int', $args[1]['t']);
    //                     $phpunit->assertGreaterThanOrEqual($args[1]['t'], time());
    //                     // 2 seconds grace period should be enough
    //                     $phpunit->assertLessThanOrEqual(2, time() - $args[1]['t']);
    //                 });
    //             $args[0]($transaction->reveal());
    //         });
    //     $this->collection->document($id)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef);
    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal()
    //     );
    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->write('sessionid', 'sessiondata');

    //     $this->assertTrue($ret);
    // }

    // /**
    //  * @expectedException PHPUnit_Framework_Error_Warning
    //  */
    // public function testWriteWithException()
    // {
    //     $id = self::SESSION_NAME . ':sessionid';
    //     $transaction = $this->prophesize(Transaction::class);
    //     $docRef = $this->prophesize(DocumentReference::class);
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($this->collection->reveal());
    //     $this->firestore->runTransaction(Argument::any())
    //         ->shouldBeCalledTimes(1)
    //         ->willThrow(new ServiceException(''));
    //     $this->collection->document($id)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef);

    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal()
    //     );
    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->write('sessionid', 'sessiondata');

    //     $this->assertFalse($ret);
    // }

    // public function testDestroy()
    // {
    //     $id = self::SESSION_NAME . ':sessionid';
    //     $docRef = $this->prophesize(DocumentReference::class);
    //     $docRef->delete()
    //         ->shouldBeCalledTimes(1);
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($this->collection->reveal());
    //     $this->collection->document($id)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef);
    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal()
    //     );
    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->destroy('sessionid');

    //     $this->assertTrue($ret);
    // }

    // /**
    //  * @expectedException PHPUnit_Framework_Error_Warning
    //  */
    // public function testDestroyWithException()
    // {
    //     $id = self::SESSION_NAME . ':sessionid';
    //     $docRef = $this->prophesize(DocumentReference::class);
    //     $docRef->delete()
    //         ->shouldBeCalledTimes(1)
    //         ->willThrow(new ServiceException(''));
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($this->collection->reveal());
    //     $this->collection->document($id)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef);
    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal()
    //     );
    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->destroy('sessionid');

    //     $this->assertFalse($ret);
    // }

    // public function testDefaultGcDoesNothing()
    // {
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($this->collection->reveal());
    //     $this->collection->limit()->shouldNotBeCalled();
    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal()
    //     );
    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->gc(100);

    //     $this->assertTrue($ret);
    // }

    // public function testGc()
    // {
    //     $docRef1 = $this->prophesize(DocumentReference::class);
    //     $docRef1->delete()
    //         ->shouldBeCalledTimes(1);
    //     $snapshot1 = $this->prophesize(DocumentSnapshot::class);
    //     $snapshot1->reference()
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef1);
    //     $docRef2 = $this->prophesize(DocumentReference::class);
    //     $docRef2->delete()
    //         ->shouldBeCalledTimes(1);
    //     $snapshot2 = $this->prophesize(DocumentSnapshot::class);
    //     $snapshot2->reference()
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef2);
    //     $phpunit = $this;
    //     $collection = $this->collection;
    //     $collection->where(
    //         Argument::type('string'),
    //         Argument::type('string'),
    //         Argument::type('int')
    //     )
    //         ->shouldBeCalledTimes(1)
    //         ->will(function ($args) use ($phpunit, $collection) {
    //             $phpunit->assertEquals('t', $args[0]);
    //             $phpunit->assertEquals('<', $args[1]);
    //             $phpunit->assertInternalType('int', $args[2]);
    //             $diff = time() - $args[2];
    //             // 2 seconds grace period should be enough
    //             $phpunit->assertLessThanOrEqual(102, $diff);
    //             $phpunit->assertGreaterThanOrEqual(100, $diff);
    //             return $collection->reveal();
    //         });

    //     $collection->orderBy('t')
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($collection->reveal());
    //     $collection->limit(1000)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($collection->reveal());
    //     $collection->documents()
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn([$snapshot1, $snapshot2]);
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($collection->reveal());

    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal(),
    //         1000
    //     );

    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->gc(100);

    //     $this->assertTrue($ret);
    // }

    // /**
    //  * @expectedException PHPUnit_Framework_Error_Warning
    //  */
    // public function testGcWithException()
    // {
    //     $docRef = $this->prophesize(DocumentReference::class);
    //     $docRef->delete()
    //         ->shouldBeCalledTimes(1)
    //         ->willThrow(new ServiceException(''));
    //     $snapshot = $this->prophesize(DocumentSnapshot::class);
    //     $snapshot->reference()
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($docRef);
    //     $phpunit = $this;
    //     $collection = $this->collection;
    //     $collection->where(
    //         Argument::type('string'),
    //         Argument::type('string'),
    //         Argument::type('int')
    //     )
    //         ->shouldBeCalledTimes(1)
    //         ->will(function ($args) use ($phpunit, $collection) {
    //             $phpunit->assertEquals('t', $args[0]);
    //             $phpunit->assertEquals('<', $args[1]);
    //             $phpunit->assertInternalType('int', $args[2]);
    //             $diff = time() - $args[2];
    //             // 2 seconds grace period should be enough
    //             $phpunit->assertLessThanOrEqual(102, $diff);
    //             $phpunit->assertGreaterThanOrEqual(100, $diff);
    //             return $collection->reveal();
    //         });

    //     $collection->orderBy('t')
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($collection->reveal());
    //     $collection->limit(1000)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($collection->reveal());
    //     $collection->documents()
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn([$snapshot]);
    //     $this->firestore->collection(self::SESSION_SAVE_PATH)
    //         ->shouldBeCalledTimes(1)
    //         ->willReturn($collection->reveal());
    //     $firestoreSessionHandler = new FirestoreSessionHandler(
    //         $this->firestore->reveal(),
    //         1000
    //     );

    //     $firestoreSessionHandler->open(self::SESSION_SAVE_PATH, self::SESSION_NAME);
    //     $ret = $firestoreSessionHandler->gc(100);

    //     $this->assertFalse($ret);
    // }
}
