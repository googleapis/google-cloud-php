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
 * https://github.com/google/googleapis/blob/master/google/firestore/v1beta1/firestore.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Firestore\V1beta1;

use Google\Firestore\V1beta1\BatchGetDocumentsRequest;
use Google\Firestore\V1beta1\BeginTransactionRequest;
use Google\Firestore\V1beta1\CommitRequest;
use Google\Firestore\V1beta1\CreateDocumentRequest;
use Google\Firestore\V1beta1\DeleteDocumentRequest;
use Google\Firestore\V1beta1\Document;
use Google\Firestore\V1beta1\DocumentMask;
use Google\Firestore\V1beta1\FirestoreGrpcClient;
use Google\Firestore\V1beta1\GetDocumentRequest;
use Google\Firestore\V1beta1\ListCollectionIdsRequest;
use Google\Firestore\V1beta1\ListDocumentsRequest;
use Google\Firestore\V1beta1\ListenRequest;
use Google\Firestore\V1beta1\Precondition;
use Google\Firestore\V1beta1\RollbackRequest;
use Google\Firestore\V1beta1\RunQueryRequest;
use Google\Firestore\V1beta1\StructuredQuery;
use Google\Firestore\V1beta1\Target;
use Google\Firestore\V1beta1\TransactionOptions;
use Google\Firestore\V1beta1\UpdateDocumentRequest;
use Google\Firestore\V1beta1\Write;
use Google\Firestore\V1beta1\WriteRequest;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\Protobuf\Timestamp;

/**
 * Service Description: The Cloud Firestore service.
 *
 * This service exposes several types of comparable timestamps:
 *
 * *    `create_time` - The time at which a document was created. Changes only
 *      when a document is deleted, then re-created. Increases in a strict
 *       monotonic fashion.
 * *    `update_time` - The time at which a document was last updated. Changes
 *      every time a document is modified. Does not change when a write results
 *      in no modifications. Increases in a strict monotonic fashion.
 * *    `read_time` - The time at which a particular state was observed. Used
 *      to denote a consistent snapshot of the database or the time at which a
 *      Document was observed to not exist.
 * *    `commit_time` - The time at which the writes in a transaction were
 *      committed. Any read with an equal or greater `read_time` is guaranteed
 *      to see the effects of the transaction.
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
 *     $firestoreClient = new FirestoreClient();
 *     $formattedName = FirestoreClient::formatDocumentPathName("[PROJECT]", "[DATABASE]", "[DOCUMENT]", "[DOCUMENT_PATH]");
 *     $response = $firestoreClient->getDocument($formattedName);
 * } finally {
 *     $firestoreClient->close();
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
class FirestoreGapicClient
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

    private static $databaseNameTemplate;
    private static $documentPathNameTemplate;

    protected $grpcCredentialsHelper;
    protected $firestoreStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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
     * a document_path resource.
     *
     * @param string $project
     * @param string $database
     * @param string $document
     * @param string $documentPath
     *
     * @return string The formatted document_path resource.
     * @experimental
     */
    public static function formatDocumentPathName($project, $database, $document, $documentPath)
    {
        return self::getDocumentPathNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'document' => $document,
            'document_path' => $documentPath,
        ]);
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
     * represents a document_path resource.
     *
     * @param string $documentPathName The fully-qualified document_path resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromDocumentPathName($documentPathName)
    {
        return self::getDocumentPathNameTemplate()->match($documentPathName)['project'];
    }

    /**
     * Parses the database from the given fully-qualified path which
     * represents a document_path resource.
     *
     * @param string $documentPathName The fully-qualified document_path resource.
     *
     * @return string The extracted database value.
     * @experimental
     */
    public static function parseDatabaseFromDocumentPathName($documentPathName)
    {
        return self::getDocumentPathNameTemplate()->match($documentPathName)['database'];
    }

    /**
     * Parses the document from the given fully-qualified path which
     * represents a document_path resource.
     *
     * @param string $documentPathName The fully-qualified document_path resource.
     *
     * @return string The extracted document value.
     * @experimental
     */
    public static function parseDocumentFromDocumentPathName($documentPathName)
    {
        return self::getDocumentPathNameTemplate()->match($documentPathName)['document'];
    }

    /**
     * Parses the document_path from the given fully-qualified path which
     * represents a document_path resource.
     *
     * @param string $documentPathName The fully-qualified document_path resource.
     *
     * @return string The extracted document_path value.
     * @experimental
     */
    public static function parseDocumentPathFromDocumentPathName($documentPathName)
    {
        return self::getDocumentPathNameTemplate()->match($documentPathName)['document_path'];
    }

    private static function getDatabaseNameTemplate()
    {
        if (self::$databaseNameTemplate == null) {
            self::$databaseNameTemplate = new PathTemplate('projects/{project}/databases/{database}');
        }

        return self::$databaseNameTemplate;
    }

    private static function getDocumentPathNameTemplate()
    {
        if (self::$documentPathNameTemplate == null) {
            self::$documentPathNameTemplate = new PathTemplate('projects/{project}/databases/{database}/documents/{document}/{document_path=**}');
        }

        return self::$documentPathNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listDocumentsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDocuments',
                ]);
        $listCollectionIdsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCollectionIds',
                ]);

        $pageStreamingDescriptors = [
            'listDocuments' => $listDocumentsPageStreamingDescriptor,
            'listCollectionIds' => $listCollectionIdsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getGrpcStreamingDescriptors()
    {
        return [
            'batchGetDocuments' => [
                'grpcStreamingType' => 'ServerStreaming',
            ],
            'runQuery' => [
                'grpcStreamingType' => 'ServerStreaming',
            ],
            'write' => [
                'grpcStreamingType' => 'BidiStreaming',
            ],
            'listen' => [
                'grpcStreamingType' => 'BidiStreaming',
            ],
        ];
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
            'getDocument' => $defaultDescriptors,
            'listDocuments' => $defaultDescriptors,
            'createDocument' => $defaultDescriptors,
            'updateDocument' => $defaultDescriptors,
            'deleteDocument' => $defaultDescriptors,
            'batchGetDocuments' => $defaultDescriptors,
            'beginTransaction' => $defaultDescriptors,
            'commit' => $defaultDescriptors,
            'rollback' => $defaultDescriptors,
            'runQuery' => $defaultDescriptors,
            'write' => $defaultDescriptors,
            'listen' => $defaultDescriptors,
            'listCollectionIds' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }
        $grpcStreamingDescriptors = self::getGrpcStreamingDescriptors();
        foreach ($grpcStreamingDescriptors as $method => $grpcStreamingDescriptor) {
            $this->descriptors[$method]['grpcStreamingDescriptor'] = $grpcStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/firestore_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.firestore.v1beta1.Firestore',
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

        $createFirestoreStubFunction = function ($hostname, $opts, $channel) {
            return new FirestoreGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createFirestoreStubFunction', $options)) {
            $createFirestoreStubFunction = $options['createFirestoreStubFunction'];
        }
        $this->firestoreStub = $this->grpcCredentialsHelper->createStub($createFirestoreStubFunction);
    }

    /**
     * Gets a single document.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedName = FirestoreClient::formatDocumentPathName("[PROJECT]", "[DATABASE]", "[DOCUMENT]", "[DOCUMENT_PATH]");
     *     $response = $firestoreClient->getDocument($formattedName);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $name         The resource name of the Document to get. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type DocumentMask $mask
     *          The fields to return. If not set, returns all fields.
     *
     *          If the document has a field that is not present in this mask, that field
     *          will not be returned in the response.
     *     @type string $transaction
     *          Reads the document in a transaction.
     *     @type Timestamp $readTime
     *          Reads the version of the document at the given time.
     *          This may not be older than 60 seconds.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Document
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getDocument($name, $optionalArgs = [])
    {
        $request = new GetDocumentRequest();
        $request->setName($name);
        if (isset($optionalArgs['mask'])) {
            $request->setMask($optionalArgs['mask']);
        }
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }

        $mergedSettings = $this->defaultCallSettings['getDocument']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'GetDocument',
            $mergedSettings,
            $this->descriptors['getDocument']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists documents.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedParent = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $collectionId = "";
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreClient->listDocuments($formattedParent, $collectionId);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreClient->listDocuments($formattedParent, $collectionId, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent resource name. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents` or
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     *                             For example:
     *                             `projects/my-project/databases/my-database/documents` or
     *                             `projects/my-project/databases/my-database/documents/chatrooms/my-chatroom`
     * @param string $collectionId The collection ID, relative to `parent`, to list. For example: `chatrooms`
     *                             or `messages`.
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
     *     @type string $orderBy
     *          The order to sort results by. For example: `priority desc, name`.
     *     @type DocumentMask $mask
     *          The fields to return. If not set, returns all fields.
     *
     *          If a document has a field that is not present in this mask, that field
     *          will not be returned in the response.
     *     @type string $transaction
     *          Reads documents in a transaction.
     *     @type Timestamp $readTime
     *          Reads documents as they were at the given time.
     *          This may not be older than 60 seconds.
     *     @type bool $showMissing
     *          If the list should show missing documents. A missing document is a
     *          document that does not exist but has sub-documents. These documents will
     *          be returned with a key but will not have fields, [Document.create_time][google.firestore.v1beta1.Document.create_time],
     *          or [Document.update_time][google.firestore.v1beta1.Document.update_time] set.
     *
     *          Requests with `show_missing` may not specify `where` or
     *          `order_by`.
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
    public function listDocuments($parent, $collectionId, $optionalArgs = [])
    {
        $request = new ListDocumentsRequest();
        $request->setParent($parent);
        $request->setCollectionId($collectionId);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }
        if (isset($optionalArgs['mask'])) {
            $request->setMask($optionalArgs['mask']);
        }
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }
        if (isset($optionalArgs['showMissing'])) {
            $request->setShowMissing($optionalArgs['showMissing']);
        }

        $mergedSettings = $this->defaultCallSettings['listDocuments']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'ListDocuments',
            $mergedSettings,
            $this->descriptors['listDocuments']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a new document.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedParent = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $collectionId = "";
     *     $document = new Document();
     *     $response = $firestoreClient->createDocument($formattedParent, $collectionId, $document);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string   $parent       The parent resource. For example:
     *                               `projects/{project_id}/databases/{database_id}/documents` or
     *                               `projects/{project_id}/databases/{database_id}/documents/chatrooms/{chatroom_id}`
     * @param string   $collectionId The collection ID, relative to `parent`, to list. For example: `chatrooms`.
     * @param Document $document     The document to create. `name` must not be set.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $documentId
     *          The client-assigned document ID to use for this document.
     *
     *          Optional. If not specified, an ID will be assigned by the service.
     *     @type DocumentMask $mask
     *          The fields to return. If not set, returns all fields.
     *
     *          If the document has a field that is not present in this mask, that field
     *          will not be returned in the response.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Document
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createDocument($parent, $collectionId, $document, $optionalArgs = [])
    {
        $request = new CreateDocumentRequest();
        $request->setParent($parent);
        $request->setCollectionId($collectionId);
        $request->setDocument($document);
        if (isset($optionalArgs['documentId'])) {
            $request->setDocumentId($optionalArgs['documentId']);
        }
        if (isset($optionalArgs['mask'])) {
            $request->setMask($optionalArgs['mask']);
        }

        $mergedSettings = $this->defaultCallSettings['createDocument']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'CreateDocument',
            $mergedSettings,
            $this->descriptors['createDocument']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates or inserts a document.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $document = new Document();
     *     $updateMask = new DocumentMask();
     *     $response = $firestoreClient->updateDocument($document, $updateMask);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param Document     $document   The updated document.
     *                                 Creates the document if it does not already exist.
     * @param DocumentMask $updateMask The fields to update.
     *                                 None of the field paths in the mask may contain a reserved name.
     *
     * If the document exists on the server and has fields not referenced in the
     * mask, they are left unchanged.
     * Fields referenced in the mask, but not present in the input document, are
     * deleted from the document on the server.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type DocumentMask $mask
     *          The fields to return. If not set, returns all fields.
     *
     *          If the document has a field that is not present in this mask, that field
     *          will not be returned in the response.
     *     @type Precondition $currentDocument
     *          An optional precondition on the document.
     *          The request will fail if this is set and not met by the target document.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\Document
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function updateDocument($document, $updateMask, $optionalArgs = [])
    {
        $request = new UpdateDocumentRequest();
        $request->setDocument($document);
        $request->setUpdateMask($updateMask);
        if (isset($optionalArgs['mask'])) {
            $request->setMask($optionalArgs['mask']);
        }
        if (isset($optionalArgs['currentDocument'])) {
            $request->setCurrentDocument($optionalArgs['currentDocument']);
        }

        $mergedSettings = $this->defaultCallSettings['updateDocument']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'UpdateDocument',
            $mergedSettings,
            $this->descriptors['updateDocument']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a document.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedName = FirestoreClient::formatDocumentPathName("[PROJECT]", "[DATABASE]", "[DOCUMENT]", "[DOCUMENT_PATH]");
     *     $firestoreClient->deleteDocument($formattedName);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $name         The resource name of the Document to delete. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Precondition $currentDocument
     *          An optional precondition on the document.
     *          The request will fail if this is set and not met by the target document.
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
    public function deleteDocument($name, $optionalArgs = [])
    {
        $request = new DeleteDocumentRequest();
        $request->setName($name);
        if (isset($optionalArgs['currentDocument'])) {
            $request->setCurrentDocument($optionalArgs['currentDocument']);
        }

        $mergedSettings = $this->defaultCallSettings['deleteDocument']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'DeleteDocument',
            $mergedSettings,
            $this->descriptors['deleteDocument']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets multiple documents.
     *
     * Documents returned by this method are not guaranteed to be returned in the
     * same order that they were requested.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedDatabase = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $documents = [];
     *     // Read all responses until the stream is complete
     *     $stream = $firestoreClient->batchGetDocuments($formattedDatabase, $documents);
     *     foreach ($stream->readAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string   $database     The database name. In the format:
     *                               `projects/{project_id}/databases/{database_id}`.
     * @param string[] $documents    The names of the documents to retrieve. In the format:
     *                               `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     *                               The request will fail if any of the document is not a child resource of the
     *                               given `database`. Duplicate names will be elided.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type DocumentMask $mask
     *          The fields to return. If not set, returns all fields.
     *
     *          If a document has a field that is not present in this mask, that field will
     *          not be returned in the response.
     *     @type string $transaction
     *          Reads documents in a transaction.
     *     @type TransactionOptions $newTransaction
     *          Starts a new transaction and reads the documents.
     *          Defaults to a read-only transaction.
     *          The new transaction ID will be returned as the first response in the
     *          stream.
     *     @type Timestamp $readTime
     *          Reads documents as they were at the given time.
     *          This may not be older than 60 seconds.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\ServerStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function batchGetDocuments($database, $documents, $optionalArgs = [])
    {
        $request = new BatchGetDocumentsRequest();
        $request->setDatabase($database);
        $request->setDocuments($documents);
        if (isset($optionalArgs['mask'])) {
            $request->setMask($optionalArgs['mask']);
        }
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['newTransaction'])) {
            $request->setNewTransaction($optionalArgs['newTransaction']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }

        $mergedSettings = $this->defaultCallSettings['batchGetDocuments']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'BatchGetDocuments',
            $mergedSettings,
            $this->descriptors['batchGetDocuments']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Starts a new transaction.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedDatabase = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $response = $firestoreClient->beginTransaction($formattedDatabase);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $database     The database name. In the format:
     *                             `projects/{project_id}/databases/{database_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type TransactionOptions $options
     *          The options for the transaction.
     *          Defaults to a read-write transaction.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\BeginTransactionResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function beginTransaction($database, $optionalArgs = [])
    {
        $request = new BeginTransactionRequest();
        $request->setDatabase($database);
        if (isset($optionalArgs['options'])) {
            $request->setOptions($optionalArgs['options']);
        }

        $mergedSettings = $this->defaultCallSettings['beginTransaction']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'BeginTransaction',
            $mergedSettings,
            $this->descriptors['beginTransaction']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Commits a transaction, while optionally updating documents.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedDatabase = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $writes = [];
     *     $response = $firestoreClient->commit($formattedDatabase, $writes);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string  $database The database name. In the format:
     *                          `projects/{project_id}/databases/{database_id}`.
     * @param Write[] $writes   The writes to apply.
     *
     * Always executed atomically and in order.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $transaction
     *          If non-empty, applies all writes in this transaction, and commits it.
     *          Otherwise, applies the writes as if they were in their own transaction.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Firestore\V1beta1\CommitResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function commit($database, $writes, $optionalArgs = [])
    {
        $request = new CommitRequest();
        $request->setDatabase($database);
        $request->setWrites($writes);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }

        $mergedSettings = $this->defaultCallSettings['commit']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'Commit',
            $mergedSettings,
            $this->descriptors['commit']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Rolls back a transaction.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedDatabase = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     $transaction = "";
     *     $firestoreClient->rollback($formattedDatabase, $transaction);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $database     The database name. In the format:
     *                             `projects/{project_id}/databases/{database_id}`.
     * @param string $transaction  The transaction to roll back.
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
    public function rollback($database, $transaction, $optionalArgs = [])
    {
        $request = new RollbackRequest();
        $request->setDatabase($database);
        $request->setTransaction($transaction);

        $mergedSettings = $this->defaultCallSettings['rollback']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'Rollback',
            $mergedSettings,
            $this->descriptors['rollback']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Runs a query.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedParent = FirestoreClient::formatDatabaseName("[PROJECT]", "[DATABASE]");
     *     // Read all responses until the stream is complete
     *     $stream = $firestoreClient->runQuery($formattedParent);
     *     foreach ($stream->readAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent resource name. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents` or
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     *                             For example:
     *                             `projects/my-project/databases/my-database/documents` or
     *                             `projects/my-project/databases/my-database/documents/chatrooms/my-chatroom`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type StructuredQuery $structuredQuery
     *          A structured query.
     *     @type string $transaction
     *          Reads documents in a transaction.
     *     @type TransactionOptions $newTransaction
     *          Starts a new transaction and reads the documents.
     *          Defaults to a read-only transaction.
     *          The new transaction ID will be returned as the first response in the
     *          stream.
     *     @type Timestamp $readTime
     *          Reads documents as they were at the given time.
     *          This may not be older than 60 seconds.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\ServerStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function runQuery($parent, $optionalArgs = [])
    {
        $request = new RunQueryRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['structuredQuery'])) {
            $request->setStructuredQuery($optionalArgs['structuredQuery']);
        }
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }
        if (isset($optionalArgs['newTransaction'])) {
            $request->setNewTransaction($optionalArgs['newTransaction']);
        }
        if (isset($optionalArgs['readTime'])) {
            $request->setReadTime($optionalArgs['readTime']);
        }

        $mergedSettings = $this->defaultCallSettings['runQuery']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'RunQuery',
            $mergedSettings,
            $this->descriptors['runQuery']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Streams batches of document updates and deletes, in order.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $request = new WriteRequest();
     *     $requests = [$request];
     *
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $stream = $firestoreClient->write();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $stream = $firestoreClient->write();
     *     foreach ($requests as $request) {
     *         $stream->write($request);
     *         // if required, read a single response from the stream
     *         $element = $stream->read();
     *         // doSomethingWith($element)
     *     }
     *     $stream->closeWrite();
     *     $element = $stream->read();
     *     while (!is_null($element)) {
     *         // doSomethingWith($element)
     *         $element = $stream->read();
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\BidiStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function write($optionalArgs = [])
    {
        $mergedSettings = $this->defaultCallSettings['write']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'Write',
            $mergedSettings,
            $this->descriptors['write']
        );

        return $callable(
            null,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Listens to changes.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $request = new ListenRequest();
     *     $requests = [$request];
     *
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $stream = $firestoreClient->listen();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $stream = $firestoreClient->listen();
     *     foreach ($requests as $request) {
     *         $stream->write($request);
     *         // if required, read a single response from the stream
     *         $element = $stream->read();
     *         // doSomethingWith($element)
     *     }
     *     $stream->closeWrite();
     *     $element = $stream->read();
     *     while (!is_null($element)) {
     *         // doSomethingWith($element)
     *         $element = $stream->read();
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\BidiStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listen($optionalArgs = [])
    {
        $mergedSettings = $this->defaultCallSettings['listen']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'Listen',
            $mergedSettings,
            $this->descriptors['listen']
        );

        return $callable(
            null,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists all the collection IDs underneath a document.
     *
     * Sample code:
     * ```
     * try {
     *     $firestoreClient = new FirestoreClient();
     *     $formattedParent = FirestoreClient::formatDocumentPathName("[PROJECT]", "[DATABASE]", "[DOCUMENT]", "[DOCUMENT_PATH]");
     *     // Iterate through all elements
     *     $pagedResponse = $firestoreClient->listCollectionIds($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $firestoreClient->listCollectionIds($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $parent       The parent document. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     *                             For example:
     *                             `projects/my-project/databases/my-database/documents/chatrooms/my-chatroom`
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
    public function listCollectionIds($parent, $optionalArgs = [])
    {
        $request = new ListCollectionIdsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listCollectionIds']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->firestoreStub,
            'ListCollectionIds',
            $mergedSettings,
            $this->descriptors['listCollectionIds']
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
        $this->firestoreStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
