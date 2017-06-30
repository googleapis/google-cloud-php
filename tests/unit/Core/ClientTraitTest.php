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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Compute\Metadata;
use GuzzleHttp\Psr7\Response;

/**
 * @group core
 */
class ClientTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testGetConnectionTypeThrowsExceptionWhenAttempingGrpcWithoutDeps()
    {
        $trait = new ClientTraitStubGrpcDependencyChecks([false, false]);
        $trait->runGetConnectionType(['transport' => 'grpc']);
    }

    /**
     * @dataProvider dependencyStatusProvider
     */
    public function testGetConnectionType($dependencyStatus, $config, $expectedConnectionType)
    {
        $trait = new ClientTraitStubGrpcDependencyChecks($dependencyStatus);
        $actualConnectionType = $trait->runGetConnectionType($config);

        $this->assertEquals($expectedConnectionType, $actualConnectionType);
    }

    public function dependencyStatusProvider()
    {
        return [
            [
                [true, true],
                [],
                'rest'
            ],
            [
                [false, false],
                ['transport' => 'rest'],
                'rest'
            ],
            [
                [false, true],
                [],
                'rest'
            ],
            [
                [true, true],
                ['transport' => 'grpc'],
                'grpc'
            ]
        ];
    }

    public function testConfigureAuthentication()
    {
        $keyFilePath = __DIR__ . '/../fixtures/json-key-fixture.json';
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath"); // for application default credentials

        $trait = new ClientTraitStub;
        $conf = $trait->runConfigureAuthentication([]);

        $this->assertEquals(json_decode(file_get_contents($keyFilePath), true), $conf['keyFile']);
        $this->assertEquals('example_project', $trait->getProjectId());
    }

    public function testConfigureAuthenticationWithKeyFile()
    {
        $keyFilePath = __DIR__ . '/../fixtures/json-key-fixture.json';
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        $keyFile['project_id'] = 'test';

        $trait = new ClientTraitStub;
        $conf = $trait->runConfigureAuthentication([
            'keyFile' => $keyFile
        ]);

        $this->assertEquals($keyFile, $conf['keyFile']);
        $this->assertEquals('test', $trait->getProjectId());
    }

    public function testConfigureAuthenticationWithKeyFilePath()
    {
        $keyFilePath = __DIR__ . '/../fixtures/json-key-fixture.json';
        $keyFile = json_decode(file_get_contents($keyFilePath), true);

        $trait = new ClientTraitStub;
        $conf = $trait->runConfigureAuthentication([
            'keyFilePath' => $keyFilePath
        ]);

        $this->assertEquals($keyFile, $conf['keyFile']);
        $this->assertEquals('example_project', $trait->getProjectId());
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testConfigureAuthenticationWithInvalidKeyFilePath()
    {
        $keyFilePath = __DIR__ . '/i/sure/hope/this/doesnt/exist';

        $trait = new ClientTraitStub;
        $conf = $trait->runConfigureAuthentication([
            'keyFilePath' => $keyFilePath
        ]);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testConfigureAuthenticationWithKeyFileThatCantBeDecoded()
    {
        $keyFilePath = __DIR__ . '/ClientTraitTest.php';

        $trait = new ClientTraitStub;
        $conf = $trait->runConfigureAuthentication([
            'keyFilePath' => $keyFilePath
        ]);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\GoogleException
     */
    public function testDetectProjectIdWithNoProjectIdAvailable()
    {
        $keyFilePath = __DIR__ . '/../fixtures/json-key-fixture.json';
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        unset($keyFile['project_id']);

        $trait = new ClientTraitStub;
        $conf = $trait->runDetectProjectId([
            'keyFile' => $keyFile,
            'httpHandler' => function ($request, $options = []) {
                return new Response(500);
            }
        ]);
    }

    public function testProjectIdFromEnv()
    {
        $projectId = 'project-from-env';

        $trait = new ClientTraitStub();

        $originalEnv = getenv('GCLOUD_PROJECT');
        
        try {
            putenv('GCLOUD_PROJECT=' . $projectId);
            $res = $trait->runDetectProjectId([]);

            $this->assertEquals($res, $projectId);
        } finally {
            if ($originalEnv === false) {
                putenv('GCLOUD_PROJECT');
            } else {
                putenv('GCLOUD_PROJECT=' . $originalEnv);
            }
        }
    }

    public function testDetectProjectIdOnGce()
    {
        $projectId = 'gce-project-rawks';

        $m = $this->prophesize(Metadata::class);
        $m->getProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = new ClientTraitStubOnGce($m);

        $res = $trait->runDetectProjectId([]);

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

        $trait = new ClientTraitStubOnGce($m);

        $res = $trait->runDetectProjectId([]);
    }
}

class ClientTraitStub
{
    use ClientTrait;

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function runGetConnectionType($config)
    {
        return $this->getConnectionType($config);
    }

    public function runConfigureAuthentication($config)
    {
        return $this->configureAuthentication($config);
    }

    public function runDetectProjectId($config)
    {
        return $this->detectProjectId($config);
    }
}

class ClientTraitStubOnGce extends ClientTraitStub
{
    use ClientTrait;

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

class ClientTraitStubGrpcDependencyChecks extends ClientTraitStub
{
    use ClientTrait;

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
