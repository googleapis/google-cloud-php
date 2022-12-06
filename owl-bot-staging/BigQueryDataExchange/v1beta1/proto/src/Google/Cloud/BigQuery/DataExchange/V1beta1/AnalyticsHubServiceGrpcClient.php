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
namespace Google\Cloud\BigQuery\DataExchange\V1beta1;

/**
 * The `AnalyticsHubService` API facilitates data sharing within and across
 * organizations. It allows data providers to publish listings that reference
 * shared datasets. With Analytics Hub, users can discover and search for
 * listings that they have access to. Subscribers can view and subscribe to
 * listings. When you subscribe to a listing, Analytics Hub creates a linked
 * dataset in your project.
 */
class AnalyticsHubServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all data exchanges in a given project and location.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\ListDataExchangesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataExchanges(\Google\Cloud\BigQuery\DataExchange\V1beta1\ListDataExchangesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/ListDataExchanges',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\ListDataExchangesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all data exchanges from projects in a given organization and
     * location.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\ListOrgDataExchangesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListOrgDataExchanges(\Google\Cloud\BigQuery\DataExchange\V1beta1\ListOrgDataExchangesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/ListOrgDataExchanges',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\ListOrgDataExchangesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a data exchange.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\GetDataExchangeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataExchange(\Google\Cloud\BigQuery\DataExchange\V1beta1\GetDataExchangeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/GetDataExchange',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\DataExchange', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new data exchange.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\CreateDataExchangeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataExchange(\Google\Cloud\BigQuery\DataExchange\V1beta1\CreateDataExchangeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/CreateDataExchange',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\DataExchange', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing data exchange.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\UpdateDataExchangeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataExchange(\Google\Cloud\BigQuery\DataExchange\V1beta1\UpdateDataExchangeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/UpdateDataExchange',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\DataExchange', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing data exchange.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\DeleteDataExchangeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataExchange(\Google\Cloud\BigQuery\DataExchange\V1beta1\DeleteDataExchangeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/DeleteDataExchange',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all listings in a given project and location.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\ListListingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListListings(\Google\Cloud\BigQuery\DataExchange\V1beta1\ListListingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/ListListings',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\ListListingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a listing.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\GetListingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetListing(\Google\Cloud\BigQuery\DataExchange\V1beta1\GetListingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/GetListing',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\Listing', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new listing.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\CreateListingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateListing(\Google\Cloud\BigQuery\DataExchange\V1beta1\CreateListingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/CreateListing',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\Listing', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing listing.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\UpdateListingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateListing(\Google\Cloud\BigQuery\DataExchange\V1beta1\UpdateListingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/UpdateListing',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\Listing', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a listing.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\DeleteListingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteListing(\Google\Cloud\BigQuery\DataExchange\V1beta1\DeleteListingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/DeleteListing',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Subscribes to a listing.
     *
     * Currently, with Analytics Hub, you can create listings that
     * reference only BigQuery datasets.
     * Upon subscription to a listing for a BigQuery dataset, Analytics Hub
     * creates a linked dataset in the subscriber's project.
     * @param \Google\Cloud\BigQuery\DataExchange\V1beta1\SubscribeListingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SubscribeListing(\Google\Cloud\BigQuery\DataExchange\V1beta1\SubscribeListingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/SubscribeListing',
        $argument,
        ['\Google\Cloud\BigQuery\DataExchange\V1beta1\SubscribeListingResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM policy.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the IAM policy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the permissions that a caller has.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.dataexchange.v1beta1.AnalyticsHubService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
