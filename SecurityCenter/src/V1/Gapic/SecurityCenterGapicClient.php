<?php
/*
 * Copyright 2019 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/securitycenter/v1/securitycenter_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\SecurityCenter\V1\Gapic;

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
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\GetPolicyOptions;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\SecurityCenter\V1\CreateFindingRequest;
use Google\Cloud\SecurityCenter\V1\CreateSourceRequest;
use Google\Cloud\SecurityCenter\V1\Finding;
use Google\Cloud\SecurityCenter\V1\Finding\State;
use Google\Cloud\SecurityCenter\V1\GetOrganizationSettingsRequest;
use Google\Cloud\SecurityCenter\V1\GetSourceRequest;
use Google\Cloud\SecurityCenter\V1\GroupAssetsRequest;
use Google\Cloud\SecurityCenter\V1\GroupAssetsResponse;
use Google\Cloud\SecurityCenter\V1\GroupFindingsRequest;
use Google\Cloud\SecurityCenter\V1\GroupFindingsResponse;
use Google\Cloud\SecurityCenter\V1\ListAssetsRequest;
use Google\Cloud\SecurityCenter\V1\ListAssetsResponse;
use Google\Cloud\SecurityCenter\V1\ListFindingsRequest;
use Google\Cloud\SecurityCenter\V1\ListFindingsResponse;
use Google\Cloud\SecurityCenter\V1\ListSourcesRequest;
use Google\Cloud\SecurityCenter\V1\ListSourcesResponse;
use Google\Cloud\SecurityCenter\V1\OrganizationSettings;
use Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryRequest;
use Google\Cloud\SecurityCenter\V1\SecurityMarks;
use Google\Cloud\SecurityCenter\V1\SetFindingStateRequest;
use Google\Cloud\SecurityCenter\V1\Source;
use Google\Cloud\SecurityCenter\V1\UpdateFindingRequest;
use Google\Cloud\SecurityCenter\V1\UpdateOrganizationSettingsRequest;
use Google\Cloud\SecurityCenter\V1\UpdateSecurityMarksRequest;
use Google\Cloud\SecurityCenter\V1\UpdateSourceRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;

/**
 * Service Description: V1 APIs for Security Center service.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $securityCenterClient = new SecurityCenterClient();
 * try {
 *     $formattedParent = $securityCenterClient->organizationName('[ORGANIZATION]');
 *     $source = new Source();
 *     $response = $securityCenterClient->createSource($formattedParent, $source);
 * } finally {
 *     $securityCenterClient->close();
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
class SecurityCenterGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.securitycenter.v1.SecurityCenter';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'securitycenter.googleapis.com';

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
        'https://www.googleapis.com/auth/cloud-platform',
    ];
    private static $assetNameTemplate;
    private static $assetSecurityMarksNameTemplate;
    private static $findingNameTemplate;
    private static $findingSecurityMarksNameTemplate;
    private static $organizationNameTemplate;
    private static $organizationSettingsNameTemplate;
    private static $organizationSourcesNameTemplate;
    private static $sourceNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/security_center_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/security_center_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/security_center_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/security_center_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAssetNameTemplate()
    {
        if (null == self::$assetNameTemplate) {
            self::$assetNameTemplate = new PathTemplate('organizations/{organization}/assets/{asset}');
        }

        return self::$assetNameTemplate;
    }

    private static function getAssetSecurityMarksNameTemplate()
    {
        if (null == self::$assetSecurityMarksNameTemplate) {
            self::$assetSecurityMarksNameTemplate = new PathTemplate('organizations/{organization}/assets/{asset}/securityMarks');
        }

        return self::$assetSecurityMarksNameTemplate;
    }

    private static function getFindingNameTemplate()
    {
        if (null == self::$findingNameTemplate) {
            self::$findingNameTemplate = new PathTemplate('organizations/{organization}/sources/{source}/findings/{finding}');
        }

        return self::$findingNameTemplate;
    }

    private static function getFindingSecurityMarksNameTemplate()
    {
        if (null == self::$findingSecurityMarksNameTemplate) {
            self::$findingSecurityMarksNameTemplate = new PathTemplate('organizations/{organization}/sources/{source}/findings/{finding}/securityMarks');
        }

        return self::$findingSecurityMarksNameTemplate;
    }

    private static function getOrganizationNameTemplate()
    {
        if (null == self::$organizationNameTemplate) {
            self::$organizationNameTemplate = new PathTemplate('organizations/{organization}');
        }

        return self::$organizationNameTemplate;
    }

    private static function getOrganizationSettingsNameTemplate()
    {
        if (null == self::$organizationSettingsNameTemplate) {
            self::$organizationSettingsNameTemplate = new PathTemplate('organizations/{organization}/organizationSettings');
        }

        return self::$organizationSettingsNameTemplate;
    }

    private static function getOrganizationSourcesNameTemplate()
    {
        if (null == self::$organizationSourcesNameTemplate) {
            self::$organizationSourcesNameTemplate = new PathTemplate('organizations/{organization}/sources/-');
        }

        return self::$organizationSourcesNameTemplate;
    }

    private static function getSourceNameTemplate()
    {
        if (null == self::$sourceNameTemplate) {
            self::$sourceNameTemplate = new PathTemplate('organizations/{organization}/sources/{source}');
        }

        return self::$sourceNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'asset' => self::getAssetNameTemplate(),
                'assetSecurityMarks' => self::getAssetSecurityMarksNameTemplate(),
                'finding' => self::getFindingNameTemplate(),
                'findingSecurityMarks' => self::getFindingSecurityMarksNameTemplate(),
                'organization' => self::getOrganizationNameTemplate(),
                'organizationSettings' => self::getOrganizationSettingsNameTemplate(),
                'organizationSources' => self::getOrganizationSourcesNameTemplate(),
                'source' => self::getSourceNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a asset resource.
     *
     * @param string $organization
     * @param string $asset
     *
     * @return string The formatted asset resource.
     * @experimental
     */
    public static function assetName($organization, $asset)
    {
        return self::getAssetNameTemplate()->render([
            'organization' => $organization,
            'asset' => $asset,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a asset_security_marks resource.
     *
     * @param string $organization
     * @param string $asset
     *
     * @return string The formatted asset_security_marks resource.
     * @experimental
     */
    public static function assetSecurityMarksName($organization, $asset)
    {
        return self::getAssetSecurityMarksNameTemplate()->render([
            'organization' => $organization,
            'asset' => $asset,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a finding resource.
     *
     * @param string $organization
     * @param string $source
     * @param string $finding
     *
     * @return string The formatted finding resource.
     * @experimental
     */
    public static function findingName($organization, $source, $finding)
    {
        return self::getFindingNameTemplate()->render([
            'organization' => $organization,
            'source' => $source,
            'finding' => $finding,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a finding_security_marks resource.
     *
     * @param string $organization
     * @param string $source
     * @param string $finding
     *
     * @return string The formatted finding_security_marks resource.
     * @experimental
     */
    public static function findingSecurityMarksName($organization, $source, $finding)
    {
        return self::getFindingSecurityMarksNameTemplate()->render([
            'organization' => $organization,
            'source' => $source,
            'finding' => $finding,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a organization resource.
     *
     * @param string $organization
     *
     * @return string The formatted organization resource.
     * @experimental
     */
    public static function organizationName($organization)
    {
        return self::getOrganizationNameTemplate()->render([
            'organization' => $organization,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a organization_settings resource.
     *
     * @param string $organization
     *
     * @return string The formatted organization_settings resource.
     * @experimental
     */
    public static function organizationSettingsName($organization)
    {
        return self::getOrganizationSettingsNameTemplate()->render([
            'organization' => $organization,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a organization_sources resource.
     *
     * @param string $organization
     *
     * @return string The formatted organization_sources resource.
     * @experimental
     */
    public static function organizationSourcesName($organization)
    {
        return self::getOrganizationSourcesNameTemplate()->render([
            'organization' => $organization,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a source resource.
     *
     * @param string $organization
     * @param string $source
     *
     * @return string The formatted source resource.
     * @experimental
     */
    public static function sourceName($organization, $source)
    {
        return self::getSourceNameTemplate()->render([
            'organization' => $organization,
            'source' => $source,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - asset: organizations/{organization}/assets/{asset}
     * - assetSecurityMarks: organizations/{organization}/assets/{asset}/securityMarks
     * - finding: organizations/{organization}/sources/{source}/findings/{finding}
     * - findingSecurityMarks: organizations/{organization}/sources/{source}/findings/{finding}/securityMarks
     * - organization: organizations/{organization}
     * - organizationSettings: organizations/{organization}/organizationSettings
     * - organizationSources: organizations/{organization}/sources/-
     * - source: organizations/{organization}/sources/{source}.
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
     *           as "<uri>:<port>". Default 'securitycenter.googleapis.com:443'.
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
     * Creates a source.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->organizationName('[ORGANIZATION]');
     *     $source = new Source();
     *     $response = $securityCenterClient->createSource($formattedParent, $source);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the new source's parent. Its format should be
     *                             "organizations/[organization_id]".
     * @param Source $source       The Source being created, only the display_name and description will be
     *                             used. All other fields will be ignored.
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
     * @return \Google\Cloud\SecurityCenter\V1\Source
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSource($parent, $source, array $optionalArgs = [])
    {
        $request = new CreateSourceRequest();
        $request->setParent($parent);
        $request->setSource($source);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateSource',
            Source::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a finding. The corresponding source must exist for finding creation
     * to succeed.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     $findingId = '';
     *     $finding = new Finding();
     *     $response = $securityCenterClient->createFinding($formattedParent, $findingId, $finding);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string  $parent       Resource name of the new finding's parent. Its format should be
     *                              "organizations/[organization_id]/sources/[source_id]".
     * @param string  $findingId    Unique identifier provided by the client within the parent scope.
     *                              It must be alphanumeric and less than or equal to 32 characters and
     *                              greater than 0 characters in length.
     * @param Finding $finding      The Finding being created. The name and security_marks will be ignored as
     *                              they are both output only fields on this resource.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\SecurityCenter\V1\Finding
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createFinding($parent, $findingId, $finding, array $optionalArgs = [])
    {
        $request = new CreateFindingRequest();
        $request->setParent($parent);
        $request->setFindingId($findingId);
        $request->setFinding($finding);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateFinding',
            Finding::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the access control policy on the specified Source.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedResource = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     $response = $securityCenterClient->getIamPolicy($formattedResource);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             See the operation documentation for the appropriate value for this field.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type GetPolicyOptions $options
     *          OPTIONAL: A `GetPolicyOptions` object for specifying options to
     *          `GetIamPolicy`. This field is only used by Cloud IAM.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, array $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);
        if (isset($optionalArgs['options'])) {
            $request->setOptions($optionalArgs['options']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the settings for an organization.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedName = $securityCenterClient->organizationSettingsName('[ORGANIZATION]');
     *     $response = $securityCenterClient->getOrganizationSettings($formattedName);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $name         Name of the organization to get organization settings for. Its format is
     *                             "organizations/[organization_id]/organizationSettings".
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
     * @return \Google\Cloud\SecurityCenter\V1\OrganizationSettings
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getOrganizationSettings($name, array $optionalArgs = [])
    {
        $request = new GetOrganizationSettingsRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetOrganizationSettings',
            OrganizationSettings::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a source.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedName = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     $response = $securityCenterClient->getSource($formattedName);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $name         Relative resource name of the source. Its format is
     *                             "organizations/[organization_id]/source/[source_id]".
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
     * @return \Google\Cloud\SecurityCenter\V1\Source
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSource($name, array $optionalArgs = [])
    {
        $request = new GetSourceRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetSource',
            Source::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Filters an organization's assets and  groups them by their specified
     * properties.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->organizationName('[ORGANIZATION]');
     *     $groupBy = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $securityCenterClient->groupAssets($formattedParent, $groupBy);
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
     *     $pagedResponse = $securityCenterClient->groupAssets($formattedParent, $groupBy);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent  Name of the organization to groupBy. Its format is
     *                        "organizations/[organization_id]".
     * @param string $groupBy Expression that defines what assets fields to use for grouping. The string
     *                        value should follow SQL syntax: comma separated list of fields. For
     *                        example:
     *                        "security_center_properties.resource_project,security_center_properties.project".
     *
     * The following fields are supported when compare_duration is not set:
     *
     * * security_center_properties.resource_project
     * * security_center_properties.resource_type
     * * security_center_properties.resource_parent
     *
     * The following fields are supported when compare_duration is set:
     *
     * * security_center_properties.resource_type
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $filter
     *          Expression that defines the filter to apply across assets.
     *          The expression is a list of zero or more restrictions combined via logical
     *          operators `AND` and `OR`.
     *          Parentheses are supported, and `OR` has higher precedence than `AND`.
     *
     *          Restrictions have the form `<field> <operator> <value>` and may have a `-`
     *          character in front of them to indicate negation. The fields map to those
     *          defined in the Asset resource. Examples include:
     *
     *          * name
     *          * security_center_properties.resource_name
     *          * resource_properties.a_property
     *          * security_marks.marks.marka
     *
     *          The supported operators are:
     *
     *          * `=` for all value types.
     *          * `>`, `<`, `>=`, `<=` for integer values.
     *          * `:`, meaning substring matching, for strings.
     *
     *          The supported value types are:
     *
     *          * string literals in quotes.
     *          * integer literals without quotes.
     *          * boolean literals `true` and `false` without quotes.
     *
     *          The following field and operator combinations are supported:
     *          name | '='
     *          update_time | '=', '>', '<', '>=', '<='
     *
     *            Usage: This should be milliseconds since epoch or an RFC3339 string.
     *            Examples:
     *              "update_time = \"2019-06-10T16:07:18-07:00\""
     *              "update_time = 1560208038000"
     *
     *          create_time |  '=', '>', '<', '>=', '<='
     *
     *            Usage: This should be milliseconds since epoch or an RFC3339 string.
     *            Examples:
     *              "create_time = \"2019-06-10T16:07:18-07:00\""
     *              "create_time = 1560208038000"
     *
     *          iam_policy.policy_blob | '=', ':'
     *          resource_properties | '=', ':', '>', '<', '>=', '<='
     *          security_marks | '=', ':'
     *          security_center_properties.resource_name | '=', ':'
     *          security_center_properties.resource_type | '=', ':'
     *          security_center_properties.resource_parent | '=', ':'
     *          security_center_properties.resource_project | '=', ':'
     *          security_center_properties.resource_owners | '=', ':'
     *
     *          For example, `resource_properties.size = 100` is a valid filter string.
     *     @type Duration $compareDuration
     *          When compare_duration is set, the GroupResult's "state_change" property is
     *          updated to indicate whether the asset was added, removed, or remained
     *          present during the compare_duration period of time that precedes the
     *          read_time. This is the time between (read_time - compare_duration) and
     *          read_time.
     *
     *          The state change value is derived based on the presence of the asset at the
     *          two points in time. Intermediate state changes between the two times don't
     *          affect the result. For example, the results aren't affected if the asset is
     *          removed and re-created again.
     *
     *          Possible "state_change" values when compare_duration is specified:
     *
     *          * "ADDED":   indicates that the asset was not present at the start of
     *                         compare_duration, but present at reference_time.
     *          * "REMOVED": indicates that the asset was present at the start of
     *                         compare_duration, but not present at reference_time.
     *          * "ACTIVE":  indicates that the asset was present at both the
     *                         start and the end of the time period defined by
     *                         compare_duration and reference_time.
     *
     *          If compare_duration is not specified, then the only possible state_change
     *          is "UNUSED", which will be the state_change set for all assets present at
     *          read_time.
     *
     *          If this field is set then `state_change` must be a specified field in
     *          `group_by`.
     *     @type Timestamp $readTime
     *          Time used as a reference point when filtering assets. The filter is limited
     *          to assets existing at the supplied time and their values are those at that
     *          specific time. Absence of this field will default to the API's version of
     *          NOW.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function groupAssets($parent, $groupBy, array $optionalArgs = [])
    {
        $request = new GroupAssetsRequest();
        $request->setParent($parent);
        $request->setGroupBy($groupBy);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['compareDuration'])) {
            $request->setCompareDuration($optionalArgs['compareDuration']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'GroupAssets',
            $optionalArgs,
            GroupAssetsResponse::class,
            $request
        );
    }

    /**
     * Filters an organization or source's findings and  groups them by their
     * specified properties.
     *
     * To group across all sources provide a `-` as the source id.
     * Example: /v1/organizations/123/sources/-/findings
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     $groupBy = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $securityCenterClient->groupFindings($formattedParent, $groupBy);
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
     *     $pagedResponse = $securityCenterClient->groupFindings($formattedParent, $groupBy);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent  Name of the source to groupBy. Its format is
     *                        "organizations/[organization_id]/sources/[source_id]". To groupBy across
     *                        all sources provide a source_id of `-`. For example:
     *                        organizations/123/sources/-
     * @param string $groupBy Expression that defines what assets fields to use for grouping (including
     *                        `state_change`). The string value should follow SQL syntax: comma separated
     *                        list of fields. For example: "parent,resource_name".
     *
     * The following fields are supported:
     *
     * * resource_name
     * * category
     * * state
     * * parent
     *
     * The following fields are supported when compare_duration is set:
     *
     * * state_change
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $filter
     *          Expression that defines the filter to apply across findings.
     *          The expression is a list of one or more restrictions combined via logical
     *          operators `AND` and `OR`.
     *          Parentheses are supported, and `OR` has higher precedence than `AND`.
     *
     *          Restrictions have the form `<field> <operator> <value>` and may have a `-`
     *          character in front of them to indicate negation. Examples include:
     *
     *           * name
     *           * source_properties.a_property
     *           * security_marks.marks.marka
     *
     *          The supported operators are:
     *
     *          * `=` for all value types.
     *          * `>`, `<`, `>=`, `<=` for integer values.
     *          * `:`, meaning substring matching, for strings.
     *
     *          The supported value types are:
     *
     *          * string literals in quotes.
     *          * integer literals without quotes.
     *          * boolean literals `true` and `false` without quotes.
     *
     *          The following field and operator combinations are supported:
     *          name | `=`
     *          parent | '=', ':'
     *          resource_name | '=', ':'
     *          state | '=', ':'
     *          category | '=', ':'
     *          external_uri | '=', ':'
     *          event_time | `=`, `>`, `<`, `>=`, `<=`
     *
     *            Usage: This should be milliseconds since epoch or an RFC3339 string.
     *            Examples:
     *              "event_time = \"2019-06-10T16:07:18-07:00\""
     *              "event_time = 1560208038000"
     *
     *          security_marks | '=', ':'
     *          source_properties | '=', ':', `>`, `<`, `>=`, `<=`
     *
     *          For example, `source_properties.size = 100` is a valid filter string.
     *     @type Timestamp $readTime
     *          Time used as a reference point when filtering findings. The filter is
     *          limited to findings existing at the supplied time and their values are
     *          those at that specific time. Absence of this field will default to the
     *          API's version of NOW.
     *     @type Duration $compareDuration
     *          When compare_duration is set, the GroupResult's "state_change" attribute is
     *          updated to indicate whether the finding had its state changed, the
     *          finding's state remained unchanged, or if the finding was added during the
     *          compare_duration period of time that precedes the read_time. This is the
     *          time between (read_time - compare_duration) and read_time.
     *
     *          The state_change value is derived based on the presence and state of the
     *          finding at the two points in time. Intermediate state changes between the
     *          two times don't affect the result. For example, the results aren't affected
     *          if the finding is made inactive and then active again.
     *
     *          Possible "state_change" values when compare_duration is specified:
     *
     *          * "CHANGED":   indicates that the finding was present at the start of
     *                           compare_duration, but changed its state at read_time.
     *          * "UNCHANGED": indicates that the finding was present at the start of
     *                           compare_duration and did not change state at read_time.
     *          * "ADDED":     indicates that the finding was not present at the start
     *                           of compare_duration, but was present at read_time.
     *
     *          If compare_duration is not specified, then the only possible state_change
     *          is "UNUSED",  which will be the state_change set for all findings present
     *          at read_time.
     *
     *          If this field is set then `state_change` must be a specified field in
     *          `group_by`.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function groupFindings($parent, $groupBy, array $optionalArgs = [])
    {
        $request = new GroupFindingsRequest();
        $request->setParent($parent);
        $request->setGroupBy($groupBy);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }
        if (isset($optionalArgs['compareDuration'])) {
            $request->setCompareDuration($optionalArgs['compareDuration']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'GroupFindings',
            $optionalArgs,
            GroupFindingsResponse::class,
            $request
        );
    }

    /**
     * Lists an organization's assets.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->organizationName('[ORGANIZATION]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $securityCenterClient->listAssets($formattedParent);
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
     *     $pagedResponse = $securityCenterClient->listAssets($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent       Name of the organization assets should belong to. Its format is
     *                             "organizations/[organization_id]".
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          Expression that defines the filter to apply across assets.
     *          The expression is a list of zero or more restrictions combined via logical
     *          operators `AND` and `OR`.
     *          Parentheses are supported, and `OR` has higher precedence than `AND`.
     *
     *          Restrictions have the form `<field> <operator> <value>` and may have a `-`
     *          character in front of them to indicate negation. The fields map to those
     *          defined in the Asset resource. Examples include:
     *
     *          * name
     *          * security_center_properties.resource_name
     *          * resource_properties.a_property
     *          * security_marks.marks.marka
     *
     *          The supported operators are:
     *
     *          * `=` for all value types.
     *          * `>`, `<`, `>=`, `<=` for integer values.
     *          * `:`, meaning substring matching, for strings.
     *
     *          The supported value types are:
     *
     *          * string literals in quotes.
     *          * integer literals without quotes.
     *          * boolean literals `true` and `false` without quotes.
     *
     *          The following are the allowed field and operator combinations:
     *          name | `=`
     *          update_time | `=`, `>`, `<`, `>=`, `<=`
     *
     *            Usage: This should be milliseconds since epoch or an RFC3339 string.
     *            Examples:
     *              "update_time = \"2019-06-10T16:07:18-07:00\""
     *              "update_time = 1560208038000"
     *
     *          create_time | `=`, `>`, `<`, `>=`, `<=`
     *
     *            Usage: This should be milliseconds since epoch or an RFC3339 string.
     *            Examples:
     *              "create_time = \"2019-06-10T16:07:18-07:00\""
     *              "create_time = 1560208038000"
     *
     *          iam_policy.policy_blob | '=', ':'
     *          resource_properties | '=', ':', `>`, `<`, `>=`, `<=`
     *          security_marks | '=', ':'
     *          security_center_properties.resource_name | '=', ':'
     *          security_center_properties.resource_type | '=', ':'
     *          security_center_properties.resource_parent | '=', ':'
     *          security_center_properties.resource_project | '=', ':'
     *          security_center_properties.resource_owners | '=', ':'
     *
     *          For example, `resource_properties.size = 100` is a valid filter string.
     *     @type string $orderBy
     *          Expression that defines what fields and order to use for sorting. The
     *          string value should follow SQL syntax: comma separated list of fields. For
     *          example: "name,resource_properties.a_property". The default sorting order
     *          is ascending. To specify descending order for a field, a suffix " desc"
     *          should be appended to the field name. For example: "name
     *          desc,resource_properties.a_property". Redundant space characters in the
     *          syntax are insignificant. "name desc,resource_properties.a_property" and "
     *          name     desc  ,   resource_properties.a_property  " are equivalent.
     *
     *          The following fields are supported:
     *          name
     *          update_time
     *          resource_properties
     *          security_marks
     *          security_center_properties.resource_name
     *          security_center_properties.resource_parent
     *          security_center_properties.resource_project
     *          security_center_properties.resource_type
     *     @type Timestamp $readTime
     *          Time used as a reference point when filtering assets. The filter is limited
     *          to assets existing at the supplied time and their values are those at that
     *          specific time. Absence of this field will default to the API's version of
     *          NOW.
     *     @type Duration $compareDuration
     *          When compare_duration is set, the ListAssetsResult's "state_change"
     *          attribute is updated to indicate whether the asset was added, removed, or
     *          remained present during the compare_duration period of time that precedes
     *          the read_time. This is the time between (read_time - compare_duration) and
     *          read_time.
     *
     *          The state_change value is derived based on the presence of the asset at the
     *          two points in time. Intermediate state changes between the two times don't
     *          affect the result. For example, the results aren't affected if the asset is
     *          removed and re-created again.
     *
     *          Possible "state_change" values when compare_duration is specified:
     *
     *          * "ADDED":   indicates that the asset was not present at the start of
     *                         compare_duration, but present at read_time.
     *          * "REMOVED": indicates that the asset was present at the start of
     *                         compare_duration, but not present at read_time.
     *          * "ACTIVE":  indicates that the asset was present at both the
     *                         start and the end of the time period defined by
     *                         compare_duration and read_time.
     *
     *          If compare_duration is not specified, then the only possible state_change
     *          is "UNUSED",  which will be the state_change set for all assets present at
     *          read_time.
     *     @type FieldMask $fieldMask
     *          Optional.
     *
     *          A field mask to specify the ListAssetsResult fields to be listed in the
     *          response.
     *          An empty field mask will list all fields.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function listAssets($parent, array $optionalArgs = [])
    {
        $request = new ListAssetsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }
        if (isset($optionalArgs['compareDuration'])) {
            $request->setCompareDuration($optionalArgs['compareDuration']);
        }
        if (isset($optionalArgs['fieldMask'])) {
            $request->setFieldMask($optionalArgs['fieldMask']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListAssets',
            $optionalArgs,
            ListAssetsResponse::class,
            $request
        );
    }

    /**
     * Lists an organization or source's findings.
     *
     * To list across all sources provide a `-` as the source id.
     * Example: /v1/organizations/123/sources/-/findings
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $securityCenterClient->listFindings($formattedParent);
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
     *     $pagedResponse = $securityCenterClient->listFindings($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent       Name of the source the findings belong to. Its format is
     *                             "organizations/[organization_id]/sources/[source_id]". To list across all
     *                             sources provide a source_id of `-`. For example:
     *                             organizations/123/sources/-
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          Expression that defines the filter to apply across findings.
     *          The expression is a list of one or more restrictions combined via logical
     *          operators `AND` and `OR`.
     *          Parentheses are supported, and `OR` has higher precedence than `AND`.
     *
     *          Restrictions have the form `<field> <operator> <value>` and may have a `-`
     *          character in front of them to indicate negation. Examples include:
     *
     *           * name
     *           * source_properties.a_property
     *           * security_marks.marks.marka
     *
     *          The supported operators are:
     *
     *          * `=` for all value types.
     *          * `>`, `<`, `>=`, `<=` for integer values.
     *          * `:`, meaning substring matching, for strings.
     *
     *          The supported value types are:
     *
     *          * string literals in quotes.
     *          * integer literals without quotes.
     *          * boolean literals `true` and `false` without quotes.
     *
     *          The following field and operator combinations are supported:
     *          name | `=`
     *          parent | '=', ':'
     *          resource_name | '=', ':'
     *          state | '=', ':'
     *          category | '=', ':'
     *          external_uri | '=', ':'
     *          event_time | `=`, `>`, `<`, `>=`, `<=`
     *
     *            Usage: This should be milliseconds since epoch or an RFC3339 string.
     *            Examples:
     *              "event_time = \"2019-06-10T16:07:18-07:00\""
     *              "event_time = 1560208038000"
     *
     *          security_marks | '=', ':'
     *          source_properties | '=', ':', `>`, `<`, `>=`, `<=`
     *
     *          For example, `source_properties.size = 100` is a valid filter string.
     *     @type string $orderBy
     *          Expression that defines what fields and order to use for sorting. The
     *          string value should follow SQL syntax: comma separated list of fields. For
     *          example: "name,resource_properties.a_property". The default sorting order
     *          is ascending. To specify descending order for a field, a suffix " desc"
     *          should be appended to the field name. For example: "name
     *          desc,source_properties.a_property". Redundant space characters in the
     *          syntax are insignificant. "name desc,source_properties.a_property" and "
     *          name     desc  ,   source_properties.a_property  " are equivalent.
     *
     *          The following fields are supported:
     *          name
     *          parent
     *          state
     *          category
     *          resource_name
     *          event_time
     *          source_properties
     *          security_marks
     *     @type Timestamp $readTime
     *          Time used as a reference point when filtering findings. The filter is
     *          limited to findings existing at the supplied time and their values are
     *          those at that specific time. Absence of this field will default to the
     *          API's version of NOW.
     *     @type Duration $compareDuration
     *          When compare_duration is set, the ListFindingsResult's "state_change"
     *          attribute is updated to indicate whether the finding had its state changed,
     *          the finding's state remained unchanged, or if the finding was added in any
     *          state during the compare_duration period of time that precedes the
     *          read_time. This is the time between (read_time - compare_duration) and
     *          read_time.
     *
     *          The state_change value is derived based on the presence and state of the
     *          finding at the two points in time. Intermediate state changes between the
     *          two times don't affect the result. For example, the results aren't affected
     *          if the finding is made inactive and then active again.
     *
     *          Possible "state_change" values when compare_duration is specified:
     *
     *          * "CHANGED":   indicates that the finding was present at the start of
     *                           compare_duration, but changed its state at read_time.
     *          * "UNCHANGED": indicates that the finding was present at the start of
     *                           compare_duration and did not change state at read_time.
     *          * "ADDED":     indicates that the finding was not present at the start
     *                           of compare_duration, but was present at read_time.
     *
     *          If compare_duration is not specified, then the only possible state_change
     *          is "UNUSED", which will be the state_change set for all findings present at
     *          read_time.
     *     @type FieldMask $fieldMask
     *          Optional.
     *
     *          A field mask to specify the Finding fields to be listed in the response.
     *          An empty field mask will list all fields.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function listFindings($parent, array $optionalArgs = [])
    {
        $request = new ListFindingsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }
        if (isset($optionalArgs['compareDuration'])) {
            $request->setCompareDuration($optionalArgs['compareDuration']);
        }
        if (isset($optionalArgs['fieldMask'])) {
            $request->setFieldMask($optionalArgs['fieldMask']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListFindings',
            $optionalArgs,
            ListFindingsResponse::class,
            $request
        );
    }

    /**
     * Lists all sources belonging to an organization.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->organizationName('[ORGANIZATION]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $securityCenterClient->listSources($formattedParent);
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
     *     $pagedResponse = $securityCenterClient->listSources($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the parent of sources to list. Its format should be
     *                             "organizations/[organization_id]".
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function listSources($parent, array $optionalArgs = [])
    {
        $request = new ListSourcesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListSources',
            $optionalArgs,
            ListSourcesResponse::class,
            $request
        );
    }

    /**
     * Runs asset discovery. The discovery is tracked with a long-running
     * operation.
     *
     * This API can only be called with limited frequency for an organization. If
     * it is called too frequently the caller will receive a TOO_MANY_REQUESTS
     * error.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedParent = $securityCenterClient->organizationName('[ORGANIZATION]');
     *     $operationResponse = $securityCenterClient->runAssetDiscovery($formattedParent);
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
     *     $operationResponse = $securityCenterClient->runAssetDiscovery($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $securityCenterClient->resumeOperation($operationName, 'runAssetDiscovery');
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
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $parent       Name of the organization to run asset discovery for. Its format is
     *                             "organizations/[organization_id]".
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function runAssetDiscovery($parent, array $optionalArgs = [])
    {
        $request = new RunAssetDiscoveryRequest();
        $request->setParent($parent);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'RunAssetDiscovery',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Updates the state of a finding.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedName = $securityCenterClient->findingName('[ORGANIZATION]', '[SOURCE]', '[FINDING]');
     *     $state = State::STATE_UNSPECIFIED;
     *     $startTime = new Timestamp();
     *     $response = $securityCenterClient->setFindingState($formattedName, $state, $startTime);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string    $name         The relative resource name of the finding. See:
     *                                https://cloud.google.com/apis/design/resource_names#relative_resource_name
     *                                Example:
     *                                "organizations/123/sources/456/finding/789".
     * @param int       $state        The desired State of the finding.
     *                                For allowed values, use constants defined on {@see \Google\Cloud\SecurityCenter\V1\Finding\State}
     * @param Timestamp $startTime    The time at which the updated state takes effect.
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
     * @return \Google\Cloud\SecurityCenter\V1\Finding
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setFindingState($name, $state, $startTime, array $optionalArgs = [])
    {
        $request = new SetFindingStateRequest();
        $request->setName($name);
        $request->setState($state);
        $request->setStartTime($startTime);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetFindingState',
            Finding::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the access control policy on the specified Source.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedResource = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     $policy = new Policy();
     *     $response = $securityCenterClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             See the operation documentation for the appropriate value for this field.
     * @param Policy $policy       REQUIRED: The complete policy to be applied to the `resource`. The size of
     *                             the policy is limited to a few 10s of KB. An empty policy is a
     *                             valid policy but certain Cloud Platform services (such as Projects)
     *                             might reject them.
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
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, array $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns the permissions that a caller has on the specified source.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $formattedResource = $securityCenterClient->sourceName('[ORGANIZATION]', '[SOURCE]');
     *     $permissions = [];
     *     $response = $securityCenterClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               See the operation documentation for the appropriate value for this field.
     * @param string[] $permissions  The set of permissions to check for the `resource`. Permissions with
     *                               wildcards (such as '*' or 'storage.*') are not allowed. For more
     *                               information see
     *                               [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
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
     * @return \Google\Cloud\Iam\V1\TestIamPermissionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, array $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'TestIamPermissions',
            TestIamPermissionsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates or updates a finding. The corresponding source must exist for a
     * finding creation to succeed.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $finding = new Finding();
     *     $response = $securityCenterClient->updateFinding($finding);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param Finding $finding The finding resource to update or create if it does not already exist.
     *                         parent, security_marks, and update_time will be ignored.
     *
     * In the case of creation, the finding id portion of the name must be
     * alphanumeric and less than or equal to 32 characters and greater than 0
     * characters in length.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type FieldMask $updateMask
     *          The FieldMask to use when updating the finding resource. This field should
     *          not be specified when creating a finding.
     *
     *          When updating a finding, an empty mask is treated as updating all mutable
     *          fields and replacing source_properties.  Individual source_properties can
     *          be added/updated by using "source_properties.<property key>" in the field
     *          mask.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\SecurityCenter\V1\Finding
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateFinding($finding, array $optionalArgs = [])
    {
        $request = new UpdateFindingRequest();
        $request->setFinding($finding);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'finding.name' => $request->getFinding()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateFinding',
            Finding::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an organization's settings.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $organizationSettings = new OrganizationSettings();
     *     $response = $securityCenterClient->updateOrganizationSettings($organizationSettings);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param OrganizationSettings $organizationSettings The organization settings resource to update.
     * @param array                $optionalArgs         {
     *                                                   Optional.
     *
     *     @type FieldMask $updateMask
     *          The FieldMask to use when updating the settings resource.
     *
     *           If empty all mutable fields will be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\SecurityCenter\V1\OrganizationSettings
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateOrganizationSettings($organizationSettings, array $optionalArgs = [])
    {
        $request = new UpdateOrganizationSettingsRequest();
        $request->setOrganizationSettings($organizationSettings);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'organization_settings.name' => $request->getOrganizationSettings()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateOrganizationSettings',
            OrganizationSettings::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a source.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $source = new Source();
     *     $response = $securityCenterClient->updateSource($source);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param Source $source       The source resource to update.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type FieldMask $updateMask
     *          The FieldMask to use when updating the source resource.
     *
     *          If empty all mutable fields will be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\SecurityCenter\V1\Source
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateSource($source, array $optionalArgs = [])
    {
        $request = new UpdateSourceRequest();
        $request->setSource($source);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'source.name' => $request->getSource()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateSource',
            Source::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates security marks.
     *
     * Sample code:
     * ```
     * $securityCenterClient = new SecurityCenterClient();
     * try {
     *     $securityMarks = new SecurityMarks();
     *     $response = $securityCenterClient->updateSecurityMarks($securityMarks);
     * } finally {
     *     $securityCenterClient->close();
     * }
     * ```
     *
     * @param SecurityMarks $securityMarks The security marks resource to update.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type FieldMask $updateMask
     *          The FieldMask to use when updating the security marks resource.
     *
     *          The field mask must not contain duplicate fields.
     *          If empty or set to "marks", all marks will be replaced.  Individual
     *          marks can be updated using "marks.<mark_key>".
     *     @type Timestamp $startTime
     *          The time at which the updated SecurityMarks take effect.
     *          If not set uses current server time.  Updates will be applied to the
     *          SecurityMarks that are active immediately preceding this time.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\SecurityCenter\V1\SecurityMarks
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateSecurityMarks($securityMarks, array $optionalArgs = [])
    {
        $request = new UpdateSecurityMarksRequest();
        $request->setSecurityMarks($securityMarks);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }
        if (isset($optionalArgs['startTime'])) {
            $request->setStartTime($optionalArgs['startTime']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'security_marks.name' => $request->getSecurityMarks()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateSecurityMarks',
            SecurityMarks::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
