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
 * https://github.com/google/googleapis/blob/master/google/cloud/talent/v4beta1/application_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Talent\V4beta1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Talent\V4beta1\Application;
use Google\Cloud\Talent\V4beta1\CreateApplicationRequest;
use Google\Cloud\Talent\V4beta1\DeleteApplicationRequest;
use Google\Cloud\Talent\V4beta1\GetApplicationRequest;
use Google\Cloud\Talent\V4beta1\ListApplicationsRequest;
use Google\Cloud\Talent\V4beta1\ListApplicationsResponse;
use Google\Cloud\Talent\V4beta1\UpdateApplicationRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: A service that handles application management, including CRUD and
 * enumeration.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $applicationServiceClient = new ApplicationServiceClient();
 * try {
 *     $formattedParent = $applicationServiceClient->profileName('[PROJECT]', '[TENANT]', '[PROFILE]');
 *     $application = new Application();
 *     $response = $applicationServiceClient->createApplication($formattedParent, $application);
 * } finally {
 *     $applicationServiceClient->close();
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
class ApplicationServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.talent.v4beta1.ApplicationService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'jobs.googleapis.com';

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
        'https://www.googleapis.com/auth/jobs',
    ];
    private static $applicationNameTemplate;
    private static $profileNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/application_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/application_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/application_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/application_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getApplicationNameTemplate()
    {
        if (null == self::$applicationNameTemplate) {
            self::$applicationNameTemplate = new PathTemplate('projects/{project}/tenants/{tenant}/profiles/{profile}/applications/{application}');
        }

        return self::$applicationNameTemplate;
    }

    private static function getProfileNameTemplate()
    {
        if (null == self::$profileNameTemplate) {
            self::$profileNameTemplate = new PathTemplate('projects/{project}/tenants/{tenant}/profiles/{profile}');
        }

        return self::$profileNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'application' => self::getApplicationNameTemplate(),
                'profile' => self::getProfileNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a application resource.
     *
     * @param string $project
     * @param string $tenant
     * @param string $profile
     * @param string $application
     *
     * @return string The formatted application resource.
     * @experimental
     */
    public static function applicationName($project, $tenant, $profile, $application)
    {
        return self::getApplicationNameTemplate()->render([
            'project' => $project,
            'tenant' => $tenant,
            'profile' => $profile,
            'application' => $application,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a profile resource.
     *
     * @param string $project
     * @param string $tenant
     * @param string $profile
     *
     * @return string The formatted profile resource.
     * @experimental
     */
    public static function profileName($project, $tenant, $profile)
    {
        return self::getProfileNameTemplate()->render([
            'project' => $project,
            'tenant' => $tenant,
            'profile' => $profile,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - application: projects/{project}/tenants/{tenant}/profiles/{profile}/applications/{application}
     * - profile: projects/{project}/tenants/{tenant}/profiles/{profile}.
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
     *           as "<uri>:<port>". Default 'jobs.googleapis.com:443'.
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
     * Creates a new application entity.
     *
     * Sample code:
     * ```
     * $applicationServiceClient = new ApplicationServiceClient();
     * try {
     *     $formattedParent = $applicationServiceClient->profileName('[PROJECT]', '[TENANT]', '[PROFILE]');
     *     $application = new Application();
     *     $response = $applicationServiceClient->createApplication($formattedParent, $application);
     * } finally {
     *     $applicationServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. Resource name of the profile under which the application is
     *                       created.
     *
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/profiles/{profile_id}", for
     * example, "projects/test-project/tenants/test-tenant/profiles/test-profile".
     * @param Application $application  Required. The application to be created.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Talent\V4beta1\Application
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createApplication($parent, $application, array $optionalArgs = [])
    {
        $request = new CreateApplicationRequest();
        $request->setParent($parent);
        $request->setApplication($application);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateApplication',
            Application::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Retrieves specified application.
     *
     * Sample code:
     * ```
     * $applicationServiceClient = new ApplicationServiceClient();
     * try {
     *     $formattedName = $applicationServiceClient->applicationName('[PROJECT]', '[TENANT]', '[PROFILE]', '[APPLICATION]');
     *     $response = $applicationServiceClient->getApplication($formattedName);
     * } finally {
     *     $applicationServiceClient->close();
     * }
     * ```
     *
     * @param string $name Required. The resource name of the application to be retrieved.
     *
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/profiles/{profile_id}/applications/{application_id}",
     * for example,
     * "projects/test-project/tenants/test-tenant/profiles/test-profile/applications/test-application".
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Talent\V4beta1\Application
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getApplication($name, array $optionalArgs = [])
    {
        $request = new GetApplicationRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetApplication',
            Application::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates specified application.
     *
     * Sample code:
     * ```
     * $applicationServiceClient = new ApplicationServiceClient();
     * try {
     *     $application = new Application();
     *     $response = $applicationServiceClient->updateApplication($application);
     * } finally {
     *     $applicationServiceClient->close();
     * }
     * ```
     *
     * @param Application $application  Required. The application resource to replace the current resource in the
     *                                  system.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type FieldMask $updateMask
     *          Optional but strongly recommended for the best service
     *          experience.
     *
     *          If
     *          [update_mask][google.cloud.talent.v4beta1.UpdateApplicationRequest.update_mask]
     *          is provided, only the specified fields in
     *          [application][google.cloud.talent.v4beta1.UpdateApplicationRequest.application]
     *          are updated. Otherwise all the fields are updated.
     *
     *          A field mask to specify the application fields to be updated. Only
     *          top level fields of [Application][google.cloud.talent.v4beta1.Application]
     *          are supported.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Talent\V4beta1\Application
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateApplication($application, array $optionalArgs = [])
    {
        $request = new UpdateApplicationRequest();
        $request->setApplication($application);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'application.name' => $request->getApplication()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateApplication',
            Application::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes specified application.
     *
     * Sample code:
     * ```
     * $applicationServiceClient = new ApplicationServiceClient();
     * try {
     *     $formattedName = $applicationServiceClient->applicationName('[PROJECT]', '[TENANT]', '[PROFILE]', '[APPLICATION]');
     *     $applicationServiceClient->deleteApplication($formattedName);
     * } finally {
     *     $applicationServiceClient->close();
     * }
     * ```
     *
     * @param string $name Required. The resource name of the application to be deleted.
     *
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/profiles/{profile_id}/applications/{application_id}",
     * for example,
     * "projects/test-project/tenants/test-tenant/profiles/test-profile/applications/test-application".
     * @param array $optionalArgs {
     *                            Optional.
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
    public function deleteApplication($name, array $optionalArgs = [])
    {
        $request = new DeleteApplicationRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteApplication',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all applications associated with the profile.
     *
     * Sample code:
     * ```
     * $applicationServiceClient = new ApplicationServiceClient();
     * try {
     *     $formattedParent = $applicationServiceClient->profileName('[PROJECT]', '[TENANT]', '[PROFILE]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $applicationServiceClient->listApplications($formattedParent);
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
     *     $pagedResponse = $applicationServiceClient->listApplications($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $applicationServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. Resource name of the profile under which the application is
     *                       created.
     *
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/profiles/{profile_id}", for
     * example, "projects/test-project/tenants/test-tenant/profiles/test-profile".
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listApplications($parent, array $optionalArgs = [])
    {
        $request = new ListApplicationsRequest();
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
            'ListApplications',
            $optionalArgs,
            ListApplicationsResponse::class,
            $request
        );
    }
}
