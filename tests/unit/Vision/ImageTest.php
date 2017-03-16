<?php
/**
 * Copyright 2016 Google Inc.
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

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Vision\Image;

/**
 * @group vision
 */
class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testWithString()
    {
        $bytes = file_get_contents(__DIR__ .'/../fixtures/vision/eiffel-tower.jpg');
        $image = new Image($bytes, ['landmarks']);

        $res = $image->requestObject();

        $this->assertEquals($res['image']['content'], base64_encode($bytes));
        $this->assertEquals($res['features'], [ ['type' => 'LANDMARK_DETECTION'] ]);
    }

    public function testWithStorage()
    {
        $storage = new StorageClient;
        $bucket = $storage->bucket('test-bucket');
        $object = $bucket->object('test-object.jpg');

        $gcsUri = 'gs://test-bucket/test-object.jpg';

        $image = new Image($object, [ 'landmarks' ]);
        $res = $image->requestObject();

        $this->assertEquals($res['image']['source']['imageUri'], $gcsUri);
        $this->assertEquals($res['features'], [ ['type' => 'LANDMARK_DETECTION'] ]);
    }

    public function testWithResource()
    {
        $resource = fopen(__DIR__ .'/../fixtures/vision/eiffel-tower.jpg', 'r');
        $bytes = file_get_contents(__DIR__ .'/../fixtures/vision/eiffel-tower.jpg');

        $image = new Image($resource, ['landmarks']);
        $res = $image->requestObject();

        $this->assertEquals($res['image']['content'], base64_encode($bytes));
        $this->assertEquals($res['features'], [ ['type' => 'LANDMARK_DETECTION'] ]);
    }

    public function testWithExternalImage()
    {
        $externalUri = 'http://google.com/image.jpg';
        $image = new Image($externalUri, ['landmarks']);

        $res = $image->requestObject();

        $this->assertEquals($res['image']['source']['imageUri'], $externalUri);
        $this->assertEquals($res['features'], [ ['type' => 'LANDMARK_DETECTION'] ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithInvalidType()
    {
        new Image([], ['landmarks']);
    }

    public function testMaxResults()
    {
        $bytes = 'foo';
        $image = new Image($bytes, ['landmarks'], [
            'maxResults' => [
                'landmarks' => 100
            ]
        ]);

        $res = $image->requestObject();
        $this->assertEquals($res['features'][0]['maxResults'], 100);
    }

    public function testShortNamesMapping()
    {
        $names = [
            'faces'           => 'FACE_DETECTION',
            'landmarks'       => 'LANDMARK_DETECTION',
            'logos'           => 'LOGO_DETECTION',
            'labels'          => 'LABEL_DETECTION',
            'text'            => 'TEXT_DETECTION',
            'document'        => 'DOCUMENT_TEXT_DETECTION',
            'safeSearch'      => 'SAFE_SEARCH_DETECTION',
            'imageProperties' => 'IMAGE_PROPERTIES',
            'crop'            => 'CROP_HINTS',
            'web'             => 'WEB_DETECTION'
        ];

        $bytes = 'foo';

        $image = new Image($bytes, array_keys($names));

        $res = $image->requestObject();

        $features = [];
        foreach ($res['features'] as $feature) {
            $features[] = $feature['type'];
        }

        $this->assertEquals(array_values($names), $features);
    }

    public function testBytesWithoutEncoding()
    {
        $bytes = 'foo';

        $image = new Image($bytes, ['landmarks']);

        $res = $image->requestObject(false);
        $this->assertEquals($res['image']['content'], $bytes);

        $encodedRes = $image->requestObject();
        $this->assertEquals($encodedRes['image']['content'], base64_encode($bytes));
    }

    public function testUrlSchemes()
    {
        $urls = [
            'http://foo.bar',
            'https://foo.bar',
            'gs://foo/bar',
            'ssh://foo/bar'
        ];

        $images = [
            new Image($urls[0], ['faces']),
            new Image($urls[1], ['faces']),
            new Image($urls[2], ['faces']),
            new Image($urls[3], ['faces']),
        ];

        $this->assertEquals($urls[0], $images[0]->requestObject()['image']['source']['imageUri']);
        $this->assertEquals($urls[1], $images[1]->requestObject()['image']['source']['imageUri']);
        $this->assertEquals($urls[2], $images[2]->requestObject()['image']['source']['imageUri']);
        $this->assertFalse(isset($images[3]->requestObject()['image']['source']['imageUri']));
    }
}
