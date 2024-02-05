<?php
/**
 * Copyright 2024 Google Inc.
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

use Exception;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\HandwrittenClientTrait;
use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Testing\TestHelpers;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 * @group core-client-trait
 */
class HandwrittenClientTraitTest extends TestCase
{
    use ProphecyTrait;

    private $impl;
    private $dependency;

    public function setUp(): void
    {
        $this->impl = TestHelpers::impl(HandwrittenClientTrait::class);
    }

    public function testCredentialsWithEnv()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$keyFilePath");

        $conf = $this->impl->call('initCredentialsAndProjectId', [[]]);

        $this->assertInstanceOf(CredentialsWrapper::class, $conf['credentials']);
    }

    public function testCredentialsWithKeyFileContents()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();
        $keyFile = json_decode(file_get_contents($keyFilePath), true);

        $conf = $this->impl->call('initCredentialsAndProjectId', [[
            'credentials' => $keyFile
        ]]);

        $this->assertInstanceOf(CredentialsWrapper::class, $conf['credentials']);
    }

    public function testCredentialsWithKeyFilePath()
    {
        $keyFilePath = Fixtures::JSON_KEY_FIXTURE();

        $conf = $this->impl->call('initCredentialsAndProjectId', [[
            'credentials' => $keyFilePath
        ]]);

        $this->assertInstanceOf(CredentialsWrapper::class, $conf['credentials']);
    }

    public function testInitCredentialsAndProjectIdWithInvalidKeyFilePath()
    {
        $this->expectException(ValidationException::class);

        $keyFilePath = __DIR__ . '/i/sure/hope/this/doesnt/exist';

        $conf = $this->impl->call('initCredentialsAndProjectId', [[
            'credentials' => $keyFilePath
        ]]);
    }

    public function testDetectProjectIdWithNoProjectIdAvailable()
    {
        $this->expectException(GoogleException::class);

        $conf = $this->impl->call('detectProjectId', [[
            'projectIdRequired' => true,
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

        $trait = TestHelpers::impl(HandwrittenClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [[]]);

        $this->assertEquals($res, $projectId);
    }

    public function testDetectNumericProjectIdOnGce()
    {
        $projectId = '1234567';

        $m = $this->prophesize(Metadata::class);
        $m->getNumericProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = TestHelpers::impl(HandwrittenClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [['preferNumericProjectId' => true]]);

        $this->assertEquals($res, $projectId);
    }

    public function testDetectProjectIdOnGceButOhNoThereStillIsntAProjectId()
    {
        $this->expectException(GoogleException::class);

        $projectId = null;

        $m = $this->prophesize(Metadata::class);
        $m->getProjectId()->willReturn($projectId)->shouldBeCalled();

        $trait = TestHelpers::impl(HandwrittenClientTraitStubOnGce::class, ['metadata']);
        $trait->___setProperty('metadata', $m);

        $res = $trait->call('detectProjectId', [[
            'projectIdRequired' => true
        ]]);
    }

    public function testDetectProjectIdEmulatorWithProjectId()
    {
        $projectId = 'emulator-project';

        $res = $this->impl->call('detectProjectId', [[
            'hasEmulator' => true,
            'projectId' => $projectId,
        ]]);

        $this->assertEquals($projectId, $res);
    }


    public function testDetectProjectIdEmulator()
    {
        $projectId = 'emulator-project';

        $res = $this->impl->call('detectProjectId', [[
            'hasEmulator' => true
        ]]);

        $this->assertEquals($projectId, $res);
    }
}

//@codingStandardsIgnoreStart
trait HandwrittenClientTraitStubOnGce
{
    use HandwrittenClientTrait;

    protected function onGce($httpHandler)
    {
        return true;
    }

    protected function getMetadata()
    {
        return $this->metadata->reveal();
    }
}
//@codingStandardsIgnoreEnd
