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
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Dialogflow\V2\CreateSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\DeleteSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\GetSessionEntityTypeRequest;
use Google\Cloud\Dialogflow\V2\ListSessionEntityTypesRequest;
use Google\Cloud\Dialogflow\V2\ListSessionEntityTypesResponse;
use Google\Cloud\Dialogflow\V2\SessionEntityType;
use Google\Cloud\Dialogflow\V2\UpdateSessionEntityTypeRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Grpc\Channel;
use Grpc\ChannelCredentials;

/**
 * Service Description: Entities are extracted from user input and represent parameters that are
 * meaningful to your application. For example, a date range, a proper name
 * such as a geographic location or landmark, and so on. Entities represent
 * actionable data for your application.
 *
 * Session entity types are referred to as **User** entity types and are
 * entities that are built for an individual user such as
 * favorites, preferences, playlists, and so on. You can redefine a session
 * entity type at the session level.
 *
 * For more information about entity types, see the
 * [Dialogflow documentation](https://dialogflow.com/docs/entities).
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $sessionEntityTypesClient = new SessionEntityTypesClient();
 * try {
 *     $formattedParent = $sessionEntityTypesClient->sessionName('[PROJECT]', '[SESSION]');
 *     // Iterate through all elements
 *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($formattedParent);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $sessionNameTemplate;
    private static $sessionEntityTypeNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'clientConfigPath' => __DIR__.'/../resources/session_entity_types_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/session_entity_types_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/session_entity_types_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
        ];
    }

    private static function getSessionNameTemplate()
    {
        if (self::$sessionNameTemplate == null) {
            self::$sessionNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}');
        }

        return self::$sessionNameTemplate;
    }

    private static function getSessionEntityTypeNameTemplate()
    {
        if (self::$sessionEntityTypeNameTemplate == null) {
            self::$sessionEntityTypeNameTemplate = new PathTemplate('projects/{project}/agent/sessions/{session}/entityTypes/{entity_type}');
        }

        return self::$sessionEntityTypeNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'session' => self::getSessionNameTemplate(),
                'sessionEntityType' => self::getSessionEntityTypeNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
        $this->setClientOptions($options + self::getClientDefaults());
    }

    /**
     * Returns the list of all session entity types in the specified session.
     *
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $formattedParent = $sessionEntityTypesClient->sessionName('[PROJECT]', '[SESSION]');
     *     // Iterate through all elements
     *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $sessionEntityTypesClient->listSessionEntityTypes($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The session to list all session entity types from.
     *                             Format: `projects/<Project ID>/agent/sessions/<Session ID>`.
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
    public function listSessionEntityTypes($parent, $optionalArgs = [])
    {
        $request = new ListSessionEntityTypesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

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
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $formattedName = $sessionEntityTypesClient->sessionEntityTypeName('[PROJECT]', '[SESSION]', '[ENTITY_TYPE]');
     *     $response = $sessionEntityTypesClient->getSessionEntityType($formattedName);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the session entity type. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>/entityTypes/<Entity Type
     *                             Display Name>`.
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
    public function getSessionEntityType($name, $optionalArgs = [])
    {
        $request = new GetSessionEntityTypeRequest();
        $request->setName($name);

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
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $formattedParent = $sessionEntityTypesClient->sessionName('[PROJECT]', '[SESSION]');
     *     $sessionEntityType = new SessionEntityType();
     *     $response = $sessionEntityTypesClient->createSessionEntityType($formattedParent, $sessionEntityType);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string            $parent            Required. The session to create a session entity type for.
     *                                             Format: `projects/<Project ID>/agent/sessions/<Session ID>`.
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
    public function createSessionEntityType($parent, $sessionEntityType, $optionalArgs = [])
    {
        $request = new CreateSessionEntityTypeRequest();
        $request->setParent($parent);
        $request->setSessionEntityType($sessionEntityType);

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
     * @param SessionEntityType $sessionEntityType Required. The entity type to update. Format:
     *                                             `projects/<Project ID>/agent/sessions/<Session ID>/entityTypes/<Entity Type
     *                                             Display Name>`.
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
    public function updateSessionEntityType($sessionEntityType, $optionalArgs = [])
    {
        $request = new UpdateSessionEntityTypeRequest();
        $request->setSessionEntityType($sessionEntityType);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

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
     * Sample code:
     * ```
     * $sessionEntityTypesClient = new SessionEntityTypesClient();
     * try {
     *     $formattedName = $sessionEntityTypesClient->sessionEntityTypeName('[PROJECT]', '[SESSION]', '[ENTITY_TYPE]');
     *     $sessionEntityTypesClient->deleteSessionEntityType($formattedName);
     * } finally {
     *     $sessionEntityTypesClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the entity type to delete. Format:
     *                             `projects/<Project ID>/agent/sessions/<Session ID>/entityTypes/<Entity Type
     *                             Display Name>`.
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
    public function deleteSessionEntityType($name, $optionalArgs = [])
    {
        $request = new DeleteSessionEntityTypeRequest();
        $request->setName($name);

        return $this->startCall(
            'DeleteSessionEntityType',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
