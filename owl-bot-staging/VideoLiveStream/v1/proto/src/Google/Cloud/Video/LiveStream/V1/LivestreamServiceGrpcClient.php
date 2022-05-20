<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\Video\LiveStream\V1;

/**
 * Using Live Stream API, you can generate live streams in the various
 * renditions and streaming formats. The streaming format include HTTP Live
 * Streaming (HLS) and Dynamic Adaptive Streaming over HTTP (DASH). You can send
 * a source stream in the various ways, including Real-Time Messaging
 * Protocol (RTMP) and Secure Reliable Transport (SRT).
 */
class LivestreamServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a channel with the provided unique ID in the specified
     * region.
     * @param \Google\Cloud\Video\LiveStream\V1\CreateChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateChannel(\Google\Cloud\Video\LiveStream\V1\CreateChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/CreateChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of all channels in the specified region.
     * @param \Google\Cloud\Video\LiveStream\V1\ListChannelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListChannels(\Google\Cloud\Video\LiveStream\V1\ListChannelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/ListChannels',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\ListChannelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified channel.
     * @param \Google\Cloud\Video\LiveStream\V1\GetChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetChannel(\Google\Cloud\Video\LiveStream\V1\GetChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/GetChannel',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\Channel', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified channel.
     * @param \Google\Cloud\Video\LiveStream\V1\DeleteChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteChannel(\Google\Cloud\Video\LiveStream\V1\DeleteChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/DeleteChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified channel.
     * @param \Google\Cloud\Video\LiveStream\V1\UpdateChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateChannel(\Google\Cloud\Video\LiveStream\V1\UpdateChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/UpdateChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts the specified channel. Part of the video pipeline will be created
     * only when the StartChannel request is received by the server.
     * @param \Google\Cloud\Video\LiveStream\V1\StartChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartChannel(\Google\Cloud\Video\LiveStream\V1\StartChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/StartChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops the specified channel. Part of the video pipeline will be released
     * when the StopChannel request is received by the server.
     * @param \Google\Cloud\Video\LiveStream\V1\StopChannelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopChannel(\Google\Cloud\Video\LiveStream\V1\StopChannelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/StopChannel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an input with the provided unique ID in the specified region.
     * @param \Google\Cloud\Video\LiveStream\V1\CreateInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInput(\Google\Cloud\Video\LiveStream\V1\CreateInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/CreateInput',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of all inputs in the specified region.
     * @param \Google\Cloud\Video\LiveStream\V1\ListInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInputs(\Google\Cloud\Video\LiveStream\V1\ListInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/ListInputs',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\ListInputsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified input.
     * @param \Google\Cloud\Video\LiveStream\V1\GetInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInput(\Google\Cloud\Video\LiveStream\V1\GetInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/GetInput',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\Input', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified input.
     * @param \Google\Cloud\Video\LiveStream\V1\DeleteInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInput(\Google\Cloud\Video\LiveStream\V1\DeleteInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/DeleteInput',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified input.
     * @param \Google\Cloud\Video\LiveStream\V1\UpdateInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInput(\Google\Cloud\Video\LiveStream\V1\UpdateInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/UpdateInput',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an event with the provided unique ID in the specified channel.
     * @param \Google\Cloud\Video\LiveStream\V1\CreateEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEvent(\Google\Cloud\Video\LiveStream\V1\CreateEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/CreateEvent',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\Event', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of all events in the specified channel.
     * @param \Google\Cloud\Video\LiveStream\V1\ListEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEvents(\Google\Cloud\Video\LiveStream\V1\ListEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/ListEvents',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\ListEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the specified event.
     * @param \Google\Cloud\Video\LiveStream\V1\GetEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEvent(\Google\Cloud\Video\LiveStream\V1\GetEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/GetEvent',
        $argument,
        ['\Google\Cloud\Video\LiveStream\V1\Event', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified event.
     * @param \Google\Cloud\Video\LiveStream\V1\DeleteEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEvent(\Google\Cloud\Video\LiveStream\V1\DeleteEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.video.livestream.v1.LivestreamService/DeleteEvent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
