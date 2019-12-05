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
 * https://github.com/google/googleapis/blob/master/google/firestore/admin/v1/firestore_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Firestore\Admin\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Firestore\Admin\V1\CreateIndexRequest;
use Google\Cloud\Firestore\Admin\V1\DeleteIndexRequest;
use Google\Cloud\Firestore\Admin\V1\ExportDocumentsRequest;
use Google\Cloud\Firestore\Admin\V1\Field;
use Google\Cloud\Firestore\Admin\V1\GetFieldRequest;
use Google\Cloud\Firestore\Admin\V1\GetIndexRequest;
use Google\Cloud\Firestore\Admin\V1\ImportDocumentsRequest;
use Google\Cloud\Firestore\Admin\V1\Index;
use Google\Cloud\Firestore\Admin\V1\ListFieldsRequest;
use Google\Cloud\Firestore\Admin\V1\ListFieldsResponse;
use Google\Cloud\Firestore\Admin\V1\ListIndexesRequest;
use Google\Cloud\Firestore\Admin\V1\ListIndexesResponse;
use Google\Cloud\Firestore\Admin\V1\UpdateFieldRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Operations are created by service `FirestoreAdmin`, but are accessed via
 * service `google.longrunning.Operations`.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $firestoreAdminClient = new FirestoreAdminClient();
 * try {
 *     $formattedParent = $firestoreAdminClient->parentName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]');
 *     $index = new Index();
 *     $response = $firestoreAdminClient->createIndex($formattedParent, $index);
 * } finally {
 *     $firestoreAdminClient->close();
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
class FirestoreAdminGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.firestore.admin.v1.FirestoreAdmin';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'firestore.googleapis.com';

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
        'https://www.googleapis.com/auth/datastore',
    ];
    private static $databaseNameTemplate;
    private static $fieldNameTemplate;
    private static $indexNameTemplate;
    private static $parentNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/firestore_admin_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/firestore_admin_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/firestore_admin_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/firestore_admin_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getDatabaseNameTemplate()
    {
        if (null == self::$databaseNameTemplate) {
            self::$databaseNameTemplate = new PathTemplate('projects/{project}/databases/{database}');
        }

        return self::$databaseNameTemplate;
    }

    private static function getFieldNameTemplate()
    {
        if (null == self::$fieldNameTemplate) {
            self::$fieldNameTemplate = new PathTemplate('projects/{project}/databases/{database}/collectionGroups/{collection_id}/fields/{field_id}');
        }

        return self::$fieldNameTemplate;
    }

    private static function getIndexNameTemplate()
    {
        if (null == self::$indexNameTemplate) {
            self::$indexNameTemplate = new PathTemplate('projects/{project}/databases/{database}/collectionGroups/{collection_id}/indexes/{index_id}');
        }

        return self::$indexNameTemplate;
    }

    private static function getParentNameTemplate()
    {
        if (null == self::$parentNameTemplate) {
            self::$parentNameTemplate = new PathTemplate('projects/{project}/databases/{database}/collectionGroups/{collection_id}');
        }

        return self::$parentNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'database' => self::getDatabaseNameTemplate(),
                'field' => self::getFieldNameTemplate(),
                'index' => self::getIndexNameTemplate(),
                'parent' => self::getParentNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a database resource.
     *
     * @param string $project
     * @param string $database
     *
     * @return string The formatted database resource.
     * @experimental
     */
    public static function databaseName($project, $database)
    {
        return self::getDatabaseNameTemplate()->render([
            'project' => $project,
            'database' => $database,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a field resource.
     *
     * @param string $project
     * @param string $database
     * @param string $collectionId
     * @param string $fieldId
     *
     * @return string The formatted field resource.
     * @experimental
     */
    public static function fieldName($project, $database, $collectionId, $fieldId)
    {
        return self::getFieldNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'collection_id' => $collectionId,
            'field_id' => $fieldId,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a index resource.
     *
     * @param string $project
     * @param string $database
     * @param string $collectionId
     * @param string $indexId
     *
     * @return string The formatted index resource.
     * @experimental
     */
    public static function indexName($project, $database, $collectionId, $indexId)
    {
        return self::getIndexNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'collection_id' => $collectionId,
            'index_id' => $indexId,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a parent resource.
     *
     * @param string $project
     * @param string $database
     * @param string $collectionId
     *
     * @return string The formatted parent resource.
     * @experimental
     */
    public static function parentName($project, $database, $collectionId)
    {
        return self::getParentNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'collection_id' => $collectionId,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - database: projects/{project}/databases/{database}
     * - field: projects/{project}/databases/{database}/collectionGroups/{collection_id}/fields/{field_id}
     * - index: projects/{project}/databases/{database}/collectionGroups/{collection_id}/indexes/{index_id}
     * - parent: projects/{project}/databases/{database}/collectionGroups/{collection_id}.
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
     *           as "<uri>:<port>". Default 'firestore.googleapis.com:443'.
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
     * Creates a composite index. This returns a [google.longrunning.Operation][google.longrunning.Operation]
     * which may be used to track the status of the creation. The metadata for
     * the operation will be the type [IndexOperationMetadata][google.firestore.admin.v1.IndexOperationMetadata].
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedParent = $firestoreAdminClient->parentName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]');
     *     $index = new Index();
     *     $response = $firestoreAdminClient->createIndex($formattedParent, $index);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. A parent name of the form
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}`
     * @param Index  $index        Required. The composite index to create.
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
     * @return \Google\LongRunning\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createIndex($parent, $index, array $optionalArgs = [])
    {
        $request = new CreateIndexRequest();
        $request->setParent($parent);
        $request->setIndex($index);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateIndex',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists composite indexes.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedParent = $firestoreAdminClient->parentName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $firestoreAdminClient->listIndexes($formattedParent);
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
     *     $pagedResponse = $firestoreAdminClient->listIndexes($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. A parent name of the form
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          The filter to apply to list results.
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
    public function listIndexes($parent, array $optionalArgs = [])
    {
        $request = new ListIndexesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
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
            'ListIndexes',
            $optionalArgs,
            ListIndexesResponse::class,
            $request
        );
    }

    /**
     * Gets a composite index.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedName = $firestoreAdminClient->indexName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]', '[INDEX_ID]');
     *     $response = $firestoreAdminClient->getIndex($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. A name of the form
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}/indexes/{index_id}`
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
     * @return \Google\Cloud\Firestore\Admin\V1\Index
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIndex($name, array $optionalArgs = [])
    {
        $request = new GetIndexRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIndex',
            Index::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a composite index.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedName = $firestoreAdminClient->indexName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]', '[INDEX_ID]');
     *     $firestoreAdminClient->deleteIndex($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. A name of the form
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}/indexes/{index_id}`
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
    public function deleteIndex($name, array $optionalArgs = [])
    {
        $request = new DeleteIndexRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteIndex',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Imports documents into Google Cloud Firestore. Existing documents with the
     * same name are overwritten. The import occurs in the background and its
     * progress can be monitored and managed via the Operation resource that is
     * created. If an ImportDocuments operation is cancelled, it is possible
     * that a subset of the data has already been imported to Cloud Firestore.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedName = $firestoreAdminClient->databaseName('[PROJECT]', '[DATABASE]');
     *     $response = $firestoreAdminClient->importDocuments($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Database to import into. Should be of the form:
     *                             `projects/{project_id}/databases/{database_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string[] $collectionIds
     *          Which collection ids to import. Unspecified means all collections included
     *          in the import.
     *     @type string $inputUriPrefix
     *          Location of the exported files.
     *          This must match the output_uri_prefix of an ExportDocumentsResponse from
     *          an export that has completed successfully.
     *          See:
     *          [google.firestore.admin.v1.ExportDocumentsResponse.output_uri_prefix][google.firestore.admin.v1.ExportDocumentsResponse.output_uri_prefix].
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\LongRunning\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function importDocuments($name, array $optionalArgs = [])
    {
        $request = new ImportDocumentsRequest();
        $request->setName($name);
        if (isset($optionalArgs['collectionIds'])) {
            $request->setCollectionIds($optionalArgs['collectionIds']);
        }
        if (isset($optionalArgs['inputUriPrefix'])) {
            $request->setInputUriPrefix($optionalArgs['inputUriPrefix']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ImportDocuments',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Exports a copy of all or a subset of documents from Google Cloud Firestore
     * to another storage system, such as Google Cloud Storage. Recent updates to
     * documents may not be reflected in the export. The export occurs in the
     * background and its progress can be monitored and managed via the
     * Operation resource that is created. The output of an export may only be
     * used once the associated operation is done. If an export operation is
     * cancelled before completion it may leave partial data behind in Google
     * Cloud Storage.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedName = $firestoreAdminClient->databaseName('[PROJECT]', '[DATABASE]');
     *     $response = $firestoreAdminClient->exportDocuments($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Database to export. Should be of the form:
     *                             `projects/{project_id}/databases/{database_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string[] $collectionIds
     *          Which collection ids to export. Unspecified means all collections.
     *     @type string $outputUriPrefix
     *          The output URI. Currently only supports Google Cloud Storage URIs of the
     *          form: `gs://BUCKET_NAME[/NAMESPACE_PATH]`, where `BUCKET_NAME` is the name
     *          of the Google Cloud Storage bucket and `NAMESPACE_PATH` is an optional
     *          Google Cloud Storage namespace path. When
     *          choosing a name, be sure to consider Google Cloud Storage naming
     *          guidelines: https://cloud.google.com/storage/docs/naming.
     *          If the URI is a bucket (without a namespace path), a prefix will be
     *          generated based on the start time.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\LongRunning\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function exportDocuments($name, array $optionalArgs = [])
    {
        $request = new ExportDocumentsRequest();
        $request->setName($name);
        if (isset($optionalArgs['collectionIds'])) {
            $request->setCollectionIds($optionalArgs['collectionIds']);
        }
        if (isset($optionalArgs['outputUriPrefix'])) {
            $request->setOutputUriPrefix($optionalArgs['outputUriPrefix']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ExportDocuments',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the metadata and configuration for a Field.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedName = $firestoreAdminClient->fieldName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]', '[FIELD_ID]');
     *     $response = $firestoreAdminClient->getField($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. A name of the form
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}/fields/{field_id}`
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
     * @return \Google\Cloud\Firestore\Admin\V1\Field
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getField($name, array $optionalArgs = [])
    {
        $request = new GetFieldRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetField',
            Field::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the field configuration and metadata for this database.
     *
     * Currently, [FirestoreAdmin.ListFields][google.firestore.admin.v1.FirestoreAdmin.ListFields] only supports listing fields
     * that have been explicitly overridden. To issue this query, call
     * [FirestoreAdmin.ListFields][google.firestore.admin.v1.FirestoreAdmin.ListFields] with the filter set to
     * `indexConfig.usesAncestorConfig:false`.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $formattedParent = $firestoreAdminClient->parentName('[PROJECT]', '[DATABASE]', '[COLLECTION_ID]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $firestoreAdminClient->listFields($formattedParent);
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
     *     $pagedResponse = $firestoreAdminClient->listFields($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. A parent name of the form
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          The filter to apply to list results. Currently,
     *          [FirestoreAdmin.ListFields][google.firestore.admin.v1.FirestoreAdmin.ListFields] only supports listing fields
     *          that have been explicitly overridden. To issue this query, call
     *          [FirestoreAdmin.ListFields][google.firestore.admin.v1.FirestoreAdmin.ListFields] with the filter set to
     *          `indexConfig.usesAncestorConfig:false`.
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
    public function listFields($parent, array $optionalArgs = [])
    {
        $request = new ListFieldsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
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
            'ListFields',
            $optionalArgs,
            ListFieldsResponse::class,
            $request
        );
    }

    /**
     * Updates a field configuration. Currently, field updates apply only to
     * single field index configuration. However, calls to
     * [FirestoreAdmin.UpdateField][google.firestore.admin.v1.FirestoreAdmin.UpdateField] should provide a field mask to avoid
     * changing any configuration that the caller isn't aware of. The field mask
     * should be specified as: `{ paths: "index_config" }`.
     *
     * This call returns a [google.longrunning.Operation][google.longrunning.Operation] which may be used to
     * track the status of the field update. The metadata for
     * the operation will be the type [FieldOperationMetadata][google.firestore.admin.v1.FieldOperationMetadata].
     *
     * To configure the default field settings for the database, use
     * the special `Field` with resource name:
     * `projects/{project_id}/databases/{database_id}/collectionGroups/__default__/fields/*`.
     *
     * Sample code:
     * ```
     * $firestoreAdminClient = new FirestoreAdminClient();
     * try {
     *     $field = new Field();
     *     $response = $firestoreAdminClient->updateField($field);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param Field $field        Required. The field to be updated.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type FieldMask $updateMask
     *          A mask, relative to the field. If specified, only configuration specified
     *          by this field_mask will be updated in the field.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\LongRunning\Operation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateField($field, array $optionalArgs = [])
    {
        $request = new UpdateFieldRequest();
        $request->setField($field);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'field.name' => $request->getField()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateField',
            Operation::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
