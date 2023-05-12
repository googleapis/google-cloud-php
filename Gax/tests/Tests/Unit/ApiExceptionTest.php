<?php
/*
 * Copyright 2016 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\ApiException;
use Google\Protobuf\Any;
use Google\Protobuf\Duration;
use Google\Rpc\BadRequest;
use Google\Rpc\Code;
use Google\Rpc\DebugInfo;
use Google\Rpc\ErrorInfo;
use Google\Rpc\Help;
use Google\Rpc\LocalizedMessage;
use Google\Rpc\QuotaFailure;
use Google\Rpc\RequestInfo;
use Google\Rpc\ResourceInfo;
use Google\Rpc\RetryInfo;
use Google\Rpc\Status;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiExceptionTest extends TestCase
{
    public function testWithoutMetadata()
    {
        $status = new \stdClass();
        $status->code = Code::OK;
        $status->details = 'testWithoutMetadata';

        $apiException = ApiException::createFromStdClass($status);

        $expectedMessage = json_encode([
            'message' => 'testWithoutMetadata',
            'code' => Code::OK,
            'status' => 'OK',
            'details' => []
        ], JSON_PRETTY_PRINT);

        $this->assertSame(Code::OK, $apiException->getCode());
        $this->assertSame($expectedMessage, $apiException->getMessage());
        $this->assertNull($apiException->getMetadata());
    }

    /**
     * @dataProvider getMetadata
     */
    public function testWithMetadataWithoutErrorInfo($metadata, $metadataArray)
    {
        $status = new \stdClass();
        $status->code = Code::OK;
        $status->details = 'testWithMetadata';
        $status->metadata = $metadata;

        $apiException = ApiException::createFromStdClass($status);

        $expectedMessageWithoutErrorDetails = json_encode([
            'message' => 'testWithMetadata',
            'code' => Code::OK,
            'status' => 'OK',
            'details' => $metadataArray
        ], JSON_PRETTY_PRINT);

        $this->assertSame(Code::OK, $apiException->getCode());
        $this->assertSame($expectedMessageWithoutErrorDetails, $apiException->getMessage());
        $this->assertSame($metadata, $apiException->getMetadata());
    }

    /**
     * Test without ErrorInfo in Metadata
     * @dataProvider getMetadata
     */
    public function testCreateFromApiResponse($metadata, $metadataArray)
    {
        $basicMessage = 'testWithMetadata';
        $code = Code::OK;
        $status = 'OK';

        $apiException = ApiException::createFromApiResponse($basicMessage, $code, $metadata);

        $expectedMessage = json_encode([
            'message' => $basicMessage,
            'code' => $code,
            'status' => $status,
            'details' => $metadataArray
        ], JSON_PRETTY_PRINT);

        $this->assertSame(Code::OK, $apiException->getCode());
        $this->assertSame($expectedMessage, $apiException->getMessage());
        $this->assertSame($metadata, $apiException->getMetadata());
    }

    public function getMetadata()
    {
        $retryInfo = new RetryInfo();
        $duration = new Duration();
        $duration->setSeconds(1);
        $duration->setNanos(2);
        $retryInfo->setRetryDelay($duration);

        $unknownBinData = [
            [
                '@type' => 'unknown-bin',
                'data' => '<Unknown Binary Data>'
            ]
        ];
        $asciiData = [
            [
                '@type' => 'ascii',
                'data' => 'ascii-data'
            ]
        ];
        $retryInfoData = [
            [
                '@type' => 'google.rpc.retryinfo-bin',
                'retryDelay' => [
                    'seconds' => 1,
                    'nanos' => 2,
                ],
            ]
        ];
        $allKnownTypesData = [
            [
                '@type' => 'google.rpc.retryinfo-bin',
            ],
            [
                '@type' => 'google.rpc.debuginfo-bin',
                "stackEntries" => [],
                "detail" => ""
            ],
            [
                '@type' => 'google.rpc.quotafailure-bin',
                'violations' => [],
            ],
            [
                '@type' => 'google.rpc.badrequest-bin',
                'fieldViolations' => []
            ],
            [
                '@type' => 'google.rpc.requestinfo-bin',
                'requestId' => '',
                'servingData' => '',
            ],
            [
                '@type' => 'google.rpc.resourceinfo-bin',
                'resourceType' => '',
                'resourceName' => '',
                'owner' => '',
                'description' => '',
            ],
            [
                '@type' => 'google.rpc.help-bin',
                'links' => [],
            ],
            [
                '@type' => 'google.rpc.localizedmessage-bin',
                'locale' => '',
                'message' => '',
            ],
        ];
        return [
            [['unknown-bin' => ['some-data-that-should-not-appear']], $unknownBinData],
            [['ascii' => ['ascii-data']], $asciiData],
            [['google.rpc.retryinfo-bin' => [$retryInfo->serializeToString()]], $retryInfoData],
            [[
                'google.rpc.retryinfo-bin' => [(new RetryInfo())->serializeToString()],
                'google.rpc.debuginfo-bin' => [(new DebugInfo())->serializeToString()],
                'google.rpc.quotafailure-bin' => [(new QuotaFailure())->serializeToString()],
                'google.rpc.badrequest-bin' => [(new BadRequest())->serializeToString()],
                'google.rpc.requestinfo-bin' => [(new RequestInfo())->serializeToString()],
                'google.rpc.resourceinfo-bin' => [(new ResourceInfo())->serializeToString()],
                'google.rpc.help-bin' => [(new Help())->serializeToString()],
                'google.rpc.localizedmessage-bin' => [(new LocalizedMessage())->serializeToString()],
            ], $allKnownTypesData],
        ];
    }

    /**
     * @dataProvider getMetadataWithErrorInfo
     */
    public function testWithMetadataWithErrorInfo($metadata, $metadataArray)
    {
        $status = new \stdClass();
        $status->code = Code::OK;
        $status->details = 'testWithMetadataWithErrorInfo';
        $status->metadata = $metadata;

        $apiException = ApiException::createFromStdClass($status);

        $expectedMessage = json_encode(
            [
            'reason' => '',
            'domain' => '',
            'errorInfoMetadata' => [],
            'message' => 'testWithMetadataWithErrorInfo',
            'code' => Code::OK,
            'status' => 'OK',
            'details' => $metadataArray,
        ],
            JSON_PRETTY_PRINT
        );

        $this->assertSame(Code::OK, $apiException->getCode());
        $this->assertSame($expectedMessage, $apiException->getMessage());
        $this->assertSame($metadata, $apiException->getMetadata());
    }

    /**
    * Test with ErrorInfo in Metadata
    * @dataProvider getMetadataWithErrorInfo
    */
    public function testCreateFromApiResponseWithErrorInfo($metadata, $metadataArray)
    {
        $basicMessage = 'testWithMetadataWithErrorInfo';
        $code = Code::OK;
        $status = 'OK';

        $apiException = ApiException::createFromApiResponse($basicMessage, $code, $metadata);

        $expectedMessage = json_encode([
            'reason' => '',
            'domain' => '',
            'errorInfoMetadata' => [],
            'message' => $basicMessage,
            'code' => $code,
            'status' => $status,
            'details' => $metadataArray,
        ], JSON_PRETTY_PRINT);

        $this->assertSame(Code::OK, $apiException->getCode());
        $this->assertSame($expectedMessage, $apiException->getMessage());
        $this->assertSame($metadata, $apiException->getMetadata());
        $this->assertSame('', $apiException->getReason());
        $this->assertSame('', $apiException->getDomain());
        $this->assertSame([], $apiException->getErrorInfoMetadata());
    }

    public function getMetadataWithErrorInfo()
    {
        $allKnownTypesData = [
            [
                '@type' => 'google.rpc.retryinfo-bin',
            ],
            [
                '@type' => 'google.rpc.debuginfo-bin',
                "stackEntries" => [],
                "detail" => ""
            ],
            [
                '@type' => 'google.rpc.quotafailure-bin',
                'violations' => [],
            ],
            [
                '@type' => 'google.rpc.badrequest-bin',
                'fieldViolations' => []
            ],
            [
                '@type' => 'google.rpc.requestinfo-bin',
                'requestId' => '',
                'servingData' => '',
            ],
            [
                '@type' => 'google.rpc.resourceinfo-bin',
                'resourceType' => '',
                'resourceName' => '',
                'owner' => '',
                'description' => '',
            ],
            [
                '@type' => 'google.rpc.errorinfo-bin',
                'reason' => '',
                'domain' => '',
                'metadata' => [],
            ],
            [
                '@type' => 'google.rpc.help-bin',
                'links' => [],
            ],
            [
                '@type' => 'google.rpc.localizedmessage-bin',
                'locale' => '',
                'message' => '',
            ],
        ];
        return [
            [[
                'google.rpc.retryinfo-bin' => [(new RetryInfo())->serializeToString()],
                'google.rpc.debuginfo-bin' => [(new DebugInfo())->serializeToString()],
                'google.rpc.quotafailure-bin' => [(new QuotaFailure())->serializeToString()],
                'google.rpc.badrequest-bin' => [(new BadRequest())->serializeToString()],
                'google.rpc.requestinfo-bin' => [(new RequestInfo())->serializeToString()],
                'google.rpc.resourceinfo-bin' => [(new ResourceInfo())->serializeToString()],
                'google.rpc.errorinfo-bin' => [(new ErrorInfo())->serializeToString()],
                'google.rpc.help-bin' => [(new Help())->serializeToString()],
                'google.rpc.localizedmessage-bin' => [(new LocalizedMessage())->serializeToString()],
            ], $allKnownTypesData],
        ];
    }

    /**
     * @dataProvider getRestMetadata
     */
    public function testCreateFromRestApiResponse($metadata)
    {
        $basicMessage = 'testWithRestMetadata';
        $code = Code::OK;
        $status = 'OK';

        $apiException = ApiException::createFromRestApiResponse($basicMessage, $code, $metadata);

        $expectedMessage = json_encode([
            'message' => $basicMessage,
            'code' => $code,
            'status' => $status,
            'details' => $metadata
        ], JSON_PRETTY_PRINT);

        $this->assertSame($expectedMessage, $apiException->getMessage());
        $this->assertSame(null, $apiException->getReason());
        $this->assertSame(null, $apiException->getDomain());
        $this->assertSame(null, $apiException->getErrorInfoMetadata());
    }

    public function getRestMetadata()
    {
        $unknownBinData = [
            [
                '@type' => 'unknown-bin',
                'data' => '<Unknown Binary Data>'
            ]
        ];
        $asciiData = [
            [
                '@type' => 'ascii',
                'data' => 'ascii-data'
            ]
        ];
        $retryInfoData = [
            [
                '@type' => 'google.rpc.retryinfo-bin',
                'retryDelay' => [
                    'seconds' => 1,
                    'nanos' => 2,
                ],
            ]
        ];
        $allKnownTypesData = [
            [
                '@type' => 'google.rpc.retryinfo-bin',
            ],
            [
                '@type' => 'google.rpc.debuginfo-bin',
                "stackEntries" => [],
                "detail" => ""
            ],
            [
                '@type' => 'google.rpc.quotafailure-bin',
                'violations' => [],
            ],
            [
                '@type' => 'google.rpc.badrequest-bin',
                'fieldViolations' => []
            ],
            [
                '@type' => 'google.rpc.requestinfo-bin',
                'requestId' => '',
                'servingData' => '',
            ],
            [
                '@type' => 'google.rpc.resourceinfo-bin',
                'resourceType' => '',
                'resourceName' => '',
                'owner' => '',
                'description' => '',
            ],
            [
                '@type' => 'google.rpc.help-bin',
                'links' => [],
            ],
            [
                '@type' => 'google.rpc.localizedmessage-bin',
                'locale' => '',
                'message' => '',
            ],
        ];

        return [
            [
                [[]],
                [[null]],
                [$unknownBinData],
                [$asciiData],
                [$retryInfoData],
                [$allKnownTypesData]
            ]
        ];
    }

    /**
     * @dataProvider getRestMetadataWithErrorInfo
     */
    public function testCreateFromRestApiResponseWithErrorInfo($metadata)
    {
        $basicMessage = 'testWithRestMetadataWithErrorInfo';
        $code = Code::OK;
        $status = 'OK';

        $apiException = ApiException::createFromRestApiResponse($basicMessage, $code, $metadata);

        $expectedMessage = json_encode([
            'reason' => '',
            'domain' => '',
            'errorInfoMetadata' => [],
            'message' => $basicMessage,
            'code' => $code,
            'status' => $status,
            'details' => $metadata
        ], JSON_PRETTY_PRINT);

        $this->assertSame($expectedMessage, $apiException->getMessage());
        $this->assertSame('', $apiException->getReason());
        $this->assertSame('', $apiException->getDomain());
        $this->assertSame([], $apiException->getErrorInfoMetadata());
    }

    public function getRestMetadataWithErrorInfo()
    {
        $allKnownTypesData = [
            [
                '@type' => 'google.rpc.retryinfo-bin',
            ],
            [
                '@type' => 'google.rpc.debuginfo-bin',
                "stackEntries" => [],
                "detail" => ""
            ],
            [
                '@type' => 'google.rpc.quotafailure-bin',
                'violations' => [],
            ],
            [
                '@type' => 'google.rpc.badrequest-bin',
                'fieldViolations' => []
            ],
            [
                '@type' => 'google.rpc.requestinfo-bin',
                'requestId' => '',
                'servingData' => '',
            ],
            [
                '@type' => 'google.rpc.resourceinfo-bin',
                'resourceType' => '',
                'resourceName' => '',
                'owner' => '',
                'description' => '',
            ],
            [
                '@type' => 'google.rpc.help-bin',
                'links' => [],
            ],
            [
                '@type' => 'google.rpc.localizedmessage-bin',
                'locale' => '',
                'message' => '',
            ],
            [
                '@type' => 'google.rpc.errorinfo-bin',
                'reason' => '',
                'domain' => '',
                'metadata' => [],
            ],
        ];

        return [
                [$allKnownTypesData]
        ];
    }

    /**
     * Test without ErrorInfo
     * @dataProvider getRpcStatusData
     */
    public function testCreateFromRpcStatus($status, $expectedApiException)
    {
        $actualApiException = ApiException::createFromRpcStatus($status);
        $this->assertEquals($expectedApiException, $actualApiException);
        $this->assertEquals(null, $actualApiException->getReason());
        $this->assertSame(null, $actualApiException->getDomain());
        $this->assertSame(null, $actualApiException->getErrorInfoMetadata());
    }

    public function getRpcStatusData()
    {
        $debugInfo = new DebugInfo();
        $debugInfo->setDetail("debug detail");
        $any = new Any();
        $any->pack($debugInfo);

        $status = new Status();
        $status->setMessage("status string");
        $status->setCode(Code::OK);
        $status->setDetails([$any]);

        $expectedMessage = json_encode([
            'message' => $status->getMessage(),
            'code' => $status->getCode(),
            'status' => 'OK',
            'details' => [
                [
                    'stackEntries' => [],
                    'detail' => 'debug detail',
                ]
            ],
        ], JSON_PRETTY_PRINT);

        return [
            [
                $status,
                new ApiException(
                    $expectedMessage,
                    Code::OK,
                    'OK',
                    [
                        'metadata' => [$any],
                        'basicMessage' => $status->getMessage(),
                    ]
                )
            ]
        ];
    }

    /**
     * Test with ErrorInfo
     * @dataProvider getRpcStatusDataWithErrorInfo
     */
    public function testCreateFromRpcStatusWithErrorInfo($status, $expectedApiException)
    {
        $actualApiException = ApiException::createFromRpcStatus($status);
        $this->assertEquals($expectedApiException, $actualApiException);
        $this->assertSame('SERVICE_DISABLED', $actualApiException->getReason());
        $this->assertSame('googleapis.com', $actualApiException->getDomain());
        $this->assertSame([], $actualApiException->getErrorInfoMetadata());
    }

    public function getRpcStatusDataWithErrorInfo()
    {
        $errorInfo = new ErrorInfo();
        $errorInfo->setDomain('googleapis.com');
        $errorInfo->setReason('SERVICE_DISABLED');
        $any = new Any();
        $any->pack($errorInfo);

        $status = new Status();
        $status->setMessage("status string");
        $status->setCode(Code::OK);
        $status->setDetails([$any]);

        $expectedMessage = json_encode([
            'reason' => $errorInfo->getReason(),
            'domain' => $errorInfo->getDomain(),
            'errorInfoMetadata' => [],
            'message' => $status->getMessage(),
            'code' => $status->getCode(),
            'status' => 'OK',
            'details' => [
                [
                    'reason' => 'SERVICE_DISABLED',
                    'domain' => 'googleapis.com',
                    'metadata' => []],
                ]
        ], JSON_PRETTY_PRINT);

        return [
            [
                $status,
                new ApiException(
                    $expectedMessage,
                    Code::OK,
                    'OK',
                    [
                        'metadata' => [$any],
                        'basicMessage' => $status->getMessage(),
                    ]
                )
            ]
        ];
    }

    /**
     * @dataProvider buildRequestExceptions
     */
    public function testCreateFromRequestException($re, $stream, $expectedCode)
    {
        $ae = ApiException::createFromRequestException($re, $stream);
        $this->assertSame($expectedCode, $ae->getCode());
    }

    public function buildRequestExceptions()
    {
        $error = [
            'error' => [
                'status' => 'NOT_FOUND',
                'message' => 'Ruh-roh.',
            ]
        ];
        $stream = RequestException::create(
            new Request('POST', 'http://www.example.com'),
            new Response(
                404,
                [],
                json_encode([$error])
            )
        );
        $unary = RequestException::create(
            new Request('POST', 'http://www.example.com'),
            new Response(
                404,
                [],
                json_encode($error)
            )
        );
        unset($error['error']['message']);
        $withoutErrorMessageStream = RequestException::create(
            new Request('POST', 'http://www.example.com'),
            new Response(
                404,
                [],
                json_encode([$error])
            )
        );
        $withoutErrorMessageUnary = RequestException::create(
            new Request('POST', 'http://www.example.com'),
            new Response(
                404,
                [],
                json_encode($error)
            )
        );
        return [
            [$stream, true, Code::NOT_FOUND],
            [$unary, false, Code::NOT_FOUND],
            [$withoutErrorMessageStream, true, Code::NOT_FOUND],
            [$withoutErrorMessageUnary, true, Code::NOT_FOUND]
        ];
    }
}
