<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\Support\V2;

/**
 * A service to manage comments on cases.
 */
class CommentServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieve all Comments associated with the Case object.
     * @param \Google\Cloud\Support\V2\ListCommentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListComments(\Google\Cloud\Support\V2\ListCommentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CommentService/ListComments',
        $argument,
        ['\Google\Cloud\Support\V2\ListCommentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Add a new comment to the specified Case.
     * The comment object must have the following fields set: body.
     * @param \Google\Cloud\Support\V2\CreateCommentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateComment(\Google\Cloud\Support\V2\CreateCommentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CommentService/CreateComment',
        $argument,
        ['\Google\Cloud\Support\V2\Comment', 'decode'],
        $metadata, $options);
    }

}
