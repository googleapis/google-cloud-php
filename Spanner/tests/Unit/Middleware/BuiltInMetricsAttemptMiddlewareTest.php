<?php
/**
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\Spanner\Tests\Unit\Middleware;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\ServerStream;
use Google\ApiCore\ServerStreamingCallInterface;
use Google\Cloud\Spanner\Middleware\MetricsAttemptMiddleware;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\RejectedPromise;
use OpenTelemetry\API\Metrics\CounterInterface;
use OpenTelemetry\API\Metrics\HistogramInterface;
use OpenTelemetry\API\Metrics\MeterInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class BuiltInMetricsAttemptMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    private $meter;
    private $attemptHistogram;
    private $attemptCounter;
    private $gfeHistogram;
    private $gfeErrorCounter;
    private $afeHistogram;
    private $afeErrorCounter;
    private $nextHandler;

    public function setUp(): void
    {
        $this->attemptHistogram = $this->prophesize(HistogramInterface::class);
        $this->attemptCounter = $this->prophesize(CounterInterface::class);
        $this->gfeHistogram = $this->prophesize(HistogramInterface::class);
        $this->gfeErrorCounter = $this->prophesize(CounterInterface::class);
        $this->afeHistogram = $this->prophesize(HistogramInterface::class);
        $this->afeErrorCounter = $this->prophesize(CounterInterface::class);
        $this->meter = $this->prophesize(MeterInterface::class);

        $this->meter->createHistogram(
            'attempt_latencies',
            'ms',
            Argument::any()
        )->willReturn($this->attemptHistogram->reveal());

        $this->meter->createCounter(
            'attempt_count',
            '1',
            Argument::any()
        )->willReturn($this->attemptCounter->reveal());

        $this->meter->createHistogram(
            'gfe_latencies',
            'ms',
            Argument::any()
        )->willReturn($this->gfeHistogram->reveal());

        $this->meter->createCounter(
            'gfe_connectivity_error_count',
            '1',
            Argument::any()
        )->willReturn($this->gfeErrorCounter->reveal());

        $this->meter->createHistogram(
            'afe_latencies',
            'ms',
            Argument::any()
        )->willReturn($this->afeHistogram->reveal());

        $this->meter->createCounter(
            'afe_connectivity_error_count',
            '1',
            Argument::any()
        )->willReturn($this->afeErrorCounter->reveal());

        $this->nextHandler = function ($call, $options) {
            if (isset($options['metadataCallback'])) {
                $options['metadataCallback']([
                    'server-timing' => ['gfet4t7; dur=12.5, afe; dur=8.2']
                ]);
            }
            return new FulfilledPromise('ok');
        };
    }

    public function testRecordsAttemptMetrics()
    {
        $projectId = 'test-project';
        $clientId = 'test-client-id';
        $version = '2.5.1';
        $expectedClientName = 'spanner-php/2.5.1';
        $location = 'us-central1';

        $middleware = new MetricsAttemptMiddleware(
            $this->nextHandler,
            $this->meter->reveal(),
            $clientId,
            $projectId,
            $version,
            $location
        );

        $call = $this->prophesize(Call::class);
        $call->getMethod()->willReturn('Commit');

        // GAX formats this as a URL-encoded string in a header
        $options = [
            'headers' => [
                'x-goog-request-params' => ['database=projects%2Fp%2Finstances%2Fi%2Fdatabases%2Fd']
            ]
        ];

        // Verify Labels
        $expectedLabels = [
            'method' => 'Commit',
            'status' => 'OK',
            'instance_id' => 'i',
            'database' => 'd',
            'project_id' => $projectId,
            'client_uid' => $clientId,
            'client_name' => $expectedClientName,
            'instance_config' => 'unknown',
            'location' => $location
        ];

        $this->attemptCounter->add(1, $expectedLabels)->shouldBeCalled();
        $this->attemptHistogram->record(Argument::type('float'), $expectedLabels)->shouldBeCalled();

        // GFE and AFE metrics
        $this->gfeHistogram->record(12.5, $expectedLabels)->shouldBeCalled();
        $this->afeHistogram->record(8.2, $expectedLabels)->shouldBeCalled();

        $promise = $middleware($call->reveal(), $options);
        $promise->wait();
    }

    public function testRecordsGfeMetricsOnStreamingResponse()
    {
        $callWrapper = $this->prophesize(ServerStreamingCallInterface::class);
        $callWrapper->getMetadata()->willReturn(['server-timing' => ['gfet4t7; dur=45.0']]);

        $serverStream = new ServerStream($callWrapper->reveal());

        $this->nextHandler = function ($call, $options) use ($serverStream) {
            return $serverStream;
        };

        $middleware = new MetricsAttemptMiddleware(
            $this->nextHandler,
            $this->meter->reveal(),
            'client',
            'project',
            'name',
            'global'
        );

        $call = $this->prophesize(Call::class);
        $call->getMethod()->willReturn('ExecuteStreamingSql');

        $options = [
            'headers' => [
                'x-goog-request-params' => ['database=projects%2Fp%2Finstances%2Fi%2Fdatabases%2Fd']
            ]
        ];

        // Expect GFE latency recording from the stream metadata
        $this->gfeHistogram->record(45.0, Argument::any())->shouldBeCalled();
        $this->attemptCounter->add(1, Argument::any())->shouldBeCalled();

        $middleware($call->reveal(), $options);
    }

    public function testRecordsGfeErrorOnMissingHeader()
    {
        $this->nextHandler = function ($call, $options) {
            if (isset($options['metadataCallback'])) {
                $options['metadataCallback']([]); // Missing header
            }
            return new FulfilledPromise('ok');
        };

        $middleware = new MetricsAttemptMiddleware(
            $this->nextHandler,
            $this->meter->reveal(),
            'client',
            'project',
            'name',
            'global'
        );

        $call = $this->prophesize(Call::class);
        $call->getMethod()->willReturn('Commit');

        $options = [
            'headers' => [
                'x-goog-request-params' => ['database=projects%2Fp%2Finstances%2Fi%2Fdatabases%2Fd']
            ]
        ];

        $this->gfeErrorCounter->add(1, Argument::any())->shouldBeCalled();

        $promise = $middleware($call->reveal(), $options);
        $promise->wait();
    }

    public function testRecordsMetricsOnError()
    {
        $this->nextHandler = function ($call, $options) {
            return new RejectedPromise(new \Exception('fail', 7));
        };

        $middleware = new MetricsAttemptMiddleware(
            $this->nextHandler,
            $this->meter->reveal(),
            'client',
            'project',
            'name',
            'global'
        );

        $call = $this->prophesize(Call::class);
        $call->getMethod()->willReturn('Commit');

        $options = [
            'headers' => [
                'x-goog-request-params' => ['database=projects%2Fp%2Finstances%2Fi%2Fdatabases%2Fd']
            ]
        ];

        // On error, we expect attempt count/latency AND GFE error count (since headers were missing)
        $this->attemptCounter->add(1, Argument::any())->shouldBeCalled();
        $this->attemptHistogram->record(Argument::any(), Argument::any())->shouldBeCalled();
        $this->gfeErrorCounter->add(1, Argument::any())->shouldBeCalled();

        $promise = $middleware($call->reveal(), $options);

        try {
            $promise->wait();
        } catch (\Exception $e) {
            $this->assertEquals(7, $e->getCode());
        }
    }
}
