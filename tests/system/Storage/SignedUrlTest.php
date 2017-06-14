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

/**
 * @group storage
 * @group storage-signed-urls
 */
class SignedUrlTest extends StorageTestCase
{
    const CONTENT = 'hello world!';

    public function testSignedUrl()
    {
        $obj = $this->createFile();
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
            'Content-type: text/plain'
        ]);

        $obj->reload();
    }

    private function createFile()
    {
        $bucket = self::$bucket;
        $object = $bucket->upload(self::CONTENT, [
            'name' => uniqid(self::TESTING_PREFIX) .'.txt',
        ]);

        return $object;
    }

    private function getFile($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function updateFile($url, $content, array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function deleteFile($url, array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
