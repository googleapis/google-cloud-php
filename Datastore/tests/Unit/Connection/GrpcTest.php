<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Datastore\Tests\Unit\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\Connection\Grpc;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\CompositeFilter\Operator as CompositeFilterOperator;
use Google\Cloud\Datastore\V1\GqlQuery;
use Google\Cloud\Datastore\V1\Key;
use Google\Cloud\Datastore\V1\Mutation;
use Google\Cloud\Datastore\V1\PartitionId;
use Google\Cloud\Datastore\V1\PropertyFilter\Operator as PropertyFilterOperator;
use Google\Cloud\Datastore\V1\PropertyOrder;
use Google\Cloud\Datastore\V1\PropertyOrder\Direction;
use Google\Cloud\Datastore\V1\Query;
use Google\Cloud\Datastore\V1\ReadOptions;
use Google\Cloud\Datastore\V1\ReadOptions\ReadConsistency;
use Google\Cloud\Datastore\V1\TransactionOptions;
use Google\Protobuf\NullValue;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Prophecy\Argument;

/**
 * @group datastore
 * @group datastore-connection
 */
class GrpcTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;
    use GrpcTrait;

    const PROJECT_ID = 'my-project';

    private $successMessage;

    private $serializer;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
        $this->serializer = new Serializer;
    }

    public function testApiEndpoint()
    {
        $expected = 'foobar.com';

        $grpc = new GrpcStub(['apiEndpoint' => $expected]);

        $this->assertEquals($expected, $grpc->config['apiEndpoint']);
    }

    public function testAllocateIds()
    {
        $key = [
            'partitionId' => [
                'projectId' => self::PROJECT_ID
            ],
            'path' => [
                [
                    'kind' => 'foo'
                ]
            ]
        ];

        $args = [
            'projectId' => self::PROJECT_ID,
            'keys' => [$key],
        ];

        $expectedArgs = [
            self::PROJECT_ID,
            [$this->serializer->decodeMessage(new Key, $key)],
            []
        ];

        $this->assertRunsServiceCall('allocateIds', $args, $expectedArgs);
    }

    public function testBeginTransaction()
    {
        $args = [
            'projectId' => self::PROJECT_ID,
            'transactionOptions' => [
                'readWrite' => [
                    'previousTransaction' => '1234'
                ]
            ]
        ];

        $expectedArgs = [
            self::PROJECT_ID,
            [
                'transactionOptions' => $this->serializer->decodeMessage(
                    new TransactionOptions,
                    $args['transactionOptions']
                )
            ]
        ];

        $this->assertRunsServiceCall('beginTransaction', $args, $expectedArgs);
    }

    /**
     * @dataProvider modes
     */
    public function testCommit($mode)
    {
        $timestamp = new Timestamp(new \DateTime);

        $mutation = [
            'insert' => [
                'key' => [
                    'partitionId' => [
                        'projectId' => self::PROJECT_ID
                    ],
                    'path' => [
                        [
                            'kind' => 'foo',
                            'id' => 1
                        ]
                    ]
                ],
                'properties' => [
                    'prop' => [
                        'stringValue' => 'val'
                    ],
                    'nullVal' => [
                        'nullValue' => null
                    ],
                    'time' => [
                        'timestampValue' => $timestamp->formatAsString()
                    ],
                    'point' => [
                        'geoPointValue' => [
                            'latitude' => 1.0,
                            'longitude' => null
                        ]
                    ]
                ]
            ]
        ];

        $args = [
            'projectId' => self::PROJECT_ID,
            'mode' => $mode,
            'mutations' => [
                $mutation
            ]
        ];

        $mutation['insert']['properties']['nullVal']['nullValue'] = NullValue::NULL_VALUE;
        $mutation['insert']['properties']['time']['timestampValue'] = $timestamp->formatForApi();
        $mutation['insert']['properties']['point']['geoPointValue'] = [
            'latitude' => 1.0,
            'longitude' => 0.0
        ];

        $expectedArgs = [
            self::PROJECT_ID,
            constant(Mode::class .'::' . $mode),
            [$this->serializer->decodeMessage(new Mutation, $mutation)],
            []
        ];

        $this->assertRunsServiceCall('commit', $args, $expectedArgs);
    }

    public function modes()
    {
        return [
            ['TRANSACTIONAL'],
            ['NON_TRANSACTIONAL']
        ];
    }

    /**
     * @dataProvider readOptions
     */
    public function testLookup($readOptions, $readOptionsProto)
    {
        $args = [
            'projectId' => self::PROJECT_ID,
            'keys' => [
                [
                    'partitionId' => [
                        'projectId' => self::PROJECT_ID,
                        'namespaceId' => 'foobar'
                    ],
                    'path' => [
                        [
                            'kind' => 'person',
                            'name' => 'steve'
                        ]
                    ]
                ]
            ],
            'readOptions' => $readOptions
        ];

        $keysList = [];
        foreach ($args['keys'] as $key) {
            $keysList[] = $this->serializer->decodeMessage(new Key, $key);
        }

        $expectedArgs = [
            self::PROJECT_ID,
            $keysList,
            [
                'readOptions' => $readOptionsProto
            ]
        ];

        $this->assertRunsServiceCall('lookup', $args, $expectedArgs);
    }

    public function readOptions()
    {
        $this->setUp();

        $readOptionsTransaction = [
            'transaction' => 1234
        ];

        $strongConsistency = [
            'readConsistency' => 'STRONG'
        ];

        $strongConsistencyProto = new ReadOptions([
            'read_consistency' => ReadConsistency::STRONG
        ]);

        $eventualConsistency = [
            'readConsistency' => 'EVENTUAL'
        ];

        $eventualConsistencyProto = new ReadOptions([
            'read_consistency' => ReadConsistency::EVENTUAL
        ]);

        return [
            [
                $readOptionsTransaction,
                $this->serializer->decodeMessage(new ReadOptions, $readOptionsTransaction)
            ], [
                $strongConsistency,
                $strongConsistencyProto
            ], [
                $eventualConsistency,
                $eventualConsistencyProto
            ]
        ];
    }

    public function testRollback()
    {
        $args = [
            'projectId' => self::PROJECT_ID,
            'transaction' => '1234'
        ];

        $expectedArgs = [
            self::PROJECT_ID,
            '1234',
            []
        ];

        $this->assertRunsServiceCall('rollback', $args, $expectedArgs);
    }

    public function testRunQuery()
    {
        $timestamp = new Timestamp(new \DateTime);

        $query = [
            'order' => [
                [
                    'property' => [
                        'name' => 'foo'
                    ],
                    'direction' => 'DESCENDING',
                ], [
                    'property' => [
                        'name' => 'bar'
                    ],
                    'direction' => 'ASCENDING'
                ]
            ],
            'limit' => 500
        ];

        $gqlQuery = [
            'queryString' => 'SELECT 1=1',
            'allowLiterals' => false,
            'namedBindings' => [
                'foo' => [
                    'value' => [
                        'timestampValue' => $timestamp->formatAsString()
                    ]
                ],
                'bar' => [
                    'cursor' => '1234'
                ]
            ],
            'positionalBindings' => [
                [
                    'value' => [
                        'timestampValue' => $timestamp->formatAsString()
                    ]
                ], [
                    'cursor' => '531252'
                ]
            ]
        ];

        $args = [
            'projectId' => self::PROJECT_ID,
            'partitionId' => [
                'projectId' => self::PROJECT_ID,
                'namespaceId' => 'foobar'
            ],
            'readOptions' => [
                'transaction' => '1234'
            ],
            'query' => $query,
            'gqlQuery' => $gqlQuery
        ];

        $gqlQuery['namedBindings']['foo']['value']['timestampValue'] = $timestamp->formatForApi();
        $gqlQuery['positionalBindings'][0]['value']['timestampValue'] = $timestamp->formatForApi();

        $expectedArgs = [
            self::PROJECT_ID,
            $this->serializer->decodeMessage(new PartitionId, $args['partitionId']),
            [
                'readOptions' => $this->serializer->decodeMessage(new ReadOptions, $args['readOptions']),
                'query' => $this->serializer->decodeMessage(new Query, [
                    'order' => [
                        [
                            'property' => [
                                'name' => 'foo'
                            ],
                            'direction' => Direction::DESCENDING
                        ],
                        [
                            'property' => [
                                'name' => 'bar'
                            ],
                            'direction' => Direction::ASCENDING
                        ]
                    ],
                    'limit' => [
                        'value' => 500
                    ]
                ]),
                'gqlQuery' => $this->serializer->decodeMessage(new GqlQuery, $gqlQuery),
            ]
        ];

        $this->assertRunsServiceCall('runQuery', $args, $expectedArgs);
    }

    /**
     * @dataProvider propertyFilters
     */
    public function testQueryPropertyFilters($operator)
    {
        $query = [
            'filter' => [
                'propertyFilter' => [
                    'property' => [
                        'name' => 'foo'
                    ],
                    'op' => $operator,
                    'value' => [
                        'stringValue' => 'bar'
                    ]
                ]
            ]
        ];

        $args = [
            'projectId' => self::PROJECT_ID,
            'partitionId' => [
                'projectId' => self::PROJECT_ID,
            ],
            'query' => $query
        ];

        $operator = $query['filter']['propertyFilter']['op'];
        $constName = PropertyFilterOperator::class .'::'. $operator;
        $query['filter']['propertyFilter']['op'] = defined($constName)
            ? constant($constName)
            : 0;

        $expectedArgs = [
            self::PROJECT_ID,
            $this->serializer->decodeMessage(new PartitionId, $args['partitionId']),
            [
                'query' => $this->serializer->decodeMessage(new Query, $query)
            ]
        ];

        $this->assertRunsServiceCall('runQuery', $args, $expectedArgs);
    }

    public function testQueryCompositeFilter()
    {
        $query = [
            'filter' => [
                'compositeFilter' => [
                    'op' => 'AND',
                    'filters' => [
                        [
                            'propertyFilter' => [
                                'property' => [
                                    'name' => 'foo'
                                ],
                                'op' => 'EQUAL',
                                'value' => [
                                    'stringValue' => 'bar'
                                ]
                            ]
                        ], [
                            'compositeFilter' => [
                                'op' => 'AND',
                                'filters' => [
                                    [
                                        'propertyFilter' => [
                                            'property' => [
                                                'name' => 'foo'
                                            ],
                                            'op' => 'EQUAL',
                                            'value' => [
                                                'stringValue' => 'bar'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $args = [
            'projectId' => self::PROJECT_ID,
            'partitionId' => [
                'projectId' => self::PROJECT_ID,
            ],
            'query' => $query
        ];

        $query['filter']['compositeFilter']['op'] = CompositeFilterOperator::PBAND;
        $query['filter']['compositeFilter']['filters'][0]['propertyFilter']['op'] = PropertyFilterOperator::EQUAL;

        $query['filter']['compositeFilter']['filters'][1]['compositeFilter']['op'] = CompositeFilterOperator::PBAND;
        $query['filter']['compositeFilter']['filters'][1]['compositeFilter']['filters'][0]['propertyFilter']['op']
            = PropertyFilterOperator::EQUAL;

        $expectedArgs = [
            self::PROJECT_ID,
            $this->serializer->decodeMessage(new PartitionId, $args['partitionId']),
            [
                'query' => $this->serializer->decodeMessage(new Query, $query)
            ]
        ];

        $this->assertRunsServiceCall('runQuery', $args, $expectedArgs);
    }

    public function propertyFilters()
    {
        return [
            ['LESS_THAN'],
            ['LESS_THAN_OR_EQUAL'],
            ['GREATER_THAN'],
            ['GREATER_THAN_OR_EQUAL'],
            ['EQUAL'],
            ['HAS_ANCESTOR'],
        ];
    }

    /**
     * @dataProvider invalidFilters
     */
    public function testInvalidFilter($filter)
    {
        $this->expectException('InvalidArgumentException');

        return $this->testQueryPropertyFilters($filter);
    }

    public function invalidFilters()
    {
        return [
            ['F00'],
            [9999999]
        ];
    }

    private function assertRunsServiceCall($method, $args, $expectedArgs, $return = null, $result = '')
    {
        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($return ?: $this->successMessage);

        $grpc = new Grpc();
        $grpc->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($result !== '' ? $result : $this->successMessage, $grpc->$method($args));
    }
}

//@codingStandardsIgnoreStart
class GrpcStub extends Grpc
{
    public $config;

    protected function constructGapic($gapicName, array $config)
    {
        $this->config = $config;

        return parent::constructGapic($gapicName, $config);
    }
}
//@codingStandardsIgnoreEnd
