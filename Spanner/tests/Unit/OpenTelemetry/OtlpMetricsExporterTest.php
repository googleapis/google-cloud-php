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

namespace Google\Cloud\Spanner\Tests\Unit\OpenTelemetry;

use Google\Cloud\Spanner\OpenTelemetry\OtlpMetricsExporter;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScope;
use OpenTelemetry\SDK\Metrics\Data\Metric as OTelMetric;
use OpenTelemetry\SDK\Metrics\Data\NumberDataPoint;
use OpenTelemetry\SDK\Metrics\Data\Sum;
use OpenTelemetry\SDK\Metrics\Data\Temporality;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Metrics\PushMetricExporterInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;

/**
 * @group spanner
 */
class OtlpMetricsExporterTest extends TestCase
{
    use ProphecyTrait;

    public function testExport()
    {
        $mockCredentials = $this->prophesize(\Google\ApiCore\CredentialsWrapper::class);
        $mockOtlpExporter = $this->prophesize(PushMetricExporterInterface::class);
        $exporter = new OtlpMetricsExporter(
            $mockCredentials->reveal(),
            100,
            [],
            $mockOtlpExporter->reveal()
        );

        $scope = new InstrumentationScope('google-cloud-spanner', '1.0.0', null, Attributes::create([]));
        $resource = ResourceInfo::create(Attributes::create([
            'gcp.resource_type' => 'spanner_instance_client',
            'client_hash' => '000212'
        ]));

        $attributes = Attributes::create([
            'method' => 'ExecuteSql',
            'status' => 'OK',
            'instance_id' => 'my-instance',
            'database' => 'my-db'
        ]);

        $point = new NumberDataPoint(
            1,
            $attributes,
            1711368000000000000,
            1711368060000000000
        );

        $sum = new Sum([$point], Temporality::CUMULATIVE, true);
        $metric = new OTelMetric(
            $scope,
            $resource,
            'spanner.googleapis.com/internal/client/attempt_count',
            '1',
            'desc',
            $sum
        );

        $mockOtlpExporter->export(Argument::type('iterable'))->shouldBeCalled()->willReturn(true);

        $this->assertTrue($exporter->export([$metric]));
    }

    public function testExportCustomTimeout()
    {
        $mockCredentials = $this->prophesize(\Google\ApiCore\CredentialsWrapper::class);
        $mockOtlpExporter = $this->prophesize(PushMetricExporterInterface::class);
        $timeout = 500;
        $exporter = new OtlpMetricsExporter($mockCredentials->reveal(), $timeout, [], $mockOtlpExporter->reveal());

        $scope = new InstrumentationScope('google-cloud-spanner', '1.0.0', null, Attributes::create([]));
        $resource = ResourceInfo::create(Attributes::create([]));

        $attributes = Attributes::create([]);
        $point = new NumberDataPoint(1, $attributes, 1711368000000000000, 1711368060000000000);
        $sum = new Sum([$point], Temporality::CUMULATIVE, true);
        $metric = new OTelMetric(
            $scope,
            $resource,
            'spanner.googleapis.com/internal/client/attempt_count',
            '1',
            'desc',
            $sum
        );

        $mockOtlpExporter->export(Argument::any())->shouldBeCalled()->willReturn(true);

        $this->assertTrue($exporter->export([$metric]));
    }

    public function testConstructWithCredentialsWrapper()
    {
        $mockCredentials = $this->prophesize(\Google\ApiCore\CredentialsWrapper::class);
        $exporter = new OtlpMetricsExporter($mockCredentials->reveal(), 100, []);

        $this->assertInstanceOf(OtlpMetricsExporter::class, $exporter);
    }

    public function testGuzzleMiddlewareAttachesAuthorizationAndQuotaProjectHeaders()
    {
        $mockCredentials = $this->prophesize(\Google\ApiCore\CredentialsWrapper::class);
        $mockCredentials->getAuthorizationHeaderCallback()->willReturn(function () {
            return ['authorization' => ['Bearer test-metric-token']];
        });
        $mockCredentials->getQuotaProject()->willReturn('test-quota-project-id');

        $mockHandler = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], '')
        ]);
        $handlerStack = \GuzzleHttp\HandlerStack::create($mockHandler);

        $exporter = new OtlpMetricsExporter(
            $mockCredentials->reveal(),
            100,
            ['handlerStack' => $handlerStack]
        );

        $scope = new InstrumentationScope('google-cloud-spanner', '1.0.0', null, Attributes::create([]));
        $resource = ResourceInfo::create(Attributes::create([]));
        $point = new NumberDataPoint(1, Attributes::create([]), 1711368000000000000, 1711368060000000000);
        $sum = new Sum([$point], Temporality::CUMULATIVE, true);
        $metric = new OTelMetric(
            $scope,
            $resource,
            'spanner.googleapis.com/internal/client/attempt_count',
            '1',
            'desc',
            $sum
        );

        // Access the internal otlpExporter via reflection to trigger HTTP call through transport
        $reflection = new ReflectionClass(OtlpMetricsExporter::class);
        $property = $reflection->getProperty('otlpExporter');
        $property->setAccessible(true);
        $otlpExporter = $property->getValue($exporter);

        $otlpExporter->export([$metric]);

        $lastRequest = $mockHandler->getLastRequest();
        $this->assertNotNull($lastRequest);
        $this->assertEquals(['Bearer test-metric-token'], $lastRequest->getHeader('authorization'));
        $this->assertEquals(['test-quota-project-id'], $lastRequest->getHeader('x-goog-user-project'));
    }

    public function testExportFailureReturnsFalse()
    {
        $mockCredentials = $this->prophesize(\Google\ApiCore\CredentialsWrapper::class);
        $mockOtlpExporter = $this->prophesize(PushMetricExporterInterface::class);

        $mockOtlpExporter->export(Argument::any())->willThrow(new \Exception('Connection failed'));

        $exporter = new OtlpMetricsExporter(
            $mockCredentials->reveal(),
            100,
            [],
            $mockOtlpExporter->reveal()
        );

        $scope = new InstrumentationScope('google-cloud-spanner', '1.0.0', null, Attributes::create([]));
        $resource = ResourceInfo::create(Attributes::create([]));
        $point = new NumberDataPoint(1, Attributes::create([]), 1000, 2000);
        $sum = new Sum([$point], Temporality::CUMULATIVE, true);
        $metric = new OTelMetric($scope, $resource, 'attempt_count', '1', 'desc', $sum);

        $result = $exporter->export([$metric]);
        $this->assertFalse($result);
    }
}
