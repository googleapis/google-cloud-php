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

namespace Google\Cloud\OsLogin\Tests\System\V1beta;

use Google\Auth\CredentialsLoader;
use Google\Cloud\OsLogin\V1beta\OsLoginServiceClient;
use Google\Cloud\OsLogin\V1beta\LoginProfile;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class OsLoginServiceClientTest extends TestCase
{
    protected static $grpcClient;
    protected static $restClient;
    protected static $clientEmail;
    private static $hasSetUp = false;

    public function clientProvider()
    {
        self::set_up_before_class();

        return [
            [self::$restClient],
            [self::$grpcClient]
        ];
    }

    public static function set_up_before_class()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);

        self::$restClient = new OsLoginServiceClient([
            'credentials' => $keyFilePath,
            'transport' => 'rest'
        ]);

        self::$grpcClient = new OsLoginServiceClient([
            'credentials' => $keyFilePath,
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
