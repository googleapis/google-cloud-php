<?php
/*
 * Copyright 2017, Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
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
 * https://github.com/google/googleapis/blob/master/google/firestore/v1beta1/firestore_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Firestore\V1beta1;

use Google\Firestore\V1beta1\CreateIndexRequest;
use Google\Firestore\V1beta1\DeleteIndexRequest;
use Google\Firestore\V1beta1\FirestoreAdminGrpcClient;
use Google\Firestore\V1beta1\GetCollectionGroupRequest;
use Google\Firestore\V1beta1\GetDatabaseRequest;
use Google\Firestore\V1beta1\GetFieldRequest;
use Google\Firestore\V1beta1\GetIndexRequest;
use Google\Firestore\V1beta1\GetNamespaceRequest;
use Google\Firestore\V1beta1\Index;
use Google\Firestore\V1beta1\ListCollectionGroupsRequest;
use Google\Firestore\V1beta1\ListDatabasesRequest;
use Google\Firestore\V1beta1\ListFieldsRequest;
use Google\Firestore\V1beta1\ListIndexesRequest;
use Google\Firestore\V1beta1\ListNamespacesRequest;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;

/**
 * Service Description: The Cloud Firestore Admin API.
 *
 * This API provides several administrative services for Cloud Firestore.
 *
 * # Concepts
 *
 * Project, Database, Namespace, Collection, and Document are used as defined in
 * the Google Cloud Firestore API.
 *
 * Operation: An Operation represents work being performed in the background.
 *
 *
 * # Services
 *
 * ## Index
 *
 * The index service manages Cloud Firestore indexes.
 *
 * Index creation is performed asynchronously.
 * An Operation resource is created for each such asynchronous operation.
 * The state of the operation (including any errors encountered)
 * may be queried via the Operation resource.
 *
 * ## Metadata
 *
 * Provides metadata and statistical information about data in Cloud Firestore.
 * The data provided as part of this API may be stale.
 *
 * ## Operation
 *
 * The Operations collection provides a record of actions performed for the
 * specified Project (including any Operations in progress). Operations are not
 * created directly but through calls on other collections or resources.
 *
 * An Operation that is not yet done may be cancelled. The request to cancel is
 * asynchronous and the Operation may continue to run for some time after the
 * request to cancel is made.
 *
 * An Operation that is done may be deleted so that it is no longer listed as
 * part of the Operation collection.
 *
 * Operations are created by service `FirestoreAdmin`, but are accessed via
 * service `google.longrunning.Operations`.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $firestoreAdminClient = new FirestoreAdminClient();
 *     $formattedParent = FirestoreAdminClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
 *     $index = new Index();
 *     $response = $firestoreAdminClient->createIndex($formattedParent, $index);
 * } finally {
 *     $firestoreAdminClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 *
 * @experimental
 */
class FirestoreAdminGapicClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'firestore.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $databaseNameTemplate;
    private static $collectionGroupNameTemplate;
    private static $fieldNameTemplate;
    private static $indexNameTemplate;
    private static $namespaceNameTemplate;

    protected $grpcCredentialsHelper;
    protected $firestoreAdminStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function formatProjectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
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
    public static function formatDatabaseName($project, $database)
    {
        return self::getDatabaseNameTemplate()->render([
            'project' => $project,
            'database' => $database,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a collection_group resource.
     *
     * @param string $project
     * @param string $database
     * @param string $collectionGroup
     *
     * @return string The formatted collection_group resource.
     * @experimental
     */
    public static function formatCollectionGroupName($project, $database, $collectionGroup)
    {
        return self::getCollectionGroupNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'collection_group' => $collectionGroup,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a field resource.
     *
     * @param string $project
     * @param string $database
     * @param string $collectionGroup
     * @param string $field
     *
     * @return string The formatted field resource.
     * @experimental
     */
    public static function formatFieldName($project, $database, $collectionGroup, $field)
    {
        return self::getFieldNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'collection_group' => $collectionGroup,
            'field' => $field,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a index resource.
     *
     * @param string $project
     * @param string $database
     * @param string $index
     *
     * @return string The formatted index resource.
     * @experimental
     */
    public static function formatIndexName($project, $database, $index)
    {
        return self::getIndexNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'index' => $index,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a namespace resource.
     *
     * @param string $project
     * @param string $database
     * @param string $namespace
     *
     * @return string The formatted namespace resource.
     * @experimental
     */
    public static function formatNamespaceName($project, $database, $namespace)
    {
        return self::getNamespaceNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'namespace' => $namespace,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a project resource.
     *
     * @param string $projectName The fully-qualified project resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a database resource.
     *
     * @param string $databaseName The fully-qualified database resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['project'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a database resource.
     *
     * @param string $databaseName The fully-qualified database resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromDatabaseName($databaseName)
    {
        return self::getDatabaseNameTemplate()->match($databaseName)['database'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a collection_group resource.
     *
     * @param string $collectionGroupName The fully-qualified collection_group resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromCollectionGroupName($collectionGroupName)
    {
        return self::getCollectionGroupNameTemplate()->match($collectionGroupName)['project'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a collection_group resource.
     *
     * @param string $collectionGroupName The fully-qualified collection_group resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromCollectionGroupName($collectionGroupName)
    {
        return self::getCollectionGroupNameTemplate()->match($collectionGroupName)['database'];
    }

    /**
     * Parses the collection_group from the given fully-qualified path which
     * represents a collection_group resource.
     *
     * @param string $collectionGroupName The fully-qualified collection_group resource.
     *
     * @return string The extracted collection_group value.
     * @experimental
     */
    public static function parseCollectionGroupFromCollectionGroupName($collectionGroupName)
    {
        return self::getCollectionGroupNameTemplate()->match($collectionGroupName)['collection_group'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a field resource.
     *
     * @param string $fieldName The fully-qualified field resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromFieldName($fieldName)
    {
        return self::getFieldNameTemplate()->match($fieldName)['project'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a field resource.
     *
     * @param string $fieldName The fully-qualified field resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromFieldName($fieldName)
    {
        return self::getFieldNameTemplate()->match($fieldName)['database'];
    }

    /**
     * Parses the collection_group from the given fully-qualified path which
     * represents a field resource.
     *
     * @param string $fieldName The fully-qualified field resource.
     *
     * @return string The extracted collection_group value.
     * @experimental
     */
    public static function parseCollectionGroupFromFieldName($fieldName)
    {
        return self::getFieldNameTemplate()->match($fieldName)['collection_group'];
    }

    /**
     * Parses the field from the given fully-qualified path which
     * represents a field resource.
     *
     * @param string $fieldName The fully-qualified field resource.
     *
     * @return string The extracted field value.
     * @experimental
     */
    public static function parseFieldFromFieldName($fieldName)
    {
        return self::getFieldNameTemplate()->match($fieldName)['field'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a index resource.
     *
     * @param string $indexName The fully-qualified index resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromIndexName($indexName)
    {
        return self::getIndexNameTemplate()->match($indexName)['project'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a index resource.
     *
     * @param string $indexName The fully-qualified index resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromIndexName($indexName)
    {
        return self::getIndexNameTemplate()->match($indexName)['database'];
    }

    /**
     * Parses the index from the given fully-qualified path which
     * represents a index resource.
     *
     * @param string $indexName The fully-qualified index resource.
     *
     * @return string The extracted index value.
     * @experimental
     */
    public static function parseIndexFromIndexName($indexName)
    {
        return self::getIndexNameTemplate()->match($indexName)['index'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a namespace resource.
     *
     * @param string $namespaceName The fully-qualified namespace resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromNamespaceName($namespaceName)
    {
        return self::getNamespaceNameTemplate()->match($namespaceName)['project'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a namespace resource.
     *
     * @param string $namespaceName The fully-qualified namespace resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromNamespaceName($namespaceName)
    {
        return self::getNamespaceNameTemplate()->match($namespaceName)['database'];
    }

    /**
     * Parses the namespace from the given fully-qualified path which
     * represents a namespace resource.
     *
     * @param string $namespaceName The fully-qualified namespace resource.
     *
     * @return string The extracted namespace value.
     * @experimental
     */
    public static function parseNamespaceFromNamespaceName($namespaceName)
    {
        return self::getNamespaceNameTemplate()->match($namespaceName)['namespace'];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getDatabaseNameTemplate()
    {
        if (self::$databaseNameTemplate == null) {
            self::$databaseNameTemplate = new PathTemplate('projects/{project}/databases/{database}');
        }

        return self::$databaseNameTemplate;
    }

    private static function getCollectionGroupNameTemplate()
    {
        if (self::$collectionGroupNameTemplate == null) {
            self::$collectionGroupNameTemplate = new PathTemplate('projects/{project}/databases/{database}/collectionGroups/{collection_group}');
        }

        return self::$collectionGroupNameTemplate;
    }

    private static function getFieldNameTemplate()
    {
        if (self::$fieldNameTemplate == null) {
            self::$fieldNameTemplate = new PathTemplate('projects/{project}/databases/{database}/collectionGroups/{collection_group}/fields/{field}');
        }

        return self::$fieldNameTemplate;
    }

    private static function getIndexNameTemplate()
    {
        if (self::$indexNameTemplate == null) {
            self::$indexNameTemplate = new PathTemplate('projects/{project}/databases/{database}/indexes/{index}');
        }

        return self::$indexNameTemplate;
    }

    private static function getNamespaceNameTemplate()
    {
        if (self::$namespaceNameTemplate == null) {
            self::$namespaceNameTemplate = new PathTemplate('projects/{project}/databases/{database}/namespaces/{namespace}');
        }

        return self::$namespaceNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listIndexesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getIndexes',
                ]);
        $listDatabasesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDatabases',
                ]);
        $listNamespacesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getNamespaces',
                ]);
        $listCollectionGroupsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCollectionGroups',
                ]);
        $listFieldsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFields',
                ]);

        $pageStreamingDescriptors = [
            'listIndexes' => $listIndexesPageStreamingDescriptor,
            'listDatabases' => $listDatabasesPageStreamingDescriptor,
            'listNamespaces' => $listNamespacesPageStreamingDescriptor,
            'listCollectionGroups' => $listCollectionGroupsPageStreamingDescriptor,
            'listFields' => $listFieldsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getGapicVersion()
    {
        if (file_exists(__DIR__.'/../VERSION')) {
            return trim(file_get_contents(__DIR__.'/../VERSION'));
        } elseif (class_exists('\Google\Cloud\ServiceBuilder')) {
            return \Google\Cloud\ServiceBuilder::VERSION;
        } else {
            return;
        }
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'firestore.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\Channel $channel
     *           A `Channel` object to be used by gRPC. If not specified, a channel will be constructed.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: if the $channel optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Google Cloud Firestore API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/datastore',
            ],
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'createIndex' => $defaultDescriptors,
            'listIndexes' => $defaultDescriptors,
            'getIndex' => $defaultDescriptors,
            'deleteIndex' => $defaultDescriptors,
            'listDatabases' => $defaultDescriptors,
            'getDatabase' => $defaultDescriptors,
            'listNamespaces' => $defaultDescriptors,
            'getNamespace' => $defaultDescriptors,
            'listCollectionGroups' => $defaultDescriptors,
            'getCollectionGroup' => $defaultDescriptors,
            'listFields' => $defaultDescriptors,
            'getField' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/firestore_admin_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.firestore.v1beta1.FirestoreAdmin',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createFirestoreAdminStubFunction = function ($hostname, $opts, $channel) {
            return new FirestoreAdminGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createFirestoreAdminStubFunction', $options)) {
            $createFirestoreAdminStubFunction = $options['createFirestoreAdminStubFunction'];
        }
        $this->firestoreAdminStub = $this->grpcCredentialsHelper->createStub($createFirestoreAdminStubFunction);
    }

    /**
     * Creates the specified index.
     * A newly created index's initial state is `CREATING`. On completion of the
     * returned [google.longrunning.Operation][google.longrunning.Operation], the state will be `READY`.
     * If the index already exists, the call will return an `ALREADY_EXISTS`
     * status.
     *
     * During creation, the process could result in an error, in which case the
     * index will move to the `ERROR` state. The process can be recovered by
     * fixing the data that caused the error, removing the index with
     * [delete][google.firestore.v1beta1.FirestoreAdmin.DeleteIndex], then re-creating the index with
     * [create][google.firestore.v1beta1.FirestoreAdmin.CreateIndex].
     *
     * Indexes with a single field cannot be created.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedParent = FirestoreAdminClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $index = new Index();
     *     $response = $firestoreAdminClient->createIndex($formattedParent, $index);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The name of the database this index will apply to. For example:
     *                             `projects/{project_id}/databases/{database_id}`
     * @param Index  $index        The index to create. The name and state should not be specified.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Longrunning\Operation
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createIndex($parent, $index, $optionalArgs = [])
    {
        $request = new CreateIndexRequest();
        $request->setParent($parent);
        $request->setIndex($index);

        $mergedSettings = $this->defaultCallSettings['createIndex']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'CreateIndex',
            $mergedSettings,
            $this->descriptors['createIndex']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the indexes that match the specified filters.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedParent = FirestoreAdminClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $filter = "";
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreAdminClient->listIndexes($formattedParent, $filter);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreAdminClient->listIndexes($formattedParent, $filter, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The database name. For example:
     *                             `projects/{project_id}/databases/{database_id}`
     * @param string $filter
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listIndexes($parent, $filter, $optionalArgs = [])
    {
        $request = new ListIndexesRequest();
        $request->setParent($parent);
        $request->setFilter($filter);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listIndexes']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'ListIndexes',
            $mergedSettings,
            $this->descriptors['listIndexes']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets an index.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedName = FirestoreAdminClient::formatIndexName("[PROJECT]", "[DATABASE]", "[INDEX]");
     *     $response = $firestoreAdminClient->getIndex($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the index. For example:
     *                             `projects/{project_id}/databases/{database_id}/indexes/{index_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Index
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getIndex($name, $optionalArgs = [])
    {
        $request = new GetIndexRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getIndex']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'GetIndex',
            $mergedSettings,
            $this->descriptors['getIndex']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes an index.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedName = FirestoreAdminClient::formatIndexName("[PROJECT]", "[DATABASE]", "[INDEX]");
     *     $firestoreAdminClient->deleteIndex($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The index name. For example:
     *                             `projects/{project_id}/databases/{database_id}/indexes/{index_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function deleteIndex($name, $optionalArgs = [])
    {
        $request = new DeleteIndexRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['deleteIndex']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'DeleteIndex',
            $mergedSettings,
            $this->descriptors['deleteIndex']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists information about the databases of a project.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedParent = FirestoreAdminClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreAdminClient->listDatabases($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreAdminClient->listDatabases($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The project resource name. For example:
     *                             `projects/{project_id}`
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listDatabases($parent, $optionalArgs = [])
    {
        $request = new ListDatabasesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listDatabases']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'ListDatabases',
            $mergedSettings,
            $this->descriptors['listDatabases']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about a database.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedName = FirestoreAdminClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $response = $firestoreAdminClient->getDatabase($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The database resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Database
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getDatabase($name, $optionalArgs = [])
    {
        $request = new GetDatabaseRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getDatabase']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'GetDatabase',
            $mergedSettings,
            $this->descriptors['getDatabase']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists information about the namespaces of a database.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedParent = FirestoreAdminClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreAdminClient->listNamespaces($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreAdminClient->listNamespaces($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The database resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}`
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listNamespaces($parent, $optionalArgs = [])
    {
        $request = new ListNamespacesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listNamespaces']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'ListNamespaces',
            $mergedSettings,
            $this->descriptors['listNamespaces']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about a namespace.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedName = FirestoreAdminClient::formatNamespaceName("[PROJECT]", "[DATABASE]", "[NAMESPACE]");
     *     $response = $firestoreAdminClient->getNamespace($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The namespace resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}/namespaces/{namespace_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Namespace
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getNamespace($name, $optionalArgs = [])
    {
        $request = new GetNamespaceRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getNamespace']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'GetNamespace',
            $mergedSettings,
            $this->descriptors['getNamespace']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists information about the collection groups of a database.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedParent = FirestoreAdminClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreAdminClient->listCollectionGroups($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreAdminClient->listCollectionGroups($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The database resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}`
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listCollectionGroups($parent, $optionalArgs = [])
    {
        $request = new ListCollectionGroupsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listCollectionGroups']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'ListCollectionGroups',
            $mergedSettings,
            $this->descriptors['listCollectionGroups']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about a collection group.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedName = FirestoreAdminClient::formatCollectionGroupName("[PROJECT]", "[DATABASE]", "[COLLECTION_GROUP]");
     *     $response = $firestoreAdminClient->getCollectionGroup($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The collection group resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}/collectionGroup/{collection_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\CollectionGroup
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getCollectionGroup($name, $optionalArgs = [])
    {
        $request = new GetCollectionGroupRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getCollectionGroup']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'GetCollectionGroup',
            $mergedSettings,
            $this->descriptors['getCollectionGroup']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists information about the fields of a collection group.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedParent = FirestoreAdminClient::formatCollectionGroupName("[PROJECT]", "[DATABASE]", "[COLLECTION_GROUP]");
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreAdminClient->listFields($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreAdminClient->listFields($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The collection group resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}/collectionGroup/{collection_id}`
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listFields($parent, $optionalArgs = [])
    {
        $request = new ListFieldsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listFields']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'ListFields',
            $mergedSettings,
            $this->descriptors['listFields']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about a field.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreAdminClient = new FirestoreAdminClient();
     *     $formattedName = FirestoreAdminClient::formatFieldName("[PROJECT]", "[DATABASE]", "[COLLECTION_GROUP]", "[FIELD]");
     *     $response = $firestoreAdminClient->getField($formattedName);
     * } finally {
     *     $firestoreAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The field resource name. For example:
     *                             `projects/{project_id}/databases/{database_id}/collectionGroups/{collection_id}/fields/{field_id}`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Field
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getField($name, $optionalArgs = [])
    {
        $request = new GetFieldRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getField']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreAdminStub,
            'GetField',
            $mergedSettings,
            $this->descriptors['getField']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->firestoreAdminStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
