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
 * https://github.com/google/googleapis/blob/master/google/firestore/v1/firestore.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Firestore\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\BatchGetDocumentsResponse;
use Google\Cloud\Firestore\V1\BatchWriteRequest;
use Google\Cloud\Firestore\V1\BatchWriteResponse;
use Google\Cloud\Firestore\V1\BeginTransactionRequest;
use Google\Cloud\Firestore\V1\BeginTransactionResponse;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\CreateDocumentRequest;
use Google\Cloud\Firestore\V1\DeleteDocumentRequest;
use Google\Cloud\Firestore\V1\Document;
use Google\Cloud\Firestore\V1\DocumentMask;
use Google\Cloud\Firestore\V1\GetDocumentRequest;
use Google\Cloud\Firestore\V1\ListCollectionIdsRequest;
use Google\Cloud\Firestore\V1\ListCollectionIdsResponse;
use Google\Cloud\Firestore\V1\ListDocumentsRequest;
use Google\Cloud\Firestore\V1\ListDocumentsResponse;
use Google\Cloud\Firestore\V1\ListenRequest;
use Google\Cloud\Firestore\V1\ListenResponse;
use Google\Cloud\Firestore\V1\PartitionQueryRequest;
use Google\Cloud\Firestore\V1\PartitionQueryResponse;
use Google\Cloud\Firestore\V1\Precondition;
use Google\Cloud\Firestore\V1\RollbackRequest;
use Google\Cloud\Firestore\V1\RunQueryRequest;
use Google\Cloud\Firestore\V1\RunQueryResponse;
use Google\Cloud\Firestore\V1\StructuredQuery;
use Google\Cloud\Firestore\V1\Target;
use Google\Cloud\Firestore\V1\TransactionOptions;
use Google\Cloud\Firestore\V1\UpdateDocumentRequest;
use Google\Cloud\Firestore\V1\Write;
use Google\Cloud\Firestore\V1\WriteRequest;
use Google\Cloud\Firestore\V1\WriteResponse;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;

/**
 * Service Description: The Cloud Firestore service.
 *
 * Cloud Firestore is a fast, fully managed, serverless, cloud-native NoSQL
 * document database that simplifies storing, syncing, and querying data for
 * your mobile, web, and IoT apps at global scale. Its client libraries provide
 * live synchronization and offline support, while its security features and
 * integrations with Firebase and Google Cloud Platform (GCP) accelerate
 * building truly serverless apps.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $firestoreClient = new FirestoreClient();
 * try {
 *     $formattedName = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
 *     $response = $firestoreClient->getDocument($formattedName);
 * } finally {
 *     $firestoreClient->close();
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
class FirestoreGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.firestore.v1.Firestore';

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
    private static $anyPathNameTemplate;
    private static $databaseRootNameTemplate;
    private static $documentPathNameTemplate;
    private static $documentRootNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/firestore_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/firestore_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/firestore_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/firestore_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAnyPathNameTemplate()
    {
        if (null == self::$anyPathNameTemplate) {
            self::$anyPathNameTemplate = new PathTemplate('projects/{project}/databases/{database}/documents/{document}/{any_path=**}');
        }

        return self::$anyPathNameTemplate;
    }

    private static function getDatabaseRootNameTemplate()
    {
        if (null == self::$databaseRootNameTemplate) {
            self::$databaseRootNameTemplate = new PathTemplate('projects/{project}/databases/{database}');
        }

        return self::$databaseRootNameTemplate;
    }

    private static function getDocumentPathNameTemplate()
    {
        if (null == self::$documentPathNameTemplate) {
            self::$documentPathNameTemplate = new PathTemplate('projects/{project}/databases/{database}/documents/{document_path=**}');
        }

        return self::$documentPathNameTemplate;
    }

    private static function getDocumentRootNameTemplate()
    {
        if (null == self::$documentRootNameTemplate) {
            self::$documentRootNameTemplate = new PathTemplate('projects/{project}/databases/{database}/documents');
        }

        return self::$documentRootNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'anyPath' => self::getAnyPathNameTemplate(),
                'databaseRoot' => self::getDatabaseRootNameTemplate(),
                'documentPath' => self::getDocumentPathNameTemplate(),
                'documentRoot' => self::getDocumentRootNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a any_path resource.
     *
     * @param string $project
     * @param string $database
     * @param string $document
     * @param string $anyPath
     *
     * @return string The formatted any_path resource.
     * @experimental
     */
    public static function anyPathName($project, $database, $document, $anyPath)
    {
        return self::getAnyPathNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'document' => $document,
            'any_path' => $anyPath,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a database_root resource.
     *
     * @param string $project
     * @param string $database
     *
     * @return string The formatted database_root resource.
     * @experimental
     */
    public static function databaseRootName($project, $database)
    {
        return self::getDatabaseRootNameTemplate()->render([
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
     * @param string $documentPath
     *
     * @return string The formatted document_path resource.
     * @experimental
     */
    public static function documentPathName($project, $database, $documentPath)
    {
        return self::getDocumentPathNameTemplate()->render([
            'project' => $project,
            'database' => $database,
            'document_path' => $documentPath,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a document_root resource.
     *
     * @param string $project
     * @param string $database
     *
     * @return string The formatted document_root resource.
     * @experimental
     */
    public static function documentRootName($project, $database)
    {
        return self::getDocumentRootNameTemplate()->render([
            'project' => $project,
            'database' => $database,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - anyPath: projects/{project}/databases/{database}/documents/{document}/{any_path=**}
     * - databaseRoot: projects/{project}/databases/{database}
     * - documentPath: projects/{project}/databases/{database}/documents/{document_path=**}
     * - documentRoot: projects/{project}/databases/{database}/documents.
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
     * Gets a single document.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedName = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
     *     $response = $firestoreClient->getDocument($formattedName);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the Document to get. In the format:
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
     *          This may not be older than 270 seconds.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\Document
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDocument($name, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetDocument',
            Document::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists documents.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedParent = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
     *     $collectionId = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $firestoreClient->listDocuments($formattedParent, $collectionId);
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
     *     $pagedResponse = $firestoreClient->listDocuments($formattedParent, $collectionId);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The parent resource name. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents` or
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     *                             For example:
     *                             `projects/my-project/databases/my-database/documents` or
     *                             `projects/my-project/databases/my-database/documents/chatrooms/my-chatroom`
     * @param string $collectionId Required. The collection ID, relative to `parent`, to list. For example: `chatrooms`
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
     *          This may not be older than 270 seconds.
     *     @type bool $showMissing
     *          If the list should show missing documents. A missing document is a
     *          document that does not exist but has sub-documents. These documents will
     *          be returned with a key but will not have fields, [Document.create_time][google.firestore.v1.Document.create_time],
     *          or [Document.update_time][google.firestore.v1.Document.update_time] set.
     *
     *          Requests with `show_missing` may not specify `where` or
     *          `order_by`.
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
    public function listDocuments($parent, $collectionId, array $optionalArgs = [])
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

        return $this->getPagedListResponse(
            'ListDocuments',
            $optionalArgs,
            ListDocumentsResponse::class,
            $request
        );
    }

    /**
     * Creates a new document.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedParent = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
     *     $collectionId = '';
     *     $documentId = '';
     *     $document = new Document();
     *     $response = $firestoreClient->createDocument($formattedParent, $collectionId, $documentId, $document);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The parent resource. For example:
     *                             `projects/{project_id}/databases/{database_id}/documents` or
     *                             `projects/{project_id}/databases/{database_id}/documents/chatrooms/{chatroom_id}`
     * @param string $collectionId Required. The collection ID, relative to `parent`, to list. For example: `chatrooms`.
     * @param string $documentId   The client-assigned document ID to use for this document.
     *
     * Optional. If not specified, an ID will be assigned by the service.
     * @param Document $document     Required. The document to create. `name` must not be set.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type DocumentMask $mask
     *          The fields to return. If not set, returns all fields.
     *
     *          If the document has a field that is not present in this mask, that field
     *          will not be returned in the response.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\Document
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createDocument($parent, $collectionId, $documentId, $document, array $optionalArgs = [])
    {
        $request = new CreateDocumentRequest();
        $request->setParent($parent);
        $request->setCollectionId($collectionId);
        $request->setDocumentId($documentId);
        $request->setDocument($document);
        if (isset($optionalArgs['mask'])) {
            $request->setMask($optionalArgs['mask']);
        }

        return $this->startCall(
            'CreateDocument',
            Document::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates or inserts a document.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $document = new Document();
     *     $updateMask = new DocumentMask();
     *     $response = $firestoreClient->updateDocument($document, $updateMask);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param Document     $document   Required. The updated document.
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\Document
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateDocument($document, $updateMask, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'document.name' => $request->getDocument()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateDocument',
            Document::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a document.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedName = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
     *     $firestoreClient->deleteDocument($formattedName);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the Document to delete. In the format:
     *                             `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Precondition $currentDocument
     *          An optional precondition on the document.
     *          The request will fail if this is set and not met by the target document.
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
    public function deleteDocument($name, array $optionalArgs = [])
    {
        $request = new DeleteDocumentRequest();
        $request->setName($name);
        if (isset($optionalArgs['currentDocument'])) {
            $request->setCurrentDocument($optionalArgs['currentDocument']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteDocument',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets multiple documents.
     *
     * Documents returned by this method are not guaranteed to be returned in the
     * same order that they were requested.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedDatabase = $firestoreClient->databaseRootName('[PROJECT]', '[DATABASE]');
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
     * @param string   $database     Required. The database name. In the format:
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
     *          This may not be older than 270 seconds.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\ApiCore\ServerStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchGetDocuments($database, $documents, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'database' => $request->getDatabase(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BatchGetDocuments',
            BatchGetDocumentsResponse::class,
            $optionalArgs,
            $request,
            Call::SERVER_STREAMING_CALL
        );
    }

    /**
     * Starts a new transaction.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedDatabase = $firestoreClient->databaseRootName('[PROJECT]', '[DATABASE]');
     *     $response = $firestoreClient->beginTransaction($formattedDatabase);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $database     Required. The database name. In the format:
     *                             `projects/{project_id}/databases/{database_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type TransactionOptions $options
     *          The options for the transaction.
     *          Defaults to a read-write transaction.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\BeginTransactionResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function beginTransaction($database, array $optionalArgs = [])
    {
        $request = new BeginTransactionRequest();
        $request->setDatabase($database);
        if (isset($optionalArgs['options'])) {
            $request->setOptions($optionalArgs['options']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'database' => $request->getDatabase(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BeginTransaction',
            BeginTransactionResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Commits a transaction, while optionally updating documents.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedDatabase = $firestoreClient->databaseRootName('[PROJECT]', '[DATABASE]');
     *     $writes = [];
     *     $response = $firestoreClient->commit($formattedDatabase, $writes);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string  $database Required. The database name. In the format:
     *                          `projects/{project_id}/databases/{database_id}`.
     * @param Write[] $writes   The writes to apply.
     *
     * Always executed atomically and in order.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $transaction
     *          If set, applies all writes in this transaction, and commits it.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\CommitResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function commit($database, $writes, array $optionalArgs = [])
    {
        $request = new CommitRequest();
        $request->setDatabase($database);
        $request->setWrites($writes);
        if (isset($optionalArgs['transaction'])) {
            $request->setTransaction($optionalArgs['transaction']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'database' => $request->getDatabase(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Commit',
            CommitResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Rolls back a transaction.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedDatabase = $firestoreClient->databaseRootName('[PROJECT]', '[DATABASE]');
     *     $transaction = '';
     *     $firestoreClient->rollback($formattedDatabase, $transaction);
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $database     Required. The database name. In the format:
     *                             `projects/{project_id}/databases/{database_id}`.
     * @param string $transaction  Required. The transaction to roll back.
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
    public function rollback($database, $transaction, array $optionalArgs = [])
    {
        $request = new RollbackRequest();
        $request->setDatabase($database);
        $request->setTransaction($transaction);

        $requestParams = new RequestParamsHeaderDescriptor([
          'database' => $request->getDatabase(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Rollback',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Runs a query.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedParent = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
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
     * @param string $parent       Required. The parent resource name. In the format:
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
     *          This may not be older than 270 seconds.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\ApiCore\ServerStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function runQuery($parent, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RunQuery',
            RunQueryResponse::class,
            $optionalArgs,
            $request,
            Call::SERVER_STREAMING_CALL
        );
    }

    /**
     * Streams batches of document updates and deletes, in order.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedDatabase = $firestoreClient->databaseRootName('[PROJECT]', '[DATABASE]');
     *     $request = new WriteRequest();
     *     $request->setDatabase($formattedDatabase);
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $requests = [$request];
     *     $stream = $firestoreClient->write();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $requests = [$request];
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
     * @return \Google\ApiCore\BidiStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function write(array $optionalArgs = [])
    {
        return $this->startCall(
            'Write',
            WriteResponse::class,
            $optionalArgs,
            null,
            Call::BIDI_STREAMING_CALL
        );
    }

    /**
     * Listens to changes.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedDatabase = $firestoreClient->databaseRootName('[PROJECT]', '[DATABASE]');
     *     $request = new ListenRequest();
     *     $request->setDatabase($formattedDatabase);
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $requests = [$request];
     *     $stream = $firestoreClient->listen();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $requests = [$request];
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
     * @return \Google\ApiCore\BidiStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listen(array $optionalArgs = [])
    {
        return $this->startCall(
            'Listen',
            ListenResponse::class,
            $optionalArgs,
            null,
            Call::BIDI_STREAMING_CALL
        );
    }

    /**
     * Lists all the collection IDs underneath a document.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $formattedParent = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $firestoreClient->listCollectionIds($formattedParent);
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
     *     $pagedResponse = $firestoreClient->listCollectionIds($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The parent document. In the format:
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
    public function listCollectionIds($parent, array $optionalArgs = [])
    {
        $request = new ListCollectionIdsRequest();
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
            'ListCollectionIds',
            $optionalArgs,
            ListCollectionIdsResponse::class,
            $request
        );
    }

    /**
     * Partitions a query by returning partition cursors that can be used to run
     * the query in parallel. The returned partition cursors are split points that
     * can be used by RunQuery as starting/end points for the query results.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $response = $firestoreClient->partitionQuery();
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $parent
     *          Required. The parent resource name. In the format:
     *          `projects/{project_id}/databases/{database_id}/documents`.
     *          Document resource names are not supported; only database resource names
     *          can be specified.
     *     @type StructuredQuery $structuredQuery
     *          A structured query.
     *          Filters, order bys, limits, offsets, and start/end cursors are not
     *          supported.
     *     @type int $partitionCount
     *          The desired maximum number of partition points.
     *          The partitions may be returned across multiple pages of results.
     *          The number must be strictly positive. The actual number of partitions
     *          returned may be fewer.
     *
     *          For example, this may be set to one fewer than the number of parallel
     *          queries to be run, or in running a data pipeline job, one fewer than the
     *          number of workers or compute instances available.
     *     @type string $pageToken
     *          The `next_page_token` value returned from a previous call to
     *          PartitionQuery that may be used to get an additional set of results.
     *          There are no ordering guarantees between sets of results. Thus, using
     *          multiple sets of results will require merging the different result sets.
     *
     *          For example, two subsequent calls using a page_token may return:
     *
     *           * cursor B, cursor M, cursor Q
     *           * cursor A, cursor U, cursor W
     *
     *          To obtain a complete result set ordered with respect to the results of the
     *          query supplied to PartitionQuery, the results sets should be merged:
     *          cursor A, cursor B, cursor M, cursor Q, cursor U, cursor W
     *     @type int $pageSize
     *          The maximum number of partitions to return in this call, subject to
     *          `partition_count`.
     *
     *          For example, if `partition_count` = 10 and `page_size` = 8, the first call
     *          to PartitionQuery will return up to 8 partitions and a `next_page_token`
     *          if more results exist. A second call to PartitionQuery will return up to
     *          2 partitions, to complete the total of 10 specified in `partition_count`.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\PartitionQueryResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function partitionQuery(array $optionalArgs = [])
    {
        $request = new PartitionQueryRequest();
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
        }
        if (isset($optionalArgs['structuredQuery'])) {
            $request->setStructuredQuery($optionalArgs['structuredQuery']);
        }
        if (isset($optionalArgs['partitionCount'])) {
            $request->setPartitionCount($optionalArgs['partitionCount']);
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

        return $this->startCall(
            'PartitionQuery',
            PartitionQueryResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Applies a batch of write operations.
     *
     * The BatchWrite method does not apply the write operations atomically
     * and can apply them out of order. Method does not allow more than one write
     * per document. Each write succeeds or fails independently. See the
     * [BatchWriteResponse][google.firestore.v1.BatchWriteResponse] for the success status of each write.
     *
     * If you require an atomically applied set of writes, use
     * [Commit][google.firestore.v1.Firestore.Commit] instead.
     *
     * Sample code:
     * ```
     * $firestoreClient = new FirestoreClient();
     * try {
     *     $response = $firestoreClient->batchWrite();
     * } finally {
     *     $firestoreClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $database
     *          Required. The database name. In the format:
     *          `projects/{project_id}/databases/{database_id}`.
     *     @type Write[] $writes
     *          The writes to apply.
     *
     *          Method does not apply writes atomically and does not guarantee ordering.
     *          Each write succeeds or fails independently. You cannot write to the same
     *          document more than once per request.
     *     @type array $labels
     *          Labels associated with this batch write.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Firestore\V1\BatchWriteResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchWrite(array $optionalArgs = [])
    {
        $request = new BatchWriteRequest();
        if (isset($optionalArgs['database'])) {
            $request->setDatabase($optionalArgs['database']);
        }
        if (isset($optionalArgs['writes'])) {
            $request->setWrites($optionalArgs['writes']);
        }
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'database' => $request->getDatabase(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'BatchWrite',
            BatchWriteResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
