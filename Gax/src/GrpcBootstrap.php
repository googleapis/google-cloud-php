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
namespace Google\GAX;

use Google\Auth\ApplicationDefaultCredentials;
use Grpc\ChannelCredentials;

/**
 * Class that provides helpful utility functions for bootstrapping a gRPC client.
 */
class GrpcBootstrap {
    /**
     * Provides a default instance of GrpcBootstrap.
     */
    public static function defaultInstance() {
        return new GrpcBootstrap();
    }

    /**
     * Creates the callback function to be passed to gRPC for providing the credentials
     * for a call.
     *
     * @param scopes The scopes for Oauth2 credentials.
     */
    public function createCallCredentialsCallback($scopes)
    {
        $authCredentials = $this->getADCCredentials($scopes);
        $callback = function($context) use ($authCredentials) {
            return $authCredentials->updateMetadata([], $context->service_url);
        };
        return $callback;
    }

    /**
     * Gets credentials from ADC. This exists to allow overriding in unit tests.
     */
    protected function getADCCredentials($scopes)
    {
        return ApplicationDefaultCredentials::getCredentials($scopes);
    }

    // TODO(garrettjones):
    // add:
    //   1. (when supported in gRPC) channel
    /**
     * Creates a gRPC client stub.
     *
     * @oaram function $generatedCreateStub
     *        Function callback which must accept two arguments ($hostname, $opts)
     *        and return an instance of the stub of the specific API to call.
     *        Generally, this should just call the stub's constructor and return
     *        the instance.
     * @param string $serviceAddress The domain name of the API remote host.
     * @param mixed $port The port on which to connect to the remote host.
     * @param array $options {
     *     Optional. Options for configuring the gRPC stub.
     *
     *     @type Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     * }
     */
    public function createStub($generatedCreateStub, $serviceAddress, $port, $options = array())
    {
        $stubOpts = [];
        if (empty($options['sslCreds'])) {
            $stubOpts['credentials'] = $this->createSslChannelCredentials();
        } else {
            $stubOpts['credentials'] = $options['sslCreds'];
        }

        $fullAddress = "$serviceAddress:$port";
        $stubOpts['grpc.ssl_target_name_override'] = $fullAddress;

        return $generatedCreateStub($fullAddress, $stubOpts);
    }

    /**
     * Gets credentials from ADC. This exists to allow overriding in unit tests.
     */
    protected function createSslChannelCredentials()
    {
        return ChannelCredentials::createSsl();
    }
}
