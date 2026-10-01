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
use Google\ApiCore\OperationsClientInterface;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Status;
use Prophecy\Argument;
use Google\Cloud\Audit\RequestMetadata;
use Google\Cloud\Audit\AuthorizationInfo;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 * @group core-longrunning
 */
class OperationResponseTraitTest extends TestCase
{
    use ProphecyTrait;
    use OperationResponseTrait;

    const RESULT_TYPE = 'resp-type';
    const METADATA_TYPE = 'meta-type';

    const OPERATION_NAME = 'test-operation';

    private $serializer;
    private $operationsClient;
    private $lroResponseMappers = [
        [
            'typeUrl' => self::METADATA_TYPE,
            'message' => RequestMetadata::class,
        ], [
            'typeUrl' => self::RESULT_TYPE,
            'message' => AuthorizationInfo::class,
        ],
    ];

    public function setUp(): void
    {
        $serializer = $this->prophesize(Serializer::class);
        $serializer->encodeMessage(Argument::any())->will(function ($arg) {
            $json = $arg[0]->serializeToJsonString();
            return json_decode($json, true);
        });
        $this->serializer = $serializer->reveal();
        $this->operationsClient = $this->prophesize(OperationsClientInterface::class)->reveal();
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
        $operation = new OperationResponse(
            self::OPERATION_NAME,
            $this->operationsClient,
            ['lastProtoResponse' => $response]
        );
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
        $error = new Status([
            'code' => 1,
            'message' => 'error',
        ]);
        $meta = new RequestMetadata([
            'caller_ip' => '127.8.9.10', // Sic(!)
        ]);
        $response = new Response(self::METADATA_TYPE, $meta);
        $response->error = $error;
        $operation = new OperationResponse(
            self::OPERATION_NAME,
            $this->operationsClient,
            ['lastProtoResponse' => $response]
        );
        $got = $this->operationToArray($operation, $this->serializer, $this->lroResponseMappers);

        $expected = [
            'done' => true,
            'metadata' => [
                'callerIp' => '127.8.9.10',
                'typeUrl' => self::METADATA_TYPE,
            ],
            'error' => [
                'code' => 1,
                'message' => 'error',
            ],
            'response' => null,
        ];
        $this->assertEquals($expected, $got);
    }

    public function testNullProtoResponse()
    {
        $operation = new OperationResponse(self::OPERATION_NAME, $this->operationsClient);
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
        $operation = new OperationResponse(
            self::OPERATION_NAME,
            $this->operationsClient,
            ['lastProtoResponse' => $response]
        );

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

class Value extends Any
{
    public $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return (string) $this->value;
    }
}

class Response extends Operation
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

    public function getResponse(): ?Any
    {
        return new Value($this->response);
    }

    public function getMetadata(): ?Any
    {
        return new Value($this->metadata);
    }

    public function getDone(): bool
    {
        return (isset($this->response) or isset($this->error));
    }

    public function getError(): ?Status
    {
        return $this->error;
    }

    public function serializeToJsonString($options = 0): string
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
