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

namespace Google\Cloud\AutoMl\Tests\System\V1;

use Google\ApiCore\ApiException;
use Google\Cloud\AutoMl\V1\AutoMlClient;
use Google\Cloud\AutoMl\V1\Dataset;
use Google\Cloud\AutoMl\V1\TranslationDatasetMetadata;
use Google\Cloud\Core\Testing\System\SystemTestCase;

/**
 * @group automl
 * @group gapic
 */
class AutoMlSmokeTest extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $clients;
    protected static $projectId;
    private static $location = 'us-central1';
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);

        self::$clients = [
            [
                new AutoMlClient([
                    'credentials' => $keyFilePath,
                    'transport' => 'grpc'
                ]),
            ], [
                new AutoMlClient([
                    'credentials' => $keyFilePath,
                    'transport' => 'rest'
                ]),
            ]
        ];

        self::$projectId = $keyFileData['project_id'];

        self::$hasSetUp = true;
    }

    /**
     * @dataProvider clientsProvider
     */
    public function testAutoMl(AutoMlClient $automl)
    {
        $notFound = false;
        $dataset = AutoMlClient::datasetName(
            self::$projectId,
            self::$location,
            'TRL100'
        );

        try {
            $automl->getDataset($dataset);
        } catch (ApiException $e) {
            if ($e->getStatus() === 'NOT_FOUND') {
                $notFound = true;
            }
        }

        $this->assertTrue($notFound);
    }

    public function clientsProvider()
    {
        self::setUpBeforeClass();
        return self::$clients;
    }
}
