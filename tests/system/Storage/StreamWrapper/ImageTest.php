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

namespace Google\Cloud\Tests\System\Storage\StreamWrapper;

/**
 * @group storage
 * @group streamWrapper
 */
class ImageTest extends StreamWrapperTestCase
{
    const TEST_IMAGE_WITH_EXIF = 'https://storage.googleapis.com/chingor-php-gcs.appspot.com/Friday-2.jpg';
    const TEST_IMAGE = 'https://storage.googleapis.com/chingor-php-gcs.appspot.com/featured_google.jpg';

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // must get contents because we can't pass an fopen stream from the https stream wrapper
        // because it's not seekable
        $contents = file_get_contents(self::TEST_IMAGE_WITH_EXIF);
        self::$bucket->upload(
            $contents,
            ['name' => 'exif.jpg']
        );
        $contents = file_get_contents(self::TEST_IMAGE);
        self::$bucket->upload(
            $contents,
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
        $this->assertTrue(count(array_keys($info)) > 1);
    }

    public function imageProvider()
    {
        return [
            ['plain.jpg', 1956, 960],
            ['exif.jpg', 3960, 2640],
        ];
    }
}
