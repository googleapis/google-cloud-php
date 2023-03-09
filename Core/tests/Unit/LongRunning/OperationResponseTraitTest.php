<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Core\Tests\Unit\LongRunning;

use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\ApiCore\Serializer;
use Prophecy\Argument;
use Google\Cloud\Audit\RequestMetadata;
use Google\Cloud\Audit\AuthorizationInfo;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group core-longrunning
 */
class OperationResponseTraitTest extends TestCase
{
    use OperationResponseTrait;

    const RESULT_TYPE = 'resp-type';
    const METADATA_TYPE = 'meta-type';

    const OPERATION_NAME = 'test-operation';

    private $serializer;
    private $lroResponseMappers = [
        [
            'typeUrl' => self::METADATA_TYPE,
            'message' => RequestMetadata::class,
        ], [
            'typeUrl' => self::RESULT_TYPE,
            'message' => AuthorizationInfo::class,
        ],
    ];

    public function set_up()
    {
        $serializer = $this->prophesize(Serializer::class);
        $serializer->encodeMessage(Argument::any())->will(function ($arg) {
            $json = $arg[0]->serializeToJsonString();
            return json_decode($json, true);
        });
        $this->serializer = $serializer->reveal();
    }

    public function testOperationWithResponse()
    {
        $result = new AuthorizationInfo([
            'resource' => 'any',
            'permission' => 'all',
            'granted' => true,
        ]);
        $meta = new RequestMetadata([
            'caller_ip' => '127.8.9.10', // Sic(!)
        ]);
        $response = new Response(self::METADATA_TYPE, $meta, self::RESULT_TYPE, $result);
        $operation = new OperationResponse(self::OPERATION_NAME, null, ['lastProtoResponse' => $response]);
        $got = $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);

        $expected = [
            'done' => true,
            'error' => null,
            'metadata' => [
                'callerIp' => '127.8.9.10',
                'typeUrl' => self::METADATA_TYPE,
            ],
            'response' => [
                'resource' => 'any',
                'permission' => 'all',
                'granted' => true,
            ],
        ];
        $this->assertEquals($expected, $got);
    }

    public function testOperationWithError()
    {
        $error = new AuthorizationInfo([
            'resource' => 'any',
            'permission' => 'all',
            'granted' => true,
        ]);
        $meta = new RequestMetadata([
            'caller_ip' => '127.8.9.10', // Sic(!)
        ]);
        $response = new Response(self::METADATA_TYPE, $meta);
        $response->error = $error;
        $operation = new OperationResponse(self::OPERATION_NAME, null, ['lastProtoResponse' => $response]);
        $got = $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);

        $expected = [
            'done' => true,
            'metadata' => [
                'callerIp' => '127.8.9.10',
                'typeUrl' => self::METADATA_TYPE,
            ],
            'error' => [
                'resource' => 'any',
                'permission' => 'all',
                'granted' => true,
            ],
            'response' => null,
        ];
        $this->assertEquals($expected, $got);
    }

    public function testNullProtoResponse()
    {
        $operation = new OperationResponse(self::OPERATION_NAME, null);
        $got = $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);
        $this->assertNull($got);
    }

    public function testLroCallable()
    {
        $result = new AuthorizationInfo([
            'permission' => 'all',
            'granted' => true,
            'resource' => 'any',
        ]);
        $meta = new RequestMetadata([
            'caller_ip' => '127.8.9.10',
        ]);
        $response = new Response(self::METADATA_TYPE, $meta, self::RESULT_TYPE, $result);
        $operation = new OperationResponse(self::OPERATION_NAME, null, ['lastProtoResponse' => $response]);

        $connection = $this->prophesize(LongRunningConnectionInterface::class);
        $t = $this;
        $connection->get(Argument::any())->will(function () use ($t, $operation) {
            return $t->operationToArray($operation, $t->serializer, $t->lroResponseMappers);
        });
        $callables = [
            [
                'typeUrl' => self::METADATA_TYPE,
                'callable' => function ($result) {
                    return implode('|', [$result['resource'], $result['permission'], $result['granted']]);
                }
            ]
        ];
        $lro = new LongRunningOperation($connection->reveal(), self::OPERATION_NAME, $callables);
        $got = $lro->result();
        $expected = 'any|all|1';
        $this->assertEquals($expected, $got);
    }
}

//@codingStandardsIgnoreStart

class Value
{
    public $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

class Response
{
    public $metadataType;
    public $metadata;
    public $responseType;
    public $response = null;
    public $error = null;

    public function __construct($metaType, $metadata, $respType = null, $response = null)
    {
        $this->metadataType = $metaType;
        $this->metadata = $metadata->serializeToString();
        $this->responseType = $respType;
        if (isset($response)) {
            $this->response = $response->serializeToString();
        }
    }

    public function getResponse()
    {
        return new Value($this->response);
    }

    public function getMetadata()
    {
        return new Value($this->metadata);
    }

    public function getDone()
    {
        return (isset($this->response) or isset($this->error));
    }

    public function getError()
    {
        return $this->error;
    }

    public function serializeToJsonString()
    {
        $result = [
            'done' => true,
            'metadata' => [
                'typeUrl' => $this->metadataType,
                'value' => $this->metadata,
            ],
        ];
        if (isset($this->response)) {
            $result['response'] = [
                'typeUrl' => $this->responseType,
                'value' => $this->response,
            ];
        }

        return json_encode($result);
    }
}

//@codingStandardsIgnoreEnd
