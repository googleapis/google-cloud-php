<?php
/*
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/analytics/admin/v1alpha/analytics_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Analytics\Admin\V1alpha\Gapic;

use Google\Analytics\Admin\V1alpha\Account;
use Google\Analytics\Admin\V1alpha\AndroidAppDataStream;
use Google\Analytics\Admin\V1alpha\AuditUserLinksRequest;
use Google\Analytics\Admin\V1alpha\AuditUserLinksResponse;
use Google\Analytics\Admin\V1alpha\BatchCreateUserLinksRequest;
use Google\Analytics\Admin\V1alpha\BatchCreateUserLinksResponse;
use Google\Analytics\Admin\V1alpha\BatchDeleteUserLinksRequest;
use Google\Analytics\Admin\V1alpha\BatchGetUserLinksRequest;
use Google\Analytics\Admin\V1alpha\BatchGetUserLinksResponse;
use Google\Analytics\Admin\V1alpha\BatchUpdateUserLinksRequest;
use Google\Analytics\Admin\V1alpha\BatchUpdateUserLinksResponse;
use Google\Analytics\Admin\V1alpha\CreateAndroidAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\CreateFirebaseLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateIosAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\CreatePropertyRequest;
use Google\Analytics\Admin\V1alpha\CreateUserLinkRequest;
use Google\Analytics\Admin\V1alpha\CreateWebDataStreamRequest;
use Google\Analytics\Admin\V1alpha\DataSharingSettings;
use Google\Analytics\Admin\V1alpha\DeleteAccountRequest;
use Google\Analytics\Admin\V1alpha\DeleteAndroidAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\DeleteFirebaseLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteIosAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\DeletePropertyRequest;
use Google\Analytics\Admin\V1alpha\DeleteUserLinkRequest;
use Google\Analytics\Admin\V1alpha\DeleteWebDataStreamRequest;
use Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings;
use Google\Analytics\Admin\V1alpha\FirebaseLink;
use Google\Analytics\Admin\V1alpha\GetAccountRequest;
use Google\Analytics\Admin\V1alpha\GetAndroidAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\GetDataSharingSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetEnhancedMeasurementSettingsRequest;
use Google\Analytics\Admin\V1alpha\GetGlobalSiteTagRequest;
use Google\Analytics\Admin\V1alpha\GetIosAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\GetPropertyRequest;
use Google\Analytics\Admin\V1alpha\GetUserLinkRequest;
use Google\Analytics\Admin\V1alpha\GetWebDataStreamRequest;
use Google\Analytics\Admin\V1alpha\GlobalSiteTag;
use Google\Analytics\Admin\V1alpha\GoogleAdsLink;
use Google\Analytics\Admin\V1alpha\IosAppDataStream;
use Google\Analytics\Admin\V1alpha\ListAccountSummariesRequest;
use Google\Analytics\Admin\V1alpha\ListAccountSummariesResponse;
use Google\Analytics\Admin\V1alpha\ListAccountsRequest;
use Google\Analytics\Admin\V1alpha\ListAccountsResponse;
use Google\Analytics\Admin\V1alpha\ListAndroidAppDataStreamsRequest;
use Google\Analytics\Admin\V1alpha\ListAndroidAppDataStreamsResponse;
use Google\Analytics\Admin\V1alpha\ListFirebaseLinksRequest;
use Google\Analytics\Admin\V1alpha\ListFirebaseLinksResponse;
use Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksRequest;
use Google\Analytics\Admin\V1alpha\ListGoogleAdsLinksResponse;
use Google\Analytics\Admin\V1alpha\ListIosAppDataStreamsRequest;
use Google\Analytics\Admin\V1alpha\ListIosAppDataStreamsResponse;
use Google\Analytics\Admin\V1alpha\ListPropertiesRequest;
use Google\Analytics\Admin\V1alpha\ListPropertiesResponse;
use Google\Analytics\Admin\V1alpha\ListUserLinksRequest;
use Google\Analytics\Admin\V1alpha\ListUserLinksResponse;
use Google\Analytics\Admin\V1alpha\ListWebDataStreamsRequest;
use Google\Analytics\Admin\V1alpha\ListWebDataStreamsResponse;
use Google\Analytics\Admin\V1alpha\Property;
use Google\Analytics\Admin\V1alpha\ProvisionAccountTicketRequest;
use Google\Analytics\Admin\V1alpha\ProvisionAccountTicketResponse;
use Google\Analytics\Admin\V1alpha\UpdateAccountRequest;
use Google\Analytics\Admin\V1alpha\UpdateAndroidAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\UpdateEnhancedMeasurementSettingsRequest;
use Google\Analytics\Admin\V1alpha\UpdateFirebaseLinkRequest;
use Google\Analytics\Admin\V1alpha\UpdateGoogleAdsLinkRequest;
use Google\Analytics\Admin\V1alpha\UpdateIosAppDataStreamRequest;
use Google\Analytics\Admin\V1alpha\UpdatePropertyRequest;
use Google\Analytics\Admin\V1alpha\UpdateUserLinkRequest;
use Google\Analytics\Admin\V1alpha\UpdateWebDataStreamRequest;
use Google\Analytics\Admin\V1alpha\UserLink;
use Google\Analytics\Admin\V1alpha\WebDataStream;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service Interface for the Analytics Admin API (GA4).
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
 * try {
 *     $formattedName = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
 *     $response = $analyticsAdminServiceClient->getAccount($formattedName);
 * } finally {
 *     $analyticsAdminServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 *
 * @experimental
 */
class AnalyticsAdminServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.analytics.admin.v1alpha.AnalyticsAdminService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'analyticsadmin.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/analytics.edit',
        'https://www.googleapis.com/auth/analytics.manage.users',
        'https://www.googleapis.com/auth/analytics.manage.users.readonly',
        'https://www.googleapis.com/auth/analytics.readonly',
    ];
    private static $accountNameTemplate;
    private static $accountUserLinkNameTemplate;
    private static $androidAppDataStreamNameTemplate;
    private static $dataSharingSettingsNameTemplate;
    private static $enhancedMeasurementSettingsNameTemplate;
    private static $firebaseLinkNameTemplate;
    private static $globalSiteTagNameTemplate;
    private static $googleAdsLinkNameTemplate;
    private static $iosAppDataStreamNameTemplate;
    private static $propertyNameTemplate;
    private static $propertyUserLinkNameTemplate;
    private static $userLinkNameTemplate;
    private static $webDataStreamNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/analytics_admin_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/analytics_admin_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/analytics_admin_service_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/analytics_admin_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAccountNameTemplate()
    {
        if (null == self::$accountNameTemplate) {
            self::$accountNameTemplate = new PathTemplate('accounts/{account}');
        }

        return self::$accountNameTemplate;
    }

    private static function getAccountUserLinkNameTemplate()
    {
        if (null == self::$accountUserLinkNameTemplate) {
            self::$accountUserLinkNameTemplate = new PathTemplate('accounts/{account}/userLinks/{user_link}');
        }

        return self::$accountUserLinkNameTemplate;
    }

    private static function getAndroidAppDataStreamNameTemplate()
    {
        if (null == self::$androidAppDataStreamNameTemplate) {
            self::$androidAppDataStreamNameTemplate = new PathTemplate('properties/{property}/androidAppDataStreams/{android_app_data_stream}');
        }

        return self::$androidAppDataStreamNameTemplate;
    }

    private static function getDataSharingSettingsNameTemplate()
    {
        if (null == self::$dataSharingSettingsNameTemplate) {
            self::$dataSharingSettingsNameTemplate = new PathTemplate('accounts/{account}/dataSharingSettings');
        }

        return self::$dataSharingSettingsNameTemplate;
    }

    private static function getEnhancedMeasurementSettingsNameTemplate()
    {
        if (null == self::$enhancedMeasurementSettingsNameTemplate) {
            self::$enhancedMeasurementSettingsNameTemplate = new PathTemplate('properties/{property}/webDataStreams/{web_data_stream}/enhancedMeasurementSettings');
        }

        return self::$enhancedMeasurementSettingsNameTemplate;
    }

    private static function getFirebaseLinkNameTemplate()
    {
        if (null == self::$firebaseLinkNameTemplate) {
            self::$firebaseLinkNameTemplate = new PathTemplate('properties/{property}/firebaseLinks/{firebase_link}');
        }

        return self::$firebaseLinkNameTemplate;
    }

    private static function getGlobalSiteTagNameTemplate()
    {
        if (null == self::$globalSiteTagNameTemplate) {
            self::$globalSiteTagNameTemplate = new PathTemplate('properties/{property}/globalSiteTag');
        }

        return self::$globalSiteTagNameTemplate;
    }

    private static function getGoogleAdsLinkNameTemplate()
    {
        if (null == self::$googleAdsLinkNameTemplate) {
            self::$googleAdsLinkNameTemplate = new PathTemplate('properties/{property}/googleAdsLinks/{google_ads_link}');
        }

        return self::$googleAdsLinkNameTemplate;
    }

    private static function getIosAppDataStreamNameTemplate()
    {
        if (null == self::$iosAppDataStreamNameTemplate) {
            self::$iosAppDataStreamNameTemplate = new PathTemplate('properties/{property}/iosAppDataStreams/{ios_app_data_stream}');
        }

        return self::$iosAppDataStreamNameTemplate;
    }

    private static function getPropertyNameTemplate()
    {
        if (null == self::$propertyNameTemplate) {
            self::$propertyNameTemplate = new PathTemplate('properties/{property}');
        }

        return self::$propertyNameTemplate;
    }

    private static function getPropertyUserLinkNameTemplate()
    {
        if (null == self::$propertyUserLinkNameTemplate) {
            self::$propertyUserLinkNameTemplate = new PathTemplate('properties/{property}/userLinks/{user_link}');
        }

        return self::$propertyUserLinkNameTemplate;
    }

    private static function getUserLinkNameTemplate()
    {
        if (null == self::$userLinkNameTemplate) {
            self::$userLinkNameTemplate = new PathTemplate('accounts/{account}/userLinks/{user_link}');
        }

        return self::$userLinkNameTemplate;
    }

    private static function getWebDataStreamNameTemplate()
    {
        if (null == self::$webDataStreamNameTemplate) {
            self::$webDataStreamNameTemplate = new PathTemplate('properties/{property}/webDataStreams/{web_data_stream}');
        }

        return self::$webDataStreamNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'account' => self::getAccountNameTemplate(),
                'accountUserLink' => self::getAccountUserLinkNameTemplate(),
                'androidAppDataStream' => self::getAndroidAppDataStreamNameTemplate(),
                'dataSharingSettings' => self::getDataSharingSettingsNameTemplate(),
                'enhancedMeasurementSettings' => self::getEnhancedMeasurementSettingsNameTemplate(),
                'firebaseLink' => self::getFirebaseLinkNameTemplate(),
                'globalSiteTag' => self::getGlobalSiteTagNameTemplate(),
                'googleAdsLink' => self::getGoogleAdsLinkNameTemplate(),
                'iosAppDataStream' => self::getIosAppDataStreamNameTemplate(),
                'property' => self::getPropertyNameTemplate(),
                'propertyUserLink' => self::getPropertyUserLinkNameTemplate(),
                'userLink' => self::getUserLinkNameTemplate(),
                'webDataStream' => self::getWebDataStreamNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a account resource.
     *
     * @param string $account
     *
     * @return string The formatted account resource.
     * @experimental
     */
    public static function accountName($account)
    {
        return self::getAccountNameTemplate()->render([
            'account' => $account,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a account_user_link resource.
     *
     * @param string $account
     * @param string $userLink
     *
     * @return string The formatted account_user_link resource.
     * @experimental
     */
    public static function accountUserLinkName($account, $userLink)
    {
        return self::getAccountUserLinkNameTemplate()->render([
            'account' => $account,
            'user_link' => $userLink,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a android_app_data_stream resource.
     *
     * @param string $property
     * @param string $androidAppDataStream
     *
     * @return string The formatted android_app_data_stream resource.
     * @experimental
     */
    public static function androidAppDataStreamName($property, $androidAppDataStream)
    {
        return self::getAndroidAppDataStreamNameTemplate()->render([
            'property' => $property,
            'android_app_data_stream' => $androidAppDataStream,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a data_sharing_settings resource.
     *
     * @param string $account
     *
     * @return string The formatted data_sharing_settings resource.
     * @experimental
     */
    public static function dataSharingSettingsName($account)
    {
        return self::getDataSharingSettingsNameTemplate()->render([
            'account' => $account,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a enhanced_measurement_settings resource.
     *
     * @param string $property
     * @param string $webDataStream
     *
     * @return string The formatted enhanced_measurement_settings resource.
     * @experimental
     */
    public static function enhancedMeasurementSettingsName($property, $webDataStream)
    {
        return self::getEnhancedMeasurementSettingsNameTemplate()->render([
            'property' => $property,
            'web_data_stream' => $webDataStream,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a firebase_link resource.
     *
     * @param string $property
     * @param string $firebaseLink
     *
     * @return string The formatted firebase_link resource.
     * @experimental
     */
    public static function firebaseLinkName($property, $firebaseLink)
    {
        return self::getFirebaseLinkNameTemplate()->render([
            'property' => $property,
            'firebase_link' => $firebaseLink,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a global_site_tag resource.
     *
     * @param string $property
     *
     * @return string The formatted global_site_tag resource.
     * @experimental
     */
    public static function globalSiteTagName($property)
    {
        return self::getGlobalSiteTagNameTemplate()->render([
            'property' => $property,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a google_ads_link resource.
     *
     * @param string $property
     * @param string $googleAdsLink
     *
     * @return string The formatted google_ads_link resource.
     * @experimental
     */
    public static function googleAdsLinkName($property, $googleAdsLink)
    {
        return self::getGoogleAdsLinkNameTemplate()->render([
            'property' => $property,
            'google_ads_link' => $googleAdsLink,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a ios_app_data_stream resource.
     *
     * @param string $property
     * @param string $iosAppDataStream
     *
     * @return string The formatted ios_app_data_stream resource.
     * @experimental
     */
    public static function iosAppDataStreamName($property, $iosAppDataStream)
    {
        return self::getIosAppDataStreamNameTemplate()->render([
            'property' => $property,
            'ios_app_data_stream' => $iosAppDataStream,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a property resource.
     *
     * @param string $property
     *
     * @return string The formatted property resource.
     * @experimental
     */
    public static function propertyName($property)
    {
        return self::getPropertyNameTemplate()->render([
            'property' => $property,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a property_user_link resource.
     *
     * @param string $property
     * @param string $userLink
     *
     * @return string The formatted property_user_link resource.
     * @experimental
     */
    public static function propertyUserLinkName($property, $userLink)
    {
        return self::getPropertyUserLinkNameTemplate()->render([
            'property' => $property,
            'user_link' => $userLink,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a user_link resource.
     *
     * @param string $account
     * @param string $userLink
     *
     * @return string The formatted user_link resource.
     * @experimental
     */
    public static function userLinkName($account, $userLink)
    {
        return self::getUserLinkNameTemplate()->render([
            'account' => $account,
            'user_link' => $userLink,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a web_data_stream resource.
     *
     * @param string $property
     * @param string $webDataStream
     *
     * @return string The formatted web_data_stream resource.
     * @experimental
     */
    public static function webDataStreamName($property, $webDataStream)
    {
        return self::getWebDataStreamNameTemplate()->render([
            'property' => $property,
            'web_data_stream' => $webDataStream,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - account: accounts/{account}
     * - accountUserLink: accounts/{account}/userLinks/{user_link}
     * - androidAppDataStream: properties/{property}/androidAppDataStreams/{android_app_data_stream}
     * - dataSharingSettings: accounts/{account}/dataSharingSettings
     * - enhancedMeasurementSettings: properties/{property}/webDataStreams/{web_data_stream}/enhancedMeasurementSettings
     * - firebaseLink: properties/{property}/firebaseLinks/{firebase_link}
     * - globalSiteTag: properties/{property}/globalSiteTag
     * - googleAdsLink: properties/{property}/googleAdsLinks/{google_ads_link}
     * - iosAppDataStream: properties/{property}/iosAppDataStreams/{ios_app_data_stream}
     * - property: properties/{property}
     * - propertyUserLink: properties/{property}/userLinks/{user_link}
     * - userLink: accounts/{account}/userLinks/{user_link}
     * - webDataStream: properties/{property}/webDataStreams/{web_data_stream}.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @experimental
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'analyticsadmin.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Lookup for a single Account.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $response = $analyticsAdminServiceClient->getAccount($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the account to lookup.
     *                             Format: accounts/{account}
     *                             Example: "accounts/100"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\Account
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getAccount($name, array $optionalArgs = [])
    {
        $request = new GetAccountRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetAccount',
            Account::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns all accounts accessible by the caller.
     *
     * Note that these accounts might not currently have GA4 properties.
     * Soft-deleted (ie: "trashed") accounts are excluded by default.
     * Returns an empty list if no relevant accounts are found.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listAccounts();
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listAccounts();
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type bool $showDeleted
     *          Whether to include soft-deleted (ie: "trashed") Accounts in the
     *          results. Accounts can be inspected to determine whether they are deleted or
     *          not.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listAccounts(array $optionalArgs = [])
    {
        $request = new ListAccountsRequest();
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['showDeleted'])) {
            $request->setShowDeleted($optionalArgs['showDeleted']);
        }

        return $this->getPagedListResponse(
            'ListAccounts',
            $optionalArgs,
            ListAccountsResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $analyticsAdminServiceClient->deleteAccount($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the Account to soft-delete.
     *                             Format: accounts/{account}
     *                             Example: "accounts/100"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteAccount($name, array $optionalArgs = [])
    {
        $request = new DeleteAccountRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteAccount',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an account.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $account = new Account();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateAccount($account, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param Account   $account      Required. The account to update.
     *                                The account's `name` field is used to identify the account.
     * @param FieldMask $updateMask   Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                To replace the entire entity, use one path with the string "*" to match
     *                                all fields.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\Account
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateAccount($account, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateAccountRequest();
        $request->setAccount($account);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'account.name' => $request->getAccount()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateAccount',
            Account::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Requests a ticket for creating an account.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $response = $analyticsAdminServiceClient->provisionAccountTicket();
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type Account $account
     *          The account to create.
     *     @type string $redirectUri
     *          Redirect URI where the user will be sent after accepting Terms of Service.
     *          Must be configured in Developers Console as a Redirect URI
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\ProvisionAccountTicketResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function provisionAccountTicket(array $optionalArgs = [])
    {
        $request = new ProvisionAccountTicketRequest();
        if (isset($optionalArgs['account'])) {
            $request->setAccount($optionalArgs['account']);
        }
        if (isset($optionalArgs['redirectUri'])) {
            $request->setRedirectUri($optionalArgs['redirectUri']);
        }

        return $this->startCall(
            'ProvisionAccountTicket',
            ProvisionAccountTicketResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns summaries of all accounts accessible by the caller.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listAccountSummaries();
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listAccountSummaries();
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listAccountSummaries(array $optionalArgs = [])
    {
        $request = new ListAccountSummariesRequest();
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListAccountSummaries',
            $optionalArgs,
            ListAccountSummariesResponse::class,
            $request
        );
    }

    /**
     * Lookup for a single "GA4" Property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $response = $analyticsAdminServiceClient->getProperty($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the property to lookup.
     *                             Format: properties/{property_id}
     *                             Example: "properties/1000"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\Property
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getProperty($name, array $optionalArgs = [])
    {
        $request = new GetPropertyRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetProperty',
            Property::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns child Properties under the specified parent Account.
     *
     * Only "GA4" properties will be returned.
     * Properties will be excluded if the caller does not have access.
     * Soft-deleted (ie: "trashed") properties are excluded by default.
     * Returns an empty list if no relevant properties are found.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $filter = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listProperties($filter);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listProperties($filter);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $filter Required. An expression for filtering the results of the request.
     *                       Fields eligible for filtering are:
     *                       `parent:`(The resource name of the parent account) or
     *                       `firebase_project:`(The id or number of the linked firebase project).
     *                       Some examples of filters:
     *
     * ```
     * | Filter                      | Description                               |
     * |-----------------------------|-------------------------------------------|
     * | parent:accounts/123         | The account with account id: 123.         |
     * | firebase_project:project-id | The firebase project with id: project-id. |
     * | firebase_project:123        | The firebase project with number: 123.    |
     * ```
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type bool $showDeleted
     *          Whether to include soft-deleted (ie: "trashed") Properties in the
     *          results. Properties can be inspected to determine whether they are deleted
     *          or not.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listProperties($filter, array $optionalArgs = [])
    {
        $request = new ListPropertiesRequest();
        $request->setFilter($filter);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['showDeleted'])) {
            $request->setShowDeleted($optionalArgs['showDeleted']);
        }

        return $this->getPagedListResponse(
            'ListProperties',
            $optionalArgs,
            ListPropertiesResponse::class,
            $request
        );
    }

    /**
     * Creates an "GA4" property with the specified location and attributes.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $property = new Property();
     *     $response = $analyticsAdminServiceClient->createProperty($property);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param Property $property     Required. The property to create.
     *                               Note: the supplied property must specify its parent.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\Property
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createProperty($property, array $optionalArgs = [])
    {
        $request = new CreatePropertyRequest();
        $request->setProperty($property);

        return $this->startCall(
            'CreateProperty',
            Property::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $analyticsAdminServiceClient->deleteProperty($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the Property to soft-delete.
     *                             Format: properties/{property_id}
     *                             Example: "properties/1000"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteProperty($name, array $optionalArgs = [])
    {
        $request = new DeletePropertyRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteProperty',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $property = new Property();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateProperty($property, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param Property  $property     Required. The property to update.
     *                                The property's `name` field is used to identify the property to be
     *                                updated.
     * @param FieldMask $updateMask   Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                To replace the entire entity, use one path with the string "*" to match
     *                                all fields.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\Property
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateProperty($property, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdatePropertyRequest();
        $request->setProperty($property);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'property.name' => $request->getProperty()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateProperty',
            Property::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets information about a user's link to an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $name = '';
     *     $response = $analyticsAdminServiceClient->getUserLink($name);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Example format: accounts/1234/userLinks/5678
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\UserLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getUserLink($name, array $optionalArgs = [])
    {
        $request = new GetUserLinkRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetUserLink',
            UserLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets information about multiple users' links to an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $names = [];
     *     $response = $analyticsAdminServiceClient->batchGetUserLinks($formattedParent, $names);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The account or property that all user links in the request are
     *                               for. The parent of all provided values for the 'names' field must match
     *                               this field.
     *                               Example format: accounts/1234
     * @param string[] $names        Required. The names of the user links to retrieve.
     *                               A maximum of 1000 user links can be retrieved in a batch.
     *                               Format: accounts/{accountId}/userLinks/{userLinkId}
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\BatchGetUserLinksResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchGetUserLinks($parent, $names, array $optionalArgs = [])
    {
        $request = new BatchGetUserLinksRequest();
        $request->setParent($parent);
        $request->setNames($names);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BatchGetUserLinks',
            BatchGetUserLinksResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all user links on an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listUserLinks($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listUserLinks($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. Example format: accounts/1234
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listUserLinks($parent, array $optionalArgs = [])
    {
        $request = new ListUserLinksRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListUserLinks',
            $optionalArgs,
            ListUserLinksResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->auditUserLinks($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->auditUserLinks($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. Example format: accounts/1234
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function auditUserLinks($parent, array $optionalArgs = [])
    {
        $request = new AuditUserLinksRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'AuditUserLinks',
            $optionalArgs,
            AuditUserLinksResponse::class,
            $request
        );
    }

    /**
     * Creates a user link on an account or property.
     *
     * If the user with the specified email already has permissions on the
     * account or property, then the user's existing permissions will be unioned
     * with the permissions specified in the new UserLink.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $userLink = new UserLink();
     *     $response = $analyticsAdminServiceClient->createUserLink($formattedParent, $userLink);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. Example format: accounts/1234
     * @param UserLink $userLink     Required. The user link to create.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type bool $notifyNewUser
     *          Optional. If set, then email the new user notifying them that they've been granted
     *          permissions to the resource.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\UserLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createUserLink($parent, $userLink, array $optionalArgs = [])
    {
        $request = new CreateUserLinkRequest();
        $request->setParent($parent);
        $request->setUserLink($userLink);
        if (isset($optionalArgs['notifyNewUser'])) {
            $request->setNotifyNewUser($optionalArgs['notifyNewUser']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateUserLink',
            UserLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates information about multiple users' links to an account or property.
     *
     * This method is transactional. If any UserLink cannot be created, none of
     * the UserLinks will be created.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $requests = [];
     *     $response = $analyticsAdminServiceClient->batchCreateUserLinks($formattedParent, $requests);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string                  $parent       Required. The account or property that all user links in the request are for.
     *                                              This field is required. The parent field in the CreateUserLinkRequest
     *                                              messages must either be empty or match this field.
     *                                              Example format: accounts/1234
     * @param CreateUserLinkRequest[] $requests     Required. The requests specifying the user links to create.
     *                                              A maximum of 1000 user links can be created in a batch.
     * @param array                   $optionalArgs {
     *                                              Optional.
     *
     *     @type bool $notifyNewUsers
     *          Optional. If set, then email the new users notifying them that they've been granted
     *          permissions to the resource. Regardless of whether this is set or not,
     *          notify_new_user field inside each individual request is ignored.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\BatchCreateUserLinksResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchCreateUserLinks($parent, $requests, array $optionalArgs = [])
    {
        $request = new BatchCreateUserLinksRequest();
        $request->setParent($parent);
        $request->setRequests($requests);
        if (isset($optionalArgs['notifyNewUsers'])) {
            $request->setNotifyNewUsers($optionalArgs['notifyNewUsers']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BatchCreateUserLinks',
            BatchCreateUserLinksResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a user link on an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $userLink = new UserLink();
     *     $response = $analyticsAdminServiceClient->updateUserLink($userLink);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param UserLink $userLink     Required. The user link to update.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\UserLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateUserLink($userLink, array $optionalArgs = [])
    {
        $request = new UpdateUserLinkRequest();
        $request->setUserLink($userLink);

        $requestParams = new RequestParamsHeaderDescriptor([
          'user_link.name' => $request->getUserLink()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateUserLink',
            UserLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates information about multiple users' links to an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $requests = [];
     *     $response = $analyticsAdminServiceClient->batchUpdateUserLinks($formattedParent, $requests);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string                  $parent       Required. The account or property that all user links in the request are
     *                                              for. The parent field in the UpdateUserLinkRequest messages must either be
     *                                              empty or match this field.
     *                                              Example format: accounts/1234
     * @param UpdateUserLinkRequest[] $requests     Required. The requests specifying the user links to update.
     *                                              A maximum of 1000 user links can be updated in a batch.
     * @param array                   $optionalArgs {
     *                                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\BatchUpdateUserLinksResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchUpdateUserLinks($parent, $requests, array $optionalArgs = [])
    {
        $request = new BatchUpdateUserLinksRequest();
        $request->setParent($parent);
        $request->setRequests($requests);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BatchUpdateUserLinks',
            BatchUpdateUserLinksResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a user link on an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $name = '';
     *     $analyticsAdminServiceClient->deleteUserLink($name);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Example format: accounts/1234/userLinks/5678
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteUserLink($name, array $optionalArgs = [])
    {
        $request = new DeleteUserLinkRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteUserLink',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes information about multiple users' links to an account or property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->accountName('[ACCOUNT]');
     *     $requests = [];
     *     $analyticsAdminServiceClient->batchDeleteUserLinks($formattedParent, $requests);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string                  $parent       Required. The account or property that all user links in the request are
     *                                              for. The parent of all values for user link names to delete must match this
     *                                              field.
     *                                              Example format: accounts/1234
     * @param DeleteUserLinkRequest[] $requests     Required. The requests specifying the user links to update.
     *                                              A maximum of 1000 user links can be updated in a batch.
     * @param array                   $optionalArgs {
     *                                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchDeleteUserLinks($parent, $requests, array $optionalArgs = [])
    {
        $request = new BatchDeleteUserLinksRequest();
        $request->setParent($parent);
        $request->setRequests($requests);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BatchDeleteUserLinks',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lookup for a single WebDataStream.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->webDataStreamName('[PROPERTY]', '[WEB_DATA_STREAM]');
     *     $response = $analyticsAdminServiceClient->getWebDataStream($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the web data stream to lookup.
     *                             Format: properties/{property_id}/webDataStreams/{stream_id}
     *                             Example: "properties/123/webDataStreams/456"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\WebDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getWebDataStream($name, array $optionalArgs = [])
    {
        $request = new GetWebDataStreamRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetWebDataStream',
            WebDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a web stream on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->webDataStreamName('[PROPERTY]', '[WEB_DATA_STREAM]');
     *     $analyticsAdminServiceClient->deleteWebDataStream($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the web data stream to delete.
     *                             Format: properties/{property_id}/webDataStreams/{stream_id}
     *                             Example: "properties/123/webDataStreams/456"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteWebDataStream($name, array $optionalArgs = [])
    {
        $request = new DeleteWebDataStreamRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteWebDataStream',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a web stream on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $webDataStream = new WebDataStream();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateWebDataStream($webDataStream, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param WebDataStream $webDataStream Required. The web stream to update.
     *                                     The `name` field is used to identify the web stream to be updated.
     * @param FieldMask     $updateMask    Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                     To replace the entire entity, use one path with the string "*" to match
     *                                     all fields.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\WebDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateWebDataStream($webDataStream, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateWebDataStreamRequest();
        $request->setWebDataStream($webDataStream);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'web_data_stream.name' => $request->getWebDataStream()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateWebDataStream',
            WebDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a web stream with the specified location and attributes.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $webDataStream = new WebDataStream();
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $response = $analyticsAdminServiceClient->createWebDataStream($webDataStream, $formattedParent);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param WebDataStream $webDataStream Required. The web stream to create.
     * @param string        $parent        Required. The parent resource where this web data stream will be created.
     *                                     Format: properties/123
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\WebDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createWebDataStream($webDataStream, $parent, array $optionalArgs = [])
    {
        $request = new CreateWebDataStreamRequest();
        $request->setWebDataStream($webDataStream);
        $request->setParent($parent);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateWebDataStream',
            WebDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns child web data streams under the specified parent property.
     *
     * Web data streams will be excluded if the caller does not have access.
     * Returns an empty list if no relevant web data streams are found.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listWebDataStreams($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listWebDataStreams($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the parent property.
     *                             For example, to list results of web streams under the property with Id
     *                             123: "properties/123"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listWebDataStreams($parent, array $optionalArgs = [])
    {
        $request = new ListWebDataStreamsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListWebDataStreams',
            $optionalArgs,
            ListWebDataStreamsResponse::class,
            $request
        );
    }

    /**
     * Lookup for a single IosAppDataStream.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->iosAppDataStreamName('[PROPERTY]', '[IOS_APP_DATA_STREAM]');
     *     $response = $analyticsAdminServiceClient->getIosAppDataStream($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the iOS app data stream to lookup.
     *                             Format: properties/{property_id}/iosAppDataStreams/{stream_id}
     *                             Example: "properties/123/iosAppDataStreams/456"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\IosAppDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIosAppDataStream($name, array $optionalArgs = [])
    {
        $request = new GetIosAppDataStreamRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIosAppDataStream',
            IosAppDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an iOS app stream on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->iosAppDataStreamName('[PROPERTY]', '[IOS_APP_DATA_STREAM]');
     *     $analyticsAdminServiceClient->deleteIosAppDataStream($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the iOS app data stream to delete.
     *                             Format: properties/{property_id}/iosAppDataStreams/{stream_id}
     *                             Example: "properties/123/iosAppDataStreams/456"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteIosAppDataStream($name, array $optionalArgs = [])
    {
        $request = new DeleteIosAppDataStreamRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteIosAppDataStream',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an iOS app stream on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $iosAppDataStream = new IosAppDataStream();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateIosAppDataStream($iosAppDataStream, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param IosAppDataStream $iosAppDataStream Required. The iOS app stream to update.
     *                                           The `name` field is used to identify the iOS app stream to be updated.
     * @param FieldMask        $updateMask       Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                           To replace the entire entity, use one path with the string "*" to match
     *                                           all fields.
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\IosAppDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateIosAppDataStream($iosAppDataStream, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateIosAppDataStreamRequest();
        $request->setIosAppDataStream($iosAppDataStream);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'ios_app_data_stream.name' => $request->getIosAppDataStream()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateIosAppDataStream',
            IosAppDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates an iOS app data stream with the specified location and attributes.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $iosAppDataStream = new IosAppDataStream();
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $response = $analyticsAdminServiceClient->createIosAppDataStream($iosAppDataStream, $formattedParent);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param IosAppDataStream $iosAppDataStream Required. The iOS app data stream to create.
     * @param string           $parent           Required. The parent resource where this ios app data stream will be created.
     *                                           Format: properties/123
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\IosAppDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createIosAppDataStream($iosAppDataStream, $parent, array $optionalArgs = [])
    {
        $request = new CreateIosAppDataStreamRequest();
        $request->setIosAppDataStream($iosAppDataStream);
        $request->setParent($parent);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateIosAppDataStream',
            IosAppDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns child iOS app data streams under the specified parent property.
     *
     * iOS app data streams will be excluded if the caller does not have access.
     * Returns an empty list if no relevant iOS app data streams are found.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listIosAppDataStreams($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listIosAppDataStreams($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the parent property.
     *                             For example, to list results of app streams under the property with Id
     *                             123: "properties/123"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listIosAppDataStreams($parent, array $optionalArgs = [])
    {
        $request = new ListIosAppDataStreamsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListIosAppDataStreams',
            $optionalArgs,
            ListIosAppDataStreamsResponse::class,
            $request
        );
    }

    /**
     * Lookup for a single AndroidAppDataStream.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->androidAppDataStreamName('[PROPERTY]', '[ANDROID_APP_DATA_STREAM]');
     *     $response = $analyticsAdminServiceClient->getAndroidAppDataStream($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the android app data stream to lookup.
     *                             Format: properties/{property_id}/androidAppDataStreams/{stream_id}
     *                             Example: "properties/123/androidAppDataStreams/456"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\AndroidAppDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getAndroidAppDataStream($name, array $optionalArgs = [])
    {
        $request = new GetAndroidAppDataStreamRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetAndroidAppDataStream',
            AndroidAppDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an android app stream on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->androidAppDataStreamName('[PROPERTY]', '[ANDROID_APP_DATA_STREAM]');
     *     $analyticsAdminServiceClient->deleteAndroidAppDataStream($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the android app data stream to delete.
     *                             Format: properties/{property_id}/androidAppDataStreams/{stream_id}
     *                             Example: "properties/123/androidAppDataStreams/456"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteAndroidAppDataStream($name, array $optionalArgs = [])
    {
        $request = new DeleteAndroidAppDataStreamRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteAndroidAppDataStream',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an android app stream on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $androidAppDataStream = new AndroidAppDataStream();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateAndroidAppDataStream($androidAppDataStream, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param AndroidAppDataStream $androidAppDataStream Required. The android app stream to update.
     *                                                   The `name` field is used to identify the android app stream to be updated.
     * @param FieldMask            $updateMask           Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                                   To replace the entire entity, use one path with the string "*" to match
     *                                                   all fields.
     * @param array                $optionalArgs         {
     *                                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\AndroidAppDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateAndroidAppDataStream($androidAppDataStream, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateAndroidAppDataStreamRequest();
        $request->setAndroidAppDataStream($androidAppDataStream);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'android_app_data_stream.name' => $request->getAndroidAppDataStream()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateAndroidAppDataStream',
            AndroidAppDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates an android app stream with the specified location and attributes.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $androidAppDataStream = new AndroidAppDataStream();
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $response = $analyticsAdminServiceClient->createAndroidAppDataStream($androidAppDataStream, $formattedParent);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param AndroidAppDataStream $androidAppDataStream Required. The android app stream to create.
     * @param string               $parent               Required. The parent resource where this android app data stream will be created.
     *                                                   Format: properties/123
     * @param array                $optionalArgs         {
     *                                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\AndroidAppDataStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createAndroidAppDataStream($androidAppDataStream, $parent, array $optionalArgs = [])
    {
        $request = new CreateAndroidAppDataStreamRequest();
        $request->setAndroidAppDataStream($androidAppDataStream);
        $request->setParent($parent);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateAndroidAppDataStream',
            AndroidAppDataStream::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns child android app streams under the specified parent property.
     *
     * Android app streams will be excluded if the caller does not have access.
     * Returns an empty list if no relevant android app streams are found.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listAndroidAppDataStreams($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listAndroidAppDataStreams($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the parent property.
     *                             For example, to limit results to app streams under the property with Id
     *                             123: "properties/123"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listAndroidAppDataStreams($parent, array $optionalArgs = [])
    {
        $request = new ListAndroidAppDataStreamsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListAndroidAppDataStreams',
            $optionalArgs,
            ListAndroidAppDataStreamsResponse::class,
            $request
        );
    }

    /**
     * Returns the singleton enhanced measurement settings for this web stream.
     * Note that the stream must enable enhanced measurement for these settings to
     * take effect.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->enhancedMeasurementSettingsName('[PROPERTY]', '[WEB_DATA_STREAM]');
     *     $response = $analyticsAdminServiceClient->getEnhancedMeasurementSettings($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the settings to lookup.
     *                             Format:
     *                             properties/{property_id}/webDataStreams/{stream_id}/enhancedMeasurementSettings
     *                             Example: "properties/1000/webDataStreams/2000/enhancedMeasurementSettings"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getEnhancedMeasurementSettings($name, array $optionalArgs = [])
    {
        $request = new GetEnhancedMeasurementSettingsRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetEnhancedMeasurementSettings',
            EnhancedMeasurementSettings::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the singleton enhanced measurement settings for this web stream.
     * Note that the stream must enable enhanced measurement for these settings to
     * take effect.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $enhancedMeasurementSettings = new EnhancedMeasurementSettings();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateEnhancedMeasurementSettings($enhancedMeasurementSettings, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param EnhancedMeasurementSettings $enhancedMeasurementSettings Required. The settings to update.
     *                                                                 The `name` field is used to identify the settings to be updated.
     * @param FieldMask                   $updateMask                  Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                                                 To replace the entire entity, use one path with the string "*" to match
     *                                                                 all fields.
     * @param array                       $optionalArgs                {
     *                                                                 Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateEnhancedMeasurementSettings($enhancedMeasurementSettings, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateEnhancedMeasurementSettingsRequest();
        $request->setEnhancedMeasurementSettings($enhancedMeasurementSettings);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'enhanced_measurement_settings.name' => $request->getEnhancedMeasurementSettings()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateEnhancedMeasurementSettings',
            EnhancedMeasurementSettings::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a FirebaseLink.
     *
     * Properties can have at most one FirebaseLink.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $firebaseLink = new FirebaseLink();
     *     $response = $analyticsAdminServiceClient->createFirebaseLink($formattedParent, $firebaseLink);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string       $parent       Required. Format: properties/{property_id}
     *                                   Example: properties/1234
     * @param FirebaseLink $firebaseLink Required. The Firebase link to create.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\FirebaseLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createFirebaseLink($parent, $firebaseLink, array $optionalArgs = [])
    {
        $request = new CreateFirebaseLinkRequest();
        $request->setParent($parent);
        $request->setFirebaseLink($firebaseLink);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateFirebaseLink',
            FirebaseLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a FirebaseLink on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $firebaseLink = new FirebaseLink();
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateFirebaseLink($firebaseLink, $updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param FirebaseLink $firebaseLink Required. The Firebase link to update.
     * @param FieldMask    $updateMask   Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                   To replace the entire entity, use one path with the string "*" to match
     *                                   all fields.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\FirebaseLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateFirebaseLink($firebaseLink, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateFirebaseLinkRequest();
        $request->setFirebaseLink($firebaseLink);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'firebase_link.name' => $request->getFirebaseLink()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateFirebaseLink',
            FirebaseLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a FirebaseLink on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->firebaseLinkName('[PROPERTY]', '[FIREBASE_LINK]');
     *     $analyticsAdminServiceClient->deleteFirebaseLink($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Format: properties/{property_id}/firebaseLinks/{firebase_link_id}
     *                             Example: properties/1234/firebaseLinks/5678
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteFirebaseLink($name, array $optionalArgs = [])
    {
        $request = new DeleteFirebaseLinkRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteFirebaseLink',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists FirebaseLinks on a property.
     * Properties can have at most one FirebaseLink.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listFirebaseLinks($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listFirebaseLinks($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. Format: properties/{property_id}
     *                             Example: properties/1234
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listFirebaseLinks($parent, array $optionalArgs = [])
    {
        $request = new ListFirebaseLinksRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListFirebaseLinks',
            $optionalArgs,
            ListFirebaseLinksResponse::class,
            $request
        );
    }

    /**
     * Returns the Site Tag for the specified web stream.
     * Site Tags are immutable singletons.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->globalSiteTagName('[PROPERTY]');
     *     $response = $analyticsAdminServiceClient->getGlobalSiteTag($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the site tag to lookup.
     *                             Note that site tags are singletons and do not have unique IDs.
     *                             Format: properties/{property_id}/webDataStreams/{stream_id}/globalSiteTag
     *                             Example: "properties/123/webDataStreams/456/globalSiteTag"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\GlobalSiteTag
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getGlobalSiteTag($name, array $optionalArgs = [])
    {
        $request = new GetGlobalSiteTagRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetGlobalSiteTag',
            GlobalSiteTag::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a GoogleAdsLink.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     $googleAdsLink = new GoogleAdsLink();
     *     $response = $analyticsAdminServiceClient->createGoogleAdsLink($formattedParent, $googleAdsLink);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string        $parent        Required. Example format: properties/1234
     * @param GoogleAdsLink $googleAdsLink Required. The GoogleAdsLink to create.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\GoogleAdsLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createGoogleAdsLink($parent, $googleAdsLink, array $optionalArgs = [])
    {
        $request = new CreateGoogleAdsLinkRequest();
        $request->setParent($parent);
        $request->setGoogleAdsLink($googleAdsLink);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateGoogleAdsLink',
            GoogleAdsLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a GoogleAdsLink on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $updateMask = new FieldMask();
     *     $response = $analyticsAdminServiceClient->updateGoogleAdsLink($updateMask);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param FieldMask $updateMask   Required. The list of fields to be updated. Omitted fields will not be updated.
     *                                To replace the entire entity, use one path with the string "*" to match
     *                                all fields.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type GoogleAdsLink $googleAdsLink
     *          The GoogleAdsLink to update
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\GoogleAdsLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateGoogleAdsLink($updateMask, array $optionalArgs = [])
    {
        $request = new UpdateGoogleAdsLinkRequest();
        $request->setUpdateMask($updateMask);
        if (isset($optionalArgs['googleAdsLink'])) {
            $request->setGoogleAdsLink($optionalArgs['googleAdsLink']);
        }

        $descriptors = [];
        if ($request->getGoogleAdsLink()) {
            $descriptors = [
              'google_ads_link.name' => $request->getGoogleAdsLink()->getName(),
            ];
        }
        $requestParams = new RequestParamsHeaderDescriptor($descriptors);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateGoogleAdsLink',
            GoogleAdsLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a GoogleAdsLink on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->googleAdsLinkName('[PROPERTY]', '[GOOGLE_ADS_LINK]');
     *     $analyticsAdminServiceClient->deleteGoogleAdsLink($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Example format: properties/1234/googleAdsLinks/5678
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteGoogleAdsLink($name, array $optionalArgs = [])
    {
        $request = new DeleteGoogleAdsLinkRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteGoogleAdsLink',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists GoogleAdsLinks on a property.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedParent = $analyticsAdminServiceClient->propertyName('[PROPERTY]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $analyticsAdminServiceClient->listGoogleAdsLinks($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $analyticsAdminServiceClient->listGoogleAdsLinks($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. Example format: properties/1234
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listGoogleAdsLinks($parent, array $optionalArgs = [])
    {
        $request = new ListGoogleAdsLinksRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListGoogleAdsLinks',
            $optionalArgs,
            ListGoogleAdsLinksResponse::class,
            $request
        );
    }

    /**
     * Get data sharing settings on an account.
     * Data sharing settings are singletons.
     *
     * Sample code:
     * ```
     * $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();
     * try {
     *     $formattedName = $analyticsAdminServiceClient->dataSharingSettingsName('[ACCOUNT]');
     *     $response = $analyticsAdminServiceClient->getDataSharingSettings($formattedName);
     * } finally {
     *     $analyticsAdminServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the settings to lookup.
     *                             Format: accounts/{account}/dataSharingSettings
     *                             Example: "accounts/1000/dataSharingSettings"
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Analytics\Admin\V1alpha\DataSharingSettings
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDataSharingSettings($name, array $optionalArgs = [])
    {
        $request = new GetDataSharingSettingsRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetDataSharingSettings',
            DataSharingSettings::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
