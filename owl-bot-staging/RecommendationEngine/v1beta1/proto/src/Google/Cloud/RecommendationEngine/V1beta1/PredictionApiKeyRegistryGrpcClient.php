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
 * Service for registering API keys for use with the `predict` method. If you
 * use an API key to request predictions, you must first register the API key.
 * Otherwise, your prediction request is rejected. If you use OAuth to
 * authenticate your `predict` method call, you do not need to register an API
 * key. You can register up to 20 API keys per project.
 */
class PredictionApiKeyRegistryGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Register an API key for use with predict method.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\CreatePredictionApiKeyRegistrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePredictionApiKeyRegistration(\Google\Cloud\RecommendationEngine\V1beta1\CreatePredictionApiKeyRegistrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/CreatePredictionApiKeyRegistration',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\PredictionApiKeyRegistration', 'decode'],
        $metadata, $options);
    }

    /**
     * List the registered apiKeys for use with predict method.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ListPredictionApiKeyRegistrationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPredictionApiKeyRegistrations(\Google\Cloud\RecommendationEngine\V1beta1\ListPredictionApiKeyRegistrationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/ListPredictionApiKeyRegistrations',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\ListPredictionApiKeyRegistrationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Unregister an apiKey from using for predict method.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\DeletePredictionApiKeyRegistrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePredictionApiKeyRegistration(\Google\Cloud\RecommendationEngine\V1beta1\DeletePredictionApiKeyRegistrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.PredictionApiKeyRegistry/DeletePredictionApiKeyRegistration',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
