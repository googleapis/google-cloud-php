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
 * https://github.com/google/googleapis/blob/master/google/cloud/dialogflow/v2/agent.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Dialogflow\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Dialogflow\V2\Agent;
use Google\Cloud\Dialogflow\V2\ExportAgentRequest;
use Google\Cloud\Dialogflow\V2\ExportAgentResponse;
use Google\Cloud\Dialogflow\V2\GetAgentRequest;
use Google\Cloud\Dialogflow\V2\ImportAgentRequest;
use Google\Cloud\Dialogflow\V2\RestoreAgentRequest;
use Google\Cloud\Dialogflow\V2\SearchAgentsRequest;
use Google\Cloud\Dialogflow\V2\SearchAgentsResponse;
use Google\Cloud\Dialogflow\V2\TrainAgentRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Struct;
use Grpc\Channel;
use Grpc\ChannelCredentials;

/**
 * Service Description: Agents are best described as Natural Language Understanding (NLU) modules
 * that transform user requests into actionable data. You can include agents
 * in your app, product, or service to determine user intent and respond to the
 * user in a natural way.
 *
 * After you create an agent, you can add [Intents][google.cloud.dialogflow.v2.Intents], [Contexts][google.cloud.dialogflow.v2.Contexts],
 * [Entity Types][google.cloud.dialogflow.v2.EntityTypes], [Webhooks][google.cloud.dialogflow.v2.WebhookRequest], and so on to
 * manage the flow of a conversation and match user input to predefined intents
 * and actions.
 *
 * You can create an agent using both Dialogflow Standard Edition and
 * Dialogflow Enterprise Edition. For details, see
 * [Dialogflow Editions](https://cloud.google.com/dialogflow-enterprise/docs/editions).
 *
 * You can save your agent for backup or versioning by exporting the agent by
 * using the [ExportAgent][google.cloud.dialogflow.v2.Agents.ExportAgent] method. You can import a saved
 * agent by using the [ImportAgent][google.cloud.dialogflow.v2.Agents.ImportAgent] method.
 *
 * Dialogflow provides several
 * [prebuilt agents](https://dialogflow.com/docs/prebuilt-agents) for common
 * conversation scenarios such as determining a date and time, converting
 * currency, and so on.
 *
 * For more information about agents, see the
 * [Dialogflow documentation](https://dialogflow.com/docs/agents).
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $agentsClient = new AgentsClient();
 * try {
 *     $formattedParent = $agentsClient->projectName('[PROJECT]');
 *     $response = $agentsClient->getAgent($formattedParent);
 * } finally {
 *     $agentsClient->close();
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
class AgentsGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dialogflow.v2.Agents';

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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'clientConfigPath' => __DIR__.'/../resources/agents_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/agents_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/agents_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
        ];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function projectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}.
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'dialogflow.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl().
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this option is unused.
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type string[] $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Dialogflow API.
     *     @type string $clientConfigPath
     *           Path to a JSON file containing client method configuration, including retry settings.
     *           Specify this setting to specify the retry behavior of all methods on the client.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder. The retry settings provided in this option can be overridden
     *           by settings in $retryingOverride
     *     @type array $retryingOverride
     *           An associative array in which the keys are method names (e.g. 'createFoo'), and
     *           the values are retry settings to use for that method. The retry settings for each
     *           method can be a {@see Google\ApiCore\RetrySettings} object, or an associative array
     *           of retry settings parameters. See the documentation on {@see Google\ApiCore\RetrySettings}
     *           for example usage. Passing a value of null is equivalent to a value of
     *           ['retriesEnabled' => false]. Retry settings provided in this setting override the
     *           settings in $clientConfigPath.
     *     @type callable $authHttpHandler A handler used to deliver PSR-7 requests specifically
     *           for authentication. Should match a signature of
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $options += self::getClientDefaults();
        $this->setClientOptions($options);
        $this->pluckArray([
            'serviceName',
            'clientConfigPath',
            'descriptorsConfigPath',
        ], $options);
        $this->operationsClient = $this->pluck('operationsClient', $options, false)
            ?: new OperationsClient($options);
    }

    /**
     * Retrieves the specified agent.
     *
     * Sample code:
     * ```
     * $agentsClient = new AgentsClient();
     * try {
     *     $formattedParent = $agentsClient->projectName('[PROJECT]');
     *     $response = $agentsClient->getAgent($formattedParent);
     * } finally {
     *     $agentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The project that the agent to fetch is associated with.
     *                             Format: `projects/<Project ID>`.
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
     * @return \Google\Cloud\Dialogflow\V2\Agent
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getAgent($parent, $optionalArgs = [])
    {
        $request = new GetAgentRequest();
        $request->setParent($parent);

        return $this->startCall(
            'GetAgent',
            Agent::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns the list of agents.
     *
     * Since there is at most one conversational agent per project, this method is
     * useful primarily for listing all agents across projects the caller has
     * access to. One can achieve that with a wildcard project collection id "-".
     * Refer to [List
     * Sub-Collections](https://cloud.google.com/apis/design/design_patterns#list_sub-collections).
     *
     * Sample code:
     * ```
     * $agentsClient = new AgentsClient();
     * try {
     *     $formattedParent = $agentsClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $agentsClient->searchAgents($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $agentsClient->searchAgents($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $agentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The project to list agents from.
     *                             Format: `projects/<Project ID or '-'>`.
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
    public function searchAgents($parent, $optionalArgs = [])
    {
        $request = new SearchAgentsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'SearchAgents',
            $optionalArgs,
            SearchAgentsResponse::class,
            $request
        );
    }

    /**
     * Trains the specified agent.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     *
     * Sample code:
     * ```
     * $agentsClient = new AgentsClient();
     * try {
     *     $formattedParent = $agentsClient->projectName('[PROJECT]');
     *     $operationResponse = $agentsClient->trainAgent($formattedParent);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $agentsClient->trainAgent($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $agentsClient->resumeOperation($operationName, 'trainAgent');
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
     *     $agentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The project that the agent to train is associated with.
     *                             Format: `projects/<Project ID>`.
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
    public function trainAgent($parent, $optionalArgs = [])
    {
        $request = new TrainAgentRequest();
        $request->setParent($parent);

        return $this->startOperationsCall(
            'TrainAgent',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Exports the specified agent to a ZIP file.
     *
     * Operation <response: [ExportAgentResponse][google.cloud.dialogflow.v2.ExportAgentResponse],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     *
     * Sample code:
     * ```
     * $agentsClient = new AgentsClient();
     * try {
     *     $formattedParent = $agentsClient->projectName('[PROJECT]');
     *     $operationResponse = $agentsClient->exportAgent($formattedParent);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $agentsClient->exportAgent($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $agentsClient->resumeOperation($operationName, 'exportAgent');
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
     *     $agentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The project that the agent to export is associated with.
     *                             Format: `projects/<Project ID>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $agentUri
     *          Optional. The Google Cloud Storage URI to export the agent to.
     *          Note: The URI must start with
     *          "gs://". If left unspecified, the serialized agent is returned inline.
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
    public function exportAgent($parent, $optionalArgs = [])
    {
        $request = new ExportAgentRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['agentUri'])) {
            $request->setAgentUri($optionalArgs['agentUri']);
        }

        return $this->startOperationsCall(
            'ExportAgent',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Imports the specified agent from a ZIP file.
     *
     * Uploads new intents and entity types without deleting the existing ones.
     * Intents and entity types with the same name are replaced with the new
     * versions from ImportAgentRequest.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     *
     * Sample code:
     * ```
     * $agentsClient = new AgentsClient();
     * try {
     *     $formattedParent = $agentsClient->projectName('[PROJECT]');
     *     $operationResponse = $agentsClient->importAgent($formattedParent);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $agentsClient->importAgent($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $agentsClient->resumeOperation($operationName, 'importAgent');
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
     *     $agentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The project that the agent to import is associated with.
     *                             Format: `projects/<Project ID>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $agentUri
     *          The URI to a Google Cloud Storage file containing the agent to import.
     *          Note: The URI must start with "gs://".
     *     @type string $agentContent
     *          The agent to import.
     *
     *          Example for how to import an agent via the command line:
     *
     *          curl \
     *            'https://dialogflow.googleapis.com/v2/projects/<project_name>/agent:import\
     *             -X POST \
     *             -H 'Authorization: Bearer '$(gcloud auth print-access-token) \
     *             -H 'Accept: application/json' \
     *             -H 'Content-Type: application/json' \
     *             --compressed \
     *             --data-binary "{
     *                'agentContent': '$(cat <agent zip file> | base64 -w 0)'
     *             }"
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
    public function importAgent($parent, $optionalArgs = [])
    {
        $request = new ImportAgentRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['agentUri'])) {
            $request->setAgentUri($optionalArgs['agentUri']);
        }
        if (isset($optionalArgs['agentContent'])) {
            $request->setAgentContent($optionalArgs['agentContent']);
        }

        return $this->startOperationsCall(
            'ImportAgent',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Restores the specified agent from a ZIP file.
     *
     * Replaces the current agent version with a new one. All the intents and
     * entity types in the older version are deleted.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     *
     * Sample code:
     * ```
     * $agentsClient = new AgentsClient();
     * try {
     *     $formattedParent = $agentsClient->projectName('[PROJECT]');
     *     $operationResponse = $agentsClient->restoreAgent($formattedParent);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $agentsClient->restoreAgent($formattedParent);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $agentsClient->resumeOperation($operationName, 'restoreAgent');
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
     *     $agentsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The project that the agent to restore is associated with.
     *                             Format: `projects/<Project ID>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $agentUri
     *          The URI to a Google Cloud Storage file containing the agent to restore.
     *          Note: The URI must start with "gs://".
     *     @type string $agentContent
     *          The agent to restore.
     *
     *          Example for how to restore an agent via the command line:
     *
     *          curl \
     *            'https://dialogflow.googleapis.com/v2/projects/<project_name>/agent:restore\
     *             -X POST \
     *             -H 'Authorization: Bearer '$(gcloud auth print-access-token) \
     *             -H 'Accept: application/json' \
     *             -H 'Content-Type: application/json' \
     *             --compressed \
     *             --data-binary "{
     *                 'agentContent': '$(cat <agent zip file> | base64 -w 0)'
     *             }" \
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
    public function restoreAgent($parent, $optionalArgs = [])
    {
        $request = new RestoreAgentRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['agentUri'])) {
            $request->setAgentUri($optionalArgs['agentUri']);
        }
        if (isset($optionalArgs['agentContent'])) {
            $request->setAgentContent($optionalArgs['agentContent']);
        }

        return $this->startOperationsCall(
            'RestoreAgent',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }
}
