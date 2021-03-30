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
namespace Google\Cloud\BigQuery\Storage\V1;

/**
 * BigQuery Read API.
 *
 * The Read API can be used to read data from BigQuery.
 */
class BigQueryReadGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new read session. A read session divides the contents of a
     * BigQuery table into one or more streams, which can then be used to read
     * data from the table. The read session also specifies properties of the
     * data to be read, such as a list of columns or a push-down filter describing
     * the rows to be returned.
     *
     * A particular row can be read by at most one stream. When the caller has
     * reached the end of each stream in the session, then all the data in the
     * table has been read.
     *
     * Data is assigned to each stream such that roughly the same number of
     * rows can be read from each stream. Because the server-side unit for
     * assigning data is collections of rows, the API does not guarantee that
     * each stream will return the same number or rows. Additionally, the
     * limits are enforced based on the number of pre-filtered rows, so some
     * filters can lead to lopsided assignments.
     *
     * Read sessions automatically expire 24 hours after they are created and do
     * not require manual clean-up by the caller.
     * @param \Google\Cloud\BigQuery\Storage\V1\CreateReadSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateReadSession(\Google\Cloud\BigQuery\Storage\V1\CreateReadSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.storage.v1.BigQueryRead/CreateReadSession',
        $argument,
        ['\Google\Cloud\BigQuery\Storage\V1\ReadSession', 'decode'],
        $metadata, $options);
    }

    /**
     * Reads rows from the stream in the format prescribed by the ReadSession.
     * Each response contains one or more table rows, up to a maximum of 100 MiB
     * per response; read requests which attempt to read individual rows larger
     * than 100 MiB will fail.
     *
     * Each request also returns a set of stream statistics reflecting the current
     * state of the stream.
     * @param \Google\Cloud\BigQuery\Storage\V1\ReadRowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function ReadRows(\Google\Cloud\BigQuery\Storage\V1\ReadRowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.cloud.bigquery.storage.v1.BigQueryRead/ReadRows',
        $argument,
        ['\Google\Cloud\BigQuery\Storage\V1\ReadRowsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Splits a given `ReadStream` into two `ReadStream` objects. These
     * `ReadStream` objects are referred to as the primary and the residual
     * streams of the split. The original `ReadStream` can still be read from in
     * the same manner as before. Both of the returned `ReadStream` objects can
     * also be read from, and the rows returned by both child streams will be
     * the same as the rows read from the original stream.
     *
     * Moreover, the two child streams will be allocated back-to-back in the
     * original `ReadStream`. Concretely, it is guaranteed that for streams
     * original, primary, and residual, that original[0-j] = primary[0-j] and
     * original[j-n] = residual[0-m] once the streams have been read to
     * completion.
     * @param \Google\Cloud\BigQuery\Storage\V1\SplitReadStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SplitReadStream(\Google\Cloud\BigQuery\Storage\V1\SplitReadStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.storage.v1.BigQueryRead/SplitReadStream',
        $argument,
        ['\Google\Cloud\BigQuery\Storage\V1\SplitReadStreamResponse', 'decode'],
        $metadata, $options);
    }

}
