<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Batch;

use Google\Cloud\Core\Batch\BatchJob;
use Google\Cloud\Core\Batch\BatchRunner;
use Google\Cloud\Core\Batch\BatchTrait;
use Google\Cloud\Core\Batch\ProcessItemInterface;
use Google\Cloud\Core\Tests\Unit\Batch\Fixtures\BatchClass;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group core
 * @group batch
 */
class BatchTraitTest extends TestCase
{
    use AssertStringContains;
    use ExpectException;

    const ID = 'some-id';
    const BATCH_METHOD = 'doBatch';

    public function testFlush()
    {
        $idNum = 5;
        $returnVal = true;
        $job = $this->prophesize(BatchJob::class);
        $job->id()
            ->willReturn($idNum)
            ->shouldBeCalledTimes(1);
        $processor = $this->prophesize(ProcessItemInterface::class);
        $processor->flush($idNum)
            ->willReturn($returnVal);
        $runner = $this->prophesize(BatchRunner::class);
        $runner->getJobFromId(Argument::any())
            ->willReturn($job->reveal())
            ->shouldBeCalledTimes(1);
        $runner->getProcessor()
            ->willReturn($processor->reveal())
            ->shouldBeCalledTimes(1);
        $impl = new BatchClass(['batchRunner' => $runner->reveal()]);

        $this->assertEquals($returnVal, $impl->flush());
    }

    public function testSend()
    {
        $items = ['a', 'b', 'c'];
        $temp = fopen('php://temp', 'rw');
        $hasExecuted = false;
        $count = 0;
        $impl = new BatchClass([
            'debugOutput' => true,
            'debugOutputResource' => $temp,
            'cb' => function (array $items) use (&$count, &$hasExecuted) {
                $hasExecuted = true;
                $count = count($items);
            }
        ]);

        $impl->send($items);

        rewind($temp);
        $contents = stream_get_contents($temp);

        $this->assertTrue($hasExecuted);
        $this->assertEquals(count($items), $count);
        $this->assertStringContainsString('seconds for ' . self::BATCH_METHOD, $contents);
    }

    public function testSetCommonBatchPropertiesThrowsExceptionWithoutIdentifier()
    {
        $this->expectException('\InvalidArgumentException');

        $impl = new BatchClass();
        $impl->setCommonBatchProperties(['batchMethod' => self::BATCH_METHOD]);
    }

    public function testSetCommonBatchPropertiesThrowsExceptionWithoutBatchMethod()
    {
        $this->expectException('\InvalidArgumentException');

        $impl = new BatchClass();
        $impl->setCommonBatchProperties(['identifier' => self::ID]);
    }
}
