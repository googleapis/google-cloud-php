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
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\Transport\RestTransport;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Protobuf\Internal\Message;
use Google\Showcase\V1beta1\Client\EchoClient;
use Google\Showcase\V1beta1\FailEchoWithDetailsRequest;
use Grpc\ChannelCredentials;

final class ShowcaseTest extends TestCase
{
    public function provideTransport()
    {
        // build gRPC transport
        $grpc = GrpcTransport::build(
            'localhost:7469',
            ['stubOpts' => ['credentials' => ChannelCredentials::createInsecure()]]
        );

        // build REST transport
        $restConfigPath = __DIR__ . '/src/V1beta1/resources/echo_rest_client_config.php';
        $requestBuilder = new InsecureRequestBuilder('localhost:7469', $restConfigPath);
        $httpHandler = HttpHandlerFactory::build();
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
}
