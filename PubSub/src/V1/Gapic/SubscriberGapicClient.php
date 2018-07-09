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
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\PubSub\V1\AcknowledgeRequest;
use Google\Cloud\PubSub\V1\CreateSnapshotRequest;
use Google\Cloud\PubSub\V1\DeleteSnapshotRequest;
use Google\Cloud\PubSub\V1\DeleteSubscriptionRequest;
use Google\Cloud\PubSub\V1\GetSubscriptionRequest;
use Google\Cloud\PubSub\V1\ListSnapshotsRequest;
use Google\Cloud\PubSub\V1\ListSnapshotsResponse;
use Google\Cloud\PubSub\V1\ListSubscriptionsRequest;
use Google\Cloud\PubSub\V1\ListSubscriptionsResponse;
use Google\Cloud\PubSub\V1\ModifyAckDeadlineRequest;
use Google\Cloud\PubSub\V1\ModifyPushConfigRequest;
use Google\Cloud\PubSub\V1\PullRequest;
use Google\Cloud\PubSub\V1\PullResponse;
use Google\Cloud\PubSub\V1\PushConfig;
use Google\Cloud\PubSub\V1\SeekRequest;
use Google\Cloud\PubSub\V1\SeekResponse;
use Google\Cloud\PubSub\V1\Snapshot;
use Google\Cloud\PubSub\V1\StreamingPullRequest;
use Google\Cloud\PubSub\V1\StreamingPullResponse;
use Google\Cloud\PubSub\V1\Subscription;
use Google\Cloud\PubSub\V1\UpdateSnapshotRequest;
use Google\Cloud\PubSub\V1\UpdateSubscriptionRequest;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;

/**
 * Service Description: The service that an application uses to manipulate subscriptions and to
 * consume messages from a subscription via the `Pull` method or by
 * establishing a bi-directional stream using the `StreamingPull` method.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $subscriberClient = new SubscriberClient();
 * try {
 *     $formattedName = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
 *     $formattedTopic = $subscriberClient->topicName('[PROJECT]', '[TOPIC]');
 *     $response = $subscriberClient->createSubscription($formattedName, $formattedTopic);
 * } finally {
 *     $subscriberClient->close();
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
class SubscriberGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.pubsub.v1.Subscriber';

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
    private static $subscriptionNameTemplate;
    private static $topicNameTemplate;
    private static $projectNameTemplate;
    private static $snapshotNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/subscriber_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/subscriber_descriptor_config.php',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/subscriber_rest_client_config.php',
                ],
            ],
        ];
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

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'subscription' => self::getSubscriptionNameTemplate(),
                'topic' => self::getTopicNameTemplate(),
                'project' => self::getProjectNameTemplate(),
                'snapshot' => self::getSnapshotNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
    public static function subscriptionName($project, $subscription)
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
    public static function topicName($project, $topic)
    {
        return self::getTopicNameTemplate()->render([
            'project' => $project,
            'topic' => $topic,
        ]);
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
     * a snapshot resource.
     *
     * @param string $project
     * @param string $snapshot
     *
     * @return string The formatted snapshot resource.
     * @experimental
     */
    public static function snapshotName($project, $snapshot)
    {
        return self::getSnapshotNameTemplate()->render([
            'project' => $project,
            'snapshot' => $snapshot,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - subscription: projects/{project}/subscriptions/{subscription}
     * - topic: projects/{project}/topics/{topic}
     * - project: projects/{project}
     * - snapshot: projects/{project}/snapshots/{snapshot}.
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
     *           object is provided, any settings in $transportConfig, and any $serviceAddress
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
     * Creates a subscription to a given topic. See the
     * <a href="/pubsub/docs/admin#resource_names"> resource name rules</a>.
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedName = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
     *     $formattedTopic = $subscriberClient->topicName('[PROJECT]', '[TOPIC]');
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
     *                             in length, and it must not start with `"goog"`
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
     *          non-streaming pull or send the `ack_id` in a
     *          `StreamingModifyAckDeadlineRequest` if using streaming pull.
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
     *          window.<br><br>
     *          <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     *          changed in backward-incompatible ways and is not recommended for production
     *          use. It is not subject to any SLA or deprecation policy.
     *     @type Duration $messageRetentionDuration
     *          How long to retain unacknowledged messages in the subscription's backlog,
     *          from the moment a message is published.
     *          If `retain_acked_messages` is true, then this also configures the retention
     *          of acknowledged messages, and thus configures how far back in time a `Seek`
     *          can be done. Defaults to 7 days. Cannot be more than 7 days or less than 10
     *          minutes.<br><br>
     *          <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     *          changed in backward-incompatible ways and is not recommended for production
     *          use. It is not subject to any SLA or deprecation policy.
     *     @type array $labels
     *          User labels.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Subscription
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSubscription($name, $topic, array $optionalArgs = [])
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
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }

        return $this->startCall(
            'CreateSubscription',
            Subscription::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the configuration details of a subscription.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Subscription
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSubscription($subscription, array $optionalArgs = [])
    {
        $request = new GetSubscriptionRequest();
        $request->setSubscription($subscription);

        return $this->startCall(
            'GetSubscription',
            Subscription::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing subscription. Note that certain properties of a
     * subscription, such as its topic, are not modifiable.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $ackDeadlineSeconds = 42;
     *     $subscription = new Subscription();
     *     $subscription->setAckDeadlineSeconds($ackDeadlineSeconds);
     *     $pathsElement = 'ack_deadline_seconds';
     *     $paths = [$pathsElement];
     *     $updateMask = new FieldMask();
     *     $updateMask->setPaths($paths);
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Subscription
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateSubscription($subscription, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateSubscriptionRequest();
        $request->setSubscription($subscription);
        $request->setUpdateMask($updateMask);

        return $this->startCall(
            'UpdateSubscription',
            Subscription::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists matching subscriptions.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedProject = $subscriberClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $subscriberClient->listSubscriptions($formattedProject);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $subscriberClient->listSubscriptions($formattedProject);
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
    public function listSubscriptions($project, array $optionalArgs = [])
    {
        $request = new ListSubscriptionsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListSubscriptions',
            $optionalArgs,
            ListSubscriptionsResponse::class,
            $request
        );
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
    public function deleteSubscription($subscription, array $optionalArgs = [])
    {
        $request = new DeleteSubscriptionRequest();
        $request->setSubscription($subscription);

        return $this->startCall(
            'DeleteSubscription',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
    public function modifyAckDeadline($subscription, $ackIds, $ackDeadlineSeconds, array $optionalArgs = [])
    {
        $request = new ModifyAckDeadlineRequest();
        $request->setSubscription($subscription);
        $request->setAckIds($ackIds);
        $request->setAckDeadlineSeconds($ackDeadlineSeconds);

        return $this->startCall(
            'ModifyAckDeadline',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
    public function acknowledge($subscription, $ackIds, array $optionalArgs = [])
    {
        $request = new AcknowledgeRequest();
        $request->setSubscription($subscription);
        $request->setAckIds($ackIds);

        return $this->startCall(
            'Acknowledge',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Pulls messages from the server. Returns an empty list if there are no
     * messages available in the backlog. The server may return `UNAVAILABLE` if
     * there are too many concurrent pull requests pending for the given
     * subscription.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\PullResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function pull($subscription, $maxMessages, array $optionalArgs = [])
    {
        $request = new PullRequest();
        $request->setSubscription($subscription);
        $request->setMaxMessages($maxMessages);
        if (isset($optionalArgs['returnImmediately'])) {
            $request->setReturnImmediately($optionalArgs['returnImmediately']);
        }

        return $this->startCall(
            'Pull',
            PullResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Establishes a stream with the server, which sends messages down to the
     * client. The client streams acknowledgements and ack deadline modifications
     * back to the server. The server will close the stream and return the status
     * on any error. The server may close the stream with status `UNAVAILABLE` to
     * reassign server-side resources, in which case, the client should
     * re-establish the stream. Flow control can be achieved by configuring the
     * underlying RPC channel.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     * @return \Google\ApiCore\BidiStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function streamingPull(array $optionalArgs = [])
    {
        return $this->startCall(
            'StreamingPull',
            StreamingPullResponse::class,
            $optionalArgs,
            null,
            Call::BIDI_STREAMING_CALL
        );
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     * the subscription if `Pull` or `StreamingPull` is not called.
     * @param array $optionalArgs {
     *                            Optional.
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
    public function modifyPushConfig($subscription, $pushConfig, array $optionalArgs = [])
    {
        $request = new ModifyPushConfigRequest();
        $request->setSubscription($subscription);
        $request->setPushConfig($pushConfig);

        return $this->startCall(
            'ModifyPushConfig',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the existing snapshots.<br><br>
     * <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     * changed in backward-incompatible ways and is not recommended for production
     * use. It is not subject to any SLA or deprecation policy.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedProject = $subscriberClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $subscriberClient->listSnapshots($formattedProject);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $subscriberClient->listSnapshots($formattedProject);
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
    public function listSnapshots($project, array $optionalArgs = [])
    {
        $request = new ListSnapshotsRequest();
        $request->setProject($project);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListSnapshots',
            $optionalArgs,
            ListSnapshotsResponse::class,
            $request
        );
    }

    /**
     * Creates a snapshot from the requested subscription.<br><br>
     * <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     * changed in backward-incompatible ways and is not recommended for production
     * use. It is not subject to any SLA or deprecation policy.
     * If the snapshot already exists, returns `ALREADY_EXISTS`.
     * If the requested subscription doesn't exist, returns `NOT_FOUND`.
     * If the backlog in the subscription is too old -- and the resulting snapshot
     * would expire in less than 1 hour -- then `FAILED_PRECONDITION` is returned.
     * See also the `Snapshot.expire_time` field. If the name is not provided in
     * the request, the server will assign a random
     * name for this snapshot on the same project as the subscription, conforming
     * to the [resource name format](https://cloud.google.com/pubsub/docs/overview#names).
     * The generated
     * name is populated in the returned Snapshot object. Note that for REST API
     * requests, you must specify a name in the request.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedName = $subscriberClient->snapshotName('[PROJECT]', '[SNAPSHOT]');
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     *     @type array $labels
     *          User labels.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\Snapshot
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSnapshot($name, $subscription, array $optionalArgs = [])
    {
        $request = new CreateSnapshotRequest();
        $request->setName($name);
        $request->setSubscription($subscription);
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }

        return $this->startCall(
            'CreateSnapshot',
            Snapshot::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing snapshot.<br><br>
     * <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     * changed in backward-incompatible ways and is not recommended for production
     * use. It is not subject to any SLA or deprecation policy.
     * Note that certain properties of a snapshot are not modifiable.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $seconds = 123456;
     *     $expireTime = new Timestamp();
     *     $expireTime->setSeconds($seconds);
     *     $snapshot = new Snapshot();
     *     $snapshot->setExpireTime($expireTime);
     *     $pathsElement = 'expire_time';
     *     $paths = [$pathsElement];
     *     $updateMask = new FieldMask();
     *     $updateMask->setPaths($paths);
     *     $response = $subscriberClient->updateSnapshot($snapshot, $updateMask);
     * } finally {
     *     $subscriberClient->close();
     * }
     * ```
     *
     * @param Snapshot  $snapshot     The updated snapshot object.
     * @param FieldMask $updateMask   Indicates which fields in the provided snapshot to update.
     *                                Must be specified and non-empty.
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
     * @return \Google\Cloud\PubSub\V1\Snapshot
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateSnapshot($snapshot, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateSnapshotRequest();
        $request->setSnapshot($snapshot);
        $request->setUpdateMask($updateMask);

        return $this->startCall(
            'UpdateSnapshot',
            Snapshot::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Removes an existing snapshot. <br><br>
     * <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     * changed in backward-incompatible ways and is not recommended for production
     * use. It is not subject to any SLA or deprecation policy.
     * When the snapshot is deleted, all messages retained in the snapshot
     * are immediately dropped. After a snapshot is deleted, a new one may be
     * created with the same name, but the new one has no association with the old
     * snapshot or its subscription, unless the same subscription is specified.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSnapshot = $subscriberClient->snapshotName('[PROJECT]', '[SNAPSHOT]');
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
    public function deleteSnapshot($snapshot, array $optionalArgs = [])
    {
        $request = new DeleteSnapshotRequest();
        $request->setSnapshot($snapshot);

        return $this->startCall(
            'DeleteSnapshot',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Seeks an existing subscription to a point in time or to a given snapshot,
     * whichever is provided in the request.<br><br>
     * <b>ALPHA:</b> This feature is part of an alpha release. This API might be
     * changed in backward-incompatible ways and is not recommended for production
     * use. It is not subject to any SLA or deprecation policy.
     *
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedSubscription = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\PubSub\V1\SeekResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function seek($subscription, array $optionalArgs = [])
    {
        $request = new SeekRequest();
        $request->setSubscription($subscription);
        if (isset($optionalArgs['time'])) {
            $request->setTime($optionalArgs['time']);
        }
        if (isset($optionalArgs['snapshot'])) {
            $request->setSnapshot($optionalArgs['snapshot']);
        }

        return $this->startCall(
            'Seek',
            SeekResponse::class,
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedResource = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedResource = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
     * Sample code:
     * ```
     * $subscriberClient = new SubscriberClient();
     * try {
     *     $formattedResource = $subscriberClient->subscriptionName('[PROJECT]', '[SUBSCRIPTION]');
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
