<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Analytics\Admin\V1beta;

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
     * @param \Google\Analytics\Admin\V1beta\GetAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccount(\Google\Analytics\Admin\V1beta\GetAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetAccount',
        $argument,
        ['\Google\Analytics\Admin\V1beta\Account', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns all accounts accessible by the caller.
     *
     * Note that these accounts might not currently have GA4 properties.
     * Soft-deleted (ie: "trashed") accounts are excluded by default.
     * Returns an empty list if no relevant accounts are found.
     * @param \Google\Analytics\Admin\V1beta\ListAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAccounts(\Google\Analytics\Admin\V1beta\ListAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListAccounts',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListAccountsResponse', 'decode'],
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
     * @param \Google\Analytics\Admin\V1beta\DeleteAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAccount(\Google\Analytics\Admin\V1beta\DeleteAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteAccount',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an account.
     * @param \Google\Analytics\Admin\V1beta\UpdateAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAccount(\Google\Analytics\Admin\V1beta\UpdateAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateAccount',
        $argument,
        ['\Google\Analytics\Admin\V1beta\Account', 'decode'],
        $metadata, $options);
    }

    /**
     * Requests a ticket for creating an account.
     * @param \Google\Analytics\Admin\V1beta\ProvisionAccountTicketRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ProvisionAccountTicket(\Google\Analytics\Admin\V1beta\ProvisionAccountTicketRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ProvisionAccountTicket',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ProvisionAccountTicketResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns summaries of all accounts accessible by the caller.
     * @param \Google\Analytics\Admin\V1beta\ListAccountSummariesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAccountSummaries(\Google\Analytics\Admin\V1beta\ListAccountSummariesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListAccountSummaries',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListAccountSummariesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single "GA4" Property.
     * @param \Google\Analytics\Admin\V1beta\GetPropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProperty(\Google\Analytics\Admin\V1beta\GetPropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetProperty',
        $argument,
        ['\Google\Analytics\Admin\V1beta\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child Properties under the specified parent Account.
     *
     * Only "GA4" properties will be returned.
     * Properties will be excluded if the caller does not have access.
     * Soft-deleted (ie: "trashed") properties are excluded by default.
     * Returns an empty list if no relevant properties are found.
     * @param \Google\Analytics\Admin\V1beta\ListPropertiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProperties(\Google\Analytics\Admin\V1beta\ListPropertiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListProperties',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListPropertiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an "GA4" property with the specified location and attributes.
     * @param \Google\Analytics\Admin\V1beta\CreatePropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateProperty(\Google\Analytics\Admin\V1beta\CreatePropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateProperty',
        $argument,
        ['\Google\Analytics\Admin\V1beta\Property', 'decode'],
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
     * Returns an error if the target is not found, or is not a GA4 Property.
     * @param \Google\Analytics\Admin\V1beta\DeletePropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProperty(\Google\Analytics\Admin\V1beta\DeletePropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteProperty',
        $argument,
        ['\Google\Analytics\Admin\V1beta\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a property.
     * @param \Google\Analytics\Admin\V1beta\UpdatePropertyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateProperty(\Google\Analytics\Admin\V1beta\UpdatePropertyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateProperty',
        $argument,
        ['\Google\Analytics\Admin\V1beta\Property', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a FirebaseLink.
     *
     * Properties can have at most one FirebaseLink.
     * @param \Google\Analytics\Admin\V1beta\CreateFirebaseLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFirebaseLink(\Google\Analytics\Admin\V1beta\CreateFirebaseLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateFirebaseLink',
        $argument,
        ['\Google\Analytics\Admin\V1beta\FirebaseLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a FirebaseLink on a property
     * @param \Google\Analytics\Admin\V1beta\DeleteFirebaseLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFirebaseLink(\Google\Analytics\Admin\V1beta\DeleteFirebaseLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteFirebaseLink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists FirebaseLinks on a property.
     * Properties can have at most one FirebaseLink.
     * @param \Google\Analytics\Admin\V1beta\ListFirebaseLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFirebaseLinks(\Google\Analytics\Admin\V1beta\ListFirebaseLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListFirebaseLinks',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListFirebaseLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a GoogleAdsLink.
     * @param \Google\Analytics\Admin\V1beta\CreateGoogleAdsLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateGoogleAdsLink(\Google\Analytics\Admin\V1beta\CreateGoogleAdsLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateGoogleAdsLink',
        $argument,
        ['\Google\Analytics\Admin\V1beta\GoogleAdsLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a GoogleAdsLink on a property
     * @param \Google\Analytics\Admin\V1beta\UpdateGoogleAdsLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGoogleAdsLink(\Google\Analytics\Admin\V1beta\UpdateGoogleAdsLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateGoogleAdsLink',
        $argument,
        ['\Google\Analytics\Admin\V1beta\GoogleAdsLink', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a GoogleAdsLink on a property
     * @param \Google\Analytics\Admin\V1beta\DeleteGoogleAdsLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteGoogleAdsLink(\Google\Analytics\Admin\V1beta\DeleteGoogleAdsLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteGoogleAdsLink',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists GoogleAdsLinks on a property.
     * @param \Google\Analytics\Admin\V1beta\ListGoogleAdsLinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGoogleAdsLinks(\Google\Analytics\Admin\V1beta\ListGoogleAdsLinksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListGoogleAdsLinks',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListGoogleAdsLinksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get data sharing settings on an account.
     * Data sharing settings are singletons.
     * @param \Google\Analytics\Admin\V1beta\GetDataSharingSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataSharingSettings(\Google\Analytics\Admin\V1beta\GetDataSharingSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetDataSharingSettings',
        $argument,
        ['\Google\Analytics\Admin\V1beta\DataSharingSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single "GA4" MeasurementProtocolSecret.
     * @param \Google\Analytics\Admin\V1beta\GetMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMeasurementProtocolSecret(\Google\Analytics\Admin\V1beta\GetMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetMeasurementProtocolSecret',
        $argument,
        ['\Google\Analytics\Admin\V1beta\MeasurementProtocolSecret', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns child MeasurementProtocolSecrets under the specified parent
     * Property.
     * @param \Google\Analytics\Admin\V1beta\ListMeasurementProtocolSecretsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMeasurementProtocolSecrets(\Google\Analytics\Admin\V1beta\ListMeasurementProtocolSecretsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListMeasurementProtocolSecrets',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListMeasurementProtocolSecretsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a measurement protocol secret.
     * @param \Google\Analytics\Admin\V1beta\CreateMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMeasurementProtocolSecret(\Google\Analytics\Admin\V1beta\CreateMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateMeasurementProtocolSecret',
        $argument,
        ['\Google\Analytics\Admin\V1beta\MeasurementProtocolSecret', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes target MeasurementProtocolSecret.
     * @param \Google\Analytics\Admin\V1beta\DeleteMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMeasurementProtocolSecret(\Google\Analytics\Admin\V1beta\DeleteMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteMeasurementProtocolSecret',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a measurement protocol secret.
     * @param \Google\Analytics\Admin\V1beta\UpdateMeasurementProtocolSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMeasurementProtocolSecret(\Google\Analytics\Admin\V1beta\UpdateMeasurementProtocolSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateMeasurementProtocolSecret',
        $argument,
        ['\Google\Analytics\Admin\V1beta\MeasurementProtocolSecret', 'decode'],
        $metadata, $options);
    }

    /**
     * Acknowledges the terms of user data collection for the specified property.
     *
     * This acknowledgement must be completed (either in the Google Analytics UI
     * or through this API) before MeasurementProtocolSecret resources may be
     * created.
     * @param \Google\Analytics\Admin\V1beta\AcknowledgeUserDataCollectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AcknowledgeUserDataCollection(\Google\Analytics\Admin\V1beta\AcknowledgeUserDataCollectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/AcknowledgeUserDataCollection',
        $argument,
        ['\Google\Analytics\Admin\V1beta\AcknowledgeUserDataCollectionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches through all changes to an account or its children given the
     * specified set of filters.
     * @param \Google\Analytics\Admin\V1beta\SearchChangeHistoryEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchChangeHistoryEvents(\Google\Analytics\Admin\V1beta\SearchChangeHistoryEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/SearchChangeHistoryEvents',
        $argument,
        ['\Google\Analytics\Admin\V1beta\SearchChangeHistoryEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a conversion event with the specified attributes.
     * @param \Google\Analytics\Admin\V1beta\CreateConversionEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversionEvent(\Google\Analytics\Admin\V1beta\CreateConversionEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateConversionEvent',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ConversionEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve a single conversion event.
     * @param \Google\Analytics\Admin\V1beta\GetConversionEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversionEvent(\Google\Analytics\Admin\V1beta\GetConversionEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetConversionEvent',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ConversionEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a conversion event in a property.
     * @param \Google\Analytics\Admin\V1beta\DeleteConversionEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversionEvent(\Google\Analytics\Admin\V1beta\DeleteConversionEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteConversionEvent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of conversion events in the specified parent property.
     *
     * Returns an empty list if no conversion events are found.
     * @param \Google\Analytics\Admin\V1beta\ListConversionEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversionEvents(\Google\Analytics\Admin\V1beta\ListConversionEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListConversionEvents',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListConversionEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a CustomDimension.
     * @param \Google\Analytics\Admin\V1beta\CreateCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomDimension(\Google\Analytics\Admin\V1beta\CreateCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateCustomDimension',
        $argument,
        ['\Google\Analytics\Admin\V1beta\CustomDimension', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a CustomDimension on a property.
     * @param \Google\Analytics\Admin\V1beta\UpdateCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomDimension(\Google\Analytics\Admin\V1beta\UpdateCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateCustomDimension',
        $argument,
        ['\Google\Analytics\Admin\V1beta\CustomDimension', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CustomDimensions on a property.
     * @param \Google\Analytics\Admin\V1beta\ListCustomDimensionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomDimensions(\Google\Analytics\Admin\V1beta\ListCustomDimensionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListCustomDimensions',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListCustomDimensionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Archives a CustomDimension on a property.
     * @param \Google\Analytics\Admin\V1beta\ArchiveCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ArchiveCustomDimension(\Google\Analytics\Admin\V1beta\ArchiveCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ArchiveCustomDimension',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single CustomDimension.
     * @param \Google\Analytics\Admin\V1beta\GetCustomDimensionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomDimension(\Google\Analytics\Admin\V1beta\GetCustomDimensionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetCustomDimension',
        $argument,
        ['\Google\Analytics\Admin\V1beta\CustomDimension', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a CustomMetric.
     * @param \Google\Analytics\Admin\V1beta\CreateCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomMetric(\Google\Analytics\Admin\V1beta\CreateCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateCustomMetric',
        $argument,
        ['\Google\Analytics\Admin\V1beta\CustomMetric', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a CustomMetric on a property.
     * @param \Google\Analytics\Admin\V1beta\UpdateCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomMetric(\Google\Analytics\Admin\V1beta\UpdateCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateCustomMetric',
        $argument,
        ['\Google\Analytics\Admin\V1beta\CustomMetric', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CustomMetrics on a property.
     * @param \Google\Analytics\Admin\V1beta\ListCustomMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomMetrics(\Google\Analytics\Admin\V1beta\ListCustomMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListCustomMetrics',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListCustomMetricsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Archives a CustomMetric on a property.
     * @param \Google\Analytics\Admin\V1beta\ArchiveCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ArchiveCustomMetric(\Google\Analytics\Admin\V1beta\ArchiveCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ArchiveCustomMetric',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single CustomMetric.
     * @param \Google\Analytics\Admin\V1beta\GetCustomMetricRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomMetric(\Google\Analytics\Admin\V1beta\GetCustomMetricRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetCustomMetric',
        $argument,
        ['\Google\Analytics\Admin\V1beta\CustomMetric', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the singleton data retention settings for this property.
     * @param \Google\Analytics\Admin\V1beta\GetDataRetentionSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataRetentionSettings(\Google\Analytics\Admin\V1beta\GetDataRetentionSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetDataRetentionSettings',
        $argument,
        ['\Google\Analytics\Admin\V1beta\DataRetentionSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the singleton data retention settings for this property.
     * @param \Google\Analytics\Admin\V1beta\UpdateDataRetentionSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataRetentionSettings(\Google\Analytics\Admin\V1beta\UpdateDataRetentionSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateDataRetentionSettings',
        $argument,
        ['\Google\Analytics\Admin\V1beta\DataRetentionSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a DataStream.
     * @param \Google\Analytics\Admin\V1beta\CreateDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataStream(\Google\Analytics\Admin\V1beta\CreateDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/CreateDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1beta\DataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a DataStream on a property.
     * @param \Google\Analytics\Admin\V1beta\DeleteDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataStream(\Google\Analytics\Admin\V1beta\DeleteDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/DeleteDataStream',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a DataStream on a property.
     * @param \Google\Analytics\Admin\V1beta\UpdateDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataStream(\Google\Analytics\Admin\V1beta\UpdateDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/UpdateDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1beta\DataStream', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DataStreams on a property.
     * @param \Google\Analytics\Admin\V1beta\ListDataStreamsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataStreams(\Google\Analytics\Admin\V1beta\ListDataStreamsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/ListDataStreams',
        $argument,
        ['\Google\Analytics\Admin\V1beta\ListDataStreamsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lookup for a single DataStream.
     * @param \Google\Analytics\Admin\V1beta\GetDataStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataStream(\Google\Analytics\Admin\V1beta\GetDataStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/GetDataStream',
        $argument,
        ['\Google\Analytics\Admin\V1beta\DataStream', 'decode'],
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
     * @param \Google\Analytics\Admin\V1beta\RunAccessReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunAccessReport(\Google\Analytics\Admin\V1beta\RunAccessReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.analytics.admin.v1beta.AnalyticsAdminService/RunAccessReport',
        $argument,
        ['\Google\Analytics\Admin\V1beta\RunAccessReportResponse', 'decode'],
        $metadata, $options);
    }

}
