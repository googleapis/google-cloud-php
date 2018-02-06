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

namespace Google\Cloud\Tests\Unit\Vision;

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature_Type;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\ImageSource;
use Google\Cloud\Vision\VisionHelpersTrait;
use InvalidArgumentException;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group vision
 */
class VisionHelpersTraitTest extends TestCase
{
    private $implementation;

    public function setUp()
    {
        $this->implementation = new VisionHelpersTraitStub();
    }

    public function testBuildSingleFeatureRequest()
    {
        $image = new Image();
        $featureType = Feature_Type::FACE_DETECTION;
        $request = $this->implementation->call('buildSingleFeatureRequest', [
            AnnotateImageRequest::class,
            Feature::class,
            $image,
            $featureType
        ]);
        $this->assertEquals(AnnotateImageRequest::class, get_class($request));
        $this->assertSame($image, $request->getImage());
        $this->assertSame(1, count($request->getFeatures()));
        $this->assertSame($featureType, $request->getFeatures()[0]->getType());
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
        $stream = fopen('php://memory','r+');
        fwrite($stream, $content);
        rewind($stream);
        return [
            ["http://my.site/myimage.jpg", "", "http://my.site/myimage.jpg"],
            ["https://my.site/myimage.jpg", "", "https://my.site/myimage.jpg"],
            ["gs://my_bucket/myimage.jpg", "", "gs://my_bucket/myimage.jpg"],
            ["abcdefxyz", "abcdefxyz", null],
            [$stream, $content, null],
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
            [new Image()],
            [5],
        ];
    }
}

class VisionHelpersTraitStub
{
    use VisionHelpersTrait;

    public function call($fn, array $args)
    {
        return call_user_func_array([$this, $fn], $args);
    }
}
