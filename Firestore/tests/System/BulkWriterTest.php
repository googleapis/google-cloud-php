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
use Google\Cloud\Firestore\Tests\Unit\GenerateProtoTrait;
use Google\Cloud\Firestore\Tests\Unit\ServerStreamMockTrait;
use Google\Cloud\Firestore\V1\BatchWriteRequest;
use Google\Cloud\Firestore\V1\BatchWriteResponse;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\Write;
use Google\Cloud\Firestore\ValueMapper;
use Google\Rpc\Code;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group firestore
 * @group firestore-bulkwriter
 */
class BulkWriterTest extends FirestoreTestCase
{
    use GenerateProtoTrait;
    use ProphecyTrait;

    private $document;
    private $bulkwriter;
    private $batch;

    public function setUp(): void
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
        $gapicClient = $this->prophesize(FirestoreClient::class);
        $this->batch = TestHelpers::stub(BulkWriter::class, [
            $gapicClient->reveal(),
            new ValueMapper($gapicClient->reveal(), false),
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

        $protoResponse = self::generateProto(BatchWriteResponse::class, [
            'writeResults' => array_fill(0, $batchSize, []),
            'status' => array_merge(
                array_fill(0, $successPerBatch, [
                    'code' => Code::OK,
                ]),
                array_fill(0, $batchSize - $successPerBatch, [
                    'code' => Code::DATA_LOSS,
                ]),
            ),
        ]);

        $gapicClient->batchWrite(
            Argument::that(function (BatchWriteRequest $request) use ($docs, $successPerBatch, &$successfulDocs){
                $this->assertGreaterThan(0, count($request->getWrites()));

                /**
                 * @var Write $write
                 */
                foreach($request->getWrites() as $i => $write) {
                    $this->assertNotEmpty($write->getCurrentDocument());
                    $this->assertEquals(
                        $docs[$write->getUpdate()->getFields()['key']->getIntegerValue()]->name(),
                        $write->getUpdate()->getFields()['path']->getReferenceValue()
                    );
                    if ($i < $successPerBatch) {
                        $successfulDocs[] = $write->getUpdate()->getFields()['path']->getReferenceValue();
                    }
                }

                return true;
            }),
            Argument::any()
        )->shouldBeCalledTimes(10)
            ->willReturn($protoResponse);

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
