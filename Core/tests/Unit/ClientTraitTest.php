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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Compute\Metadata;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group client-trait
 */
class ClientTraitTest extends TestCase
{
    private $impl;
    private $dependency;

    public function setUp()
    {
        $this->impl = \Google\Cloud\Core\Testing\TestHelpers::impl(ClientTrait::class);

        $this->dependency = \Google\Cloud\Core\Testing\TestHelpers::impl(ClientTraitStubGrpcDependencyChecks::class, [
            'dependencyStatus'
        ]);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     * @dataProvider invalidDependencyStatusProvider
     */
    public function testGetConnectionTypeInvalidStatus($dependencyStatus, $config)
    {
        $this->dependency->___setProperty('dependencyStatus', $dependencyStatus);
        $this->dependency->call('getConnectionType', [$config]);
    }

    /**
     * @dataProvider dependencyStatusProvider
     */
    public function testGetConnectionType($dependencyStatus, $config, $expectedConnectionType)
    {
        $this->dependency->___setProperty('dependencyStatus', $dependencyStatus);

        $actualConnectionType = $this->dependency->call('getConnectionType', [$config]);

        $this->assertEquals($expectedConnectionType, $actualConnectionType);
    }

    public function invalidDependencyStatusProvider()
    {
        return [
            [
                false,
                ['transport' => 'grpc'],
            ],
        ];
    }

    public function dependencyStatusProvider()
    {
        return [
            [
                true,
                [],
                'grpc'
            ],
            [
                false,
                [],
                'rest'
            ],
            [
                false,
                ['transport' => 'rest'],
                'rest'
            ],
            [
                true,
                ['transport' => 'rest'],
                'rest'
            ],
            [
                true,
                ['transport' => 'grpc'],
                'grpc'
            ],
        ];
    }

    public function testRequireGrpcPassesWithGrpc()
    {
        $this->dependency->___setProperty('dependencyStatus', true);

        $this->assertNull(
            $this->dependency->call('requireGrpc')
        );
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testRequireGrpcThrowsExceptionWithoutGrpc()
    {
        $this->dependency->___setProperty('dependencyStatus', false);
        $this->dependency->call('requireGrpc');
    }

    public function testConfigureAuthentication()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath"); // for application default credentials

        $conf = $this->impl->call('configureAuthentication', [[]]);

        $this->assertEquals(json_decode(file_get_contents($keyFilePath), true), $conf['keyFile']);
        $this->assertEquals('example_project', $this->impl->___getProperty('projectId'));
    }

    public function testConfigureAuthenticationWithKeyFile()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        $keyFile['project_id'] = 'test';

        $conf = $this->impl->call('configureAuthentication', [[
            'keyFile' => $keyFile
        ]]);

        $this->assertEquals($keyFile, $conf['keyFile']);
        $this->assertEquals('test', $this->impl->___getProperty('projectId'));
    }

    public function testConfigureAuthenticationWithKeyFilePath()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        $keyFile = json_decode(file_get_contents($keyFilePath), true);

        $conf = $this->impl->call('configureAuthentication', [[
            'keyFilePath' => $keyFilePath
        ]]);

        $this->assertEquals($keyFile, $conf['keyFile']);
        $this->assertEquals('example_project', $this->impl->___getProperty('projectId'));
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testConfigureAuthenticationWithInvalidKeyFilePath()
    {
        $keyFilePath = __DIR__ . '/i/sure/hope/this/doesnt/exist';

        $conf = $this->impl->call('configureAuthentication', [[
            'keyFilePath' => $keyFilePath
        ]]);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testConfigureAuthenticationWithKeyFileThatCantBeDecoded()
    {
        $keyFilePath = __DIR__ . '/ClientTraitTest.php';

        $conf = $this->impl->call('configureAuthentication', [[
            'keyFilePath' => $keyFilePath
        ]]);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testDetectProjectIdWithNoProjectIdAvailable()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        unset($keyFile['project_id']);

        $conf = $this->impl->call('detectProjectId', [[
            'projectIdRequired' => true,
            'keyFile' => $keyFile,
            'httpHandler' => function ($request, $options = []) {
                return new Response(500);
            }
        ]]);
    }

    public function testProjectIdFromEnv()
    {
        $projectId = 'project-from-env';

        $originalOldEnv = getenv('GCLOUD_PROJECT');
        $originalEnv = getenv('GOOGLE_CLOUD_PROJECT');

        try {
            putenv('GOOGLE_CLOUD_PROJECT=' . $projectId);
            putenv('GCLOUD_PROJECT=invalid-value');
            $res = $this->impl->call('detectProjectId', [[]]);

            $this->assertEquals($res, $projectId);
        } finally {
            if ($originalOldEnv === false) {
                putenv('GCLOUD_PROJECT');
            } else {
                putenv('GCLOUD_PROJECT=' . $originalOldEnv);
            }

            if ($originalEnv === false) {
                putenv('GOOGLE_CLOUD_PROJECT');
            } else {
                putenv('GOOGLE_CLOUD_PROJECT=' . $originalEnv);
            }
        }
    }

    public function testProjectIdFromOldEnv()
    {
        $projectId = 'project-from-env';

        $originalEnv = getenv('GCLOUD_PROJECT');

        $originalOldEnv = getenv('GCLOUD_PROJECT');
        $originalEnv = getenv('GOOGLE_CLOUD_PROJECT');

        try {
            putenv('GCLOUD_PROJECT=' . $projectId);
            putenv('GOOGLE_CLOUD_PROJECT');
            $res = $this->impl->call('detectProjectId', [[]]);

            $this->assertEquals($res, $projectId);
        } finally {
            if ($originalOldEnv === false) {
                putenv('GCLOUD_PROJECT');
            } else {
                putenv('GCLOUD_PROJECT=' . $originalOldEnv);
            }

            if ($originalEnv === false) {
                putenv('GOOGLE_CLOUD_PROJECT');
            } else {
                putenv('GOOGLE_CLOUD_PROJECT=' . $originalEnv);
            }
        }
    }

    public function testDetectProjectIdOnGce()
    {
        $projectId = 'gce-project-rawks';

        $m = $this->prophesize(Metadata::class);
        $m->getProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = \Google\Cloud\Core\Testing\TestHelpers::impl(ClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [[]]);

        $this->assertEquals($res, $projectId);
    }

    public function testDetectNumericProjectIdOnGce()
    {
        $projectId = '1234567';

        $m = $this->prophesize(Metadata::class);
        $m->getNumericProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = \Google\Cloud\Core\Testing\TestHelpers::impl(ClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [['preferNumericProjectId' => true]]);

        $this->assertEquals($res, $projectId);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testDetectProjectIdOnGceButOhNoThereStillIsntAProjectId()
    {
        $projectId = null;

        $m = $this->prophesize(Metadata::class);
        $m->getProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = \Google\Cloud\Core\Testing\TestHelpers::impl(ClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [[
            'projectIdRequired' => true
        ]]);
    }

    public function testDetectProjectIdEmulator()
    {
        $projectId = 'emulator-project';

        $originalEnv = getenv('GCLOUD_PROJECT');
        putenv('GCLOUD_PROJECT');

        $m = $this->prophesize(Metadata::class);
        $m->getProjectId()->willReturn(false)->shouldBeCalled();

        $trait = \Google\Cloud\Core\Testing\TestHelpers::impl(ClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [[
            'hasEmulator' => true
        ]]);

        if ($originalEnv) {
            putenv('GCLOUD_PROJECT='. $originalEnv);
        }

        $this->assertEquals($projectId, $res);
    }
}

trait ClientTraitStubOnGce
{
    use ClientTrait;

    protected function onGce($httpHandler)
    {
        return true;
    }

    protected function getMetadata()
    {
        return $this->metadata->reveal();
    }
}

trait ClientTraitStubGrpcDependencyChecks
{
    use ClientTrait;

    protected function isGrpcLoaded()
    {
        return $this->dependencyStatus;
    }
}
