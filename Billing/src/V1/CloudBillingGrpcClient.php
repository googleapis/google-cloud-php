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
namespace Google\Cloud\Billing\V1;

/**
 * Retrieves the Google Cloud Console billing accounts and associates them with
 * projects.
 */
class CloudBillingGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets information about a billing account. The current authenticated user
     * must be a [viewer of the billing
     * account](https://cloud.google.com/billing/docs/how-to/billing-access).
     * @param \Google\Cloud\Billing\V1\GetBillingAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBillingAccount(\Google\Cloud\Billing\V1\GetBillingAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/GetBillingAccount',
        $argument,
        ['\Google\Cloud\Billing\V1\BillingAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the billing accounts that the current authenticated user has
     * permission to
     * [view](https://cloud.google.com/billing/docs/how-to/billing-access).
     * @param \Google\Cloud\Billing\V1\ListBillingAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBillingAccounts(\Google\Cloud\Billing\V1\ListBillingAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/ListBillingAccounts',
        $argument,
        ['\Google\Cloud\Billing\V1\ListBillingAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a billing account's fields.
     * Currently the only field that can be edited is `display_name`.
     * The current authenticated user must have the `billing.accounts.update`
     * IAM permission, which is typically given to the
     * [administrator](https://cloud.google.com/billing/docs/how-to/billing-access)
     * of the billing account.
     * @param \Google\Cloud\Billing\V1\UpdateBillingAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBillingAccount(\Google\Cloud\Billing\V1\UpdateBillingAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/UpdateBillingAccount',
        $argument,
        ['\Google\Cloud\Billing\V1\BillingAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * This method creates [billing
     * subaccounts](https://cloud.google.com/billing/docs/concepts#subaccounts).
     *
     * Google Cloud resellers should use the
     * Channel Services APIs,
     * [accounts.customers.create](https://cloud.google.com/channel/docs/reference/rest/v1/accounts.customers/create)
     * and
     * [accounts.customers.entitlements.create](https://cloud.google.com/channel/docs/reference/rest/v1/accounts.customers.entitlements/create).
     *
     * When creating a subaccount, the current authenticated user must have the
     * `billing.accounts.update` IAM permission on the parent account, which is
     * typically given to billing account
     * [administrators](https://cloud.google.com/billing/docs/how-to/billing-access).
     * This method will return an error if the parent account has not been
     * provisioned as a reseller account.
     * @param \Google\Cloud\Billing\V1\CreateBillingAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBillingAccount(\Google\Cloud\Billing\V1\CreateBillingAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/CreateBillingAccount',
        $argument,
        ['\Google\Cloud\Billing\V1\BillingAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the projects associated with a billing account. The current
     * authenticated user must have the `billing.resourceAssociations.list` IAM
     * permission, which is often given to billing account
     * [viewers](https://cloud.google.com/billing/docs/how-to/billing-access).
     * @param \Google\Cloud\Billing\V1\ListProjectBillingInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProjectBillingInfo(\Google\Cloud\Billing\V1\ListProjectBillingInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/ListProjectBillingInfo',
        $argument,
        ['\Google\Cloud\Billing\V1\ListProjectBillingInfoResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the billing information for a project. The current authenticated user
     * must have the `resourcemanager.projects.get` permission for the project,
     * which can be granted by assigning the [Project
     * Viewer](https://cloud.google.com/iam/docs/understanding-roles#predefined_roles)
     * role.
     * @param \Google\Cloud\Billing\V1\GetProjectBillingInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProjectBillingInfo(\Google\Cloud\Billing\V1\GetProjectBillingInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/GetProjectBillingInfo',
        $argument,
        ['\Google\Cloud\Billing\V1\ProjectBillingInfo', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets or updates the billing account associated with a project. You specify
     * the new billing account by setting the `billing_account_name` in the
     * `ProjectBillingInfo` resource to the resource name of a billing account.
     * Associating a project with an open billing account enables billing on the
     * project and allows charges for resource usage. If the project already had a
     * billing account, this method changes the billing account used for resource
     * usage charges.
     *
     * *Note:* Incurred charges that have not yet been reported in the transaction
     * history of the Google Cloud Console might be billed to the new billing
     * account, even if the charge occurred before the new billing account was
     * assigned to the project.
     *
     * The current authenticated user must have ownership privileges for both the
     * [project](https://cloud.google.com/docs/permissions-overview#h.bgs0oxofvnoo
     * ) and the [billing
     * account](https://cloud.google.com/billing/docs/how-to/billing-access).
     *
     * You can disable billing on the project by setting the
     * `billing_account_name` field to empty. This action disassociates the
     * current billing account from the project. Any billable activity of your
     * in-use services will stop, and your application could stop functioning as
     * expected. Any unbilled charges to date will be billed to the previously
     * associated account. The current authenticated user must be either an owner
     * of the project or an owner of the billing account for the project.
     *
     * Note that associating a project with a *closed* billing account will have
     * much the same effect as disabling billing on the project: any paid
     * resources used by the project will be shut down. Thus, unless you wish to
     * disable billing, you should always call this method with the name of an
     * *open* billing account.
     * @param \Google\Cloud\Billing\V1\UpdateProjectBillingInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateProjectBillingInfo(\Google\Cloud\Billing\V1\UpdateProjectBillingInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/UpdateProjectBillingInfo',
        $argument,
        ['\Google\Cloud\Billing\V1\ProjectBillingInfo', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a billing account.
     * The caller must have the `billing.accounts.getIamPolicy` permission on the
     * account, which is often given to billing account
     * [viewers](https://cloud.google.com/billing/docs/how-to/billing-access).
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy for a billing account. Replaces any existing
     * policy.
     * The caller must have the `billing.accounts.setIamPolicy` permission on the
     * account, which is often given to billing account
     * [administrators](https://cloud.google.com/billing/docs/how-to/billing-access).
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Tests the access control policy for a billing account. This method takes
     * the resource and a set of permissions as input and returns the subset of
     * the input permissions that the caller is allowed for that resource.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudBilling/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
