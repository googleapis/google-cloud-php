<?php
/**
 * Copyright 2019, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\ApiCore\ApiException;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Serializer;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry as RequestEntry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry as ResponseEntry;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk as ReadRowsResponse_CellChunk;
use Google\Protobuf\StringValue;
use Google\Protobuf\BytesValue;
use Google\Rpc\Code;
use Google\Rpc\Status;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtabledata
 * @group bigtabledatasmartretries
 */
class SmartRetriesTest extends TestCase
{
    use ProphecyTrait;

    const HEADER = 'my-header';
    const HEADER_VALUE = 'my-header-value';
    const APP_PROFILE = 'my-app-profile';
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';
    const TIMESTAMP = 1534183334215000;

    private $bigtableClient;
    private $table;
    private $options;
    private $serverStream;
    private $retryingApiException;
    private $nonRetryingApiException;

    public function setUp(): void
    {
        $this->retryingApiException = new ApiException(
            'DEADLINE_EXCEEDED',
            Code::DEADLINE_EXCEEDED,
            'DEADLINE_EXCEEDED'
        );
        $this->nonRetryingApiException = new ApiException(
            'UNAUTHENTICATED',
            Code::UNAUTHENTICATED,
            'UNAUTHENTICATED'
        );
        $this->bigtableClient = $this->prophesize(BigtableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);
        $this->options = [
            'appProfileId' => self::APP_PROFILE,
            'headers' => [self::HEADER => self::HEADER_VALUE]
        ];
        $this->table = new Table(
            $this->bigtableClient->reveal(),
            new Serializer(),
            self::TABLE_NAME,
            $this->options
        );
    }

    public function testReadRowsShouldRetryDefaultTimes()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('DEADLINE_EXCEEDED');

        $expectedArgs = $this->options;
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(4)
            ->willThrow(
                $this->retryingApiException
            );
        $this->bigtableClient->readRows(
            Argument::type(ReadRowsRequest::class),
            Argument::type('array')
        )->shouldBeCalledTimes(4)
        ->willReturn(
            $this->serverStream->reveal()
        );
        $args = [];
        $iterator = $this->table->readRows($args);
        $iterator->getIterator()->current();
    }

    public function testReadRowsShouldRetryForProvidedAttempts()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('DEADLINE_EXCEEDED');

        $expectedArgs = $this->options;
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(6)
            ->willThrow(
                $this->retryingApiException
            );
        $this->bigtableClient->readRows(
            Argument::type(ReadRowsRequest::class),
            Argument::type('array')
        )->shouldBeCalledTimes(6)
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = ['retrySettings' => ['maxRetries' => 5]];
        $iterator = $this->table->readRows($args);
        $iterator->getIterator()->current();
    }

    public function testReadRowsContainsAttemptHeader()
    {
        $attempt = 0;
        $expectedArgs = $this->options;
        $retryingApiException = $this->retryingApiException;
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->will(function () use (&$attempt, $retryingApiException) {
                // throw a retriable exception on the first call
                return 0 === $attempt++ ? throw $retryingApiException : [];
            });
        $this->bigtableClient->readRows(
            Argument::type(ReadRowsRequest::class),
            Argument::that(function ($callOptions) use (&$attempt) {
                $attemptHeader = $callOptions['headers']['bigtable-attempt'][0] ?? null;
                if ($attempt === 0) {
                    $this->assertNull($attemptHeader);
                } else {
                    $this->assertSame((string) $attempt, $attemptHeader);
                }

                return true;
            })
        )->shouldBeCalledTimes(2)
            ->willReturn(
                $this->serverStream->reveal()
            );

        $iterator = $this->table->readRows();
        $iterator->getIterator()->current();
    }

    public function testReadRowsPartialSuccess()
    {
        $expectedArgs = $this->options;
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    array_merge($this->generateRowsResponse(1, 2), [$this->generatePartialRowResponse(3)]),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    [],
                    $this->nonRetryingApiException
                )
            );
        $this->bigtableClient->readRows(
            Argument::type(ReadRowsRequest::class),
            Argument::type('array')
        )->willReturn(
            $this->serverStream->reveal()
        );
        $args = [];
        $iterator = $this->table->readRows($args);
        $rows = [];
        try {
            foreach ($iterator as $rowKey => $row) {
                $rows[$rowKey] = $row;
            }
            $this->fail('Expected exception is not thrown');
        } catch (ApiException $e) {
            $expectedOutputSoFar = $this->generateExpectedRows(1, 2);
            $this->assertEquals($expectedOutputSoFar, $rows);
        }
    }

    public function testReadRowsWithRowsLimit()
    {
        $args = ['rowsLimit' => 5];
        $expectedArgs = $args + $this->options;
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(1, 2),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(3, 4)
                )
            );

        $allowedRowsLimit = ['5' => 1, '3' => 1];
        $this->bigtableClient->readRows(
            Argument::that(function ($request) use (&$allowedRowsLimit) {
                $rowsLimit = $request->getRowsLimit();
                if (!isset($allowedRowsLimit[$rowsLimit]) || $allowedRowsLimit[$rowsLimit] == 0) {
                    return false;
                }

                // This means that once we have encountered a `rowsLimit` in a request.
                // We decrease the number of times the request is allowed with the particular rowsLimit.
                $allowedRowsLimit[$rowsLimit] -= 1;
                return true;
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );

        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = $this->generateExpectedRows(1, 4);
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsWithRowsLimitAndExceptionThrownAfterSuccess()
    {
        $args = ['rowsLimit' => 1];
        $expectedArgs = $args + $this->options;
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(1)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(1, 1),
                    $this->retryingApiException
                )
            );
        $this->bigtableClient->readRows(
            Argument::that(function ($request) use (&$allowedRowsLimit) {
                return $request->getRowsLimit() === 1;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(1)
            ->willReturn(
                $this->serverStream->reveal()
            );

        $rows = $this->table->readRows($args);
        $expectedRows = $this->generateExpectedRows(1, 1);
        $this->assertEquals($expectedRows, iterator_to_array($rows));
    }

    public function testReadRowsWithRowKeys()
    {
        $args = ['rowKeys' => ['rk1', 'rk2', 'rk3', 'rk4']];
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(1, 2),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(3, 4)
                )
            );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return iterator_to_array($request->getRows()->getRowKeys()) === ['rk1', 'rk2', 'rk3', 'rk4'];
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return iterator_to_array($request->getRows()->getRowKeys()) === ['rk3', 'rk4'];
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );
        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = $this->generateExpectedRows(1, 4);
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRangeStartKeyOpen()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(6, 7),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(8, 9)
                )
            );

            $this->bigtableClient->readRows(
                Argument::that(function ($request) {
                    return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === 'rk5';
                }),
                Argument::type('array')
            )->shouldBeCalledTimes(1)
            ->willReturn(
                $this->serverStream->reveal()
            );

            $this->bigtableClient->readRows(
                Argument::that(function ($request) {
                    return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === 'rk7';
                }),
                Argument::type('array')
            )->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = ['rowRanges' => [
            ['startKeyOpen' => 'rk5']
        ]];
        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = $this->generateExpectedRows(6, 9);
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRangeStartKeyClosed()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(5, 6),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(7, 9)
                )
            );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return $request->getRows()->getRowRanges()[0]->getStartKeyClosed() === 'rk5';
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === 'rk6';
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );
        $args = ['rowRanges' => [
            ['startKeyClosed' => 'rk5']
        ]];
        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = $this->generateExpectedRows(5, 9);
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRangeEndKeyOpen()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(1, 3),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(4, 6)
                )
            );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === '' &&
                $request->getRows()->getRowRanges()[0]->getEndKeyOpen() === 'rk7';
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === 'rk3' &&
                $request->getRows()->getRowRanges()[0]->getEndKeyOpen() === 'rk7';
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );

        $args = ['rowRanges' => [
            ['endKeyOpen' => 'rk7']
        ]];
        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = $this->generateExpectedRows(1, 6);
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRangeEndKeyClosed()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(1, 3),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(4, 7)
                )
            );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === '' &&
                $request->getRows()->getRowRanges()[0]->getEndKeyClosed() === 'rk7';
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                return $request->getRows()->getRowRanges()[0]->getStartKeyOpen() === 'rk3' &&
                $request->getRows()->getRowRanges()[0]->getEndKeyClosed() === 'rk7';
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );

        $args = ['rowRanges' => [
            ['endKeyClosed' => 'rk7']
        ]];
        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = $this->generateExpectedRows(1, 7);
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRangeWithSomeCompletedRange()
    {
        $expectedRows = (new RowSet)->setRowRanges([
            (new RowRange)->setStartKeyOpen('rk1')->setEndKeyClosed('rk3'),
            (new RowRange)->setStartKeyClosed('rk5')->setEndKeyClosed('rk7'),
            (new RowRange)->setStartKeyClosed('rk8')->setEndKeyClosed('rk9')
        ]);
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    array_merge($this->generateRowsResponse(2, 3), $this->generateRowsResponse(5, 6)),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(7, 9)
                )
            );

        $this->bigtableClient->readRows(
            Argument::that(function ($request) use ($expectedRows) {
                return $request->getRows()->serializeToJsonString() === $expectedRows->serializeToJsonString();
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $expectedRows2 = (new RowSet)->setRowRanges([
            (new RowRange)->setStartKeyOpen('rk6')->setEndKeyClosed('rk7'),
            (new RowRange)->setStartKeyClosed('rk8')->setEndKeyClosed('rk9')
        ]);

        $this->bigtableClient->readRows(
            Argument::that(function ($request) use ($expectedRows2) {
                return $request->getRows()->serializeToJsonString() === $expectedRows2->serializeToJsonString();
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );

        $args = ['rowRanges' => [
            ['startKeyOpen' => 'rk1', 'endKeyClosed' => 'rk3'],
            ['startKeyClosed' => 'rk5', 'endKeyClosed' => 'rk7'],
            ['startKeyClosed' => 'rk8', 'endKeyClosed' => 'rk9']
        ]];
        $iterator = $this->table->readRows($args);
        $rows = [];
        foreach ($iterator as $rowKey => $row) {
            $rows[$rowKey] = $row;
        }
        $expectedRows = array_merge($this->generateExpectedRows(2, 3), $this->generateExpectedRows(5, 9));
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsWithRetryableErrorAfterAllDataReceived()
    {
        $this->serverStream->readAll()->willReturn(
            $this->arrayAsGeneratorWithException(
                $this->generateRowsResponse(1, 3),
                $this->retryingApiException
            ),
            $this->arrayAsGeneratorWithException([])
        );

        // First Call
        // Check if the request has expected row range
        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                $rowRanges = $request->getRows()->getRowRanges();
                if (count($rowRanges) === 0) {
                    return false;
                }
                $rowRange = $rowRanges[0];
                return $rowRange->getStartKeyClosed() === 'rk1' &&
                    $rowRange->getEndKeyClosed() === 'rk3';
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        // Second Call
        // Check if the request has empty row range and fail the test
        // as this will result in full table scan
        $this->bigtableClient->readRows(
            Argument::that(function ($request) {
                $rowRanges = $request->getRows()->getRowRanges();
                return !count($rowRanges);
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $args = [
            'rowRanges' => [[
                'startKeyClosed' => 'rk1',
                'endKeyClosed' => 'rk3'
            ]]
        ];
        $iterator = $this->table->readRows($args);
        $this->assertCount(3, $iterator);
    }

    public function testMutateRowsShouldRetryDefaultNumberOfTimes()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('DEADLINE_EXCEEDED');

        $this->serverStream->readAll()
            ->shouldBeCalledTimes(4)
            ->willThrow(
                $this->retryingApiException
            );
        $mutations = $this->generateMutations(1, 5);
        $entries = $this->generateEntries(1, 5);
        $this->bigtableClient->mutateRows(
            Argument::type(MutateRowsRequest::class),
            Argument::type('array')
        )->shouldBeCalledTimes(4)
        ->willReturn(
            $this->serverStream->reveal()
        );
        $this->table->mutateRows($mutations);
    }

    public function testMutateRowsRespectRetriesAttempt()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('DEADLINE_EXCEEDED');

        $this->serverStream->readAll()
            ->shouldBeCalledTimes(6)
            ->willThrow(
                $this->retryingApiException
            );
        $mutations = $this->generateMutations(1, 5);
        $entries = $this->generateEntries(1, 5);
        $this->bigtableClient->mutateRows(
            Argument::type(MutateRowsRequest::class),
            Argument::type('array')
        )->shouldBeCalledTimes(6)
        ->willReturn(
            $this->serverStream->reveal()
        );
        $this->table->mutateRows($mutations, ['retrySettings' => ['maxRetries' => 5]]);
    }

    public function testMutateRowsOnlyRetriesFailedEntries()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->getMutateRowsResponse(5, [2 => Code::ABORTED, 3 => Code::ABORTED])
                ),
                $this->arrayAsGeneratorWithException(
                    $this->getMutateRowsResponse(1)
                )
            );
        $entries = $this->generateEntries(0, 5);
        $this->bigtableClient->mutateRows(
            Argument::that(function ($request) use ($entries) {
                return iterator_to_array($request->getEntries()) == $entries;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($this->serverStream->reveal());

        $entries = $this->generateEntries(2, 3);

        // ensure the bigtable-attempt header is sent in for the next retry.
        $this->bigtableClient->mutateRows(
            Argument::that(function ($request) use ($entries) {
                return iterator_to_array($request->getEntries()) == $entries;
            }),
            Argument::withEntry('headers', ['bigtable-attempt' => ['1']] + $this->options['headers'])
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($this->serverStream->reveal());

        $mutations = $this->generateMutations(0, 5);
        $this->table->mutateRows($mutations);
    }

    public function testMutateRowsExceptionShouldAddEntryToPendingMutations()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->getMutateRowsResponse(3, [1 => Code::ABORTED, 2 => Code::ABORTED])
                ),
                $this->arrayAsGeneratorWithException(
                    [],
                    $this->nonRetryingApiException
                )
            );
        $entries = $this->generateEntries(0, 5);
        $this->bigtableClient->mutateRows(
            Argument::that(function ($request) use ($entries) {
                return iterator_to_array($request->getEntries()) == $entries;
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );
        $entries = array_merge($this->generateEntries(1, 2), $this->generateEntries(4, 5));
        $this->bigtableClient->mutateRows(
            Argument::that(function ($request) use ($entries) {
                return iterator_to_array($request->getEntries()) == $entries;
            }),
            Argument::type('array')
        )->shouldBeCalled()
        ->willReturn(
            $this->serverStream->reveal()
        );
        try {
            $mutations = $this->generateMutations(0, 5);
            $this->table->mutateRows($mutations);
            $this->fail('Expected exception is not thrown');
        } catch (BigtableDataOperationException $ex) {
            $expectedFailedMutations = [];
            foreach ([1, 2, 4, 5] as $rowKey) {
                $expectedFailedMutations[] = [
                    'rowKey' => 'rk' . $rowKey,
                    'statusCode' => $ex->getCode(),
                    'message' => $ex->getMessage()
                ];
            }
            $this->assertEquals($expectedFailedMutations, $ex->getMetadata());
        }
    }

    public function testMutateRowsShouldNotRetryIfAnyMutationIsNotRetryable()
    {
        $this->serverStream->readAll()
            ->shouldBeCalledTimes(1)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->getMutateRowsResponse(
                        4,
                        [1 => Code::ABORTED, 2 => Code::UNAUTHENTICATED, 3 => Code::ABORTED]
                    )
                )
            );
        $entries = $this->generateEntries(0, 7);
        $this->bigtableClient->mutateRows(
            Argument::that(function ($request) use ($entries) {
                return iterator_to_array($request->getEntries()) == $entries;
            }),
            Argument::type('array')
        )->shouldBeCalledTimes(1)
        ->willReturn(
            $this->serverStream->reveal()
        );
        try {
            $mutations = $this->generateMutations(0, 7);
            $this->table->mutateRows($mutations);
            $this->fail('Expected exception is not thrown');
        } catch (BigtableDataOperationException $ex) {
            $expectedFailedMutations = [];
            $expectedFailedMutations[] = [
                'rowKey' => 'rk1',
                'statusCode' => Code::ABORTED,
                'message' => 'partial failure'
            ];
            $expectedFailedMutations[] = [
                'rowKey' => 'rk2',
                'statusCode' => Code::UNAUTHENTICATED,
                'message' => 'partial failure'
            ];
            $expectedFailedMutations[] = [
                'rowKey' => 'rk3',
                'statusCode' => Code::ABORTED,
                'message' => 'partial failure'
            ];
            foreach (range(5, 7) as $rowKey) {
                $expectedFailedMutations[] = [
                    'rowKey' => 'rk' . $rowKey,
                    'statusCode' => Code::UNAUTHENTICATED,
                    'message' => 'partial failure'
                ];
            }
            $this->assertEquals($expectedFailedMutations, $ex->getMetadata());
        }
    }

    public function testRetrySettingsObject()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('DEADLINE_EXCEEDED');

        $this->serverStream->readAll()
            ->shouldBeCalledTimes(5)
            ->willThrow(
                $this->retryingApiException
            );
        $this->bigtableClient->readRows(
            Argument::type(ReadRowsRequest::class),
            Argument::type('array')
        )->shouldBeCalledTimes(5)
        ->willReturn(
            $this->serverStream->reveal()
        );

        $retrySettings = RetrySettings::constructDefault();
        $retrySettings = $retrySettings->with(['maxRetries' => 4]);

        $iterator = $this->table->readRows([
            'retrySettings' => $retrySettings
        ]);

        $iterator->getIterator()->current();
    }

    private function generateRowsResponse($from, $to)
    {
        $rows = [];
        foreach (range($from, $to) as $rowKey) {
            $chunks = [];
            $chunks[] = (new ReadRowsResponse_CellChunk)
                ->setRowKey('rk' . $rowKey)
                ->setFamilyName((new StringValue)->setValue('cf1' . $rowKey))
                ->setQualifier((new BytesValue)->setValue('cq1' . $rowKey))
                ->setValue('value1' . $rowKey);
            $chunks[] = (new ReadRowsResponse_CellChunk)
                ->setRowKey('rk' . $rowKey)
                ->setFamilyName((new StringValue)->setValue('cf2' . $rowKey))
                ->setQualifier((new BytesValue)->setValue('cq2' . $rowKey))
                ->setValue('value2' . $rowKey)
                ->setCommitRow(true);
            $rows[] = (new ReadRowsResponse)->setChunks($chunks);
        }
        return $rows;
    }

    private function generatePartialRowResponse($rowKey)
    {
        $chunks = [];
        $chunks[] = (new ReadRowsResponse_CellChunk)
            ->setRowKey('rk' . $rowKey)
            ->setFamilyName((new StringValue)->setValue('cf1' . $rowKey))
            ->setQualifier((new BytesValue)->setValue('cq1' . $rowKey))
            ->setValue('value1' . $rowKey);
        $chunks[] = (new ReadRowsResponse_CellChunk)
            ->setRowKey('rk' . $rowKey)
            ->setFamilyName((new StringValue)->setValue('cf2' . $rowKey))
            ->setQualifier((new BytesValue)->setValue('cq2' . $rowKey))
            ->setValue('value2' . $rowKey)
            ->setCommitRow(false);
        return (new ReadRowsResponse)->setChunks($chunks);
    }

    private function generateExpectedRows($from, $to)
    {
        $rows = [];
        foreach (range($from, $to) as $rowKey) {
            $rows['rk' . $rowKey] = [
                'cf1' . $rowKey => [
                    'cq1' . $rowKey => [[
                        'value' => 'value1' . $rowKey,
                        'labels' => '',
                        'timeStamp' => 0
                    ]]
                ],
                'cf2' . $rowKey => [
                    'cq2' . $rowKey => [[
                        'value' => 'value2' . $rowKey,
                        'labels' => '',
                        'timeStamp' => 0
                    ]]
                ]
            ];
        }
        return $rows;
    }

    private function generateMutations($from, $to)
    {
        $mutations = [];
        foreach (range($from, $to) as $rowKey) {
            $mutations['rk' . $rowKey] = (new Mutations)->upsert(
                'cf1' . $rowKey,
                'cq1' . $rowKey,
                'value1' . $rowKey,
                self::TIMESTAMP
            );
        }
        return $mutations;
    }

    private function generateEntries($from, $to)
    {
        $entries = [];
        foreach ($this->generateMutations($from, $to) as $rowKey => $mutations) {
            $entries[] = (new RequestEntry)->setRowkey($rowKey)->setMutations($mutations->toProto());
        }
        return $entries;
    }

    private function getMutateRowsResponse($to, array $status = [])
    {
        $mutateRowsResponses = [];
        $range = range(0, $to);
        foreach (array_combine($range, $this->generateStatus($range, $status)) as $entryIndex => $value) {
            $mutateRowsResponses[] = (new MutateRowsResponse)
                ->setEntries([
                    (new ResponseEntry)->setStatus($value)->setIndex($entryIndex)
                ]);
        }
        return $mutateRowsResponses;
    }

    private function generateStatus(array $range, array $status)
    {
        $returnStatus = [];
        foreach ($range as $key) {
            $value = Code::OK;
            if (isset($status[$key])) {
                $value = $status[$key];
            }
            $returnStatus[$key] = (new Status)->setCode($value)->setMessage('partial failure');
        }
        return $returnStatus;
    }

    private function arrayAsGeneratorWithException(array $array, $ex = null)
    {
        foreach ($array as $item) {
            yield $item;
        }
        if ($ex !== null) {
            throw $ex;
        }
    }
}
