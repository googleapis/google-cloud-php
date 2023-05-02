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
namespace Google\Cloud\Retail\V2;

/**
 * Service for performing CRUD operations on models.
 * Recommendation models contain all the metadata necessary to generate a set of
 * models for the `Predict()` API. A model is queried
 * indirectly via a ServingConfig, which associates a model with a
 * given Placement (e.g. Frequently Bought Together on Home Page).
 *
 * This service allows you to do the following:
 *
 * * Initiate training of a model.
 * * Pause training of an existing model.
 * * List all the available models along with their metadata.
 * * Control their tuning schedule.
 */
class ModelServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new model.
     * @param \Google\Cloud\Retail\V2\CreateModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateModel(\Google\Cloud\Retail\V2\CreateModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/CreateModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a model.
     * @param \Google\Cloud\Retail\V2\GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModel(\Google\Cloud\Retail\V2\GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/GetModel',
        $argument,
        ['\Google\Cloud\Retail\V2\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses the training of an existing model.
     * @param \Google\Cloud\Retail\V2\PauseModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseModel(\Google\Cloud\Retail\V2\PauseModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/PauseModel',
        $argument,
        ['\Google\Cloud\Retail\V2\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Resumes the training of an existing model.
     * @param \Google\Cloud\Retail\V2\ResumeModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeModel(\Google\Cloud\Retail\V2\ResumeModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/ResumeModel',
        $argument,
        ['\Google\Cloud\Retail\V2\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing model.
     * @param \Google\Cloud\Retail\V2\DeleteModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteModel(\Google\Cloud\Retail\V2\DeleteModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/DeleteModel',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all the models linked to this event store.
     * @param \Google\Cloud\Retail\V2\ListModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModels(\Google\Cloud\Retail\V2\ListModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/ListModels',
        $argument,
        ['\Google\Cloud\Retail\V2\ListModelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update of model metadata. Only fields that
     * currently can be updated are: `filtering_option` and
     * `periodic_tuning_state`.
     * If other values are provided, this API method ignores them.
     * @param \Google\Cloud\Retail\V2\UpdateModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateModel(\Google\Cloud\Retail\V2\UpdateModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/UpdateModel',
        $argument,
        ['\Google\Cloud\Retail\V2\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Tunes an existing model.
     * @param \Google\Cloud\Retail\V2\TuneModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TuneModel(\Google\Cloud\Retail\V2\TuneModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ModelService/TuneModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
