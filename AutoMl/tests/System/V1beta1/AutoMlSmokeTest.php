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

namespace Google\Cloud\AutoMl\Tests\System\V1beta1;

use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Cloud\AutoMl\V1beta1\Dataset;
use Google\Cloud\AutoMl\V1beta1\TranslationDatasetMetadata;
use PHPUnit\Framework\TestCase;

/**
 * @group automl
 * @group gapic
 */
class AutoMlSmokeTest extends TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $clients;
    protected static $projectId;
    private static $location = 'us-central1';
    private static $hasSetUp = false;

    public static function set_up_before_class()
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
        $formattedParent = $automl->locationName(self::$projectId, self::$location);
        $dataset = new Dataset([
            'display_name' => uniqid(self::TESTING_PREFIX),
            'translation_dataset_metadata' => new TranslationDatasetMetadata([
                'source_language_code' => 'en',
                'target_language_code' => 'es'
            ])
        ]);

        $response = $automl->createDataset($formattedParent, $dataset);
        $datasetName = $response->getName();
        $ds = $automl->getDataset($datasetName);
        $this->assertInstanceOf(Dataset::class, $ds);

        // cleanup
        $automl->deleteDataset($datasetName);
    }

    public function clientsProvider()
    {
        self::set_up_before_class();
        return self::$clients;
    }
}
