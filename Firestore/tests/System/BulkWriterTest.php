<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\System;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\BulkWriter;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\ValueMapper;
use Google\Rpc\Code;
use Prophecy\Argument;

/**
 * @group firestore
 * @group firestore-bulkwriter
 */
class BulkWriterTest extends FirestoreTestCase
{
    private $document;
    private $bulkwriter;

    public function set_up()
    {
        $doc = self::$collection->newDocument();
        $this->bulkwriter = self::$client->bulkWriter();
        $this->document = $doc;
    }

    public function testInsert()
    {
        $this->assertFalse($this->document->snapshot()->exists());

        $this->bulkwriter->create($this->document, [
            'foo' => 'bar',
        ]);
        $this->bulkwriter->flush();

        $this->assertTrue($this->document->snapshot()->exists());
    }

    public function testLongCreateMultipleDocsWithDelay()
    {
        $docs = $this->bulkDocuments();
        $throttledBulkwriter = self::$client->bulkWriter([
            'initialOpsPerSecond' => 5,
            'maxOpsPerSecond' => 10,
            'greedilySend' => false,
        ]);
        foreach ($docs as $k => $v) {
            $this->assertFalse($this->document->snapshot()->exists());
            $throttledBulkwriter->create($v, [
                'key' => $k,
                'value' => $v,
            ]);
        }
        $startTime = floor(microtime(true) * 1000);
        $throttledBulkwriter->flush();
        $endTime = floor(microtime(true) * 1000);

        $this->assertGreaterThan(2 * 1000, $endTime - $startTime);
        $this->assertLessThan(10 * 1000, $endTime - $startTime);

        $documents = self::$collection->where('key', '>=', 0)->documents();
        $this->assertEquals(count($docs), $documents->size());
        foreach ($documents as $document) {
            $this->assertTrue($document->exists());
            $this->assertArrayHasKey('key', $document->data());
            $this->assertArrayHasKey('value', $document->data());
            $this->assertStringContainsString(
                $docs[$document->data()['key']]->name(),
                $document->data()['value']->name()
            );
        }
    }

    public function testLongFailuresAreRetriedWithDelay()
    {
        $docs = $this->bulkDocuments();
        $connection = $this->prophesize(ConnectionInterface::class);
        $this->batch = TestHelpers::stub(BulkWriter::class, [
            $connection->reveal(),
            new ValueMapper($connection->reveal(), false),
            self::$collection->name(),
            [
                'initialOpsPerSecond' => 5,
                'maxOpsPerSecond' => 10,
                'greedilySend' => false,
            ],
        ]);
        $batchSize = 20;
        $successPerBatch = $batchSize * 3 / 4;
        $successfulDocs = [];
        $connection->batchWrite(Argument::that(
            function ($arg) use ($docs, $successPerBatch, &$successfulDocs) {
                if (count($arg['writes']) <= 0) {
                    return false;
                }
                foreach ($arg['writes'] as $i => $write) {
                    if (!$write['currentDocument']) {
                        return false;
                    }
                    if ($docs[$write['update']['fields']['key']['integerValue']]->name()
                        !== $write['update']['fields']['path']['referenceValue']) {
                        return false;
                    }
                    if ($i < $successPerBatch) {
                        $successfulDocs[] = $write['update']['fields']['path']['referenceValue'];
                    }
                }
                return true;
            }
        ))
            ->shouldBeCalledTimes(10)
            ->willReturn(
                [
                    'writeResults' => array_fill(0, $batchSize, []),
                    'status' => array_merge(
                        array_fill(0, $successPerBatch, [
                            'code' => Code::OK,
                        ]),
                        array_fill(0, $batchSize - $successPerBatch, [
                            'code' => Code::DATA_LOSS,
                        ]),
                    ),
                ]
            );
        foreach ($docs as $k => $v) {
            $this->batch->create($v, [
                'key' => $k,
                'path' => $v,
            ]);
        }

        $startTime = floor(microtime(true) * 1000);
        $this->batch->flush();
        $endTime = floor(microtime(true) * 1000);
        $this->assertGreaterThan(2 * 1000, $endTime - $startTime);
        $this->assertLessThan(10 * 1000, $endTime - $startTime);
        $this->assertEquals(count($docs), count($successfulDocs));
        for ($i = 0; $i < count($docs); $i++) {
            $this->assertContains($docs[$i]->name(), $successfulDocs);
        }
    }

    public function testUpdate()
    {
        $this->document->create([
            'foo' => 'bar',
        ]);

        $this->bulkwriter->update($this->document, [
            ['path' => 'bat', 'value' => 'baz'],
        ]);
        $this->bulkwriter->flush();

        $this->assertEquals([
            'foo' => 'bar',
            'bat' => 'baz',
        ], $this->document->snapshot()->data());
    }

    public function testSet()
    {
        $this->document->create([
            'foo' => 'bar',
        ]);

        $this->bulkwriter->set($this->document, [
            'bat' => 'baz',
        ]);
        $this->bulkwriter->flush();

        $this->assertEquals([
            'bat' => 'baz',
        ], $this->document->snapshot()->data());
    }

    public function testSetMerge()
    {
        $this->document->create([
            'foo' => 'bar',
        ]);

        $this->bulkwriter->set(
            $this->document,
            [
                'bat' => 'baz',
            ],
            [
                'merge' => true,
            ]
        );
        $this->bulkwriter->flush();

        $this->assertEquals([
            'foo' => 'bar',
            'bat' => 'baz',
        ], $this->document->snapshot()->data());
    }

    public function testDelete()
    {
        $this->document->create([
            'foo' => 'bar',
        ]);
        $this->assertTrue($this->document->snapshot()->exists());

        $this->bulkwriter->delete(
            $this->document,
        );
        $this->bulkwriter->flush();

        $this->assertFalse($this->document->snapshot()->exists());
    }

    public function bulkDocuments()
    {
        $docs = [];
        for ($i = 0; $i < 50; $i++) {
            $docs[] = self::$collection->newDocument();
        }

        return $docs;
    }
}
