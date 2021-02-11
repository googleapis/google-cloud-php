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
 * CloudChannelService enables Google cloud resellers and distributors to manage
 * their customers, channel partners, entitlements and reports.
 *
 * Using this service:
 * 1. Resellers or distributors can manage a customer entity.
 * 2. Distributors can register an authorized reseller in their channel and then
 *    enable delegated admin access for the reseller.
 * 3. Resellers or distributors can manage entitlements for their customers.
 *
 * The service primarily exposes the following resources:
 * - [Customer][google.cloud.channel.v1.Customer]s: A Customer represents an entity managed by a reseller or
 * distributor. A customer typically represents an enterprise. In an n-tier
 * resale channel hierarchy, customers are generally represented as leaf nodes.
 * Customers primarily have an Entitlement sub-resource discussed below.
 *
 * - [Entitlement][google.cloud.channel.v1.Entitlement]s: An Entitlement represents an entity which provides a
 * customer means to start using a service. Entitlements are created or updated
 * as a result of a successful fulfillment.
 *
 * - [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink]s: A ChannelPartnerLink is an entity that identifies
 * links between distributors and their indirect resellers in a channel.
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
     * List downstream [Customer][google.cloud.channel.v1.Customer]s.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Return Value:
     * <br/> List of [Customer][google.cloud.channel.v1.Customer]s pertaining to the reseller or empty list if
     * there are none.
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
     * Returns a requested [Customer][google.cloud.channel.v1.Customer] resource.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: If the customer resource doesn't exist. Usually
     * the result of an invalid name parameter.
     *
     * Return Value:
     * <br/> [Customer][google.cloud.channel.v1.Customer] resource if found, error otherwise.
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
     * Confirms the existence of Cloud Identity accounts, based on the domain and
     * whether the Cloud Identity accounts are owned by the reseller.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * INVALID_VALUE: Invalid domain value in the request.
     * * NOT_FOUND: If there is no [CloudIdentityCustomerAccount][google.cloud.channel.v1.CloudIdentityCustomerAccount] customer
     * for the domain specified in the request.
     *
     * Return Value:
     * <br/> List of [CloudIdentityCustomerAccount][google.cloud.channel.v1.CloudIdentityCustomerAccount] resources if any exist for
     * the domain, otherwise an error is returned.
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
     * Possible Error Codes:
     * <ul>
     * <li>PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.</li>
     * <li> INVALID_ARGUMENT:
     * <ul>
     *  <li> Missing or invalid required parameters in the request. </li>
     *  <li> Domain field value doesn't match the domain specified in primary
     *  email.</li>
     * </ul>
     * </li>
     * </ul>
     *
     * Return Value:
     * <br/> If successful, the newly created [Customer][google.cloud.channel.v1.Customer] resource, otherwise
     * returns an error.
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
     * Updates an existing [Customer][google.cloud.channel.v1.Customer] resource belonging to the reseller or
     * distributor.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: No [Customer][google.cloud.channel.v1.Customer] resource found for the name
     * specified in the request.
     *
     * Return Value:
     * <br/> If successful, the updated [Customer][google.cloud.channel.v1.Customer] resource, otherwise returns
     * an error.
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
     * Deletes the given [Customer][google.cloud.channel.v1.Customer] permanently and irreversibly.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the account making the request does not own
     * this customer.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * FAILED_PRECONDITION: If the customer has existing entitlements.
     * * NOT_FOUND: No [Customer][google.cloud.channel.v1.Customer] resource found for the name
     * specified in the request.
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
     * information or the information provided here, if present.
     *
     * Possible Error Codes:
     *
     * *  PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * *  INVALID_ARGUMENT: Missing or invalid required parameters in the request.
     * *  NOT_FOUND: If the customer is not found for the reseller.
     * *  ALREADY_EXISTS: If the customer's primary email already exists. In this
     *    case, retry after changing the customer's primary contact email.
     * *  INTERNAL: Any non-user error related to a technical issue in the
     *    backend. Contact Cloud Channel support in this case.
     * *  UNKNOWN: Any non-user error related to a technical issue in the backend.
     *    Contact Cloud Channel support in this case.
     *
     * Return Value:
     * <br/>  Long Running Operation ID.
     *
     * To get the results of the operation, call the GetOperation method of
     * CloudChannelOperationsService. The Operation metadata will contain an
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
     * List [Entitlement][google.cloud.channel.v1.Entitlement]s belonging to a customer.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the request.
     *
     * Return Value:
     * <br/> List of [Entitlement][google.cloud.channel.v1.Entitlement]s belonging to the customer, or empty list if
     * there are none.
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
     * List [TransferableSku][google.cloud.channel.v1.TransferableSku]s of a customer based on Cloud Identity ID or
     * Customer Name in the request.
     *
     * This method is used when a reseller lists the entitlements
     * information of a customer that is not owned. The reseller should provide
     * the customer's Cloud Identity ID or Customer Name.
     *
     * Possible Error Codes:
     * <ul>
     * <li>PERMISSION_DENIED, due to one of the following reasons:
     * <ul>
     *    <li> If the customer doesn't belong to the reseller and no auth token,
     *    or an invalid auth token is supplied. </li> <li> If the reseller account
     *    making the request and the reseller account being queried for are
     *    different. </li>
     * </ul>
     * </li>
     * <li> INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.</li>
     * </ul>
     *
     * Return Value:
     * <br/> List of [TransferableSku][google.cloud.channel.v1.TransferableSku] for the given customer.
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
     * This method is used when a reseller gets the entitlement
     * information of a customer that is not owned. The reseller should provide
     * the customer's Cloud Identity ID or Customer Name.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED, due to one of the following reasons: (a) If the
     * customer doesn't belong to the reseller and no auth token or invalid auth
     * token is supplied. (b) If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Return Value:
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
     * Returns a requested [Entitlement][google.cloud.channel.v1.Entitlement] resource.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: If the entitlement is not found for the customer.
     *
     * Return Value:
     * <br/> If found, the requested [Entitlement][google.cloud.channel.v1.Entitlement] resource, otherwise returns
     * an error.
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
     * Possible Error Codes:
     * <ul>
     * <li> PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * </li> <li> INVALID_ARGUMENT: <ul>
     *   <li> Missing or invalid required parameters in the request. </li>
     *   <li> Cannot purchase an entitlement if there is already an
     *    entitlement for customer, for a SKU from the same product family. </li>
     *   <li> INVALID_VALUE: Offer passed in isn't valid. Make sure OfferId is
     * valid. If it is valid, then contact Google Channel support for further
     * troubleshooting. </li>
     * </ul>
     * </li>
     * <li> NOT_FOUND: If the customer or offer resource is not found for the
     * reseller. </li>
     * <li> ALREADY_EXISTS: This failure can happen in the following cases:
     *   <ul>
     *     <li>If the SKU has been already purchased for the customer.</li>
     *     <li>If the customer's primary email already exists. In this case retry
     *         after changing the customer's primary contact email.
     *     </li>
     *   </ul>
     * </li>
     * <li> CONDITION_NOT_MET or FAILED_PRECONDITION: This
     * failure can happen in the following cases:
     * <ul>
     *    <li> Purchasing a SKU that requires domain verification and the
     *    domain has not been verified. </li>
     *    <li> Purchasing an Add-On SKU like Vault or Drive without purchasing
     *    the pre-requisite SKU, such as Google Workspace Business Starter. </li>
     *    <li> Applicable only for developer accounts: reseller and resold
     *    domain. Must meet the following domain naming requirements:
     *     <ul>
     *       <li> Domain names must start with goog-test. </li>
     *       <li> Resold domain names must include the reseller domain. </li>
     *     </ul>
     *    </li>
     * </ul>
     * </li>
     * <li> INTERNAL: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel Support in this case. </li>
     * <li> UNKNOWN: Any non-user error related to a technical issue in the
     * backend. Contact Cloud Channel Support in this case. </li>
     * </ul>
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * Change parameters of the entitlement
     *
     * An entitlement parameters update is a long-running operation and results in
     * updates to the entitlement as a result of fulfillment.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request. For example, if the number of seats being changed to is greater
     * than the allowed number of max seats for the resource. Or decreasing seats
     * for a commitment based plan.
     * * NOT_FOUND: Entitlement resource not found.
     * * INTERNAL: Any non-user error related to a technical issue
     * in the backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * An entitlement update is a long-running operation and results in updates to
     * the entitlement as a result of fulfillment.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: Entitlement resource not found.
     * * NOT_COMMITMENT_PLAN: Renewal Settings are only applicable for a
     * commitment plan. Can't enable or disable renewal for non-commitment plans.
     * * INTERNAL: Any non user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * An entitlement update is a long-running operation and results in updates to
     * the entitlement as a result of fulfillment.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: Offer or Entitlement resource not found.
     * * INTERNAL: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * only applicable if a plan has already been set up for a trial entitlement
     * but has some trial days remaining.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: Entitlement resource not found.
     * * FAILED_PRECONDITION/NOT_IN_TRIAL: This method only works for
     * entitlement on trial plans.
     * * INTERNAL: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue
     * in the backend. In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * An entitlement suspension is a long-running operation.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: Entitlement resource not found.
     * * NOT_ACTIVE: Entitlement is not active.
     * * INTERNAL: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * An entitlement cancellation is a long-running operation.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller or
     * if the reseller account making the request and reseller account being
     * queried for are different.
     * * FAILED_PRECONDITION: If there are any Google Cloud projects linked to the
     * Google Cloud entitlement's Cloud Billing subaccount.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: Entitlement resource not found.
     * * DELETION_TYPE_NOT_ALLOWED: Cancel is only allowed for Google Workspace
     * add-ons or entitlements for Google Cloud's development platform.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * Activates a previously suspended entitlement. The entitlement must be in a
     * suspended state for it to be activated. Entitlements suspended for pending
     * ToS acceptance can't be activated using this method. An entitlement
     * activation is a long-running operation and can result in updates to
     * the state of the customer entitlement.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller or
     * if the reseller account making the request and reseller account being
     * queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: Entitlement resource not found.
     * * SUSPENSION_NOT_RESELLER_INITIATED: Can't activate an
     * entitlement that is pending TOS acceptance. Only reseller initiated
     * suspensions can be activated.
     * * NOT_SUSPENDED: Can't activate entitlements that are already in ACTIVE
     * state. Can only activate suspended entitlements.
     * * INTERNAL: Any non-user error related to a technical issue
     * in the backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in the backend.
     * In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * Possible Error Codes:
     * <ul>
     * <li> PERMISSION_DENIED: If the customer doesn't belong to the
     * reseller.</li> <li> INVALID_ARGUMENT: Missing or invalid required
     * parameters in the request. </li> <li> NOT_FOUND: If the customer or offer
     * resource is not found for the reseller. </li> <li> ALREADY_EXISTS: If the
     * SKU has been already transferred for the customer. </li> <li>
     * CONDITION_NOT_MET or FAILED_PRECONDITION: This failure can happen in the
     * following cases: <ul>
     *    <li> Transferring a SKU that requires domain verification and the
     * domain has not been verified. </li>
     *    <li> Transferring an Add-On SKU like Vault or Drive without transferring
     * the pre-requisite SKU, such as G Suite Basic </li> <li> Applicable only for
     * developer accounts: reseller and resold domain must follow the domain
     * naming convention as follows:
     *      <ul>
     *         <li> Domain names must start with goog-test. </li>
     *         <li> Resold domain names must include the reseller domain. </li>
     *      </ul>
     *   </li>
     *   <li> All transferring entitlements must be specified. </li>
     * </ul>
     * </li>
     * <li> INTERNAL: Any non-user error related to a technical issue in the
     * backend. Please contact Cloud Channel Support in this case. </li>
     * <li> UNKNOWN: Any non-user error related to a technical issue in the
     * backend. Please contact Cloud Channel Support in this case. </li>
     * </ul>
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * Transfers customer entitlements from current reseller to Google.
     *
     * Possible Error Codes:
     * <ul>
     * <li> PERMISSION_DENIED: If the customer doesn't belong to the reseller.
     * </li> <li> INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request. </li>
     * <li> NOT_FOUND: If the customer or offer resource is not found
     * for the reseller. </li>
     * <li> ALREADY_EXISTS: If the SKU has been already
     * transferred for the customer. </li>
     * <li> CONDITION_NOT_MET or FAILED_PRECONDITION: This failure can happen in
     * the following cases:
     * <ul>
     *    <li> Transferring a SKU that requires domain verification and the
     * domain has not been verified. </li>
     *    <li> Transferring an Add-On SKU like Vault or Drive without purchasing
     * the pre-requisite SKU, such as G Suite Basic </li> <li> Applicable only for
     * developer accounts: reseller and resold domain must follow the domain
     * naming convention as follows:
     *      <ul>
     *         <li> Domain names must start with goog-test. </li>
     *         <li> Resold domain names must include the reseller domain. </li>
     *      </ul>
     *    </li>
     * </ul>
     * </li>
     * <li> INTERNAL: Any non-user error related to a technical issue in the
     * backend. Please contact Cloud Channel Support in this case. </li>
     * <li> UNKNOWN: Any non-user error related to a technical issue in the
     * backend. Please contact Cloud Channel Support in this case.</li>
     * </ul>
     *
     * Return Value:
     * <br/> Long Running Operation ID.
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
     * To call this method, you must be a distributor.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Return Value:
     * <br/> If successful, returns the list of [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resources
     * for the distributor account, otherwise returns an error.
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
     * Returns a requested [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource.
     * To call this method, you must be a distributor.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: ChannelPartnerLink resource not found. Results
     * due invalid channel partner link name.
     *
     * Return Value:
     * <br/> [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource if found, otherwise returns an error.
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
     * Initiates a channel partner link between a distributor and a reseller or
     * between resellers in an n-tier reseller channel.
     * To accept the invite, the invited partner should follow the invite_link_uri
     * provided in the response. If the link creation is accepted, a valid link is
     * set up between the two involved parties.
     * To call this method, you must be a distributor.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * ALREADY_EXISTS: If the ChannelPartnerLink sent in the request already
     * exists.
     * * NOT_FOUND: If no Cloud Identity customer exists for domain provided.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in
     * the backend. In this case, contact Cloud Channel support.
     *
     * Return Value:
     * <br/> Newly created [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource if successful,
     * otherwise error is returned.
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
     * Updates a channel partner link. A distributor calls this method to change a
     * link's status. For example, suspend a partner link.
     * To call this method, you must be a distributor.
     *
     * Possible Error Codes:
     * <ul>
     * <li> PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being queried for are different. </li>
     * <li> INVALID_ARGUMENT:
     * <ul>
     *   <li> Missing or invalid required parameters in the request. </li>
     *   <li> Updating link state from invited to active or suspended. </li>
     *   <li> Sending reseller_cloud_identity_id, invite_url or name in update
     *   mask. </li>
     * </ul>
     * </li>
     * <li> NOT_FOUND: ChannelPartnerLink resource not found.</li>
     * <li> INTERNAL: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support. </li>
     * <li> UNKNOWN: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.</li>
     * </ul>
     *
     * Return Value:
     * <br/> If successful, the updated [ChannelPartnerLink][google.cloud.channel.v1.ChannelPartnerLink] resource, otherwise
     * returns an error.
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
     * Lists the Products the reseller is authorized to sell.
     *
     * Possible Error Codes:
     *
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
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
     * Possible Error Codes:
     *
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
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
     * Possible Error Codes:
     *
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
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
     * Lists the Purchasable SKUs for following cases:
     *
     * * SKUs that can be newly purchased for a customer
     * * SKUs that can be upgraded/downgraded to, for an entitlement.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
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
     * Lists the Purchasable Offers for the following cases:
     *
     * * Offers that can be newly purchased for a customer
     * * Offers that can be changed to, for an entitlement.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
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
     * topic created for this Channel Services account. Once you create a
     * subscriber, you will get the events as per [SubscriberEvent][google.cloud.channel.v1.SubscriberEvent]
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being provided are different, or if the impersonated user
     * is not a super admin.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in
     * the backend. In this case, contact Cloud Channel support.
     *
     * Return Value:
     * Topic name with service email address registered if successful,
     * otherwise error is returned.
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
     * more service account left with sunbscriber privileges, the topic will be
     * deleted. You can check this by calling ListSubscribers api.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being provided are different, or if the impersonated user
     * is not a super admin.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: If the topic resource doesn't exist.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in
     * the backend. In this case, contact Cloud Channel support.
     *
     * Return Value:
     * Topic name from which service email address has been unregistered if
     * successful, otherwise error is returned. If the service email was already
     * not associated with the topic, the success response will be returned.
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
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the reseller account making the request and the
     * reseller account being provided are different, or if the account is not
     * a super admin.
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     * * NOT_FOUND: If the topic resource doesn't exist.
     * * INTERNAL: Any non-user error related to a technical issue in the
     * backend. In this case, contact Cloud Channel support.
     * * UNKNOWN: Any non-user error related to a technical issue in
     * the backend. In this case, contact Cloud Channel support.
     *
     * Return Value:
     * List of service email addresses if successful, otherwise error is
     * returned.
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
