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

namespace Google\Cloud\Tests\System\Bigtable;

use Google\Auth\CredentialsLoader;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse;
use Google\Cloud\Core\Testing\System\SystemTestCase;

class BigtableInstanceAdminClientTest extends SystemTestCase
{
    protected static $grpcClient;
    protected static $restClient;
    protected static $projectId;
    private static $hasSetUp = false;

    public function clientProvider()
    {
        self::setUpBeforeClass();

        return [
            [self::$restClient],
            [self::$grpcClient]
        ];
    }

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);

        $credentialsLoader = CredentialsLoader::makeCredentials(
            ['https://www.googleapis.com/auth/cloud-platform'],
            $keyFileData
        );

        self::$restClient = new BigtableInstanceAdminClient([
            'credentialsLoader' => $credentialsLoader,
            'transport' => 'rest'
        ]);

        self::$grpcClient = new BigtableInstanceAdminClient([
            'credentialsLoader' => $credentialsLoader,
            'transport' => 'grpc'
        ]);

        self::$projectId = $keyFileData['project_id'];

        self::$hasSetUp = true;
    }

    /**
     * @dataProvider clientProvider
     */
    public function testListInstances(BigtableInstanceAdminClient $client)
    {
        $response = $client->listInstances(
            $client->projectName(self::$projectId)
        );

        $this->assertInstanceOf(ListInstancesResponse::class, $response);
    }
}
