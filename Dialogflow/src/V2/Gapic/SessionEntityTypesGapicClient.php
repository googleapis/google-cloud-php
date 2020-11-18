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
 * https://github.com/google/googleapis/blob/master/google/cloud/dialogflow/v2/session_entity_type.proto
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
use Google\Cloud\Dialogflow\V2\CreateSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\DeleteSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\GetSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\ListSessionEntityTypesRequest;
use Google\Cloud\Dialogflow\V2\ListSessionEntityTypesResponse;
use Google\Cloud\Dialogflow\V2\SessionEntityType;
use Google\Cloud\Dialogflow\V2\UpdateSessionEntityTypeRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for managing [SessionEntityTypes][google.cloud.dialogflow.v2.SessionEntityType].
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $sessionEntityTypesClient = new SessionEntityTypesClient();
 * try {
 *     $parent = '';
 *     // Iterate over pages of elements
 *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($parent);
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
 *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($parent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $sessionEntityTypesClient->close();
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
class SessionEntityTypesGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dialogflow.v2.SessionEntityTypes';

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
    private static $projectEnvironmentUserSessionNameTemplate;
    private static $projectEnvironmentUserSessionEntityTypeNameTemplate;
    private static $projectSessionNameTemplate;
    private static $projectSessionEntityTypeNameTemplate;
    private static $sessionNameTemplate;
    private static $sessionEntityTypeNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/session_entity_types_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/session_entity_types_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/session_entity_types_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/session_entity_types_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getProjectEnvironmentUserSessionNameTemplate()
    {
        if (null == self::$projectEnvironmentUserSessionNameTemplate) {
            self::$projectEnvironmentUserSessionNameTemplate = new PathTemplate('projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}');
        }

        return self::$projectEnvironmentUserSessionNameTemplate;
    }

    private static function getProjectEnvironmentUserSessionEntityTypeNameTemplate()
    {
        if (null == self::$projectEnvironmentUserSessionEntityTypeNameTemplate) {
            self::$projectEnvironmentUserSessionEntityTypeNameTemplate = new PathTemplate('projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/entityTypes/{entity_type}');
        }

        return self::$projectEnvironmentUserSessionEntityTypeNameTemplate;
    }

    private static function getProjectSessionNameTemplate()
    {
        if (null == self::$projectSessionNameTemplate) {
            self::$projectSessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$projectSessionNameTemplate;
    }

    private static function getProjectSessionEntityTypeNameTemplate()
    {
        if (null == self::$projectSessionEntityTypeNameTemplate) {
            self::$projectSessionEntityTypeNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}');
        }

        return self::$projectSessionEntityTypeNameTemplate;
    }

    private static function getSessionNameTemplate()
    {
        if (null == self::$sessionNameTemplate) {
            self::$sessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$sessionNameTemplate;
    }

    private static function getSessionEntityTypeNameTemplate()
    {
        if (null == self::$sessionEntityTypeNameTemplate) {
            self::$sessionEntityTypeNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}');
        }

        return self::$sessionEntityTypeNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'projectEnvironmentUserSession' => self::getProjectEnvironmentUserSessionNameTemplate(),
                'projectEnvironmentUserSessionEntityType' => self::getProjectEnvironmentUserSessionEntityTypeNameTemplate(),
                'projectSession' => self::getProjectSessionNameTemplate(),
                'projectSessionEntityType' => self::getProjectSessionEntityTypeNameTemplate(),
                'session' => self::getSessionNameTemplate(),
                'sessionEntityType' => self::getSessionEntityTypeNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a project_environment_user_session_entity_type resource.
     *
     * @param string $project
     * @param string $environment
     * @param string $user
     * @param string $session
     * @param string $entityType
     *
     * @return string The formatted project_environment_user_session_entity_type resource.
     * @experimental
     */
    public static function projectEnvironmentUserSessionEntityTypeName($project, $environment, $user, $session, $entityType)
    {
        return self::getProjectEnvironmentUserSessionEntityTypeNameTemplate()->render([
            'project' => $project,
            'environment' => $environment,
            'user' => $user,
            'session' => $session,
            'entity_type' => $entityType,
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
     * a project_session_entity_type resource.
     *
     * @param string $project
     * @param string $session
     * @param string $entityType
     *
     * @return string The formatted project_session_entity_type resource.
     * @experimental
     */
    public static function projectSessionEntityTypeName($project, $session, $entityType)
    {
        return self::getProjectSessionEntityTypeNameTemplate()->render([
            'project' => $project,
            'session' => $session,
            'entity_type' => $entityType,
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
     * Formats a string containing the fully-qualified path to represent
     * a session_entity_type resource.
     *
     * @param string $project
     * @param string $session
     * @param string $entityType
     *
     * @return string The formatted session_entity_type resource.
     * @experimental
     */
    public static function sessionEntityTypeName($project, $session, $entityType)
    {
        return self::getSessionEntityTypeNameTemplate()->render([
            'project' => $project,
            'session' => $session,
            'entity_type' => $entityType,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - projectEnvironmentUserSession: projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}
     * - projectEnvironmentUserSessionEntityType: projects/{project}/agent/environments/{environment}/users/{user}/sessions/{session}/entityTypes/{entity_type}
     * - projectSession: projects/{project}/agent/sessions/{session}
     * - projectSessionEntityType: projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}
     * - session: projects/{project}/agent/sessions/{session}
     * - sessionEntityType: projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}.
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
     * Returns the list of all session entity types in the specified session.
     *
     * This method doesn't work with Google Assistant integration.
     * Contact Dialogflow support if you need to use session entities
     * with Google Assistant integration.
     *
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $parent = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($parent);
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
     *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($parent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The session to list all session entity types from.
     *                             Format: `projects/<Project ID>/agent/sessions/<Session ID>` or
     *                             `projects/<Project ID>/agent/environments/<Environment ID>/users/<User ID>/
     *                             sessions/<Session ID>`.
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
    public function listSessionEntityTypes($parent, array $optionalArgs = [])
    {
        $request = new ListSessionEntityTypesRequest();
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
            'ListSessionEntityTypes',
            $optionalArgs,
            ListSessionEntityTypesResponse::class,
            $request
        );
    }

    /**
     * Retrieves the specified session entity type.
     *
     * This method doesn't work with Google Assistant integration.
     * Contact Dialogflow support if you need to use session entities
     * with Google Assistant integration.
     *
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $name = '';
     *     $response = $sessionEntityTypesClient->getSessionEntityType($name);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the session entity type. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>/entityTypes/<Entity Type
     *                             Display Name>` or `projects/<Project ID>/agent/environments/<Environment
     *                             ID>/users/<User ID>/sessions/<Session ID>/entityTypes/<Entity Type Display
     *                             Name>`.
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
     * @return \Google\Cloud\Dialogflow\V2\SessionEntityType
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSessionEntityType($name, array $optionalArgs = [])
    {
        $request = new GetSessionEntityTypeRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetSessionEntityType',
            SessionEntityType::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a session entity type.
     *
     * If the specified session entity type already exists, overrides the session
     * entity type.
     *
     * This method doesn't work with Google Assistant integration.
     * Contact Dialogflow support if you need to use session entities
     * with Google Assistant integration.
     *
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $parent = '';
     *     $sessionEntityType = new SessionEntityType();
     *     $response = $sessionEntityTypesClient->createSessionEntityType($parent, $sessionEntityType);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string            $parent            Required. The session to create a session entity type for.
     *                                             Format: `projects/<Project ID>/agent/sessions/<Session ID>` or
     *                                             `projects/<Project ID>/agent/environments/<Environment ID>/users/<User ID>/
     *                                             sessions/<Session ID>`.
     *                                             If `Environment ID` is not specified, we assume default 'draft'
     *                                             environment. If `User ID` is not specified, we assume default '-' user.
     * @param SessionEntityType $sessionEntityType Required. The session entity type to create.
     * @param array             $optionalArgs      {
     *                                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dialogflow\V2\SessionEntityType
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSessionEntityType($parent, $sessionEntityType, array $optionalArgs = [])
    {
        $request = new CreateSessionEntityTypeRequest();
        $request->setParent($parent);
        $request->setSessionEntityType($sessionEntityType);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateSessionEntityType',
            SessionEntityType::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates the specified session entity type.
     *
     * This method doesn't work with Google Assistant integration.
     * Contact Dialogflow support if you need to use session entities
     * with Google Assistant integration.
     *
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $sessionEntityType = new SessionEntityType();
     *     $response = $sessionEntityTypesClient->updateSessionEntityType($sessionEntityType);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param SessionEntityType $sessionEntityType Required. The session entity type to update.
     * @param array             $optionalArgs      {
     *                                             Optional.
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
     * @return \Google\Cloud\Dialogflow\V2\SessionEntityType
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateSessionEntityType($sessionEntityType, array $optionalArgs = [])
    {
        $request = new UpdateSessionEntityTypeRequest();
        $request->setSessionEntityType($sessionEntityType);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'session_entity_type.name' => $request->getSessionEntityType()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateSessionEntityType',
            SessionEntityType::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the specified session entity type.
     *
     * This method doesn't work with Google Assistant integration.
     * Contact Dialogflow support if you need to use session entities
     * with Google Assistant integration.
     *
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $name = '';
     *     $sessionEntityTypesClient->deleteSessionEntityType($name);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entity type to delete. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>/entityTypes/<Entity Type
     *                             Display Name>` or `projects/<Project ID>/agent/environments/<Environment
     *                             ID>/users/<User ID>/sessions/<Session ID>/entityTypes/<Entity Type Display
     *                             Name>`.
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
    public function deleteSessionEntityType($name, array $optionalArgs = [])
    {
        $request = new DeleteSessionEntityTypeRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteSessionEntityType',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
