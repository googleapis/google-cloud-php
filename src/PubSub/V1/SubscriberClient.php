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
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;
use Google\Pubsub\V1\AcknowledgeRequest;
use Google\Pubsub\V1\CreateSnapshotRequest;
use Google\Pubsub\V1\DeleteSnapshotRequest;
use Google\Pubsub\V1\DeleteSubscriptionRequest;
use Google\Pubsub\V1\GetSubscriptionRequest;
use Google\Pubsub\V1\ListSnapshotsRequest;
use Google\Pubsub\V1\ListSubscriptionsRequest;
use Google\Pubsub\V1\ModifyAckDeadlineRequest;
use Google\Pubsub\V1\ModifyPushConfigRequest;
use Google\Pubsub\V1\PullRequest;
use Google\Pubsub\V1\PushConfig;
use Google\Pubsub\V1\SeekRequest;
use Google\Pubsub\V1\StreamingPullRequest;
use Google\Pubsub\V1\SubscriberGrpcClient;
use Google\Pubsub\V1\Subscription;
use Google\Pubsub\V1\UpdateSubscriptionRequest;

/**
 * Service Description: The service that an application uses to manipulate subscriptions and to
 * consume messages from a subscription via the `Pull` method.
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
 *     $subscriberClient = new SubscriberClient();
 *     $formattedName = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
 *     $formattedTopic = SubscriberClient::formatTopicName("[PROJECT]", "[TOPIC]");
 *     $response = $subscriberClient->createSubscription($formattedName, $formattedTopic);
 * } finally {
 *     $subscriberClient->close();
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
class SubscriberClient
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
    private static $snapshotNameTemplate;
    private static $subscriptionNameTemplate;
    private static $topicNameTemplate;

    private $grpcCredentialsHelper;
    private $iamPolicyStub;
    private $subscriberStub;
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
     * a snapshot resource.
     *
     * @param string $project
     * @param string $snapshot
     *
     * @return string The formatted snapshot resource.
     * @experimental
     */
    public static function formatSnapshotName($project, $snapshot)
    {
        return self::getSnapshotNameTemplate()->render([
            'project' => $project,
            'snapshot' => $snapshot,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a subscription resource.
     *
     * @param string $project
     * @param string $subscription
     *
     * @return string The formatted subscription resource.
     * @experimental
     */
    public static function formatSubscriptionName($project, $subscription)
    {
        return self::getSubscriptionNameTemplate()->render([
            'project' => $project,
            'subscription' => $subscription,
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
     * represents a snapshot resource.
     *
     * @param string $snapshotName The fully-qualified snapshot resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromSnapshotName($snapshotName)
    {
        return self::getSnapshotNameTemplate()->match($snapshotName)['project'];
    }

    /**
     * Parses the snapshot from the given fully-qualified path which
     * represents a snapshot resource.
     *
     * @param string $snapshotName The fully-qualified snapshot resource.
     *
     * @return string The extracted snapshot value.
     * @experimental
     */
    public static function parseSnapshotFromSnapshotName($snapshotName)
    {
        return self::getSnapshotNameTemplate()->match($snapshotName)['snapshot'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a subscription resource.
     *
     * @param string $subscriptionName The fully-qualified subscription resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromSubscriptionName($subscriptionName)
    {
        return self::getSubscriptionNameTemplate()->match($subscriptionName)['project'];
    }

    /**
     * Parses the subscription from the given fully-qualified path which
     * represents a subscription resource.
     *
     * @param string $subscriptionName The fully-qualified subscription resource.
     *
     * @return string The extracted subscription value.
     * @experimental
     */
    public static function parseSubscriptionFromSubscriptionName($subscriptionName)
    {
        return self::getSubscriptionNameTemplate()->match($subscriptionName)['subscription'];
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

    private static function getSnapshotNameTemplate()
    {
        if (self::$snapshotNameTemplate == null) {
            self::$snapshotNameTemplate = new PathTemplate('projects/{project}/snapshots/{snapshot}');
        }

        return self::$snapshotNameTemplate;
    }

    private static function getSubscriptionNameTemplate()
    {
        if (self::$subscriptionNameTemplate == null) {
            self::$subscriptionNameTemplate = new PathTemplate('projects/{project}/subscriptions/{subscription}');
        }

        return self::$subscriptionNameTemplate;
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
        $listSubscriptionsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubscriptions',
                ]);
        $listSnapshotsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnapshots',
                ]);

        $pageStreamingDescriptors = [
            'listSubscriptions' => $listSubscriptionsPageStreamingDescriptor,
            'listSnapshots' => $listSnapshotsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getGrpcStreamingDescriptors()
    {
        return [
            'streamingPull' => [
                'grpcStreamingType' => 'BidiStreaming',
                'resourcesGetMethod' => 'getReceivedMessages',
            ],
        ];
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
            'createSubscription' => $defaultDescriptors,
            'getSubscription' => $defaultDescriptors,
            'updateSubscription' => $defaultDescriptors,
            'listSubscriptions' => $defaultDescriptors,
            'deleteSubscription' => $defaultDescriptors,
            'modifyAckDeadline' => $defaultDescriptors,
            'acknowledge' => $defaultDescriptors,
            'pull' => $defaultDescriptors,
            'streamingPull' => $defaultDescriptors,
            'modifyPushConfig' => $defaultDescriptors,
            'listSnapshots' => $defaultDescriptors,
            'createSnapshot' => $defaultDescriptors,
            'deleteSnapshot' => $defaultDescriptors,
            'seek' => $defaultDescriptors,
            'setIamPolicy' => $defaultDescriptors,
            'getIamPolicy' => $defaultDescriptors,
            'testIamPermissions' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }
        $grpcStreamingDescriptors = self::getGrpcStreamingDescriptors();
        foreach ($grpcStreamingDescriptors as $method => $grpcStreamingDescriptor) {
            $this->descriptors[$method]['grpcStreamingDescriptor'] = $grpcStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/subscriber_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.pubsub.v1.Subscriber',
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
        $createSubscriberStubFunction = function ($hostname, $opts) {
            return new SubscriberGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createSubscriberStubFunction', $options)) {
            $createSubscriberStubFunction = $options['createSubscriberStubFunction'];
        }
        $this->subscriberStub = $this->grpcCredentialsHelper->createStub(
            $createSubscriberStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Creates a subscription to a given topic.
     * If the subscription already exists, returns `ALREADY_EXISTS`.
     * If the corresponding topic doesn't exist, returns `NOT_FOUND`.
     *
     * If the name is not provided in the request, the server will assign a random
     * name for this subscription on the same project as the topic, conforming
     * to the
     * [resource name format](https://cloud.google.com/pubsub/docs/overview#names).
     * The generated name is populated in the returned Subscription object.
     * Note that for REST API requests, you must specify a name in the request.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedName = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $formattedTopic = SubscriberClient::formatTopicName("[PROJECT]", "[TOPIC]");
     *     $response = $subscriberClient->createSubscription($formattedName, $formattedTopic);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the subscription. It must have the format
     *                             `"projects/{project}/subscriptions/{subscription}"`. `{subscription}` must
     *                             start with a letter, and contain only letters (`[A-Za-z]`), numbers
     *                             (`[0-9]`), dashes (`-`), underscores (`_`), periods (`.`), tildes (`~`),
     *                             plus (`+`) or percent signs (`%`). It must be between 3 and 255 characters
     *                             in length, and it must not start with `"goog"`.
     * @param string $topic        The name of the topic from which this subscription is receiving messages.
     *                             Format is `projects/{project}/topics/{topic}`.
     *                             The value of this field will be `_deleted-topic_` if the topic has been
     *                             deleted.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type PushConfig $pushConfig
     *          If push delivery is used with this subscription, this field is
     *          used to configure it. An empty `pushConfig` signifies that the subscriber
     *          will pull and ack messages using API methods.
     *     @type int $ackDeadlineSeconds
     *          This value is the maximum time after a subscriber receives a message
     *          before the subscriber should acknowledge the message. After message
     *          delivery but before the ack deadline expires and before the message is
     *          acknowledged, it is an outstanding message and will not be delivered
     *          again during that time (on a best-effort basis).
     *
     *          For pull subscriptions, this value is used as the initial value for the ack
     *          deadline. To override this value for a given message, call
     *          `ModifyAckDeadline` with the corresponding `ack_id` if using
     *          pull.
     *          The minimum custom deadline you can specify is 10 seconds.
     *          The maximum custom deadline you can specify is 600 seconds (10 minutes).
     *          If this parameter is 0, a default value of 10 seconds is used.
     *
     *          For push delivery, this value is also used to set the request timeout for
     *          the call to the push endpoint.
     *
     *          If the subscriber never acknowledges the message, the Pub/Sub
     *          system will eventually redeliver the message.
     *     @type bool $retainAckedMessages
     *          Indicates whether to retain acknowledged messages. If true, then
     *          messages are not expunged from the subscription's backlog, even if they are
     *          acknowledged, until they fall out of the `message_retention_duration`
     *          window.
     *     @type Duration $messageRetentionDuration
     *          How long to retain unacknowledged messages in the subscription's backlog,
     *          from the moment a message is published.
     *          If `retain_acked_messages` is true, then this also configures the retention
     *          of acknowledged messages, and thus configures how far back in time a `Seek`
     *          can be done. Defaults to 7 days. Cannot be more than 7 days or less than 10
     *          minutes.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\Subscription
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createSubscription($name, $topic, $optionalArgs = [])
    {
        $request = new Subscription();
        $request->setName($name);
        $request->setTopic($topic);
        if (isset($optionalArgs['pushConfig'])) {
            $request->setPushConfig($optionalArgs['pushConfig']);
        }
        if (isset($optionalArgs['ackDeadlineSeconds'])) {
            $request->setAckDeadlineSeconds($optionalArgs['ackDeadlineSeconds']);
        }
        if (isset($optionalArgs['retainAckedMessages'])) {
            $request->setRetainAckedMessages($optionalArgs['retainAckedMessages']);
        }
        if (isset($optionalArgs['messageRetentionDuration'])) {
            $request->setMessageRetentionDuration($optionalArgs['messageRetentionDuration']);
        }

        $mergedSettings = $this->defaultCallSettings['createSubscription']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'CreateSubscription',
            $mergedSettings,
            $this->descriptors['createSubscription']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the configuration details of a subscription.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $response = $subscriberClient->getSubscription($formattedSubscription);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $subscription The name of the subscription to get.
     *                             Format is `projects/{project}/subscriptions/{sub}`.
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
     * @return \Google\Pubsub\V1\Subscription
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getSubscription($subscription, $optionalArgs = [])
    {
        $request = new GetSubscriptionRequest();
        $request->setSubscription($subscription);

        $mergedSettings = $this->defaultCallSettings['getSubscription']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'GetSubscription',
            $mergedSettings,
            $this->descriptors['getSubscription']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates an existing subscription. Note that certain properties of a
     * subscription, such as its topic, are not modifiable.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $subscription = new Subscription();
     *     $updateMask = new FieldMask();
     *     $response = $subscriberClient->updateSubscription($subscription, $updateMask);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param Subscription $subscription The updated subscription object.
     * @param FieldMask    $updateMask   Indicates which fields in the provided subscription to update.
     *                                   Must be specified and non-empty.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\Subscription
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function updateSubscription($subscription, $updateMask, $optionalArgs = [])
    {
        $request = new UpdateSubscriptionRequest();
        $request->setSubscription($subscription);
        $request->setUpdateMask($updateMask);

        $mergedSettings = $this->defaultCallSettings['updateSubscription']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'UpdateSubscription',
            $mergedSettings,
            $this->descriptors['updateSubscription']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists matching subscriptions.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedProject = SubscriberClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $subscriberClient->listSubscriptions($formattedProject);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $subscriberClient->listSubscriptions($formattedProject, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $project      The name of the cloud project that subscriptions belong to.
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
    public function listSubscriptions($project, $optionalArgs = [])
    {
        $request = new ListSubscriptionsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listSubscriptions']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'ListSubscriptions',
            $mergedSettings,
            $this->descriptors['listSubscriptions']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes an existing subscription. All messages retained in the subscription
     * are immediately dropped. Calls to `Pull` after deletion will return
     * `NOT_FOUND`. After a subscription is deleted, a new one may be created with
     * the same name, but the new one has no association with the old
     * subscription or its topic unless the same topic is specified.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $subscriberClient->deleteSubscription($formattedSubscription);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $subscription The subscription to delete.
     *                             Format is `projects/{project}/subscriptions/{sub}`.
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
    public function deleteSubscription($subscription, $optionalArgs = [])
    {
        $request = new DeleteSubscriptionRequest();
        $request->setSubscription($subscription);

        $mergedSettings = $this->defaultCallSettings['deleteSubscription']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'DeleteSubscription',
            $mergedSettings,
            $this->descriptors['deleteSubscription']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Modifies the ack deadline for a specific message. This method is useful
     * to indicate that more time is needed to process a message by the
     * subscriber, or to make the message available for redelivery if the
     * processing was interrupted. Note that this does not modify the
     * subscription-level `ackDeadlineSeconds` used for subsequent messages.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $ackIds = [];
     *     $ackDeadlineSeconds = 0;
     *     $subscriberClient->modifyAckDeadline($formattedSubscription, $ackIds, $ackDeadlineSeconds);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string   $subscription       The name of the subscription.
     *                                     Format is `projects/{project}/subscriptions/{sub}`.
     * @param string[] $ackIds             List of acknowledgment IDs.
     * @param int      $ackDeadlineSeconds The new ack deadline with respect to the time this request was sent to
     *                                     the Pub/Sub system. For example, if the value is 10, the new
     *                                     ack deadline will expire 10 seconds after the `ModifyAckDeadline` call
     *                                     was made. Specifying zero may immediately make the message available for
     *                                     another pull request.
     *                                     The minimum deadline you can specify is 0 seconds.
     *                                     The maximum deadline you can specify is 600 seconds (10 minutes).
     * @param array    $optionalArgs       {
     *                                     Optional.
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
    public function modifyAckDeadline($subscription, $ackIds, $ackDeadlineSeconds, $optionalArgs = [])
    {
        $request = new ModifyAckDeadlineRequest();
        $request->setSubscription($subscription);
        $request->setAckIds($ackIds);
        $request->setAckDeadlineSeconds($ackDeadlineSeconds);

        $mergedSettings = $this->defaultCallSettings['modifyAckDeadline']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'ModifyAckDeadline',
            $mergedSettings,
            $this->descriptors['modifyAckDeadline']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Acknowledges the messages associated with the `ack_ids` in the
     * `AcknowledgeRequest`. The Pub/Sub system can remove the relevant messages
     * from the subscription.
     *
     * Acknowledging a message whose ack deadline has expired may succeed,
     * but such a message may be redelivered later. Acknowledging a message more
     * than once will not result in an error.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $ackIds = [];
     *     $subscriberClient->acknowledge($formattedSubscription, $ackIds);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string   $subscription The subscription whose message is being acknowledged.
     *                               Format is `projects/{project}/subscriptions/{sub}`.
     * @param string[] $ackIds       The acknowledgment ID for the messages being acknowledged that was returned
     *                               by the Pub/Sub system in the `Pull` response. Must not be empty.
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
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function acknowledge($subscription, $ackIds, $optionalArgs = [])
    {
        $request = new AcknowledgeRequest();
        $request->setSubscription($subscription);
        $request->setAckIds($ackIds);

        $mergedSettings = $this->defaultCallSettings['acknowledge']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'Acknowledge',
            $mergedSettings,
            $this->descriptors['acknowledge']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Pulls messages from the server. Returns an empty list if there are no
     * messages available in the backlog. The server may return `UNAVAILABLE` if
     * there are too many concurrent pull requests pending for the given
     * subscription.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $maxMessages = 0;
     *     $response = $subscriberClient->pull($formattedSubscription, $maxMessages);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $subscription The subscription from which messages should be pulled.
     *                             Format is `projects/{project}/subscriptions/{sub}`.
     * @param int    $maxMessages  The maximum number of messages returned for this request. The Pub/Sub
     *                             system may return fewer than the number specified.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type bool $returnImmediately
     *          If this field set to true, the system will respond immediately even if
     *          it there are no messages available to return in the `Pull` response.
     *          Otherwise, the system may wait (for a bounded amount of time) until at
     *          least one message is available, rather than returning no messages. The
     *          client may cancel the request if it does not wish to wait any longer for
     *          the response.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\PullResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function pull($subscription, $maxMessages, $optionalArgs = [])
    {
        $request = new PullRequest();
        $request->setSubscription($subscription);
        $request->setMaxMessages($maxMessages);
        if (isset($optionalArgs['returnImmediately'])) {
            $request->setReturnImmediately($optionalArgs['returnImmediately']);
        }

        $mergedSettings = $this->defaultCallSettings['pull']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'Pull',
            $mergedSettings,
            $this->descriptors['pull']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * (EXPERIMENTAL) StreamingPull is an experimental feature. This RPC will
     * respond with UNIMPLEMENTED errors unless you have been invited to test
     * this feature. Contact cloud-pubsub&#64;google.com with any questions.
     *
     * Establishes a stream with the server, which sends messages down to the
     * client. The client streams acknowledgements and ack deadline modifications
     * back to the server. The server will close the stream and return the status
     * on any error. The server may close the stream with status `OK` to reassign
     * server-side resources, in which case, the client should re-establish the
     * stream. `UNAVAILABLE` may also be returned in the case of a transient error
     * (e.g., a server restart). These should also be retried by the client. Flow
     * control can be achieved by configuring the underlying RPC channel.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $streamAckDeadlineSeconds = 0;
     *     $request = new StreamingPullRequest();
     *     $request->setSubscription($formattedSubscription);
     *     $request->setStreamAckDeadlineSeconds($streamAckDeadlineSeconds);
     *     $requests = [$request];
     *
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $stream = $subscriberClient->streamingPull();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $stream = $subscriberClient->streamingPull();
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
     *     $subscriberClient->close();
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
     * @return \Google\GAX\BidiStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function streamingPull($optionalArgs = [])
    {
        $mergedSettings = $this->defaultCallSettings['streamingPull']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'StreamingPull',
            $mergedSettings,
            $this->descriptors['streamingPull']
        );

        return $callable(
            null,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Modifies the `PushConfig` for a specified subscription.
     *
     * This may be used to change a push subscription to a pull one (signified by
     * an empty `PushConfig`) or vice versa, or change the endpoint URL and other
     * attributes of a push subscription. Messages will accumulate for delivery
     * continuously through the call regardless of changes to the `PushConfig`.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $pushConfig = new PushConfig();
     *     $subscriberClient->modifyPushConfig($formattedSubscription, $pushConfig);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string     $subscription The name of the subscription.
     *                                 Format is `projects/{project}/subscriptions/{sub}`.
     * @param PushConfig $pushConfig   The push configuration for future deliveries.
     *
     * An empty `pushConfig` indicates that the Pub/Sub system should
     * stop pushing messages from the given subscription and allow
     * messages to be pulled and acknowledged - effectively pausing
     * the subscription if `Pull` is not called.
     * @param array $optionalArgs {
     *                            Optional.
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
    public function modifyPushConfig($subscription, $pushConfig, $optionalArgs = [])
    {
        $request = new ModifyPushConfigRequest();
        $request->setSubscription($subscription);
        $request->setPushConfig($pushConfig);

        $mergedSettings = $this->defaultCallSettings['modifyPushConfig']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'ModifyPushConfig',
            $mergedSettings,
            $this->descriptors['modifyPushConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the existing snapshots.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedProject = SubscriberClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $subscriberClient->listSnapshots($formattedProject);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $subscriberClient->listSnapshots($formattedProject, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $project      The name of the cloud project that snapshots belong to.
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
    public function listSnapshots($project, $optionalArgs = [])
    {
        $request = new ListSnapshotsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listSnapshots']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'ListSnapshots',
            $mergedSettings,
            $this->descriptors['listSnapshots']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a snapshot from the requested subscription.
     * If the snapshot already exists, returns `ALREADY_EXISTS`.
     * If the requested subscription doesn't exist, returns `NOT_FOUND`.
     *
     * If the name is not provided in the request, the server will assign a random
     * name for this snapshot on the same project as the subscription, conforming
     * to the
     * [resource name format](https://cloud.google.com/pubsub/docs/overview#names).
     * The generated name is populated in the returned Snapshot object.
     * Note that for REST API requests, you must specify a name in the request.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedName = SubscriberClient::formatSnapshotName("[PROJECT]", "[SNAPSHOT]");
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $response = $subscriberClient->createSnapshot($formattedName, $formattedSubscription);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $name         Optional user-provided name for this snapshot.
     *                             If the name is not provided in the request, the server will assign a random
     *                             name for this snapshot on the same project as the subscription.
     *                             Note that for REST API requests, you must specify a name.
     *                             Format is `projects/{project}/snapshots/{snap}`.
     * @param string $subscription The subscription whose backlog the snapshot retains.
     *                             Specifically, the created snapshot is guaranteed to retain:
     *                             (a) The existing backlog on the subscription. More precisely, this is
     *                             defined as the messages in the subscription's backlog that are
     *                             unacknowledged upon the successful completion of the
     *                             `CreateSnapshot` request; as well as:
     *                             (b) Any messages published to the subscription's topic following the
     *                             successful completion of the CreateSnapshot request.
     *                             Format is `projects/{project}/subscriptions/{sub}`.
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
     * @return \Google\Pubsub\V1\Snapshot
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createSnapshot($name, $subscription, $optionalArgs = [])
    {
        $request = new CreateSnapshotRequest();
        $request->setName($name);
        $request->setSubscription($subscription);

        $mergedSettings = $this->defaultCallSettings['createSnapshot']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'CreateSnapshot',
            $mergedSettings,
            $this->descriptors['createSnapshot']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Removes an existing snapshot. All messages retained in the snapshot
     * are immediately dropped. After a snapshot is deleted, a new one may be
     * created with the same name, but the new one has no association with the old
     * snapshot or its subscription, unless the same subscription is specified.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSnapshot = SubscriberClient::formatSnapshotName("[PROJECT]", "[SNAPSHOT]");
     *     $subscriberClient->deleteSnapshot($formattedSnapshot);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $snapshot     The name of the snapshot to delete.
     *                             Format is `projects/{project}/snapshots/{snap}`.
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
    public function deleteSnapshot($snapshot, $optionalArgs = [])
    {
        $request = new DeleteSnapshotRequest();
        $request->setSnapshot($snapshot);

        $mergedSettings = $this->defaultCallSettings['deleteSnapshot']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'DeleteSnapshot',
            $mergedSettings,
            $this->descriptors['deleteSnapshot']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Seeks an existing subscription to a point in time or to a given snapshot,
     * whichever is provided in the request.
     *
     * Sample code:
     * ```
     * try {
     *     $subscriberClient = new SubscriberClient();
     *     $formattedSubscription = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $response = $subscriberClient->seek($formattedSubscription);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param string $subscription The subscription to affect.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Timestamp $time
     *          The time to seek to.
     *          Messages retained in the subscription that were published before this
     *          time are marked as acknowledged, and messages retained in the
     *          subscription that were published after this time are marked as
     *          unacknowledged. Note that this operation affects only those messages
     *          retained in the subscription (configured by the combination of
     *          `message_retention_duration` and `retain_acked_messages`). For example,
     *          if `time` corresponds to a point before the message retention
     *          window (or to a point before the system's notion of the subscription
     *          creation time), only retained messages will be marked as unacknowledged,
     *          and already-expunged messages will not be restored.
     *     @type string $snapshot
     *          The snapshot to seek to. The snapshot's topic must be the same as that of
     *          the provided subscription.
     *          Format is `projects/{project}/snapshots/{snap}`.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Pubsub\V1\SeekResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function seek($subscription, $optionalArgs = [])
    {
        $request = new SeekRequest();
        $request->setSubscription($subscription);
        if (isset($optionalArgs['time'])) {
            $request->setTime($optionalArgs['time']);
        }
        if (isset($optionalArgs['snapshot'])) {
            $request->setSnapshot($optionalArgs['snapshot']);
        }

        $mergedSettings = $this->defaultCallSettings['seek']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->subscriberStub,
            'Seek',
            $mergedSettings,
            $this->descriptors['seek']
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
     *     $subscriberClient = new SubscriberClient();
     *     $formattedResource = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $policy = new Policy();
     *     $response = $subscriberClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $subscriberClient->close();
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
     *     $subscriberClient = new SubscriberClient();
     *     $formattedResource = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $response = $subscriberClient->getIamPolicy($formattedResource);
     * } finally {
     *     $subscriberClient->close();
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
     *     $subscriberClient = new SubscriberClient();
     *     $formattedResource = SubscriberClient::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $permissions = [];
     *     $response = $subscriberClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $subscriberClient->close();
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
        $this->subscriberStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
