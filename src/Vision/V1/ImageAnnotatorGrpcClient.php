<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2016 Google Inc.
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
     */
    public function BatchAnnotateImages(\Google\Cloud\Vision\V1\BatchAnnotateImagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ImageAnnotator/BatchAnnotateImages',
        $argument,
        ['\Google\Cloud\Vision\V1\BatchAnnotateImagesResponse', 'decode'],
        $metadata, $options);
    }

}
