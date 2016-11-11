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

namespace Google\Cloud\Tests;

use Google\Cloud\AppEngine\AppIdentity;
use Google\Cloud\Compute\Metadata;
use Google\Cloud\DetectProjectTrait;

/**
 * @group root
 */
class DetectProjectTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testPathToGcloudConfig()
    {
        $configPath = getenv('HOME') . '/.config/gcloud/configurations/config_default';

        $trait = new DetectProjectTraitStub();

        $res = $trait->runPathToGcloudConfig();

        $this->assertEquals($res, $configPath);
    }

    public function testPathToGcloudConfigOnWindows()
    {
        $configPath = 'test/gcloud/configurations/config_default';

        $trait = new DetectProjectTraitStubOnWindows();

        putenv('APPDATA=' . 'test');

        $res = $trait->runPathToGcloudConfig();

        putenv('APPDATA');

        $this->assertEquals($res, $configPath);
    }


    public function testDetectProjectIdOnGce()
    {
        $projectId = 'gce-project-rawks';

        $m = $this->prophesize(Metadata::class);
        $m->getProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = new DetectProjectTraitStubOnGce($m);

        $res = $trait->runProjectFromGce([]);

        $this->assertEquals($res, $projectId);
    }

    public function testDetectProjectIdOnAppEngine()
    {
        $projectId = 'appengine-project-rawks';

        $m = $this->prophesize(AppIdentity::class);
        $m->getApplicationId()->willReturn($projectId)->shouldBeCalled();

        $trait = new DetectProjectTraitStubOnAppEngine($m);

        $res = $trait->runProjectFromAppEngine();

        $this->assertEquals($res, $projectId);
    }

    public function testDetectProjectIdWithEnvVar()
    {
        $projectId = 'appengineflex-project-rawks';

        // set a test environment variable
        putenv('GOOGLE_DETECT_PROJECT_TEST_PROJECT_ID=' . $projectId);

        $trait = new DetectProjectTraitStubWithEnvVar();

        $res = $trait->runProjectFromEnvVar();

        // remove the environment variable
        putenv('GOOGLE_DETECT_PROJECT_TEST_PROJECT_ID');

        $this->assertEquals($res, $projectId);
    }

    public function testDetectProjectIdWithGcloudConfig()
    {
        $projectId = 'gcloud-project-rawks';

        $configPath = __DIR__ . '/fixtures/config_default_fixture';

        $trait = new DetectProjectTraitStubWithGcloudConfig($configPath);

        $res = $trait->runProjectFromGcloudConfig();

        $this->assertEquals($res, $projectId);
    }
}

class DetectProjectTraitStub
{
    use DetectProjectTrait;

    public function runPathToGcloudConfig()
    {
        return $this->pathToGcloudConfig();
    }

    public function runProjectFromEnvVar()
    {
        return $this->projectFromEnvVar();
    }

    public function runProjectFromGce()
    {
        return $this->projectFromGce();
    }

    public function runProjectFromAppEngine()
    {
        return $this->projectFromAppEngine();
    }

    public function runProjectFromGcloudConfig()
    {
        return $this->projectFromGcloudConfig();
    }
}

class DetectProjectTraitStubOnWindows extends DetectProjectTraitStub
{
    use DetectProjectTrait;

    public function onWindows()
    {
        return true;
    }
}

class DetectProjectTraitStubWithEnvVar extends DetectProjectTraitStub
{
    use DetectProjectTrait;

    protected function getEnvVar()
    {
        return 'GOOGLE_DETECT_PROJECT_TEST_PROJECT_ID';
    }
}

class DetectProjectTraitStubOnAppEngine extends DetectProjectTraitStub
{
    use DetectProjectTrait;

    private $appIdentity;

    public function __construct($appIdentity)
    {
        $this->appIdentity = $appIdentity;
    }

    protected function onAppEngine()
    {
        return true;
    }

    protected function getAppIdentity()
    {
        return $this->appIdentity->reveal();
    }
}

class DetectProjectTraitStubOnGce extends DetectProjectTraitStub
{
    use DetectProjectTrait;

    private $metadata;

    public function __construct($metadata)
    {
        $this->metadata = $metadata;
    }

    protected function onGce($httpHandler)
    {
        return true;
    }

    protected function getMetadata()
    {
        return $this->metadata->reveal();
    }
}

class DetectProjectTraitStubWithGcloudConfig extends DetectProjectTraitStub
{
    use DetectProjectTrait;

    private $configPath;

    public function __construct($configPath)
    {
        $this->configPath = $configPath;
    }

    protected function pathToGcloudConfig()
    {
        return $this->configPath;
    }
}

class DetectProjectTraitStubGrpcDependencyChecks extends DetectProjectTraitStub
{
    use DetectProjectTrait;

    private $dependencyStatus;

    public function __construct(array $dependencyStatus)
    {
        $this->dependencyStatus = $dependencyStatus;
    }

    protected function getGrpcDependencyStatus()
    {
        return $this->dependencyStatus;
    }
}
