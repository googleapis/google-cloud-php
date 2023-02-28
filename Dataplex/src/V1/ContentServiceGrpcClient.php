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
namespace Google\Cloud\Dataplex\V1;

/**
 * ContentService manages Notebook and SQL Scripts for Dataplex.
 */
class ContentServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a content.
     * @param \Google\Cloud\Dataplex\V1\CreateContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateContent(\Google\Cloud\Dataplex\V1\CreateContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/CreateContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Content', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a content. Only supports full resource update.
     * @param \Google\Cloud\Dataplex\V1\UpdateContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateContent(\Google\Cloud\Dataplex\V1\UpdateContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/UpdateContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Content', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a content.
     * @param \Google\Cloud\Dataplex\V1\DeleteContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteContent(\Google\Cloud\Dataplex\V1\DeleteContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/DeleteContent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a content resource.
     * @param \Google\Cloud\Dataplex\V1\GetContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetContent(\Google\Cloud\Dataplex\V1\GetContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/GetContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Content', 'decode'],
        $metadata, $options);
    }

    /**
     * List content.
     * @param \Google\Cloud\Dataplex\V1\ListContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListContent(\Google\Cloud\Dataplex\V1\ListContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/ListContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListContentResponse', 'decode'],
        $metadata, $options);
    }

}
