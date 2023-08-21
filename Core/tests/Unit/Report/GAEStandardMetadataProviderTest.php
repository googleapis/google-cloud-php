<?php
/**
 * Copyright 2018 Google LLC.
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

use Google\Cloud\Core\Report\GAEStandardMetadataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class GAEStandardMetadataProviderTest extends TestCase
{
    private $envs = [
        'GAE_SERVICE' => 'my-service',
        'GAE_VERSION' => 'my-version',
        'GOOGLE_CLOUD_PROJECT' => 'my-project',
        'HTTP_X_CLOUD_TRACE_CONTEXT' => 'my-traceId'
    ];

    /**
     * @dataProvider provideTestData
     */
    public function testGAEStandardMetadataProvider(
        $envs,
        $monitoredResource,
        $projectId,
        $serviceId,
        $versionId,
        $labels
    ) {
        $metadataProvider = new GAEStandardMetadataProvider($envs);
        $this->assertEquals($monitoredResource, $metadataProvider->monitoredResource());
        $this->assertEquals($projectId, $metadataProvider->projectId());
        $this->assertEquals($serviceId, $metadataProvider->serviceId());
        $this->assertEquals($versionId, $metadataProvider->versionId());
        $this->assertEquals($labels, $metadataProvider->labels());
    }

    public function provideTestData()
    {
        return [
            [
                [
                    'GAE_SERVICE' => 'my-service',
                    'GAE_VERSION' => 'my-version',
                    'GOOGLE_CLOUD_PROJECT' => 'my-project',
                    'HTTP_X_CLOUD_TRACE_CONTEXT' => 'my-traceId'
                ],
                [
                    'type' => 'gae_app',
                    'labels' => [
                        'project_id' => 'my-project',
                        'version_id' => 'my-version',
                        'module_id' => 'my-service'
                    ]
                ],
                'my-project',
                'my-service',
                'my-version',
                [
                    'appengine.googleapis.com/trace_id' =>
                    sprintf(
                        'projects/%s/traces/%s',
                        'my-project',
                        'my-traceId'
                    )
                ],
            ],
            [
                [
                    'GAE_SERVICE' => 'my-service',
                    'GAE_VERSION' => 'my-version',
                    'HTTP_X_CLOUD_TRACE_CONTEXT' => 'my-traceId'
                ],
                [
                    'type' => 'gae_app',
                    'labels' => [
                        'project_id' => 'unknown-projectid',
                        'version_id' => 'my-version',
                        'module_id' => 'my-service'
                    ]
                ],
                'unknown-projectid',
                'my-service',
                'my-version',
                [
                    'appengine.googleapis.com/trace_id' =>
                        'my-traceId'
                ],
            ],
            [
                [],
                [
                    'type' => 'gae_app',
                    'labels' => [
                        'project_id' => 'unknown-projectid',
                        'version_id' => 'unknown-version',
                        'module_id' => 'unknown-service'
                    ]
                ],
                'unknown-projectid',
                'unknown-service',
                'unknown-version',
                [],
            ],
        ];
    }
}
