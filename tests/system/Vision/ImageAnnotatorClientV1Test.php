<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\System\Vision;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use google\cloud\vision\v1\Feature;
use google\cloud\vision\v1\FaceAnnotation;

/**
 * @group vision
 * @group grpc
 */
class ImageAnnotatorClientV1Test extends \PHPUnit_Framework_TestCase
{
    /** @var ImageAnnotatorClient */
    private static $client;
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        self::$client = new ImageAnnotatorClient();
        self::$hasSetUp = true;
    }

    public function testFeatureDetection()
    {
        $image = file_get_contents($this->getFixtureFilePath('obama.jpg'));
        $response = self::$client->detectFeatures($image, [Feature\Type::FACE_DETECTION]);
        $this->assertSame(1, count($response->getFaceAnnotationsList()));
        $face = $response->getFaceAnnotationsList()[0];
        $leftEyePosition = self::$client->getFaceLandmarkPosition(
            $face,
            FaceAnnotation\Landmark\Type::LEFT_EYE);
        $this->assertNotNull($leftEyePosition);
    }

    public function testFaceDetection()
    {
        $image = file_get_contents($this->getFixtureFilePath('obama.jpg'));
        $faces = self::$client->detectFaces($image);
        $this->assertSame(1, count($faces));
        $this->assertInstanceOf('\google\cloud\vision\v1\FaceAnnotation', $faces[0]);
    }

    protected function getFixtureFilePath($file)
    {
        return __DIR__ .'/fixtures/'. $file;
    }
}
