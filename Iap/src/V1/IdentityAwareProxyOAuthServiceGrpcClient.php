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
namespace Google\Cloud\Iap\V1;

/**
 * API to programmatically create, list and retrieve Identity Aware Proxy (IAP)
 * OAuth brands; and create, retrieve, delete and reset-secret of IAP OAuth
 * clients.
 */
class IdentityAwareProxyOAuthServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the existing brands for the project.
     * @param \Google\Cloud\Iap\V1\ListBrandsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBrands(\Google\Cloud\Iap\V1\ListBrandsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/ListBrands',
        $argument,
        ['\Google\Cloud\Iap\V1\ListBrandsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Constructs a new OAuth brand for the project if one does not exist.
     * The created brand is "internal only", meaning that OAuth clients created
     * under it only accept requests from users who belong to the same Google
     * Workspace organization as the project. The brand is created in an
     * un-reviewed status. NOTE: The "internal only" status can be manually
     * changed in the Google Cloud Console. Requires that a brand does not already
     * exist for the project, and that the specified support email is owned by the
     * caller.
     * @param \Google\Cloud\Iap\V1\CreateBrandRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBrand(\Google\Cloud\Iap\V1\CreateBrandRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/CreateBrand',
        $argument,
        ['\Google\Cloud\Iap\V1\Brand', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the OAuth brand of the project.
     * @param \Google\Cloud\Iap\V1\GetBrandRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBrand(\Google\Cloud\Iap\V1\GetBrandRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/GetBrand',
        $argument,
        ['\Google\Cloud\Iap\V1\Brand', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an Identity Aware Proxy (IAP) OAuth client. The client is owned
     * by IAP. Requires that the brand for the project exists and that it is
     * set for internal-only use.
     * @param \Google\Cloud\Iap\V1\CreateIdentityAwareProxyClientRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateIdentityAwareProxyClient(\Google\Cloud\Iap\V1\CreateIdentityAwareProxyClientRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/CreateIdentityAwareProxyClient',
        $argument,
        ['\Google\Cloud\Iap\V1\IdentityAwareProxyClient', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the existing clients for the brand.
     * @param \Google\Cloud\Iap\V1\ListIdentityAwareProxyClientsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIdentityAwareProxyClients(\Google\Cloud\Iap\V1\ListIdentityAwareProxyClientsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/ListIdentityAwareProxyClients',
        $argument,
        ['\Google\Cloud\Iap\V1\ListIdentityAwareProxyClientsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves an Identity Aware Proxy (IAP) OAuth client.
     * Requires that the client is owned by IAP.
     * @param \Google\Cloud\Iap\V1\GetIdentityAwareProxyClientRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIdentityAwareProxyClient(\Google\Cloud\Iap\V1\GetIdentityAwareProxyClientRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/GetIdentityAwareProxyClient',
        $argument,
        ['\Google\Cloud\Iap\V1\IdentityAwareProxyClient', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets an Identity Aware Proxy (IAP) OAuth client secret. Useful if the
     * secret was compromised. Requires that the client is owned by IAP.
     * @param \Google\Cloud\Iap\V1\ResetIdentityAwareProxyClientSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetIdentityAwareProxyClientSecret(\Google\Cloud\Iap\V1\ResetIdentityAwareProxyClientSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/ResetIdentityAwareProxyClientSecret',
        $argument,
        ['\Google\Cloud\Iap\V1\IdentityAwareProxyClient', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Identity Aware Proxy (IAP) OAuth client. Useful for removing
     * obsolete clients, managing the number of clients in a given project, and
     * cleaning up after tests. Requires that the client is owned by IAP.
     * @param \Google\Cloud\Iap\V1\DeleteIdentityAwareProxyClientRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIdentityAwareProxyClient(\Google\Cloud\Iap\V1\DeleteIdentityAwareProxyClientRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyOAuthService/DeleteIdentityAwareProxyClient',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
