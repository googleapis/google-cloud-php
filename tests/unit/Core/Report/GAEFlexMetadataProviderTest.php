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
    use EnvTestTrait;
    
    private $envs = ['GAE_SERVICE', 'GAE_VERSION', 'GCLOUD_PROJECT'];
    
    public function setup()
    {
        $this->preserveEnvs($this->envs);
    }

    public function tearDown()
    {
        $this->restoreEnvs($this->envs);
    }
    
    public function testWithEnvs()
    {
        $this->setEnv('GAE_SERVICE', 'my-service');
        $this->setEnv('GAE_VERSION', 'my-version');
        $this->setenv('GCLOUD_PROJECT', 'my-project');
        $metadataProvider = new GAEFlexMetadataProvider();
        $this->assertEquals(
            [
                'type' => 'gae_app',
                'labels' => [
                    'project_id' => 'my-project',
                    'version_id' => 'my-version',
                    'module_id' => 'my-service'
                ]
            ],
            $metadataProvider->getMonitoredResource()
        );
        $this->assertEquals('my-project', $metadataProvider->getProjectId());
        $this->assertEquals('my-service', $metadataProvider->getService());
        $this->assertEquals('my-version', $metadataProvider->getVersion());
    }

    public function testWithOutEnvs()
    {
        $this->setEnv('GAE_SERVICE', false);
        $this->setEnv('GAE_VERSION', false);
        $this->setenv('GCLOUD_PROJECT', false);
        $metadataProvider = new GAEFlexMetadataProvider();
        $this->assertEquals(
            [
                'type' => 'gae_app',
                'labels' => [
                    'project_id' => 'unknown-projectid',
                    'version_id' => 'unknown-version',
                    'module_id' => 'unknown-service'
                ]
            ],
            $metadataProvider->getMonitoredResource()
        );
        $this->assertEquals(
            'unknown-projectid',
            $metadataProvider->getProjectId()
        );
        $this->assertEquals('unknown-service', $metadataProvider->getService());
        $this->assertEquals('unknown-version', $metadataProvider->getVersion());
    }
}
