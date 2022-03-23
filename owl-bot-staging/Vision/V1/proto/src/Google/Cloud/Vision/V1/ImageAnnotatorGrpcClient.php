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
namespace Google\Cloud\Vision\V1;

/**
 * Service that performs Google Cloud Vision API detection tasks over client
 * images, such as face, landmark, logo, label, and text detection. The
 * ImageAnnotator service returns detected entities from the images.
 */
class ImageAnnotatorGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Run image detection and annotation for a batch of images.
     * @param \Google\Cloud\Vision\V1\BatchAnnotateImagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchAnnotateImages(\Google\Cloud\Vision\V1\BatchAnnotateImagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ImageAnnotator/BatchAnnotateImages',
        $argument,
        ['\Google\Cloud\Vision\V1\BatchAnnotateImagesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Service that performs image detection and annotation for a batch of files.
     * Now only "application/pdf", "image/tiff" and "image/gif" are supported.
     *
     * This service will extract at most 5 (customers can specify which 5 in
     * AnnotateFileRequest.pages) frames (gif) or pages (pdf or tiff) from each
     * file provided and perform detection and annotation for each image
     * extracted.
     * @param \Google\Cloud\Vision\V1\BatchAnnotateFilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchAnnotateFiles(\Google\Cloud\Vision\V1\BatchAnnotateFilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ImageAnnotator/BatchAnnotateFiles',
        $argument,
        ['\Google\Cloud\Vision\V1\BatchAnnotateFilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Run asynchronous image detection and annotation for a list of images.
     *
     * Progress and results can be retrieved through the
     * `google.longrunning.Operations` interface.
     * `Operation.metadata` contains `OperationMetadata` (metadata).
     * `Operation.response` contains `AsyncBatchAnnotateImagesResponse` (results).
     *
     * This service will write image annotation outputs to json files in customer
     * GCS bucket, each json file containing BatchAnnotateImagesResponse proto.
     * @param \Google\Cloud\Vision\V1\AsyncBatchAnnotateImagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AsyncBatchAnnotateImages(\Google\Cloud\Vision\V1\AsyncBatchAnnotateImagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ImageAnnotator/AsyncBatchAnnotateImages',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Run asynchronous image detection and annotation for a list of generic
     * files, such as PDF files, which may contain multiple pages and multiple
     * images per page. Progress and results can be retrieved through the
     * `google.longrunning.Operations` interface.
     * `Operation.metadata` contains `OperationMetadata` (metadata).
     * `Operation.response` contains `AsyncBatchAnnotateFilesResponse` (results).
     * @param \Google\Cloud\Vision\V1\AsyncBatchAnnotateFilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AsyncBatchAnnotateFiles(\Google\Cloud\Vision\V1\AsyncBatchAnnotateFilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ImageAnnotator/AsyncBatchAnnotateFiles',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
