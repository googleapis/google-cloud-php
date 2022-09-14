<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\Dataflow\V1beta3;

/**
 * The Dataflow Messages API is used for monitoring the progress of
 * Dataflow jobs.
 */
class MessagesV1Beta3GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Request the job status.
     *
     * To request the status of a job, we recommend using
     * `projects.locations.jobs.messages.list` with a [regional endpoint]
     * (https://cloud.google.com/dataflow/docs/concepts/regional-endpoints). Using
     * `projects.jobs.messages.list` is not recommended, as you can only request
     * the status of jobs that are running in `us-central1`.
     * @param \Google\Cloud\Dataflow\V1beta3\ListJobMessagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobMessages(\Google\Cloud\Dataflow\V1beta3\ListJobMessagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.MessagesV1Beta3/ListJobMessages',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\ListJobMessagesResponse', 'decode'],
        $metadata, $options);
    }

}
