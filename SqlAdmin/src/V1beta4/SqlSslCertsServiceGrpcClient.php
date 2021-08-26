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
 */
class SqlSslCertsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Deletes the SSL certificate. For First Generation instances, the
     * certificate remains valid until the instance is restarted.
     * @param \Google\Cloud\Sql\V1beta4\SqlSslCertsDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Google\Cloud\Sql\V1beta4\SqlSslCertsDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlSslCertsService/Delete',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a particular SSL certificate.  Does not include the private key
     * (required for usage).  The private key must be saved from the response to
     * initial creation.
     * @param \Google\Cloud\Sql\V1beta4\SqlSslCertsGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Google\Cloud\Sql\V1beta4\SqlSslCertsGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlSslCertsService/Get',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\SslCert', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an SSL certificate and returns it along with the private key and
     * server certificate authority.  The new certificate will not be usable until
     * the instance is restarted.
     * @param \Google\Cloud\Sql\V1beta4\SqlSslCertsInsertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Insert(\Google\Cloud\Sql\V1beta4\SqlSslCertsInsertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlSslCertsService/Insert',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\SslCertsInsertResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all of the current SSL certificates for the instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlSslCertsListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Google\Cloud\Sql\V1beta4\SqlSslCertsListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlSslCertsService/List',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\SslCertsListResponse', 'decode'],
        $metadata, $options);
    }

}
