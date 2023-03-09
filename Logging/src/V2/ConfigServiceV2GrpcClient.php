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
namespace Google\Cloud\Logging\V2;

/**
 * Service for configuring sinks used to route log entries.
 */
class ConfigServiceV2GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists log buckets.
     * @param \Google\Cloud\Logging\V2\ListBucketsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBuckets(\Google\Cloud\Logging\V2\ListBucketsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/ListBuckets',
        $argument,
        ['\Google\Cloud\Logging\V2\ListBucketsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a log bucket.
     * @param \Google\Cloud\Logging\V2\GetBucketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBucket(\Google\Cloud\Logging\V2\GetBucketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetBucket',
        $argument,
        ['\Google\Cloud\Logging\V2\LogBucket', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a log bucket that can be used to store log entries. After a bucket
     * has been created, the bucket's location cannot be changed.
     * @param \Google\Cloud\Logging\V2\CreateBucketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBucket(\Google\Cloud\Logging\V2\CreateBucketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/CreateBucket',
        $argument,
        ['\Google\Cloud\Logging\V2\LogBucket', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a log bucket. This method replaces the following fields in the
     * existing bucket with values from the new bucket: `retention_period`
     *
     * If the retention period is decreased and the bucket is locked,
     * `FAILED_PRECONDITION` will be returned.
     *
     * If the bucket has a `lifecycle_state` of `DELETE_REQUESTED`, then
     * `FAILED_PRECONDITION` will be returned.
     *
     * After a bucket has been created, the bucket's location cannot be changed.
     * @param \Google\Cloud\Logging\V2\UpdateBucketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBucket(\Google\Cloud\Logging\V2\UpdateBucketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateBucket',
        $argument,
        ['\Google\Cloud\Logging\V2\LogBucket', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a log bucket.
     *
     * Changes the bucket's `lifecycle_state` to the `DELETE_REQUESTED` state.
     * After 7 days, the bucket will be purged and all log entries in the bucket
     * will be permanently deleted.
     * @param \Google\Cloud\Logging\V2\DeleteBucketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBucket(\Google\Cloud\Logging\V2\DeleteBucketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/DeleteBucket',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeletes a log bucket. A bucket that has been deleted can be undeleted
     * within the grace period of 7 days.
     * @param \Google\Cloud\Logging\V2\UndeleteBucketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteBucket(\Google\Cloud\Logging\V2\UndeleteBucketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UndeleteBucket',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists views on a log bucket.
     * @param \Google\Cloud\Logging\V2\ListViewsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListViews(\Google\Cloud\Logging\V2\ListViewsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/ListViews',
        $argument,
        ['\Google\Cloud\Logging\V2\ListViewsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a view on a log bucket..
     * @param \Google\Cloud\Logging\V2\GetViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetView(\Google\Cloud\Logging\V2\GetViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetView',
        $argument,
        ['\Google\Cloud\Logging\V2\LogView', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a view over log entries in a log bucket. A bucket may contain a
     * maximum of 30 views.
     * @param \Google\Cloud\Logging\V2\CreateViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateView(\Google\Cloud\Logging\V2\CreateViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/CreateView',
        $argument,
        ['\Google\Cloud\Logging\V2\LogView', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a view on a log bucket. This method replaces the following fields
     * in the existing view with values from the new view: `filter`.
     * If an `UNAVAILABLE` error is returned, this indicates that system is not in
     * a state where it can update the view. If this occurs, please try again in a
     * few minutes.
     * @param \Google\Cloud\Logging\V2\UpdateViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateView(\Google\Cloud\Logging\V2\UpdateViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateView',
        $argument,
        ['\Google\Cloud\Logging\V2\LogView', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a view on a log bucket.
     * If an `UNAVAILABLE` error is returned, this indicates that system is not in
     * a state where it can delete the view. If this occurs, please try again in a
     * few minutes.
     * @param \Google\Cloud\Logging\V2\DeleteViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteView(\Google\Cloud\Logging\V2\DeleteViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/DeleteView',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists sinks.
     * @param \Google\Cloud\Logging\V2\ListSinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSinks(\Google\Cloud\Logging\V2\ListSinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/ListSinks',
        $argument,
        ['\Google\Cloud\Logging\V2\ListSinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a sink.
     * @param \Google\Cloud\Logging\V2\GetSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSink(\Google\Cloud\Logging\V2\GetSinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetSink',
        $argument,
        ['\Google\Cloud\Logging\V2\LogSink', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a sink that exports specified log entries to a destination. The
     * export of newly-ingested log entries begins immediately, unless the sink's
     * `writer_identity` is not permitted to write to the destination. A sink can
     * export log entries only from the resource owning the sink.
     * @param \Google\Cloud\Logging\V2\CreateSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSink(\Google\Cloud\Logging\V2\CreateSinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/CreateSink',
        $argument,
        ['\Google\Cloud\Logging\V2\LogSink', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a sink. This method replaces the following fields in the existing
     * sink with values from the new sink: `destination`, and `filter`.
     *
     * The updated sink might also have a new `writer_identity`; see the
     * `unique_writer_identity` field.
     * @param \Google\Cloud\Logging\V2\UpdateSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSink(\Google\Cloud\Logging\V2\UpdateSinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateSink',
        $argument,
        ['\Google\Cloud\Logging\V2\LogSink', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a sink. If the sink has a unique `writer_identity`, then that
     * service account is also deleted.
     * @param \Google\Cloud\Logging\V2\DeleteSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSink(\Google\Cloud\Logging\V2\DeleteSinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/DeleteSink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all the exclusions on the _Default sink in a parent resource.
     * @param \Google\Cloud\Logging\V2\ListExclusionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListExclusions(\Google\Cloud\Logging\V2\ListExclusionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/ListExclusions',
        $argument,
        ['\Google\Cloud\Logging\V2\ListExclusionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the description of an exclusion in the _Default sink.
     * @param \Google\Cloud\Logging\V2\GetExclusionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetExclusion(\Google\Cloud\Logging\V2\GetExclusionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetExclusion',
        $argument,
        ['\Google\Cloud\Logging\V2\LogExclusion', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new exclusion in the _Default sink in a specified parent
     * resource. Only log entries belonging to that resource can be excluded. You
     * can have up to 10 exclusions in a resource.
     * @param \Google\Cloud\Logging\V2\CreateExclusionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateExclusion(\Google\Cloud\Logging\V2\CreateExclusionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/CreateExclusion',
        $argument,
        ['\Google\Cloud\Logging\V2\LogExclusion', 'decode'],
        $metadata, $options);
    }

    /**
     * Changes one or more properties of an existing exclusion in the _Default
     * sink.
     * @param \Google\Cloud\Logging\V2\UpdateExclusionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateExclusion(\Google\Cloud\Logging\V2\UpdateExclusionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateExclusion',
        $argument,
        ['\Google\Cloud\Logging\V2\LogExclusion', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an exclusion in the _Default sink.
     * @param \Google\Cloud\Logging\V2\DeleteExclusionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteExclusion(\Google\Cloud\Logging\V2\DeleteExclusionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/DeleteExclusion',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the Logging CMEK settings for the given resource.
     *
     * Note: CMEK for the Log Router can be configured for Google Cloud projects,
     * folders, organizations and billing accounts. Once configured for an
     * organization, it applies to all projects and folders in the Google Cloud
     * organization.
     *
     * See [Enabling CMEK for Log
     * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
     * for more information.
     * @param \Google\Cloud\Logging\V2\GetCmekSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCmekSettings(\Google\Cloud\Logging\V2\GetCmekSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetCmekSettings',
        $argument,
        ['\Google\Cloud\Logging\V2\CmekSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the Log Router CMEK settings for the given resource.
     *
     * Note: CMEK for the Log Router can currently only be configured for Google
     * Cloud organizations. Once configured, it applies to all projects and
     * folders in the Google Cloud organization.
     *
     * [UpdateCmekSettings][google.logging.v2.ConfigServiceV2.UpdateCmekSettings]
     * will fail if 1) `kms_key_name` is invalid, or 2) the associated service
     * account does not have the required
     * `roles/cloudkms.cryptoKeyEncrypterDecrypter` role assigned for the key, or
     * 3) access to the key is disabled.
     *
     * See [Enabling CMEK for Log
     * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
     * for more information.
     * @param \Google\Cloud\Logging\V2\UpdateCmekSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCmekSettings(\Google\Cloud\Logging\V2\UpdateCmekSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateCmekSettings',
        $argument,
        ['\Google\Cloud\Logging\V2\CmekSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the Log Router settings for the given resource.
     *
     * Note: Settings for the Log Router can be get for Google Cloud projects,
     * folders, organizations and billing accounts. Currently it can only be
     * configured for organizations. Once configured for an organization, it
     * applies to all projects and folders in the Google Cloud organization.
     *
     * See [Enabling CMEK for Log
     * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
     * for more information.
     * @param \Google\Cloud\Logging\V2\GetSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSettings(\Google\Cloud\Logging\V2\GetSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetSettings',
        $argument,
        ['\Google\Cloud\Logging\V2\Settings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the Log Router settings for the given resource.
     *
     * Note: Settings for the Log Router can currently only be configured for
     * Google Cloud organizations. Once configured, it applies to all projects and
     * folders in the Google Cloud organization.
     *
     * [UpdateSettings][google.logging.v2.ConfigServiceV2.UpdateSettings]
     * will fail if 1) `kms_key_name` is invalid, or 2) the associated service
     * account does not have the required
     * `roles/cloudkms.cryptoKeyEncrypterDecrypter` role assigned for the key, or
     * 3) access to the key is disabled. 4) `location_id` is not supported by
     * Logging. 5) `location_id` violate OrgPolicy.
     *
     * See [Enabling CMEK for Log
     * Router](https://cloud.google.com/logging/docs/routing/managed-encryption)
     * for more information.
     * @param \Google\Cloud\Logging\V2\UpdateSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSettings(\Google\Cloud\Logging\V2\UpdateSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateSettings',
        $argument,
        ['\Google\Cloud\Logging\V2\Settings', 'decode'],
        $metadata, $options);
    }

    /**
     * Copies a set of log entries from a log bucket to a Cloud Storage bucket.
     * @param \Google\Cloud\Logging\V2\CopyLogEntriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CopyLogEntries(\Google\Cloud\Logging\V2\CopyLogEntriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/CopyLogEntries',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
