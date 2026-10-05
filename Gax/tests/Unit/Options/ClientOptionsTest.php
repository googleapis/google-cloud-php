<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\ApiCore\Tests\Unit\Options;

use Google\ApiCore\Options\ClientOptions;
use PHPUnit\Framework\TestCase;

class ClientOptionsTest extends TestCase
{
    public function testFluidClientOptions()
    {
        $options = (new ClientOptions())
            ->setApiEndpoint('custom.endpoint:443')
            ->setDisableRetries(true)
            ->setUniverseDomain('custom.domain')
            ->setApiKey('my-api-key')
            ->setTransportConfig([
                'grpc' => ['stubOpts' => ['foo' => 'bar']],
                'grpc-fallback' => ['httpHandler' => fn () => null],
            ]);

        $this->assertEquals('custom.endpoint:443', $options['apiEndpoint']);
        $this->assertTrue($options['disableRetries']);
        $this->assertEquals('custom.domain', $options['universeDomain']);
        $this->assertEquals('my-api-key', $options['apiKey']);
        $this->assertEquals(['foo' => 'bar'], $options['transportConfig']['grpc']['stubOpts']);
        $this->assertNotNull($options['transportConfig']['grpc-fallback']['httpHandler']);
    }

    public function testServiceAddressAlias()
    {
        $options = new ClientOptions([
            'apiEndpoint' => 'default.endpoint:443',
            'serviceAddress' => 'override.endpoint:443',
        ]);
        $this->assertEquals('override.endpoint:443', $options['apiEndpoint']);
        $this->assertArrayNotHasKey('serviceAddress', $options->toArray());

        $fluid = (new ClientOptions())->setServiceAddress('fluid.endpoint:443');
        $this->assertEquals('fluid.endpoint:443', $fluid['apiEndpoint']);
    }

    public function testSubclassClientOptions()
    {
        $options = new class([
            'apiEndpoint' => 'ads.googleapis.com:443',
            'developer-token' => 'dev-123',
        ]) extends ClientOptions {
            protected ?string $developerToken = null;
            protected ?string $loginCustomerId = null;

            public function setDeveloperToken(?string $developerToken): static
            {
                $this->developerToken = $developerToken;
                return $this;
            }

            public function getDeveloperToken(): ?string
            {
                return $this->developerToken;
            }

            public function setLoginCustomerId(?string $loginCustomerId): static
            {
                $this->loginCustomerId = $loginCustomerId;
                return $this;
            }
        };

        $options
            ->setDisableRetries(true)
            ->setLoginCustomerId('cust-456');

        $this->assertEquals('ads.googleapis.com:443', $options['apiEndpoint']);
        $this->assertTrue($options['disableRetries']);
        $this->assertEquals('dev-123', $options->getDeveloperToken());
        $this->assertEquals('dev-123', $options['developerToken']);
        $this->assertEquals('cust-456', $options['loginCustomerId']);

        $arr = $options->toArray();
        $this->assertEquals('dev-123', $arr['developerToken']);
        $this->assertEquals('cust-456', $arr['loginCustomerId']);
    }

    public function testArrayAccessSet()
    {
        $options = new ClientOptions();
        $options['apiEndpoint'] ??= 'localhost:8086';

        $this->assertEquals('localhost:8086', $options['apiEndpoint']);
    }
}
