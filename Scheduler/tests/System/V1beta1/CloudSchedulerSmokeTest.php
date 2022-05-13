<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Scheduler\Tests\System\V1beta1;

use Google\Cloud\Scheduler\V1beta1\AppEngineHttpTarget;
use Google\Cloud\Scheduler\V1beta1\CloudSchedulerClient;
use Google\Cloud\Scheduler\V1beta1\Job;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group scheduler
 * @group gapic
 */
class CloudSchedulerSmokeTest extends TestCase
{
    protected static $grpcClient;
    protected static $restClient;
    protected static $projectId;
    private static $location = 'us-central1';
    private static $hasSetUp = false;

    public function clientProvider()
    {
        self::set_up_before_class();

        return [
            [self::$grpcClient],
            [self::$restClient]
        ];
    }

    public static function set_up_before_class()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);

        self::$grpcClient = new CloudSchedulerClient([
            'credentials' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$restClient = new CloudSchedulerClient([
            'credentials' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$projectId = $keyFileData['project_id'];

        self::$hasSetUp = true;
    }

    /**
     * @dataProvider clientProvider
     */
    public function testScheduler($client)
    {
        $parent = $client->locationName(self::$projectId, self::$location);
        $target = new AppEngineHttpTarget;
        $target->setRelativeUri('/');
        $job = new Job;
        $job->setName($client->jobName(self::$projectId, self::$location, uniqid('job')));
        $job->setAppEngineHttpTarget($target);
        $job->setSchedule('* * * * *');

        $client->createJob($parent, $job);

        foreach ($client->listJobs($parent) as $job) {
            $name = $job->getName();
            $client->deleteJob($name);
        }
    }
}
