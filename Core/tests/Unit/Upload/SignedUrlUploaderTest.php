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

namespace Google\Cloud\Core\Tests\Unit\Upload;

use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\GetQuotaProjectInterface;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 * @group upload
 */
class SignedUrlUploaderTest extends TestCase
{
    use ProphecyTrait;

    private $requestWrapper;
    private $stream;
    private $successBody;

    public function setUp(): void
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->stream = Utils::streamFor('abcd');
        $this->successBody = '{"canI":"kickIt"}';
    }

    public function testGetResumeUri()
    {
        $resumeUri = 'http://www.example.com/upload?upload_id=123';
        $response = new Response(200, ['Location' => $resumeUri]);

        $this->requestWrapper->send(
            Argument::that(function ($arg) {
                if (!($arg instanceof RequestInterface)) {
                    return false;
                }

                if ($arg->getHeaderLine('Content-Type') !== 'application/octet-stream') {
                    return false;
                }

                if ($arg->getHeader('Content-Length') !== ['0']) {
                    return false;
                }

                if ($arg->getHeaderLine('x-goog-resumable') !== 'start') {
                    return false;
                }

                return true;
            }),
            Argument::withEntry('shouldSignRequest', false)
        )->willReturn($response)->shouldBeCalledOnce();

        $uploader = new SignedUrlUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertSame($resumeUri, $uploader->getResumeUri());
    }

    public function testUploadDoesNotSendOAuthTokenOrQuotaProjectHeaders()
    {
        $credentialsFetcher = $this->prophesize(FetchAuthTokenInterface::class);
        $credentialsFetcher->willImplement(GetQuotaProjectInterface::class);
        $credentialsFetcher->fetchAuthToken(Argument::any())->shouldNotBeCalled();
        $credentialsFetcher->getQuotaProject()->shouldNotBeCalled();

        $signedUri = 'https://example.invalid/signed-upload?X-Goog-Signature=secret-sig';
        $sessionUri = 'https://example.invalid/signed-upload?upload_id=session-123';
        $sentRequests = [];

        $requestWrapper = new RequestWrapper([
            'credentialsFetcher' => $credentialsFetcher->reveal(),
            'quotaProject' => 'secret-quota-project',
            'httpHandler' => function (RequestInterface $request) use (&$sentRequests, $sessionUri) {
                $sentRequests[] = $request;
                if ($request->getMethod() === 'POST') {
                    return new Response(200, ['Location' => $sessionUri]);
                }

                return new Response(200, [], $this->successBody);
            },
        ]);

        $uploader = new SignedUrlUploader(
            $requestWrapper,
            $this->stream,
            $signedUri,
            ['shouldSignRequest' => true]
        );

        $this->assertSame($this->successBody, (string) $uploader->upload());
        $this->assertCount(2, $sentRequests);
        $this->assertSame('POST', $sentRequests[0]->getMethod());
        $this->assertSame($signedUri, (string) $sentRequests[0]->getUri());
        $this->assertSame('PUT', $sentRequests[1]->getMethod());
        $this->assertSame($sessionUri, (string) $sentRequests[1]->getUri());

        foreach ($sentRequests as $request) {
            $this->assertFalse($request->hasHeader('Authorization'));
            $this->assertFalse($request->hasHeader('X-Goog-User-Project'));
        }
    }

    /**
     * @dataProvider validLocationProvider
     */
    public function testCreateResumeUriAllowsMatchingLocationOrigin(
        string $signedUri,
        string $locationHeader,
        string $expectedResumeUri
    ) {
        $this->requestWrapper->send(
            Argument::that(function (RequestInterface $request) {
                return $request->getMethod() === 'POST';
            }),
            Argument::withEntry('shouldSignRequest', false)
        )->willReturn(new Response(200, ['Location' => $locationHeader]))->shouldBeCalledOnce();

        $uploader = new SignedUrlUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            $signedUri
        );

        $this->assertSame($expectedResumeUri, $uploader->getResumeUri());
    }

    public function validLocationProvider()
    {
        $defaultSignedUri = 'https://storage.googleapis.com/my-bucket/obj.bin?X-Goog-Signature=sig';

        return [
            'exact match preserving gcs upload_id chars' => [
                $defaultSignedUri,
                'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=ADPycd-1_2+3%2F4=',
                'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=ADPycd-1_2+3%2F4=',
            ],
            'case-insensitive scheme and host' => [
                $defaultSignedUri,
                'HTTPS://STORAGE.GOOGLEAPIS.COM/my-bucket/obj.bin?upload_id=123',
                'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
            ],
            'explicit default https port' => [
                $defaultSignedUri,
                'https://storage.googleapis.com:443/my-bucket/obj.bin?upload_id=123',
                'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
            ],
            'omitted default https port' => [
                'https://storage.googleapis.com:443/my-bucket/obj.bin?X-Goog-Signature=sig',
                'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
                'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
            ],
            'http emulator signed url' => [
                'http://localhost:4443/my-bucket/obj.bin?X-Goog-Signature=sig',
                'http://localhost:4443/my-bucket/obj.bin?upload_id=123',
                'http://localhost:4443/my-bucket/obj.bin?upload_id=123',
            ],
            'ipv6 emulator signed url' => [
                'http://[::1]:4443/my-bucket/obj.bin?X-Goog-Signature=sig',
                'http://[::1]:4443/my-bucket/obj.bin?upload_id=123',
                'http://[::1]:4443/my-bucket/obj.bin?upload_id=123',
            ],
        ];
    }

    /**
     * @dataProvider invalidLocationProvider
     */
    public function testUploadRejectsInvalidOrMismatchedLocationHeader(
        string $signedUri,
        string $locationHeader,
        string $expectedMessage
    ) {
        $headers = $locationHeader === '' ? [] : ['Location' => $locationHeader];

        // Only the initial POST should execute; PUT must never be dispatched.
        $this->requestWrapper->send(
            Argument::that(function (RequestInterface $request) {
                return $request->getMethod() === 'POST';
            }),
            Argument::withEntry('shouldSignRequest', false)
        )->willReturn(new Response(200, $headers))->shouldBeCalledOnce();

        $uploader = new SignedUrlUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            $signedUri
        );

        try {
            $uploader->upload();
            $this->fail('Expected GoogleException was not thrown.');
        } catch (GoogleException $e) {
            $this->assertSame($expectedMessage, $e->getMessage());
            $this->assertNull($e->getPrevious());
        }
    }

    public function testCreateResumeUriDoesNotMutateResumeUriOnValidationFailure()
    {
        $validResumeUri = 'https://storage.googleapis.com/my-bucket/obj.bin?upload_id=valid';
        $attempt = 0;

        $this->requestWrapper->send(
            Argument::that(function (RequestInterface $request) {
                return $request->getMethod() === 'POST';
            }),
            Argument::withEntry('shouldSignRequest', false)
        )->will(function () use (&$attempt, $validResumeUri) {
            if ($attempt++ === 0) {
                return new Response(200, ['Location' => 'https://example.invalid/steal']);
            }

            return new Response(200, ['Location' => $validResumeUri]);
        })->shouldBeCalledTimes(2);

        $uploader = new SignedUrlUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'https://storage.googleapis.com/my-bucket/obj.bin?X-Goog-Signature=sig'
        );

        try {
            $uploader->getResumeUri();
            $this->fail('Expected GoogleException was not thrown.');
        } catch (GoogleException $e) {
            $this->assertNull($e->getPrevious());
        }

        $this->assertSame($validResumeUri, $uploader->getResumeUri());
    }

    public function invalidLocationProvider()
    {
        $defaultSignedUri = 'https://storage.googleapis.com/my-bucket/obj.bin?X-Goog-Signature=secret-sig';
        $defaultOriginMsg = 'Resume Location URI origin does not match the configured upload endpoint origin '
            . '(https://storage.googleapis.com).';

        return [
            'missing location header' => [
                $defaultSignedUri,
                '',
                'Resume Location URI must be a non-empty string or UriInterface.',
            ],
            'different host' => [
                $defaultSignedUri,
                'https://example.invalid/upload-session?upload_id=secret-token',
                $defaultOriginMsg,
            ],
            'https to http downgrade' => [
                $defaultSignedUri,
                'http://storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
                $defaultOriginMsg,
            ],
            'different port' => [
                $defaultSignedUri,
                'https://storage.googleapis.com:8443/my-bucket/obj.bin?upload_id=123',
                $defaultOriginMsg,
            ],
            'missing custom port' => [
                'http://localhost:4443/my-bucket/obj.bin?X-Goog-Signature=secret-sig',
                'http://localhost/my-bucket/obj.bin?upload_id=123',
                'Resume Location URI origin does not match the configured upload endpoint origin '
                    . '(http://localhost:4443).',
            ],
            'subdomain suffix spoof' => [
                $defaultSignedUri,
                'https://storage.googleapis.com.evil.com/my-bucket/obj.bin?upload_id=123',
                $defaultOriginMsg,
            ],
            'trailing dot host' => [
                $defaultSignedUri,
                'https://storage.googleapis.com./my-bucket/obj.bin?upload_id=123',
                $defaultOriginMsg,
            ],
            'userinfo host confusion' => [
                $defaultSignedUri,
                'https://storage.googleapis.com@example.invalid/upload-session',
                $defaultOriginMsg,
            ],
            'unexpected userinfo' => [
                $defaultSignedUri,
                'https://user:secret@storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
                'Resume Location URI userinfo does not match the configured upload endpoint.',
            ],
            'backslash userinfo parser differential' => [
                $defaultSignedUri,
                'https://example.invalid\\@storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
                'Resume Location URI userinfo does not match the configured upload endpoint.',
            ],
            'relative location' => [
                $defaultSignedUri,
                '/my-bucket/obj.bin?upload_id=123',
                'Resume Location URI must include a valid HTTP(S) scheme and host.',
            ],
            'protocol-relative location' => [
                $defaultSignedUri,
                '//storage.googleapis.com/my-bucket/obj.bin?upload_id=123',
                'Resume Location URI must include a valid HTTP(S) scheme and host.',
            ],
            'non-http scheme' => [
                $defaultSignedUri,
                'file://storage.googleapis.com/etc/passwd',
                'Resume Location URI must include a valid HTTP(S) scheme and host.',
            ],
            'space in scheme' => [
                $defaultSignedUri,
                'http secret://storage.googleapis.com/upload',
                'Resume Location URI must include a valid HTTP(S) scheme and host.',
            ],
            'malformed location redacts secrets' => [
                $defaultSignedUri,
                'https://user:secret@:443/upload?upload_id=secret-token&X-Goog-Signature=secret-sig',
                'Resume Location URI is not a valid URI.',
            ],
        ];
    }

    /**
     * @dataProvider invalidConfiguredUriProvider
     */
    public function testCreateResumeUriRejectsInvalidConfiguredUri($configuredUri, string $expectedMessage)
    {
        $this->requestWrapper->send(
            Argument::any(),
            Argument::any()
        )->shouldNotBeCalled();

        $uploader = new SignedUrlUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            $configuredUri
        );

        try {
            $uploader->getResumeUri();
            $this->fail('Expected InvalidArgumentException was not thrown.');
        } catch (InvalidArgumentException $e) {
            $this->assertSame($expectedMessage, $e->getMessage());
            $this->assertNull($e->getPrevious());
        }
    }

    public function invalidConfiguredUriProvider()
    {
        return [
            'empty string' => [
                '',
                'Configured upload endpoint must be a non-empty string or UriInterface.',
            ],
            'null' => [
                null,
                'Configured upload endpoint must be a non-empty string or UriInterface.',
            ],
            'relative path' => [
                '/my-bucket/obj.bin',
                'Configured upload endpoint must include a valid HTTP(S) scheme and host.',
            ],
            'non-http scheme' => [
                'file://storage.googleapis.com/my-bucket/obj.bin',
                'Configured upload endpoint must include a valid HTTP(S) scheme and host.',
            ],
            'control characters' => [
                "https://storage.googleapis.com/obj.bin\r\nX-Injected: 1",
                'Configured upload endpoint must not contain control characters.',
            ],
            'malformed uri redacts signature' => [
                'https://:443/my-bucket/obj.bin?X-Goog-Signature=secret-sig',
                'Configured upload endpoint is not a valid URI.',
            ],
        ];
    }
}
