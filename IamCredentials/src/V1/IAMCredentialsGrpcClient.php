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
namespace Google\Cloud\Iam\Credentials\V1;

/**
 * A service account is a special type of Google account that belongs to your
 * application or a virtual machine (VM), instead of to an individual end user.
 * Your application assumes the identity of the service account to call Google
 * APIs, so that the users aren't directly involved.
 *
 * Service account credentials are used to temporarily assume the identity
 * of the service account. Supported credential types include OAuth 2.0 access
 * tokens, OpenID Connect ID tokens, self-signed JSON Web Tokens (JWTs), and
 * more.
 */
class IAMCredentialsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Generates an OAuth 2.0 access token for a service account.
     * @param \Google\Cloud\Iam\Credentials\V1\GenerateAccessTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateAccessToken(\Google\Cloud\Iam\Credentials\V1\GenerateAccessTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.credentials.v1.IAMCredentials/GenerateAccessToken',
        $argument,
        ['\Google\Cloud\Iam\Credentials\V1\GenerateAccessTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates an OpenID Connect ID token for a service account.
     * @param \Google\Cloud\Iam\Credentials\V1\GenerateIdTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateIdToken(\Google\Cloud\Iam\Credentials\V1\GenerateIdTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.credentials.v1.IAMCredentials/GenerateIdToken',
        $argument,
        ['\Google\Cloud\Iam\Credentials\V1\GenerateIdTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Signs a blob using a service account's system-managed private key.
     * @param \Google\Cloud\Iam\Credentials\V1\SignBlobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SignBlob(\Google\Cloud\Iam\Credentials\V1\SignBlobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.credentials.v1.IAMCredentials/SignBlob',
        $argument,
        ['\Google\Cloud\Iam\Credentials\V1\SignBlobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Signs a JWT using a service account's system-managed private key.
     * @param \Google\Cloud\Iam\Credentials\V1\SignJwtRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SignJwt(\Google\Cloud\Iam\Credentials\V1\SignJwtRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.credentials.v1.IAMCredentials/SignJwt',
        $argument,
        ['\Google\Cloud\Iam\Credentials\V1\SignJwtResponse', 'decode'],
        $metadata, $options);
    }

}
