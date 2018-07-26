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

namespace Google\Cloud\Vision\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Google\Cloud\Vision\V1\BatchAnnotateImagesResponse;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature_Type;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\ImageContext;
use Google\Cloud\Vision\V1\ImageSource;
use Google\Cloud\Vision\VisionHelpersTrait;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group vision
 */
class VisionHelpersTraitTest extends TestCase
{
    use VisionHelpersTrait;

    private $implementation;

    public function setUp()
    {
        $this->implementation = TestHelpers::impl(VisionHelpersTrait::class);
    }

    public function testAnnotateImageHelper()
    {
        $image = new Image();
        $featureType = Feature_Type::FACE_DETECTION;
        $feature = new Feature();
        $feature->setType($featureType);
        $features = [$feature];
        $imageContext = new ImageContext();
        $imageContext->setLanguageHints(['en']);

        $cb = function ($requests, $optionalArgs) use ($image, $features, $imageContext) {

            // Test that imageContext key is correctly stripped
            $this->assertArrayNotHasKey('imageContext', $optionalArgs);

            $this->assertSame(1, count($requests));
            $request = $requests[0];
            $this->assertEquals($image, $request->getImage());
            // Use iterator_to_array to convert protobuf Repeated Field object to array for comparison
            $this->assertSame($features, iterator_to_array($request->getFeatures()));
            $this->assertSame($imageContext, $request->getImageContext());

            $response = new BatchAnnotateImagesResponse();
            $response->setResponses([new AnnotateImageResponse()]);
            return $response;
        };

        $response = $this->implementation->call('annotateImageHelper', [
            $cb,
            AnnotateImageRequest::class,
            $image,
            $features,
            ['imageContext' => $imageContext]
        ]);

        $this->assertEquals(AnnotateImageResponse::class, get_class($response));
    }

    /**
     * @dataProvider createImageHelperDataProvider
     */
    public function testCreateImageHelper($imageInput, $expectedContent, $expectedUri)
    {
        $image = $this->implementation->call('createImageHelper', [
            Image::class,
            ImageSource::class,
            $imageInput
        ]);
        $this->assertSame($expectedContent, $image->getContent());
        $imageSource = $image->getSource();
        $this->assertSame($expectedUri, is_null($imageSource) ? null : $imageSource->getImageUri());
    }

    public function createImageHelperDataProvider()
    {
        $content = 'imageresourcecontent';
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $content);
        rewind($stream);
        return [
            ["http://my.site/myimage.jpg", "", "http://my.site/myimage.jpg"],
            ["https://my.site/myimage.jpg", "", "https://my.site/myimage.jpg"],
            ["gs://my_bucket/myimage.jpg", "", "gs://my_bucket/myimage.jpg"],
            ["abcdefxyz", "abcdefxyz", null],
            [$stream, $content, null],
            [
                $this->createImageHelper(Image::class, ImageSource::class, 'foobar'),
                'foobar',
                null
            ],
            [
                $this->createImageHelper(Image::class, ImageSource::class, 'https://my.site/myimage.jpg'),
                '',
                'https://my.site/myimage.jpg'
            ],
        ];
    }

    /**
     * @dataProvider invalidCreateImageHelperDataProvider
     * @expectedException InvalidArgumentException
     */
    public function testInvalidCreateImageHelper($imageInput)
    {
        $this->implementation->call('createImageHelper', [
            Image::class,
            ImageSource::class,
            $imageInput
        ]);
    }

    public function invalidCreateImageHelperDataProvider()
    {
        return [
            [null],
            [5],
        ];
    }
}
