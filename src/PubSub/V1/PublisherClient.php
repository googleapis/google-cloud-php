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
 * https://github.com/google/googleapis/blob/master/google/pubsub/v1/pubsub.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\PubSub\V1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\Iam\V1\GetIamPolicyRequest;
use Google\Iam\V1\IAMPolicyGrpcClient;
use Google\Iam\V1\Policy;
use Google\Iam\V1\SetIamPolicyRequest;
use Google\Iam\V1\TestIamPermissionsRequest;
use Google\Pubsub\V1\DeleteTopicRequest;
use Google\Pubsub\V1\GetTopicRequest;
use Google\Pubsub\V1\ListTopicSubscriptionsRequest;
use Google\Pubsub\V1\ListTopicsRequest;
use Google\Pubsub\V1\PublishRequest;
use Google\Pubsub\V1\PublisherGrpcClient;
use Google\Pubsub\V1\PubsubMessage;
use Google\Pubsub\V1\Topic;

/**
 * Service Description: The service that an application uses to manipulate topics, and to send
 * messages to a topic.
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
 *     $publisherClient = new PublisherClient();
 *     $formattedName = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
 *     $response = $publisherClient->createTopic($formattedName);
 * } finally {
 *     $publisherClient->close();
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
class PublisherClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'pubsub.googleapis.com';

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

    private static $projectNameTemplate;
    private static $topicNameTemplate;

    private $grpcCredentialsHelper;
    private $iamPolicyStub;
    private $publisherStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function formatProjectName($project)
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
    public static function formatTopicName($project, $topic)
    {
        return self::getTopicNameTemplate()->render([
            'project' => $project,
            'topic' => $topic,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a project resource.
     *
     * @param string $projectName The fully-qualified project resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a topic resource.
     *
     * @param string $topicName The fully-qualified topic resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromTopicName($topicName)
    {
        return self::getTopicNameTemplate()->match($topicName)['project'];
    }

    /**
     * Parses the topic from the given fully-qualified path which
     * represents a topic resource.
     *
     * @param string $topicName The fully-qualified topic resource.
     *
     * @return string The extracted topic value.
     * @experimental
     */
    public static function parseTopicFromTopicName($topicName)
    {
        return self::getTopicNameTemplate()->match($topicName)['topic'];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getTopicNameTemplate()
    {
        if (self::$topicNameTemplate == null) {
            self::$topicNameTemplate = new PathTemplate('projects/{project}/topics/{topic}');
        }

        return self::$topicNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listTopicsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTopics',
                ]);
        $listTopicSubscriptionsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubscriptions',
                ]);

        $pageStreamingDescriptors = [
            'listTopics' => $listTopicsPageStreamingDescriptor,
            'listTopicSubscriptions' => $listTopicSubscriptionsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
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

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'pubsub.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Pub/Sub API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
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
                'https://www.googleapis.com/auth/pubsub',
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
            'createTopic' => $defaultDescriptors,
            'publish' => $defaultDescriptors,
            'getTopic' => $defaultDescriptors,
            'listTopics' => $defaultDescriptors,
            'listTopicSubscriptions' => $defaultDescriptors,
            'deleteTopic' => $defaultDescriptors,
            'setIamPolicy' => $defaultDescriptors,
            'getIamPolicy' => $defaultDescriptors,
            'testIamPermissions' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/publisher_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.pubsub.v1.Publisher',
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
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createIamPolicyStubFunction = function ($hostname, $opts) {
            return new IAMPolicyGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createIamPolicyStubFunction', $options)) {
            $createIamPolicyStubFunction = $options['createIamPolicyStubFunction'];
        }
        $this->iamPolicyStub = $this->grpcCredentialsHelper->createStub(
            $createIamPolicyStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
        $createPublisherStubFunction = function ($hostname, $opts) {
            return new PublisherGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createPublisherStubFunction', $options)) {
            $createPublisherStubFunction = $options['createPublisherStubFunction'];
        }
        $this->publisherStub = $this->grpcCredentialsHelper->createStub(
            $createPublisherStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Creates the given topic with the given name.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedName = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\Topic
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createTopic($name, $optionalArgs = [])
    {
        $request = new Topic();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['createTopic']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->publisherStub,
            'CreateTopic',
            $mergedSettings,
            $this->descriptors['createTopic']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Adds one or more messages to the topic. Returns `NOT_FOUND` if the topic
     * does not exist. The message payload must not be empty; it must contain
     *  either a non-empty data field, or at least one attribute.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedTopic = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
     *     $data = "";
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\PublishResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function publish($topic, $messages, $optionalArgs = [])
    {
        $request = new PublishRequest();
        $request->setTopic($topic);
        $request->setMessages($messages);

        $mergedSettings = $this->defaultCallSettings['publish']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->publisherStub,
            'Publish',
            $mergedSettings,
            $this->descriptors['publish']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the configuration of a topic.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedTopic = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\Topic
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getTopic($topic, $optionalArgs = [])
    {
        $request = new GetTopicRequest();
        $request->setTopic($topic);

        $mergedSettings = $this->defaultCallSettings['getTopic']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->publisherStub,
            'GetTopic',
            $mergedSettings,
            $this->descriptors['getTopic']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists matching topics.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedProject = PublisherClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $publisherClient->listTopics($formattedProject);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $publisherClient->listTopics($formattedProject, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $project      The name of the cloud project that topics belong to.
     *                             Format is `projects/{project}`.
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
    public function listTopics($project, $optionalArgs = [])
    {
        $request = new ListTopicsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listTopics']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->publisherStub,
            'ListTopics',
            $mergedSettings,
            $this->descriptors['listTopics']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the name of the subscriptions for this topic.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedTopic = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
     *     // Iterate through all elements
     *     $pagedResponse = $publisherClient->listTopicSubscriptions($formattedTopic);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $publisherClient->listTopicSubscriptions($formattedTopic, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
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
    public function listTopicSubscriptions($topic, $optionalArgs = [])
    {
        $request = new ListTopicSubscriptionsRequest();
        $request->setTopic($topic);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listTopicSubscriptions']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->publisherStub,
            'ListTopicSubscriptions',
            $mergedSettings,
            $this->descriptors['listTopicSubscriptions']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
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
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedTopic = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
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
    public function deleteTopic($topic, $optionalArgs = [])
    {
        $request = new DeleteTopicRequest();
        $request->setTopic($topic);

        $mergedSettings = $this->defaultCallSettings['deleteTopic']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->publisherStub,
            'DeleteTopic',
            $mergedSettings,
            $this->descriptors['deleteTopic']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Sets the access control policy on the specified resource. Replaces any
     * existing policy.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedResource = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
     *     $policy = new Policy();
     *     $response = $publisherClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param Policy $policy       REQUIRED: The complete policy to be applied to the `resource`. The size of
     *                             the policy is limited to a few 10s of KB. An empty policy is a
     *                             valid policy but certain Cloud Platform services (such as Projects)
     *                             might reject them.
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
     * @return \Google\Iam\V1\Policy
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $mergedSettings = $this->defaultCallSettings['setIamPolicy']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->iamPolicyStub,
            'SetIamPolicy',
            $mergedSettings,
            $this->descriptors['setIamPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the access control policy for a resource.
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedResource = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
     *     $response = $publisherClient->getIamPolicy($formattedResource);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
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
     * @return \Google\Iam\V1\Policy
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);

        $mergedSettings = $this->defaultCallSettings['getIamPolicy']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->iamPolicyStub,
            'GetIamPolicy',
            $mergedSettings,
            $this->descriptors['getIamPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns permissions that a caller has on the specified resource.
     * If the resource does not exist, this will return an empty set of
     * permissions, not a NOT_FOUND error.
     *
     * Sample code:
     * ```
     * try {
     *     $publisherClient = new PublisherClient();
     *     $formattedResource = PublisherClient::formatTopicName("[PROJECT]", "[TOPIC]");
     *     $permissions = [];
     *     $response = $publisherClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $publisherClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               `resource` is usually specified as a path. For example, a Project
     *                               resource is specified as `projects/{project}`.
     * @param string[] $permissions  The set of permissions to check for the `resource`. Permissions with
     *                               wildcards (such as '*' or 'storage.*') are not allowed. For more
     *                               information see
     *                               [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Iam\V1\TestIamPermissionsResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        $mergedSettings = $this->defaultCallSettings['testIamPermissions']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->iamPolicyStub,
            'TestIamPermissions',
            $mergedSettings,
            $this->descriptors['testIamPermissions']
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
        $this->iamPolicyStub->close();
        $this->publisherStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
