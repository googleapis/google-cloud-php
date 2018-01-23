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

use Google\Cloud\Debugger\V2\Gapic\Debugger2GapicClient as GapicClient;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\SourceLocation;

use GuzzleHttp\Client;
use Google\Cloud\TestUtils\EventuallyConsistentTestTrait;

use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class E2ETest extends TestCase
{
    protected static $projectId;
    protected static $version = 'e2e-test';
    protected static $debuggeeId;
    protected static $client;

    use EventuallyConsistentTestTrait;

    public static function setUpBeforeClass()
    {
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $data = json_decode(file_get_contents($keyFilePath), true);
        self::$projectId = $data['project_id'];
        self::createComposerJson();
        self::deploy();

        $url = sprintf('https://%s-dot-%s.appspot.com/', self::$version, self::$projectId);
        self::$client = new Client(['base_uri' => $url]);

        $resp = self::$client->get('/debuggee');
        $data = json_decode($resp->getBody()->getContents(), true);
        self::$debuggeeId = $data['debuggeeId'];
    }

    public static function tearDownAfterClass()
    {
        $cmd = sprintf(
            'gcloud -q app versions delete --service default --project %s %s',
            self::$projectId,
            self::$version
        );
        printf("Deleting app: '%s'\n", $cmd);
        exec($cmd);
    }

    public static function createComposerJson()
    {
        $branch = exec('git rev-parse --abbrev-ref HEAD');
        $origin = exec('git remote get-url origin');
        $repo = 'GoogleCloudPlatform/google-cloud-php';
        if (preg_match('/[:\/](.+\/[^\/\.]+)(\.git)?/', $origin, $matches)) {
            $repo = $matches[1];
        }

        $data = [
            'name' => 'google/debugger-test-app',
            'type' => 'project',
            'require' => [
                'php' => '^7.0',
                'silex/silex' => '~2.0',
                'google/cloud' => 'dev-' . $branch,
                'ext-stackdriver_debugger' => '*'
            ],
            'repositories' => [
                [
                    'type' => 'git',
                    'url' => 'https://github.com/' . $repo
                ]
            ]
        ];
        $file = implode(DIRECTORY_SEPARATOR, [__DIR__, 'app', 'composer.json']);
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function deploy()
    {
        $cwd = getcwd();
        chdir(implode(DIRECTORY_SEPARATOR, [__DIR__, 'app']));
        $command = sprintf(
            'gcloud -q app deploy --version %s --project %s --no-promote',
            self::$version,
            self::$projectId
        );
        printf("Executing command: '%s'\n", $command);

        try {
            exec($command, $output, $ret);
        } finally {
            chdir($cwd);
        }
    }

    public function testWithFullPath()
    {
        $this->setBreakpoint('web/app.php', 13);

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(1);
        });

        $resp = self::$client->get('hello/full');
        $this->assertEquals('200', $resp->getStatusCode(), 'hello/full status code');
        $this->assertContains('Hello, full', $resp->getBody()->getContents());

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(0);
        });
    }

    private function assertBreakpointCount($count)
    {
        $resp = self::$client->get('/debuggee');
        $data = json_decode($resp->getBody()->getContents(), true);
        $this->assertEquals($count, (int) $data['numBreakpoints']);
    }

    public function testWithExtraPath()
    {
        $this->setBreakpoint('/extra/web/app.php', 13);

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(1);
        });

        $resp = self::$client->get('hello/extra');
        $this->assertEquals('200', $resp->getStatusCode(), 'hello/extra status code');
        $this->assertContains('Hello, extra', $resp->getBody()->getContents());

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(0);
        });
    }

    public function testWithMissingPath()
    {
        $this->setBreakpoint('app.php', 13);

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(1);
        });

        $resp = self::$client->get('hello/missing');
        $this->assertEquals('200', $resp->getStatusCode(), 'hello/missing status code');
        $this->assertContains('Hello, missing', $resp->getBody()->getContents());

        $this->runEventuallyConsistentTest(function () {
            $this->assertBreakpointCount(0);
        });
    }

    private function setBreakpoint($file, $line)
    {
        // Set a breakpoint
        $client = new GapicClient();
        $breakpoint = new Breakpoint();
        $location = new SourceLocation();
        $location->setPath($file);
        $location->setLine($line);
        $breakpoint->setLocation($location);
        $resp = $client->setBreakpoint(self::$debuggeeId, $breakpoint, 'google.com/php/v0.1');
        $bp = $resp->getBreakpoint();
        $this->assertNotEmpty($bp->getId());
    }

}
