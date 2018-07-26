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

namespace Google\Cloud\Storage\Tests\System;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Timestamp;
use GuzzleHttp\Client;

/**
 * @group storage
 * @group storage-signed-url
 */
class SignedUrlTest extends StorageTestCase
{
    const RANDOM_NAME = 'rand';
    const CONTENT = 'hello world!';

    private $guzzle;

    public function setUp()
    {
        $this->guzzle = new Client;
    }

    public function signedUrls()
    {
        return [
            [
                uniqid(self::TESTING_PREFIX)
            ], [
                uniqid(self::TESTING_PREFIX . ' ' . self::TESTING_PREFIX)
            ], [
                uniqid(self::TESTING_PREFIX) .'/'. uniqid(self::TESTING_PREFIX) .' '. uniqid(self::TESTING_PREFIX)
            ], [
                uniqid(self::TESTING_PREFIX),
                [
                    'headers' => [
                        'x-goog-foo' => 'bar',
                        'x-goog-a' => 'b'
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider signedUrls
     */
    public function testSignedUrl($objectName, array $urlOpts = [])
    {
        $obj = $this->createFile($objectName);
        $ts = new Timestamp(new \DateTime('tomorrow'));
        return $obj->signedUrl($ts, $urlOpts);

        $this->assertEquals(self::CONTENT, $this->getFile($url, $urlOpts));
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testSignedUrlDelete()
    {
        $obj = $this->createFile(uniqid(self::TESTING_PREFIX));

        $ts = new Timestamp(new \DateTime('tomorrow'));
        $url = $obj->signedUrl($ts, [
            'method' => 'DELETE',
            'contentType' => 'text/plain'
        ]);

        try {
            $obj->reload();
        } catch (NotFoundException $e) {
            // If the file doesn't exist now, prevent the expected throw to get a failure.
            return false;
        }

        $this->deleteFile($url, [
            'Content-type' => 'text/plain'
        ]);

        $obj->reload();
    }

    public function testSignedUploadSession()
    {
        $obj = self::$bucket->object(uniqid(self::TESTING_PREFIX) .'.txt');
        $url = $obj->beginSignedUploadSession();

        $this->guzzle->request('PUT', $url, [
            'body' => self::CONTENT
        ]);

        $this->assertTrue($obj->exists());
        $this->assertEquals(self::CONTENT, $obj->downloadAsString());
    }

    public function testSignedUploadSessionOrigin()
    {
        $obj = self::$bucket->object(uniqid(self::TESTING_PREFIX) .'.txt');
        self::$deletionQueue->add($obj);

        $url = $obj->beginSignedUploadSession([
            'origin' => 'https://google.com',
            'headers' => [
                'x-goog-test' => 'hi'
            ]
        ]);

        $res = $this->guzzle->request('OPTIONS', $url, [
            'headers' => [
                'Origin' => 'https://google.com',
                'x-goog-test' => 'hi'
            ]
        ]);

        $this->guzzle->request('PUT', $url, [
            'body' => self::CONTENT,
            'headers' => [
                'x-goog-test' => 'hi'
            ]
        ]);

        $this->assertEquals('https://google.com', $res->getHeaderLine('Access-Control-Allow-Origin'));

        $this->assertTrue($obj->exists());
        $this->assertEquals(self::CONTENT, $obj->downloadAsString());
    }

    public function testSignedUrlContentType()
    {
        $obj = $this->createFile(uniqid(self::TESTING_PREFIX) .'.txt');

        $obj->update([
            'contentType' => null
        ]);

        $url = $obj->signedUrl(time()+2, [
            'responseDisposition' => 'attachment;filename="image.jpg"',
            'responseType' => 'image/jpg'
        ]);

        $res = $this->guzzle->request('GET', $url, [
            'headers' => [
                // 'Content-Type' => 'image/jpg'
            ]
        ]);

        $this->assertEquals('image/jpg', $res->getHeaderLine('Content-Type'));
        $this->assertEquals('attachment;filename="image.jpg"', $res->getHeaderLine('Content-Disposition'));
    }

    private function createFile($name)
    {
        $bucket = self::$bucket;
        $object = $bucket->upload(self::CONTENT, [
            'name' => $name .'.txt',
        ]);

        self::$deletionQueue->add($object);

        return $object;
    }

    private function getFile($url, array $options = [])
    {
        $res = $this->guzzle->request('GET', $url, $options);

        return (string) $res->getBody();
    }

    private function deleteFile($url, array $headers = [])
    {
        $this->guzzle->request('DELETE', $url, [
            'headers' => $headers
        ]);
    }
}
