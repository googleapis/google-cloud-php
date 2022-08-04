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
namespace Google\Cloud\Datastream\V1;

/**
 * Datastream service
 */
class DatastreamGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Use this method to list connection profiles created in a project and
     * location.
     * @param \Google\Cloud\Datastream\V1\ListConnectionProfilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConnectionProfiles(\Google\Cloud\Datastream\V1\ListConnectionProfilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/ListConnectionProfiles',
        $argument,
        ['\Google\Cloud\Datastream\V1\ListConnectionProfilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to get details about a connection profile.
     * @param \Google\Cloud\Datastream\V1\GetConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnectionProfile(\Google\Cloud\Datastream\V1\GetConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/GetConnectionProfile',
        $argument,
        ['\Google\Cloud\Datastream\V1\ConnectionProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to create a connection profile in a project and location.
     * @param \Google\Cloud\Datastream\V1\CreateConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConnectionProfile(\Google\Cloud\Datastream\V1\CreateConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/CreateConnectionProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to update the parameters of a connection profile.
     * @param \Google\Cloud\Datastream\V1\UpdateConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConnectionProfile(\Google\Cloud\Datastream\V1\UpdateConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/UpdateConnectionProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to delete a connection profile.
     * @param \Google\Cloud\Datastream\V1\DeleteConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConnectionProfile(\Google\Cloud\Datastream\V1\DeleteConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/DeleteConnectionProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to discover a connection profile.
     * The discover API call exposes the data objects and metadata belonging to
     * the profile. Typically, a request returns children data objects of a
     * parent data object that's optionally supplied in the request.
     * @param \Google\Cloud\Datastream\V1\DiscoverConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DiscoverConnectionProfile(\Google\Cloud\Datastream\V1\DiscoverConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/DiscoverConnectionProfile',
        $argument,
        ['\Google\Cloud\Datastream\V1\DiscoverConnectionProfileResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to list streams in a project and location.
     * @param \Google\Cloud\Datastream\V1\ListStreamsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListStreams(\Google\Cloud\Datastream\V1\ListStreamsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/ListStreams',
        $argument,
        ['\Google\Cloud\Datastream\V1\ListStreamsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to get details about a stream.
     * @param \Google\Cloud\Datastream\V1\GetStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetStream(\Google\Cloud\Datastream\V1\GetStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/GetStream',
        $argument,
        ['\Google\Cloud\Datastream\V1\Stream', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to create a stream.
     * @param \Google\Cloud\Datastream\V1\CreateStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateStream(\Google\Cloud\Datastream\V1\CreateStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/CreateStream',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to update the configuration of a stream.
     * @param \Google\Cloud\Datastream\V1\UpdateStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateStream(\Google\Cloud\Datastream\V1\UpdateStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/UpdateStream',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to delete a stream.
     * @param \Google\Cloud\Datastream\V1\DeleteStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteStream(\Google\Cloud\Datastream\V1\DeleteStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/DeleteStream',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to get details about a stream object.
     * @param \Google\Cloud\Datastream\V1\GetStreamObjectRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetStreamObject(\Google\Cloud\Datastream\V1\GetStreamObjectRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/GetStreamObject',
        $argument,
        ['\Google\Cloud\Datastream\V1\StreamObject', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to look up a stream object by its source object identifier.
     * @param \Google\Cloud\Datastream\V1\LookupStreamObjectRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LookupStreamObject(\Google\Cloud\Datastream\V1\LookupStreamObjectRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/LookupStreamObject',
        $argument,
        ['\Google\Cloud\Datastream\V1\StreamObject', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to list the objects of a specific stream.
     * @param \Google\Cloud\Datastream\V1\ListStreamObjectsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListStreamObjects(\Google\Cloud\Datastream\V1\ListStreamObjectsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/ListStreamObjects',
        $argument,
        ['\Google\Cloud\Datastream\V1\ListStreamObjectsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to start a backfill job for the specified stream object.
     * @param \Google\Cloud\Datastream\V1\StartBackfillJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartBackfillJob(\Google\Cloud\Datastream\V1\StartBackfillJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/StartBackfillJob',
        $argument,
        ['\Google\Cloud\Datastream\V1\StartBackfillJobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to stop a backfill job for the specified stream object.
     * @param \Google\Cloud\Datastream\V1\StopBackfillJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopBackfillJob(\Google\Cloud\Datastream\V1\StopBackfillJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/StopBackfillJob',
        $argument,
        ['\Google\Cloud\Datastream\V1\StopBackfillJobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * The FetchStaticIps API call exposes the static IP addresses used by
     * Datastream.
     * @param \Google\Cloud\Datastream\V1\FetchStaticIpsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchStaticIps(\Google\Cloud\Datastream\V1\FetchStaticIpsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/FetchStaticIps',
        $argument,
        ['\Google\Cloud\Datastream\V1\FetchStaticIpsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to create a private connectivity configuration.
     * @param \Google\Cloud\Datastream\V1\CreatePrivateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePrivateConnection(\Google\Cloud\Datastream\V1\CreatePrivateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/CreatePrivateConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to get details about a private connectivity configuration.
     * @param \Google\Cloud\Datastream\V1\GetPrivateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPrivateConnection(\Google\Cloud\Datastream\V1\GetPrivateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/GetPrivateConnection',
        $argument,
        ['\Google\Cloud\Datastream\V1\PrivateConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to list private connectivity configurations in a project
     * and location.
     * @param \Google\Cloud\Datastream\V1\ListPrivateConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPrivateConnections(\Google\Cloud\Datastream\V1\ListPrivateConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/ListPrivateConnections',
        $argument,
        ['\Google\Cloud\Datastream\V1\ListPrivateConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to delete a private connectivity configuration.
     * @param \Google\Cloud\Datastream\V1\DeletePrivateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePrivateConnection(\Google\Cloud\Datastream\V1\DeletePrivateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/DeletePrivateConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to create a route for a private connectivity configuration
     * in a project and location.
     * @param \Google\Cloud\Datastream\V1\CreateRouteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRoute(\Google\Cloud\Datastream\V1\CreateRouteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/CreateRoute',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to get details about a route.
     * @param \Google\Cloud\Datastream\V1\GetRouteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRoute(\Google\Cloud\Datastream\V1\GetRouteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/GetRoute',
        $argument,
        ['\Google\Cloud\Datastream\V1\Route', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to list routes created for a private connectivity
     * configuration in a project and location.
     * @param \Google\Cloud\Datastream\V1\ListRoutesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRoutes(\Google\Cloud\Datastream\V1\ListRoutesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/ListRoutes',
        $argument,
        ['\Google\Cloud\Datastream\V1\ListRoutesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Use this method to delete a route.
     * @param \Google\Cloud\Datastream\V1\DeleteRouteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRoute(\Google\Cloud\Datastream\V1\DeleteRouteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datastream.v1.Datastream/DeleteRoute',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
