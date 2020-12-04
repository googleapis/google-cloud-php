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
 * https://github.com/google/googleapis/blob/master/google/cloud/dialogflow/v2/context.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Dialogflow\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Dialogflow\V2\Context;
use Google\Cloud\Dialogflow\V2\CreateContextRequest;
use Google\Cloud\Dialogflow\V2\DeleteAllContextsRequest;
use Google\Cloud\Dialogflow\V2\DeleteContextRequest;
use Google\Cloud\Dialogflow\V2\GetContextRequest;
use Google\Cloud\Dialogflow\V2\ListContextsRequest;
use Google\Cloud\Dialogflow\V2\ListContextsResponse;
use Google\Cloud\Dialogflow\V2\UpdateContextRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for managing [Contexts][google.cloud.dialogflow.v2.Context].
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $contextsClient = new ContextsClient();
 * try {
 *     $parent = '';
 *     // Iterate over pages of elements
 *     $pagedResponse = $contextsClient->listContexts($parent);
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
 *     $pagedResponse = $contextsClient->listContexts($parent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $contextsClient->close();
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
class ContextsGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dialogflow.v2.Contexts';

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
    private static $contextNameTemplate;
    private static $projectEnvironmentUserSessionNameTemplate;
    private static $projectEnvironmentUserSessionContextNameTemplate;
    private static $projectSessionNameTemplate;
    private static $projectSessionContextNameTemplate;
    private static $sessionNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/contexts_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/contexts_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/contexts_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/contexts_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getContextNameTemplate()
    {
        if (null == self::$contextNameTemplate) {
            self::$contextNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}/contexts/{context}');
        }

        return self::$contextNameTemplate;
    }

    private static function getProjectEnvironmentUserSessionNameTemplate()
    {
        if (null == self::$projectEnvironmentUserSessionNameTemplate) {
            self::$projectEnvironmentUserSessionNameTemplate = new PathTemplate('projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}');
        }

        return self::$projectEnvironmentUserSessionNameTemplate;
    }

    private static function getProjectEnvironmentUserSessionContextNameTemplate()
    {
        if (null == self::$projectEnvironmentUserSessionContextNameTemplate) {
            self::$projectEnvironmentUserSessionContextNameTemplate = new PathTemplate('projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}');
        }

        return self::$projectEnvironmentUserSessionContextNameTemplate;
    }

    private static function getProjectSessionNameTemplate()
    {
        if (null == self::$projectSessionNameTemplate) {
            self::$projectSessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$projectSessionNameTemplate;
    }

    private static function getProjectSessionContextNameTemplate()
    {
        if (null == self::$projectSessionContextNameTemplate) {
            self::$projectSessionContextNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}/contexts/{context}');
        }

        return self::$projectSessionContextNameTemplate;
    }

    private static function getSessionNameTemplate()
    {
        if (null == self::$sessionNameTemplate) {
            self::$sessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$sessionNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'context' => self::getContextNameTemplate(),
                'projectEnvironmentUserSession' => self::getProjectEnvironmentUserSessionNameTemplate(),
                'projectEnvironmentUserSessionContext' => self::getProjectEnvironmentUserSessionContextNameTemplate(),
                'projectSession' => self::getProjectSessionNameTemplate(),
                'projectSessionContext' => self::getProjectSessionContextNameTemplate(),
                'session' => self::getSessionNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a context resource.
     *
     * @param string $project
     * @param string $session
     * @param string $context
     *
     * @return string The formatted context resource.
     * @experimental
     */
    public static function contextName($project, $session, $context)
    {
        return self::getContextNameTemplate()->render([
            'project' => $project,
            'session' => $session,
            'context' => $context,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_environment_user_session resource.
     *
     * @param string $project
     * @param string $environment
     * @param string $user
     * @param string $session
     *
     * @return string The formatted project_environment_user_session resource.
     * @experimental
     */
    public static function projectEnvironmentUserSessionName($project, $environment, $user, $session)
    {
        return self::getProjectEnvironmentUserSessionNameTemplate()->render([
            'project' => $project,
            'environment' => $environment,
            'user' => $user,
            'session' => $session,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_environment_user_session_context resource.
     *
     * @param string $project
     * @param string $environment
     * @param string $user
     * @param string $session
     * @param string $context
     *
     * @return string The formatted project_environment_user_session_context resource.
     * @experimental
     */
    public static function projectEnvironmentUserSessionContextName($project, $environment, $user, $session, $context)
    {
        return self::getProjectEnvironmentUserSessionContextNameTemplate()->render([
            'project' => $project,
            'environment' => $environment,
            'user' => $user,
            'session' => $session,
            'context' => $context,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_session resource.
     *
     * @param string $project
     * @param string $session
     *
     * @return string The formatted project_session resource.
     * @experimental
     */
    public static function projectSessionName($project, $session)
    {
        return self::getProjectSessionNameTemplate()->render([
            'project' => $project,
            'session' => $session,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project_session_context resource.
     *
     * @param string $project
     * @param string $session
     * @param string $context
     *
     * @return string The formatted project_session_context resource.
     * @experimental
     */
    public static function projectSessionContextName($project, $session, $context)
    {
        return self::getProjectSessionContextNameTemplate()->render([
            'project' => $project,
            'session' => $session,
            'context' => $context,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a session resource.
     *
     * @param string $project
     * @param string $session
     *
     * @return string The formatted session resource.
     * @experimental
     */
    public static function sessionName($project, $session)
    {
        return self::getSessionNameTemplate()->render([
            'project' => $project,
            'session' => $session,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - context: projects/{project}/agent/sessions/{session}/contexts/{context}
     * - projectEnvironmentUserSession: projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}
     * - projectEnvironmentUserSessionContext: projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/contexts/{context}
     * - projectSession: projects/{project}/agent/sessions/{session}
     * - projectSessionContext: projects/{project}/agent/sessions/{session}/contexts/{context}
     * - session: projects/{project}/agent/sessions/{session}.
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
    }

    /**
     * Returns the list of all contexts in the specified session.
     *
     * Sample code:
     * ```
     * $contextsClient = new ContextsClient();
     * try {
     *     $parent = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $contextsClient->listContexts($parent);
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
     *     $pagedResponse = $contextsClient->listContexts($parent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $contextsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The session to list all contexts from.
     *                             Format: `projects/<Project ID>/agent/sessions/<Session ID>` or
     *                             `projects/<Project ID>/agent/environments/<Environment ID>/users/<User
     *                             ID>/sessions/<Session ID>`.
     *                             If `Environment ID` is not specified, we assume default 'draft'
     *                             environment. If `User ID` is not specified, we assume default '-' user.
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
    public function listContexts($parent, array $optionalArgs = [])
    {
        $request = new ListContextsRequest();
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
            'ListContexts',
            $optionalArgs,
            ListContextsResponse::class,
            $request
        );
    }

    /**
     * Retrieves the specified context.
     *
     * Sample code:
     * ```
     * $contextsClient = new ContextsClient();
     * try {
     *     $name = '';
     *     $response = $contextsClient->getContext($name);
     * } finally {
     *     $contextsClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the context. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>/contexts/<Context ID>`
     *                             or `projects/<Project ID>/agent/environments/<Environment ID>/users/<User
     *                             ID>/sessions/<Session ID>/contexts/<Context ID>`.
     *                             If `Environment ID` is not specified, we assume default 'draft'
     *                             environment. If `User ID` is not specified, we assume default '-' user.
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
     * @return \Google\Cloud\Dialogflow\V2\Context
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getContext($name, array $optionalArgs = [])
    {
        $request = new GetContextRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetContext',
            Context::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a context.
     *
     * If the specified context already exists, overrides the context.
     *
     * Sample code:
     * ```
     * $contextsClient = new ContextsClient();
     * try {
     *     $parent = '';
     *     $context = new Context();
     *     $response = $contextsClient->createContext($parent, $context);
     * } finally {
     *     $contextsClient->close();
     * }
     * ```
     *
     * @param string  $parent       Required. The session to create a context for.
     *                              Format: `projects/<Project ID>/agent/sessions/<Session ID>` or
     *                              `projects/<Project ID>/agent/environments/<Environment ID>/users/<User
     *                              ID>/sessions/<Session ID>`.
     *                              If `Environment ID` is not specified, we assume default 'draft'
     *                              environment. If `User ID` is not specified, we assume default '-' user.
     * @param Context $context      Required. The context to create.
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
     * @return \Google\Cloud\Dialogflow\V2\Context
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createContext($parent, $context, array $optionalArgs = [])
    {
        $request = new CreateContextRequest();
        $request->setParent($parent);
        $request->setContext($context);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateContext',
            Context::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the specified context.
     *
     * Sample code:
     * ```
     * $contextsClient = new ContextsClient();
     * try {
     *     $context = new Context();
     *     $response = $contextsClient->updateContext($context);
     * } finally {
     *     $contextsClient->close();
     * }
     * ```
     *
     * @param Context $context      Required. The context to update.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type FieldMask $updateMask
     *          Optional. The mask to control which fields get updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\Context
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateContext($context, array $optionalArgs = [])
    {
        $request = new UpdateContextRequest();
        $request->setContext($context);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'context.name' => $request->getContext()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateContext',
            Context::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the specified context.
     *
     * Sample code:
     * ```
     * $contextsClient = new ContextsClient();
     * try {
     *     $name = '';
     *     $contextsClient->deleteContext($name);
     * } finally {
     *     $contextsClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the context to delete. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>/contexts/<Context ID>`
     *                             or `projects/<Project ID>/agent/environments/<Environment ID>/users/<User
     *                             ID>/sessions/<Session ID>/contexts/<Context ID>`.
     *                             If `Environment ID` is not specified, we assume default 'draft'
     *                             environment. If `User ID` is not specified, we assume default '-' user.
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
    public function deleteContext($name, array $optionalArgs = [])
    {
        $request = new DeleteContextRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteContext',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes all active contexts in the specified session.
     *
     * Sample code:
     * ```
     * $contextsClient = new ContextsClient();
     * try {
     *     $parent = '';
     *     $contextsClient->deleteAllContexts($parent);
     * } finally {
     *     $contextsClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the session to delete all contexts from. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>` or `projects/<Project
     *                             ID>/agent/environments/<Environment ID>/users/<User ID>/sessions/<Session
     *                             ID>`.
     *                             If `Environment ID` is not specified we assume default 'draft' environment.
     *                             If `User ID` is not specified, we assume default '-' user.
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
    public function deleteAllContexts($parent, array $optionalArgs = [])
    {
        $request = new DeleteAllContextsRequest();
        $request->setParent($parent);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteAllContexts',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
