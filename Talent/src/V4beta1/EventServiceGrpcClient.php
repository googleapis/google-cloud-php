<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\Talent\V4beta1;

/**
 * A service handles client event report.
 */
class EventServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Report events issued when end user interacts with customer's application
     * that uses Cloud Talent Solution. You may inspect the created events in
     * [self service
     * tools](https://console.cloud.google.com/talent-solution/overview).
     * [Learn
     * more](https://cloud.google.com/talent-solution/docs/management-tools)
     * about self service tools.
     * @param \Google\Cloud\Talent\V4beta1\CreateClientEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateClientEvent(\Google\Cloud\Talent\V4beta1\CreateClientEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.EventService/CreateClientEvent',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ClientEvent', 'decode'],
        $metadata, $options);
    }

}
