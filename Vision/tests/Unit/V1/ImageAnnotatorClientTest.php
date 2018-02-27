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

namespace Google\Cloud\Vision\Tests\Unit\V1;

use Google\ApiCore\Call;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesResponse;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature_Type;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\ImageContext;
use Google\Cloud\Vision\V1\ImageSource;
use Google\Cloud\Vision\VisionHelpersTrait;
use GuzzleHttp\Promise\FulfilledPromise;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group vision
 * @group gapic
 */
class ImageAnnotatorClientTest extends TestCase
{
    use VisionHelpersTrait;

    /** @var ImageAnnotatorClient */
    private $client;
    private $transport;

    public function setUp()
    {
        $this->transport = $this->prophesize(TransportInterface::class);
        $this->client = new ImageAnnotatorClient([
            'transport' => $this->transport->reveal(),
        ]);
    }

    public function testCreateImageObject()
    {
        $image = $this->client->createImageObject("gs://my-bucket/myimage.jpg");
        $this->assertSame(Image::class, get_class($image));
        $this->assertSame(ImageSource::class, get_class($image->getSource()));
    }

    /**
     * @dataProvider annotateImageDataProvider
     */
    public function testAnnotateImage($image, $features)
    {
        $expectedAnnotationResponses = [new AnnotateImageResponse()];
        $expectedResponse = new BatchAnnotateImagesResponse();
        $expectedResponse->setResponses($expectedAnnotationResponses);
        $this->transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(1)
            ->willReturn(
                new FulfilledPromise(
                    $expectedResponse
                )
            );

        $res = $this->client->annotateImage($image, $features);

        $this->assertInstanceOf(AnnotateImageResponse::class, $res);
    }

    public function annotateImageDataProvider()
    {
        return [
            [$this->createImageObject('foobar'), [(new Feature())->setType(Feature_Type::FACE_DETECTION)]],
            ['foobar', [Feature_Type::FACE_DETECTION]],
        ];
    }

    public function testAnnotateImageWithImageContext()
    {
        $image = $this->client->createImageObject('foobar');
        $featureType = Feature_Type::FACE_DETECTION;
        $imageContext = new ImageContext();
        $imageContext->setLanguageHints(['en']);

        $expectedFeature = new Feature();
        $expectedFeature->setType($featureType);
        $expectedFeatures = [$expectedFeature];
        $expectedRequest = new AnnotateImageRequest();
        $expectedRequest->setImage($image);
        $expectedRequest->setFeatures($expectedFeatures);
        $expectedRequest->setImageContext($imageContext);
        $expectedRequests = [$expectedRequest];

        $expectedMessage = new BatchAnnotateImagesRequest();
        $expectedMessage->setRequests($expectedRequests);

        $expectedAnnotationResponses = [new AnnotateImageResponse()];
        $expectedResponse = new BatchAnnotateImagesResponse();
        $expectedResponse->setResponses($expectedAnnotationResponses);
        $this->transport->startUnaryCall( Argument::allOf(
                    Argument::type(Call::class),
                    Argument::which('getMethod', 'google.cloud.vision.v1.ImageAnnotator/BatchAnnotateImages'),
                    Argument::which('getMessage', $expectedMessage)
                ),
                Argument::type('array')
            )
            ->shouldBeCalledTimes(1)
            ->willReturn(
                new FulfilledPromise(
                    $expectedResponse
                )
            );

        $feature = new Feature();
        $feature->setType($featureType);
        $features = [$feature];

        $res = $this->client->annotateImage($image, $features, [
            'imageContext' => $imageContext,
        ]);

        $this->assertInstanceOf(AnnotateImageResponse::class, $res);
    }

    /**
     * @dataProvider detectionMethodDataProvider
     */
    public function testDetectionMethod($methodName, $featureType, $image)
    {
        $expectedFeature = new Feature();
        $expectedFeature->setType($featureType);
        $expectedFeatures = [$expectedFeature];
        $expectedRequest = new AnnotateImageRequest();
        $expectedRequest->setImage($this->createImageObject($image));
        $expectedRequest->setFeatures($expectedFeatures);
        $expectedRequests = [$expectedRequest];

        $expectedMessage = new BatchAnnotateImagesRequest();
        $expectedMessage->setRequests($expectedRequests);

        $expectedAnnotationResponses = [new AnnotateImageResponse()];
        $expectedResponse = new BatchAnnotateImagesResponse();
        $expectedResponse->setResponses($expectedAnnotationResponses);
        $this->transport->startUnaryCall(
                Argument::allOf(
                    Argument::type(Call::class),
                    Argument::which('getMethod', 'google.cloud.vision.v1.ImageAnnotator/BatchAnnotateImages'),
                    Argument::which('getMessage', $expectedMessage)
                ),
                Argument::type('array')
            )
            ->shouldBeCalledTimes(1)
            ->willReturn(
                new FulfilledPromise(
                    $expectedResponse
                )
            );

        $res = $this->client->$methodName($image);

        $this->assertInstanceOf(AnnotateImageResponse::class, $res);
    }

    public function detectionMethodDataProvider()
    {
        $items = [
            ['faceDetection', Feature_Type::FACE_DETECTION],
            ['landmarkDetection', Feature_Type::LANDMARK_DETECTION],
            ['logoDetection', Feature_Type::LOGO_DETECTION],
            ['labelDetection', Feature_Type::LABEL_DETECTION],
            ['textDetection', Feature_Type::TEXT_DETECTION],
            ['documentTextDetection', Feature_Type::DOCUMENT_TEXT_DETECTION],
            ['safeSearchDetection', Feature_Type::SAFE_SEARCH_DETECTION],
            ['imagePropertiesDetection', Feature_Type::IMAGE_PROPERTIES],
            ['cropHintsDetection', Feature_Type::CROP_HINTS],
            ['webDetection', Feature_Type::WEB_DETECTION],
        ];
        $data = [];
        foreach ($items as $item) {
            $item[] = 'foobar';
            $item[] = $this->createImageObject('foobar');
            $data[] = $item;
        }
        return $data;
    }

    private function createImageObject($imageInput)
    {
        return $this->createImageHelper(Image::class, ImageSource::class, $imageInput);
    }
}
