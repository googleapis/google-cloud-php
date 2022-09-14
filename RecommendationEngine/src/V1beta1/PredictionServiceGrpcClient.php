<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\RecommendationEngine\V1beta1;

/**
 * Service for making recommendation prediction.
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
     * Makes a recommendation prediction. If using API Key based authentication,
     * the API Key must be registered using the
     * [PredictionApiKeyRegistry][google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry]
     * service. [Learn more](https://cloud.google.com/recommendations-ai/docs/setting-up#register-key).
     * @param \Google\Cloud\RecommendationEngine\V1beta1\PredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Predict(\Google\Cloud\RecommendationEngine\V1beta1\PredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.PredictionService/Predict',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\PredictResponse', 'decode'],
        $metadata, $options);
    }

}
