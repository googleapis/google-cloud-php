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
namespace Google\Cloud\AccessApproval\V1;

/**
 * This API allows a customer to manage accesses to cloud resources by
 * Google personnel. It defines the following resource model:
 *
 * - The API has a collection of
 *   [ApprovalRequest][google.cloud.accessapproval.v1.ApprovalRequest]
 *   resources, named `approvalRequests/{approval_request_id}`
 * - The API has top-level settings per Project/Folder/Organization, named
 *   `accessApprovalSettings`
 *
 * The service also periodically emails a list of recipients, defined at the
 * Project/Folder/Organization level in the accessApprovalSettings, when there
 * is a pending ApprovalRequest for them to act on. The ApprovalRequests can
 * also optionally be published to a Cloud Pub/Sub topic owned by the customer
 * (for Beta, the Pub/Sub setup is managed manually).
 *
 * ApprovalRequests can be approved or dismissed. Google personel can only
 * access the indicated resource or resources if the request is approved
 * (subject to some exclusions:
 * https://cloud.google.com/access-approval/docs/overview#exclusions).
 *
 * Note: Using Access Approval functionality will mean that Google may not be
 * able to meet the SLAs for your chosen products, as any support response times
 * may be dramatically increased. As such the SLAs do not apply to any service
 * disruption to the extent impacted by Customer's use of Access Approval. Do
 * not enable Access Approval for projects where you may require high service
 * availability and rapid response by Google Cloud Support.
 *
 * After a request is approved or dismissed, no further action may be taken on
 * it. Requests with the requested_expiration in the past or with no activity
 * for 14 days are considered dismissed. When an approval expires, the request
 * is considered dismissed.
 *
 * If a request is not approved or dismissed, we call it pending.
 */
class AccessApprovalGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists approval requests associated with a project, folder, or organization.
     * Approval requests can be filtered by state (pending, active, dismissed).
     * The order is reverse chronological.
     * @param \Google\Cloud\AccessApproval\V1\ListApprovalRequestsMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApprovalRequests(\Google\Cloud\AccessApproval\V1\ListApprovalRequestsMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/ListApprovalRequests',
        $argument,
        ['\Google\Cloud\AccessApproval\V1\ListApprovalRequestsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an approval request. Returns NOT_FOUND if the request does not exist.
     * @param \Google\Cloud\AccessApproval\V1\GetApprovalRequestMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApprovalRequest(\Google\Cloud\AccessApproval\V1\GetApprovalRequestMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/GetApprovalRequest',
        $argument,
        ['\Google\Cloud\AccessApproval\V1\ApprovalRequest', 'decode'],
        $metadata, $options);
    }

    /**
     * Approves a request and returns the updated ApprovalRequest.
     *
     * Returns NOT_FOUND if the request does not exist. Returns
     * FAILED_PRECONDITION if the request exists but is not in a pending state.
     * @param \Google\Cloud\AccessApproval\V1\ApproveApprovalRequestMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ApproveApprovalRequest(\Google\Cloud\AccessApproval\V1\ApproveApprovalRequestMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/ApproveApprovalRequest',
        $argument,
        ['\Google\Cloud\AccessApproval\V1\ApprovalRequest', 'decode'],
        $metadata, $options);
    }

    /**
     * Dismisses a request. Returns the updated ApprovalRequest.
     *
     * NOTE: This does not deny access to the resource if another request has been
     * made and approved. It is equivalent in effect to ignoring the request
     * altogether.
     *
     * Returns NOT_FOUND if the request does not exist.
     *
     * Returns FAILED_PRECONDITION if the request exists but is not in a pending
     * state.
     * @param \Google\Cloud\AccessApproval\V1\DismissApprovalRequestMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DismissApprovalRequest(\Google\Cloud\AccessApproval\V1\DismissApprovalRequestMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/DismissApprovalRequest',
        $argument,
        ['\Google\Cloud\AccessApproval\V1\ApprovalRequest', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the settings associated with a project, folder, or organization.
     * @param \Google\Cloud\AccessApproval\V1\GetAccessApprovalSettingsMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccessApprovalSettings(\Google\Cloud\AccessApproval\V1\GetAccessApprovalSettingsMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/GetAccessApprovalSettings',
        $argument,
        ['\Google\Cloud\AccessApproval\V1\AccessApprovalSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the settings associated with a project, folder, or organization.
     * Settings to update are determined by the value of field_mask.
     * @param \Google\Cloud\AccessApproval\V1\UpdateAccessApprovalSettingsMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAccessApprovalSettings(\Google\Cloud\AccessApproval\V1\UpdateAccessApprovalSettingsMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/UpdateAccessApprovalSettings',
        $argument,
        ['\Google\Cloud\AccessApproval\V1\AccessApprovalSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the settings associated with a project, folder, or organization.
     * This will have the effect of disabling Access Approval for the project,
     * folder, or organization, but only if all ancestors also have Access
     * Approval disabled. If Access Approval is enabled at a higher level of the
     * hierarchy, then Access Approval will still be enabled at this level as
     * the settings are inherited.
     * @param \Google\Cloud\AccessApproval\V1\DeleteAccessApprovalSettingsMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAccessApprovalSettings(\Google\Cloud\AccessApproval\V1\DeleteAccessApprovalSettingsMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.accessapproval.v1.AccessApproval/DeleteAccessApprovalSettings',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
