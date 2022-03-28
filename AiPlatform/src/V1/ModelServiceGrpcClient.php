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
 * A service for managing Vertex AI's machine learning Models.
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
     * Uploads a Model artifact into Vertex AI.
     * @param \Google\Cloud\AIPlatform\V1\UploadModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UploadModel(\Google\Cloud\AIPlatform\V1\UploadModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/UploadModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a Model.
     * @param \Google\Cloud\AIPlatform\V1\GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModel(\Google\Cloud\AIPlatform\V1\GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/GetModel',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Models in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModels(\Google\Cloud\AIPlatform\V1\ListModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/ListModels',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListModelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a Model.
     * @param \Google\Cloud\AIPlatform\V1\UpdateModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateModel(\Google\Cloud\AIPlatform\V1\UpdateModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/UpdateModel',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Model.
     *
     * A model cannot be deleted if any [Endpoint][google.cloud.aiplatform.v1.Endpoint] resource has a
     * [DeployedModel][google.cloud.aiplatform.v1.DeployedModel] based on the model in its
     * [deployed_models][google.cloud.aiplatform.v1.Endpoint.deployed_models] field.
     * @param \Google\Cloud\AIPlatform\V1\DeleteModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteModel(\Google\Cloud\AIPlatform\V1\DeleteModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/DeleteModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports a trained, exportable Model to a location specified by the
     * user. A Model is considered to be exportable if it has at least one
     * [supported export format][google.cloud.aiplatform.v1.Model.supported_export_formats].
     * @param \Google\Cloud\AIPlatform\V1\ExportModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportModel(\Google\Cloud\AIPlatform\V1\ExportModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/ExportModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ModelEvaluation.
     * @param \Google\Cloud\AIPlatform\V1\GetModelEvaluationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModelEvaluation(\Google\Cloud\AIPlatform\V1\GetModelEvaluationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/GetModelEvaluation',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ModelEvaluation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ModelEvaluations in a Model.
     * @param \Google\Cloud\AIPlatform\V1\ListModelEvaluationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModelEvaluations(\Google\Cloud\AIPlatform\V1\ListModelEvaluationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/ListModelEvaluations',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListModelEvaluationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ModelEvaluationSlice.
     * @param \Google\Cloud\AIPlatform\V1\GetModelEvaluationSliceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModelEvaluationSlice(\Google\Cloud\AIPlatform\V1\GetModelEvaluationSliceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/GetModelEvaluationSlice',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ModelEvaluationSlice', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ModelEvaluationSlices in a ModelEvaluation.
     * @param \Google\Cloud\AIPlatform\V1\ListModelEvaluationSlicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModelEvaluationSlices(\Google\Cloud\AIPlatform\V1\ListModelEvaluationSlicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.ModelService/ListModelEvaluationSlices',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListModelEvaluationSlicesResponse', 'decode'],
        $metadata, $options);
    }

}
