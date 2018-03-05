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

namespace Google\Cloud\Vision\Tests\Snippet\V1;

use Google\ApiCore\Call;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Google\Cloud\Vision\V1\BatchAnnotateImagesResponse;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use GuzzleHttp\Promise\FulfilledPromise;
use Prophecy\Argument;

/**
 * @group vision
 */
class ImageAnnotatorClientTest extends SnippetTestCase
{
    /** @var  ImageAnnotatorClient */
    private $client;
    private $transport;

    public function setUp()
    {
        $this->transport = $this->prophesize(TransportInterface::class);
        $this->client = new ImageAnnotatorClient([
            'transport' => $this->transport->reveal(),
        ]);
    }

    /**
     * @dataProvider createImageObjectSnippetsDataProvider
     */
    public function testCreateImageObjectSnippets($snippetName)
    {
        $snippet = $this->snippetFromMethod(
            ImageAnnotatorClient::class,
            'createImageObject',
            $snippetName
        );
        $snippet->addLocal('imageAnnotatorClient', $this->client);

        $snippet->replace(
            "path/to/image.jpg",
            "php://temp"
        );

        $this->transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getPromisedResponse());

        $res = $snippet->invoke('image');

        $this->assertInstanceOf(Image::class, $res->returnVal());
    }

    public function createImageObjectSnippetsDataProvider()
    {
        return [
            ['resource'],
            ['data'],
            ['url']
        ];
    }

    public function testAnnotateImage()
    {
        $snippet = $this->snippetFromMethod(ImageAnnotatorClient::class, 'annotateImage');
        $snippet->addLocal('imageAnnotatorClient', $this->client);

        $snippet->replace(
            "path/to/image.jpg",
            "php://temp"
        );

        $this->transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getPromisedResponse());

        $res = $snippet->invoke('response');

        $this->assertInstanceOf(AnnotateImageResponse::class, $res->returnVal());
    }

    /**
     * @dataProvider detectionMethodSnippetDataProvider
     */
    public function testDetectionMethodSnippet($method)
    {
        $snippet = $this->snippetFromMethod(ImageAnnotatorClient::class, $method);
        $snippet->addLocal('imageAnnotatorClient', $this->client);

        $snippet->replace(
            "path/to/image.jpg",
            "php://temp"
        );


        $this->transport->startUnaryCall(Argument::type(Call::class), Argument::type('array'))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->getPromisedResponse());

        $res = $snippet->invoke('response');

        $this->assertInstanceOf(AnnotateImageResponse::class, $res->returnVal());
    }

    public function detectionMethodSnippetDataProvider()
    {
        return [
            ['faceDetection'],
            ['landmarkDetection'],
            ['logoDetection'],
            ['labelDetection'],
            ['textDetection'],
            ['documentTextDetection'],
            ['safeSearchDetection'],
            ['imagePropertiesDetection'],
            ['cropHintsDetection'],
            ['webDetection'],
        ];
    }

    private function getPromisedResponse()
    {
        $expectedAnnotationResponses = [new AnnotateImageResponse()];
        $expectedResponse = new BatchAnnotateImagesResponse();
        $expectedResponse->setResponses($expectedAnnotationResponses);
        return new FulfilledPromise(
            $expectedResponse
        );
    }
}
