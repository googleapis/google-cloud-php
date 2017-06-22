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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\ValueMapper;
use Prophecy\Argument;

trait ResultTestTrait
{
    public function streamingDataProvider()
    {
        foreach ($this->getStreamingDataFixture()['tests'] as $test) {
            yield [$test['chunks'], $test['result']['value']];
        }
    }

    public function streamingDataProviderFirstChunk()
    {
        foreach ($this->getStreamingDataFixture()['tests'] as $test) {
            yield [$test['chunks'], $test['result']['value']];
            break;
        }
    }

    private function getResultClass(
        $chunks = null,
        $context = 'r',
        $mapper = null,
        $call = null
    ) {
        $operation = $this->prophesize(Operation::class);
        $session = $this->prophesize(Session::class)->reveal();
        $transaction = $this->prophesize(Transaction::class);
        $snapshot = $this->prophesize(Snapshot::class);

        if (!$mapper) {
            $mapper = $this->prophesize(ValueMapper::class);
            $mapper->decodeValues(
                Argument::any(),
                Argument::any(),
                Argument::any()
            )->will(function ($args) {
                return $args[1];
            });
            $mapper = $mapper->reveal();
        }

        if (!$call) {
            $call = function () use ($chunks) {
                return $this->resultGenerator($chunks);
            };
        }

        if ($context === 'r') {
            $operation->createSnapshot(
                $session,
                Argument::type('array')
            )->willReturn($snapshot->reveal());
        } else {
            $operation->createTransaction(
                $session,
                Argument::type('array')
            )->willReturn($transaction->reveal());
        }

        return new Result(
            $operation->reveal(),
            $session,
            $call,
            $context,
            $mapper
        );
    }

    private function resultGenerator($chunks)
    {
        foreach ($chunks as $chunk) {
            yield json_decode($chunk, true);
        }
    }

    private function getStreamingDataFixture()
    {
        return json_decode(
            file_get_contents(__DIR__ .'/../fixtures/spanner/streaming-read-acceptance-test.json'),
            true
        );
    }
}
