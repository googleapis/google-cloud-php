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
namespace Google\Cloud\Run\V2;

/**
 * Cloud Run Revision Control Plane API.
 */
class RevisionsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets information about a Revision.
     * @param \Google\Cloud\Run\V2\GetRevisionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRevision(\Google\Cloud\Run\V2\GetRevisionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.run.v2.Revisions/GetRevision',
        $argument,
        ['\Google\Cloud\Run\V2\Revision', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Revisions from a given Service, or from a given location.
     * @param \Google\Cloud\Run\V2\ListRevisionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRevisions(\Google\Cloud\Run\V2\ListRevisionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.run.v2.Revisions/ListRevisions',
        $argument,
        ['\Google\Cloud\Run\V2\ListRevisionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Revision.
     * @param \Google\Cloud\Run\V2\DeleteRevisionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRevision(\Google\Cloud\Run\V2\DeleteRevisionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.run.v2.Revisions/DeleteRevision',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
