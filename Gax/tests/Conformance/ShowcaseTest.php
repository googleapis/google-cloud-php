<?php
/*
 * Copyright 2021 Google LLC
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

use PHPUnit\Framework\TestCase;
use Google\ApiCore\ApiException;
use Google\ApiCore\KnownTypes;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\InsecureRequestBuilder;
use Google\ApiCore\RequestBuilder;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\Transport\RestTransport;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Protobuf\Internal\Message;
use Google\Showcase\V1beta1\Client\EchoClient;
use Google\Showcase\V1beta1\EchoRequest;
use Google\Showcase\V1beta1\FailEchoWithDetailsRequest;
use Grpc\ChannelCredentials;
use GuzzleHttp\Client;

final class ShowcaseTest extends TestCase
{
    private const TLS_GROUP = 'x-showcase-tls-group';
    private const PEM_PATH = __DIR__ . '/showcase.pem';

    public function provideTransport()
    {
        $host = 'localhost:7469';
        $restConfigPath = __DIR__ . '/src/V1beta1/resources/echo_rest_client_config.php';

        if (file_exists(self::PEM_PATH)) {
            $pemContents = file_get_contents(self::PEM_PATH);
            $grpcCredentials = ChannelCredentials::createSsl($pemContents);
            $requestBuilder = new RequestBuilder($host, $restConfigPath);
            $guzzleClient = new Client(['verify' => self::PEM_PATH]);
        } else {
            $grpcCredentials = ChannelCredentials::createInsecure();
            $requestBuilder = new InsecureRequestBuilder($host, $restConfigPath);
            $guzzleClient = null;
        }

        // build gRPC transport
        $grpc = GrpcTransport::build(
            $host,
            [
                'stubOpts' => [
                    'credentials' => $grpcCredentials
                ]
            ]
        );

        // build REST transport
        $httpHandler = HttpHandlerFactory::build($guzzleClient);
        $rest = new RestTransport($requestBuilder, [$httpHandler, 'async']);

        return [[$grpc], [$rest]];
    }

    /** @dataProvider provideTransport **/
    public function testFailWithDetails(TransportInterface $transport): void
    {
        $echoClient = new EchoClient([
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
        ]);
        try {
            $echoClient->failEchoWithDetails(new FailEchoWithDetailsRequest());

            // this should not be reached
            $this->fail('errors should have been thrown');
        } catch (ApiException $e) {
        }

        $this->assertGreaterThan(0, count($e->getErrorDetails()));
        foreach ($e->getErrorDetails() as $detail) {
            $this->assertInstanceOf(Message::class, $detail);
        }
    }

    /** @dataProvider provideTransport */
    public function testPqc(TransportInterface $transport): void
    {
        if (!file_exists(self::PEM_PATH)) {
            $this->markTestSkipped(
                'You need to run the showcase server with --tls --ca-cert-output-file tests/Conformance/showcase.pem to run PQC tests'
            );
        }

        $expected = 'This is a test';
        $expectedGroup = 'X25519MLKEM768';
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
        $negotiatedGroup = $responseHeaders[self::TLS_GROUP][0];

        if ($transport instanceof GrpcTransport) {
            // gRPC must ALWAYS negotiate PQC
            $this->assertEquals($expectedGroup, $negotiatedGroup);
        } else {
            // REST uses host system OpenSSL (X25519MLKEM768 when PQC is available, or X25519 fallback)
            $this->assertContains($negotiatedGroup, [$expectedGroup, 'X25519']);
        }
    }
}
