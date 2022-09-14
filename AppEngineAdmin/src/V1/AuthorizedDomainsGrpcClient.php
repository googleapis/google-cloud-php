<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\AppEngine\V1;

/**
 * Manages domains a user is authorized to administer. To authorize use of a
 * domain, verify ownership via
 * [Webmaster Central](https://www.google.com/webmasters/verification/home).
 */
class AuthorizedDomainsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all domains the user is authorized to administer.
     * @param \Google\Cloud\AppEngine\V1\ListAuthorizedDomainsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAuthorizedDomains(\Google\Cloud\AppEngine\V1\ListAuthorizedDomainsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.AuthorizedDomains/ListAuthorizedDomains',
        $argument,
        ['\Google\Cloud\AppEngine\V1\ListAuthorizedDomainsResponse', 'decode'],
        $metadata, $options);
    }

}
