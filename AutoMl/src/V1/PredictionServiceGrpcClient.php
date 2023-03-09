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
namespace Google\Cloud\AutoMl\V1;

/**
 * AutoML Prediction API.
 *
 * On any input that is documented to expect a string parameter in
 * snake_case or dash-case, either of those cases is accepted.
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
     * Perform an online prediction. The prediction result is directly
     * returned in the response.
     * Available for following ML scenarios, and their expected request payloads:
     *
     * AutoML Vision Classification
     *
     * * An image in .JPEG, .GIF or .PNG format, image_bytes up to 30MB.
     *
     * AutoML Vision Object Detection
     *
     * * An image in .JPEG, .GIF or .PNG format, image_bytes up to 30MB.
     *
     * AutoML Natural Language Classification
     *
     * * A TextSnippet up to 60,000 characters, UTF-8 encoded or a document in
     * .PDF, .TIF or .TIFF format with size upto 2MB.
     *
     * AutoML Natural Language Entity Extraction
     *
     * * A TextSnippet up to 10,000 characters, UTF-8 NFC encoded or a document
     *  in .PDF, .TIF or .TIFF format with size upto 20MB.
     *
     * AutoML Natural Language Sentiment Analysis
     *
     * * A TextSnippet up to 60,000 characters, UTF-8 encoded or a document in
     * .PDF, .TIF or .TIFF format with size upto 2MB.
     *
     * AutoML Translation
     *
     * * A TextSnippet up to 25,000 characters, UTF-8 encoded.
     *
     * AutoML Tables
     *
     * * A row with column values matching
     *   the columns of the model, up to 5MB. Not available for FORECASTING
     *   `prediction_type`.
     * @param \Google\Cloud\AutoMl\V1\PredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Predict(\Google\Cloud\AutoMl\V1\PredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.PredictionService/Predict',
        $argument,
        ['\Google\Cloud\AutoMl\V1\PredictResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Perform a batch prediction. Unlike the online [Predict][google.cloud.automl.v1.PredictionService.Predict], batch
     * prediction result won't be immediately available in the response. Instead,
     * a long running operation object is returned. User can poll the operation
     * result via [GetOperation][google.longrunning.Operations.GetOperation]
     * method. Once the operation is done, [BatchPredictResult][google.cloud.automl.v1.BatchPredictResult] is returned in
     * the [response][google.longrunning.Operation.response] field.
     * Available for following ML scenarios:
     *
     * * AutoML Vision Classification
     * * AutoML Vision Object Detection
     * * AutoML Video Intelligence Classification
     * * AutoML Video Intelligence Object Tracking * AutoML Natural Language Classification
     * * AutoML Natural Language Entity Extraction
     * * AutoML Natural Language Sentiment Analysis
     * * AutoML Tables
     * @param \Google\Cloud\AutoMl\V1\BatchPredictRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchPredict(\Google\Cloud\AutoMl\V1\BatchPredictRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.PredictionService/BatchPredict',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
