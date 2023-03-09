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
namespace Google\Cloud\SecurityCenter\V1;

/**
 * V1 APIs for Security Center service.
 */
class SecurityCenterGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Kicks off an LRO to bulk mute findings for a parent based on a filter. The
     * parent can be either an organization, folder or project. The findings
     * matched by the filter will be muted after the LRO is done.
     * @param \Google\Cloud\SecurityCenter\V1\BulkMuteFindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BulkMuteFindings(\Google\Cloud\SecurityCenter\V1\BulkMuteFindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/BulkMuteFindings',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a source.
     * @param \Google\Cloud\SecurityCenter\V1\CreateSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSource(\Google\Cloud\SecurityCenter\V1\CreateSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/CreateSource',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Source', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a finding. The corresponding source must exist for finding creation
     * to succeed.
     * @param \Google\Cloud\SecurityCenter\V1\CreateFindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFinding(\Google\Cloud\SecurityCenter\V1\CreateFindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/CreateFinding',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Finding', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a mute config.
     * @param \Google\Cloud\SecurityCenter\V1\CreateMuteConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMuteConfig(\Google\Cloud\SecurityCenter\V1\CreateMuteConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/CreateMuteConfig',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\MuteConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a notification config.
     * @param \Google\Cloud\SecurityCenter\V1\CreateNotificationConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNotificationConfig(\Google\Cloud\SecurityCenter\V1\CreateNotificationConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/CreateNotificationConfig',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\NotificationConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing mute config.
     * @param \Google\Cloud\SecurityCenter\V1\DeleteMuteConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMuteConfig(\Google\Cloud\SecurityCenter\V1\DeleteMuteConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/DeleteMuteConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a notification config.
     * @param \Google\Cloud\SecurityCenter\V1\DeleteNotificationConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteNotificationConfig(\Google\Cloud\SecurityCenter\V1\DeleteNotificationConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/DeleteNotificationConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a BigQuery export.
     * @param \Google\Cloud\SecurityCenter\V1\GetBigQueryExportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBigQueryExport(\Google\Cloud\SecurityCenter\V1\GetBigQueryExportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GetBigQueryExport',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\BigQueryExport', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy on the specified Source.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a mute config.
     * @param \Google\Cloud\SecurityCenter\V1\GetMuteConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMuteConfig(\Google\Cloud\SecurityCenter\V1\GetMuteConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GetMuteConfig',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\MuteConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a notification config.
     * @param \Google\Cloud\SecurityCenter\V1\GetNotificationConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNotificationConfig(\Google\Cloud\SecurityCenter\V1\GetNotificationConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GetNotificationConfig',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\NotificationConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the settings for an organization.
     * @param \Google\Cloud\SecurityCenter\V1\GetOrganizationSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOrganizationSettings(\Google\Cloud\SecurityCenter\V1\GetOrganizationSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GetOrganizationSettings',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\OrganizationSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a source.
     * @param \Google\Cloud\SecurityCenter\V1\GetSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSource(\Google\Cloud\SecurityCenter\V1\GetSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GetSource',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Source', 'decode'],
        $metadata, $options);
    }

    /**
     * Filters an organization's assets and  groups them by their specified
     * properties.
     * @param \Google\Cloud\SecurityCenter\V1\GroupAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GroupAssets(\Google\Cloud\SecurityCenter\V1\GroupAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GroupAssets',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\GroupAssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Filters an organization or source's findings and  groups them by their
     * specified properties.
     *
     * To group across all sources provide a `-` as the source id.
     * Example: /v1/organizations/{organization_id}/sources/-/findings,
     * /v1/folders/{folder_id}/sources/-/findings,
     * /v1/projects/{project_id}/sources/-/findings
     * @param \Google\Cloud\SecurityCenter\V1\GroupFindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GroupFindings(\Google\Cloud\SecurityCenter\V1\GroupFindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/GroupFindings',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\GroupFindingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists an organization's assets.
     * @param \Google\Cloud\SecurityCenter\V1\ListAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAssets(\Google\Cloud\SecurityCenter\V1\ListAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/ListAssets',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ListAssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists an organization or source's findings.
     *
     * To list across all sources provide a `-` as the source id.
     * Example: /v1/organizations/{organization_id}/sources/-/findings
     * @param \Google\Cloud\SecurityCenter\V1\ListFindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFindings(\Google\Cloud\SecurityCenter\V1\ListFindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/ListFindings',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ListFindingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists mute configs.
     * @param \Google\Cloud\SecurityCenter\V1\ListMuteConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMuteConfigs(\Google\Cloud\SecurityCenter\V1\ListMuteConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/ListMuteConfigs',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ListMuteConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists notification configs.
     * @param \Google\Cloud\SecurityCenter\V1\ListNotificationConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNotificationConfigs(\Google\Cloud\SecurityCenter\V1\ListNotificationConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/ListNotificationConfigs',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ListNotificationConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all sources belonging to an organization.
     * @param \Google\Cloud\SecurityCenter\V1\ListSourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSources(\Google\Cloud\SecurityCenter\V1\ListSourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/ListSources',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ListSourcesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Runs asset discovery. The discovery is tracked with a long-running
     * operation.
     *
     * This API can only be called with limited frequency for an organization. If
     * it is called too frequently the caller will receive a TOO_MANY_REQUESTS
     * error.
     * @param \Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunAssetDiscovery(\Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/RunAssetDiscovery',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the state of a finding.
     * @param \Google\Cloud\SecurityCenter\V1\SetFindingStateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetFindingState(\Google\Cloud\SecurityCenter\V1\SetFindingStateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/SetFindingState',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Finding', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the mute state of a finding.
     * @param \Google\Cloud\SecurityCenter\V1\SetMuteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetMute(\Google\Cloud\SecurityCenter\V1\SetMuteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/SetMute',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Finding', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on the specified Source.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the permissions that a caller has on the specified source.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates external system. This is for a given finding.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateExternalSystemRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateExternalSystem(\Google\Cloud\SecurityCenter\V1\UpdateExternalSystemRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateExternalSystem',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ExternalSystem', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates or updates a finding. The corresponding source must exist for a
     * finding creation to succeed.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateFindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFinding(\Google\Cloud\SecurityCenter\V1\UpdateFindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateFinding',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Finding', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a mute config.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateMuteConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMuteConfig(\Google\Cloud\SecurityCenter\V1\UpdateMuteConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateMuteConfig',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\MuteConfig', 'decode'],
        $metadata, $options);
    }

    /**
     *
     * Updates a notification config. The following update
     * fields are allowed: description, pubsub_topic, streaming_config.filter
     * @param \Google\Cloud\SecurityCenter\V1\UpdateNotificationConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNotificationConfig(\Google\Cloud\SecurityCenter\V1\UpdateNotificationConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateNotificationConfig',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\NotificationConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an organization's settings.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateOrganizationSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateOrganizationSettings(\Google\Cloud\SecurityCenter\V1\UpdateOrganizationSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateOrganizationSettings',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\OrganizationSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a source.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSource(\Google\Cloud\SecurityCenter\V1\UpdateSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateSource',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\Source', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates security marks.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateSecurityMarksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSecurityMarks(\Google\Cloud\SecurityCenter\V1\UpdateSecurityMarksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateSecurityMarks',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\SecurityMarks', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a BigQuery export.
     * @param \Google\Cloud\SecurityCenter\V1\CreateBigQueryExportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBigQueryExport(\Google\Cloud\SecurityCenter\V1\CreateBigQueryExportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/CreateBigQueryExport',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\BigQueryExport', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing BigQuery export.
     * @param \Google\Cloud\SecurityCenter\V1\DeleteBigQueryExportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBigQueryExport(\Google\Cloud\SecurityCenter\V1\DeleteBigQueryExportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/DeleteBigQueryExport',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a BigQuery export.
     * @param \Google\Cloud\SecurityCenter\V1\UpdateBigQueryExportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBigQueryExport(\Google\Cloud\SecurityCenter\V1\UpdateBigQueryExportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/UpdateBigQueryExport',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\BigQueryExport', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists BigQuery exports. Note that when requesting BigQuery exports at a
     * given level all exports under that level are also returned e.g. if
     * requesting BigQuery exports under a folder, then all BigQuery exports
     * immediately under the folder plus the ones created under the projects
     * within the folder are returned.
     * @param \Google\Cloud\SecurityCenter\V1\ListBigQueryExportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBigQueryExports(\Google\Cloud\SecurityCenter\V1\ListBigQueryExportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.securitycenter.v1.SecurityCenter/ListBigQueryExports',
        $argument,
        ['\Google\Cloud\SecurityCenter\V1\ListBigQueryExportsResponse', 'decode'],
        $metadata, $options);
    }

}
