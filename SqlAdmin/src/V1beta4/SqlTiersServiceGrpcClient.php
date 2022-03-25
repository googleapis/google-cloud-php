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
namespace Google\Cloud\Sql\V1beta4;

/**
 * LINT: LEGACY_NAMES
 *
 * Service for providing machine types (tiers) for Cloud SQL.
 */
class SqlTiersServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all available machine types (tiers) for Cloud SQL, for example,
     * `db-custom-1-3840`. For related information, see [Pricing](https://cloud.google.com/sql/pricing).
     * @param \Google\Cloud\Sql\V1beta4\SqlTiersListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Google\Cloud\Sql\V1beta4\SqlTiersListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlTiersService/List',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\TiersListResponse', 'decode'],
        $metadata, $options);
    }

}
