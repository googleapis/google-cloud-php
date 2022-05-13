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
namespace Google\Cloud\Optimization\V1;

/**
 * A service for optimizing vehicle tours.
 *
 * Validity of certain types of fields:
 *
 *   * `google.protobuf.Timestamp`
 *     * Times are in Unix time: seconds since 1970-01-01T00:00:00+00:00.
 *     * seconds must be in [0, 253402300799],
 *       i.e. in [1970-01-01T00:00:00+00:00, 9999-12-31T23:59:59+00:00].
 *     * nanos must be unset or set to 0.
 *   * `google.protobuf.Duration`
 *     * seconds must be in [0, 253402300799],
 *       i.e. in [1970-01-01T00:00:00+00:00, 9999-12-31T23:59:59+00:00].
 *     * nanos must be unset or set to 0.
 *   * `google.type.LatLng`
 *     * latitude must be in [-90.0, 90.0].
 *     * longitude must be in [-180.0, 180.0].
 *     * at least one of latitude and longitude must be non-zero.
 */
class FleetRoutingGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Sends an `OptimizeToursRequest` containing a `ShipmentModel` and returns an
     * `OptimizeToursResponse` containing `ShipmentRoute`s, which are a set of
     * routes to be performed by vehicles minimizing the overall cost.
     *
     * A `ShipmentModel` model consists mainly of `Shipment`s that need to be
     * carried out and `Vehicle`s that can be used to transport the `Shipment`s.
     * The `ShipmentRoute`s assign `Shipment`s to `Vehicle`s. More specifically,
     * they assign a series of `Visit`s to each vehicle, where a `Visit`
     * corresponds to a `VisitRequest`, which is a pickup or delivery for a
     * `Shipment`.
     *
     * The goal is to provide an assignment of `ShipmentRoute`s to `Vehicle`s that
     * minimizes the total cost where cost has many components defined in the
     * `ShipmentModel`.
     * @param \Google\Cloud\Optimization\V1\OptimizeToursRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function OptimizeTours(\Google\Cloud\Optimization\V1\OptimizeToursRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.optimization.v1.FleetRouting/OptimizeTours',
        $argument,
        ['\Google\Cloud\Optimization\V1\OptimizeToursResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Optimizes vehicle tours for one or more `OptimizeToursRequest`
     * messages as a batch.
     *
     * This method is a Long Running Operation (LRO). The inputs for optimization
     * (`OptimizeToursRequest` messages) and outputs (`OptimizeToursResponse`
     * messages) are read/written from/to Cloud Storage in user-specified
     * format. Like the `OptimizeTours` method, each `OptimizeToursRequest`
     * contains a `ShipmentModel` and returns an `OptimizeToursResponse`
     * containing `ShipmentRoute`s, which are a set of routes to be performed by
     * vehicles minimizing the overall cost.
     * @param \Google\Cloud\Optimization\V1\BatchOptimizeToursRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchOptimizeTours(\Google\Cloud\Optimization\V1\BatchOptimizeToursRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.optimization.v1.FleetRouting/BatchOptimizeTours',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
