<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\Unit\Core\Report;

use Google\Cloud\Core\Report\GAEFlexMetadataProvider;

/**
 * @group core
 */
class GAEFlexMetadataProviderTest extends \PHPUnit_Framework_TestCase
{
    private $envs = [
        'GAE_SERVICE' => 'my-service',
        'GAE_VERSION' => 'my-version',
        'GCLOUD_PROJECT' => 'my-project',
        'HTTP_X_CLOUD_TRACE_CONTEXT' => 'my-traceId'
    ];

    public function testWithEnvs()
    {
        $metadataProvider = new GAEFlexMetadataProvider($this->envs);
        $this->assertEquals(
            [
                'type' => 'gae_app',
                'labels' => [
                    'project_id' => 'my-project',
                    'version_id' => 'my-version',
                    'module_id' => 'my-service'
                ]
            ],
            $metadataProvider->monitoredResource()
        );
        $this->assertEquals('my-project', $metadataProvider->projectId());
        $this->assertEquals('my-service', $metadataProvider->serviceId());
        $this->assertEquals('my-version', $metadataProvider->versionId());
        $this->assertEquals(
            [
                'appengine.googleapis.com/trace_id' => 'my-traceId'
            ],
            $metadataProvider->labels()
        );
    }

    public function testWithOutEnvs()
    {
        $metadataProvider = new GAEFlexMetadataProvider([]);
        $this->assertEquals(
            [
                'type' => 'gae_app',
                'labels' => [
                    'project_id' => 'unknown-projectid',
                    'version_id' => 'unknown-version',
                    'module_id' => 'unknown-service'
                ]
            ],
            $metadataProvider->monitoredResource()
        );
        $this->assertEquals(
            'unknown-projectid',
            $metadataProvider->projectId()
        );
        $this->assertEquals('unknown-service', $metadataProvider->serviceId());
        $this->assertEquals('unknown-version', $metadataProvider->versionId());
        $this->assertEquals([], $metadataProvider->labels());
    }
}
