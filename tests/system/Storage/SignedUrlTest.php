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

namespace Google\Cloud\Tests\System\Storage;

use Google\Cloud\Core\Timestamp;
use GuzzleHttp\Client;

/**
 * @group storage
 * @group storage-signed-urls
 */
class SignedUrlTest extends StorageTestCase
{
    const CONTENT = 'hello world!';

    private $guzzle;

    public function setUp()
    {
        $this->guzzle = new Client;
    }

    public function testSignedUrl()
    {
        $obj = $this->createFile();
        self::$deletionQueue[] = $obj;

        $ts = new Timestamp(new \DateTime('tomorrow'));
        $url = $obj->signedUrl($ts);

        $this->assertEquals(self::CONTENT, $this->getFile($url));
    }

    public function testSignedUrlWithSpaces()
    {
        $obj = $this->createFile(
            uniqid(self::TESTING_PREFIX . ' ' . self::TESTING_PREFIX)
        );
        self::$deletionQueue[] = $obj;

        $ts = new Timestamp(new \DateTime('tomorrow'));
        $url = $obj->signedUrl($ts);

        $this->assertEquals(self::CONTENT, $this->getFile($url));
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\NotFoundException
     */
    public function testSignedUrlDelete()
    {
        $obj = $this->createFile();
        self::$deletionQueue[] = $obj;

        $ts = new Timestamp(new \DateTime('tomorrow'));
        $url = $obj->signedUrl($ts, [
            'method' => 'DELETE',
            'contentType' => 'text/plain'
        ]);

        $this->deleteFile($url, [
            'Content-type' => 'text/plain'
        ]);

        $obj->reload();
    }

    private function createFile($name = null)
    {
        $bucket = self::$bucket;
        $object = $bucket->upload(self::CONTENT, [
            'name' => $name ?: uniqid(self::TESTING_PREFIX) .'.txt',
        ]);

        return $object;
    }

    private function getFile($url)
    {
        $res = $this->guzzle->request('GET', $url);

        return (string) $res->getBody();
    }

    private function deleteFile($url, array $headers = [])
    {

        $this->guzzle->request('DELETE', $url, [
            'headers' => $headers
        ]);
    }
}
