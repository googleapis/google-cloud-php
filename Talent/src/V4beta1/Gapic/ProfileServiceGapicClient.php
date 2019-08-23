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
 * https://github.com/google/googleapis/blob/master/google/cloud/talent/v4beta1/profile_service.proto
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
use Google\Cloud\Talent\V4beta1\CreateProfileRequest;
use Google\Cloud\Talent\V4beta1\DeleteProfileRequest;
use Google\Cloud\Talent\V4beta1\GetProfileRequest;
use Google\Cloud\Talent\V4beta1\HistogramQuery;
use Google\Cloud\Talent\V4beta1\ListProfilesRequest;
use Google\Cloud\Talent\V4beta1\ListProfilesResponse;
use Google\Cloud\Talent\V4beta1\Profile;
use Google\Cloud\Talent\V4beta1\ProfileQuery;
use Google\Cloud\Talent\V4beta1\RequestMetadata;
use Google\Cloud\Talent\V4beta1\SearchProfilesRequest;
use Google\Cloud\Talent\V4beta1\SearchProfilesResponse;
use Google\Cloud\Talent\V4beta1\UpdateProfileRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: A service that handles profile management, including profile CRUD,
 * enumeration and search.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $profileServiceClient = new ProfileServiceClient();
 * try {
 *     $formattedParent = $profileServiceClient->tenantName('[PROJECT]', '[TENANT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $profileServiceClient->listProfiles($formattedParent);
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
 *     $pagedResponse = $profileServiceClient->listProfiles($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $profileServiceClient->close();
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
class ProfileServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.talent.v4beta1.ProfileService';

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
    private static $profileNameTemplate;
    private static $tenantNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/profile_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/profile_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/profile_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/profile_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getProfileNameTemplate()
    {
        if (null == self::$profileNameTemplate) {
            self::$profileNameTemplate = new PathTemplate('projects/{project}/tenants/{tenant}/profiles/{profile}');
        }

        return self::$profileNameTemplate;
    }

    private static function getTenantNameTemplate()
    {
        if (null == self::$tenantNameTemplate) {
            self::$tenantNameTemplate = new PathTemplate('projects/{project}/tenants/{tenant}');
        }

        return self::$tenantNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'profile' => self::getProfileNameTemplate(),
                'tenant' => self::getTenantNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * Formats a string containing the fully-qualified path to represent
     * a tenant resource.
     *
     * @param string $project
     * @param string $tenant
     *
     * @return string The formatted tenant resource.
     * @experimental
     */
    public static function tenantName($project, $tenant)
    {
        return self::getTenantNameTemplate()->render([
            'project' => $project,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - profile: projects/{project}/tenants/{tenant}/profiles/{profile}
     * - tenant: projects/{project}/tenants/{tenant}.
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
     * Lists profiles by filter. The order is unspecified.
     *
     * Sample code:
     * ```
     * $profileServiceClient = new ProfileServiceClient();
     * try {
     *     $formattedParent = $profileServiceClient->tenantName('[PROJECT]', '[TENANT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $profileServiceClient->listProfiles($formattedParent);
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
     *     $pagedResponse = $profileServiceClient->listProfiles($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $profileServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The resource name of the tenant under which the profile is
     *                       created.
     *
     * The format is "projects/{project_id}/tenants/{tenant_id}", for example,
     * "projects/api-test-project/tenants/foo".
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
     *     @type FieldMask $readMask
     *          Optional. A field mask to specify the profile fields to be listed in
     *          response. All fields are listed if it is unset.
     *
     *          Valid values are:
     *
     *          * name
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
    public function listProfiles($parent, array $optionalArgs = [])
    {
        $request = new ListProfilesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['readMask'])) {
            $request->setReadMask($optionalArgs['readMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListProfiles',
            $optionalArgs,
            ListProfilesResponse::class,
            $request
        );
    }

    /**
     * Creates and returns a new profile.
     *
     * Sample code:
     * ```
     * $profileServiceClient = new ProfileServiceClient();
     * try {
     *     $formattedParent = $profileServiceClient->tenantName('[PROJECT]', '[TENANT]');
     *     $profile = new Profile();
     *     $response = $profileServiceClient->createProfile($formattedParent, $profile);
     * } finally {
     *     $profileServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the tenant this profile belongs to.
     *
     * The format is "projects/{project_id}/tenants/{tenant_id}", for example,
     * "projects/api-test-project/tenants/foo".
     * @param Profile $profile      Required. The profile to be created.
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
     * @return \Google\Cloud\Talent\V4beta1\Profile
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createProfile($parent, $profile, array $optionalArgs = [])
    {
        $request = new CreateProfileRequest();
        $request->setParent($parent);
        $request->setProfile($profile);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateProfile',
            Profile::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the specified profile.
     *
     * Sample code:
     * ```
     * $profileServiceClient = new ProfileServiceClient();
     * try {
     *     $formattedName = $profileServiceClient->profileName('[PROJECT]', '[TENANT]', '[PROFILE]');
     *     $response = $profileServiceClient->getProfile($formattedName);
     * } finally {
     *     $profileServiceClient->close();
     * }
     * ```
     *
     * @param string $name Required. Resource name of the profile to get.
     *
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/profiles/{profile_id}",
     * for example, "projects/api-test-project/tenants/foo/profiles/bar".
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
     * @return \Google\Cloud\Talent\V4beta1\Profile
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getProfile($name, array $optionalArgs = [])
    {
        $request = new GetProfileRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetProfile',
            Profile::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the specified profile and returns the updated result.
     *
     * Sample code:
     * ```
     * $profileServiceClient = new ProfileServiceClient();
     * try {
     *     $profile = new Profile();
     *     $response = $profileServiceClient->updateProfile($profile);
     * } finally {
     *     $profileServiceClient->close();
     * }
     * ```
     *
     * @param Profile $profile      Required. Profile to be updated.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type FieldMask $updateMask
     *          Optional. A field mask to specify the profile fields to update.
     *
     *          A full update is performed if it is unset.
     *
     *          Valid values are:
     *
     *          * external_id
     *          * source
     *          * uri
     *          * is_hirable
     *          * create_time
     *          * update_time
     *          * resume
     *          * person_names
     *          * addresses
     *          * email_addresses
     *          * phone_numbers
     *          * personal_uris
     *          * additional_contact_info
     *          * employment_records
     *          * education_records
     *          * skills
     *          * activities
     *          * publications
     *          * patents
     *          * certifications
     *          * recruiting_notes
     *          * custom_attributes
     *          * group_id
     *          * external_system
     *          * source_note
     *          * primary_responsibilities
     *          * citizenships
     *          * work_authorizations
     *          * employee_types
     *          * language_code
     *          * qualification_summary
     *          * allowed_contact_types
     *          * preferred_contact_types
     *          * contact_availability
     *          * language_fluencies
     *          * work_preference
     *          * industry_experiences
     *          * work_environment_experiences
     *          * work_availability
     *          * security_clearances
     *          * references
     *          * assessments
     *          * interviews
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Talent\V4beta1\Profile
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateProfile($profile, array $optionalArgs = [])
    {
        $request = new UpdateProfileRequest();
        $request->setProfile($profile);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'profile.name' => $request->getProfile()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateProfile',
            Profile::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the specified profile.
     * Prerequisite: The profile has no associated applications or assignments
     * associated.
     *
     * Sample code:
     * ```
     * $profileServiceClient = new ProfileServiceClient();
     * try {
     *     $formattedName = $profileServiceClient->profileName('[PROJECT]', '[TENANT]', '[PROFILE]');
     *     $profileServiceClient->deleteProfile($formattedName);
     * } finally {
     *     $profileServiceClient->close();
     * }
     * ```
     *
     * @param string $name Required. Resource name of the profile to be deleted.
     *
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/profiles/{profile_id}",
     * for example, "projects/api-test-project/tenants/foo/profiles/bar".
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
    public function deleteProfile($name, array $optionalArgs = [])
    {
        $request = new DeleteProfileRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteProfile',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Searches for profiles within a tenant.
     *
     * For example, search by raw queries "software engineer in Mountain View" or
     * search by structured filters (location filter, education filter, etc.).
     *
     * See
     * [SearchProfilesRequest][google.cloud.talent.v4beta1.SearchProfilesRequest]
     * for more information.
     *
     * Sample code:
     * ```
     * $profileServiceClient = new ProfileServiceClient();
     * try {
     *     $formattedParent = $profileServiceClient->tenantName('[PROJECT]', '[TENANT]');
     *     $requestMetadata = new RequestMetadata();
     *     // Iterate over pages of elements
     *     $pagedResponse = $profileServiceClient->searchProfiles($formattedParent, $requestMetadata);
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
     *     $pagedResponse = $profileServiceClient->searchProfiles($formattedParent, $requestMetadata);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $profileServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The resource name of the tenant to search within.
     *
     * The format is "projects/{project_id}/tenants/{tenant_id}", for example,
     * "projects/api-test-project/tenants/foo".
     * @param RequestMetadata $requestMetadata Required. The meta information collected about the profile search user.
     *                                         This is used to improve the search quality of the service. These values are
     *                                         provided by users, and must be precise and consistent.
     * @param array           $optionalArgs    {
     *                                         Optional.
     *
     *     @type ProfileQuery $profileQuery
     *          Optional. Search query to execute. See
     *          [ProfileQuery][google.cloud.talent.v4beta1.ProfileQuery] for more details.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $offset
     *          Optional. An integer that specifies the current offset (that is, starting
     *          result) in search results. This field is only considered if
     *          [page_token][google.cloud.talent.v4beta1.SearchProfilesRequest.page_token]
     *          is unset.
     *
     *          The maximum allowed value is 5000. Otherwise an error is thrown.
     *
     *          For example, 0 means to search from the first profile, and 10 means to
     *          search from the 11th profile. This can be used for pagination, for example
     *          pageSize = 10 and offset = 10 means to search from the second page.
     *     @type bool $disableSpellCheck
     *          Optional. This flag controls the spell-check feature. If `false`, the
     *          service attempts to correct a misspelled query.
     *
     *          For example, "enginee" is corrected to "engineer".
     *     @type string $orderBy
     *          Optional. The criteria that determines how search results are sorted.
     *          Defaults is "relevance desc" if no value is specified.
     *
     *          Supported options are:
     *
     *          * "relevance desc": By descending relevance, as determined by the API
     *             algorithms.
     *          * "update_date desc": Sort by
     *          [Profile.update_time][google.cloud.talent.v4beta1.Profile.update_time] in
     *          descending order
     *            (recently updated profiles first).
     *          * "create_date desc": Sort by
     *          [Profile.create_time][google.cloud.talent.v4beta1.Profile.create_time] in
     *          descending order
     *            (recently created profiles first).
     *          * "first_name": Sort by
     *          [PersonName.PersonStructuredName.given_name][google.cloud.talent.v4beta1.PersonName.PersonStructuredName.given_name]
     *          in
     *            ascending order.
     *          * "first_name desc": Sort by
     *          [PersonName.PersonStructuredName.given_name][google.cloud.talent.v4beta1.PersonName.PersonStructuredName.given_name]
     *            in descending order.
     *          * "last_name": Sort by
     *          [PersonName.PersonStructuredName.family_name][google.cloud.talent.v4beta1.PersonName.PersonStructuredName.family_name]
     *          in
     *            ascending order.
     *          * "last_name desc": Sort by
     *          [PersonName.PersonStructuredName.family_name][google.cloud.talent.v4beta1.PersonName.PersonStructuredName.family_name]
     *            in ascending order.
     *     @type bool $caseSensitiveSort
     *          Optional. When sort by field is based on alphabetical order, sort values
     *          case sensitively (based on ASCII) when the value is set to true. Default
     *          value is case in-sensitive sort (false).
     *     @type HistogramQuery[] $histogramQueries
     *          Optional. A list of expressions specifies histogram requests against
     *          matching profiles for
     *          [SearchProfilesRequest][google.cloud.talent.v4beta1.SearchProfilesRequest].
     *
     *          The expression syntax looks like a function definition with optional
     *          parameters.
     *
     *          Function syntax: function_name(histogram_facet[, list of buckets])
     *
     *          Data types:
     *
     *          * Histogram facet: facet names with format [a-zA-Z][a-zA-Z0-9_]+.
     *          * String: string like "any string with backslash escape for quote(\")."
     *          * Number: whole number and floating point number like 10, -1 and -0.01.
     *          * List: list of elements with comma(,) separator surrounded by square
     *          brackets. For example, [1, 2, 3] and ["one", "two", "three"].
     *
     *          Built-in constants:
     *
     *          * MIN (minimum number similar to java Double.MIN_VALUE)
     *          * MAX (maximum number similar to java Double.MAX_VALUE)
     *
     *          Built-in functions:
     *
     *          * bucket(start, end[, label])
     *          Bucket build-in function creates a bucket with range of [start, end). Note
     *          that the end is exclusive.
     *          For example, bucket(1, MAX, "positive number") or bucket(1, 10).
     *
     *          Histogram Facets:
     *
     *          * admin1: Admin1 is a global placeholder for referring to state, province,
     *          or the particular term a country uses to define the geographic structure
     *          below the country level. Examples include states codes such as "CA", "IL",
     *          "NY", and provinces, such as "BC".
     *          * locality: Locality is a global placeholder for referring to city, town,
     *          or the particular term a country uses to define the geographic structure
     *          below the admin1 level. Examples include city names such as
     *          "Mountain View" and "New York".
     *          * extended_locality: Extended locality is concatenated version of admin1
     *          and locality with comma separator. For example, "Mountain View, CA" and
     *          "New York, NY".
     *          * postal_code: Postal code of profile which follows locale code.
     *          * country: Country code (ISO-3166-1 alpha-2 code) of profile, such as US,
     *           JP, GB.
     *          * job_title: Normalized job titles specified in EmploymentHistory.
     *          * company_name: Normalized company name of profiles to match on.
     *          * institution: The school name. For example, "MIT",
     *          "University of California, Berkeley"
     *          * degree: Highest education degree in ISCED code. Each value in degree
     *          covers a specific level of education, without any expansion to upper nor
     *          lower levels of education degree.
     *          * experience_in_months: experience in months. 0 means 0 month to 1 month
     *          (exclusive).
     *          * application_date: The application date specifies application start dates.
     *          See
     *          [ApplicationDateFilter][google.cloud.talent.v4beta1.ApplicationDateFilter]
     *          for more details.
     *          * application_outcome_notes: The application outcome reason specifies the
     *          reasons behind the outcome of the job application.
     *          See
     *          [ApplicationOutcomeNotesFilter][google.cloud.talent.v4beta1.ApplicationOutcomeNotesFilter]
     *          for more details.
     *          * application_job_title: The application job title specifies the job
     *          applied for in the application.
     *          See
     *          [ApplicationJobFilter][google.cloud.talent.v4beta1.ApplicationJobFilter]
     *          for more details.
     *          * hirable_status: Hirable status specifies the profile's hirable status.
     *          * string_custom_attribute: String custom attributes. Values can be accessed
     *          via square bracket notation like string_custom_attribute["key1"].
     *          * numeric_custom_attribute: Numeric custom attributes. Values can be
     *          accessed via square bracket notation like numeric_custom_attribute["key1"].
     *
     *          Example expressions:
     *
     *          * count(admin1)
     *          * count(experience_in_months, [bucket(0, 12, "1 year"),
     *          bucket(12, 36, "1-3 years"), bucket(36, MAX, "3+ years")])
     *          * count(string_custom_attribute["assigned_recruiter"])
     *          * count(numeric_custom_attribute["favorite_number"],
     *          [bucket(MIN, 0, "negative"), bucket(0, MAX, "non-negative")])
     *     @type string $resultSetId
     *          Optional. An id that uniquely identifies the result set of a
     *          [SearchProfiles][google.cloud.talent.v4beta1.ProfileService.SearchProfiles]
     *          call. The id should be retrieved from the
     *          [SearchProfilesResponse][google.cloud.talent.v4beta1.SearchProfilesResponse]
     *          message returned from a previous invocation of
     *          [SearchProfiles][google.cloud.talent.v4beta1.ProfileService.SearchProfiles].
     *
     *          A result set is an ordered list of search results.
     *
     *          If this field is not set, a new result set is computed based on the
     *          [profile_query][google.cloud.talent.v4beta1.SearchProfilesRequest.profile_query].
     *          A new
     *          [result_set_id][google.cloud.talent.v4beta1.SearchProfilesRequest.result_set_id]
     *          is returned as a handle to access this result set.
     *
     *          If this field is set, the service will ignore the resource and
     *          [profile_query][google.cloud.talent.v4beta1.SearchProfilesRequest.profile_query]
     *          values, and simply retrieve a page of results from the corresponding result
     *          set.  In this case, one and only one of
     *          [page_token][google.cloud.talent.v4beta1.SearchProfilesRequest.page_token]
     *          or [offset][google.cloud.talent.v4beta1.SearchProfilesRequest.offset] must
     *          be set.
     *
     *          A typical use case is to invoke
     *          [SearchProfilesRequest][google.cloud.talent.v4beta1.SearchProfilesRequest]
     *          without this field, then use the resulting
     *          [result_set_id][google.cloud.talent.v4beta1.SearchProfilesRequest.result_set_id]
     *          in
     *          [SearchProfilesResponse][google.cloud.talent.v4beta1.SearchProfilesResponse]
     *          to page through the results.
     *     @type bool $strictKeywordsSearch
     *          Optional. This flag is used to indicate whether the service will attempt to
     *          understand synonyms and terms related to the search query or treat the
     *          query "as is" when it generates a set of results. By default this flag is
     *          set to false, thus allowing expanded results to also be returned. For
     *          example a search for "software engineer" might also return candidates who
     *          have experience in jobs similar to software engineer positions. By setting
     *          this flag to true, the service will only attempt to deliver candidates has
     *          software engineer in his/her global fields by treating "software engineer"
     *          as a keyword.
     *
     *          It is recommended to provide a feature in the UI (such as a checkbox) to
     *          allow recruiters to set this flag to true if they intend to search for
     *          longer boolean strings.
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
    public function searchProfiles($parent, $requestMetadata, array $optionalArgs = [])
    {
        $request = new SearchProfilesRequest();
        $request->setParent($parent);
        $request->setRequestMetadata($requestMetadata);
        if (isset($optionalArgs['profileQuery'])) {
            $request->setProfileQuery($optionalArgs['profileQuery']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['offset'])) {
            $request->setOffset($optionalArgs['offset']);
        }
        if (isset($optionalArgs['disableSpellCheck'])) {
            $request->setDisableSpellCheck($optionalArgs['disableSpellCheck']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }
        if (isset($optionalArgs['caseSensitiveSort'])) {
            $request->setCaseSensitiveSort($optionalArgs['caseSensitiveSort']);
        }
        if (isset($optionalArgs['histogramQueries'])) {
            $request->setHistogramQueries($optionalArgs['histogramQueries']);
        }
        if (isset($optionalArgs['resultSetId'])) {
            $request->setResultSetId($optionalArgs['resultSetId']);
        }
        if (isset($optionalArgs['strictKeywordsSearch'])) {
            $request->setStrictKeywordsSearch($optionalArgs['strictKeywordsSearch']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'SearchProfiles',
            $optionalArgs,
            SearchProfilesResponse::class,
            $request
        );
    }
}
