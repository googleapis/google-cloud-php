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

namespace Google\Cloud\VideoIntelligence\Tests\System\V1;

use Google\ApiCore\OperationResponse;
use Google\Cloud\VideoIntelligence\V1\AnnotateVideoResponse;
use Google\Cloud\VideoIntelligence\V1\VideoIntelligenceServiceClient;
use Google\Cloud\VideoIntelligence\V1\Feature;
use PHPUnit\Framework\TestCase;

/**
 * @group video
 */
class VideoIntelligenceServiceClientTest extends TestCase
{
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

        self::$restClient = new VideoIntelligenceServiceClient([
            'credentials' => $keyFilePath,
            'transport' => 'rest'
        ]);

        self::$grpcClient = new VideoIntelligenceServiceClient([
            'credentials' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$projectId = $keyFileData['project_id'];

        self::$hasSetUp = true;
    }

    /**
     * @dataProvider clientProvider
     */
    public function testAnnotateVideo(VideoIntelligenceServiceClient $client)
    {
        $inputUri = "gs://cloudmleap/video/next/animals.mp4";
        $features = [
            Feature::LABEL_DETECTION,
            Feature::SHOT_CHANGE_DETECTION,
        ];

        $operationResponse = $client->annotateVideo([
            'inputUri' => $inputUri,
            'features' => $features
        ]);

        $this->assertInstanceOf(OperationResponse::class, $operationResponse);

        $operationResponse->pollUntilComplete();
        $this->assertTrue($operationResponse->operationSucceeded());

        $results = $operationResponse->getResult();
        $this->assertInstanceOf(AnnotateVideoResponse::class, $results);

    }
}
