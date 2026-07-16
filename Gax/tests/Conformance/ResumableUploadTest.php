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

use Google\ApiCore\ApiException;
use Google\ApiCore\ResumableUpload\ResumableUpload;
use Google\Showcase\V1beta1\Client\ResumableUploadServiceClient;
use Google\Showcase\V1beta1\UploadMediaRequest;
use Google\Showcase\V1beta1\UploadMediaResponse;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;

/**
 * Conformance tests validating ResumableUploadClient and ResumableUpload protocol implementation
 * against a locally running gapic-showcase server instance using the generated ResumableUploadServiceClient.
 */
class ResumableUploadTest extends TestCase
{
    private const SHOWCASE_HOST = 'localhost:7469';

    private function createClientAndUpload(
        string $data,
        ?callable $progressCallback = null,
        array $headers = []
    ): UploadMediaResponse {
        $client = new ResumableUploadServiceClient([
            'apiEndpoint' => self::SHOWCASE_HOST,
            'hasEmulator' => true,
        ]);

        $callOptions = [
            'headers' => $headers
        ];
        $resumableUploadOptions = [
            'chunkSize' => 1024
        ];
        if ($progressCallback !== null) {
            $resumableUploadOptions['progressCallback'] = $progressCallback;
        }

        $request = new UploadMediaRequest();
        $upload = $client->uploadMedia($request, $callOptions);

        $stream = Utils::streamFor($data);
        return $upload->startUpload($stream, $resumableUploadOptions);
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

        $this->assertInstanceOf(UploadMediaResponse::class, $result);
        $this->assertEquals(strlen($payload), $callbackBytes);
        $this->assertStringStartsWith("http://" . self::SHOWCASE_HOST . "/resumable/upload/v1beta1/files:upload?sid=", $callbackUrl);
    }

    public function testNonFatalErrorOnStartRecovery()
    {
        $payload = "data with transient 503 error on start";
        $headers = [
            'X-Goog-Test-Scenario' => 'non_fatal_error_on_start',
            'X-Goog-Test-Scenario-Config' => json_encode([
                'error_code' => 503,
                'failure_count' => 1,
                'action_after_failures' => 'succeed'
            ])
        ];

        $result = $this->createClientAndUpload($payload, null, $headers);
        $this->assertInstanceOf(UploadMediaResponse::class, $result);
    }

    public function testNonFatalErrorOnChunkUploadRecovery()
    {
        $payload = str_repeat("a", 3000); // multiple chunks
        $headers = [
            'X-Goog-Test-Scenario' => 'non_fatal_error_on_chunk_upload',
            'X-Goog-Test-Scenario-Config' => json_encode([
                'error_code' => 503,
                'failure_count' => 1,
                'after_offset' => 1024,
                'action_after_failures' => 'succeed'
            ])
        ];

        $result = $this->createClientAndUpload($payload, null, $headers);
        $this->assertInstanceOf(UploadMediaResponse::class, $result);
    }

    public function testNonFatalErrorOnQueryRecovery()
    {
        $payload = str_repeat("a", 3000);
        $headers = [
            'X-Goog-Test-Scenario' => 'non_fatal_error_on_query',
            'X-Goog-Test-Scenario-Config' => json_encode([
                'error_code' => 503,
                'failure_count' => 1,
                'action_after_failures' => 'succeed'
            ])
        ];

        $result = $this->createClientAndUpload($payload, null, $headers);
        $this->assertInstanceOf(UploadMediaResponse::class, $result);
    }

    public function testChunkGranularityScenario()
    {
        $payload = str_repeat("b", 1024);
        $headers = [
            'X-Goog-Test-Scenario' => 'chunk_granularity'
        ];

        $result = $this->createClientAndUpload($payload, null, $headers);
        $this->assertInstanceOf(UploadMediaResponse::class, $result);
    }

    public function testFatalErrorOnStartThrowsException()
    {
        $payload = "fatal error payload";
        $headers = [
            'X-Goog-Test-Scenario' => 'fatal_error_on_start',
            'X-Goog-Test-Scenario-Config' => json_encode([
                'error_code' => 403,
                'failure_count' => 1,
                'action_after_failures' => 'fail'
            ])
        ];

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(403);

        $this->createClientAndUpload($payload, null, $headers);
    }
}
