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
namespace Google\Cloud\ErrorReporting\V1beta1;

/**
 * An API for reporting error events.
 */
class ReportErrorsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Report an individual error event and record the event to a log.
     *
     * This endpoint accepts **either** an OAuth token,
     * **or** an [API key](https://support.google.com/cloud/answer/6158862)
     * for authentication. To use an API key, append it to the URL as the value of
     * a `key` parameter. For example:
     *
     * `POST
     * https://clouderrorreporting.googleapis.com/v1beta1/{projectName}/events:report?key=123ABC456`
     *
     * **Note:** [Error Reporting](https://cloud.google.com/error-reporting) is a global service built
     * on Cloud Logging and doesn't analyze logs stored
     * in regional log buckets or logs routed to other Google Cloud projects.
     *
     * For more information, see
     * [Using Error Reporting with regionalized
     * logs](https://cloud.google.com/error-reporting/docs/regionalization).
     * @param \Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReportErrorEvent(\Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouderrorreporting.v1beta1.ReportErrorsService/ReportErrorEvent',
        $argument,
        ['\Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventResponse', 'decode'],
        $metadata, $options);
    }

}
