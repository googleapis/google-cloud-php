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
 * https://github.com/google/googleapis/blob/master/google/cloud/datacatalog/v1/datacatalog.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\DataCatalog\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\DataCatalog\V1\CreateEntryGroupRequest;
use Google\Cloud\DataCatalog\V1\CreateEntryRequest;
use Google\Cloud\DataCatalog\V1\CreateTagRequest;
use Google\Cloud\DataCatalog\V1\CreateTagTemplateFieldRequest;
use Google\Cloud\DataCatalog\V1\CreateTagTemplateRequest;
use Google\Cloud\DataCatalog\V1\DeleteEntryGroupRequest;
use Google\Cloud\DataCatalog\V1\DeleteEntryRequest;
use Google\Cloud\DataCatalog\V1\DeleteTagRequest;
use Google\Cloud\DataCatalog\V1\DeleteTagTemplateFieldRequest;
use Google\Cloud\DataCatalog\V1\DeleteTagTemplateRequest;
use Google\Cloud\DataCatalog\V1\Entry;
use Google\Cloud\DataCatalog\V1\EntryGroup;
use Google\Cloud\DataCatalog\V1\GetEntryGroupRequest;
use Google\Cloud\DataCatalog\V1\GetEntryRequest;
use Google\Cloud\DataCatalog\V1\GetTagTemplateRequest;
use Google\Cloud\DataCatalog\V1\ListEntriesRequest;
use Google\Cloud\DataCatalog\V1\ListEntriesResponse;
use Google\Cloud\DataCatalog\V1\ListEntryGroupsRequest;
use Google\Cloud\DataCatalog\V1\ListEntryGroupsResponse;
use Google\Cloud\DataCatalog\V1\ListTagsRequest;
use Google\Cloud\DataCatalog\V1\ListTagsResponse;
use Google\Cloud\DataCatalog\V1\LookupEntryRequest;
use Google\Cloud\DataCatalog\V1\RenameTagTemplateFieldRequest;
use Google\Cloud\DataCatalog\V1\SearchCatalogRequest;
use Google\Cloud\DataCatalog\V1\SearchCatalogRequest\Scope;
use Google\Cloud\DataCatalog\V1\SearchCatalogResponse;
use Google\Cloud\DataCatalog\V1\Tag;
use Google\Cloud\DataCatalog\V1\TagTemplate;
use Google\Cloud\DataCatalog\V1\TagTemplateField;
use Google\Cloud\DataCatalog\V1\UpdateEntryGroupRequest;
use Google\Cloud\DataCatalog\V1\UpdateEntryRequest;
use Google\Cloud\DataCatalog\V1\UpdateTagRequest;
use Google\Cloud\DataCatalog\V1\UpdateTagTemplateFieldRequest;
use Google\Cloud\DataCatalog\V1\UpdateTagTemplateRequest;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\GetPolicyOptions;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Data Catalog API service allows clients to discover, understand, and manage
 * their data.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $dataCatalogClient = new DataCatalogClient();
 * try {
 *     $scope = new Scope();
 *     $query = '';
 *     // Iterate over pages of elements
 *     $pagedResponse = $dataCatalogClient->searchCatalog($scope, $query);
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
 *     $pagedResponse = $dataCatalogClient->searchCatalog($scope, $query);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $dataCatalogClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 */
class DataCatalogGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.datacatalog.v1.DataCatalog';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'datacatalog.googleapis.com';

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
    private static $entryNameTemplate;
    private static $entryGroupNameTemplate;
    private static $locationNameTemplate;
    private static $tagNameTemplate;
    private static $tagTemplateNameTemplate;
    private static $tagTemplateFieldNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/data_catalog_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/data_catalog_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/data_catalog_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/data_catalog_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getEntryNameTemplate()
    {
        if (null == self::$entryNameTemplate) {
            self::$entryNameTemplate = new PathTemplate('projects/{project}/locations/{location}/entryGroups/{entry_group}/entries/{entry}');
        }

        return self::$entryNameTemplate;
    }

    private static function getEntryGroupNameTemplate()
    {
        if (null == self::$entryGroupNameTemplate) {
            self::$entryGroupNameTemplate = new PathTemplate('projects/{project}/locations/{location}/entryGroups/{entry_group}');
        }

        return self::$entryGroupNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (null == self::$locationNameTemplate) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getTagNameTemplate()
    {
        if (null == self::$tagNameTemplate) {
            self::$tagNameTemplate = new PathTemplate('projects/{project}/locations/{location}/entryGroups/{entry_group}/entries/{entry}/tags/{tag}');
        }

        return self::$tagNameTemplate;
    }

    private static function getTagTemplateNameTemplate()
    {
        if (null == self::$tagTemplateNameTemplate) {
            self::$tagTemplateNameTemplate = new PathTemplate('projects/{project}/locations/{location}/tagTemplates/{tag_template}');
        }

        return self::$tagTemplateNameTemplate;
    }

    private static function getTagTemplateFieldNameTemplate()
    {
        if (null == self::$tagTemplateFieldNameTemplate) {
            self::$tagTemplateFieldNameTemplate = new PathTemplate('projects/{project}/locations/{location}/tagTemplates/{tag_template}/fields/{field}');
        }

        return self::$tagTemplateFieldNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'entry' => self::getEntryNameTemplate(),
                'entryGroup' => self::getEntryGroupNameTemplate(),
                'location' => self::getLocationNameTemplate(),
                'tag' => self::getTagNameTemplate(),
                'tagTemplate' => self::getTagTemplateNameTemplate(),
                'tagTemplateField' => self::getTagTemplateFieldNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a entry resource.
     *
     * @param string $project
     * @param string $location
     * @param string $entryGroup
     * @param string $entry
     *
     * @return string The formatted entry resource.
     */
    public static function entryName($project, $location, $entryGroup, $entry)
    {
        return self::getEntryNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'entry_group' => $entryGroup,
            'entry' => $entry,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a entry_group resource.
     *
     * @param string $project
     * @param string $location
     * @param string $entryGroup
     *
     * @return string The formatted entry_group resource.
     */
    public static function entryGroupName($project, $location, $entryGroup)
    {
        return self::getEntryGroupNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'entry_group' => $entryGroup,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location resource.
     *
     * @param string $project
     * @param string $location
     *
     * @return string The formatted location resource.
     */
    public static function locationName($project, $location)
    {
        return self::getLocationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a tag resource.
     *
     * @param string $project
     * @param string $location
     * @param string $entryGroup
     * @param string $entry
     * @param string $tag
     *
     * @return string The formatted tag resource.
     */
    public static function tagName($project, $location, $entryGroup, $entry, $tag)
    {
        return self::getTagNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'entry_group' => $entryGroup,
            'entry' => $entry,
            'tag' => $tag,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a tag_template resource.
     *
     * @param string $project
     * @param string $location
     * @param string $tagTemplate
     *
     * @return string The formatted tag_template resource.
     */
    public static function tagTemplateName($project, $location, $tagTemplate)
    {
        return self::getTagTemplateNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'tag_template' => $tagTemplate,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a tag_template_field resource.
     *
     * @param string $project
     * @param string $location
     * @param string $tagTemplate
     * @param string $field
     *
     * @return string The formatted tag_template_field resource.
     */
    public static function tagTemplateFieldName($project, $location, $tagTemplate, $field)
    {
        return self::getTagTemplateFieldNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'tag_template' => $tagTemplate,
            'field' => $field,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - entry: projects/{project}/locations/{location}/entryGroups/{entry_group}/entries/{entry}
     * - entryGroup: projects/{project}/locations/{location}/entryGroups/{entry_group}
     * - location: projects/{project}/locations/{location}
     * - tag: projects/{project}/locations/{location}/entryGroups/{entry_group}/entries/{entry}/tags/{tag}
     * - tagTemplate: projects/{project}/locations/{location}/tagTemplates/{tag_template}
     * - tagTemplateField: projects/{project}/locations/{location}/tagTemplates/{tag_template}/fields/{field}.
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
     *           as "<uri>:<port>". Default 'datacatalog.googleapis.com:443'.
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
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Searches Data Catalog for multiple resources like entries, tags that
     * match a query.
     *
     * This is a custom method
     * (https://cloud.google.com/apis/design/custom_methods) and does not return
     * the complete resource, only the resource identifier and high level
     * fields. Clients can subsequentally call `Get` methods.
     *
     * Note that Data Catalog search queries do not guarantee full recall. Query
     * results that match your query may not be returned, even in subsequent
     * result pages. Also note that results returned (and not returned) can vary
     * across repeated search queries.
     *
     * See [Data Catalog Search
     * Syntax](https://cloud.google.com/data-catalog/docs/how-to/search-reference)
     * for more information.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $scope = new Scope();
     *     $query = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $dataCatalogClient->searchCatalog($scope, $query);
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
     *     $pagedResponse = $dataCatalogClient->searchCatalog($scope, $query);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param Scope  $scope Required. The scope of this search request. A `scope` that has empty
     *                      `include_org_ids`, `include_project_ids` AND false
     *                      `include_gcp_public_datasets` is considered invalid. Data Catalog will
     *                      return an error in such a case.
     * @param string $query Required. The query string in search query syntax. The query must be
     *                      non-empty.
     *
     * Query strings can be simple as "x" or more qualified as:
     *
     * * name:x
     * * column:x
     * * description:y
     *
     * Note: Query tokens need to have a minimum of 3 characters for substring
     * matching to work correctly. See [Data Catalog Search
     * Syntax](https://cloud.google.com/data-catalog/docs/how-to/search-reference)
     * for more information.
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
     *     @type string $orderBy
     *          Specifies the ordering of results, currently supported case-sensitive
     *          choices are:
     *
     *            * `relevance`, only supports descending
     *            * `last_modified_timestamp [asc|desc]`, defaults to descending if not
     *              specified
     *
     *          If not specified, defaults to `relevance` descending.
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
     */
    public function searchCatalog($scope, $query, array $optionalArgs = [])
    {
        $request = new SearchCatalogRequest();
        $request->setScope($scope);
        $request->setQuery($query);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }

        return $this->getPagedListResponse(
            'SearchCatalog',
            $optionalArgs,
            SearchCatalogResponse::class,
            $request
        );
    }

    /**
     * Creates an EntryGroup.
     *
     * An entry group contains logically related entries together with Cloud
     * Identity and Access Management policies that specify the users who can
     * create, edit, and view entries within the entry group.
     *
     * Data Catalog automatically creates an entry group for BigQuery entries
     * ("&#64;bigquery") and Pub/Sub topics ("&#64;pubsub"). Users create their own entry
     * group to contain Cloud Storage fileset entries or custom type entries,
     * and the IAM policies associated with those entries. Entry groups, like
     * entries, can be searched.
     *
     * A maximum of 10,000 entry groups may be created per organization across all
     * locations.
     *
     * Users should enable the Data Catalog API in the project identified by
     * the `parent` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->locationName('[PROJECT]', '[LOCATION]');
     *     $entryGroupId = '';
     *     $response = $dataCatalogClient->createEntryGroup($formattedParent, $entryGroupId);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the project this entry group is in. Example:
     *
     * * projects/{project_id}/locations/{location}
     *
     * Note that this EntryGroup and its child resources may not actually be
     * stored in the location in this name.
     * @param string $entryGroupId Required. The id of the entry group to create.
     *                             The id must begin with a letter or underscore, contain only English
     *                             letters, numbers and underscores, and be at most 64 characters.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type EntryGroup $entryGroup
     *          The entry group to create. Defaults to an empty entry group.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\EntryGroup
     *
     * @throws ApiException if the remote call fails
     */
    public function createEntryGroup($parent, $entryGroupId, array $optionalArgs = [])
    {
        $request = new CreateEntryGroupRequest();
        $request->setParent($parent);
        $request->setEntryGroupId($entryGroupId);
        if (isset($optionalArgs['entryGroup'])) {
            $request->setEntryGroup($optionalArgs['entryGroup']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateEntryGroup',
            EntryGroup::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets an EntryGroup.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
     *     $response = $dataCatalogClient->getEntryGroup($formattedName);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entry group. For example,
     *                             `projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type FieldMask $readMask
     *          The fields to return. If not set or empty, all fields are returned.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\EntryGroup
     *
     * @throws ApiException if the remote call fails
     */
    public function getEntryGroup($name, array $optionalArgs = [])
    {
        $request = new GetEntryGroupRequest();
        $request->setName($name);
        if (isset($optionalArgs['readMask'])) {
            $request->setReadMask($optionalArgs['readMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetEntryGroup',
            EntryGroup::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an EntryGroup. The user should enable the Data Catalog API in the
     * project identified by the `entry_group.name` parameter (see [Data Catalog
     * Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $entryGroup = new EntryGroup();
     *     $response = $dataCatalogClient->updateEntryGroup($entryGroup);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param EntryGroup $entryGroup   Required. The updated entry group. "name" field must be set.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type FieldMask $updateMask
     *          The fields to update on the entry group. If absent or empty, all modifiable
     *          fields are updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\EntryGroup
     *
     * @throws ApiException if the remote call fails
     */
    public function updateEntryGroup($entryGroup, array $optionalArgs = [])
    {
        $request = new UpdateEntryGroupRequest();
        $request->setEntryGroup($entryGroup);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'entry_group.name' => $request->getEntryGroup()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateEntryGroup',
            EntryGroup::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an EntryGroup. Only entry groups that do not contain entries can be
     * deleted. Users should enable the Data Catalog API in the project
     * identified by the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
     *     $dataCatalogClient->deleteEntryGroup($formattedName);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entry group. For example,
     *                             `projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type bool $force
     *          Optional. If true, deletes all entries in the entry group.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     */
    public function deleteEntryGroup($name, array $optionalArgs = [])
    {
        $request = new DeleteEntryGroupRequest();
        $request->setName($name);
        if (isset($optionalArgs['force'])) {
            $request->setForce($optionalArgs['force']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteEntryGroup',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists entry groups.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $dataCatalogClient->listEntryGroups($formattedParent);
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
     *     $pagedResponse = $dataCatalogClient->listEntryGroups($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the location that contains the entry groups, which
     *                       can be provided in URL format. Example:
     *
     * * projects/{project_id}/locations/{location}
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
     */
    public function listEntryGroups($parent, array $optionalArgs = [])
    {
        $request = new ListEntryGroupsRequest();
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
            'ListEntryGroups',
            $optionalArgs,
            ListEntryGroupsResponse::class,
            $request
        );
    }

    /**
     * Creates an entry. Only entries of 'FILESET' type or user-specified type can
     * be created.
     *
     * Users should enable the Data Catalog API in the project identified by
     * the `parent` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * A maximum of 100,000 entries may be created per entry group.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
     *     $entryId = '';
     *     $entry = new Entry();
     *     $response = $dataCatalogClient->createEntry($formattedParent, $entryId, $entry);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the entry group this entry is in. Example:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}
     *
     * Note that this Entry and its child resources may not actually be stored in
     * the location in this name.
     * @param string $entryId      Required. The id of the entry to create.
     * @param Entry  $entry        Required. The entry to create.
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
     * @return \Google\Cloud\DataCatalog\V1\Entry
     *
     * @throws ApiException if the remote call fails
     */
    public function createEntry($parent, $entryId, $entry, array $optionalArgs = [])
    {
        $request = new CreateEntryRequest();
        $request->setParent($parent);
        $request->setEntryId($entryId);
        $request->setEntry($entry);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateEntry',
            Entry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing entry.
     * Users should enable the Data Catalog API in the project identified by
     * the `entry.name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $entry = new Entry();
     *     $response = $dataCatalogClient->updateEntry($entry);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param Entry $entry        Required. The updated entry. The "name" field must be set.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type FieldMask $updateMask
     *          The fields to update on the entry. If absent or empty, all modifiable
     *          fields are updated.
     *
     *          The following fields are modifiable:
     *          * For entries with type `DATA_STREAM`:
     *             * `schema`
     *          * For entries with type `FILESET`
     *             * `schema`
     *             * `display_name`
     *             * `description`
     *             * `gcs_fileset_spec`
     *             * `gcs_fileset_spec.file_patterns`
     *          * For entries with `user_specified_type`
     *             * `schema`
     *             * `display_name`
     *             * `description`
     *             * user_specified_type
     *             * user_specified_system
     *             * linked_resource
     *             * source_system_timestamps
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\Entry
     *
     * @throws ApiException if the remote call fails
     */
    public function updateEntry($entry, array $optionalArgs = [])
    {
        $request = new UpdateEntryRequest();
        $request->setEntry($entry);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'entry.name' => $request->getEntry()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateEntry',
            Entry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an existing entry. Only entries created through
     * [CreateEntry][google.cloud.datacatalog.v1.DataCatalog.CreateEntry]
     * method can be deleted.
     * Users should enable the Data Catalog API in the project identified by
     * the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->entryName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]', '[ENTRY]');
     *     $dataCatalogClient->deleteEntry($formattedName);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the entry. Example:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}/entries/{entry_id}
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
     */
    public function deleteEntry($name, array $optionalArgs = [])
    {
        $request = new DeleteEntryRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteEntry',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets an entry.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->entryName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]', '[ENTRY]');
     *     $response = $dataCatalogClient->getEntry($formattedName);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the entry. Example:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}/entries/{entry_id}
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
     * @return \Google\Cloud\DataCatalog\V1\Entry
     *
     * @throws ApiException if the remote call fails
     */
    public function getEntry($name, array $optionalArgs = [])
    {
        $request = new GetEntryRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetEntry',
            Entry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Get an entry by target resource name. This method allows clients to use
     * the resource name from the source Google Cloud Platform service to get the
     * Data Catalog Entry.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $response = $dataCatalogClient->lookupEntry();
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $linkedResource
     *          The full name of the Google Cloud Platform resource the Data Catalog
     *          entry represents. See:
     *          https://cloud.google.com/apis/design/resource_names#full_resource_name.
     *          Full names are case-sensitive.
     *
     *          Examples:
     *
     *           * //bigquery.googleapis.com/projects/projectId/datasets/datasetId/tables/tableId
     *           * //pubsub.googleapis.com/projects/projectId/topics/topicId
     *     @type string $sqlResource
     *          The SQL name of the entry. SQL names are case-sensitive.
     *
     *          Examples:
     *
     *            * `pubsub.project_id.topic_id`
     *            * ``pubsub.project_id.`topic.id.with.dots` ``
     *            * `bigquery.table.project_id.dataset_id.table_id`
     *            * `bigquery.dataset.project_id.dataset_id`
     *            * `datacatalog.entry.project_id.location_id.entry_group_id.entry_id`
     *
     *          `*_id`s shoud satisfy the standard SQL rules for identifiers.
     *          https://cloud.google.com/bigquery/docs/reference/standard-sql/lexical.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\Entry
     *
     * @throws ApiException if the remote call fails
     */
    public function lookupEntry(array $optionalArgs = [])
    {
        $request = new LookupEntryRequest();
        if (isset($optionalArgs['linkedResource'])) {
            $request->setLinkedResource($optionalArgs['linkedResource']);
        }
        if (isset($optionalArgs['sqlResource'])) {
            $request->setSqlResource($optionalArgs['sqlResource']);
        }

        return $this->startCall(
            'LookupEntry',
            Entry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists entries.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $dataCatalogClient->listEntries($formattedParent);
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
     *     $pagedResponse = $dataCatalogClient->listEntries($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the entry group that contains the entries, which can
     *                       be provided in URL format. Example:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}
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
     *     @type FieldMask $readMask
     *          The fields to return for each Entry. If not set or empty, all
     *          fields are returned.
     *          For example, setting read_mask to contain only one path "name" will cause
     *          ListEntries to return a list of Entries with only "name" field.
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
     */
    public function listEntries($parent, array $optionalArgs = [])
    {
        $request = new ListEntriesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
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
            'ListEntries',
            $optionalArgs,
            ListEntriesResponse::class,
            $request
        );
    }

    /**
     * Creates a tag template. The user should enable the Data Catalog API in
     * the project identified by the `parent` parameter (see [Data Catalog
     * Resource
     * Project](https://cloud.google.com/data-catalog/docs/concepts/resource-project)
     * for more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->locationName('[PROJECT]', '[LOCATION]');
     *     $tagTemplateId = '';
     *     $tagTemplate = new TagTemplate();
     *     $response = $dataCatalogClient->createTagTemplate($formattedParent, $tagTemplateId, $tagTemplate);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the project and the template location
     *                       [region](https://cloud.google.com/data-catalog/docs/concepts/regions).
     *
     * Example:
     *
     * * projects/{project_id}/locations/us-central1
     * @param string      $tagTemplateId Required. The id of the tag template to create.
     * @param TagTemplate $tagTemplate   Required. The tag template to create.
     * @param array       $optionalArgs  {
     *                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\TagTemplate
     *
     * @throws ApiException if the remote call fails
     */
    public function createTagTemplate($parent, $tagTemplateId, $tagTemplate, array $optionalArgs = [])
    {
        $request = new CreateTagTemplateRequest();
        $request->setParent($parent);
        $request->setTagTemplateId($tagTemplateId);
        $request->setTagTemplate($tagTemplate);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTagTemplate',
            TagTemplate::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a tag template.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->tagTemplateName('[PROJECT]', '[LOCATION]', '[TAG_TEMPLATE]');
     *     $response = $dataCatalogClient->getTagTemplate($formattedName);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the tag template. Example:
     *
     * * projects/{project_id}/locations/{location}/tagTemplates/{tag_template_id}
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
     * @return \Google\Cloud\DataCatalog\V1\TagTemplate
     *
     * @throws ApiException if the remote call fails
     */
    public function getTagTemplate($name, array $optionalArgs = [])
    {
        $request = new GetTagTemplateRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetTagTemplate',
            TagTemplate::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a tag template. This method cannot be used to update the fields of
     * a template. The tag template fields are represented as separate resources
     * and should be updated using their own create/update/delete methods.
     * Users should enable the Data Catalog API in the project identified by
     * the `tag_template.name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $tagTemplate = new TagTemplate();
     *     $response = $dataCatalogClient->updateTagTemplate($tagTemplate);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param TagTemplate $tagTemplate  Required. The template to update. The "name" field must be set.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type FieldMask $updateMask
     *          The field mask specifies the parts of the template to overwrite.
     *
     *          Allowed fields:
     *
     *            * `display_name`
     *
     *          If absent or empty, all of the allowed fields above will be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\TagTemplate
     *
     * @throws ApiException if the remote call fails
     */
    public function updateTagTemplate($tagTemplate, array $optionalArgs = [])
    {
        $request = new UpdateTagTemplateRequest();
        $request->setTagTemplate($tagTemplate);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'tag_template.name' => $request->getTagTemplate()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateTagTemplate',
            TagTemplate::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a tag template and all tags using the template.
     * Users should enable the Data Catalog API in the project identified by
     * the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->tagTemplateName('[PROJECT]', '[LOCATION]', '[TAG_TEMPLATE]');
     *     $force = false;
     *     $dataCatalogClient->deleteTagTemplate($formattedName, $force);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the tag template to delete. Example:
     *
     * * projects/{project_id}/locations/{location}/tagTemplates/{tag_template_id}
     * @param bool  $force        Required. Currently, this field must always be set to `true`.
     *                            This confirms the deletion of any possible tags using this template.
     *                            `force = false` will be supported in the future.
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
     */
    public function deleteTagTemplate($name, $force, array $optionalArgs = [])
    {
        $request = new DeleteTagTemplateRequest();
        $request->setName($name);
        $request->setForce($force);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteTagTemplate',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a field in a tag template. The user should enable the Data Catalog
     * API in the project identified by the `parent` parameter (see
     * [Data Catalog Resource
     * Project](https://cloud.google.com/data-catalog/docs/concepts/resource-project)
     * for more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->tagTemplateName('[PROJECT]', '[LOCATION]', '[TAG_TEMPLATE]');
     *     $tagTemplateFieldId = '';
     *     $tagTemplateField = new TagTemplateField();
     *     $response = $dataCatalogClient->createTagTemplateField($formattedParent, $tagTemplateFieldId, $tagTemplateField);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the project and the template location
     *                       [region](https://cloud.google.com/data-catalog/docs/concepts/regions).
     *
     * Example:
     *
     * * projects/{project_id}/locations/us-central1/tagTemplates/{tag_template_id}
     * @param string           $tagTemplateFieldId Required. The ID of the tag template field to create.
     *                                             Field ids can contain letters (both uppercase and lowercase), numbers
     *                                             (0-9), underscores (_) and dashes (-). Field IDs must be at least 1
     *                                             character long and at most 128 characters long. Field IDs must also be
     *                                             unique within their template.
     * @param TagTemplateField $tagTemplateField   Required. The tag template field to create.
     * @param array            $optionalArgs       {
     *                                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\TagTemplateField
     *
     * @throws ApiException if the remote call fails
     */
    public function createTagTemplateField($parent, $tagTemplateFieldId, $tagTemplateField, array $optionalArgs = [])
    {
        $request = new CreateTagTemplateFieldRequest();
        $request->setParent($parent);
        $request->setTagTemplateFieldId($tagTemplateFieldId);
        $request->setTagTemplateField($tagTemplateField);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTagTemplateField',
            TagTemplateField::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a field in a tag template. This method cannot be used to update the
     * field type. Users should enable the Data Catalog API in the project
     * identified by the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->tagTemplateFieldName('[PROJECT]', '[LOCATION]', '[TAG_TEMPLATE]', '[FIELD]');
     *     $tagTemplateField = new TagTemplateField();
     *     $response = $dataCatalogClient->updateTagTemplateField($formattedName, $tagTemplateField);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the tag template field. Example:
     *
     * * projects/{project_id}/locations/{location}/tagTemplates/{tag_template_id}/fields/{tag_template_field_id}
     * @param TagTemplateField $tagTemplateField Required. The template to update.
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type FieldMask $updateMask
     *          Optional. The field mask specifies the parts of the template to be updated.
     *          Allowed fields:
     *
     *            * `display_name`
     *            * `type.enum_type`
     *            * `is_required`
     *
     *          If `update_mask` is not set or empty, all of the allowed fields above will
     *          be updated.
     *
     *          When updating an enum type, the provided values will be merged with the
     *          existing values. Therefore, enum values can only be added, existing enum
     *          values cannot be deleted nor renamed. Updating a template field from
     *          optional to required is NOT allowed.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\TagTemplateField
     *
     * @throws ApiException if the remote call fails
     */
    public function updateTagTemplateField($name, $tagTemplateField, array $optionalArgs = [])
    {
        $request = new UpdateTagTemplateFieldRequest();
        $request->setName($name);
        $request->setTagTemplateField($tagTemplateField);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateTagTemplateField',
            TagTemplateField::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Renames a field in a tag template. The user should enable the Data Catalog
     * API in the project identified by the `name` parameter (see [Data Catalog
     * Resource
     * Project](https://cloud.google.com/data-catalog/docs/concepts/resource-project)
     * for more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->tagTemplateFieldName('[PROJECT]', '[LOCATION]', '[TAG_TEMPLATE]', '[FIELD]');
     *     $newTagTemplateFieldId = '';
     *     $response = $dataCatalogClient->renameTagTemplateField($formattedName, $newTagTemplateFieldId);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the tag template. Example:
     *
     * * projects/{project_id}/locations/{location}/tagTemplates/{tag_template_id}/fields/{tag_template_field_id}
     * @param string $newTagTemplateFieldId Required. The new ID of this tag template field. For example,
     *                                      `my_new_field`.
     * @param array  $optionalArgs          {
     *                                      Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\TagTemplateField
     *
     * @throws ApiException if the remote call fails
     */
    public function renameTagTemplateField($name, $newTagTemplateFieldId, array $optionalArgs = [])
    {
        $request = new RenameTagTemplateFieldRequest();
        $request->setName($name);
        $request->setNewTagTemplateFieldId($newTagTemplateFieldId);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RenameTagTemplateField',
            TagTemplateField::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a field in a tag template and all uses of that field.
     * Users should enable the Data Catalog API in the project identified by
     * the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->tagTemplateFieldName('[PROJECT]', '[LOCATION]', '[TAG_TEMPLATE]', '[FIELD]');
     *     $force = false;
     *     $dataCatalogClient->deleteTagTemplateField($formattedName, $force);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the tag template field to delete. Example:
     *
     * * projects/{project_id}/locations/{location}/tagTemplates/{tag_template_id}/fields/{tag_template_field_id}
     * @param bool  $force        Required. Currently, this field must always be set to `true`.
     *                            This confirms the deletion of this field from any tags using this field.
     *                            `force = false` will be supported in the future.
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
     */
    public function deleteTagTemplateField($name, $force, array $optionalArgs = [])
    {
        $request = new DeleteTagTemplateFieldRequest();
        $request->setName($name);
        $request->setForce($force);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteTagTemplateField',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a tag on an [Entry][google.cloud.datacatalog.v1.Entry].
     * Note: The project identified by the `parent` parameter for the
     * [tag](https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.entryGroups.entries.tags/create#path-parameters)
     * and the
     * [tag
     * template](https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.tagTemplates/create#path-parameters)
     * used to create the tag must be from the same organization.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->tagName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]', '[ENTRY]', '[TAG]');
     *     $tag = new Tag();
     *     $response = $dataCatalogClient->createTag($formattedParent, $tag);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the resource to attach this tag to. Tags can be
     *                       attached to Entries. Example:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}/entries/{entry_id}
     *
     * Note that this Tag and its child resources may not actually be stored in
     * the location in this name.
     * @param Tag   $tag          Required. The tag to create.
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
     * @return \Google\Cloud\DataCatalog\V1\Tag
     *
     * @throws ApiException if the remote call fails
     */
    public function createTag($parent, $tag, array $optionalArgs = [])
    {
        $request = new CreateTagRequest();
        $request->setParent($parent);
        $request->setTag($tag);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTag',
            Tag::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing tag.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $tag = new Tag();
     *     $response = $dataCatalogClient->updateTag($tag);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param Tag   $tag          Required. The updated tag. The "name" field must be set.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type FieldMask $updateMask
     *          The fields to update on the Tag. If absent or empty, all modifiable fields
     *          are updated. Currently the only modifiable field is the field `fields`.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\DataCatalog\V1\Tag
     *
     * @throws ApiException if the remote call fails
     */
    public function updateTag($tag, array $optionalArgs = [])
    {
        $request = new UpdateTagRequest();
        $request->setTag($tag);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'tag.name' => $request->getTag()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateTag',
            Tag::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a tag.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedName = $dataCatalogClient->entryName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]', '[ENTRY]');
     *     $dataCatalogClient->deleteTag($formattedName);
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $name Required. The name of the tag to delete. Example:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}/entries/{entry_id}/tags/{tag_id}
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
     */
    public function deleteTag($name, array $optionalArgs = [])
    {
        $request = new DeleteTagRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteTag',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the tags on an [Entry][google.cloud.datacatalog.v1.Entry].
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $formattedParent = $dataCatalogClient->entryName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]', '[ENTRY]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $dataCatalogClient->listTags($formattedParent);
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
     *     $pagedResponse = $dataCatalogClient->listTags($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $dataCatalogClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the Data Catalog resource to list the tags of. The
     *                       resource could be an [Entry][google.cloud.datacatalog.v1.Entry] or an
     *                       [EntryGroup][google.cloud.datacatalog.v1.EntryGroup].
     *
     * Examples:
     *
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}
     * * projects/{project_id}/locations/{location}/entryGroups/{entry_group_id}/entries/{entry_id}
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
     */
    public function listTags($parent, array $optionalArgs = [])
    {
        $request = new ListTagsRequest();
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
            'ListTags',
            $optionalArgs,
            ListTagsResponse::class,
            $request
        );
    }

    /**
     * Sets the access control policy for a resource. Replaces any existing
     * policy.
     * Supported resources are:
     *   - Tag templates.
     *   - Entries.
     *   - Entry groups.
     * Note, this method cannot be used to manage policies for BigQuery, Pub/Sub
     * and any external Google Cloud Platform resources synced to Data Catalog.
     *
     * Callers must have following Google IAM permission
     *   - `datacatalog.tagTemplates.setIamPolicy` to set policies on tag
     *     templates.
     *   - `datacatalog.entries.setIamPolicy` to set policies on entries.
     *   - `datacatalog.entryGroups.setIamPolicy` to set policies on entry groups.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $resource = '';
     *     $policy = new Policy();
     *     $response = $dataCatalogClient->setIamPolicy($resource, $policy);
     * } finally {
     *     $dataCatalogClient->close();
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
     * Gets the access control policy for a resource. A `NOT_FOUND` error
     * is returned if the resource does not exist. An empty policy is returned
     * if the resource exists but does not have a policy set on it.
     *
     * Supported resources are:
     *   - Tag templates.
     *   - Entries.
     *   - Entry groups.
     * Note, this method cannot be used to manage policies for BigQuery, Pub/Sub
     * and any external Google Cloud Platform resources synced to Data Catalog.
     *
     * Callers must have following Google IAM permission
     *   - `datacatalog.tagTemplates.getIamPolicy` to get policies on tag
     *     templates.
     *   - `datacatalog.entries.getIamPolicy` to get policies on entries.
     *   - `datacatalog.entryGroups.getIamPolicy` to get policies on entry groups.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $resource = '';
     *     $response = $dataCatalogClient->getIamPolicy($resource);
     * } finally {
     *     $dataCatalogClient->close();
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
     * Returns the caller's permissions on a resource.
     * If the resource does not exist, an empty set of permissions is returned
     * (We don't return a `NOT_FOUND` error).
     *
     * Supported resources are:
     *   - Tag templates.
     *   - Entries.
     *   - Entry groups.
     * Note, this method cannot be used to manage policies for BigQuery, Pub/Sub
     * and any external Google Cloud Platform resources synced to Data Catalog.
     *
     * A caller is not required to have Google IAM permission to make this
     * request.
     *
     * Sample code:
     * ```
     * $dataCatalogClient = new DataCatalogClient();
     * try {
     *     $resource = '';
     *     $permissions = [];
     *     $response = $dataCatalogClient->testIamPermissions($resource, $permissions);
     * } finally {
     *     $dataCatalogClient->close();
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
}
