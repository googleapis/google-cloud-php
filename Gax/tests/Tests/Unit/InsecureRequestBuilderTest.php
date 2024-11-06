<?php
/**
 * Copyright 2024 Google Inc.
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


use Google\ApiCore\InsecureRequestBuilder;
use Google\ApiCore\Testing\MockRequestBody;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class InsecureRequestBuilderTest extends TestCase
{
    private $builder;

    const SERVICE_NAME = 'test.interface.v1.api';

    public function setUp(): void
    {
        $this->builder = new InsecureRequestBuilder(
            'www.example.com',
            __DIR__ . '/testdata/test_service_rest_client_config.php'
        );
    }

    public function testMethodWithUrlPlaceholder()
    {
        $message = new MockRequestBody();
        $message->setName('message/foo');

        $request = $this->builder->build(self::SERVICE_NAME . '/MethodWithUrlPlaceholder', $message);
        $uri = $request->getUri();

        $this->assertSame('http', $uri->getScheme());
        $this->assertEmpty($uri->getQuery());
        $this->assertEmpty((string) $request->getBody());
        $this->assertSame('/v1/message/foo', $uri->getPath());
    }

    public function testMethodWithBody()
    {
        $message = new MockRequestBody();
        $message->setName('message/foo');
        $nestedMessage = new MockRequestBody();
        $nestedMessage->setName('nested/foo');
        $message->setNestedMessage($nestedMessage);

        $request = $this->builder->build(self::SERVICE_NAME . '/MethodWithBodyAndUrlPlaceholder', $message);
        $uri = $request->getUri();

        $this->assertSame('http', $uri->getScheme());
        $this->assertEmpty($uri->getQuery());
        $this->assertSame('/v1/message/foo', $uri->getPath());
        $this->assertEquals(
            ['name' => 'message/foo', 'nestedMessage' => ['name' => 'nested/foo']],
            json_decode($request->getBody(), true)
        );
    }
}
