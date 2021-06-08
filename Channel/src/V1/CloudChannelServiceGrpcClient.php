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
namespace Google\Cloud\Channel\V1;

/**
 * CloudChannelService lets Google cloud resellers and distributors manage
 * their customers, channel partners, entitlements, and reports.
 *
 * Using this service:
 * 1. Resellers and distributors can manage a customer entity.
 * 2. Distributors can register an authorized reseller in their channel and
 *    provide them with delegated admin access.
 * 3. Resellers and distributors can manage customer entitlements.
 *
 * CloudChannelService exposes the following resources:
 * - [Customer][google.cloud.channel.v1.Customer]s: An entity—usually an enterprise—managed by a reseller or
 * distributor.
 *
 * - [Entitlement][google.cloud.channel.v1.Entitlement]s: An entity that provides a customer with the means to use
 * a service. Entitlements are created or updated as a result of a successful
 * fulfillment.
 *
 * - [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink]s: An entity that identifies links between
 * distributors and their indirect resellers in a channel.
 */
class CloudChannelServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * List [Customer][google.cloud.channel.v1.Customer]s.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     *
     * Return value:
     * List of [Customer][google.cloud.channel.v1.Customer]s, or an empty list if there are no customers.
     * @param \Google\Cloud\Channel\V1\ListCustomersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomers(\Google\Cloud\Channel\V1\ListCustomersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListCustomers',
        $argument,
        ['\Google\Cloud\Channel\V1\ListCustomersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested [Customer][google.cloud.channel.v1.Customer] resource.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: The customer resource doesn't exist. Usually the result of an
     * invalid name parameter.
     *
     * Return value:
     * The [Customer][google.cloud.channel.v1.Customer] resource.
     * @param \Google\Cloud\Channel\V1\GetCustomerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomer(\Google\Cloud\Channel\V1\GetCustomerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/GetCustomer',
        $argument,
        ['\Google\Cloud\Channel\V1\Customer', 'decode'],
        $metadata, $options);
    }

    /**
     * Confirms the existence of Cloud Identity accounts based on the domain and
     * if the Cloud Identity accounts are owned by the reseller.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * INVALID_VALUE: Invalid domain value in the request.
     *
     * Return value:
     * A list of [CloudIdentityCustomerAccount][google.cloud.channel.v1.CloudIdentityCustomerAccount] resources for the domain (may be
     * empty)
     *
     * Note: in the v1alpha1 version of the API, a NOT_FOUND error returns if
     * no [CloudIdentityCustomerAccount][google.cloud.channel.v1.CloudIdentityCustomerAccount] resources match the domain.
     * @param \Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CheckCloudIdentityAccountsExist(\Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/CheckCloudIdentityAccountsExist',
        $argument,
        ['\Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [Customer][google.cloud.channel.v1.Customer] resource under the reseller or distributor
     * account.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT:
     *     * Required request parameters are missing or invalid.
     *     * Domain field value doesn't match the primary email domain.
     *
     * Return value:
     * The newly created [Customer][google.cloud.channel.v1.Customer] resource.
     * @param \Google\Cloud\Channel\V1\CreateCustomerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomer(\Google\Cloud\Channel\V1\CreateCustomerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/CreateCustomer',
        $argument,
        ['\Google\Cloud\Channel\V1\Customer', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing [Customer][google.cloud.channel.v1.Customer] resource for the reseller or
     * distributor.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: No [Customer][google.cloud.channel.v1.Customer] resource found for the name in the request.
     *
     * Return value:
     * The updated [Customer][google.cloud.channel.v1.Customer] resource.
     * @param \Google\Cloud\Channel\V1\UpdateCustomerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomer(\Google\Cloud\Channel\V1\UpdateCustomerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/UpdateCustomer',
        $argument,
        ['\Google\Cloud\Channel\V1\Customer', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the given [Customer][google.cloud.channel.v1.Customer] permanently.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The account making the request does not own
     * this customer.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * FAILED_PRECONDITION: The customer has existing entitlements.
     * * NOT_FOUND: No [Customer][google.cloud.channel.v1.Customer] resource found for the name in the request.
     * @param \Google\Cloud\Channel\V1\DeleteCustomerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCustomer(\Google\Cloud\Channel\V1\DeleteCustomerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/DeleteCustomer',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Cloud Identity for the given customer using the customer's
     * information, or the information provided here.
     *
     * Possible error codes:
     *
     * *  PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * *  INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * *  NOT_FOUND: The customer was not found.
     * *  ALREADY_EXISTS: The customer's primary email already exists. Retry
     *    after changing the customer's primary contact email.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata contains an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\ProvisionCloudIdentityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ProvisionCloudIdentity(\Google\Cloud\Channel\V1\ProvisionCloudIdentityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ProvisionCloudIdentity',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [Entitlement][google.cloud.channel.v1.Entitlement]s belonging to a customer.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     *
     * Return value:
     * A list of the customer's [Entitlement][google.cloud.channel.v1.Entitlement]s.
     * @param \Google\Cloud\Channel\V1\ListEntitlementsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEntitlements(\Google\Cloud\Channel\V1\ListEntitlementsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListEntitlements',
        $argument,
        ['\Google\Cloud\Channel\V1\ListEntitlementsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List [TransferableSku][google.cloud.channel.v1.TransferableSku]s of a customer based on the Cloud Identity ID or
     * Customer Name in the request.
     *
     * Use this method to list the entitlements information of an
     * unowned customer. You should provide the customer's
     * Cloud Identity ID or Customer Name.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED:
     *     * The customer doesn't belong to the reseller and has no auth token.
     *     * The supplied auth token is invalid.
     *     * The reseller account making the request is different
     *     from the reseller account in the query.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     *
     * Return value:
     * A list of the customer's [TransferableSku][google.cloud.channel.v1.TransferableSku].
     * @param \Google\Cloud\Channel\V1\ListTransferableSkusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTransferableSkus(\Google\Cloud\Channel\V1\ListTransferableSkusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListTransferableSkus',
        $argument,
        ['\Google\Cloud\Channel\V1\ListTransferableSkusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List [TransferableOffer][google.cloud.channel.v1.TransferableOffer]s of a customer based on Cloud Identity ID or
     * Customer Name in the request.
     *
     * Use this method when a reseller gets the entitlement information of an
     * unowned customer. The reseller should provide the customer's
     * Cloud Identity ID or Customer Name.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED:
     *     * The customer doesn't belong to the reseller and has no auth token.
     *     * The supplied auth token is invalid.
     *     * The reseller account making the request is different
     *     from the reseller account in the query.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     *
     * Return value:
     * List of [TransferableOffer][google.cloud.channel.v1.TransferableOffer] for the given customer and SKU.
     * @param \Google\Cloud\Channel\V1\ListTransferableOffersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTransferableOffers(\Google\Cloud\Channel\V1\ListTransferableOffersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListTransferableOffers',
        $argument,
        ['\Google\Cloud\Channel\V1\ListTransferableOffersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested [Entitlement][google.cloud.channel.v1.Entitlement] resource.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: The customer entitlement was not found.
     *
     * Return value:
     * The requested [Entitlement][google.cloud.channel.v1.Entitlement] resource.
     * @param \Google\Cloud\Channel\V1\GetEntitlementRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEntitlement(\Google\Cloud\Channel\V1\GetEntitlementRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/GetEntitlement',
        $argument,
        ['\Google\Cloud\Channel\V1\Entitlement', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an entitlement for a customer.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT:
     *     * Required request parameters are missing or invalid.
     *     * There is already a customer entitlement for a SKU from the same
     *     product family.
     * * INVALID_VALUE: Make sure the OfferId is valid. If it is, contact
     * Google Channel support for further troubleshooting.
     * * NOT_FOUND: The customer or offer resource was not found.
     * * ALREADY_EXISTS:
     *     * The SKU was already purchased for the customer.
     *     * The customer's primary email already exists. Retry
     *     after changing the customer's primary contact email.
     * * CONDITION_NOT_MET or FAILED_PRECONDITION:
     *     * The domain required for purchasing a SKU has not been verified.
     *     * A pre-requisite SKU required to purchase an Add-On SKU is missing.
     *     For example, Google Workspace Business Starter is required to purchase
     *     Vault or Drive.
     *     * (Developer accounts only) Reseller and resold domain must meet the
     *     following naming requirements:
     *         * Domain names must start with goog-test.
     *         * Domain names must include the reseller domain.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\CreateEntitlementRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEntitlement(\Google\Cloud\Channel\V1\CreateEntitlementRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/CreateEntitlement',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Change parameters of the entitlement.
     *
     * An entitlement update is a long-running operation and it updates the
     * entitlement as a result of fulfillment.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * For example, the number of seats being changed is greater than the allowed
     * number of max seats, or decreasing seats for a commitment based plan.
     * * NOT_FOUND: Entitlement resource not found.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\ChangeParametersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ChangeParameters(\Google\Cloud\Channel\V1\ChangeParametersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ChangeParameters',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the renewal settings for an existing customer entitlement.
     *
     * An entitlement update is a long-running operation and it updates the
     * entitlement as a result of fulfillment.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Entitlement resource not found.
     * * NOT_COMMITMENT_PLAN: Renewal Settings are only applicable for a
     * commitment plan. Can't enable or disable renewals for non-commitment plans.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     *   Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\ChangeRenewalSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ChangeRenewalSettings(\Google\Cloud\Channel\V1\ChangeRenewalSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ChangeRenewalSettings',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the Offer for an existing customer entitlement.
     *
     * An entitlement update is a long-running operation and it updates the
     * entitlement as a result of fulfillment.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Offer or Entitlement resource not found.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\ChangeOfferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ChangeOffer(\Google\Cloud\Channel\V1\ChangeOfferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ChangeOffer',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts paid service for a trial entitlement.
     *
     * Starts paid service for a trial entitlement immediately. This method is
     * only applicable if a plan is set up for a trial entitlement but has some
     * trial days remaining.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Entitlement resource not found.
     * * FAILED_PRECONDITION/NOT_IN_TRIAL: This method only works for
     * entitlement on trial plans.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\StartPaidServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartPaidService(\Google\Cloud\Channel\V1\StartPaidServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/StartPaidService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Suspends a previously fulfilled entitlement.
     *
     * An entitlement suspension is a long-running operation.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Entitlement resource not found.
     * * NOT_ACTIVE: Entitlement is not active.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\SuspendEntitlementRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SuspendEntitlement(\Google\Cloud\Channel\V1\SuspendEntitlementRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/SuspendEntitlement',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a previously fulfilled entitlement.
     *
     * An entitlement cancellation is a long-running operation.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * FAILED_PRECONDITION: There are Google Cloud projects linked to the
     * Google Cloud entitlement's Cloud Billing subaccount.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Entitlement resource not found.
     * * DELETION_TYPE_NOT_ALLOWED: Cancel is only allowed for Google Workspace
     * add-ons, or entitlements for Google Cloud's development platform.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The response will contain
     * google.protobuf.Empty on success. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\CancelEntitlementRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelEntitlement(\Google\Cloud\Channel\V1\CancelEntitlementRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/CancelEntitlement',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Activates a previously suspended entitlement. Entitlements suspended for
     * pending ToS acceptance can't be activated using this method.
     *
     * An entitlement activation is a long-running operation and it updates
     * the state of the customer entitlement.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Entitlement resource not found.
     * * SUSPENSION_NOT_RESELLER_INITIATED: Can only activate reseller-initiated
     * suspensions and entitlements that have accepted the TOS.
     * * NOT_SUSPENDED: Can only activate suspended entitlements not in an ACTIVE
     * state.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\ActivateEntitlementRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ActivateEntitlement(\Google\Cloud\Channel\V1\ActivateEntitlementRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ActivateEntitlement',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Transfers customer entitlements to new reseller.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: The customer or offer resource was not found.
     * * ALREADY_EXISTS: The SKU was already transferred for the customer.
     * * CONDITION_NOT_MET or FAILED_PRECONDITION:
     *     * The SKU requires domain verification to transfer, but the domain is
     *     not verified.
     *     * An Add-On SKU (example, Vault or Drive) is missing the
     *     pre-requisite SKU (example, G Suite Basic).
     *     * (Developer accounts only) Reseller and resold domain must meet the
     *     following naming requirements:
     *         * Domain names must start with goog-test.
     *         * Domain names must include the reseller domain.
     *     * Specify all transferring entitlements.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\TransferEntitlementsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TransferEntitlements(\Google\Cloud\Channel\V1\TransferEntitlementsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/TransferEntitlements',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Transfers customer entitlements from their current reseller to Google.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: The customer or offer resource was not found.
     * * ALREADY_EXISTS: The SKU was already transferred for the customer.
     * * CONDITION_NOT_MET or FAILED_PRECONDITION:
     *     * The SKU requires domain verification to transfer, but the domain is
     *     not verified.
     *     * An Add-On SKU (example, Vault or Drive) is missing the
     *     pre-requisite SKU (example, G Suite Basic).
     *     * (Developer accounts only) Reseller and resold domain must meet the
     *     following naming requirements:
     *         * Domain names must start with goog-test.
     *         * Domain names must include the reseller domain.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The ID of a long-running operation.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The response will contain
     * google.protobuf.Empty on success. The Operation metadata will contain an
     * instance of [OperationMetadata][google.cloud.channel.v1.OperationMetadata].
     * @param \Google\Cloud\Channel\V1\TransferEntitlementsToGoogleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TransferEntitlementsToGoogle(\Google\Cloud\Channel\V1\TransferEntitlementsToGoogleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/TransferEntitlementsToGoogle',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink]s belonging to a distributor.
     * You must be a distributor to call this method.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     *
     * Return value:
     * The list of the distributor account's [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resources.
     * @param \Google\Cloud\Channel\V1\ListChannelPartnerLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListChannelPartnerLinks(\Google\Cloud\Channel\V1\ListChannelPartnerLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListChannelPartnerLinks',
        $argument,
        ['\Google\Cloud\Channel\V1\ListChannelPartnerLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource.
     * You must be a distributor to call this method.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: ChannelPartnerLink resource not found because of an
     * invalid channel partner link name.
     *
     * Return value:
     * The [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource.
     * @param \Google\Cloud\Channel\V1\GetChannelPartnerLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetChannelPartnerLink(\Google\Cloud\Channel\V1\GetChannelPartnerLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/GetChannelPartnerLink',
        $argument,
        ['\Google\Cloud\Channel\V1\ChannelPartnerLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Initiates a channel partner link between a distributor and a reseller, or
     * between resellers in an n-tier reseller channel.
     * Invited partners need to follow the invite_link_uri provided in the
     * response to accept. After accepting the invitation, a link is set up
     * between the two parties.
     * You must be a distributor to call this method.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * ALREADY_EXISTS: The ChannelPartnerLink sent in the request already
     * exists.
     * * NOT_FOUND: No Cloud Identity customer exists for provided domain.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The new [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource.
     * @param \Google\Cloud\Channel\V1\CreateChannelPartnerLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateChannelPartnerLink(\Google\Cloud\Channel\V1\CreateChannelPartnerLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/CreateChannelPartnerLink',
        $argument,
        ['\Google\Cloud\Channel\V1\ChannelPartnerLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a channel partner link. Distributors call this method to change a
     * link's status. For example, to suspend a partner link.
     * You must be a distributor to call this method.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request is different
     * from the reseller account in the API request.
     * * INVALID_ARGUMENT:
     *     * Required request parameters are missing or invalid.
     *     * Link state cannot change from invited to active or suspended.
     *     * Cannot send reseller_cloud_identity_id, invite_url, or name in update
     *     mask.
     * * NOT_FOUND: ChannelPartnerLink resource not found.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The updated [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource.
     * @param \Google\Cloud\Channel\V1\UpdateChannelPartnerLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateChannelPartnerLink(\Google\Cloud\Channel\V1\UpdateChannelPartnerLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/UpdateChannelPartnerLink',
        $argument,
        ['\Google\Cloud\Channel\V1\ChannelPartnerLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested [Offer][google.cloud.channel.v1.Offer] resource.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The entitlement doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: Entitlement or offer was not found.
     *
     * Return value:
     * The [Offer][google.cloud.channel.v1.Offer] resource.
     * @param \Google\Cloud\Channel\V1\LookupOfferRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LookupOffer(\Google\Cloud\Channel\V1\LookupOfferRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/LookupOffer',
        $argument,
        ['\Google\Cloud\Channel\V1\Offer', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the Products the reseller is authorized to sell.
     *
     * Possible error codes:
     *
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * @param \Google\Cloud\Channel\V1\ListProductsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProducts(\Google\Cloud\Channel\V1\ListProductsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListProducts',
        $argument,
        ['\Google\Cloud\Channel\V1\ListProductsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the SKUs for a product the reseller is authorized to sell.
     *
     * Possible error codes:
     *
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * @param \Google\Cloud\Channel\V1\ListSkusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSkus(\Google\Cloud\Channel\V1\ListSkusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListSkus',
        $argument,
        ['\Google\Cloud\Channel\V1\ListSkusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the Offers the reseller can sell.
     *
     * Possible error codes:
     *
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * @param \Google\Cloud\Channel\V1\ListOffersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListOffers(\Google\Cloud\Channel\V1\ListOffersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListOffers',
        $argument,
        ['\Google\Cloud\Channel\V1\ListOffersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the following:
     *
     * * SKUs that you can purchase for a customer
     * * SKUs that you can upgrade or downgrade for an entitlement.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * @param \Google\Cloud\Channel\V1\ListPurchasableSkusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPurchasableSkus(\Google\Cloud\Channel\V1\ListPurchasableSkusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListPurchasableSkus',
        $argument,
        ['\Google\Cloud\Channel\V1\ListPurchasableSkusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the following:
     *
     * * Offers that you can purchase for a customer.
     * * Offers that you can change for an entitlement.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The customer doesn't belong to the reseller
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * @param \Google\Cloud\Channel\V1\ListPurchasableOffersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPurchasableOffers(\Google\Cloud\Channel\V1\ListPurchasableOffersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListPurchasableOffers',
        $argument,
        ['\Google\Cloud\Channel\V1\ListPurchasableOffersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Registers a service account with subscriber privileges on the Cloud Pub/Sub
     * topic for this Channel Services account. After you create a
     * subscriber, you get the events through [SubscriberEvent][google.cloud.channel.v1.SubscriberEvent]
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request and the
     * provided reseller account are different, or the impersonated user
     * is not a super admin.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The topic name with the registered service email address.
     * @param \Google\Cloud\Channel\V1\RegisterSubscriberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RegisterSubscriber(\Google\Cloud\Channel\V1\RegisterSubscriberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/RegisterSubscriber',
        $argument,
        ['\Google\Cloud\Channel\V1\RegisterSubscriberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Unregisters a service account with subscriber privileges on the Cloud
     * Pub/Sub topic created for this Channel Services account. If there are no
     * service accounts left with subscriber privileges, this deletes the topic.
     * You can call ListSubscribers to check for these accounts.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request and the
     * provided reseller account are different, or the impersonated user
     * is not a super admin.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: The topic resource doesn't exist.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * The topic name that unregistered the service email address.
     * Returns a success response if the service email address wasn't registered
     * with the topic.
     * @param \Google\Cloud\Channel\V1\UnregisterSubscriberRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UnregisterSubscriber(\Google\Cloud\Channel\V1\UnregisterSubscriberRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/UnregisterSubscriber',
        $argument,
        ['\Google\Cloud\Channel\V1\UnregisterSubscriberResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists service accounts with subscriber privileges on the Cloud Pub/Sub
     * topic created for this Channel Services account.
     *
     * Possible error codes:
     *
     * * PERMISSION_DENIED: The reseller account making the request and the
     * provided reseller account are different, or the impersonated user
     * is not a super admin.
     * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
     * * NOT_FOUND: The topic resource doesn't exist.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * Contact Cloud Channel support.
     *
     * Return value:
     * A list of service email addresses.
     * @param \Google\Cloud\Channel\V1\ListSubscribersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSubscribers(\Google\Cloud\Channel\V1\ListSubscribersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.channel.v1.CloudChannelService/ListSubscribers',
        $argument,
        ['\Google\Cloud\Channel\V1\ListSubscribersResponse', 'decode'],
        $metadata, $options);
    }

}
