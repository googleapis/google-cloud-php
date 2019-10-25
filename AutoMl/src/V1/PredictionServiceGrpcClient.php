<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\AutoMl\V1;

/**
 * AutoML Prediction API.
 *
 * On any input that is documented to expect a string parameter in
 * snake_case or kebab-case, either of those cases is accepted.
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
     * Perform an online prediction. The prediction result will be directly
     * returned in the response.
     * Available for following ML problems, and their expected request payloads:
     * * Translation - TextSnippet, content up to 25,000 characters, UTF-8
     *                 encoded.
     * @param \Google\Cloud\AutoMl\V1\PredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Predict(\Google\Cloud\AutoMl\V1\PredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.PredictionService/Predict',
        $argument,
        ['\Google\Cloud\AutoMl\V1\PredictResponse', 'decode'],
        $metadata, $options);
    }

}
