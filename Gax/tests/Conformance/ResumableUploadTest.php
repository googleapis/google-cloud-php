<?php
/*
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Generator\Tests\Conformance;

use Google\ApiCore\Call;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\ResumableUpload\ResumableUpload;
use Google\ApiCore\ResumableUpload\ResumableUploadClient;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Protobuf\Timestamp;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;

/**
 * Conformance tests validating ResumableUploadClient and ResumableUpload protocol implementation
 * against a locally running gapic-showcase server instance.
 */
class ResumableUploadTest extends TestCase
{
    private const SHOWCASE_HOST = 'http://localhost:7469';

    private function createClientAndUpload(
        string $data,
        ?callable $progressCallback = null,
        array $headers = []
    ): Timestamp {
        $httpHandler = HttpHandlerFactory::build();
        $requestBuilder = $this->createMock(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->method('build')->willReturnCallback(function ($path, $message, $reqHeaders = []) {
            $body = $message ? $message->serializeToJsonString() : '';
            return new \GuzzleHttp\Psr7\Request('POST', self::SHOWCASE_HOST, $reqHeaders, $body);
        });

        $client = new ResumableUploadClient(
            $requestBuilder,
            [$httpHandler, 'async'],
            new InsecureCredentialsWrapper(),
            serviceAddress: self::SHOWCASE_HOST,
            uploadPrefix: '/upload'
        );

        $options = [
            'chunkSize' => 1024,
            'headers' => $headers
        ];
        if ($progressCallback !== null) {
            $options['progressCallback'] = $progressCallback;
        }

        $upload = new ResumableUpload(
            $client,
            new Call(
                'test.method',
                Timestamp::class,
                new Timestamp()
            ),
            $options
        );

        $stream = Utils::streamFor($data);
        return $upload->startUpload($stream);
    }

    public function testHappyPathUpload()
    {
        $callbackBytes = null;
        $callbackUrl = null;
        $payload = "hello world from happy path integration test to resumable upload service!";

        $result = $this->createClientAndUpload(
            $payload,
            function (int $bytes, ResumableUpload $upload) use (&$callbackBytes, &$callbackUrl) {
                $callbackBytes = $bytes;
                $callbackUrl = $upload->getUploadUrl();
            }
        );

        $this->assertInstanceOf(Timestamp::class, $result);
        $this->assertEquals(strlen($payload), $callbackBytes);
        $this->assertStringStartsWith(self::SHOWCASE_HOST . "/upload?sid=", $callbackUrl);
    }

    public function testNonFatalErrorOnStartRecovery()
    {
        $payload = "data with transient 503 error on start";
        $result = $this->createClientAndUpload(
            $payload,
            headers: [
                'X-Goog-Test-Scenario' => 'non_fatal_error_on_start',
                'X-Goog-Test-Scenario-Config' => json_encode([
                    'error_code' => 503,
                    'failure_count' => 2,
                    'action_after_failures' => 'succeed'
                ])
            ]
        );

        $this->assertInstanceOf(Timestamp::class, $result);
    }

    public function testNonFatalErrorOnChunkUploadRecovery()
    {
        $payload = "data with transient 503 error on chunk upload";
        $result = $this->createClientAndUpload(
            $payload,
            headers: [
                'X-Goog-Test-Scenario' => 'non_fatal_error_on_chunk_upload',
                'X-Goog-Test-Scenario-Config' => json_encode([
                    'error_code' => 503,
                    'failure_count' => 2,
                    'action_after_failures' => 'succeed',
                    'after_offset' => 0
                ])
            ]
        );

        $this->assertInstanceOf(Timestamp::class, $result);
    }
}
