<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC
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
namespace Google\Cloud\AutoMl\V1beta1;

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
     * * Image Classification - Image in .JPEG, .GIF or .PNG format, image_bytes
     *                          up to 30MB.
     * * Image Object Detection - Image in .JPEG, .GIF or .PNG format, image_bytes
     *                            up to 30MB.
     * * Text Classification - TextSnippet, content up to 60,000 characters,
     *                         UTF-8 encoded.
     * * Text Extraction - TextSnippet, content up to 30,000 characters,
     *                     UTF-8 NFC encoded.
     * * Translation - TextSnippet, content up to 25,000 characters, UTF-8
     *                 encoded.
     * * Tables - Row, with column values matching the columns of the model,
     *            up to 5MB. Not available for FORECASTING
     *
     * [prediction_type][google.cloud.automl.v1beta1.TablesModelMetadata.prediction_type].
     * * Text Sentiment - TextSnippet, content up 500 characters, UTF-8
     *                     encoded.
     * @param \Google\Cloud\AutoMl\V1beta1\PredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Predict(\Google\Cloud\AutoMl\V1beta1\PredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1beta1.PredictionService/Predict',
        $argument,
        ['\Google\Cloud\AutoMl\V1beta1\PredictResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Perform a batch prediction. Unlike the online [Predict][google.cloud.automl.v1beta1.PredictionService.Predict], batch
     * prediction result won't be immediately available in the response. Instead,
     * a long running operation object is returned. User can poll the operation
     * result via [GetOperation][google.longrunning.Operations.GetOperation]
     * method. Once the operation is done, [BatchPredictResult][google.cloud.automl.v1beta1.BatchPredictResult] is returned in
     * the [response][google.longrunning.Operation.response] field.
     * Available for following ML problems:
     * * Image Classification
     * * Image Object Detection
     * * Video Classification
     * * Video Object Tracking * Text Extraction
     * * Tables
     * @param \Google\Cloud\AutoMl\V1beta1\BatchPredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchPredict(\Google\Cloud\AutoMl\V1beta1\BatchPredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1beta1.PredictionService/BatchPredict',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
