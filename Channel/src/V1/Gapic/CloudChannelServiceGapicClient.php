<?php
/*
 * Copyright 2021 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/channel/v1/service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Channel\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Channel\V1\ActivateEntitlementRequest;
use Google\Cloud\Channel\V1\AdminUser;
use Google\Cloud\Channel\V1\CancelEntitlementRequest;
use Google\Cloud\Channel\V1\ChangeOfferRequest;
use Google\Cloud\Channel\V1\ChangeParametersRequest;
use Google\Cloud\Channel\V1\ChangeRenewalSettingsRequest;
use Google\Cloud\Channel\V1\ChannelPartnerLink;
use Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistRequest;
use Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistResponse;
use Google\Cloud\Channel\V1\CloudIdentityInfo;
use Google\Cloud\Channel\V1\CreateChannelPartnerLinkRequest;
use Google\Cloud\Channel\V1\CreateCustomerRequest;
use Google\Cloud\Channel\V1\CreateEntitlementRequest;
use Google\Cloud\Channel\V1\Customer;
use Google\Cloud\Channel\V1\DeleteCustomerRequest;
use Google\Cloud\Channel\V1\Entitlement;
use Google\Cloud\Channel\V1\GetChannelPartnerLinkRequest;
use Google\Cloud\Channel\V1\GetCustomerRequest;
use Google\Cloud\Channel\V1\GetEntitlementRequest;
use Google\Cloud\Channel\V1\ListChannelPartnerLinksRequest;
use Google\Cloud\Channel\V1\ListChannelPartnerLinksResponse;
use Google\Cloud\Channel\V1\ListCustomersRequest;
use Google\Cloud\Channel\V1\ListCustomersResponse;
use Google\Cloud\Channel\V1\ListEntitlementsRequest;
use Google\Cloud\Channel\V1\ListEntitlementsResponse;
use Google\Cloud\Channel\V1\ListOffersRequest;
use Google\Cloud\Channel\V1\ListOffersResponse;
use Google\Cloud\Channel\V1\ListProductsRequest;
use Google\Cloud\Channel\V1\ListProductsResponse;
use Google\Cloud\Channel\V1\ListPurchasableOffersRequest;
use Google\Cloud\Channel\V1\ListPurchasableOffersResponse;
use Google\Cloud\Channel\V1\ListPurchasableSkusRequest;
use Google\Cloud\Channel\V1\ListPurchasableSkusRequest\ChangeOfferPurchase;
use Google\Cloud\Channel\V1\ListPurchasableSkusRequest\CreateEntitlementPurchase;
use Google\Cloud\Channel\V1\ListPurchasableSkusResponse;
use Google\Cloud\Channel\V1\ListSkusRequest;
use Google\Cloud\Channel\V1\ListSkusResponse;
use Google\Cloud\Channel\V1\ListSubscribersRequest;
use Google\Cloud\Channel\V1\ListSubscribersResponse;
use Google\Cloud\Channel\V1\ListTransferableOffersRequest;
use Google\Cloud\Channel\V1\ListTransferableOffersResponse;
use Google\Cloud\Channel\V1\ListTransferableSkusRequest;
use Google\Cloud\Channel\V1\ListTransferableSkusResponse;
use Google\Cloud\Channel\V1\OperationMetadata;
use Google\Cloud\Channel\V1\Parameter;
use Google\Cloud\Channel\V1\ProvisionCloudIdentityRequest;
use Google\Cloud\Channel\V1\RegisterSubscriberRequest;
use Google\Cloud\Channel\V1\RegisterSubscriberResponse;
use Google\Cloud\Channel\V1\RenewalSettings;
use Google\Cloud\Channel\V1\StartPaidServiceRequest;
use Google\Cloud\Channel\V1\SuspendEntitlementRequest;
use Google\Cloud\Channel\V1\TransferEntitlementsRequest;
use Google\Cloud\Channel\V1\TransferEntitlementsToGoogleRequest;
use Google\Cloud\Channel\V1\UnregisterSubscriberRequest;
use Google\Cloud\Channel\V1\UnregisterSubscriberResponse;
use Google\Cloud\Channel\V1\UpdateChannelPartnerLinkRequest;
use Google\Cloud\Channel\V1\UpdateCustomerRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: CloudChannelService enables Google cloud resellers and distributors to manage
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
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $cloudChannelServiceClient = new CloudChannelServiceClient();
 * try {
 *     $parent = '';
 *     // Iterate over pages of elements
 *     $pagedResponse = $cloudChannelServiceClient->listCustomers($parent);
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
 *     $pagedResponse = $cloudChannelServiceClient->listCustomers($parent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $cloudChannelServiceClient->close();
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
class CloudChannelServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.channel.v1.CloudChannelService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'cloudchannel.googleapis.com';

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
        'https://www.googleapis.com/auth/apps.order',
    ];
    private static $customerNameTemplate;
    private static $entitlementNameTemplate;
    private static $offerNameTemplate;
    private static $productNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/cloud_channel_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/cloud_channel_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/cloud_channel_service_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/cloud_channel_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getCustomerNameTemplate()
    {
        if (null == self::$customerNameTemplate) {
            self::$customerNameTemplate = new PathTemplate('accounts/{account}/customers/{customer}');
        }

        return self::$customerNameTemplate;
    }

    private static function getEntitlementNameTemplate()
    {
        if (null == self::$entitlementNameTemplate) {
            self::$entitlementNameTemplate = new PathTemplate('accounts/{account}/customers/{customer}/entitlements/{entitlement}');
        }

        return self::$entitlementNameTemplate;
    }

    private static function getOfferNameTemplate()
    {
        if (null == self::$offerNameTemplate) {
            self::$offerNameTemplate = new PathTemplate('accounts/{account}/offers/{offer}');
        }

        return self::$offerNameTemplate;
    }

    private static function getProductNameTemplate()
    {
        if (null == self::$productNameTemplate) {
            self::$productNameTemplate = new PathTemplate('products/{product}');
        }

        return self::$productNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'customer' => self::getCustomerNameTemplate(),
                'entitlement' => self::getEntitlementNameTemplate(),
                'offer' => self::getOfferNameTemplate(),
                'product' => self::getProductNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a customer resource.
     *
     * @param string $account
     * @param string $customer
     *
     * @return string The formatted customer resource.
     * @experimental
     */
    public static function customerName($account, $customer)
    {
        return self::getCustomerNameTemplate()->render([
            'account' => $account,
            'customer' => $customer,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a entitlement resource.
     *
     * @param string $account
     * @param string $customer
     * @param string $entitlement
     *
     * @return string The formatted entitlement resource.
     * @experimental
     */
    public static function entitlementName($account, $customer, $entitlement)
    {
        return self::getEntitlementNameTemplate()->render([
            'account' => $account,
            'customer' => $customer,
            'entitlement' => $entitlement,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a offer resource.
     *
     * @param string $account
     * @param string $offer
     *
     * @return string The formatted offer resource.
     * @experimental
     */
    public static function offerName($account, $offer)
    {
        return self::getOfferNameTemplate()->render([
            'account' => $account,
            'offer' => $offer,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a product resource.
     *
     * @param string $product
     *
     * @return string The formatted product resource.
     * @experimental
     */
    public static function productName($product)
    {
        return self::getProductNameTemplate()->render([
            'product' => $product,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - customer: accounts/{account}/customers/{customer}
     * - entitlement: accounts/{account}/customers/{customer}/entitlements/{entitlement}
     * - offer: accounts/{account}/offers/{offer}
     * - product: products/{product}.
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
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
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
     *           as "<uri>:<port>". Default 'cloudchannel.googleapis.com:443'.
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
        $this->operationsClient = $this->createOperationsClient($clientOptions);
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listCustomers($parent);
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
     *     $pagedResponse = $cloudChannelServiceClient->listCustomers($parent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller account from which to list customers.
     *                             The parent takes the format: accounts/{account_id}.
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
    public function listCustomers($parent, array $optionalArgs = [])
    {
        $request = new ListCustomersRequest();
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
            'ListCustomers',
            $optionalArgs,
            ListCustomersResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedName = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     $response = $cloudChannelServiceClient->getCustomer($formattedName);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the customer to retrieve.
     *                             The name takes the format: accounts/{account_id}/customers/{customer_id}
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
     * @return \Google\Cloud\Channel\V1\Customer
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCustomer($name, array $optionalArgs = [])
    {
        $request = new GetCustomerRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetCustomer',
            Customer::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     $domain = '';
     *     $response = $cloudChannelServiceClient->checkCloudIdentityAccountsExist($parent, $domain);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller account.
     *                             The parent takes the format: accounts/{account_id}
     * @param string $domain       Required. Domain for which the Cloud Identity account customer is fetched.
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
     * @return \Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function checkCloudIdentityAccountsExist($parent, $domain, array $optionalArgs = [])
    {
        $request = new CheckCloudIdentityAccountsExistRequest();
        $request->setParent($parent);
        $request->setDomain($domain);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CheckCloudIdentityAccountsExist',
            CheckCloudIdentityAccountsExistResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     $customer = new Customer();
     *     $response = $cloudChannelServiceClient->createCustomer($parent, $customer);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The resource name of reseller account in which to create the customer.
     *                               The parent takes the format: accounts/{account_id}
     * @param Customer $customer     Required. The customer to create.
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
     * @return \Google\Cloud\Channel\V1\Customer
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCustomer($parent, $customer, array $optionalArgs = [])
    {
        $request = new CreateCustomerRequest();
        $request->setParent($parent);
        $request->setCustomer($customer);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateCustomer',
            Customer::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $customer = new Customer();
     *     $response = $cloudChannelServiceClient->updateCustomer($customer);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param Customer $customer     Required. New contents of the customer.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type FieldMask $updateMask
     *          The update mask that applies to the resource.
     *          Optional.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Channel\V1\Customer
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCustomer($customer, array $optionalArgs = [])
    {
        $request = new UpdateCustomerRequest();
        $request->setCustomer($customer);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'customer.name' => $request->getCustomer()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateCustomer',
            Customer::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedName = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     $cloudChannelServiceClient->deleteCustomer($formattedName);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the customer to delete.
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
    public function deleteCustomer($name, array $optionalArgs = [])
    {
        $request = new DeleteCustomerRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteCustomer',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedCustomer = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     $operationResponse = $cloudChannelServiceClient->provisionCloudIdentity($formattedCustomer);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->provisionCloudIdentity($formattedCustomer);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'provisionCloudIdentity');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $customer     Required. Resource name of the customer.
     *                             Format: accounts/{account_id}/customers/{customer_id}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type CloudIdentityInfo $cloudIdentityInfo
     *          CloudIdentity-specific customer information.
     *     @type AdminUser $user
     *          Admin user information.
     *     @type bool $validateOnly
     *          If set, validate the request and preview the review, but do not actually
     *          post it.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function provisionCloudIdentity($customer, array $optionalArgs = [])
    {
        $request = new ProvisionCloudIdentityRequest();
        $request->setCustomer($customer);
        if (isset($optionalArgs['cloudIdentityInfo'])) {
            $request->setCloudIdentityInfo($optionalArgs['cloudIdentityInfo']);
        }
        if (isset($optionalArgs['user'])) {
            $request->setUser($optionalArgs['user']);
        }
        if (isset($optionalArgs['validateOnly'])) {
            $request->setValidateOnly($optionalArgs['validateOnly']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'customer' => $request->getCustomer(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ProvisionCloudIdentity',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedParent = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listEntitlements($formattedParent);
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
     *     $pagedResponse = $cloudChannelServiceClient->listEntitlements($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller's customer account for which to list
     *                             entitlements.
     *                             The parent takes the format: accounts/{account_id}/customers/{customer_id}
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
    public function listEntitlements($parent, array $optionalArgs = [])
    {
        $request = new ListEntitlementsRequest();
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
            'ListEntitlements',
            $optionalArgs,
            ListEntitlementsResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listTransferableSkus($parent);
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
     *     $pagedResponse = $cloudChannelServiceClient->listTransferableSkus($parent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller's account.
     *                             The parent takes the format: accounts/{account_id}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $cloudIdentityId
     *          Customer's Cloud Identity ID
     *     @type string $customerName
     *          A reseller is required to create a customer and use the resource name of
     *          the created customer here.
     *          The customer_name takes the format:
     *          accounts/{account_id}/customers/{customer_id}
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $authToken
     *          This token is generated by the Super Admin of the resold customer to
     *          authorize a reseller to access their Cloud Identity and purchase
     *          entitlements on their behalf. This token can be omitted once the
     *          authorization is generated. See https://support.google.com/a/answer/7643790
     *          for more details.
     *     @type string $languageCode
     *          The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
     *          Optional.
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
    public function listTransferableSkus($parent, array $optionalArgs = [])
    {
        $request = new ListTransferableSkusRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['cloudIdentityId'])) {
            $request->setCloudIdentityId($optionalArgs['cloudIdentityId']);
        }
        if (isset($optionalArgs['customerName'])) {
            $request->setCustomerName($optionalArgs['customerName']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['authToken'])) {
            $request->setAuthToken($optionalArgs['authToken']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListTransferableSkus',
            $optionalArgs,
            ListTransferableSkusResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     $sku = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listTransferableOffers($parent, $sku);
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
     *     $pagedResponse = $cloudChannelServiceClient->listTransferableOffers($parent, $sku);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller's account.
     * @param string $sku          Required. SKU for which the Offers are being looked up.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $cloudIdentityId
     *          Customer's Cloud Identity ID
     *     @type string $customerName
     *          A reseller should create a customer and use the resource name of
     *          the created customer here.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $languageCode
     *          The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
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
    public function listTransferableOffers($parent, $sku, array $optionalArgs = [])
    {
        $request = new ListTransferableOffersRequest();
        $request->setParent($parent);
        $request->setSku($sku);
        if (isset($optionalArgs['cloudIdentityId'])) {
            $request->setCloudIdentityId($optionalArgs['cloudIdentityId']);
        }
        if (isset($optionalArgs['customerName'])) {
            $request->setCustomerName($optionalArgs['customerName']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListTransferableOffers',
            $optionalArgs,
            ListTransferableOffersResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedName = $cloudChannelServiceClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
     *     $response = $cloudChannelServiceClient->getEntitlement($formattedName);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the entitlement to retrieve.
     *                             The name takes the format:
     *                             accounts/{account_id}/customers/{customer_id}/entitlements/{id}
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
     * @return \Google\Cloud\Channel\V1\Entitlement
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getEntitlement($name, array $optionalArgs = [])
    {
        $request = new GetEntitlementRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetEntitlement',
            Entitlement::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedParent = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     $entitlement = new Entitlement();
     *     $operationResponse = $cloudChannelServiceClient->createEntitlement($formattedParent, $entitlement);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->createEntitlement($formattedParent, $entitlement);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'createEntitlement');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string      $parent       Required. The resource name of reseller's customer account in which to create the
     *                                  entitlement.
     *                                  The parent takes the format: accounts/{account_id}/customers/{customer_id}
     * @param Entitlement $entitlement  Required. The entitlement to create.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createEntitlement($parent, $entitlement, array $optionalArgs = [])
    {
        $request = new CreateEntitlementRequest();
        $request->setParent($parent);
        $request->setEntitlement($entitlement);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateEntitlement',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Change parameters of the entitlement.
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $parameters = [];
     *     $operationResponse = $cloudChannelServiceClient->changeParameters($name, $parameters);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->changeParameters($name, $parameters);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'changeParameters');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string      $name         Required. The name of the entitlement to update.
     *                                  The name takes the format:
     *                                  accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param Parameter[] $parameters   Required. Entitlement parameters to update. Only editable parameters are allowed to
     *                                  be changed.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be
     *          a valid [UUID](https://tools.ietf.org/html/rfc4122) with the exception that
     *          zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type string $purchaseOrderId
     *          Optional. Purchase order ID provided by the reseller.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function changeParameters($name, $parameters, array $optionalArgs = [])
    {
        $request = new ChangeParametersRequest();
        $request->setName($name);
        $request->setParameters($parameters);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }
        if (isset($optionalArgs['purchaseOrderId'])) {
            $request->setPurchaseOrderId($optionalArgs['purchaseOrderId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ChangeParameters',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $renewalSettings = new RenewalSettings();
     *     $operationResponse = $cloudChannelServiceClient->changeRenewalSettings($name, $renewalSettings);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->changeRenewalSettings($name, $renewalSettings);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'changeRenewalSettings');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string          $name            Required. The name of the entitlement to update.
     *                                         The name takes the format:
     *                                         accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param RenewalSettings $renewalSettings Required. New renewal settings.
     * @param array           $optionalArgs    {
     *                                         Optional.
     *
     *     @type string $requestId
     *          Optional. A request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function changeRenewalSettings($name, $renewalSettings, array $optionalArgs = [])
    {
        $request = new ChangeRenewalSettingsRequest();
        $request->setName($name);
        $request->setRenewalSettings($renewalSettings);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ChangeRenewalSettings',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $formattedOffer = $cloudChannelServiceClient->offerName('[ACCOUNT]', '[OFFER]');
     *     $operationResponse = $cloudChannelServiceClient->changeOffer($name, $formattedOffer);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->changeOffer($name, $formattedOffer);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'changeOffer');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entitlement to update.
     *                             Format:
     *                             accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param string $offer        Required. New Offer.
     *                             Format: accounts/{account_id}/offers/{offer_id}.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Parameter[] $parameters
     *          Optional. Parameters needed to purchase the Offer.
     *     @type string $purchaseOrderId
     *          Optional. Purchase order id provided by the reseller.
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function changeOffer($name, $offer, array $optionalArgs = [])
    {
        $request = new ChangeOfferRequest();
        $request->setName($name);
        $request->setOffer($offer);
        if (isset($optionalArgs['parameters'])) {
            $request->setParameters($optionalArgs['parameters']);
        }
        if (isset($optionalArgs['purchaseOrderId'])) {
            $request->setPurchaseOrderId($optionalArgs['purchaseOrderId']);
        }
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ChangeOffer',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $operationResponse = $cloudChannelServiceClient->startPaidService($name);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->startPaidService($name);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'startPaidService');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entitlement for which paid service is being started.
     *                             The name takes the format:
     *                             accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function startPaidService($name, array $optionalArgs = [])
    {
        $request = new StartPaidServiceRequest();
        $request->setName($name);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'StartPaidService',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $operationResponse = $cloudChannelServiceClient->suspendEntitlement($name);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->suspendEntitlement($name);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'suspendEntitlement');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the entitlement to suspend.
     *                             The name takes the format:
     *                             accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function suspendEntitlement($name, array $optionalArgs = [])
    {
        $request = new SuspendEntitlementRequest();
        $request->setName($name);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'SuspendEntitlement',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $operationResponse = $cloudChannelServiceClient->cancelEntitlement($name);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->cancelEntitlement($name);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'cancelEntitlement');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the entitlement to cancel.
     *                             The name takes the format:
     *                             accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function cancelEntitlement($name, array $optionalArgs = [])
    {
        $request = new CancelEntitlementRequest();
        $request->setName($name);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CancelEntitlement',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $operationResponse = $cloudChannelServiceClient->activateEntitlement($name);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->activateEntitlement($name);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'activateEntitlement');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the entitlement to activate.
     *                             The name takes the format:
     *                             accounts/{account_id}/customers/{customer_id}/entitlements/{entitlement_id}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function activateEntitlement($name, array $optionalArgs = [])
    {
        $request = new ActivateEntitlementRequest();
        $request->setName($name);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ActivateEntitlement',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     $entitlements = [];
     *     $operationResponse = $cloudChannelServiceClient->transferEntitlements($parent, $entitlements);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->transferEntitlements($parent, $entitlements);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'transferEntitlements');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string        $parent       Required. The resource name of reseller's customer account where the entitlements
     *                                    transfer to.
     *                                    The parent takes the format: accounts/{account_id}/customers/{customer_id}
     * @param Entitlement[] $entitlements Required. The new entitlements to be created or transferred.
     * @param array         $optionalArgs {
     *                                    Optional.
     *
     *     @type string $authToken
     *          This token is generated by the Super Admin of the resold customer to
     *          authorize a reseller to access their Cloud Identity and purchase
     *          entitlements on their behalf. This token can be omitted once the
     *          authorization is generated. See https://support.google.com/a/answer/7643790
     *          for more details.
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function transferEntitlements($parent, $entitlements, array $optionalArgs = [])
    {
        $request = new TransferEntitlementsRequest();
        $request->setParent($parent);
        $request->setEntitlements($entitlements);
        if (isset($optionalArgs['authToken'])) {
            $request->setAuthToken($optionalArgs['authToken']);
        }
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'TransferEntitlements',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     $entitlements = [];
     *     $operationResponse = $cloudChannelServiceClient->transferEntitlementsToGoogle($parent, $entitlements);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudChannelServiceClient->transferEntitlementsToGoogle($parent, $entitlements);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudChannelServiceClient->resumeOperation($operationName, 'transferEntitlementsToGoogle');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string        $parent       Required. The resource name of reseller's customer account where the entitlements
     *                                    transfer from.
     *                                    The parent takes the format: accounts/{account_id}/customers/{customer_id}
     * @param Entitlement[] $entitlements Required. The entitlements to be transferred to Google.
     * @param array         $optionalArgs {
     *                                    Optional.
     *
     *     @type string $requestId
     *          Optional. An optional request ID to identify requests. Specify a unique request ID so
     *          that if you must retry your request, the server will know to ignore the
     *          request if it has already been completed.
     *
     *          For example, consider a situation where you make an initial request and
     *          the request times out. If you make the request again with the same
     *          request ID, the server can check if the original operation with the same
     *          request ID was received, and if so, will ignore the second request.
     *
     *          The request ID must be a valid [UUID](https://tools.ietf.org/html/rfc4122)
     *          with the exception that zero UUID is not supported
     *          (`00000000-0000-0000-0000-000000000000`).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function transferEntitlementsToGoogle($parent, $entitlements, array $optionalArgs = [])
    {
        $request = new TransferEntitlementsToGoogleRequest();
        $request->setParent($parent);
        $request->setEntitlements($entitlements);
        if (isset($optionalArgs['requestId'])) {
            $request->setRequestId($optionalArgs['requestId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'TransferEntitlementsToGoogle',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listChannelPartnerLinks($parent);
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
     *     $pagedResponse = $cloudChannelServiceClient->listChannelPartnerLinks($parent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller account for listing channel partner
     *                             links.
     *                             The parent takes the format: accounts/{account_id}
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
     *     @type int $view
     *          Optional. The level of granularity the ChannelPartnerLink will display.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Channel\V1\ChannelPartnerLinkView}
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
    public function listChannelPartnerLinks($parent, array $optionalArgs = [])
    {
        $request = new ListChannelPartnerLinksRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListChannelPartnerLinks',
            $optionalArgs,
            ListChannelPartnerLinksResponse::class,
            $request
        );
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $response = $cloudChannelServiceClient->getChannelPartnerLink($name);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the channel partner link to retrieve.
     *                             The name takes the format: accounts/{account_id}/channelPartnerLinks/{id}
     *                             where {id} is the Cloud Identity ID of the partner.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $view
     *          Optional. The level of granularity the ChannelPartnerLink will display.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Channel\V1\ChannelPartnerLinkView}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Channel\V1\ChannelPartnerLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getChannelPartnerLink($name, array $optionalArgs = [])
    {
        $request = new GetChannelPartnerLinkRequest();
        $request->setName($name);
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetChannelPartnerLink',
            ChannelPartnerLink::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     $channelPartnerLink = new ChannelPartnerLink();
     *     $response = $cloudChannelServiceClient->createChannelPartnerLink($parent, $channelPartnerLink);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string             $parent             Required. The resource name of reseller's account for which to create a channel
     *                                               partner link.
     *                                               The parent takes the format: accounts/{account_id}
     * @param ChannelPartnerLink $channelPartnerLink Required. The channel partner link to create.
     *                                               Either channel_partner_link.reseller_cloud_identity_id or domain can be
     *                                               used to create a link.
     * @param array              $optionalArgs       {
     *                                               Optional.
     *
     *     @type string $domain
     *          Optional. The invited partner's domain. Either domain or
     *          channel_partner_link.reseller_cloud_identity_id can be used to create a
     *          link.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Channel\V1\ChannelPartnerLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createChannelPartnerLink($parent, $channelPartnerLink, array $optionalArgs = [])
    {
        $request = new CreateChannelPartnerLinkRequest();
        $request->setParent($parent);
        $request->setChannelPartnerLink($channelPartnerLink);
        if (isset($optionalArgs['domain'])) {
            $request->setDomain($optionalArgs['domain']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateChannelPartnerLink',
            ChannelPartnerLink::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $name = '';
     *     $channelPartnerLink = new ChannelPartnerLink();
     *     $updateMask = new FieldMask();
     *     $response = $cloudChannelServiceClient->updateChannelPartnerLink($name, $channelPartnerLink, $updateMask);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string             $name               Required. The resource name of the channel partner link to cancel.
     *                                               The name takes the format: accounts/{account_id}/channelPartnerLinks/{id}
     *                                               where {id} is the Cloud Identity ID of the partner.
     * @param ChannelPartnerLink $channelPartnerLink Required. The channel partner link to update. Only field
     *                                               channel_partner_link.link_state is allowed to be updated.
     * @param FieldMask          $updateMask         Required. The update mask that applies to the resource.
     *                                               The only allowable value for update mask is
     *                                               channel_partner_link.link_state.
     * @param array              $optionalArgs       {
     *                                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Channel\V1\ChannelPartnerLink
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateChannelPartnerLink($name, $channelPartnerLink, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateChannelPartnerLinkRequest();
        $request->setName($name);
        $request->setChannelPartnerLink($channelPartnerLink);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateChannelPartnerLink',
            ChannelPartnerLink::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the Products the reseller is authorized to sell.
     *
     * Possible Error Codes:
     *
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $account = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listProducts($account);
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
     *     $pagedResponse = $cloudChannelServiceClient->listProducts($account);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $account      Required. The resource name of the reseller account.
     *                             Format: accounts/{account_id}.
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
     *     @type string $languageCode
     *          Optional. The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
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
    public function listProducts($account, array $optionalArgs = [])
    {
        $request = new ListProductsRequest();
        $request->setAccount($account);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        return $this->getPagedListResponse(
            'ListProducts',
            $optionalArgs,
            ListProductsResponse::class,
            $request
        );
    }

    /**
     * Lists the SKUs for a product the reseller is authorized to sell.
     *
     * Possible Error Codes:
     *
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedParent = $cloudChannelServiceClient->productName('[PRODUCT]');
     *     $account = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listSkus($formattedParent, $account);
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
     *     $pagedResponse = $cloudChannelServiceClient->listSkus($formattedParent, $account);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the Product for which to list SKUs.
     *                             The parent takes the format: products/{product_id}.
     *                             Supports products/- to retrieve SKUs for all products.
     * @param string $account      Required. Resource name of the reseller.
     *                             Format: accounts/{account_id}.
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
     *     @type string $languageCode
     *          Optional. The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
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
    public function listSkus($parent, $account, array $optionalArgs = [])
    {
        $request = new ListSkusRequest();
        $request->setParent($parent);
        $request->setAccount($account);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListSkus',
            $optionalArgs,
            ListSkusResponse::class,
            $request
        );
    }

    /**
     * Lists the Offers the reseller can sell.
     *
     * Possible Error Codes:
     *
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $parent = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listOffers($parent);
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
     *     $pagedResponse = $cloudChannelServiceClient->listOffers($parent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the reseller account from which to list Offers.
     *                             The parent takes the format: accounts/{account_id}.
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
     *     @type string $filter
     *          Optional. The expression to filter results by name (name of
     *          the Offer), sku.name (name of the SKU) or sku.product.name (name of the
     *          Product).
     *          Example 1: sku.product.name=products/p1 AND sku.name!=products/p1/skus/s1
     *          Example 2: name=accounts/a1/offers/o1
     *     @type string $languageCode
     *          Optional. The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
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
    public function listOffers($parent, array $optionalArgs = [])
    {
        $request = new ListOffersRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListOffers',
            $optionalArgs,
            ListOffersResponse::class,
            $request
        );
    }

    /**
     * Lists the Purchasable SKUs for following cases:.
     *
     * * SKUs that can be newly purchased for a customer
     * * SKUs that can be upgraded/downgraded to, for an entitlement.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedCustomer = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listPurchasableSkus($formattedCustomer);
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
     *     $pagedResponse = $cloudChannelServiceClient->listPurchasableSkus($formattedCustomer);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $customer     Required. The resource name of the customer for which to list SKUs.
     *                             Format: accounts/{account_id}/customers/{customer_id}.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type CreateEntitlementPurchase $createEntitlementPurchase
     *          List SKUs for CreateEntitlement purchase.
     *     @type ChangeOfferPurchase $changeOfferPurchase
     *          List SKUs for ChangeOffer purchase with a new SKU.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $languageCode
     *          Optional. The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
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
    public function listPurchasableSkus($customer, array $optionalArgs = [])
    {
        $request = new ListPurchasableSkusRequest();
        $request->setCustomer($customer);
        if (isset($optionalArgs['createEntitlementPurchase'])) {
            $request->setCreateEntitlementPurchase($optionalArgs['createEntitlementPurchase']);
        }
        if (isset($optionalArgs['changeOfferPurchase'])) {
            $request->setChangeOfferPurchase($optionalArgs['changeOfferPurchase']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'customer' => $request->getCustomer(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListPurchasableSkus',
            $optionalArgs,
            ListPurchasableSkusResponse::class,
            $request
        );
    }

    /**
     * Lists the Purchasable Offers for the following cases:.
     *
     * * Offers that can be newly purchased for a customer
     * * Offers that can be changed to, for an entitlement.
     *
     * Possible Error Codes:
     *
     * * PERMISSION_DENIED: If the customer doesn't belong to the reseller
     * * INVALID_ARGUMENT: Missing or invalid required parameters in the
     * request.
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $formattedCustomer = $cloudChannelServiceClient->customerName('[ACCOUNT]', '[CUSTOMER]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listPurchasableOffers($formattedCustomer);
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
     *     $pagedResponse = $cloudChannelServiceClient->listPurchasableOffers($formattedCustomer);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $customer     Required. The resource name of the customer for which to list Offers.
     *                             Format: accounts/{account_id}/customers/{customer_id}.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\Cloud\Channel\V1\ListPurchasableOffersRequest\CreateEntitlementPurchase $createEntitlementPurchase
     *          List Offers for CreateEntitlement purchase.
     *     @type \Google\Cloud\Channel\V1\ListPurchasableOffersRequest\ChangeOfferPurchase $changeOfferPurchase
     *          List Offers for ChangeOffer purchase.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $languageCode
     *          Optional. The BCP-47 language code, such as "en-US".  If specified, the
     *          response will be localized to the corresponding language code. Default is
     *          "en-US".
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
    public function listPurchasableOffers($customer, array $optionalArgs = [])
    {
        $request = new ListPurchasableOffersRequest();
        $request->setCustomer($customer);
        if (isset($optionalArgs['createEntitlementPurchase'])) {
            $request->setCreateEntitlementPurchase($optionalArgs['createEntitlementPurchase']);
        }
        if (isset($optionalArgs['changeOfferPurchase'])) {
            $request->setChangeOfferPurchase($optionalArgs['changeOfferPurchase']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'customer' => $request->getCustomer(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListPurchasableOffers',
            $optionalArgs,
            ListPurchasableOffersResponse::class,
            $request
        );
    }

    /**
     * Registers a service account with subscriber privileges on the Cloud Pub/Sub
     * topic created for this Channel Services account. Once you create a
     * subscriber, you will get the events as per [SubscriberEvent][google.cloud.channel.v1.SubscriberEvent].
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $account = '';
     *     $serviceAccount = '';
     *     $response = $cloudChannelServiceClient->registerSubscriber($account, $serviceAccount);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $account        Required. Resource name of the account.
     * @param string $serviceAccount Required. Service account which will provide subscriber access to the
     *                               registered topic.
     * @param array  $optionalArgs   {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Channel\V1\RegisterSubscriberResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function registerSubscriber($account, $serviceAccount, array $optionalArgs = [])
    {
        $request = new RegisterSubscriberRequest();
        $request->setAccount($account);
        $request->setServiceAccount($serviceAccount);

        $requestParams = new RequestParamsHeaderDescriptor([
          'account' => $request->getAccount(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RegisterSubscriber',
            RegisterSubscriberResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $account = '';
     *     $serviceAccount = '';
     *     $response = $cloudChannelServiceClient->unregisterSubscriber($account, $serviceAccount);
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $account        Required. Resource name of the account.
     * @param string $serviceAccount Required. Service account which will be unregistered from getting subscriber access
     *                               to the topic.
     * @param array  $optionalArgs   {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Channel\V1\UnregisterSubscriberResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function unregisterSubscriber($account, $serviceAccount, array $optionalArgs = [])
    {
        $request = new UnregisterSubscriberRequest();
        $request->setAccount($account);
        $request->setServiceAccount($serviceAccount);

        $requestParams = new RequestParamsHeaderDescriptor([
          'account' => $request->getAccount(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UnregisterSubscriber',
            UnregisterSubscriberResponse::class,
            $optionalArgs,
            $request
        )->wait();
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
     *
     * Sample code:
     * ```
     * $cloudChannelServiceClient = new CloudChannelServiceClient();
     * try {
     *     $account = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $cloudChannelServiceClient->listSubscribers($account);
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
     *     $pagedResponse = $cloudChannelServiceClient->listSubscribers($account);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $cloudChannelServiceClient->close();
     * }
     * ```
     *
     * @param string $account      Required. Resource name of the account.
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
    public function listSubscribers($account, array $optionalArgs = [])
    {
        $request = new ListSubscribersRequest();
        $request->setAccount($account);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'account' => $request->getAccount(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListSubscribers',
            $optionalArgs,
            ListSubscribersResponse::class,
            $request
        );
    }
}
