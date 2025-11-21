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

namespace Google\Cloud\Dev\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group docs
 */
class ProductNeutralGuideTest extends SnippetTestCase
{
    private const PROJECT_ROOT = __DIR__ . '/../../../..';
    use ProphecyTrait;

    public function testConnectingToARegionalEndpointGrpc()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('requires grpc extension');
        }
        $snippet = $this->snippetFromMarkdown(
            self::PROJECT_ROOT . '/CLIENT_CONFIGURATION.md',
            'Connecting to a Regional Endpoint'
        );

        $res = $snippet->invoke('pubsub');
        $pubsubClient = $res->returnVal();
        $this->assertInstanceOf(PubSubClient::class, $pubsubClient);
        $requestHandler = (new \ReflectionClass($pubsubClient))->getProperty('requestHandler')->getValue($pubsubClient);
        $clients = (new \ReflectionClass($requestHandler))->getProperty('clients')->getValue($requestHandler);
        $publisherClient = $clients[PublisherClient::class];
        $this->assertInstanceOf(PublisherClient::class, $publisherClient);
        $transport = (new \ReflectionClass($publisherClient))->getProperty('transport')->getValue($publisherClient);
        $hostname = (new \ReflectionClass($transport))->getParentClass()->getProperty('hostname')->getValue($transport);
        $this->assertEquals('us-east1-pubsub.googleapis.com:443', $hostname);
    }

    public function testConnectingToARegionalEndpointRest()
    {
        if (extension_loaded('grpc')) {
            $this->markTestSkipped('requires grpc extension to be disabled');
        }

        $snippet = $this->snippetFromMarkdown(
            self::PROJECT_ROOT . '/CLIENT_CONFIGURATION.md',
            'Connecting to a Regional Endpoint'
        );

        $res = $snippet->invoke('pubsub');
        $pubsubClient = $res->returnVal();
        $this->assertInstanceOf(PubSubClient::class, $pubsubClient);
        $requestHandler = (new \ReflectionClass($pubsubClient))->getProperty('requestHandler')->getValue($pubsubClient);
        $clients = (new \ReflectionClass($requestHandler))->getProperty('clients')->getValue($requestHandler);
        $publisherClient = $clients[PublisherClient::class];
        $this->assertInstanceOf(PublisherClient::class, $publisherClient);
        $transport = (new \ReflectionClass($publisherClient))->getProperty('transport')->getValue($publisherClient);
        $requestBuilder = (new \ReflectionClass($transport))->getProperty('requestBuilder')->getValue($transport);
        $baseUri = (new \ReflectionClass($requestBuilder))->getProperty('baseUri')->getValue($requestBuilder);
        $this->assertEquals('us-east1-pubsub.googleapis.com:443', $baseUri);
    }

    public function testDisablingRetries()
    {
        $snippet = $this->snippetFromMarkdown(
            self::PROJECT_ROOT . '/CLIENT_CONFIGURATION.md',
            'Disabling Retries'
        );

        $res = $snippet->invoke('pubsub');
        $pubsubClient = $res->returnVal();
        $this->assertInstanceOf(PubSubClient::class, $pubsubClient);
        $requestHandler = (new \ReflectionClass($pubsubClient))->getProperty('requestHandler')->getValue($pubsubClient);
        $clients = (new \ReflectionClass($requestHandler))->getProperty('clients')->getValue($requestHandler);
        $publisherClient = $clients[PublisherClient::class];
        $this->assertInstanceOf(PublisherClient::class, $publisherClient);
        $retrySettings = (new \ReflectionClass($publisherClient))->getProperty('retrySettings')->getValue($publisherClient);
        foreach ($retrySettings as $_method => $methodRetrySettings) {
            $this->assertFalse($methodRetrySettings->retriesEnabled());
        }
    }
}
