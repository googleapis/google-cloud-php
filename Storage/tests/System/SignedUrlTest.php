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
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group storage
 * @group storage-signed-url
 */
class SignedUrlTest extends StorageTestCase
{
    use ExpectException;

    const CONTENT = 'hello world!';

    private $guzzle;

    public function set_up()
    {
        $this->guzzle = new Client;
    }

    public function signedUrls()
    {
        return [
            [
                uniqid(self::TESTING_PREFIX) . '.txt'
            ], [
                uniqid(self::TESTING_PREFIX . ' ' . self::TESTING_PREFIX) . '.txt'
            ], [
                uniqid(self::TESTING_PREFIX) .
                '/'. uniqid(self::TESTING_PREFIX) .
                ' '. uniqid(self::TESTING_PREFIX) .
                '.txt'
            ], [
                uniqid(self::TESTING_PREFIX) . '.txt',
                [
                    'headers' => [
                        'x-goog-foo' => 'bar',
                        'x-goog-a' => 'b'
                    ]
                ]
            ], [
                uniqid(self::TESTING_PREFIX) . '.txt',
                [
                    'headers' => [
                        'x-goog-foo' => 'bar',
                        'x-goog-a' => 'b'
                    ],
                    'queryParams' => [
                        'generation' => 0
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider signedUrls
     * @group storage-signed-url-v2
     */
    public function testSignedUrlV2($objectName, array $urlOpts = [])
    {
        $urlOpts += [
            'version' => 'v2'
        ];

        $obj = $this->createFile($objectName);
        $ts = new Timestamp(new \DateTime('tomorrow'));
        $url = $obj->signedUrl($ts, $urlOpts);

        $this->assertEquals(self::CONTENT, $this->getFile($url, $urlOpts));
    }

    /**
     * @group storage-signed-url-v4
     * @dataProvider signedUrls
     */
    public function testSignedUrlV4($objectName, array $urlOpts = [])
    {
        $urlOpts += [
            'version' => 'v4'
        ];

        $obj = $this->createFile($objectName);
        $expires = new \DateTime('tomorrow');
        $url = $obj->signedUrl($expires, $urlOpts);

        $this->assertEquals(self::CONTENT, $this->getFile($url, $urlOpts));
    }

    /**
     * @dataProvider signingVersion
     */
    public function testSignedUrlDelete($version)
    {
        $this->expectException('Google\Cloud\Core\Exception\NotFoundException');

        $obj = $this->createFile(uniqid(self::TESTING_PREFIX));

        $ts = (new \DateTime)->modify('+1 day');
        $url = $obj->signedUrl($ts, [
            'method' => 'DELETE',
            'contentType' => 'text/plain',
            'version' => $version
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

    /**
     * @dataProvider signingVersion
     */
    public function testSignedUploadSession($version)
    {
        $obj = self::$bucket->object(uniqid(self::TESTING_PREFIX) .'.txt');
        $url = $obj->beginSignedUploadSession([
            'version' => $version
        ]);

        $this->guzzle->request('PUT', $url, [
            'body' => self::CONTENT,
            'headers' => [
                'Origin' => 'https://google.com',
            ]
        ]);

        $this->assertTrue($obj->exists());
        $this->assertEquals(self::CONTENT, $obj->downloadAsString());
    }

    /**
     * @dataProvider signingVersion
     */
    public function testSignedUploadSessionOrigin($version)
    {
        $obj = self::$bucket->object(uniqid(self::TESTING_PREFIX) .'.txt');
        self::$deletionQueue->add($obj);

        $url = $obj->beginSignedUploadSession([
            'origin' => 'https://google.com',
            'version' => $version,
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
            'version' => $version,
            'headers' => [
                'x-goog-test' => 'hi'
            ]
        ]);

        $this->assertEquals('https://google.com', $res->getHeaderLine('Access-Control-Allow-Origin'));

        $this->assertTrue($obj->exists());
        $this->assertEquals(self::CONTENT, $obj->downloadAsString());
    }

    /**
     * @dataProvider signingVersion
     */
    public function testSignedUrlContentType($version)
    {
        $contentType = 'image/jpeg';
        $disposition = 'attachment;filename="image.jpg"';
        $obj = $this->createFile(uniqid(self::TESTING_PREFIX) .'.jpg');

        $url = $obj->signedUrl(time() + 2, [
            'responseDisposition' => $disposition,
            'responseType' => $contentType,
            'version' => $version
        ]);

        $res = $this->guzzle->request('GET', $url);

        $this->assertEquals(200, $res->getStatusCode());
        $this->assertEquals($contentType, $res->getHeaderLine('Content-Type'));
        $this->assertEquals($disposition, $res->getHeaderLine('Content-Disposition'));
    }

    /**
     * @dataProvider signingVersion
     */
    public function testSignedUrlWithSaveAsName($version)
    {
        $obj = $this->createFile(uniqid(self::TESTING_PREFIX) .'.txt');

        $saveAs = 'foo bar';
        $url = $obj->signedUrl(time() + 2, [
            'saveAsName' => $saveAs,
            'version' => $version
        ]);

        $res = $this->guzzle->request('GET', $url);

        $this->assertEquals(200, $res->getStatusCode());
        $this->assertEquals('attachment; filename="' . $saveAs . '"', $res->getHeaderLine('Content-Disposition'));
    }

    /**
     * @dataProvider signingVersion
     */
    public function testBucketUrlSigning($version)
    {
        $url = self::$bucket->signedUrl(time() + 2, [
            'version' => $version
        ]);

        $res = $this->guzzle->request('GET', $url);
        $this->assertEquals(200, $res->getStatusCode());
    }

    public function signingVersion()
    {
        return [
            ['v2'],
            ['v4']
        ];
    }

    private function createFile($name)
    {
        $bucket = self::$bucket;
        $object = $bucket->upload(self::CONTENT, [
            'name' => $name,
        ]);

        self::$deletionQueue->add($object);

        return $object;
    }

    private function getFile($url, array $options = [])
    {
        $res = $this->guzzle->request('GET', $url, $options + [
            'http_errors' => false
        ]);

        return (string) $res->getBody();
    }

    private function deleteFile($url, array $headers = [])
    {
        $this->guzzle->request('DELETE', $url, [
            'headers' => $headers
        ]);
    }
}
