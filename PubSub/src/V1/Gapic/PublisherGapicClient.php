<?php
/*
 * Copyright 2016 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/pubsub/v1/pubsub.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\PubSub\V1\Gapic;

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
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\GetPolicyOptions;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\PubSub\V1\DeleteTopicRequest;
use Google\Cloud\PubSub\V1\GetTopicRequest;
use Google\Cloud\PubSub\V1\ListTopicSubscriptionsRequest;
use Google\Cloud\PubSub\V1\ListTopicSubscriptionsResponse;
use Google\Cloud\PubSub\V1\ListTopicsRequest;
use Google\Cloud\PubSub\V1\ListTopicsResponse;
use Google\Cloud\PubSub\V1\MessageStoragePolicy;
use Google\Cloud\PubSub\V1\PublishRequest;
use Google\Cloud\PubSub\V1\PublishResponse;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\Topic;
use Google\Cloud\PubSub\V1\UpdateTopicRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The service that an application uses to manipulate topics, and to send
 * messages to a topic.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $publisherClient = new PublisherClient();
 * try {
 *     $formattedName = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
 *     $response = $publisherClient->createTopic($formattedName);
 * } finally {
 *     $publisherClient->close();
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
class PublisherGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.pubsub.v1.Publisher';

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
    private static $topicNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/publisher_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/publisher_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/publisher_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/publisher_rest_client_config.php',
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

    private static function getTopicNameTemplate()
    {
        if (null == self::$topicNameTemplate) {
            self::$topicNameTemplate = new PathTemplate('projects/{project}/topics/{topic}');
        }

        return self::$topicNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'topic' => self::getTopicNameTemplate(),
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
     * a topic resource.
     *
     * @param string $project
     * @param string $topic
     *
     * @return string The formatted topic resource.
     * @experimental
     */
    public static function topicName($project, $topic)
    {
        return self::getTopicNameTemplate()->render([
            'project' => $project,
            'topic' => $topic,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - topic: projects/{project}/topics/{topic}.
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
     * Creates the given topic with the given name. See the
     * <a href="https://cloud.google.com/pubsub/docs/admin#resource_names">
     * resource name rules</a>.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedName = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $response = $publisherClient->createTopic($formattedName);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the topic. It must have the format
     *                             `"projects/{project}/topics/{topic}"`. `{topic}` must start with a letter,
     *                             and contain only letters (`[A-Za-z]`), numbers (`[0-9]`), dashes (`-`),
     *                             underscores (`_`), periods (`.`), tildes (`~`), plus (`+`) or percent
     *                             signs (`%`). It must be between 3 and 255 characters in length, and it
     *                             must not start with `"goog"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type array $labels
     *          See <a href="https://cloud.google.com/pubsub/docs/labels"> Creating and
     *          managing labels</a>.
     *     @type MessageStoragePolicy $messageStoragePolicy
     *          Policy constraining the set of Google Cloud Platform regions where messages
     *          published to the topic may be stored. If not present, then no constraints
     *          are in effect.
     *     @type string $kmsKeyName
     *          The resource name of the Cloud KMS CryptoKey to be used to protect access
     *          to messages published on this topic.
     *
     *          The expected format is `projects/&#42;/locations/&#42;/keyRings/&#42;/cryptoKeys/*`.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Topic
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createTopic($name, array $optionalArgs = [])
    {
        $request = new Topic();
        $request->setName($name);
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }
        if (isset($optionalArgs['messageStoragePolicy'])) {
            $request->setMessageStoragePolicy($optionalArgs['messageStoragePolicy']);
        }
        if (isset($optionalArgs['kmsKeyName'])) {
            $request->setKmsKeyName($optionalArgs['kmsKeyName']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTopic',
            Topic::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing topic. Note that certain properties of a
     * topic are not modifiable.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $topic = new Topic();
     *     $updateMask = new FieldMask();
     *     $response = $publisherClient->updateTopic($topic, $updateMask);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param Topic     $topic        The updated topic object.
     * @param FieldMask $updateMask   Indicates which fields in the provided topic to update. Must be specified
     *                                and non-empty. Note that if `update_mask` contains
     *                                "message_storage_policy" then the new value will be determined based on the
     *                                policy configured at the project or organization level. The
     *                                `message_storage_policy` must not be set in the `topic` provided above.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Topic
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateTopic($topic, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateTopicRequest();
        $request->setTopic($topic);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'topic.name' => $request->getTopic()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateTopic',
            Topic::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Adds one or more messages to the topic. Returns `NOT_FOUND` if the topic
     * does not exist.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedTopic = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $data = '';
     *     $messagesElement = new PubsubMessage();
     *     $messagesElement->setData($data);
     *     $messages = [$messagesElement];
     *     $response = $publisherClient->publish($formattedTopic, $messages);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string          $topic        The messages in the request will be published on this topic.
     *                                      Format is `projects/{project}/topics/{topic}`.
     * @param PubsubMessage[] $messages     The messages to publish.
     * @param array           $optionalArgs {
     *                                      Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\PublishResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function publish($topic, $messages, array $optionalArgs = [])
    {
        $request = new PublishRequest();
        $request->setTopic($topic);
        $request->setMessages($messages);

        $requestParams = new RequestParamsHeaderDescriptor([
          'topic' => $request->getTopic(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Publish',
            PublishResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the configuration of a topic.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedTopic = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $response = $publisherClient->getTopic($formattedTopic);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $topic        The name of the topic to get.
     *                             Format is `projects/{project}/topics/{topic}`.
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
     * @return \Google\Cloud\PubSub\V1\Topic
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getTopic($topic, array $optionalArgs = [])
    {
        $request = new GetTopicRequest();
        $request->setTopic($topic);

        $requestParams = new RequestParamsHeaderDescriptor([
          'topic' => $request->getTopic(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetTopic',
            Topic::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists matching topics.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedProject = $publisherClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $publisherClient->listTopics($formattedProject);
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
     *     $pagedResponse = $publisherClient->listTopics($formattedProject);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $project      The name of the project in which to list topics.
     *                             Format is `projects/{project-id}`.
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
    public function listTopics($project, array $optionalArgs = [])
    {
        $request = new ListTopicsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'project' => $request->getProject(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListTopics',
            $optionalArgs,
            ListTopicsResponse::class,
            $request
        );
    }

    /**
     * Lists the names of the subscriptions on this topic.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedTopic = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $publisherClient->listTopicSubscriptions($formattedTopic);
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
     *     $pagedResponse = $publisherClient->listTopicSubscriptions($formattedTopic);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $topic        The name of the topic that subscriptions are attached to.
     *                             Format is `projects/{project}/topics/{topic}`.
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
    public function listTopicSubscriptions($topic, array $optionalArgs = [])
    {
        $request = new ListTopicSubscriptionsRequest();
        $request->setTopic($topic);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'topic' => $request->getTopic(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListTopicSubscriptions',
            $optionalArgs,
            ListTopicSubscriptionsResponse::class,
            $request
        );
    }

    /**
     * Deletes the topic with the given name. Returns `NOT_FOUND` if the topic
     * does not exist. After a topic is deleted, a new topic may be created with
     * the same name; this is an entirely new topic with none of the old
     * configuration or subscriptions. Existing subscriptions to this topic are
     * not deleted, but their `topic` field is set to `_deleted-topic_`.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedTopic = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $publisherClient->deleteTopic($formattedTopic);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $topic        Name of the topic to delete.
     *                             Format is `projects/{project}/topics/{topic}`.
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
    public function deleteTopic($topic, array $optionalArgs = [])
    {
        $request = new DeleteTopicRequest();
        $request->setTopic($topic);

        $requestParams = new RequestParamsHeaderDescriptor([
          'topic' => $request->getTopic(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteTopic',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the access control policy on the specified resource. Replaces any
     * existing policy.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedResource = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $policy = new Policy();
     *     $response = $publisherClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             See the operation documentation for the appropriate value for this field.
     * @param Policy $policy       REQUIRED: The complete policy to be applied to the `resource`. The size of
     *                             the policy is limited to a few 10s of KB. An empty policy is a
     *                             valid policy but certain Cloud Platform services (such as Projects)
     *                             might reject them.
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
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, array $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            'google.iam.v1.IAMPolicy'
        )->wait();
    }

    /**
     * Gets the access control policy for a resource.
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedResource = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $response = $publisherClient->getIamPolicy($formattedResource);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             See the operation documentation for the appropriate value for this field.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type GetPolicyOptions $options
     *          OPTIONAL: A `GetPolicyOptions` object for specifying options to
     *          `GetIamPolicy`. This field is only used by Cloud IAM.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, array $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);
        if (isset($optionalArgs['options'])) {
            $request->setOptions($optionalArgs['options']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            'google.iam.v1.IAMPolicy'
        )->wait();
    }

    /**
     * Returns permissions that a caller has on the specified resource.
     * If the resource does not exist, this will return an empty set of
     * permissions, not a NOT_FOUND error.
     *
     * Note: This operation is designed to be used for building permission-aware
     * UIs and command-line tools, not for authorization checking. This operation
     * may "fail open" without warning.
     *
     * Sample code:
     * ```
     * $publisherClient = new PublisherClient();
     * try {
     *     $formattedResource = $publisherClient->topicName('[PROJECT]', '[TOPIC]');
     *     $permissions = [];
     *     $response = $publisherClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               See the operation documentation for the appropriate value for this field.
     * @param string[] $permissions  The set of permissions to check for the `resource`. Permissions with
     *                               wildcards (such as '*' or 'storage.*') are not allowed. For more
     *                               information see
     *                               [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
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
     * @return \Google\Cloud\Iam\V1\TestIamPermissionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, array $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'TestIamPermissions',
            TestIamPermissionsResponse::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            'google.iam.v1.IAMPolicy'
        )->wait();
    }
}
