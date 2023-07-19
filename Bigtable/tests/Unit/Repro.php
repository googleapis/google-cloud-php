<?php

use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Bigtable\V2\BigtableClient as BigtableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry as RequestEntry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry as ResponseEntry;
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
 * AUTHOR: @yash30201
 *
 * This file intends to create the reproduction of the issue
 * mentioned in b/268093461 tracking bug in the Bigtable's php
 * client library by mocking the grpc response(ServerStream)
 * which we get from the readRows() grpc API of Bigtable.
 *
 * Reference for code taken from:
 * https://github.com/googleapis/google-cloud-php/blob/main/Bigtable/tests/Unit/SmartRetriesTest.php
 */

class Repro extends TestCase
{
    use ProphecyTrait;

    public const HEADER = 'my-header';
    public const HEADER_VALUE = 'my-header-value';
    public const APP_PROFILE = 'my-app-profile';
    public const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';

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
        $this->bigtableClient = $this->prophesize(BigtableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);
        $this->options = [
            'appProfileId' => self::APP_PROFILE,
            'headers' => [self::HEADER => self::HEADER_VALUE]
        ];
        $this->table = new Table(
            $this->bigtableClient->reveal(),
            self::TABLE_NAME,
            $this->options
        );
    }

    public function testFullTableScanBug()
    {
        // Mock readAll() generator method for ServerStream so that
        // it retries after sending all chunks for query with a
        // deadline exceed error as stated in the repro case in the
        // issue, thus the library would re-attempt with UPDATED
        // ARGS as a part of smart retries.
        $this->serverStream->readAll()
            ->shouldBeCalled(2)
            ->willReturn(
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(1, 3),
                    $this->retryingApiException
                ),
                $this->arrayAsGeneratorWithException(
                    $this->generateRowsResponse(4, 4, "Full table scan attempted")
                )
            );


        // Mock readRows() method for Bigtable V2 gapic client for FIRST CALL
        // Check if the request has complete row range
        $this->bigtableClient->readRows(
            self::TABLE_NAME,
            Argument::that(function ($argument) {
                $rowRanges = $argument['rows']->getRowRanges();
                if (count($rowRanges) === 0) {
                    return false;
                }
                $rowRange = $rowRanges[0];
                return $rowRange->getStartKeyClosed() === 'rk1' &&
                    $rowRange->getEndKeyClosed() === 'rk3';
            })
        )->shouldBeCalledOnce()->willReturn(
            $this->serverStream->reveal()
        );

        // Mock readRows() method for Bigtable V2 gapic client for SECOND CALL
        // Check if the request has empty row range resulting in full table scan.
        $this->bigtableClient->readRows(
            self::TABLE_NAME,
            Argument::that(function ($argument) {
                $rowRanges = $argument['rows']->getRowRanges();
                if (count($rowRanges)) {
                    return false;
                }
                return true;
            })
        )->shouldBeCalledOnce()->willReturn(
            $this->serverStream->reveal()
        );

        $args = [
            'rowRanges' => [[
                'startKeyClosed' => 'rk1',
                'endKeyClosed' => 'rk3'
            ]]
        ];
        $iterator = $this->table->readRows($args);
        $rows = iterator_to_array($iterator);

        $this->assertEquals("Full table scan attempted", $rows['rk4']['cf1']['cq1'][0]['value']);

        // Print result with colors and backgound highlights
        printf(
            PHP_EOL .
            PHP_EOL .
            "\e[0;30;41m\n\n[\e[1mFull table scan attempted and hence BUG EXISTS]\n\e[0m" .
            PHP_EOL
        );
    }

    private function generateRowsResponse($from, $to, $value = null)
    {
        $rows = [];
        foreach (range($from, $to) as $rowKey) {
            $chunks = [];
            $chunks[] = (new ReadRowsResponse_CellChunk())
                ->setRowKey('rk' . $rowKey)
                ->setFamilyName((new StringValue())->setValue('cf1'))
                ->setQualifier((new BytesValue())->setValue('cq1'))
                ->setValue($value ?? 'value1' . $rowKey)
                ->setCommitRow(true);
            $rows[] = (new ReadRowsResponse())->setChunks($chunks);
        }
        return $rows;
    }


    private function generateExpectedRows($from, $to, $value = null)
    {
        $rows = [];
        foreach (range($from, $to) as $rowKey) {
            $rows['rk' . $rowKey] = [
                'cf1' => [
                    'cq1' => [[
                        'value' => $value ?? 'value1' . $rowKey,
                        'labels' => '',
                        'timeStamp' => 0
                    ]]
                ],
            ];
        }
        return $rows;
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
