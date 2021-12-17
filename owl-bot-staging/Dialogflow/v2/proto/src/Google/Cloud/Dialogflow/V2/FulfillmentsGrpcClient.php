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
namespace Google\Cloud\Dialogflow\V2;

/**
 * Service for managing [Fulfillments][google.cloud.dialogflow.v2.Fulfillment].
 */
class FulfillmentsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieves the fulfillment.
     * @param \Google\Cloud\Dialogflow\V2\GetFulfillmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFulfillment(\Google\Cloud\Dialogflow\V2\GetFulfillmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Fulfillments/GetFulfillment',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Fulfillment', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the fulfillment.
     * @param \Google\Cloud\Dialogflow\V2\UpdateFulfillmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFulfillment(\Google\Cloud\Dialogflow\V2\UpdateFulfillmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Fulfillments/UpdateFulfillment',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Fulfillment', 'decode'],
        $metadata, $options);
    }

}
