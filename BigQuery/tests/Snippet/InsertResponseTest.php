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

namespace Google\Cloud\BigQuery\Tests\Snippet;

use Google\Cloud\BigQuery\InsertResponse;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;

/**
 * @group bigquery
 */
class InsertResponseTest extends SnippetTestCase
{
    public $insertResponse;
    public $info = [
        'insertErrors' => [
            [
                'index' => 0,
                'errors' => [
                    [
                        'reason' => 'invalid',
                        'location' => 'test',
                        'debugInfo' => 'debugInfo',
                        'message' => 'message'
                    ]
                ]
            ]
        ]
    ];
    public $rows = [
        [
            'json' => [
                'test' => 'test'
            ]
        ]
    ];

    public function setUp(): void
    {
        $this->insertResponse = new InsertResponse($this->info, $this->rows);
    }

    public function testIsSuccessful()
    {
        $snippet = $this->snippetFromMethod(InsertResponse::class, 'isSuccessful');
        $snippet->addLocal('insertResponse', $this->insertResponse);
        $res = $snippet->invoke();

        $this->assertEquals(
            print_r($this->insertResponse->failedRows(), true),
            $res->output()
        );
    }

    public function testFailedRows()
    {
        $snippet = $this->snippetFromMethod(InsertResponse::class, 'failedRows');
        $snippet->addLocal('insertResponse', $this->insertResponse);
        $res = $snippet->invoke();

        $error = $this->info['insertErrors'][0]['errors'][0];
        $expected = print_r($this->rows[0]['json'], true) . $error['reason'] . ': ' . $error['message'] . PHP_EOL;

        $this->assertEquals(
            $expected,
            $res->output()
        );
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(InsertResponse::class, 'info');
        $snippet->addLocal('insertResponse', $this->insertResponse);
        $res = $snippet->invoke();

        $this->assertEquals(print_r($this->info['insertErrors'], true), $res->output());
    }
}
