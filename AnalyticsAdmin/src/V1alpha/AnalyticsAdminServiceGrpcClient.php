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
namespace Google\Analytics\Admin\V1alpha;

/**
 * Service Interface for the Analytics Admin API (GA4).
 */
class AnalyticsAdminServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lookup for a single Account.
     * @param \Google\Analytics\Admin\V1alpha\GetAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccount(\Google\Analytics\Admin\V1alpha\GetAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAccount',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Account', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns all accounts accessible by the caller.
     *
     * Note that these accounts might not currently have GA4 properties.
     * Soft-deleted (ie: "trashed") accounts are excluded by default.
     * Returns an empty list if no relevant accounts are found.
     * @param \Google\Analytics\Admin\V1alpha\ListAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAccounts(\Google\Analytics\Admin\V1alpha\ListAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAccounts',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks target Account as soft-deleted (ie: "trashed") and returns it.
     *
     * This API does not have a method to restore soft-deleted accounts.
     * However, they can be restored using the Trash Can UI.
     *
     * If the accounts are not restored before the expiration time, the account
     * and all child resources (eg: Properties, GoogleAdsLinks, Streams,
     * UserLinks) will be permanently purged.
     * https://support.google.com/analytics/answer/6154772
     *
     * Returns an error if the target is not found.
     * @param \Google\Analytics\Admin\V1alpha\DeleteAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAccount(\Google\Analytics\Admin\V1alpha\DeleteAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteAccount',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an account.
     * @param \Google\Analytics\Admin\V1alpha\UpdateAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAccount(\Google\Analytics\Admin\V1alpha\UpdateAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAccount',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Account', 'decode'],
        $metadata, $options);
    }

    /**
     * Requests a ticket for creating an account.
     * @param \Google\Analytics\Admin\V1alpha\ProvisionAccountTicketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ProvisionAccountTicket(\Google\Analytics\Admin\V1alpha\ProvisionAccountTicketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ProvisionAccountTicket',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ProvisionAccountTicketResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns summaries of all accounts accessible by the caller.
     * @param \Google\Analytics\Admin\V1alpha\ListAccountSummariesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAccountSummaries(\Google\Analytics\Admin\V1alpha\ListAccountSummariesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAccountSummaries',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListAccountSummariesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single "GA4" Property.
     * @param \Google\Analytics\Admin\V1alpha\GetPropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProperty(\Google\Analytics\Admin\V1alpha\GetPropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetProperty',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child Properties under the specified parent Account.
     *
     * Only "GA4" properties will be returned.
     * Properties will be excluded if the caller does not have access.
     * Soft-deleted (ie: "trashed") properties are excluded by default.
     * Returns an empty list if no relevant properties are found.
     * @param \Google\Analytics\Admin\V1alpha\ListPropertiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProperties(\Google\Analytics\Admin\V1alpha\ListPropertiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListProperties',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListPropertiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an "GA4" property with the specified location and attributes.
     * @param \Google\Analytics\Admin\V1alpha\CreatePropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateProperty(\Google\Analytics\Admin\V1alpha\CreatePropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateProperty',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks target Property as soft-deleted (ie: "trashed") and returns it.
     *
     * This API does not have a method to restore soft-deleted properties.
     * However, they can be restored using the Trash Can UI.
     *
     * If the properties are not restored before the expiration time, the Property
     * and all child resources (eg: GoogleAdsLinks, Streams, UserLinks)
     * will be permanently purged.
     * https://support.google.com/analytics/answer/6154772
     *
     * Returns an error if the target is not found, or is not an GA4 Property.
     * @param \Google\Analytics\Admin\V1alpha\DeletePropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProperty(\Google\Analytics\Admin\V1alpha\DeletePropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteProperty',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdatePropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateProperty(\Google\Analytics\Admin\V1alpha\UpdatePropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateProperty',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about a user's link to an account or property.
     * @param \Google\Analytics\Admin\V1alpha\GetUserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetUserLink(\Google\Analytics\Admin\V1alpha\GetUserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetUserLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\UserLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about multiple users' links to an account or property.
     * @param \Google\Analytics\Admin\V1alpha\BatchGetUserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchGetUserLinks(\Google\Analytics\Admin\V1alpha\BatchGetUserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchGetUserLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\BatchGetUserLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all user links on an account or property.
     * @param \Google\Analytics\Admin\V1alpha\ListUserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListUserLinks(\Google\Analytics\Admin\V1alpha\ListUserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListUserLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListUserLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all user links on an account or property, including implicit ones
     * that come from effective permissions granted by groups or organization
     * admin roles.
     *
     * If a returned user link does not have direct permissions, they cannot
     * be removed from the account or property directly with the DeleteUserLink
     * command. They have to be removed from the group/etc that gives them
     * permissions, which is currently only usable/discoverable in the GA or GMP
     * UIs.
     * @param \Google\Analytics\Admin\V1alpha\AuditUserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AuditUserLinks(\Google\Analytics\Admin\V1alpha\AuditUserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/AuditUserLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\AuditUserLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a user link on an account or property.
     *
     * If the user with the specified email already has permissions on the
     * account or property, then the user's existing permissions will be unioned
     * with the permissions specified in the new UserLink.
     * @param \Google\Analytics\Admin\V1alpha\CreateUserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateUserLink(\Google\Analytics\Admin\V1alpha\CreateUserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateUserLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\UserLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates information about multiple users' links to an account or property.
     *
     * This method is transactional. If any UserLink cannot be created, none of
     * the UserLinks will be created.
     * @param \Google\Analytics\Admin\V1alpha\BatchCreateUserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateUserLinks(\Google\Analytics\Admin\V1alpha\BatchCreateUserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchCreateUserLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\BatchCreateUserLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a user link on an account or property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateUserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateUserLink(\Google\Analytics\Admin\V1alpha\UpdateUserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateUserLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\UserLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates information about multiple users' links to an account or property.
     * @param \Google\Analytics\Admin\V1alpha\BatchUpdateUserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchUpdateUserLinks(\Google\Analytics\Admin\V1alpha\BatchUpdateUserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchUpdateUserLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\BatchUpdateUserLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a user link on an account or property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteUserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteUserLink(\Google\Analytics\Admin\V1alpha\DeleteUserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteUserLink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes information about multiple users' links to an account or property.
     * @param \Google\Analytics\Admin\V1alpha\BatchDeleteUserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchDeleteUserLinks(\Google\Analytics\Admin\V1alpha\BatchDeleteUserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/BatchDeleteUserLinks',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a FirebaseLink.
     *
     * Properties can have at most one FirebaseLink.
     * @param \Google\Analytics\Admin\V1alpha\CreateFirebaseLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFirebaseLink(\Google\Analytics\Admin\V1alpha\CreateFirebaseLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateFirebaseLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\FirebaseLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a FirebaseLink on a property
     * @param \Google\Analytics\Admin\V1alpha\DeleteFirebaseLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFirebaseLink(\Google\Analytics\Admin\V1alpha\DeleteFirebaseLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteFirebaseLink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists FirebaseLinks on a property.
     * Properties can have at most one FirebaseLink.
     * @param \Google\Analytics\Admin\V1alpha\ListFirebaseLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFirebaseLinks(\Google\Analytics\Admin\V1alpha\ListFirebaseLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListFirebaseLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListFirebaseLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the Site Tag for the specified web stream.
     * Site Tags are immutable singletons.
     * @param \Google\Analytics\Admin\V1alpha\GetGlobalSiteTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGlobalSiteTag(\Google\Analytics\Admin\V1alpha\GetGlobalSiteTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetGlobalSiteTag',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\GlobalSiteTag', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a GoogleAdsLink.
     * @param \Google\Analytics\Admin\V1alpha\CreateGoogleAdsLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateGoogleAdsLink(\Google\Analytics\Admin\V1alpha\CreateGoogleAdsLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateGoogleAdsLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\GoogleAdsLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a GoogleAdsLink on a property
     * @param \Google\Analytics\Admin\V1alpha\UpdateGoogleAdsLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGoogleAdsLink(\Google\Analytics\Admin\V1alpha\UpdateGoogleAdsLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateGoogleAdsLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\GoogleAdsLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a GoogleAdsLink on a property
     * @param \Google\Analytics\Admin\V1alpha\DeleteGoogleAdsLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteGoogleAdsLink(\Google\Analytics\Admin\V1alpha\DeleteGoogleAdsLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteGoogleAdsLink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists GoogleAdsLinks on a property.
     * @param \Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGoogleAdsLinks(\Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListGoogleAdsLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get data sharing settings on an account.
     * Data sharing settings are singletons.
     * @param \Google\Analytics\Admin\V1alpha\GetDataSharingSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataSharingSettings(\Google\Analytics\Admin\V1alpha\GetDataSharingSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataSharingSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DataSharingSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single "GA4" MeasurementProtocolSecret.
     * @param \Google\Analytics\Admin\V1alpha\GetMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMeasurementProtocolSecret(\Google\Analytics\Admin\V1alpha\GetMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetMeasurementProtocolSecret',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\MeasurementProtocolSecret', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child MeasurementProtocolSecrets under the specified parent
     * Property.
     * @param \Google\Analytics\Admin\V1alpha\ListMeasurementProtocolSecretsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMeasurementProtocolSecrets(\Google\Analytics\Admin\V1alpha\ListMeasurementProtocolSecretsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListMeasurementProtocolSecrets',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListMeasurementProtocolSecretsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a measurement protocol secret.
     * @param \Google\Analytics\Admin\V1alpha\CreateMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMeasurementProtocolSecret(\Google\Analytics\Admin\V1alpha\CreateMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateMeasurementProtocolSecret',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\MeasurementProtocolSecret', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes target MeasurementProtocolSecret.
     * @param \Google\Analytics\Admin\V1alpha\DeleteMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMeasurementProtocolSecret(\Google\Analytics\Admin\V1alpha\DeleteMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteMeasurementProtocolSecret',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a measurement protocol secret.
     * @param \Google\Analytics\Admin\V1alpha\UpdateMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMeasurementProtocolSecret(\Google\Analytics\Admin\V1alpha\UpdateMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateMeasurementProtocolSecret',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\MeasurementProtocolSecret', 'decode'],
        $metadata, $options);
    }

    /**
     * Acknowledges the terms of user data collection for the specified property.
     *
     * This acknowledgement must be completed (either in the Google Analytics UI
     * or via this API) before MeasurementProtocolSecret resources may be created.
     * @param \Google\Analytics\Admin\V1alpha\AcknowledgeUserDataCollectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AcknowledgeUserDataCollection(\Google\Analytics\Admin\V1alpha\AcknowledgeUserDataCollectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/AcknowledgeUserDataCollection',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\AcknowledgeUserDataCollectionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches through all changes to an account or its children given the
     * specified set of filters.
     * @param \Google\Analytics\Admin\V1alpha\SearchChangeHistoryEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchChangeHistoryEvents(\Google\Analytics\Admin\V1alpha\SearchChangeHistoryEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/SearchChangeHistoryEvents',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\SearchChangeHistoryEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for Google Signals settings for a property.
     * @param \Google\Analytics\Admin\V1alpha\GetGoogleSignalsSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGoogleSignalsSettings(\Google\Analytics\Admin\V1alpha\GetGoogleSignalsSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetGoogleSignalsSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\GoogleSignalsSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates Google Signals settings for a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateGoogleSignalsSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGoogleSignalsSettings(\Google\Analytics\Admin\V1alpha\UpdateGoogleSignalsSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateGoogleSignalsSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\GoogleSignalsSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a conversion event with the specified attributes.
     * @param \Google\Analytics\Admin\V1alpha\CreateConversionEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversionEvent(\Google\Analytics\Admin\V1alpha\CreateConversionEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateConversionEvent',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ConversionEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve a single conversion event.
     * @param \Google\Analytics\Admin\V1alpha\GetConversionEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversionEvent(\Google\Analytics\Admin\V1alpha\GetConversionEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetConversionEvent',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ConversionEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a conversion event in a property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteConversionEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversionEvent(\Google\Analytics\Admin\V1alpha\DeleteConversionEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteConversionEvent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of conversion events in the specified parent property.
     *
     * Returns an empty list if no conversion events are found.
     * @param \Google\Analytics\Admin\V1alpha\ListConversionEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversionEvents(\Google\Analytics\Admin\V1alpha\ListConversionEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListConversionEvents',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListConversionEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Look up a single DisplayVideo360AdvertiserLink
     * @param \Google\Analytics\Admin\V1alpha\GetDisplayVideo360AdvertiserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDisplayVideo360AdvertiserLink(\Google\Analytics\Admin\V1alpha\GetDisplayVideo360AdvertiserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDisplayVideo360AdvertiserLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all DisplayVideo360AdvertiserLinks on a property.
     * @param \Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDisplayVideo360AdvertiserLinks(\Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListDisplayVideo360AdvertiserLinks',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a DisplayVideo360AdvertiserLink.
     * This can only be utilized by users who have proper authorization both on
     * the Google Analytics property and on the Display & Video 360 advertiser.
     * Users who do not have access to the Display & Video 360 advertiser should
     * instead seek to create a DisplayVideo360LinkProposal.
     * @param \Google\Analytics\Admin\V1alpha\CreateDisplayVideo360AdvertiserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDisplayVideo360AdvertiserLink(\Google\Analytics\Admin\V1alpha\CreateDisplayVideo360AdvertiserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateDisplayVideo360AdvertiserLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a DisplayVideo360AdvertiserLink on a property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteDisplayVideo360AdvertiserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDisplayVideo360AdvertiserLink(\Google\Analytics\Admin\V1alpha\DeleteDisplayVideo360AdvertiserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteDisplayVideo360AdvertiserLink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a DisplayVideo360AdvertiserLink on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateDisplayVideo360AdvertiserLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDisplayVideo360AdvertiserLink(\Google\Analytics\Admin\V1alpha\UpdateDisplayVideo360AdvertiserLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDisplayVideo360AdvertiserLink',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single DisplayVideo360AdvertiserLinkProposal.
     * @param \Google\Analytics\Admin\V1alpha\GetDisplayVideo360AdvertiserLinkProposalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDisplayVideo360AdvertiserLinkProposal(\Google\Analytics\Admin\V1alpha\GetDisplayVideo360AdvertiserLinkProposalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDisplayVideo360AdvertiserLinkProposal',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLinkProposal', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DisplayVideo360AdvertiserLinkProposals on a property.
     * @param \Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinkProposalsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDisplayVideo360AdvertiserLinkProposals(\Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinkProposalsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListDisplayVideo360AdvertiserLinkProposals',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListDisplayVideo360AdvertiserLinkProposalsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a DisplayVideo360AdvertiserLinkProposal.
     * @param \Google\Analytics\Admin\V1alpha\CreateDisplayVideo360AdvertiserLinkProposalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDisplayVideo360AdvertiserLinkProposal(\Google\Analytics\Admin\V1alpha\CreateDisplayVideo360AdvertiserLinkProposalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateDisplayVideo360AdvertiserLinkProposal',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLinkProposal', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a DisplayVideo360AdvertiserLinkProposal on a property.
     * This can only be used on cancelled proposals.
     * @param \Google\Analytics\Admin\V1alpha\DeleteDisplayVideo360AdvertiserLinkProposalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDisplayVideo360AdvertiserLinkProposal(\Google\Analytics\Admin\V1alpha\DeleteDisplayVideo360AdvertiserLinkProposalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteDisplayVideo360AdvertiserLinkProposal',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Approves a DisplayVideo360AdvertiserLinkProposal.
     * The DisplayVideo360AdvertiserLinkProposal will be deleted and a new
     * DisplayVideo360AdvertiserLink will be created.
     * @param \Google\Analytics\Admin\V1alpha\ApproveDisplayVideo360AdvertiserLinkProposalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ApproveDisplayVideo360AdvertiserLinkProposal(\Google\Analytics\Admin\V1alpha\ApproveDisplayVideo360AdvertiserLinkProposalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ApproveDisplayVideo360AdvertiserLinkProposal',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ApproveDisplayVideo360AdvertiserLinkProposalResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a DisplayVideo360AdvertiserLinkProposal.
     * Cancelling can mean either:
     * - Declining a proposal initiated from Display & Video 360
     * - Withdrawing a proposal initiated from Google Analytics
     * After being cancelled, a proposal will eventually be deleted automatically.
     * @param \Google\Analytics\Admin\V1alpha\CancelDisplayVideo360AdvertiserLinkProposalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelDisplayVideo360AdvertiserLinkProposal(\Google\Analytics\Admin\V1alpha\CancelDisplayVideo360AdvertiserLinkProposalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CancelDisplayVideo360AdvertiserLinkProposal',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLinkProposal', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a CustomDimension.
     * @param \Google\Analytics\Admin\V1alpha\CreateCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomDimension(\Google\Analytics\Admin\V1alpha\CreateCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateCustomDimension',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\CustomDimension', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a CustomDimension on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomDimension(\Google\Analytics\Admin\V1alpha\UpdateCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateCustomDimension',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\CustomDimension', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CustomDimensions on a property.
     * @param \Google\Analytics\Admin\V1alpha\ListCustomDimensionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomDimensions(\Google\Analytics\Admin\V1alpha\ListCustomDimensionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListCustomDimensions',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListCustomDimensionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Archives a CustomDimension on a property.
     * @param \Google\Analytics\Admin\V1alpha\ArchiveCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ArchiveCustomDimension(\Google\Analytics\Admin\V1alpha\ArchiveCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ArchiveCustomDimension',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single CustomDimension.
     * @param \Google\Analytics\Admin\V1alpha\GetCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomDimension(\Google\Analytics\Admin\V1alpha\GetCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetCustomDimension',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\CustomDimension', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a CustomMetric.
     * @param \Google\Analytics\Admin\V1alpha\CreateCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomMetric(\Google\Analytics\Admin\V1alpha\CreateCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateCustomMetric',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\CustomMetric', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a CustomMetric on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomMetric(\Google\Analytics\Admin\V1alpha\UpdateCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateCustomMetric',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\CustomMetric', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CustomMetrics on a property.
     * @param \Google\Analytics\Admin\V1alpha\ListCustomMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomMetrics(\Google\Analytics\Admin\V1alpha\ListCustomMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListCustomMetrics',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListCustomMetricsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Archives a CustomMetric on a property.
     * @param \Google\Analytics\Admin\V1alpha\ArchiveCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ArchiveCustomMetric(\Google\Analytics\Admin\V1alpha\ArchiveCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ArchiveCustomMetric',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single CustomMetric.
     * @param \Google\Analytics\Admin\V1alpha\GetCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomMetric(\Google\Analytics\Admin\V1alpha\GetCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetCustomMetric',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\CustomMetric', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the singleton data retention settings for this property.
     * @param \Google\Analytics\Admin\V1alpha\GetDataRetentionSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataRetentionSettings(\Google\Analytics\Admin\V1alpha\GetDataRetentionSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataRetentionSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DataRetentionSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the singleton data retention settings for this property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateDataRetentionSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataRetentionSettings(\Google\Analytics\Admin\V1alpha\UpdateDataRetentionSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDataRetentionSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DataRetentionSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a DataStream.
     * @param \Google\Analytics\Admin\V1alpha\CreateDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataStream(\Google\Analytics\Admin\V1alpha\CreateDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a DataStream on a property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataStream(\Google\Analytics\Admin\V1alpha\DeleteDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteDataStream',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a DataStream on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataStream(\Google\Analytics\Admin\V1alpha\UpdateDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DataStreams on a property.
     * @param \Google\Analytics\Admin\V1alpha\ListDataStreamsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataStreams(\Google\Analytics\Admin\V1alpha\ListDataStreamsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListDataStreams',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListDataStreamsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single DataStream.
     * @param \Google\Analytics\Admin\V1alpha\GetDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataStream(\Google\Analytics\Admin\V1alpha\GetDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\DataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single Audience.
     * Audiences created before 2020 may not be supported.
     * @param \Google\Analytics\Admin\V1alpha\GetAudienceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAudience(\Google\Analytics\Admin\V1alpha\GetAudienceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAudience',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Audience', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Audiences on a property.
     * Audiences created before 2020 may not be supported.
     * @param \Google\Analytics\Admin\V1alpha\ListAudiencesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAudiences(\Google\Analytics\Admin\V1alpha\ListAudiencesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAudiences',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListAudiencesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an Audience.
     * @param \Google\Analytics\Admin\V1alpha\CreateAudienceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAudience(\Google\Analytics\Admin\V1alpha\CreateAudienceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateAudience',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Audience', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an Audience on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateAudienceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAudience(\Google\Analytics\Admin\V1alpha\UpdateAudienceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAudience',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\Audience', 'decode'],
        $metadata, $options);
    }

    /**
     * Archives an Audience on a property.
     * @param \Google\Analytics\Admin\V1alpha\ArchiveAudienceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ArchiveAudience(\Google\Analytics\Admin\V1alpha\ArchiveAudienceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ArchiveAudience',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a AttributionSettings singleton.
     * @param \Google\Analytics\Admin\V1alpha\GetAttributionSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAttributionSettings(\Google\Analytics\Admin\V1alpha\GetAttributionSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAttributionSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\AttributionSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates attribution settings on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateAttributionSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAttributionSettings(\Google\Analytics\Admin\V1alpha\UpdateAttributionSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAttributionSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\AttributionSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a customized report of data access records. The report provides
     * records of each time a user reads Google Analytics reporting data. Access
     * records are retained for up to 2 years.
     *
     * Data Access Reports can be requested for a property. The property must be
     * in Google Analytics 360. This method is only available to Administrators.
     *
     * These data access records include GA4 UI Reporting, GA4 UI Explorations,
     * GA4 Data API, and other products like Firebase & Admob that can retrieve
     * data from Google Analytics through a linkage. These records don't include
     * property configuration changes like adding a stream or changing a
     * property's time zone. For configuration change history, see
     * [searchChangeHistoryEvents](https://developers.google.com/analytics/devguides/config/admin/v1/rest/v1alpha/accounts/searchChangeHistoryEvents).
     * @param \Google\Analytics\Admin\V1alpha\RunAccessReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunAccessReport(\Google\Analytics\Admin\V1alpha\RunAccessReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/RunAccessReport',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\RunAccessReportResponse', 'decode'],
        $metadata, $options);
    }

}
