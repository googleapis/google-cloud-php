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

namespace Google\Cloud\Spanner\Tests;

use Google\ApiCore\ServerStream;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\ResultSetMetadata;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\StructType;
use Google\Cloud\Spanner\V1\StructType\Field;
use Google\Cloud\Spanner\V1\Transaction;
use Google\Cloud\Spanner\V1\Type;
use Google\Cloud\Spanner\Database;
use Google\Protobuf\Value;
use Google\Cloud\Spanner\Tests\Unit\Fixtures;

/**
 * Provide a Spanner Read/Query result
 */
trait ResultGeneratorTrait
{
    /**
     * Yield a ResultSet response.
     *
     * @param bool $withStats If true, statistics will be included.
     *        **Defaults to** `false`.
     * @param string|null $transaction If set, the value will be included as the
     *        transaction ID. **Defaults to** `null`.
     * @return \Generator
     */
    private function resultGenerator($withStats = false, $transaction = null)
    {
        return $this->yieldRows([
            [
                'name' => 'ID',
                'type' => Database::TYPE_INT64,
                'value' => '10'
            ]
        ], $withStats, $transaction);
    }

    /**
     * Yield rows with user-specified data.
     *
     * @param array[] $rows A list of arrays containing `name`, `type` and `value` keys.
     * @param ResultSetStats|null $withStats If true, statistics will be included.
     *        **Defaults to** `false`.
     * @param string|null $transactionId If set, the value will be included as the
     *        transaction ID. **Defaults to** `null`.
     * @return \Generator
     */
    private function yieldRows(array $rows, $stats = false, $transactionId = null)
    {
        $fields = [];
        $values = [];
        foreach ($rows as $row) {
            $fields[] = new Field([
                'name' => $row['name'],
                'type' => new Type(['code' => $row['type']])
            ]);

            $values[] = new Value(['string_value' => $row['value']]);
        }

        $result = [
            'metadata' => new ResultSetMetadata([
                'row_type' => new StructType([
                    'fields' => $fields
                ])
            ]),
            'values' => $values
        ];

        if ($stats) {
            $result['stats'] = $stats;
        }

        if ($transactionId) {
            $result['metadata']->setTransaction(new Transaction(['id' => $transactionId]));
        }

        if (isset($result['stats'])) {
            $result['stats'] = $stats;
        }

        yield new PartialResultSet($result);
    }

    /**
     * Yield the given array as a generator.
     *
     * @param array $data The input data
     * @return \Generator
     */
    private function resultGeneratorData(array $data)
    {
        yield $data;
    }

    private function resultGeneratorStream(
        array $chunks = null,
        ResultSetStats $stats = null,
        string $transactionId = null
    ) {
        $this->stream = $this->prophesize(ServerStream::class);
        if ($chunks) {
            foreach ($chunks as $i => $chunk) {
                $result = new PartialResultSet();
                $result->mergeFromJsonString($chunk);
                $chunks[$i] = $result;
            }

            $this->stream->readAll()
                ->willReturn($this->resultGeneratorChunks($chunks));

        } else {
            $this->stream->readAll()
                ->willReturn($this->resultGenerator($stats, $transactionId));
        }

        return $this->stream->reveal();
    }

    private function resultGeneratorChunks($chunks)
    {
        foreach ($chunks as $chunk) {
            yield $chunk;
        }
    }

    private function resultGeneratorJson($chunks)
    {
        foreach ($chunks as $chunk) {
            yield json_decode($chunk, true);
        }
    }

    private function getStreamingDataFixture()
    {
        return json_decode(
            file_get_contents(Fixtures::STREAMING_READ_ACCEPTANCE_FIXTURE()),
            true
        );
    }

    public function streamingDataProviderFirstChunk()
    {
        foreach ($this->getStreamingDataFixture()['tests'] as $test) {
            yield [$test['chunks'], $test['result']['value']];
            break;
        }
    }

    public function streamingDataProvider()
    {
        foreach ($this->getStreamingDataFixture()['tests'] as $test) {
            yield [$test['chunks'], $test['result']['value']];
        }
    }
}
