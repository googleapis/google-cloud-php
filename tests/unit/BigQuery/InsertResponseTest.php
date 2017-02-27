<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Unit\BigQuery;

use Google\Cloud\BigQuery\InsertResponse;
use Prophecy\Argument;

/**
 * @group bigquery
 */
class InsertResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $apiResponse = ['kind' => 'bigquery#tableDataInsertAllResponse'];
        $insertResponse = new InsertResponse($apiResponse, []);

        $this->assertTrue($insertResponse->isSuccessful());
        $this->assertEmpty($insertResponse->failedRows());
        $this->assertEquals($apiResponse, $insertResponse->info());
    }

    public function testFailure()
    {
        $index = 0;
        $errors = [
            [
                'reason' => 'invalid',
                'location' => 'test',
                'debugInfo' => 'genric::not_found: no such field.',
                'message' => 'no such field.'
            ]
        ];
        $apiResponse = [
            'insertErrors' => [
                [
                    'index' => $index,
                    'errors' => $errors
                ]
            ]
        ];
        $rows = [
            [
                'json' => ['key' => 'value']
            ]
        ];
        $insertResponse = new InsertResponse($apiResponse, $rows);
        $failedRow = $insertResponse->failedRows()[0];

        $this->assertFalse($insertResponse->isSuccessful());
        $this->assertEquals($index, $failedRow['index']);
        $this->assertEquals($errors, $failedRow['errors']);
        $this->assertEquals($rows[0]['json'], $failedRow['rowData']);
    }
}
