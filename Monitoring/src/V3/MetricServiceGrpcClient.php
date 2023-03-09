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
namespace Google\Cloud\Monitoring\V3;

/**
 * Manages metric descriptors, monitored resource descriptors, and
 * time series data.
 */
class MetricServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists monitored resource descriptors that match a filter. This method does not require a Workspace.
     * @param \Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMonitoredResourceDescriptors(\Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/ListMonitoredResourceDescriptors',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single monitored resource descriptor. This method does not require a Workspace.
     * @param \Google\Cloud\Monitoring\V3\GetMonitoredResourceDescriptorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMonitoredResourceDescriptor(\Google\Cloud\Monitoring\V3\GetMonitoredResourceDescriptorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/GetMonitoredResourceDescriptor',
        $argument,
        ['\Google\Api\MonitoredResourceDescriptor', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists metric descriptors that match a filter. This method does not require a Workspace.
     * @param \Google\Cloud\Monitoring\V3\ListMetricDescriptorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMetricDescriptors(\Google\Cloud\Monitoring\V3\ListMetricDescriptorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/ListMetricDescriptors',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListMetricDescriptorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single metric descriptor. This method does not require a Workspace.
     * @param \Google\Cloud\Monitoring\V3\GetMetricDescriptorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMetricDescriptor(\Google\Cloud\Monitoring\V3\GetMetricDescriptorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/GetMetricDescriptor',
        $argument,
        ['\Google\Api\MetricDescriptor', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new metric descriptor.
     * The creation is executed asynchronously and callers may check the returned
     * operation to track its progress.
     * User-created metric descriptors define
     * [custom metrics](https://cloud.google.com/monitoring/custom-metrics).
     * @param \Google\Cloud\Monitoring\V3\CreateMetricDescriptorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMetricDescriptor(\Google\Cloud\Monitoring\V3\CreateMetricDescriptorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/CreateMetricDescriptor',
        $argument,
        ['\Google\Api\MetricDescriptor', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a metric descriptor. Only user-created
     * [custom metrics](https://cloud.google.com/monitoring/custom-metrics) can be
     * deleted.
     * @param \Google\Cloud\Monitoring\V3\DeleteMetricDescriptorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMetricDescriptor(\Google\Cloud\Monitoring\V3\DeleteMetricDescriptorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/DeleteMetricDescriptor',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists time series that match a filter. This method does not require a Workspace.
     * @param \Google\Cloud\Monitoring\V3\ListTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTimeSeries(\Google\Cloud\Monitoring\V3\ListTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/ListTimeSeries',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListTimeSeriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates or adds data to one or more time series.
     * The response is empty if all time series in the request were written.
     * If any time series could not be written, a corresponding failure message is
     * included in the error response.
     * @param \Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTimeSeries(\Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/CreateTimeSeries',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates or adds data to one or more service time series. A service time
     * series is a time series for a metric from a Google Cloud service. The
     * response is empty if all time series in the request were written. If any
     * time series could not be written, a corresponding failure message is
     * included in the error response. This endpoint rejects writes to
     * user-defined metrics.
     * This method is only for use by Google Cloud services. Use
     * [projects.timeSeries.create][google.monitoring.v3.MetricService.CreateTimeSeries]
     * instead.
     * @param \Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServiceTimeSeries(\Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.MetricService/CreateServiceTimeSeries',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
