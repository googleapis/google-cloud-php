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

use Google\Cloud\Monitoring\V3\Client\MetricServiceClient;
use Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest;
use Google\Cloud\Spanner\OpenTelemetry\BuiltInMetricsExporter;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScope;
use OpenTelemetry\SDK\Metrics\Data\Metric as OTelMetric;
use OpenTelemetry\SDK\Metrics\Data\NumberDataPoint;
use OpenTelemetry\SDK\Metrics\Data\Sum;
use OpenTelemetry\SDK\Metrics\Data\Temporality;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;

/**
 * @group spanner
 */
class BuiltInMetricsExporterTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT_ID = 'test-project';
    const CLIENT_ID = 'test-client-id';

    /**
     * @dataProvider hashDataProvider
     */
    public function testGenerateClientHash($clientUid, $expected)
    {
        $client = $this->prophesize(MetricServiceClient::class);
        $exporter = new BuiltInMetricsExporter($client->reveal(), self::PROJECT_ID, self::CLIENT_ID);

        $reflection = new ReflectionClass(BuiltInMetricsExporter::class);
        $method = $reflection->getMethod('generateClientHash');
        $method->setAccessible(true);

        $result = $method->invoke($exporter, $clientUid);
        $this->assertEquals($expected, $result);
    }

    public function hashDataProvider()
    {
        return [
            ['exampleUID', '00006b'],
            ['', '000000'],
            ['!@#$%^&*()', '000389'],
            ['aVeryLongUniqueIdentifierThatExceedsNormalLength', '000125'],
            ['1234567890', '00003e'],
        ];
    }

    public function testExport()
    {
        $client = $this->prophesize(MetricServiceClient::class);
        $exporter = new BuiltInMetricsExporter($client->reveal(), self::PROJECT_ID, self::CLIENT_ID);

        $scope = new InstrumentationScope('google-cloud-spanner', '1.0.0', null, Attributes::create([]));
        $resource = ResourceInfo::create(Attributes::create(['service.name' => 'spanner']));

        $attributes = Attributes::create([
            'method' => 'ExecuteSql',
            'status' => 'OK',
            'instance_id' => 'my-instance',
            'database' => 'my-db'
        ]);

        $point = new NumberDataPoint(
            1,
            $attributes,
            1711368000000000000, // nanoseconds
            1711368060000000000
        );

        $sum = new Sum([$point], Temporality::CUMULATIVE, true);
        $metric = new OTelMetric($scope, $resource, 'attempt_count', '1', 'desc', $sum);

        $client->createServiceTimeSeries(Argument::that(function ($request) {
            if (!$request instanceof CreateTimeSeriesRequest) {
                return false;
            }

            $projectName = MetricServiceClient::projectName(self::PROJECT_ID);
            if ($request->getName() !== $projectName) {
                return false;
            }

            $timeSeries = $request->getTimeSeries()[0];

            // Verify Metric Type
            $expectedMetric = 'spanner.googleapis.com/internal/client/attempt_count';
            if ($timeSeries->getMetric()->getType() !== $expectedMetric) {
                return false;
            }

            // Verify Labels
            $labels = $timeSeries->getMetric()->getLabels();
            if ($labels['method'] !== 'ExecuteSql' ||
                $labels['status'] !== 'OK' ||
                $labels['database'] !== 'my-db') {
                return false;
            }

            // Verify Resource
            $resLabels = $timeSeries->getResource()->getLabels();
            if ($resLabels['instance_id'] !== 'my-instance') {
                return false;
            }

            // Verify Client Hash
            if ($resLabels['client_hash'] !== '000369') {
                return false;
            }

            return true;
        }), Argument::any())->shouldBeCalled();

        $this->assertTrue($exporter->export([$metric]));
    }
}
