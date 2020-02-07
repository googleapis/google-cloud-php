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

namespace Google\Cloud\BigQuery\Tests\Unit\Connection;

use Google\Cloud\BigQuery\Connection\Rest;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Upload\AbstractUploader;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

/**
 * @group bigquery
 */
class RestTest extends TestCase
{
    private $requestWrapper;
    private $successBody;

    public function setUp()
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->successBody = '{"canI":"kickIt"}';
    }

    public function testApiEndpoint()
    {
        $endpoint = 'https://foobar.com/';
        $rest = TestHelpers::stub(Rest::class, [
            [
                'apiEndpoint' => $endpoint
            ]
        ], ['requestBuilder']);

        $rb = $rest->___getProperty('requestBuilder');
        $r = new \ReflectionObject($rb);
        $p = $r->getProperty('baseUri');
        $p->setAccessible(true);

        $this->assertEquals($endpoint . 'bigquery/v2/', $p->getValue($rb));
    }

    /**
     * @dataProvider methodProvider
     */
    public function testCallBasicMethods($method)
    {
        $options = [];
        $request = new Request('GET', '/somewhere');
        $response = new Response(200, [], $this->successBody);

        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('array')
        )->willReturn($request);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $rest = new Rest();
        $rest->setRequestBuilder($requestBuilder->reveal());
        $rest->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals(json_decode($this->successBody, true), $rest->$method($options));
    }

    public function methodProvider()
    {
        return [
            ['deleteDataset'],
            ['patchDataset'],
            ['getDataset'],
            ['listDatasets'],
            ['insertDataset'],
            ['deleteTable'],
            ['patchTable'],
            ['getTable'],
            ['insertTable'],
            ['listTables'],
            ['listTableData'],
            ['insertAllTableData'],
            ['query'],
            ['getQueryResults'],
            ['getJob'],
            ['listJobs'],
            ['cancelJob'],
            ['insertJob'],
            ['getServiceAccount'],
            ['getModel'],
            ['listModels'],
            ['patchModel'],
            ['deleteModel'],
            ['insertRoutine'],
            ['updateRoutine'],
            ['getRoutine'],
            ['deleteRoutine'],
            ['listRoutines']
        ];
    }

    public function testInsertJobUpload()
    {
        $actualRequest = null;
        $config = [
            'labels' => [],
            'dryRun' => false,
            'jobReference' => [],
            'configuration' => [
                'load' => [
                    'destinationTable' => [
                        'tableId' => 'myTableId',
                        'datasetId' => 'myDatasetId',
                        'projectId' => 'myProjectId'
                    ]
                ]
            ]
        ];
        $options = [
            'data' => 'justSomeData',
            'projectId' => 'myProjectId',
        ] + $config;
        $response = new Response(200, [], json_encode([
            'jobReference' => [
                'jobId' => 'myJobId'
            ]
        ]));
        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(
            function ($args) use (&$actualRequest, $response) {
                $request = $args[0];
                if ($request->getMethod() === 'POST') {
                    $actualRequest = $request;
                }

                return $response;
            }
        )->shouldBeCalledTimes(1);
        $rest = new Rest();
        $rest->setRequestWrapper($this->requestWrapper->reveal());
        $uploader = $rest->insertJobUpload($options);
        $uploader->upload();
        $metadata = $this->getMetadata($actualRequest);

        $this->assertEquals($config, $metadata);
        $this->assertInstanceOf(AbstractUploader::class, $uploader);
    }

    private function getMetadata(Request $request)
    {
        $lines = explode(PHP_EOL, (string) $request->getBody());
        return json_decode($lines[5], true);
    }
}
