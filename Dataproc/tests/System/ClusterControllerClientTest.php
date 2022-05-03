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

namespace Google\Cloud\Dataproc\Tests\System;

use Google\Auth\CredentialsLoader;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dataproc\V1\ClusterControllerClient;
use Google\Cloud\Dataproc\V1\ListClustersResponse;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class ClusterControllerClientTest extends TestCase
{
    const REGION = 'global';

    protected static $grpcClient;
    protected static $restClient;
    protected static $projectId;
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

        self::$restClient = new ClusterControllerClient([
            'credentials' => $keyFilePath,
            'transport' => 'rest'
        ]);

        self::$grpcClient = new ClusterControllerClient([
            'credentials' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$projectId = $keyFileData['project_id'];

        self::$hasSetUp = true;
    }

    /**
     * @dataProvider clientProvider
     */
    public function testListOperations(ClusterControllerClient $client)
    {
        $pagedResponse = $client->listClusters(self::$projectId, self::REGION);
        $this->assertInstanceOf(PagedListResponse::class, $pagedResponse);

        $response = $pagedResponse->getPage()->getResponseObject();
        $this->assertInstanceOf(ListClustersResponse::class, $response);
    }
}
