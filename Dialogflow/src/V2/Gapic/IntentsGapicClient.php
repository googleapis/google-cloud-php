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
 * https://github.com/google/googleapis/blob/master/google/cloud/dialogflow/v2/intent.proto
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
use Google\Cloud\Dialogflow\V2\BatchDeleteIntentsRequest;
use Google\Cloud\Dialogflow\V2\BatchUpdateIntentsRequest;
use Google\Cloud\Dialogflow\V2\BatchUpdateIntentsResponse;
use Google\Cloud\Dialogflow\V2\CreateIntentRequest;
use Google\Cloud\Dialogflow\V2\DeleteIntentRequest;
use Google\Cloud\Dialogflow\V2\GetIntentRequest;
use Google\Cloud\Dialogflow\V2\Intent;
use Google\Cloud\Dialogflow\V2\IntentBatch;
use Google\Cloud\Dialogflow\V2\IntentView;
use Google\Cloud\Dialogflow\V2\ListIntentsRequest;
use Google\Cloud\Dialogflow\V2\ListIntentsResponse;
use Google\Cloud\Dialogflow\V2\UpdateIntentRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for managing [Intents][google.cloud.dialogflow.v2.Intent].
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $intentsClient = new IntentsClient();
 * try {
 *     $formattedParent = $intentsClient->agentName('[PROJECT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $intentsClient->listIntents($formattedParent);
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
 *     $pagedResponse = $intentsClient->listIntents($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $intentsClient->close();
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
class IntentsGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dialogflow.v2.Intents';

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
    private static $intentNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/intents_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/intents_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/intents_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/intents_rest_client_config.php',
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

    private static function getIntentNameTemplate()
    {
        if (null == self::$intentNameTemplate) {
            self::$intentNameTemplate = new PathTemplate('projects/{project}/agent/intents/{intent}');
        }

        return self::$intentNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'agent' => self::getAgentNameTemplate(),
                'intent' => self::getIntentNameTemplate(),
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
     * a intent resource.
     *
     * @param string $project
     * @param string $intent
     *
     * @return string The formatted intent resource.
     * @experimental
     */
    public static function intentName($project, $intent)
    {
        return self::getIntentNameTemplate()->render([
            'project' => $project,
            'intent' => $intent,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - agent: projects/{project}/agent
     * - intent: projects/{project}/agent/intents/{intent}.
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
     * Returns the list of all intents in the specified agent.
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $formattedParent = $intentsClient->agentName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $intentsClient->listIntents($formattedParent);
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
     *     $pagedResponse = $intentsClient->listIntents($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The agent to list all intents from.
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
     *     @type int $intentView
     *          Optional. The resource view to apply to the returned intent.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Dialogflow\V2\IntentView}
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
    public function listIntents($parent, array $optionalArgs = [])
    {
        $request = new ListIntentsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['intentView'])) {
            $request->setIntentView($optionalArgs['intentView']);
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
            'ListIntents',
            $optionalArgs,
            ListIntentsResponse::class,
            $request
        );
    }

    /**
     * Retrieves the specified intent.
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $formattedName = $intentsClient->intentName('[PROJECT]', '[INTENT]');
     *     $response = $intentsClient->getIntent($formattedName);
     * } finally {
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the intent.
     *                             Format: `projects/<Project ID>/agent/intents/<Intent ID>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type int $intentView
     *          Optional. The resource view to apply to the returned intent.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Dialogflow\V2\IntentView}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\Intent
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIntent($name, array $optionalArgs = [])
    {
        $request = new GetIntentRequest();
        $request->setName($name);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['intentView'])) {
            $request->setIntentView($optionalArgs['intentView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIntent',
            Intent::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates an intent in the specified agent.
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $formattedParent = $intentsClient->agentName('[PROJECT]');
     *     $intent = new Intent();
     *     $response = $intentsClient->createIntent($formattedParent, $intent);
     * } finally {
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The agent to create a intent for.
     *                             Format: `projects/<Project ID>/agent`.
     * @param Intent $intent       Required. The intent to create.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type int $intentView
     *          Optional. The resource view to apply to the returned intent.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Dialogflow\V2\IntentView}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\Intent
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createIntent($parent, $intent, array $optionalArgs = [])
    {
        $request = new CreateIntentRequest();
        $request->setParent($parent);
        $request->setIntent($intent);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['intentView'])) {
            $request->setIntentView($optionalArgs['intentView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateIntent',
            Intent::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the specified intent.
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $intent = new Intent();
     *     $response = $intentsClient->updateIntent($intent);
     * } finally {
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param Intent $intent       Required. The intent to update.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type FieldMask $updateMask
     *          Optional. The mask to control which fields get updated.
     *     @type int $intentView
     *          Optional. The resource view to apply to the returned intent.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Dialogflow\V2\IntentView}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\Intent
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateIntent($intent, array $optionalArgs = [])
    {
        $request = new UpdateIntentRequest();
        $request->setIntent($intent);
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }
        if (isset($optionalArgs['intentView'])) {
            $request->setIntentView($optionalArgs['intentView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'intent.name' => $request->getIntent()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateIntent',
            Intent::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the specified intent and its direct or indirect followup intents.
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $formattedName = $intentsClient->intentName('[PROJECT]', '[INTENT]');
     *     $intentsClient->deleteIntent($formattedName);
     * } finally {
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the intent to delete. If this intent has direct or
     *                             indirect followup intents, we also delete them.
     *                             Format: `projects/<Project ID>/agent/intents/<Intent ID>`.
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
    public function deleteIntent($name, array $optionalArgs = [])
    {
        $request = new DeleteIntentRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteIntent',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates/Creates multiple intents in the specified agent.
     *
     * Operation <response: [BatchUpdateIntentsResponse][google.cloud.dialogflow.v2.BatchUpdateIntentsResponse]>
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $formattedParent = $intentsClient->agentName('[PROJECT]');
     *     $operationResponse = $intentsClient->batchUpdateIntents($formattedParent);
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
     *     $operationResponse = $intentsClient->batchUpdateIntents($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $intentsClient->resumeOperation($operationName, 'batchUpdateIntents');
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
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the agent to update or create intents in.
     *                             Format: `projects/<Project ID>/agent`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $intentBatchUri
     *          The URI to a Google Cloud Storage file containing intents to update or
     *          create. The file format can either be a serialized proto (of IntentBatch
     *          type) or JSON object. Note: The URI must start with "gs://".
     *     @type IntentBatch $intentBatchInline
     *          The collection of intents to update or create.
     *     @type string $languageCode
     *          Optional. The language used to access language-specific data.
     *          If not specified, the agent's default language is used.
     *          For more information, see
     *          [Multilingual intent and entity
     *          data](https://cloud.google.com/dialogflow/docs/agents-multilingual#intent-entity).
     *     @type FieldMask $updateMask
     *          Optional. The mask to control which fields get updated.
     *     @type int $intentView
     *          Optional. The resource view to apply to the returned intent.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Dialogflow\V2\IntentView}
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
    public function batchUpdateIntents($parent, array $optionalArgs = [])
    {
        $request = new BatchUpdateIntentsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['intentBatchUri'])) {
            $request->setIntentBatchUri($optionalArgs['intentBatchUri']);
        }
        if (isset($optionalArgs['intentBatchInline'])) {
            $request->setIntentBatchInline($optionalArgs['intentBatchInline']);
        }
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }
        if (isset($optionalArgs['intentView'])) {
            $request->setIntentView($optionalArgs['intentView']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchUpdateIntents',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes intents in the specified agent.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     *
     * Sample code:
     * ```
     * $intentsClient = new IntentsClient();
     * try {
     *     $formattedParent = $intentsClient->agentName('[PROJECT]');
     *     $intents = [];
     *     $operationResponse = $intentsClient->batchDeleteIntents($formattedParent, $intents);
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
     *     $operationResponse = $intentsClient->batchDeleteIntents($formattedParent, $intents);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $intentsClient->resumeOperation($operationName, 'batchDeleteIntents');
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
     *     $intentsClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The name of the agent to delete all entities types for. Format:
     *                               `projects/<Project ID>/agent`.
     * @param Intent[] $intents      Required. The collection of intents to delete. Only intent `name` must be
     *                               filled in.
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function batchDeleteIntents($parent, $intents, array $optionalArgs = [])
    {
        $request = new BatchDeleteIntentsRequest();
        $request->setParent($parent);
        $request->setIntents($intents);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'BatchDeleteIntents',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }
}
