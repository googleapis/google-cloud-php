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
 * Cloud SQL connect service.
 */
class SqlConnectServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieves connect settings about a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\GetConnectSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnectSettings(\Google\Cloud\Sql\V1beta4\GetConnectSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlConnectService/GetConnectSettings',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\ConnectSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates a short-lived X509 certificate containing the provided public key
     * and signed by a private key specific to the target instance. Users may use
     * the certificate to authenticate as themselves when connecting to the
     * database.
     * @param \Google\Cloud\Sql\V1beta4\GenerateEphemeralCertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateEphemeralCert(\Google\Cloud\Sql\V1beta4\GenerateEphemeralCertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlConnectService/GenerateEphemeralCert',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\GenerateEphemeralCertResponse', 'decode'],
        $metadata, $options);
    }

}
