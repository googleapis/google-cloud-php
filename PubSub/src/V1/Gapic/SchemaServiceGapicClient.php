<?php
/*
 * Copyright 2021 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/pubsub/v1/schema.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\PubSub\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\PubSub\V1\CreateSchemaRequest;
use Google\Cloud\PubSub\V1\DeleteSchemaRequest;
use Google\Cloud\PubSub\V1\Encoding;
use Google\Cloud\PubSub\V1\GetSchemaRequest;
use Google\Cloud\PubSub\V1\ListSchemasRequest;
use Google\Cloud\PubSub\V1\ListSchemasResponse;
use Google\Cloud\PubSub\V1\Schema;
use Google\Cloud\PubSub\V1\ValidateMessageRequest;
use Google\Cloud\PubSub\V1\ValidateMessageResponse;
use Google\Cloud\PubSub\V1\ValidateSchemaRequest;
use Google\Cloud\PubSub\V1\ValidateSchemaResponse;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for doing schema-related operations.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $schemaServiceClient = new SchemaServiceClient();
 * try {
 *     $formattedParent = $schemaServiceClient->projectName('[PROJECT]');
 *     $schema = new Schema();
 *     $response = $schemaServiceClient->createSchema($formattedParent, $schema);
 * } finally {
 *     $schemaServiceClient->close();
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
class SchemaServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.pubsub.v1.SchemaService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'pubsub.googleapis.com';

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
        'https://www.googleapis.com/auth/pubsub',
    ];
    private static $projectNameTemplate;
    private static $schemaNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/schema_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/schema_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/schema_service_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/schema_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getProjectNameTemplate()
    {
        if (null == self::$projectNameTemplate) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getSchemaNameTemplate()
    {
        if (null == self::$schemaNameTemplate) {
            self::$schemaNameTemplate = new PathTemplate('projects/{project}/schemas/{schema}');
        }

        return self::$schemaNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'schema' => self::getSchemaNameTemplate(),
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
     * Formats a string containing the fully-qualified path to represent
     * a schema resource.
     *
     * @param string $project
     * @param string $schema
     *
     * @return string The formatted schema resource.
     * @experimental
     */
    public static function schemaName($project, $schema)
    {
        return self::getSchemaNameTemplate()->render([
            'project' => $project,
            'schema' => $schema,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - schema: projects/{project}/schemas/{schema}.
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
     *           as "<uri>:<port>". Default 'pubsub.googleapis.com:443'.
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
     * Creates a schema.
     *
     * Sample code:
     * ```
     * $schemaServiceClient = new SchemaServiceClient();
     * try {
     *     $formattedParent = $schemaServiceClient->projectName('[PROJECT]');
     *     $schema = new Schema();
     *     $response = $schemaServiceClient->createSchema($formattedParent, $schema);
     * } finally {
     *     $schemaServiceClient->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the project in which to create the schema.
     *                       Format is `projects/{project-id}`.
     * @param Schema $schema Required. The schema object to create.
     *
     * This schema's `name` parameter is ignored. The schema object returned
     * by CreateSchema will have a `name` made using the given `parent` and
     * `schema_id`.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $schemaId
     *          The ID to use for the schema, which will become the final component of
     *          the schema's resource name.
     *
     *          See https://cloud.google.com/pubsub/docs/admin#resource_names for resource
     *          name constraints.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Schema
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSchema($parent, $schema, array $optionalArgs = [])
    {
        $request = new CreateSchemaRequest();
        $request->setParent($parent);
        $request->setSchema($schema);
        if (isset($optionalArgs['schemaId'])) {
            $request->setSchemaId($optionalArgs['schemaId']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateSchema',
            Schema::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a schema.
     *
     * Sample code:
     * ```
     * $schemaServiceClient = new SchemaServiceClient();
     * try {
     *     $formattedName = $schemaServiceClient->schemaName('[PROJECT]', '[SCHEMA]');
     *     $response = $schemaServiceClient->getSchema($formattedName);
     * } finally {
     *     $schemaServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the schema to get.
     *                             Format is `projects/{project}/schemas/{schema}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $view
     *          The set of fields to return in the response. If not set, returns a Schema
     *          with `name` and `type`, but not `definition`. Set to `FULL` to retrieve all
     *          fields.
     *          For allowed values, use constants defined on {@see \Google\Cloud\PubSub\V1\SchemaView}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Schema
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSchema($name, array $optionalArgs = [])
    {
        $request = new GetSchemaRequest();
        $request->setName($name);
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetSchema',
            Schema::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists schemas in a project.
     *
     * Sample code:
     * ```
     * $schemaServiceClient = new SchemaServiceClient();
     * try {
     *     $formattedParent = $schemaServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $schemaServiceClient->listSchemas($formattedParent);
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
     *     $pagedResponse = $schemaServiceClient->listSchemas($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $schemaServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the project in which to list schemas.
     *                             Format is `projects/{project-id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $view
     *          The set of Schema fields to return in the response. If not set, returns
     *          Schemas with `name` and `type`, but not `definition`. Set to `FULL` to
     *          retrieve all fields.
     *          For allowed values, use constants defined on {@see \Google\Cloud\PubSub\V1\SchemaView}
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
    public function listSchemas($parent, array $optionalArgs = [])
    {
        $request = new ListSchemasRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['view'])) {
            $request->setView($optionalArgs['view']);
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
            'ListSchemas',
            $optionalArgs,
            ListSchemasResponse::class,
            $request
        );
    }

    /**
     * Deletes a schema.
     *
     * Sample code:
     * ```
     * $schemaServiceClient = new SchemaServiceClient();
     * try {
     *     $formattedName = $schemaServiceClient->schemaName('[PROJECT]', '[SCHEMA]');
     *     $schemaServiceClient->deleteSchema($formattedName);
     * } finally {
     *     $schemaServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Name of the schema to delete.
     *                             Format is `projects/{project}/schemas/{schema}`.
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
    public function deleteSchema($name, array $optionalArgs = [])
    {
        $request = new DeleteSchemaRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteSchema',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Validates a schema.
     *
     * Sample code:
     * ```
     * $schemaServiceClient = new SchemaServiceClient();
     * try {
     *     $formattedParent = $schemaServiceClient->projectName('[PROJECT]');
     *     $schema = new Schema();
     *     $response = $schemaServiceClient->validateSchema($formattedParent, $schema);
     * } finally {
     *     $schemaServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the project in which to validate schemas.
     *                             Format is `projects/{project-id}`.
     * @param Schema $schema       Required. The schema object to validate.
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
     * @return \Google\Cloud\PubSub\V1\ValidateSchemaResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function validateSchema($parent, $schema, array $optionalArgs = [])
    {
        $request = new ValidateSchemaRequest();
        $request->setParent($parent);
        $request->setSchema($schema);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ValidateSchema',
            ValidateSchemaResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Validates a message against a schema.
     *
     * Sample code:
     * ```
     * $schemaServiceClient = new SchemaServiceClient();
     * try {
     *     $formattedParent = $schemaServiceClient->projectName('[PROJECT]');
     *     $response = $schemaServiceClient->validateMessage($formattedParent);
     * } finally {
     *     $schemaServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the project in which to validate schemas.
     *                             Format is `projects/{project-id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $name
     *          Name of the schema against which to validate.
     *
     *          Format is `projects/{project}/schemas/{schema}`.
     *     @type Schema $schema
     *          Ad-hoc schema against which to validate
     *     @type string $message
     *          Message to validate against the provided `schema_spec`.
     *     @type int $encoding
     *          The encoding expected for messages
     *          For allowed values, use constants defined on {@see \Google\Cloud\PubSub\V1\Encoding}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\ValidateMessageResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function validateMessage($parent, array $optionalArgs = [])
    {
        $request = new ValidateMessageRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['name'])) {
            $request->setName($optionalArgs['name']);
        }
        if (isset($optionalArgs['schema'])) {
            $request->setSchema($optionalArgs['schema']);
        }
        if (isset($optionalArgs['message'])) {
            $request->setMessage($optionalArgs['message']);
        }
        if (isset($optionalArgs['encoding'])) {
            $request->setEncoding($optionalArgs['encoding']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ValidateMessage',
            ValidateMessageResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
