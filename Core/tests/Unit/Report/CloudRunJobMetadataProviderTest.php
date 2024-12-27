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
use Google\Cloud\Core\Report\CloudRunJobMetadataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class CloudRunJobMetadataProviderTest extends TestCase
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

        $provider = new CloudRunJobMetadataProvider([
            'CLOUD_RUN_JOB' => 'my-job',
            'CLOUD_RUN_EXECUTION' => 'my-execution',
            'CLOUD_RUN_TASK_INDEX' => '1',
            'CLOUD_RUN_TASK_ATTEMPT' => '3',
            'HTTP_X_CLOUD_TRACE_CONTEXT' => 'my-traceId',
        ], new Metadata($reader));
        $this->assertEquals('my-job', $provider->serviceId());
        $this->assertEquals('my-execution', $provider->versionId());
        $this->assertEquals(
            [
                'type' => 'cloud_run_job',
                'labels' => [
                    'job_name' => 'my-job',
                    'location' => 'my-region',
                    'project_id' => 'my-project',
                ],
            ],
            $provider->monitoredResource()
        );
        $this->assertEquals(
            [
                'instanceId' => 'my-instance-id',
                'run.googleapis.com/execution_name' => 'my-execution',
                'run.googleapis.com/task_attempt' => '3',
                'run.googleapis.com/task_index' => '1',
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

        $provider = new CloudRunJobMetadataProvider([], new Metadata($reader));
        $this->assertEquals('unknown-job', $provider->serviceId());
        $this->assertEquals('', $provider->versionId());
        $this->assertEquals(
            [
                'type' => 'cloud_run_job',
                'labels' => [
                    'job_name' => 'unknown-job',
                    'location' => '',
                    'project_id' => '',
                ],
            ],
            $provider->monitoredResource()
        );
        $this->assertEquals([], $provider->labels());
    }
}
