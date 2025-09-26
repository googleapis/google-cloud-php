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
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Tests\Unit\Fixtures;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\ResultSetMetadata;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\StructType;
use Google\Cloud\Spanner\V1\StructType\Field;
use Google\Cloud\Spanner\V1\Transaction;
use Google\Cloud\Spanner\V1\Type;
use Google\Protobuf\Value;

/**
 * Provide a Spanner Read/Query result
 */
trait ResultGeneratorTrait
{
    private function resultGeneratorStream(
        ?array $chunks = null,
        ?ResultSetStats $stats = null,
        ?string $transactionId = null
    ) {
        $stream = $this->prophesize(ServerStream::class);
        $chunks = $chunks ?: [
            [
                'name' => 'ID',
                'type' => Database::TYPE_INT64,
                'value' => '10'
            ]
        ];

        $rows = [];

        if ($chunks) {
            foreach ($chunks as $i => $chunk) {
                if (is_string($chunk)) {
                    // merge from JSON string
                    $result = new PartialResultSet();
                    $result->mergeFromJsonString($chunk);
                    $rows[$i] = $result;
                } elseif ($chunk instanceof PartialResultSet) {
                    $rows[$i] = $chunk;
                }
            }
        }

        if (!$rows) {
            $fields = [];
            $values = [];
            $precommitToken = null;
            foreach ($chunks as $row) {
                $fields[] = new Field([
                    'name' => $row['name'],
                    'type' => new Type(['code' => $row['type']])
                ]);

                $values[] = new Value(['string_value' => (string) $row['value']]);
                $precommitToken ??= $row['precommitToken'] ?? null;
            }

            $result = [
                'metadata' => new ResultSetMetadata([
                    'row_type' => new StructType([
                        'fields' => $fields
                    ])
                ]),
                'values' => $values,
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

            $rows[] = new PartialResultSet($result);

            if ($precommitToken) {
                $rows[0]->setPrecommitToken($precommitToken);
            }
        }

        $stream->readAll()
            ->willReturn($this->resultGeneratorArray($rows));

        return $stream->reveal();
    }

    private function resultGeneratorArray($chunks)
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
