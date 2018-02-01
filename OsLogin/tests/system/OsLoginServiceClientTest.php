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

namespace Google\Cloud\Tests\System\Container;

use Google\Auth\CredentialsLoader;
use Google\Cloud\OsLogin\V1beta\OsLoginServiceClient;
use Google\Cloud\OsLogin\V1beta\LoginProfile;
use Google\Cloud\Tests\System\SystemTestCase;

class OsLoginServiceClientTest extends SystemTestCase
{
    protected static $grpcClient;
    protected static $restClient;
    protected static $clientEmail;
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

        self::$restClient = new OsLoginServiceClient([
            'credentialsLoader' => $credentialsLoader,
            'transport' => 'rest'
        ]);

        self::$grpcClient = new OsLoginServiceClient([
            'credentialsLoader' => $credentialsLoader,
            'transport' => 'grpc'
        ]);

        self::$clientEmail = $keyFileData['client_email'];

        self::$hasSetUp = true;
    }

    /**
     * @dataProvider clientProvider
     */
    public function testListOperations(OsLoginServiceClient $client)
    {
        $response = $client->getLoginProfile(
            $client->userName(self::$clientEmail)
        );

        $this->assertInstanceOf(LoginProfile::class, $response);
    }
}
