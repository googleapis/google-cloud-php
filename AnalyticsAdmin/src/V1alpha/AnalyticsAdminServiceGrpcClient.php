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
     * Lookup for a single WebDataStream
     * @param \Google\Analytics\Admin\V1alpha\GetWebDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWebDataStream(\Google\Analytics\Admin\V1alpha\GetWebDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetWebDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\WebDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a web stream on a property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteWebDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteWebDataStream(\Google\Analytics\Admin\V1alpha\DeleteWebDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteWebDataStream',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a web stream on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateWebDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateWebDataStream(\Google\Analytics\Admin\V1alpha\UpdateWebDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateWebDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\WebDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a web stream with the specified location and attributes.
     * @param \Google\Analytics\Admin\V1alpha\CreateWebDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateWebDataStream(\Google\Analytics\Admin\V1alpha\CreateWebDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/CreateWebDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\WebDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child web data streams under the specified parent property.
     *
     * Web data streams will be excluded if the caller does not have access.
     * Returns an empty list if no relevant web data streams are found.
     * @param \Google\Analytics\Admin\V1alpha\ListWebDataStreamsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListWebDataStreams(\Google\Analytics\Admin\V1alpha\ListWebDataStreamsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListWebDataStreams',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListWebDataStreamsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single IosAppDataStream
     * @param \Google\Analytics\Admin\V1alpha\GetIosAppDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIosAppDataStream(\Google\Analytics\Admin\V1alpha\GetIosAppDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetIosAppDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\IosAppDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an iOS app stream on a property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteIosAppDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIosAppDataStream(\Google\Analytics\Admin\V1alpha\DeleteIosAppDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteIosAppDataStream',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an iOS app stream on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateIosAppDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIosAppDataStream(\Google\Analytics\Admin\V1alpha\UpdateIosAppDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateIosAppDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\IosAppDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child iOS app data streams under the specified parent property.
     *
     * iOS app data streams will be excluded if the caller does not have access.
     * Returns an empty list if no relevant iOS app data streams are found.
     * @param \Google\Analytics\Admin\V1alpha\ListIosAppDataStreamsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIosAppDataStreams(\Google\Analytics\Admin\V1alpha\ListIosAppDataStreamsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListIosAppDataStreams',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListIosAppDataStreamsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single AndroidAppDataStream
     * @param \Google\Analytics\Admin\V1alpha\GetAndroidAppDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAndroidAppDataStream(\Google\Analytics\Admin\V1alpha\GetAndroidAppDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetAndroidAppDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\AndroidAppDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an android app stream on a property.
     * @param \Google\Analytics\Admin\V1alpha\DeleteAndroidAppDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAndroidAppDataStream(\Google\Analytics\Admin\V1alpha\DeleteAndroidAppDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/DeleteAndroidAppDataStream',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an android app stream on a property.
     * @param \Google\Analytics\Admin\V1alpha\UpdateAndroidAppDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAndroidAppDataStream(\Google\Analytics\Admin\V1alpha\UpdateAndroidAppDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateAndroidAppDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\AndroidAppDataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child android app streams under the specified parent property.
     *
     * Android app streams will be excluded if the caller does not have access.
     * Returns an empty list if no relevant android app streams are found.
     * @param \Google\Analytics\Admin\V1alpha\ListAndroidAppDataStreamsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAndroidAppDataStreams(\Google\Analytics\Admin\V1alpha\ListAndroidAppDataStreamsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/ListAndroidAppDataStreams',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\ListAndroidAppDataStreamsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the singleton enhanced measurement settings for this web stream.
     * Note that the stream must enable enhanced measurement for these settings to
     * take effect.
     * @param \Google\Analytics\Admin\V1alpha\GetEnhancedMeasurementSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnhancedMeasurementSettings(\Google\Analytics\Admin\V1alpha\GetEnhancedMeasurementSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/GetEnhancedMeasurementSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the singleton enhanced measurement settings for this web stream.
     * Note that the stream must enable enhanced measurement for these settings to
     * take effect.
     * @param \Google\Analytics\Admin\V1alpha\UpdateEnhancedMeasurementSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEnhancedMeasurementSettings(\Google\Analytics\Admin\V1alpha\UpdateEnhancedMeasurementSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateEnhancedMeasurementSettings',
        $argument,
        ['\Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings', 'decode'],
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
     * Updates a FirebaseLink on a property
     * @param \Google\Analytics\Admin\V1alpha\UpdateFirebaseLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFirebaseLink(\Google\Analytics\Admin\V1alpha\UpdateFirebaseLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1alpha.AnalyticsAdminService/UpdateFirebaseLink',
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

}
