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

namespace Google\Cloud\Bigtable\Tests\Conformance;

use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse_CellChunk;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ReadRowsTest extends TestCase
{
    private $serverStream;

    public function set_up()
    {
        $this->serverStream = $this->prophesize(ServerStream::class);
    }

    /**
     * @dataProvider rowsProvider
     */
    public function testReadRows($readRowsResponses, $expectedRows, $expectedErrorCount, $message)
    {
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator($readRowsResponses)
        );
        $chunkFormatter = new ChunkFormatter(
            $this->serverStream->reveal()
        );
        $rows = [];
        $errorCount = 0;
        try {
            foreach ($chunkFormatter->readAll() as $rowKey => $row) {
                $rows[$rowKey] = $row;
            }
        } catch (BigtableDataOperationException $e) {
            $errorCount = 1;
        }
        $this->assertEquals($expectedRows, $rows, $message);
        $this->assertEquals($expectedErrorCount, $errorCount, $message);
    }

    public function rowsProvider()
    {
        $str = file_get_contents(__DIR__ . '/fixtures/read-rows-test.json');
        $json = json_decode($str, true)['tests'];
        $testsData = [];
        foreach ($json as $test) {
            $responses = [];
            foreach ($test['chunks_base64'] as $chunk) {
                $chunk = base64_decode($chunk);
                $cellChunk = new ReadRowsResponse_CellChunk();
                $cellChunk->mergeFromString($chunk);
                $response =  new ReadRowsResponse();
                $response->setChunks([$cellChunk]);
                $responses[] = $response;
            }
            $rows = [];
            $errorCount = 0;
            $rawResults = ($test['results'])?$test['results']:[];
            $error = array_filter($rawResults, function ($var) {
                    return $var['error'] == 1;
            });
            $errorCount = count($error);

            $notError = array_filter($rawResults, function ($var) {
                return $var['error'] == '' || $var['error'] == 0;
            });
            foreach ($notError as $k => $result) {
                $rowKey = $result['rk'];
                $familyName = $result['fm'];
                $qualifierName = $result['qual'];
                $labels = $result['label'];
                $timestamp = $result['ts'];
                $value = $result['value'];
                if (!isset($rows[$rowKey])) {
                    $rows[$rowKey] = [];
                }
                $row = &$rows[$rowKey];
                if (!isset($row[$familyName])) {
                    $row[$familyName] = [];
                }
                $family = &$row[$familyName];
                if (!isset($family[$qualifierName])) {
                    $family[$qualifierName] = [];
                }
                $family[$qualifierName][] = [
                    'value' => $value,
                    'labels' => $labels,
                    'timeStamp' => $timestamp
                ];
            }
            $testsData[] = [
                $responses,
                $rows,
                $errorCount,
                $test['name'] . ' failed'
            ];
        }
        return $testsData;
    }

    private function arrayAsGenerator(array $array)
    {
        foreach ($array as $item) {
            yield $item;
        }
    }
}
