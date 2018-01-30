<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Tests\System\Debugger;

use Google\Cloud\Debugger\DebuggerClient;
use Google\Cloud\Debugger\Breakpoint;
use Google\Cloud\TestUtils\EventuallyConsistentTestTrait;
use Google\Cloud\TestUtils\AppEngineDeploymentTrait;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * The test deploys the sample app contained in the app folder to Google App
 * Engine Flexible Environment. Before deployment, we generate a composer.json
 * that uses the current branch of google/cloud to test against.
 *
 * Each test sets a breakpoint, ensures that the app has seen the breakpoint,
 * then makes a request to the app that should trigger the breakpoint. We then
 * ensure that the breakpoint has been fulfilled.
 *
 * @group debugger
 * @group e2e
 */
class E2ETest extends TestCase
{
    protected $debuggeeId;
    protected $httpClient;

    use AppEngineDeploymentTrait;
    use EventuallyConsistentTestTrait;

    public static function beforeDeploy()
    {
        self::createComposerJson();
        self::$gcloudWrapper->setDir(implode(DIRECTORY_SEPARATOR, [__DIR__, 'app']));
    }

    public function setUp()
    {
        $url = self::$gcloudWrapper->getBaseUrl();
        $this->httpClient = new Client(['base_uri' => $url]);

        $this->runEventuallyConsistentTest(function () {
            $resp = $this->httpClient->get('/debuggee');
            $this->assertEquals(200, $resp->getStatusCode());
            $data = json_decode($resp->getBody()->getContents(), true);
            $this->assertNotEmpty($data['debuggeeId']);
            $this->debuggeeId = $data['debuggeeId'];
        });
    }

    public static function tearDownAfterClass()
    {
        self::deleteApp();
    }

    public static function getBranch()
    {
        $branch = getenv('TRAVIS_BRANCH') ?: getenv('BRANCH');
        if ($branch === false) {
            self::fail('Please set the BRANCH env var.');
        }
        return $branch;
    }

    public static function getRepo()
    {
        return getenv('TRAVIS_REPO_SLUG')
            ?: getenv('REPO_SLUG')
            ?: 'GoogleCloudPlatform/google-cloud-php';
    }

    public static function createComposerJson()
    {
        $data = [
            'name' => 'google/debugger-test-app',
            'type' => 'project',
            'require' => [
                'php' => '^7.0',
                'silex/silex' => '~2.0',
                'google/cloud' => 'dev-' . self::getBranch(),
                'ext-stackdriver_debugger' => '*'
            ],
            'repositories' => [
                [
                    'type' => 'git',
                    'url' => 'https://github.com/' . self::getRepo()
                ]
            ]
        ];
        $file = implode(DIRECTORY_SEPARATOR, [__DIR__, 'app', 'composer.json']);
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function testWithFullPath()
    {
        $this->setBreakpoint('web/app.php', 29);

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(1);
        });

        $resp = $this->httpClient->get('hello/full');
        $this->assertEquals('200', $resp->getStatusCode(), 'hello/full status code');
        $this->assertContains('Hello, full', $resp->getBody()->getContents());

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(0);
        });
    }

    private function assertBreakpointCount($count)
    {
        $resp = $this->httpClient->get('/debuggee');
        $data = json_decode($resp->getBody()->getContents(), true);
        $this->assertEquals($count, (int) $data['numBreakpoints']);
    }

    public function testWithExtraPath()
    {
        $this->setBreakpoint('/extra/web/app.php', 29);

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(1);
        });

        $resp = $this->httpClient->get('hello/extra');
        $this->assertEquals('200', $resp->getStatusCode(), 'hello/extra status code');
        $this->assertContains('Hello, extra', $resp->getBody()->getContents());

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(0);
        });
    }

    public function testWithMissingPath()
    {
        $this->setBreakpoint('app.php', 29);

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(1);
        });

        $resp = $this->httpClient->get('hello/missing');
        $this->assertEquals('200', $resp->getStatusCode(), 'hello/missing status code');
        $this->assertContains('Hello, missing', $resp->getBody()->getContents());

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(0);
        });
    }

    private function setBreakpoint($file, $line)
    {
        // Set a breakpoint
        $client = new DebuggerClient([
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')
        ]);
        $debuggee = $client->debuggee($this->debuggeeId);
        $breakpoint = $debuggee->setBreakpoint($file, $line);
        $this->assertInstanceOf(Breakpoint::class, $breakpoint);
        $this->assertNotNull($breakpoint->location());
    }
}
