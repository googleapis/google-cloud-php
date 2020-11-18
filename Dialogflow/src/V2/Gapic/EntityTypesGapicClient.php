<?php
/*
 * Copyright 2018 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/dialogflow/v2/entity_type.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Dialogflow\V2\Gapic;

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
use Google\Cloud\Dialogflow\V2\BatchCreateEntitiesRequest;
use Google\Cloud\Dialogflow\V2\BatchDeleteEntitiesRequest;
use Google\Cloud\Dialogflow\V2\BatchDeleteEntityTypesRequest;
use Google\Cloud\Dialogflow\V2\BatchUpdateEntitiesRequest;
use Google\Cloud\Dialogflow\V2\BatchUpdateEntityTypesRequest;
use Google\Cloud\Dialogflow\V2\BatchUpdateEntityTypesResponse;
use Google\Cloud\Dialogflow\V2\CreateEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\DeleteEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\EntityType;
use Google\Cloud\Dialogflow\V2\EntityTypeBatch;
use Google\Cloud\Dialogflow\V2\EntityType\Entity;
use Google\Cloud\Dialogflow\V2\GetEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\ListEntityTypesRequest;
use Google\Cloud\Dialogflow\V2\ListEntityTypesResponse;
use Google\Cloud\Dialogflow\V2\UpdateEntityTypeRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for managing [EntityTypes][google.cloud.dialogflow.v2.EntityType].
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $entityTypesClient = new EntityTypesClient();
 * try {
 *     $formattedParent = $entityTypesClient->agentName('[PROJECT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $entityTypesClient->listEntityTypes($formattedParent);
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
 *     $pagedResponse = $entityTypesClient->listEntityTypes($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $entityTypesClient->close();
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
class EntityTypesGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dialogflow.v2.EntityTypes';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'dialogflow.googleapis.com';

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
        'https://www.googleapis.com/auth/dialogflow',
    ];
    private static $agentNameTemplate;
    private static $entityTypeNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/entity_types_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/entity_types_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/entity_types_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/entity_types_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAgentNameTemplate()
    {
        if (null == self::$agentNameTemplate) {
            self::$agentNameTemplate = new PathTemplate('projects/{project}/agent');
        }

        return self::$agentNameTemplate;
    }

    private static function getEntityTypeNameTemplate()
    {
        if (null == self::$entityTypeNameTemplate) {
            self::$entityTypeNameTemplate = new PathTemplate('projects/{project}/agent/entityTypes/{entity_type}');
        }

        return self::$entityTypeNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'agent' => self::getAgentNameTemplate(),
                'entityType' => self::getEntityTypeNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a agent resource.
     *
     * @param string $project
     *
     * @return string The formatted agent resource.
     * @experimental
     */
    public static function agentName($project)
    {
        return self::getAgentNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a entity_type resource.
     *
     * @param string $project
     * @param string $entityType
     *
     * @return string The formatted entity_type resource.
     * @experimental
     */
    public static function entityTypeName($project, $entityType)
    {
        return self::getEntityTypeNameTemplate()->render([
            'project' => $project,
            'entity_type' => $entityType,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - agent: projects/{project}/agent
     * - entityType: projects/{project}/agent/entityTypes/{entity_type}.
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
     *           as "<uri>:<port>". Default 'dialogflow.googleapis.com:443'.
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
     * Returns the list of all entity types in the specified agent.
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->agentName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $entityTypesClient->listEntityTypes($formattedParent);
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
     *     $pagedResponse = $entityTypesClient->listEntityTypes($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The agent to list all entity types from.
     *                             Format: `projects/<Project ID>/agent`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
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
    public function listEntityTypes($parent, array $optionalArgs = [])
    {
        $request = new ListEntityTypesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
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
            'ListEntityTypes',
            $optionalArgs,
            ListEntityTypesResponse::class,
            $request
        );
    }

    /**
     * Retrieves the specified entity type.
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedName = $entityTypesClient->entityTypeName('[PROJECT]', '[ENTITY_TYPE]');
     *     $response = $entityTypesClient->getEntityType($formattedName);
     * } finally {
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entity type.
     *                             Format: `projects/<Project ID>/agent/entityTypes/<EntityType ID>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\EntityType
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getEntityType($name, array $optionalArgs = [])
    {
        $request = new GetEntityTypeRequest();
        $request->setName($name);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetEntityType',
            EntityType::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates an entity type in the specified agent.
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->agentName('[PROJECT]');
     *     $entityType = new EntityType();
     *     $response = $entityTypesClient->createEntityType($formattedParent, $entityType);
     * } finally {
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string     $parent       Required. The agent to create a entity type for.
     *                                 Format: `projects/<Project ID>/agent`.
     * @param EntityType $entityType   Required. The entity type to create.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\EntityType
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createEntityType($parent, $entityType, array $optionalArgs = [])
    {
        $request = new CreateEntityTypeRequest();
        $request->setParent($parent);
        $request->setEntityType($entityType);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateEntityType',
            EntityType::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the specified entity type.
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $entityType = new EntityType();
     *     $response = $entityTypesClient->updateEntityType($entityType);
     * } finally {
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param EntityType $entityType   Required. The entity type to update.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type FieldMask $updateMask
     *          Optional. The mask to control which fields get updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\EntityType
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateEntityType($entityType, array $optionalArgs = [])
    {
        $request = new UpdateEntityTypeRequest();
        $request->setEntityType($entityType);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'entity_type.name' => $request->getEntityType()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateEntityType',
            EntityType::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the specified entity type.
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedName = $entityTypesClient->entityTypeName('[PROJECT]', '[ENTITY_TYPE]');
     *     $entityTypesClient->deleteEntityType($formattedName);
     * } finally {
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entity type to delete.
     *                             Format: `projects/<Project ID>/agent/entityTypes/<EntityType ID>`.
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
    public function deleteEntityType($name, array $optionalArgs = [])
    {
        $request = new DeleteEntityTypeRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteEntityType',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates/Creates multiple entity types in the specified agent.
     *
     * Operation <response: [BatchUpdateEntityTypesResponse][google.cloud.dialogflow.v2.BatchUpdateEntityTypesResponse]>
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->agentName('[PROJECT]');
     *     $operationResponse = $entityTypesClient->batchUpdateEntityTypes($formattedParent);
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
     *     $operationResponse = $entityTypesClient->batchUpdateEntityTypes($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $entityTypesClient->resumeOperation($operationName, 'batchUpdateEntityTypes');
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
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the agent to update or create entity types in.
     *                             Format: `projects/<Project ID>/agent`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $entityTypeBatchUri
     *          The URI to a Google Cloud Storage file containing entity types to update
     *          or create. The file format can either be a serialized proto (of
     *          EntityBatch type) or a JSON object. Note: The URI must start with
     *          "gs://".
     *     @type EntityTypeBatch $entityTypeBatchInline
     *          The collection of entity types to update or create.
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type FieldMask $updateMask
     *          Optional. The mask to control which fields get updated.
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
    public function batchUpdateEntityTypes($parent, array $optionalArgs = [])
    {
        $request = new BatchUpdateEntityTypesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['entityTypeBatchUri'])) {
            $request->setEntityTypeBatchUri($optionalArgs['entityTypeBatchUri']);
        }
        if (isset($optionalArgs['entityTypeBatchInline'])) {
            $request->setEntityTypeBatchInline($optionalArgs['entityTypeBatchInline']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchUpdateEntityTypes',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes entity types in the specified agent.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->agentName('[PROJECT]');
     *     $entityTypeNames = [];
     *     $operationResponse = $entityTypesClient->batchDeleteEntityTypes($formattedParent, $entityTypeNames);
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
     *     $operationResponse = $entityTypesClient->batchDeleteEntityTypes($formattedParent, $entityTypeNames);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $entityTypesClient->resumeOperation($operationName, 'batchDeleteEntityTypes');
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
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string   $parent          Required. The name of the agent to delete all entities types for. Format:
     *                                  `projects/<Project ID>/agent`.
     * @param string[] $entityTypeNames Required. The names entity types to delete. All names must point to the
     *                                  same agent as `parent`.
     * @param array    $optionalArgs    {
     *                                  Optional.
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
    public function batchDeleteEntityTypes($parent, $entityTypeNames, array $optionalArgs = [])
    {
        $request = new BatchDeleteEntityTypesRequest();
        $request->setParent($parent);
        $request->setEntityTypeNames($entityTypeNames);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchDeleteEntityTypes',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Creates multiple new entities in the specified entity type.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->entityTypeName('[PROJECT]', '[ENTITY_TYPE]');
     *     $entities = [];
     *     $operationResponse = $entityTypesClient->batchCreateEntities($formattedParent, $entities);
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
     *     $operationResponse = $entityTypesClient->batchCreateEntities($formattedParent, $entities);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $entityTypesClient->resumeOperation($operationName, 'batchCreateEntities');
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
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The name of the entity type to create entities in. Format:
     *                               `projects/<Project ID>/agent/entityTypes/<Entity Type ID>`.
     * @param Entity[] $entities     Required. The entities to create.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
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
    public function batchCreateEntities($parent, $entities, array $optionalArgs = [])
    {
        $request = new BatchCreateEntitiesRequest();
        $request->setParent($parent);
        $request->setEntities($entities);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchCreateEntities',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Updates or creates multiple entities in the specified entity type. This
     * method does not affect entities in the entity type that aren't explicitly
     * specified in the request.
     *
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->entityTypeName('[PROJECT]', '[ENTITY_TYPE]');
     *     $entities = [];
     *     $operationResponse = $entityTypesClient->batchUpdateEntities($formattedParent, $entities);
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
     *     $operationResponse = $entityTypesClient->batchUpdateEntities($formattedParent, $entities);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $entityTypesClient->resumeOperation($operationName, 'batchUpdateEntities');
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
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The name of the entity type to update or create entities in.
     *                               Format: `projects/<Project ID>/agent/entityTypes/<Entity Type ID>`.
     * @param Entity[] $entities     Required. The entities to update or create.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type FieldMask $updateMask
     *          Optional. The mask to control which fields get updated.
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
    public function batchUpdateEntities($parent, $entities, array $optionalArgs = [])
    {
        $request = new BatchUpdateEntitiesRequest();
        $request->setParent($parent);
        $request->setEntities($entities);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchUpdateEntities',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes entities in the specified entity type.
     *
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     *
     * Sample code:
     * ```
     * $entityTypesClient = new EntityTypesClient();
     * try {
     *     $formattedParent = $entityTypesClient->entityTypeName('[PROJECT]', '[ENTITY_TYPE]');
     *     $entityValues = [];
     *     $operationResponse = $entityTypesClient->batchDeleteEntities($formattedParent, $entityValues);
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
     *     $operationResponse = $entityTypesClient->batchDeleteEntities($formattedParent, $entityValues);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $entityTypesClient->resumeOperation($operationName, 'batchDeleteEntities');
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
     *     $entityTypesClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The name of the entity type to delete entries for. Format:
     *                               `projects/<Project ID>/agent/entityTypes/<Entity Type ID>`.
     * @param string[] $entityValues Required. The reference `values` of the entities to delete. Note that
     *                               these are not fully-qualified names, i.e. they don't start with
     *                               `projects/<Project ID>`.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
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
    public function batchDeleteEntities($parent, $entityValues, array $optionalArgs = [])
    {
        $request = new BatchDeleteEntitiesRequest();
        $request->setParent($parent);
        $request->setEntityValues($entityValues);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchDeleteEntities',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }
}
