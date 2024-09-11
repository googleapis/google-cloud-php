<?php
/**
 * Copyright 2024, Google LLC All rights reserved.
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

use Google\Cloud\Bigtable\ResumableStream;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Argument;
use Google\ApiCore\ServerStream;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ResumableStreamTest extends TestCase
{
    use ProphecyTrait;

    const RETRYABLE_CODE = 1234;

    public function testRetryDelayIsResetWhenRowReceived()
    {
        $stream = $this->prophesize(ServerStream::class);
        $generator1 = function () {
            yield new ReadRowsResponse();
            throw new \Exception('This too is retryable!', self::RETRYABLE_CODE);
        };
        $generator2 = fn () => yield new ReadRowsResponse();
        $count = 0;
        $stream->readAll()
            ->will(function () use (&$count, $generator1, $generator2) {
                // Simlate a call to readRows where the server throws 2 exceptions, reads a row
                // successfuly, throws another exception, and reads one more row successfully.
                return match ($count++) {
                    0 => throw new \Exception('This is retryable!', self::RETRYABLE_CODE),
                    1 => throw new \Exception('This is also retryable!', self::RETRYABLE_CODE),
                    2 => $generator1(),
                    3 => $generator2(),
                };
            });
        $bigtable = $this->prophesize(BigtableClient::class);
        $bigtable->readRows(Argument::type(ReadRowsRequest::class), Argument::type('array'))
            ->shouldBeCalledTimes(4)
            ->willReturn($stream->reveal());
        $resumableStream = new ResumableStream(
            $bigtable->reveal(),
            'readRows',
            $this->prophesize(ReadRowsRequest::class)->reveal(),
            fn ($request, $callOptions) => [$request, $callOptions],
            fn ($exception) => $exception && $exception->getCode() === self::RETRYABLE_CODE
        );

        $retries = 0;
        $delayFunction = function ($delayFactor) use (&$retries) {
            $this->assertEquals(match (++$retries) {
                1 => 1, // initial delay
                2 => 2, // increment by 1
                3 => 1, // the delay is reset by the successful call
            }, $delayFactor);
        };
        $prop = (new \ReflectionObject($resumableStream))->getProperty('delayFunction');
        $prop->setAccessible(true);
        $prop->setValue($resumableStream, $delayFunction);

        $rows = iterator_to_array($resumableStream->readAll());
        $this->assertEquals(2, count($rows));
        $this->assertEquals(3, $retries);
    }
}
