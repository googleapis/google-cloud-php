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
 * A service for online predictions and explanations.
 */
class PredictionServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Perform an online prediction.
     * @param \Google\Cloud\AIPlatform\V1\PredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Predict(\Google\Cloud\AIPlatform\V1\PredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.PredictionService/Predict',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\PredictResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Perform an online prediction with an arbitrary HTTP payload.
     *
     * The response includes the following HTTP headers:
     *
     * * `X-Vertex-AI-Endpoint-Id`: ID of the [Endpoint][google.cloud.aiplatform.v1.Endpoint] that served this
     * prediction.
     *
     * * `X-Vertex-AI-Deployed-Model-Id`: ID of the Endpoint's [DeployedModel][google.cloud.aiplatform.v1.DeployedModel]
     * that served this prediction.
     * @param \Google\Cloud\AIPlatform\V1\RawPredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RawPredict(\Google\Cloud\AIPlatform\V1\RawPredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.PredictionService/RawPredict',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * Perform an online explanation.
     *
     * If [deployed_model_id][google.cloud.aiplatform.v1.ExplainRequest.deployed_model_id] is specified,
     * the corresponding DeployModel must have
     * [explanation_spec][google.cloud.aiplatform.v1.DeployedModel.explanation_spec]
     * populated. If [deployed_model_id][google.cloud.aiplatform.v1.ExplainRequest.deployed_model_id]
     * is not specified, all DeployedModels must have
     * [explanation_spec][google.cloud.aiplatform.v1.DeployedModel.explanation_spec]
     * populated. Only deployed AutoML tabular Models have
     * explanation_spec.
     * @param \Google\Cloud\AIPlatform\V1\ExplainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Explain(\Google\Cloud\AIPlatform\V1\ExplainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.PredictionService/Explain',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ExplainResponse', 'decode'],
        $metadata, $options);
    }

}
