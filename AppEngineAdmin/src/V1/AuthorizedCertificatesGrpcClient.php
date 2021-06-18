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
namespace Google\Cloud\AppEngine\V1;

/**
 * Manages SSL certificates a user is authorized to administer. A user can
 * administer any SSL certificates applicable to their authorized domains.
 */
class AuthorizedCertificatesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all SSL certificates the user is authorized to administer.
     * @param \Google\Cloud\AppEngine\V1\ListAuthorizedCertificatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAuthorizedCertificates(\Google\Cloud\AppEngine\V1\ListAuthorizedCertificatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.AuthorizedCertificates/ListAuthorizedCertificates',
        $argument,
        ['\Google\Cloud\AppEngine\V1\ListAuthorizedCertificatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the specified SSL certificate.
     * @param \Google\Cloud\AppEngine\V1\GetAuthorizedCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAuthorizedCertificate(\Google\Cloud\AppEngine\V1\GetAuthorizedCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.AuthorizedCertificates/GetAuthorizedCertificate',
        $argument,
        ['\Google\Cloud\AppEngine\V1\AuthorizedCertificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Uploads the specified SSL certificate.
     * @param \Google\Cloud\AppEngine\V1\CreateAuthorizedCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAuthorizedCertificate(\Google\Cloud\AppEngine\V1\CreateAuthorizedCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.AuthorizedCertificates/CreateAuthorizedCertificate',
        $argument,
        ['\Google\Cloud\AppEngine\V1\AuthorizedCertificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified SSL certificate. To renew a certificate and maintain
     * its existing domain mappings, update `certificate_data` with a new
     * certificate. The new certificate must be applicable to the same domains as
     * the original certificate. The certificate `display_name` may also be
     * updated.
     * @param \Google\Cloud\AppEngine\V1\UpdateAuthorizedCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAuthorizedCertificate(\Google\Cloud\AppEngine\V1\UpdateAuthorizedCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.AuthorizedCertificates/UpdateAuthorizedCertificate',
        $argument,
        ['\Google\Cloud\AppEngine\V1\AuthorizedCertificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified SSL certificate.
     * @param \Google\Cloud\AppEngine\V1\DeleteAuthorizedCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAuthorizedCertificate(\Google\Cloud\AppEngine\V1\DeleteAuthorizedCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.AuthorizedCertificates/DeleteAuthorizedCertificate',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
