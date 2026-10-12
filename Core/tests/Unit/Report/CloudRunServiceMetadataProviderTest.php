<?php
/**
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Tests\Unit\Report;

use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Compute\Metadata\Readers\ReaderInterface;
use Google\Cloud\Core\Report\CloudRunServiceMetadataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class CloudRunServiceMetadataProviderTest extends TestCase
{
    public function testMetadataProvider()
    {
        $reader = self::createStub(ReaderInterface::class);
        $reader->method('read')
            ->willReturnMap([
                ['instance/region', 'projects/my-project/regions/my-region'],
                ['instance/id', 'my-instance-id'],
                ['project/project-id', 'my-project'],
            ]);

        $provider = new CloudRunServiceMetadataProvider([
            'K_CONFIGURATION' => 'my-configuration',
            'K_SERVICE' => 'my-service',
            'K_REVISION' => 'my-revision',
            'HTTP_X_CLOUD_TRACE_CONTEXT' => 'my-traceId',
        ], new Metadata($reader));
        $this->assertEquals('my-service', $provider->serviceId());
        $this->assertEquals('my-revision', $provider->versionId());
        $this->assertEquals(
            [
                'type' => 'cloud_run_revision',
                'labels' => [
                    'configuration_name' => 'my-configuration',
                    'location' => 'my-region',
                    'project_id' => 'my-project',
                    'revision_name' => 'my-revision',
                    'service_name' => 'my-service',
                ],
            ],
            $provider->monitoredResource()
        );
        $this->assertEquals(
            [
                'instanceId' => 'my-instance-id',
                'run.googleapis.com/trace_id' => 'my-traceId',
            ],
            $provider->labels()
        );
    }

    public function testDefaults()
    {
        $reader = self::createStub(ReaderInterface::class);
        $reader->method('read')
            ->willReturn('');

        $provider = new CloudRunServiceMetadataProvider([], new Metadata($reader));
        $this->assertEquals('unknown-service', $provider->serviceId());
        $this->assertEquals('unknown-revision', $provider->versionId());
        $this->assertEquals(
            [
                'type' => 'cloud_run_revision',
                'labels' => [
                    'configuration_name' => 'unknown-configuration',
                    'location' => '',
                    'project_id' => '',
                    'revision_name' => 'unknown-revision',
                    'service_name' => 'unknown-service',
                ],
            ],
            $provider->monitoredResource()
        );
        $this->assertEquals([], $provider->labels());
    }
}
