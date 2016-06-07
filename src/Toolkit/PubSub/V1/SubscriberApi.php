<?php
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/pubsub/v1/pubsub.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Toolkit\PubSub\V1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcBootstrap;
use Google\GAX\GrpcConstants;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use google\pubsub\v1\AcknowledgeRequest;
use google\pubsub\v1\DeleteSubscriptionRequest;
use google\pubsub\v1\GetSubscriptionRequest;
use google\pubsub\v1\ListSubscriptionsRequest;
use google\pubsub\v1\ModifyAckDeadlineRequest;
use google\pubsub\v1\ModifyPushConfigRequest;
use google\pubsub\v1\PullRequest;
use google\pubsub\v1\PushConfig;
use google\pubsub\v1\SubscriberClient;
use google\pubsub\v1\Subscription;

/**
 * Service Description: The service that an application uses to manipulate subscriptions and to
 * consume messages from a subscription via the `Pull` method.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * <pre>
 * <code>
 * try {
 *     $subscriberApi = new SubscriberApi();
 *     $formattedName = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
 *     $formattedTopic = SubscriberApi::formatTopicName("[PROJECT]", "[TOPIC]");
 *     $response = $subscriberApi->createSubscription($formattedName, $formattedTopic);
 * } finally {
 *     if (isset($subscriberApi)) {
 *         $subscriberApi->close();
 *     }
 * }
 * </code>
 * </pre>
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class SubscriberApi
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

    const _GAX_VERSION = '0.1.0';
    const _CODEGEN_NAME = 'GAPIC';
    const _CODEGEN_VERSION = '0.0.0';

    private static $projectNameTemplate;
    private static $subscriptionNameTemplate;
    private static $topicNameTemplate;

    private $grpcBootstrap;
    private $stub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     */
    public static function formatProjectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a subscription resource.
     */
    public static function formatSubscriptionName($project, $subscription)
    {
        return self::getSubscriptionNameTemplate()->render([
            'project' => $project, 'subscription' => $subscription,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a topic resource.
     */
    public static function formatTopicName($project, $topic)
    {
        return self::getTopicNameTemplate()->render([
            'project' => $project, 'topic' => $topic,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a project resource.
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a subscription resource.
     */
    public static function parseProjectFromSubscriptionName($subscriptionName)
    {
        return self::getSubscriptionNameTemplate()->match($subscriptionName)['project'];
    }

    /**
     * Parses the subscription from the given fully-qualified path which
     * represents a subscription resource.
     */
    public static function parseSubscriptionFromSubscriptionName($subscriptionName)
    {
        return self::getSubscriptionNameTemplate()->match($subscriptionName)['subscription'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a topic resource.
     */
    public static function parseProjectFromTopicName($topicName)
    {
        return self::getTopicNameTemplate()->match($topicName)['project'];
    }

    /**
     * Parses the topic from the given fully-qualified path which
     * represents a topic resource.
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
                    'requestPageTokenField' => 'page_token',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'subscriptions',
                ]);

        $pageStreamingDescriptors = [
            'listSubscriptions' => $listSubscriptionsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @var string $serviceAddress The domain name of the API remote host.
     *                                  Default 'pubsub.googleapis.com'.
     *     @var mixed $port The port on which to connect to the remote host. Default 443.
     *     @var Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     *     @var array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Pub/Sub API.
     *     @var array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @var int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @var string $appName The codename of the calling service. Default 'gax'.
     *     @var string $appVersion The version of the calling service.
     *                              Default: the current version of GAX.
     * }
     */
    public function __construct($options = [])
    {
        $defaultScopes = [
            'https://www.googleapis.com/auth/pubsub',
            'https://www.googleapis.com/auth/cloud-platform',
        ];
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => $defaultScopes,
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'appName' => 'gax',
            'appVersion' => self::_GAX_VERSION,
        ];
        $options = array_merge($defaultOptions, $options);

        $headerDescriptor = new AgentHeaderDescriptor([
            'clientName' => $options['appName'],
            'clientVersion' => $options['appVersion'],
            'codeGenName' => self::_CODEGEN_NAME,
            'codeGenVersion' => self::_CODEGEN_VERSION,
            'gaxVersion' => self::_GAX_VERSION,
            'phpVersion' => phpversion(),
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'createSubscription' => $defaultDescriptors,
            'getSubscription' => $defaultDescriptors,
            'listSubscriptions' => $defaultDescriptors,
            'deleteSubscription' => $defaultDescriptors,
            'modifyAckDeadline' => $defaultDescriptors,
            'acknowledge' => $defaultDescriptors,
            'pull' => $defaultDescriptors,
            'modifyPushConfig' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        // TODO load the client config in a more package-friendly way
        $clientConfigJsonString = file_get_contents('./resources/subscriber_client_config.json');
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

        $generatedCreateStub = function ($hostname, $opts) {
            return new SubscriberClient($hostname, $opts);
        };
        $createStubOptions = [];
        if (!empty($options['sslCreds'])) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcBootstrap = GrpcBootstrap::defaultInstance();
        $this->stub = $this->grpcBootstrap->createStub(
            $generatedCreateStub,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Creates a subscription to a given topic for a given subscriber.
     * If the subscription already exists, returns `ALREADY_EXISTS`.
     * If the corresponding topic doesn't exist, returns `NOT_FOUND`.
     *
     * If the name is not provided in the request, the server will assign a random
     * name for this subscription on the same project as the topic.
     *
     * Sample code:
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedName = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $formattedTopic = SubscriberApi::formatTopicName("[PROJECT]", "[TOPIC]");
     *     $response = $subscriberApi->createSubscription($formattedName, $formattedTopic);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $name         The name of the subscription. It must have the format
     *                             `"projects/{project}/subscriptions/{subscription}"`. `{subscription}` must
     *                             start with a letter, and contain only letters (`[A-Za-z]`), numbers
     *                             (`[0-9]`), dashes (`-`), underscores (`_`), periods (`.`), tildes (`~`),
     *                             plus (`+`) or percent signs (`%`). It must be between 3 and 255 characters
     *                             in length, and it must not start with `"goog"`.
     * @param string $topic        The name of the topic from which this subscription is receiving messages.
     *                             The value of this field will be `_deleted-topic_` if the topic has been
     *                             deleted.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @var PushConfig $pushConfig If push delivery is used with this subscription, this field is
     *           used to configure it. An empty `pushConfig` signifies that the subscriber
     *           will pull and ack messages using API methods.
     *     @var int $ackDeadlineSeconds This value is the maximum time after a subscriber receives a message
     *           before the subscriber should acknowledge the message. After message
     *           delivery but before the ack deadline expires and before the message is
     *           acknowledged, it is an outstanding message and will not be delivered
     *           again during that time (on a best-effort basis).
     *
     *           For pull subscriptions, this value is used as the initial value for the ack
     *           deadline. To override this value for a given message, call
     *           `ModifyAckDeadline` with the corresponding `ack_id` if using
     *           pull.
     *
     *           For push delivery, this value is also used to set the request timeout for
     *           the call to the push endpoint.
     *
     *           If the subscriber never acknowledges the message, the Pub/Sub
     *           system will eventually redeliver the message.
     *
     *           If this parameter is not set, the default value of 10 seconds is used.
     * }
     *
     * @param array $callSettings {
     *                            Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\pubsub\v1\Subscription
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function createSubscription($name, $topic, $optionalArgs = [], $callSettings = [])
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

        $mergedSettings = $this->defaultCallSettings['createSubscription']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedSubscription = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $response = $subscriberApi->getSubscription($formattedSubscription);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $subscription The name of the subscription to get.
     * @param array  $optionalArgs {
     *                             Optional. There are no optional parameters for this method yet;
     *                             this $optionalArgs parameter reserves a spot for future ones.
     *                             }
     * @param array  $callSettings {
     *                             Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\pubsub\v1\Subscription
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function getSubscription($subscription, $optionalArgs = [], $callSettings = [])
    {
        $request = new GetSubscriptionRequest();
        $request->setSubscription($subscription);

        $mergedSettings = $this->defaultCallSettings['getSubscription']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * Lists matching subscriptions.
     *
     * Sample code:
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedProject = SubscriberApi::formatProjectName("[PROJECT]");
     *     for ($subscriberApi->listSubscriptions($formattedProject) as element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $project      The name of the cloud project that subscriptions belong to.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @var int $pageSize Maximum number of subscriptions to return.
     * }
     *
     * @param array $callSettings {
     *                            Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return Google\GAX\PageAccessor
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function listSubscriptions($project, $optionalArgs = [], $callSettings = [])
    {
        $request = new ListSubscriptionsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $mergedSettings = $this->defaultCallSettings['listSubscriptions']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * Deletes an existing subscription. All pending messages in the subscription
     * are immediately dropped. Calls to `Pull` after deletion will return
     * `NOT_FOUND`. After a subscription is deleted, a new one may be created with
     * the same name, but the new one has no association with the old
     * subscription, or its topic unless the same topic is specified.
     *
     * Sample code:
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedSubscription = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $subscriberApi->deleteSubscription($formattedSubscription);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $subscription The subscription to delete.
     * @param array  $optionalArgs {
     *                             Optional. There are no optional parameters for this method yet;
     *                             this $optionalArgs parameter reserves a spot for future ones.
     *                             }
     * @param array  $callSettings {
     *                             Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function deleteSubscription($subscription, $optionalArgs = [], $callSettings = [])
    {
        $request = new DeleteSubscriptionRequest();
        $request->setSubscription($subscription);

        $mergedSettings = $this->defaultCallSettings['deleteSubscription']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * processing was interrupted.
     *
     * Sample code:
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedSubscription = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $ackIds = [];
     *     $ackDeadlineSeconds = 0;
     *     $subscriberApi->modifyAckDeadline($formattedSubscription, $ackIds, $ackDeadlineSeconds);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $subscription       The name of the subscription.
     * @param array  $ackIds             List of acknowledgment IDs.
     * @param int    $ackDeadlineSeconds The new ack deadline with respect to the time this request was sent to
     *                                   the Pub/Sub system. Must be >= 0. For example, if the value is 10, the new
     *                                   ack deadline will expire 10 seconds after the `ModifyAckDeadline` call
     *                                   was made. Specifying zero may immediately make the message available for
     *                                   another pull request.
     * @param array  $optionalArgs       {
     *                                   Optional. There are no optional parameters for this method yet;
     *                                   this $optionalArgs parameter reserves a spot for future ones.
     *                                   }
     * @param array  $callSettings       {
     *                                   Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function modifyAckDeadline($subscription, $ackIds, $ackDeadlineSeconds, $optionalArgs = [], $callSettings = [])
    {
        $request = new ModifyAckDeadlineRequest();
        $request->setSubscription($subscription);
        foreach ($ackIds as $elem) {
            $request->addAckIds($elem);
        }
        $request->setAckDeadlineSeconds($ackDeadlineSeconds);

        $mergedSettings = $this->defaultCallSettings['modifyAckDeadline']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedSubscription = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $ackIds = [];
     *     $subscriberApi->acknowledge($formattedSubscription, $ackIds);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $subscription The subscription whose message is being acknowledged.
     * @param array  $ackIds       The acknowledgment ID for the messages being acknowledged that was returned
     *                             by the Pub/Sub system in the `Pull` response. Must not be empty.
     * @param array  $optionalArgs {
     *                             Optional. There are no optional parameters for this method yet;
     *                             this $optionalArgs parameter reserves a spot for future ones.
     *                             }
     * @param array  $callSettings {
     *                             Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function acknowledge($subscription, $ackIds, $optionalArgs = [], $callSettings = [])
    {
        $request = new AcknowledgeRequest();
        $request->setSubscription($subscription);
        foreach ($ackIds as $elem) {
            $request->addAckIds($elem);
        }

        $mergedSettings = $this->defaultCallSettings['acknowledge']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedSubscription = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $maxMessages = 0;
     *     $response = $subscriberApi->pull($formattedSubscription, $maxMessages);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string $subscription The subscription from which messages should be pulled.
     * @param int    $maxMessages  The maximum number of messages returned for this request. The Pub/Sub
     *                             system may return fewer than the number specified.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @var bool $returnImmediately If this is specified as true the system will respond immediately even if
     *           it is not able to return a message in the `Pull` response. Otherwise the
     *           system is allowed to wait until at least one message is available rather
     *           than returning no messages. The client may cancel the request if it does
     *           not wish to wait any longer for the response.
     * }
     *
     * @param array $callSettings {
     *                            Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\pubsub\v1\PullResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function pull($subscription, $maxMessages, $optionalArgs = [], $callSettings = [])
    {
        $request = new PullRequest();
        $request->setSubscription($subscription);
        $request->setMaxMessages($maxMessages);
        if (isset($optionalArgs['returnImmediately'])) {
            $request->setReturnImmediately($optionalArgs['returnImmediately']);
        }

        $mergedSettings = $this->defaultCallSettings['pull']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * Modifies the `PushConfig` for a specified subscription.
     *
     * This may be used to change a push subscription to a pull one (signified by
     * an empty `PushConfig`) or vice versa, or change the endpoint URL and other
     * attributes of a push subscription. Messages will accumulate for delivery
     * continuously through the call regardless of changes to the `PushConfig`.
     *
     * Sample code:
     * <pre><code>
     * try {
     *     $subscriberApi = new SubscriberApi();
     *     $formattedSubscription = SubscriberApi::formatSubscriptionName("[PROJECT]", "[SUBSCRIPTION]");
     *     $pushConfig = new PushConfig();
     *     $subscriberApi->modifyPushConfig($formattedSubscription, $pushConfig);
     * } finally {
     *     if (isset($subscriberApi)) {
     *         $subscriberApi->close();
     *     }
     * }
     * </code></pre>
     *
     * @param string     $subscription The name of the subscription.
     * @param PushConfig $pushConfig   The push configuration for future deliveries.
     *
     * An empty `pushConfig` indicates that the Pub/Sub system should
     * stop pushing messages from the given subscription and allow
     * messages to be pulled and acknowledged - effectively pausing
     * the subscription if `Pull` is not called.
     * @param array $optionalArgs {
     *                            Optional. There are no optional parameters for this method yet;
     *                            this $optionalArgs parameter reserves a spot for future ones.
     *                            }
     * @param array $callSettings {
     *                            Optional.
     *
     *    @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeout is ignored.
     *    @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function modifyPushConfig($subscription, $pushConfig, $optionalArgs = [], $callSettings = [])
    {
        $request = new ModifyPushConfigRequest();
        $request->setSubscription($subscription);
        $request->setPushConfig($pushConfig);

        $mergedSettings = $this->defaultCallSettings['modifyPushConfig']->merge(
            new CallSettings($callSettings)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     */
    public function close()
    {
        $this->stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcBootstrap->createCallCredentialsCallback($this->scopes);
    }
}
