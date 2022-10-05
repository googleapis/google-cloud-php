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
namespace Google\Cloud\Asset\V1;

/**
 * Asset service definition.
 */
class AssetServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Exports assets with time and resource types to a given Cloud Storage
     * location/BigQuery table. For Cloud Storage location destinations, the
     * output format is newline-delimited JSON. Each line represents a
     * [google.cloud.asset.v1.Asset][google.cloud.asset.v1.Asset] in the JSON format; for BigQuery table
     * destinations, the output table stores the fields in asset Protobuf as
     * columns. This API implements the [google.longrunning.Operation][google.longrunning.Operation] API,
     * which allows you to keep track of the export. We recommend intervals of at
     * least 2 seconds with exponential retry to poll the export operation result.
     * For regular-size resource parent, the export operation usually finishes
     * within 5 minutes.
     * @param \Google\Cloud\Asset\V1\ExportAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportAssets(\Google\Cloud\Asset\V1\ExportAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/ExportAssets',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists assets with time and resource types and returns paged results in
     * response.
     * @param \Google\Cloud\Asset\V1\ListAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAssets(\Google\Cloud\Asset\V1\ListAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/ListAssets',
        $argument,
        ['\Google\Cloud\Asset\V1\ListAssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Batch gets the update history of assets that overlap a time window.
     * For IAM_POLICY content, this API outputs history when the asset and its
     * attached IAM POLICY both exist. This can create gaps in the output history.
     * Otherwise, this API outputs history with asset in both non-delete or
     * deleted status.
     * If a specified asset does not exist, this API returns an INVALID_ARGUMENT
     * error.
     * @param \Google\Cloud\Asset\V1\BatchGetAssetsHistoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchGetAssetsHistory(\Google\Cloud\Asset\V1\BatchGetAssetsHistoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/BatchGetAssetsHistory',
        $argument,
        ['\Google\Cloud\Asset\V1\BatchGetAssetsHistoryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a feed in a parent project/folder/organization to listen to its
     * asset updates.
     * @param \Google\Cloud\Asset\V1\CreateFeedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFeed(\Google\Cloud\Asset\V1\CreateFeedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/CreateFeed',
        $argument,
        ['\Google\Cloud\Asset\V1\Feed', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details about an asset feed.
     * @param \Google\Cloud\Asset\V1\GetFeedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFeed(\Google\Cloud\Asset\V1\GetFeedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/GetFeed',
        $argument,
        ['\Google\Cloud\Asset\V1\Feed', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all asset feeds in a parent project/folder/organization.
     * @param \Google\Cloud\Asset\V1\ListFeedsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFeeds(\Google\Cloud\Asset\V1\ListFeedsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/ListFeeds',
        $argument,
        ['\Google\Cloud\Asset\V1\ListFeedsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an asset feed configuration.
     * @param \Google\Cloud\Asset\V1\UpdateFeedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFeed(\Google\Cloud\Asset\V1\UpdateFeedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/UpdateFeed',
        $argument,
        ['\Google\Cloud\Asset\V1\Feed', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an asset feed.
     * @param \Google\Cloud\Asset\V1\DeleteFeedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFeed(\Google\Cloud\Asset\V1\DeleteFeedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/DeleteFeed',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches all Cloud resources within the specified scope, such as a project,
     * folder, or organization. The caller must be granted the
     * `cloudasset.assets.searchAllResources` permission on the desired scope,
     * otherwise the request will be rejected.
     * @param \Google\Cloud\Asset\V1\SearchAllResourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchAllResources(\Google\Cloud\Asset\V1\SearchAllResourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/SearchAllResources',
        $argument,
        ['\Google\Cloud\Asset\V1\SearchAllResourcesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches all IAM policies within the specified scope, such as a project,
     * folder, or organization. The caller must be granted the
     * `cloudasset.assets.searchAllIamPolicies` permission on the desired scope,
     * otherwise the request will be rejected.
     * @param \Google\Cloud\Asset\V1\SearchAllIamPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchAllIamPolicies(\Google\Cloud\Asset\V1\SearchAllIamPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/SearchAllIamPolicies',
        $argument,
        ['\Google\Cloud\Asset\V1\SearchAllIamPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Analyzes IAM policies to answer which identities have what accesses on
     * which resources.
     * @param \Google\Cloud\Asset\V1\AnalyzeIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AnalyzeIamPolicy(\Google\Cloud\Asset\V1\AnalyzeIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/AnalyzeIamPolicy',
        $argument,
        ['\Google\Cloud\Asset\V1\AnalyzeIamPolicyResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Analyzes IAM policies asynchronously to answer which identities have what
     * accesses on which resources, and writes the analysis results to a Google
     * Cloud Storage or a BigQuery destination. For Cloud Storage destination, the
     * output format is the JSON format that represents a
     * [AnalyzeIamPolicyResponse][google.cloud.asset.v1.AnalyzeIamPolicyResponse]. This method implements the
     * [google.longrunning.Operation][google.longrunning.Operation], which allows you to track the operation
     * status. We recommend intervals of at least 2 seconds with exponential
     * backoff retry to poll the operation result. The metadata contains the
     * metadata for the long-running operation.
     * @param \Google\Cloud\Asset\V1\AnalyzeIamPolicyLongrunningRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AnalyzeIamPolicyLongrunning(\Google\Cloud\Asset\V1\AnalyzeIamPolicyLongrunningRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/AnalyzeIamPolicyLongrunning',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Analyze moving a resource to a specified destination without kicking off
     * the actual move. The analysis is best effort depending on the user's
     * permissions of viewing different hierarchical policies and configurations.
     * The policies and configuration are subject to change before the actual
     * resource migration takes place.
     * @param \Google\Cloud\Asset\V1\AnalyzeMoveRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AnalyzeMove(\Google\Cloud\Asset\V1\AnalyzeMoveRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/AnalyzeMove',
        $argument,
        ['\Google\Cloud\Asset\V1\AnalyzeMoveResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Issue a job that queries assets using a SQL statement compatible with
     * [BigQuery Standard
     * SQL](http://cloud/bigquery/docs/reference/standard-sql/enabling-standard-sql).
     *
     * If the query execution finishes within timeout and there's no pagination,
     * the full query results will be returned in the `QueryAssetsResponse`.
     *
     * Otherwise, full query results can be obtained by issuing extra requests
     * with the `job_reference` from the a previous `QueryAssets` call.
     *
     * Note, the query result has approximately 10 GB limitation enforced by
     * BigQuery
     * https://cloud.google.com/bigquery/docs/best-practices-performance-output,
     * queries return larger results will result in errors.
     * @param \Google\Cloud\Asset\V1\QueryAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryAssets(\Google\Cloud\Asset\V1\QueryAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/QueryAssets',
        $argument,
        ['\Google\Cloud\Asset\V1\QueryAssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a saved query in a parent project/folder/organization.
     * @param \Google\Cloud\Asset\V1\CreateSavedQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSavedQuery(\Google\Cloud\Asset\V1\CreateSavedQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/CreateSavedQuery',
        $argument,
        ['\Google\Cloud\Asset\V1\SavedQuery', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details about a saved query.
     * @param \Google\Cloud\Asset\V1\GetSavedQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSavedQuery(\Google\Cloud\Asset\V1\GetSavedQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/GetSavedQuery',
        $argument,
        ['\Google\Cloud\Asset\V1\SavedQuery', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all saved queries in a parent project/folder/organization.
     * @param \Google\Cloud\Asset\V1\ListSavedQueriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSavedQueries(\Google\Cloud\Asset\V1\ListSavedQueriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/ListSavedQueries',
        $argument,
        ['\Google\Cloud\Asset\V1\ListSavedQueriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a saved query.
     * @param \Google\Cloud\Asset\V1\UpdateSavedQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSavedQuery(\Google\Cloud\Asset\V1\UpdateSavedQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/UpdateSavedQuery',
        $argument,
        ['\Google\Cloud\Asset\V1\SavedQuery', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a saved query.
     * @param \Google\Cloud\Asset\V1\DeleteSavedQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSavedQuery(\Google\Cloud\Asset\V1\DeleteSavedQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/DeleteSavedQuery',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets effective IAM policies for a batch of resources.
     * @param \Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchGetEffectiveIamPolicies(\Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1.AssetService/BatchGetEffectiveIamPolicies',
        $argument,
        ['\Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesResponse', 'decode'],
        $metadata, $options);
    }

}
