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

namespace Google\Cloud\Tests\Unit\Storage\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Rize\UriTemplate;

/**
 * @group storage
 */
class RestTest extends \PHPUnit_Framework_TestCase
{
    private $requestWrapper;
    private $successBody;

    public function setUp()
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->successBody = '{"canI":"kickIt"}';
    }

    /**
     * @dataProvider methodProvider
     * @todo revisit this approach
     */
    public function testCallBasicMethods($method)
    {
        $options = [];
        $request = new Request('GET', '/somewhere');
        $response = new Response(200, [], $this->successBody);

        $requestBuilder = $this->prophesize(RequestBuilder::class);
        $requestBuilder->build(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('array')
        )->willReturn($request);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $rest = new Rest();
        $rest->setRequestBuilder($requestBuilder->reveal());
        $rest->setRequestWrapper($this->requestWrapper->reveal());

        if (substr($method, -3) == 'Acl') {
            $options = ['type' => 'bucketAccessControls'];
        }

        $this->assertEquals(json_decode($this->successBody, true), $rest->$method($options));
    }

    public function methodProvider()
    {
        return [
            ['deleteAcl'],
            ['getAcl'],
            ['listAcl'],
            ['insertAcl'],
            ['patchAcl'],
            ['deleteBucket'],
            ['getBucket'],
            ['listBuckets'],
            ['insertBucket'],
            ['patchBucket'],
            ['copyObject'],
            ['deleteObject'],
            ['getObject'],
            ['listObjects'],
            ['patchObject'],
            ['rewriteObject'],
            ['composeObject'],
            ['getBucketIamPolicy'],
            ['setBucketIamPolicy'],
            ['testBucketIamPermissions'],
        ];
    }

    public function testDownloadObject()
    {
        $actualRequest = null;
        $response = new Response(200, [], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(
            function ($args) use (&$actualRequest, $response) {
                $actualRequest = $args[0];
                return $response;
            }
        );

        $rest = new Rest();
        $rest->setRequestWrapper($this->requestWrapper->reveal());

        $actualBody = $rest->downloadObject([
            'bucket' => 'bigbucket',
            'object' => 'myfile.txt',
            'generation' => 100,
            'restOptions' => ['debug' => true],
            'retries' => 0
        ]);

        $actualUri = (string) $actualRequest->getUri();

        $this->assertEquals($this->successBody, $actualBody);
        $this->assertEquals(
            'https://storage.googleapis.com/bigbucket/myfile.txt?generation=100&alt=media',
            $actualUri
        );
    }

    /**
     * @dataProvider insertObjectProvider
     */
    public function testInsertObject(
        array $options,
        $expectedUploaderType,
        $expectedContentType,
        array $expectedMetadata
    ) {
        $actualRequest = null;
        $response = new Response(200, ['Location' => 'http://www.mordor.com'], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->will(
            function ($args) use (&$actualRequest, $response) {
                $request = $args[0];
                if ($request->getMethod() === 'POST') {
                    $actualRequest = $request;
                }

                return $response;
            }
        );

        $rest = new Rest();
        $rest->setRequestWrapper($this->requestWrapper->reveal());
        $uploader = $rest->insertObject($options);
        $uploader->upload();
        list($contentType, $metadata) = $this->getContentTypeAndMetadata($actualRequest);

        $this->assertInstanceOf($expectedUploaderType, $uploader);
        $this->assertEquals($expectedContentType, $contentType);

        foreach ($expectedMetadata as $key => $value) {
            $this->assertEquals($value, $metadata[$key]);
        }
    }

    public function insertObjectProvider()
    {
        $tempFile = Psr7\stream_for(fopen('php://temp', 'r+'));
        $tempFile->write(str_repeat('0', 5000001));
        $logoFile = Psr7\stream_for(fopen(__DIR__ . '../../../data/logo.svg', 'r'));

        return [
            [
                [
                    'data' => $tempFile,
                    'name' => 'file.txt',
                    'predefinedAcl' => 'private',
                    'metadata' => ['contentType' => 'text/plain']
                ],
                ResumableUploader::class,
                'text/plain',
                [
                    'md5Hash' => base64_encode(Psr7\hash($tempFile, 'md5', true)),
                    'name' => 'file.txt'
                ]
            ],
            [
                [
                    'data' => $logoFile,
                    'validate' => false
                ],
                MultipartUploader::class,
                'image/svg+xml',
                [
                    'name' => 'logo.svg'
                ]
            ],
            [
                [
                    'data' => 'abcdefg',
                    'name' => 'file.ext',
                    'resumable' => true,
                    'validate' => false,
                    'metadata' => [
                        'contentType' => 'text/plain',
                        'metadata' => [
                            'here' => 'wego'
                        ]
                    ]
                ],
                ResumableUploader::class,
                'text/plain',
                [
                    'name' => 'file.ext',
                    'metadata' => [
                        'here' => 'wego'
                    ]
                ]
            ],
            [
                [
                    'data' => 'abcdefg',
                    'name' => 'file.ext',
                    'streamable' => true,
                    'validate' => false,
                    'metadata' => [
                        'contentType' => 'text/plain',
                        'metadata' => [
                            'here' => 'wego'
                        ]
                    ]
                ],
                StreamableUploader::class,
                'text/plain',
                [
                    'name' => 'file.ext',
                    'metadata' => [
                        'here' => 'wego'
                    ]
                ]
            ]
        ];
    }

    private function getContentTypeAndMetadata(RequestInterface $request)
    {
        // Resumable upload request
        if ($request->getHeaderLine('X-Upload-Content-Type')) {
            return [
                $request->getHeaderLine('X-Upload-Content-Type'),
                json_decode($request->getBody(), true)
            ];
        }

        // Multipart upload request
        $lines = explode(PHP_EOL, (string) $request->getBody());
        return [
            trim(explode(':', $lines[7])[1]),
            json_decode($lines[5], true)
        ];
    }
}
