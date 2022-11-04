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
namespace Google\Cloud\Bigtable\V2;

/**
 * Service for reading from and writing to existing Bigtable tables.
 */
class BigtableGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Streams back the contents of all requested rows in key order, optionally
     * applying the same Reader filter to each. Depending on their size,
     * rows and cells may be broken up across multiple responses, but
     * atomicity of each row will still be preserved. See the
     * ReadRowsResponse documentation for details.
     * @param \Google\Cloud\Bigtable\V2\ReadRowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function ReadRows(\Google\Cloud\Bigtable\V2\ReadRowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.bigtable.v2.Bigtable/ReadRows',
        $argument,
        ['\Google\Cloud\Bigtable\V2\ReadRowsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a sample of row keys in the table. The returned row keys will
     * delimit contiguous sections of the table of approximately equal size,
     * which can be used to break up the data for distributed tasks like
     * mapreduces.
     * @param \Google\Cloud\Bigtable\V2\SampleRowKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function SampleRowKeys(\Google\Cloud\Bigtable\V2\SampleRowKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.bigtable.v2.Bigtable/SampleRowKeys',
        $argument,
        ['\Google\Cloud\Bigtable\V2\SampleRowKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Mutates a row atomically. Cells already present in the row are left
     * unchanged unless explicitly changed by `mutation`.
     * @param \Google\Cloud\Bigtable\V2\MutateRowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MutateRow(\Google\Cloud\Bigtable\V2\MutateRowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.v2.Bigtable/MutateRow',
        $argument,
        ['\Google\Cloud\Bigtable\V2\MutateRowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Mutates multiple rows in a batch. Each individual row is mutated
     * atomically as in MutateRow, but the entire batch is not executed
     * atomically.
     * @param \Google\Cloud\Bigtable\V2\MutateRowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function MutateRows(\Google\Cloud\Bigtable\V2\MutateRowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.bigtable.v2.Bigtable/MutateRows',
        $argument,
        ['\Google\Cloud\Bigtable\V2\MutateRowsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Mutates a row atomically based on the output of a predicate Reader filter.
     * @param \Google\Cloud\Bigtable\V2\CheckAndMutateRowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CheckAndMutateRow(\Google\Cloud\Bigtable\V2\CheckAndMutateRowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.v2.Bigtable/CheckAndMutateRow',
        $argument,
        ['\Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Warm up associated instance metadata for this connection.
     * This call is not required but may be useful for connection keep-alive.
     * @param \Google\Cloud\Bigtable\V2\PingAndWarmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PingAndWarm(\Google\Cloud\Bigtable\V2\PingAndWarmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.v2.Bigtable/PingAndWarm',
        $argument,
        ['\Google\Cloud\Bigtable\V2\PingAndWarmResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies a row atomically on the server. The method reads the latest
     * existing timestamp and value from the specified columns and writes a new
     * entry based on pre-defined read/modify/write rules. The new value for the
     * timestamp is the greater of the existing timestamp or the current server
     * time. The method returns the new contents of all modified cells.
     * @param \Google\Cloud\Bigtable\V2\ReadModifyWriteRowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReadModifyWriteRow(\Google\Cloud\Bigtable\V2\ReadModifyWriteRowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.v2.Bigtable/ReadModifyWriteRow',
        $argument,
        ['\Google\Cloud\Bigtable\V2\ReadModifyWriteRowResponse', 'decode'],
        $metadata, $options);
    }

}
