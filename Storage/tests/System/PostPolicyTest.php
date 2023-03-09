<?php
/**
 * Copyright 2020 Google LLC
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

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

/**
 * @group storage
 * @group storage-postpolicy
 */
class PostPolicyTest extends StorageTestCase
{
    private $guzzle;

    public function set_up()
    {
        $this->guzzle = new Client;
    }

    public function testUploadPolicy()
    {
        $filename = $this->createFilename();
        $content = 'helloworld';
        $policy = self::$bucket->generateSignedPostPolicyV4($filename, time() + 3600);
        $res = $this->uploadWithPolicy($policy, $content);
        self::$deletionQueue->add($this->getObject($filename));

        $this->assertEquals(204, $res->getStatusCode());
        $this->assertEquals($content, $this->getUploadedFileContents($filename));
    }

    public function testUploadPolicySuccessActionRedirect()
    {
        $filename = $this->createFilename();
        $content = 'helloworld';
        $location = 'https://google.com';
        $policy = self::$bucket->generateSignedPostPolicyV4($filename, time() + 3600, [
            'fields' => [
                'success_action_redirect' => $location
            ]
        ]);
        $res = $this->uploadWithPolicy($policy, $content);
        self::$deletionQueue->add($this->getObject($filename));

        $this->assertEquals(303, $res->getStatusCode());
        $this->assertStringStartsWith(
            $location . '?bucket=' . self::$bucket->name(),
            $res->getHeaderLine('Location')
        );
    }

    public function testUploadPolicyInvalidField()
    {
        $filename = $this->createFilename();
        $policy = self::$bucket->generateSignedPostPolicyV4($filename, time() + 3600, [
            'fields' => [
                'x-goog-random' => 'foo'
            ]
        ]);
        $res = $this->uploadWithPolicy($policy);
        self::$deletionQueue->add($this->getObject($filename));

        $this->assertEquals(400, $res->getStatusCode());
    }

    /**
     * @dataProvider escapingSequences
     */
    public function testUploadPolicyEscapingSequence($cond)
    {
        $filename = $this->createFilename();
        $policy = self::$bucket->generateSignedPostPolicyV4($filename, time() + 3600, [
            'conditions' => [
                ['x-goog-meta-foo' => $cond]
            ],
            'fields' => [
                'x-goog-meta-foo' => $cond
            ]
        ]);
        $res = $this->uploadWithPolicy($policy);
        self::$deletionQueue->add($this->getObject($filename));

        $this->assertGreaterThanOrEqual(200, (int)$res->getStatusCode());
        $this->assertLessThan(300, (int)$res->getStatusCode());
    }

    public function escapingSequences()
    {
        return [
            ["foo
            "],
            ["é"],
            ["hello\world"],
            ["	"] // tab
        ];
    }

    private function uploadWithPolicy(array $policy, $content = '')
    {
        $fields = [];
        $fields[] = [
            'name' => 'file',
            'contents' => Utils::streamFor($content ?: uniqid(self::TESTING_PREFIX))
        ];

        foreach ($policy['fields'] as $key => $val) {
            $fields[] = [
                'name' => $key,
                'contents' => $val
            ];
        }

        return $this->guzzle->request('POST', $policy['url'], [
            'multipart' => $fields,
            'allow_redirects' => false,
            'http_errors' => false
        ]);
    }

    private function getUploadedFileContents($filename)
    {
        $object = self::$bucket->object($filename);
        return $object->downloadAsString();
    }

    private function getObject($filename)
    {
        return self::$bucket->object($filename);
    }

    private function createFilename()
    {
        return uniqid(self::TESTING_PREFIX) . '.txt';
    }
}
