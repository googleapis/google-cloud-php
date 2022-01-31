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
namespace Google\Cloud\Monitoring\V3;

/**
 * The QueryService API is used to manage time series data in Stackdriver
 * Monitoring. Time series data is a collection of data points that describes
 * the time-varying values of a metric.
 */
class QueryServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Queries time series using Monitoring Query Language. This method does not require a Workspace.
     * @param \Google\Cloud\Monitoring\V3\QueryTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryTimeSeries(\Google\Cloud\Monitoring\V3\QueryTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.QueryService/QueryTimeSeries',
        $argument,
        ['\Google\Cloud\Monitoring\V3\QueryTimeSeriesResponse', 'decode'],
        $metadata, $options);
    }

}
