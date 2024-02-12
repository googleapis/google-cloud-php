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

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ValidationException;
use Google\Auth\ProjectIdProviderInterface;
use Google\Cloud\Core\DetectProjectIdTrait;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Testing\TestHelpers;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 * @group core-client-trait
 */
class DetectProjectIdTraitTest extends TestCase
{
    use ProphecyTrait;

    private $impl;
    private $dependency;
    private $credentials;

    public function setUp(): void
    {
        $this->impl = TestHelpers::impl(DetectProjectIdTrait::class);
        $this->credentials = $this->prophesize(ProjectIdProviderInterface::class);
    }

    public function testDetectProjectIdFromCredentials()
    {
        $this->credentials->getProjectId()->willReturn('abc');

        $projectId = $this->impl->call('detectProjectId', [[
            'credentials' => $this->credentials->reveal()
        ]]);

        $this->assertEquals('abc', $projectId);
    }

    public function testDetectProjectIdThrowsValidationExceptionOnNullProjectId()
    {
        $this->expectException(GoogleException::class);
        $this->credentials->getProjectId()->willReturn(null);

        $projectId = $this->impl->call('detectProjectId', [[
            'credentials' => $this->credentials->reveal(),
            'projectIdRequired' => true
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
