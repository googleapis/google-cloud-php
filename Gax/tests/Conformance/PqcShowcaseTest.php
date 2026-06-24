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

declare(strict_types=1);

namespace Google\Generator\Tests\Conformance;

use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\RequestBuilder;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Showcase\V1beta1\Client\EchoClient;
use Google\Showcase\V1beta1\EchoRequest;
use Grpc\ChannelCredentials;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PqcShowcaseTest extends TestCase
{
    private const TLS_GROUP = 'x-showcase-tls-group';
    private const TLS_VERSION = 'x-showcase-tls-version';

    public function provideTransport(): array
    {
        $pemPath = __DIR__ . '/showcase.pem';
        $host = 'localhost:7469';

        // gRPC Configuration
        $pemContents = file_get_contents($pemPath);
        if (!$pemContents) {
            $this->fail('Could not read showcase.pem');
        }

        $grpcTransport = GrpcTransport::build($host, [
            'stubOpts' => [
                'credentials' => ChannelCredentials::createSsl($pemContents)
            ]
        ]);

        // REST Configuration
        $restConfigPath = __DIR__ . '/src/V1beta1/resources/echo_rest_client_config.php';

        $requestBuilder = new RequestBuilder($host, $restConfigPath);
        $guzzleClient = new Client([
            'verify' => $pemPath
        ]);
        $httpHandler = HttpHandlerFactory::build($guzzleClient);
        $restTransport = new RestTransport($requestBuilder, [$httpHandler, 'async']);

        return [[$grpcTransport], [$restTransport]];
    }

    /** @dataProvider provideTransport */
    public function testPqc(TransportInterface $transport): void
    {
        $expected = 'This is a test';
        $expectedGroup = 'X25519MLKEM768';
        $expectedVersion = 'TLS 1.3';
        $responseHeaders = null;
        $metadataCallback = function (array $metadata) use (&$responseHeaders) {
            $responseHeaders = $metadata;
        };

        $echoClient = new EchoClient([
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport
        ]);

        $echoRequest = new EchoRequest();
        $echoRequest->setContent($expected);
        $response = $echoClient->echo($echoRequest, [
            'metadataCallback' => $metadataCallback
        ]);

        $this->assertEquals($expected, $response->getContent());
        $this->assertNotNull($responseHeaders);

        /** @var array<string, array<int, string>> $responseHeaders */
        $responseHeaders = array_change_key_case($responseHeaders, CASE_LOWER);

        $this->assertEquals($expectedVersion, $responseHeaders[self::TLS_VERSION][0]);
        $this->assertEquals($expectedGroup, $responseHeaders[self::TLS_GROUP][0]);
    }
}
