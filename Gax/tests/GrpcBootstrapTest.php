<?php
/*
 * Copyright 2016, Google Inc.
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

use Google\GAX\GrpcBootstrap;

class GrpcBootstrapTest extends PHPUnit_Framework_TestCase
{
    public function testCreateCallCredentialsCallback()
    {
        $grpcBootstrap = new GrpcBootstrapForTesting();
        $callback = $grpcBootstrap->createCallCredentialsCallback(['my-scope']);
        $context = new MockContext('my-service-url');
        $callbackResult = $callback($context);
        $this->assertEquals([], $callbackResult['metadata']);
        $this->assertEquals('my-service-url', $callbackResult['serviceUrl']);
    }

    public function testCreateStubWithDefaultSslCreds()
    {
        $grpcBootstrap = new GrpcBootstrapForTesting();
        $createStubCallback = function($hostname, $stubOpts) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts];
        };
        $createStubResult = $grpcBootstrap->createStub(
            $createStubCallback, 'my-service-address', 8443);
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals('DummySslCreds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals('my-service-address:8443',
                            $createStubResult['stubOpts']['grpc.ssl_target_name_override']);
    }

    public function testCreateStubWithExplicitSslCreds()
    {
        $grpcBootstrap = new GrpcBootstrapForTesting();
        $createStubCallback = function($hostname, $stubOpts) {
            return ['hostname' => $hostname, 'stubOpts' => $stubOpts];
        };
        $createStubResult = $grpcBootstrap->createStub(
            $createStubCallback, 'my-service-address', 8443, ['sslCreds' => 'provided-creds']);
        $this->assertEquals('my-service-address:8443', $createStubResult['hostname']);
        $this->assertEquals('provided-creds', $createStubResult['stubOpts']['credentials']);
        $this->assertEquals('my-service-address:8443',
                            $createStubResult['stubOpts']['grpc.ssl_target_name_override']);
    }
}

class MockContext
{
    public $service_url;

    public function __construct($service_url)
    {
        $this->service_url = $service_url;
    }
}

class MockADC
{
    public function __construct($scopes)
    {
        $this->scopes = $scopes;
    }

    public function updateMetadata($metadata, $serviceUrl)
    {
        return ['metadata' => $metadata, 'serviceUrl' => $serviceUrl];
    }

    public function getScopes()
    {
        return $this->scopes;
    }
}

class GrpcBootstrapForTesting extends GrpcBootstrap
{
    protected function getADCCredentials($scopes)
    {
        return new MockADC($scopes);
    }

    protected function createSslChannelCredentials()
    {
        return "DummySslCreds";
    }
}
