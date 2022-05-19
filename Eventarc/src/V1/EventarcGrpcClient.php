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
namespace Google\Cloud\Eventarc\V1;

/**
 * Eventarc allows users to subscribe to various events that are provided by
 * Google Cloud services and forward them to supported destinations.
 */
class EventarcGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Get a single trigger.
     * @param \Google\Cloud\Eventarc\V1\GetTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTrigger(\Google\Cloud\Eventarc\V1\GetTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/GetTrigger',
        $argument,
        ['\Google\Cloud\Eventarc\V1\Trigger', 'decode'],
        $metadata, $options);
    }

    /**
     * List triggers.
     * @param \Google\Cloud\Eventarc\V1\ListTriggersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTriggers(\Google\Cloud\Eventarc\V1\ListTriggersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/ListTriggers',
        $argument,
        ['\Google\Cloud\Eventarc\V1\ListTriggersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new trigger in a particular project and location.
     * @param \Google\Cloud\Eventarc\V1\CreateTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTrigger(\Google\Cloud\Eventarc\V1\CreateTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/CreateTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a single trigger.
     * @param \Google\Cloud\Eventarc\V1\UpdateTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTrigger(\Google\Cloud\Eventarc\V1\UpdateTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/UpdateTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a single trigger.
     * @param \Google\Cloud\Eventarc\V1\DeleteTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTrigger(\Google\Cloud\Eventarc\V1\DeleteTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/DeleteTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a single Channel.
     * @param \Google\Cloud\Eventarc\V1\GetChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetChannel(\Google\Cloud\Eventarc\V1\GetChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/GetChannel',
        $argument,
        ['\Google\Cloud\Eventarc\V1\Channel', 'decode'],
        $metadata, $options);
    }

    /**
     * List channels.
     * @param \Google\Cloud\Eventarc\V1\ListChannelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListChannels(\Google\Cloud\Eventarc\V1\ListChannelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/ListChannels',
        $argument,
        ['\Google\Cloud\Eventarc\V1\ListChannelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new channel in a particular project and location.
     * @param \Google\Cloud\Eventarc\V1\CreateChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateChannel(\Google\Cloud\Eventarc\V1\CreateChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/CreateChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a single channel.
     * @param \Google\Cloud\Eventarc\V1\UpdateChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateChannel(\Google\Cloud\Eventarc\V1\UpdateChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/UpdateChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a single channel.
     * @param \Google\Cloud\Eventarc\V1\DeleteChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteChannel(\Google\Cloud\Eventarc\V1\DeleteChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/DeleteChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a single Provider.
     * @param \Google\Cloud\Eventarc\V1\GetProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProvider(\Google\Cloud\Eventarc\V1\GetProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/GetProvider',
        $argument,
        ['\Google\Cloud\Eventarc\V1\Provider', 'decode'],
        $metadata, $options);
    }

    /**
     * List providers.
     * @param \Google\Cloud\Eventarc\V1\ListProvidersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProviders(\Google\Cloud\Eventarc\V1\ListProvidersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/ListProviders',
        $argument,
        ['\Google\Cloud\Eventarc\V1\ListProvidersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a single ChannelConnection.
     * @param \Google\Cloud\Eventarc\V1\GetChannelConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetChannelConnection(\Google\Cloud\Eventarc\V1\GetChannelConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/GetChannelConnection',
        $argument,
        ['\Google\Cloud\Eventarc\V1\ChannelConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * List channel connections.
     * @param \Google\Cloud\Eventarc\V1\ListChannelConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListChannelConnections(\Google\Cloud\Eventarc\V1\ListChannelConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/ListChannelConnections',
        $argument,
        ['\Google\Cloud\Eventarc\V1\ListChannelConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new ChannelConnection in a particular project and location.
     * @param \Google\Cloud\Eventarc\V1\CreateChannelConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateChannelConnection(\Google\Cloud\Eventarc\V1\CreateChannelConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/CreateChannelConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a single ChannelConnection.
     * @param \Google\Cloud\Eventarc\V1\DeleteChannelConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteChannelConnection(\Google\Cloud\Eventarc\V1\DeleteChannelConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/DeleteChannelConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
