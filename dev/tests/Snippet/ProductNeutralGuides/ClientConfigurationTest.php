<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Dev\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use GuzzleHttp\ClientInterface;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;

/**
 * @group docs
 */
class ClientConfigurationTest extends SnippetTestCase
{
    private const CLIENT_CONFIGURATION_FILE = __DIR__ . '/../../../../CLIENT_CONFIGURATION.md';
    use ProphecyTrait;

    /**
     * @dataProvider provideTransport
     */
    public function testConnectingToARegionalEndpoint(string $transport)
    {
        if ($transport === 'grpc' && !extension_loaded('grpc')
            || $transport === 'rest' && extension_loaded('grpc')
        ) {
            $this->markTestSkipped('requires grpc extension to be ' . ($transport === 'grpc' ? 'enabled' : 'disabled'));
        }

        $snippet = $this->snippetFromMarkdown(
            self::CLIENT_CONFIGURATION_FILE,
            '1. Customizing the API Endpoint'
        );

        // Invoke the snippet
        $res = $snippet->invoke('pubsub');
        $pubsubClient = $res->returnVal();
        $this->assertInstanceOf(PubSubClient::class, $pubsubClient);

        // Get the GAPIC client
        $requestHandler = (new ReflectionClass($pubsubClient))->getProperty('requestHandler')->getValue($pubsubClient);
        $clients = (new ReflectionClass($requestHandler))->getProperty('clients')->getValue($requestHandler);
        $publisherClient = $clients[PublisherClient::class];
        $this->assertInstanceOf(PublisherClient::class, $publisherClient);

        // Verify the apiEndpoint (baseUri on RestTransport, hostname on GrpcTransport)
        $transportObj = (new ReflectionClass($publisherClient))->getProperty('transport')->getValue($publisherClient);
        if ($transport === 'rest') {
            $requestBuilder = (new ReflectionClass($transportObj))->getProperty('requestBuilder')->getValue($transportObj);
            $hostname = (new ReflectionClass($requestBuilder))->getProperty('baseUri')->getValue($requestBuilder);
        } else {
            $hostname = (new ReflectionClass($transportObj))->getParentClass()->getProperty('hostname')->getValue($transportObj);
        }
        $this->assertEquals('us-east1-pubsub.googleapis.com:443', $hostname);
    }

    public function provideTransport()
    {
        return [['rest'], ['grpc']];
    }

    public function testDisablingRetries()
    {
        $snippet = $this->snippetFromMarkdown(
            self::CLIENT_CONFIGURATION_FILE,
            'Disabling Retries'
        );

        // Invoke the snippet
        $res = $snippet->invoke('pubsub');
        $pubsubClient = $res->returnVal();
        $this->assertInstanceOf(PubSubClient::class, $pubsubClient);

        // Get the GAPIC client
        $requestHandler = (new ReflectionClass($pubsubClient))->getProperty('requestHandler')->getValue($pubsubClient);
        $clients = (new ReflectionClass($requestHandler))->getProperty('clients')->getValue($requestHandler);
        $publisherClient = $clients[PublisherClient::class];
        $this->assertInstanceOf(PublisherClient::class, $publisherClient);

        // Verify the Retry Settings
        $retrySettings = (new ReflectionClass($publisherClient))->getProperty('retrySettings')->getValue($publisherClient);
        foreach ($retrySettings as $_method => $methodRetrySettings) {
            $this->assertFalse($methodRetrySettings->retriesEnabled());
        }
    }

    public function testProxyWithRest()
    {
        if (extension_loaded('grpc')) {
            $this->markTestSkipped('requires grpc extension to be disabled');
        }

        $snippet = $this->snippetFromMarkdown(
            self::CLIENT_CONFIGURATION_FILE,
            'Proxy with REST'
        );

        // Uncomment the "verify" line so we can check that it is set as expected
        $snippet->replace(
            "// 'verify' => false",
            "'verify' => false"
        );

        // Invoke the snippet
        $res = $snippet->invoke('secretManagerClient');
        $secretManagerClient = $res->returnVal();
        $this->assertInstanceOf(SecretManagerServiceClient::class, $secretManagerClient);

        // Get the Guzzle HTTP Client from RestTransport
        $transport = (new ReflectionClass($secretManagerClient))->getProperty('transport')->getValue($secretManagerClient);
        $httpHandlerClosure = (new ReflectionClass($transport))->getProperty('httpHandler')->getValue($transport);
        $httpHandler = (new \ReflectionFunction($httpHandlerClosure))->getClosureThis();
        $httpClient = (new ReflectionClass($httpHandler))->getParentClass()->getProperty('client')->getValue($httpHandler);
        $this->assertInstanceOf(ClientInterface::class, $httpClient);

        // Verify Proxy config is set
        $config = $httpClient->getConfig();
        $this->assertEquals('http://user:password@proxy.example.com', $config['proxy']);
    }
}
