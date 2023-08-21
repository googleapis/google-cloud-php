<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage\Tests\System\StreamWrapper;

/**
 * @group storage
 * @group storage-stream-wrapper
 * @group storage-stream-wrapper-image
 */
class ImageTest extends StreamWrapperTestCase
{
    const TEST_IMAGE_WITH_EXIF = __DIR__ . '/../data/fujifilm-dx10.jpg';
    const TEST_IMAGE = __DIR__ . '/../data/screenshot.png';

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$bucket->upload(
            fopen(self::TEST_IMAGE_WITH_EXIF, 'r'),
            ['name' => 'exif.jpg']
        );
        self::$bucket->upload(
            fopen(self::TEST_IMAGE, 'r'),
            ['name' => 'plain.jpg']
        );
    }

    /**
     * @dataProvider imageProvider
     */
    public function testGetImageSize($image, $width, $height)
    {
        $url = self::generateUrl($image);
        $size = getimagesize($url);
        $this->assertEquals($width, $size[0]);
        $this->assertEquals($height, $size[1]);
    }

    /**
     * @dataProvider imageProvider
     */
    public function testGetImageSizeWithInfo($image, $width, $height)
    {
        $url = self::generateUrl($image);
        $info = array();
        $size = getimagesize($url, $info);
        $this->assertEquals($width, $size[0]);
        $this->assertEquals($height, $size[1]);
        $this->assertGreaterThan(1, array_keys($info));
    }

    public function imageProvider()
    {
        return [
            ['plain.jpg', 1027, 823],
            ['exif.jpg', 1024, 768],
        ];
    }
}
