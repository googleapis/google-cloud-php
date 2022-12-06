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
namespace Google\Cloud\AIPlatform\V1;

/**
 * A service that migrates resources from automl.googleapis.com,
 * datalabeling.googleapis.com and ml.googleapis.com to Vertex AI.
 */
class MigrationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Searches all of the resources in automl.googleapis.com,
     * datalabeling.googleapis.com and ml.googleapis.com that can be migrated to
     * Vertex AI's given location.
     * @param \Google\Cloud\AIPlatform\V1\SearchMigratableResourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchMigratableResources(\Google\Cloud\AIPlatform\V1\SearchMigratableResourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MigrationService/SearchMigratableResources',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\SearchMigratableResourcesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Batch migrates resources from ml.googleapis.com, automl.googleapis.com,
     * and datalabeling.googleapis.com to Vertex AI.
     * @param \Google\Cloud\AIPlatform\V1\BatchMigrateResourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchMigrateResources(\Google\Cloud\AIPlatform\V1\BatchMigrateResourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MigrationService/BatchMigrateResources',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
