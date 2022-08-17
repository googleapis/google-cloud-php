<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\PubSub;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Connection\IamSubscription;
use Google\Cloud\PubSub\IncomingMessageTrait;
use InvalidArgumentException;

/**
 * A named resource representing the stream of messages from a single, specific
 * topic, to be delivered to the subscribing application.
 *
 * Example:
 * ```
 * // Create subscription through a topic
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 *
 * $topic = $pubsub->topic('my-new-topic');
 *
 * $subscription = $topic->subscription('my-new-subscription');
 * ```
 *
 * ```
 * // Create subscription through PubSubClient
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 *
 * $subscription = $pubsub->subscription(
 *     'my-new-subscription',
 *     'my-new-topic'
 * );
 * ```
 *
 * ```
 * // Consuming messages received via push with JWT Authentication.
 * use Google\Auth\AccessToken;
 *
 * // Remove the `Bearer ` prefix from the token.
 * // If using another request manager such as Symfony HttpFoundation,
 * // use `Authorization` as the header name, e.g. `$request->headers->get('Authorization')`.
 * $jwt = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];
 *
 * // Using the Access Token utility requires installation of the `phpseclib/phpseclib` dependency at version 2.
 * $accessTokenUtility = new AccessToken();
 * $payload = $accessTokenUtility->verify($jwt);
 * if (!$payload) {
 *     throw new \RuntimeException('Could not verify token!');
 * }
 *
 * echo 'Authenticated using ' . $payload['email'];
 * ```
 */
class Subscription
{
    use ArrayTrait;
    use IncomingMessageTrait;
    use ResourceNameTrait;
    use TimeTrait;
    use ValidateTrait;

    const MAX_MESSAGES = 1000;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $topicName;

    /**
     * @var bool
     */
    private $encode;

    /**
     * @var array
     */
    private $info;

    /**
     * @var Iam
     */
    private $iam;

    /**
     * @var int
     *
     * The max time an exponential retry should delay for(in microseconds)
     * set to 64 secs.
     */
    private static $exactlyOnceDeliveryMaxRetryTime = 64000000;

    /**
     * @var string
     *
     * The Error Info reason that is used to identify a subscription
     * with Exactly Once Delivery enabled or not.
     */
    private static $exactlyOnceDeliveryFailureReason = 'EXACTLY_ONCE_ACKID_FAILURE';

    /**
     * @var string
     */
    private static $exactlyOnceDeliveryTransientFailurePrefix = 'TRANSIENT_FAILURE';

    /**
     * @var int
     *
     * Max num of retries for an Exactly Once Delivery enabled sub's ack operation.
     */
    private static $exactlyOnceDeliveryMaxRetries = 15;

    /**
     * Create a Subscription.
     *
     * The idiomatic way to use this class is through the PubSubClient or Topic,
     * but you can instantiate it directly as well.
     *
     * @param ConnectionInterface $connection The service connection object
     * @param string $projectId The current project
     * @param string $name The subscription name
     * @param string $topicName The topic name the subscription is attached to
     * @param bool $encode Whether messages are encrypted or not.
     * @param array $info [optional] Subscription info. Used to pre-populate the object.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $name,
        $topicName,
        $encode,
        array $info = []
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->encode = (bool) $encode;
        $this->info = $info;

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('subscription', $name)) {
            $this->name = $name;
        } else {
            $this->name = $this->formatName('subscription', $name, $projectId);
        }

        // Accept either a simple name or a fully-qualified name.
        if ($this->isFullyQualifiedName('topic', $topicName)) {
            $this->topicName = $topicName;
        } else {
            $this->topicName = !is_null($topicName)
                ? $this->formatName('topic', $topicName, $projectId)
                : null;
        }
    }

    /**
     * Get the subscription name
     *
     * Example:
     * ```
     * echo $subscription->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Indicates whether the subscription is detached from its topic.
     *
     * Detached subscriptions don't receive messages from their topic and don't
     * retain any backlog. `Pull` and `StreamingPull` requests will return
     * FAILED_PRECONDITION. If the subscription is a push subscription, pushes
     * to the endpoint will not be made.
     *
     * Example:
     * ```
     * $detached = $subscription->detached();
     * if ($detached) {
     *     echo "The subscription is detached";
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function detached(array $options = [])
    {
        $info = $this->info($options) + ['detached' => false];
        return $info['detached'];
    }

    /**
     * Execute a service request creating the subscription.
     *
     * The suggested way of creating a subscription is by calling through
     * {@see Google\Cloud\PubSub\Topic::subscribe()} or {@see Google\Cloud\PubSub\Topic::subscription()}.
     *
     * Returns subscription info in the format detailed in the documentation
     * for a [subscription](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions#Subscription).
     *
     * **NOTE: Some methods of instantiation of a Subscription do not supply a
     * topic name. The topic name is required to create a subscription.**
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-new-topic');
     *
     * $subscription = $topic->subscription('my-new-subscription');
     * $result = $subscription->create();
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/create Create Subscription
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type int $ackDeadlineSeconds The maximum time after a subscriber
     *           receives a message before the subscriber should acknowledge the
     *           message.
     *     @type array $deadLetterPolicy A policy that specifies the conditions
     *           for dead lettering messages in this subscription. If
     *           deadLetterPolicy is not set, dead lettering is disabled. The
     *           Cloud Pub/Sub service account associated with this
     *           subscriptions's parent project (i.e.,
     *           service-{project_number}@gcp-sa-pubsub.iam.gserviceaccount.com)
     *           must have permission to acknowledge messages on this
     *           subscription.
     *     @type string|Topic $deadLetterPolicy.deadLetterTopic The topic, or
     *           name of the topic to which dead letter messages should be
     *           published. Strings must be of format
     *           `projects/{project}/topics/{topic}`. The Cloud Pub/Sub service
     *           account associated with the enclosing subscription's parent
     *           project (i.e., service-{project_number}@gcp-sa-pubsub.iam.gserviceaccount.com)
     *           must have permission to publish to this topic. The operation
     *           will fail if the topic does not exist. Users should ensure that
     *           there is a subscription attached to this topic since messages
     *           published to a topic with no subscriptions are lost.
     *     @type int $deadLetterPolicy.maxDeliveryAttempts The maximum number of
     *           delivery attempts for any message. The value must be between 5
     *           and 100.
     *     @type bool $enableMessageOrdering If true, messages published with
     *           the same `orderingKey` in {@see Google\Cloud\PubSub\Message}
     *           will be delivered to the subscribers in the order in which they
     *           are received by the Pub/Sub system. Otherwise, they may be
     *           delivered in any order.
     *     @type array $expirationPolicy A policy that specifies the conditions
     *           for resource expiration (i.e., automatic resource deletion).
     *     @type Duration|string $expirationPolicy.ttl Specifies the
     *           "time-to-live" duration for an associated resource. The
     *           resource expires if it is not active for a period of `ttl`. The
     *           definition of "activity" depends on the type of the associated
     *           resource. The minimum and maximum allowed values for `ttl`
     *           depend on the type of the associated resource, as well. If
     *           `ttl` is not set, the associated resource never expires. If a
     *           string is provided, it should be as a duration in seconds with
     *           up to nine fractional digits, terminated by 's', e.g "3.5s".
     *     @type string $filter An expression written in the Pub/Sub
     *           [filter language](https://cloud.google.com/pubsub/docs/filtering).
     *           If non-empty, then only messages whose `attributes` field
     *           matches the filter are delivered on this subscription. If
     *           empty, then no messages are filtered out. Filtering can only be
     *           configured at subscription creation.
     *     @type Duration|string $messageRetentionDuration How long to retain
     *           unacknowledged messages in the subscription's backlog, from the
     *           moment a message is published. If `$retainAckedMessages` is
     *           true, then this also configures the retention of acknowledged
     *           messages, and thus configures how far back in time a `Seek`
     *           can be done. Cannot be more than 7 days or less than 10 minutes.
     *           **Defaults to** 7 days.
     *     @type array $pushConfig.attributes Endpoint configuration attributes.
     *     @type array $pushConfig.oidcToken If specified, Pub/Sub will generate
     *           and attach an OIDC JWT token as an `Authorization` header in
     *           the HTTP request for every pushed message.
     *     @type string $pushConfig.oidcToken.audience Audience to be used when
     *           generating OIDC token. The audience claim identifies the
     *           recipients that the JWT is intended for. The audience value is
     *           a single case-sensitive string. Having multiple values (array)
     *           for the audience field is not supported. More info about the
     *           OIDC JWT token audience here: https://tools.ietf.org/html/rfc7519#section-4.1.3
     *           Note: if not specified, the Push endpoint URL will be used.
     *     @type string $pushConfig.oidcToken.serviceAccountEmail Service
     *           account email to be used for generating the OIDC token. The
     *           caller (for `subscriptions.create`, `UpdateSubscription`, and
     *           `subscriptions.modifyPushConfig` RPCs) must have the
     *           `iam.serviceAccounts.actAs` permission for the service account.
     *     @type string $pushConfig.pushEndpoint A URL locating the endpoint to which
     *           messages should be pushed. For example, a Webhook endpoint
     *           might use "https://example.com/push".
     *     @type bool $retainAckedMessages Indicates whether to retain
     *           acknowledged messages.
     *     @type array $retryPolicy A policy that specifies how Cloud Pub/Sub
     *           retries message delivery for this subscription. If not set, the
     *           default retry policy is applied. This generally means that
     *           messages will be retried as soon as possible for healthy
     *           subscribers. Retry Policy will be triggered on NACKs or
     *           acknowledgement deadline exceeded events for a given message.
     *           Retry Policies are implemented on a best effort basis At times,
     *           the delay between deliveries may not match the configuration.
     *           That is, the delay can be more or less than the configured
     *           backoff.
     *     @type Duration|string $retryPolicy.minimumBackoff The minimum delay
     *           between consecutive deliveries of a given message. Value should
     *           be between 0 and 600 seconds. Defaults to 10 seconds.
     *     @type Duration|string $retryPolicy.maximumBackoff The maximum delay
     *           between consecutive deliveries of a given message. Value should
     *           be between 0 and 600 seconds. Defaults to 600 seconds.
     *     @type bool $enableExactlyOnceDelivery Indicates whether to enable
     *           'Exactly Once Delivery' on the subscription.
     * }
     * @return array An array of subscription info
     * @throws \InvalidArgumentException
     */
    public function create(array $options = [])
    {
        // If a subscription is created via PubSubClient::subscription(),
        // it may or may not have a topic name. This is fine for most API
        // interactions, but a topic name is required to create a subscription.
        if (!$this->topicName) {
            throw new InvalidArgumentException(
                'A topic name is required to create a subscription.'
            );
        }

        $options = $this->formatSubscriptionDurations($options);

        $this->info = $this->connection->createSubscription([
            'name' => $this->name,
            'topic' => $this->topicName
        ] + $this->formatDeadLetterPolicyForApi($options));

        return $this->info;
    }

    /**
     * Update the subscription.
     *
     * Note that subscription name and topic are immutable properties and may
     * not be modified.
     *
     * Example:
     * ```
     * $subscription->update([
     *     'retainAckedMessages' => true
     * ]);
     * ```
     *
     * ```
     * // Updating labels and push config attributes with explicit update masks.
     * $subscription->update([
     *     'labels' => [
     *         'label-1' => 'value'
     *     ],
     *     'pushConfig' => [
     *         'attributes' => [
     *             'x-goog-version' => 1
     *         ]
     *     ]
     * ], [
     *     'updateMask' => [
     *         'labels',
     *         'pushConfig.attributes'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/UpdateSubscriptionRequest UpdateSubscriptionRequest
     *
     * @param array $subscription {
     *     The Subscription data.
     *
     *     @type int $ackDeadlineSeconds The maximum time after a subscriber
     *           receives a message before the subscriber should acknowledge the
     *           message.
     *     @type array $deadLetterPolicy A policy that specifies the conditions
     *           for dead lettering messages in this subscription. If
     *           deadLetterPolicy is not set, dead lettering is disabled. The
     *           Cloud Pub/Sub service account associated with this
     *           subscriptions's parent project (i.e.,
     *           service-{project_number}@gcp-sa-pubsub.iam.gserviceaccount.com)
     *           must have permission to acknowledge messages on this
     *           subscription.
     *     @type string|Topic $deadLetterPolicy.deadLetterTopic The topic, or
     *           name of the topic to which dead letter messages should be
     *           published. Strings must be of format
     *           `projects/{project}/topics/{topic}`. The Cloud Pub/Sub service
     *           account associated with the enclosing subscription's parent
     *           project (i.e., service-{project_number}@gcp-sa-pubsub.iam.gserviceaccount.com)
     *           must have permission to publish to this topic. The operation
     *           will fail if the topic does not exist. Users should ensure that
     *           there is a subscription attached to this topic since messages
     *           published to a topic with no subscriptions are lost.
     *     @type int $deadLetterPolicy.maxDeliveryAttempts The maximum number of
     *           delivery attempts for any message. The value must be between 5
     *           and 100.
     *     @type bool $enableMessageOrdering If true, messages published with
     *           the same `orderingKey` in {@see Google\Cloud\PubSub\Message}
     *           will be delivered to the subscribers in the order in which they
     *           are received by the Pub/Sub system. Otherwise, they may be
     *           delivered in any order.
     *     @type array $expirationPolicy A policy that specifies the conditions
     *           for resource expiration (i.e., automatic resource deletion).
     *     @type Duration|string $expirationPolicy.ttl Specifies the
     *           "time-to-live" duration for an associated resource. The
     *           resource expires if it is not active for a period of `ttl`. The
     *           definition of "activity" depends on the type of the associated
     *           resource. The minimum and maximum allowed values for `ttl`
     *           depend on the type of the associated resource, as well. If
     *           `ttl` is not set, the associated resource never expires. If a
     *           string is provided, it should be as a duration in seconds with
     *           up to nine fractional digits, terminated by 's', e.g "3.5s".
     *     @type Duration|string $messageRetentionDuration How long to retain
     *           unacknowledged messages in the subscription's backlog, from the
     *           moment a message is published. If `$retainAckedMessages` is
     *           true, then this also configures the retention of acknowledged
     *           messages, and thus configures how far back in time a `Seek`
     *           can be done. Cannot be more than 7 days or less than 10 minutes.
     *           **Defaults to** 7 days.
     *     @type array $pushConfig.attributes Endpoint configuration attributes.
     *     @type array $pushConfig.oidcToken If specified, Pub/Sub will generate
     *           and attach an OIDC JWT token as an `Authorization` header in
     *           the HTTP request for every pushed message.
     *     @type string $pushConfig.oidcToken.audience Audience to be used when
     *           generating OIDC token. The audience claim identifies the
     *           recipients that the JWT is intended for. The audience value is
     *           a single case-sensitive string. Having multiple values (array)
     *           for the audience field is not supported. More info about the
     *           OIDC JWT token audience here: https://tools.ietf.org/html/rfc7519#section-4.1.3
     *           Note: if not specified, the Push endpoint URL will be used.
     *     @type string $pushConfig.oidcToken.serviceAccountEmail Service
     *           account email to be used for generating the OIDC token. The
     *           caller (for `subscriptions.create`, `UpdateSubscription`, and
     *           `subscriptions.modifyPushConfig` RPCs) must have the
     *           `iam.serviceAccounts.actAs` permission for the service account.
     *     @type string $pushConfig.pushEndpoint A URL locating the endpoint to which
     *           messages should be pushed. For example, a Webhook endpoint
     *           might use "https://example.com/push".
     *     @type bool $retainAckedMessages Indicates whether to retain
     *           acknowledged messages.
     *     @type array $retryPolicy A policy that specifies how Cloud Pub/Sub
     *           retries message delivery for this subscription. If not set, the
     *           default retry policy is applied. This generally means that
     *           messages will be retried as soon as possible for healthy
     *           subscribers. Retry Policy will be triggered on NACKs or
     *           acknowledgement deadline exceeded events for a given message.
     *           Retry Policies are implemented on a best effort basis At times,
     *           the delay between deliveries may not match the configuration.
     *           That is, the delay can be more or less than the configured
     *           backoff.
     *     @type Duration|string $retryPolicy.minimumBackoff The minimum delay
     *           between consecutive deliveries of a given message. Value should
     *           be between 0 and 600 seconds. Defaults to 10 seconds.
     *     @type Duration|string $retryPolicy.maximumBackoff The maximum delay
     *           between consecutive deliveries of a given message. Value should
     *           be between 0 and 600 seconds. Defaults to 600 seconds.
     *     @type bool $enableExactlyOnceDelivery Indicates whether to enable
     *           'Exactly Once Delivery' on the subscription.
     * }
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $updateMask A list of field paths to be modified. Nested
     *           key names should be dot-separated, e.g. `pushConfig.pushEndpoint`.
     *           Google Cloud PHP will attempt to infer this value on your
     *           behalf, however modification of map fields with arbitrary keys
     *           (such as labels or push config attributes) requires an explicit
     *           update mask.
     * }
     * @return array The subscription info.
     */
    public function update(array $subscription, array $options = [])
    {
        $updateMaskPaths = $this->pluck('updateMask', $options, false) ?: [];
        if (!$updateMaskPaths) {
            $excludes = ['name', 'topic'];
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveArrayIterator($subscription),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($iterator as $leafValue) {
                $keys = [];
                foreach (range(0, $iterator->getDepth()) as $depth) {
                    $keys[] = $iterator->getSubIterator($depth)->key();
                }

                $path = implode('.', $keys);
                if (!in_array($path, $excludes)) {
                    $hasPrefix = (bool) array_filter($updateMaskPaths, function ($maskPath) use ($path) {
                        return strpos($maskPath, $path) === 0;
                    });

                    if (!$hasPrefix) {
                        $updateMaskPaths[] = $path;
                    }
                }
            }
        }

        $subscription = $this->formatSubscriptionDurations($subscription);

        $subscription = [
            'name' => $this->name
        ] + $this->formatDeadLetterPolicyForApi($subscription);

        return $this->info = $this->connection->updateSubscription([
            'name' => $this->name,
            'subscription' => $subscription,
            'updateMask' => implode(',', $updateMaskPaths)
        ] + $options);
    }

    /**
     * Delete a subscription
     *
     * Example:
     * ```
     * $subscription->delete();
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/delete Delete Subscription
     *
     * @param array $options [optional] Configuration Options.
     * @return void
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteSubscription($options + [
            'subscription' => $this->name
        ]);
    }

    /**
     * Check if a subscription exists.
     *
     * Service errors will NOT bubble up from this method. It will always return
     * a boolean value. If you want to check for errors, use
     * {@see Google\Cloud\PubSub\Subscription::info()}.
     *
     * If you need to re-check the existence of a subscription that is already
     * downloaded, call {@see Google\Cloud\PubSub\Subscription::reload()} first
     * to refresh the cached information.
     *
     * Example:
     * ```
     * if ($subscription->exists()) {
     *     echo 'Subscription exists!';
     * }
     * ```
     *
     * @param array $options [optional] Configuration Options
     * @return bool
     */
    public function exists(array $options = [])
    {
        try {
            $this->info($options);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }

    /**
     * Get info on a subscription
     *
     * If the info is already cached on the object, it will return that result.
     * To fetch a fresh result, use {@see Google\Cloud\PubSub\Subscription::reload()}.
     *
     * Example:
     * ```
     * $info = $subscription->info();
     * echo $info['name']; // `projects/my-awesome-project/subscriptions/my-new-subscription`
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/get Get Subscription
     *
     * @param array $options [optional] Configuration Options
     * @return array Subscription data
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Retrieve info on a subscription from the API.
     *
     * To use the previously cached result (if it exists), use
     * {@see Subscription::info()}.
     *
     * Example:
     * ```
     * $subscription->reload();
     * $info = $subscription->info();
     * echo $info['name']; // `projects/my-awesome-project/subscriptions/my-new-subscription`
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/get Get Subscription
     *
     * @param array $options [optional] Configuration Options
     * @return array Subscription data
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getSubscription($options + [
            'subscription' => $this->name
        ]);
    }

    /**
     * Retrieve new messages from the topic.
     *
     * Example:
     * ```
     * $messages = $subscription->pull();
     * foreach ($messages as $message) {
     *     echo $message->data();
     * }
     * ```
     *
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/pull Pull Subscriptions
     *
     * @param array $options [optional] {
     *      Configuration Options
     *
     *      @type bool $returnImmediately If true, the system will respond
     *            immediately, even if no messages are available. Otherwise,
     *            wait until new messages are available. **Defaults to**
     *            `false`.
     *      @type int $maxMessages Limit the amount of messages pulled.
     *            **Defaults to** `1000`.
     * }
     * @return Message[]
     */
    public function pull(array $options = [])
    {
        $messages = [];
        $options['maxMessages'] = isset($options['maxMessages'])
            ? $options['maxMessages']
            : self::MAX_MESSAGES;

        $response = $this->connection->pull($options + [
            'subscription' => $this->name
        ]);

        if (isset($response['receivedMessages'])) {
            foreach ($response['receivedMessages'] as $message) {
                $messages[] = $this->messageFactory($message, $this->connection, $this->projectId, $this->encode);
            }
        }

        return $messages;
    }

    /**
     * Acknowledge receipt of a message.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::acknowledgeBatch()} to
     * acknowledge multiple messages at once.
     *
     * Example:
     * ```
     * $messages = $subscription->pull();
     *
     * foreach ($messages as $message) {
     *     $subscription->acknowledge($message);
     * }
     * ```
     * ```
     * $messages = $subscription->pull();
     *
     * foreach ($messages as $message) {
     *     $failedMsgs = $subscription->acknowledge($message, ['returnFailures' => true]);
     *
     *     // Either log or store the $failedMsgs to be retried later
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/acknowledge Acknowledge Message
     * @codingStandardsIgnoreEnd
     *
     * @param Message $message A message object.
     * @param array $options [optional] {
     *      Configuration Options
     *
     *      @type bool $returnFailures If set, and if an acknowledgement is failed with a
     *            temporary failure code, it will be retried with an exponential delay. This will also make sure
     *            that the permanently failed message is returned to the caller. This is only true for a
     *            subscription with 'Exactly Once Delivery' enabled.
     *            Read more about EOD: https://cloud.google.com/pubsub/docs/exactly-once-delivery
     * }
     * @return void|array
     */
    public function acknowledge(Message $message, array $options = [])
    {
        return $this->acknowledgeBatch([$message], $options);
    }

    /**
     * Acknowledge receipt of multiple messages at once.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::acknowledge()} to acknowledge
     * a single message.
     *
     * Example:
     * ```
     * $messages = $subscription->pull();
     *
     * $subscription->acknowledgeBatch($messages);
     * ```
     * ```
     * $messages = $subscription->pull();
     *
     * $failedMsgs = $subscription->acknowledgeBatch($messages, ['returnFailures' => true]);
     *
     * // Either log or store the $failedMsgs to be retried later
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/acknowledge Acknowledge Message
     * @codingStandardsIgnoreEnd
     *
     * @param Message[] $messages An array of messages
     * @param array $options [optional] {
     *      Configuration Options
     *
     *      @type bool $returnFailures If set, and if a message is failed with a
     *            temporary failure code, it will be retried with an exponential delay. This will also make sure
     *            that the permanently failed message is returned to the caller. This is only true for a
     *            subscription with 'Exactly Once Delivery' enabled.
     *            Read more about EOD: https://cloud.google.com/pubsub/docs/exactly-once-delivery
     * }
     * @return void|array
     */
    public function acknowledgeBatch(array $messages, array $options = [])
    {
        $this->validateBatch($messages, Message::class);

        if (isset($options['returnFailures']) && $options['returnFailures']) {
            return $this->acknowledgeBatchWithRetries($messages, $options);
        }

        // the rpc may throw errors for a sub with EOD enabled
        // but we don't act on the exception to maintain compatibility
        try {
            $this->connection->acknowledge($options + [
                'subscription' => $this->name,
                'ackIds' => $this->getMessageAckIds($messages)
            ]);
        } catch (BadRequestException $e) {
            // bubble up the error if the exception isn't an EOD exception
            if (!$this->isExceptionExactlyOnce($e)) {
                throw $e;
            }
        }
    }

    /**
     * Helper that sends an acknowledge request but with retries.
     *
     * @param Message[] $messages An array of messages
     * @param array $options Configuration Options
     * @return array|void Array of messages which failed permanently
     */
    private function acknowledgeBatchWithRetries(array $messages, array $options = [])
    {
        $actionFunc = function (&$messages, $options) {
            $this->connection->acknowledge($options + [
                'subscription' => $this->name,
                'ackIds' => $this->getMessageAckIds($messages)
            ]);
        };

        return $this->retryEodAction($actionFunc, $messages, $options);
    }

    /**
     * Set the acknowledge deadline for a single ackId.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::modifyAckDeadlineBatch()} to
     * modify the ack deadline for multiple messages at once.
     *
     * Example:
     * ```
     * $messages = $subscription->pull();
     *
     * foreach ($messages as $message) {
     *     $subscription->modifyAckDeadline($message, 3);
     *     sleep(2);
     *
     *     // Now we'll acknowledge!
     *     $subscription->acknowledge($message);
     *
     *     break;
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/modifyAckDeadline Modify Ack Deadline
     * @codingStandardsIgnoreEnd
     *
     * @param Message $message A message object
     * @param int $seconds The new ack deadline with respect to the time
     *        this request was sent to the Pub/Sub system. Must be >= 0. For
     *        example, if the value is 10, the new ack deadline will expire 10
     *        seconds after the ModifyAckDeadline call was made. Specifying
     *        zero may immediately make the message available for another pull
     *        request.
     * @param array $options [optional] {
     *      Configuration Options
     *
     *      @type bool $returnFailures If set, and if a message is failed with a
     *            temporary failure code, it will be retried with an exponential delay. This will also make sure
     *            that the permanently failed message is returned to the caller. This is only true for a
     *            subscription with 'Exactly Once Delivery' enabled.
     *            Read more about EOD: https://cloud.google.com/pubsub/docs/exactly-once-delivery
     * }
     * @return void|array
     */
    public function modifyAckDeadline(Message $message, $seconds, array $options = [])
    {
        return $this->modifyAckDeadlineBatch([$message], $seconds, $options);
    }

    /**
     * Set the acknowledge deadline for multiple ackIds.
     *
     * Use {@see Google\Cloud\PubSub\Subscription::modifyAckDeadline()} to
     * modify the ack deadline for a single message.
     *
     * Example:
     * ```
     * $messages = $subscription->pull();
     *
     * // Set the ack deadline to three seconds from now for every message
     * $subscription->modifyAckDeadlineBatch($messages, 3);
     *
     * // Delay execution, or make a sandwich or something.
     * sleep(2);
     *
     * // Now we'll acknowledge
     * $subscription->acknowledgeBatch($messages);
     * ```
     * ```
     * $messages = $subscription->pull();
     * $failedMsgs = $subscription->modifyAckDeadlineBatch($messages, 3, ['returnFailures' => true]);
     *
     * // Either log or store the $failedMsgs to be retried later
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/modifyAckDeadline Modify Ack Deadline
     * @codingStandardsIgnoreEnd
     *
     * @param Message[] $messages An array of messages
     * @param int $seconds The new ack deadline with respect to the time
     *        this request was sent to the Pub/Sub system. Must be >= 0. For
     *        example, if the value is 10, the new ack deadline will expire 10
     *        seconds after the ModifyAckDeadline call was made. Specifying
     *        zero may immediately make the message available for another pull
     *        request.
     * @param array $options [optional] {
     *      Configuration Options
     *
     *      @type bool $returnFailures If set, and if a message is failed with a
     *            temporary failure code, it will be retried with an exponential delay. This will also make sure
     *            that the permanently failed message is returned to the caller. This is only true for a
     *            subscription with 'Exactly Once Delivery' enabled.
     *            Read more about EOD: https://cloud.google.com/pubsub/docs/exactly-once-delivery
     * }
     * @return void|array
     */
    public function modifyAckDeadlineBatch(array $messages, $seconds, array $options = [])
    {
        $this->validateBatch($messages, Message::class);

        if (isset($options['returnFailures']) && $options['returnFailures']) {
            return $this->modifyAckDeadlineBatchWithRetries($messages, $seconds, $options);
        }

        // the rpc may throw errors for a sub with EOD enabled
        // but we don't act on the exception to maintain compatibility
        try {
            $this->connection->modifyAckDeadline($options + [
                'subscription' => $this->name,
                'ackIds' => $this->getMessageAckIds($messages),
                'ackDeadlineSeconds' => $seconds
            ]);
        } catch (BadRequestException $e) {
            // bubble up the error if the exception isn't an EOD exception
            if (!$this->isExceptionExactlyOnce($e)) {
                throw $e;
            }
        }
    }

    /**
     * Helper that sends a request to modify the ack deadline but with retries.
     *
     * @param Message[] $messages An array of messages
     * @param int $seconds The new ack deadline with respect to the time
     *        this request was sent to the Pub/Sub system. Must be >= 0. For
     *        example, if the value is 10, the new ack deadline will expire 10
     *        seconds after the ModifyAckDeadline call was made. Specifying
     *        zero may immediately make the message available for another pull
     *        request.
     * @param array $options Configuration Options
     *
     * @return array
     */
    private function modifyAckDeadlineBatchWithRetries(array $messages, $seconds, array $options)
    {
        $actionFunc = function (&$messages, $options) use ($seconds) {
            $this->connection->modifyAckDeadline($options + [
                'subscription' => $this->name,
                'ackIds' => $this->getMessageAckIds($messages),
                'ackDeadlineSeconds' => $seconds
            ]);
        };

        return $this->retryEodAction($actionFunc, $messages, $options);
    }

    /**
     * Helper function to retry an action for an `Exactly Once Delivery` enabled subscription
     * with an ExponentionBackOff.
     *
     * @param callable $actionFunc The function to be retried
     * @param Messages[] $messages The messages to be passed on to the pubsub service
     * @param array $options The configuration options
     */
    private function retryEodAction(callable $actionFunc, array $messages, array $options)
    {
        $failed = [];
        $eodEnabled = true;
        $startTime = time();
        $maxAttemptTime = 10 * 60;  // 10 minutes
        
        // min delay of 1 sec, max delay of 64 secs
        // doubles on every attempt
        $delayFunc = function ($attempt) {
            $delay = min(
                mt_rand(0, 1000000) + (pow(2, $attempt) * 1000000),
                self::$exactlyOnceDeliveryMaxRetryTime
            );
            return $delay;
        };

        // Func that decides if we need to retry again or not
        $retryFunc = function (
            BadRequestException $e,
            $attempt
        ) use (
            &$messages,
            &$failed,
            &$eodEnabled,
            $startTime,
            $maxAttemptTime
        ) {
            // If the subscription isn't EOD enabled, the method behaves as the acknowledge method.
            // Info from the exception is used instead of $subscription->info() to avoid
            // the need of `pubsub.subscriptions.get` permission.
            if (!$this->isExceptionExactlyOnce($e)) {
                $eodEnabled = false;
                return false;
            }

            $retryAckIds = $this->getRetryableAckIds($e);

            // Find the messages which can be retried
            $messages = array_filter($messages, function ($message) use (
                $retryAckIds,
                &$failed,
                $startTime,
                $maxAttemptTime
            ) {
                // A message will only be retried if
                // 1. It's ackId is in the list of retryable ackIds
                // 2. The total time elapsed hasn't crossed $maxAttemptTime seconds
                if (in_array($message->ackId(), $retryAckIds)
                    && time() - $startTime < $maxAttemptTime
                ) {
                    return true;
                }

                // If a message ack fails permanently, we remove it from the $messages array
                // and add it to the list of failed messages
                $failed[] = $message;

                return false;
            });

            // Retry only if there are retryable messages left
            return count($messages) > 0;
        };
        
        // We use 15 retries as the number of retries should be high enough to have a total delay
        // of 10 minutes($maxAttemptTime)
        $backoff = new ExponentialBackoff(self::$exactlyOnceDeliveryMaxRetries, $retryFunc);
        $backoff->setCalcDelayFunction($delayFunc);

        // Try to ack the messages with an ExponentialBackoff
        try {
            $backoff->execute($actionFunc, [&$messages, $options]);
        } catch (BadRequestException $e) {
            // When an exception is thrown in the action func
            // and retry function returns false
            // the exception is passed here
        }

        // We don't return anything if EOD is disabled
        // to make it behave like if the flag `returnFailures` wasn't set.
        if ($eodEnabled) {
            return $failed;
        }
    }

    /**
     * Set the push config for the subscription
     *
     * Example:
     * ```
     * $subscription->modifyPushConfig([
     *     'pushEndpoint' => 'https://www.example.com/foo/bar'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/modifyPushConfig Modify Push Config
     * @codingStandardsIgnoreEnd
     *
     * @param array $pushConfig {
     *     Push delivery configuration. See
     *     [PushConfig](https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions#PushConfig)
     *     for more details.
     *
     *     @type string $pushEndpoint A URL locating the endpoint to which
     *           messages should be pushed. For example, a Webhook endpoint
     *           might use "https://example.com/push".
     *     @type array $attributes Endpoint configuration attributes.
     * }
     * @param array $options [optional] Configuration Options
     * @return void
     */
    public function modifyPushConfig(array $pushConfig, array $options = [])
    {
        $this->connection->modifyPushConfig($options + [
            'subscription' => $this->name,
            'pushConfig' => $pushConfig
        ]);
    }

    /**
     * Seek to a given timestamp.
     *
     * When you seek to a time, it has the effect of marking every message
     * received before this time as acknowledged, and all messages received
     * after the time as unacknowledged.
     *
     * Please note that this method may not yet be available in your project.
     *
     * Example:
     * ```
     * $time = $pubsub->timestamp(new \DateTime('2017-04-01'));
     * $subscription->seekToTime($time);
     * ```
     *
     * @param Timestamp $timestamp The time to seek to.
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function seekToTime(Timestamp $timestamp, array $options = [])
    {
        return $this->connection->seek([
            'subscription' => $this->name,
            'time' => $timestamp->formatAsString()
        ] + $options);
    }

    /**
     * Seek to a given snapshot.
     *
     * When seeking to a snapshot, any message that had an "unacknowledged"
     * state when the snapshot was created can be re-delivered.
     *
     * Please note that this method may not yet be available in your project.
     *
     * Example:
     * ```
     * $snapshot = $pubsub->snapshot('my-snapshot');
     * $subscription->seekToSnapshot($snapshot);
     * ```
     *
     * @param Snapshot $snapshot The snapshot to seek to.
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function seekToSnapshot(Snapshot $snapshot, array $options = [])
    {
        return $this->connection->seek([
            'subscription' => $this->name,
            'snapshot' => $snapshot->name()
        ] + $options);
    }

    /**
     * Detach the subscription from its topic.
     *
     * All messages retained in the subscription are dropped. Subsequent `Pull`
     * requests will return FAILED_PRECONDITION. If the subscription is a push
     * subscription, pushes to the endpoint will stop.
     *
     * Example:
     * ```
     * $subscription->detach();
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function detach(array $options = [])
    {
        return $this->connection->detachSubscription([
            'subscription' => $this->name
        ] + $options);
    }

    /**
     * Manage the IAM policy for the current Subscription.
     *
     * Example:
     * ```
     * $iam = $subscription->iam();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/pubsub/access_control PubSub Access Control Documentation
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/getIamPolicy Get Subscription IAM Policy
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/setIamPolicy Set Subscription IAM Policy
     * @see https://cloud.google.com/pubsub/docs/reference/rest/v1/projects.subscriptions/testIamPermissions Test Subscription Permissions
     * @codingStandardsIgnoreEnd
     *
     * @return Iam
     */
    public function iam()
    {
        if (!$this->iam) {
            $iamConnection = new IamSubscription($this->connection);
            $this->iam = new Iam($iamConnection, $this->name);
        }

        return $this->iam;
    }

    /**
     * Get a list of ackIds from a list of Message objects.
     *
     * @param Message[] $messages The messages
     * @return array
     */
    private function getMessageAckIds(array $messages)
    {
        $ackIds = [];
        foreach ($messages as $message) {
            $ackIds[] = $message->ackId();
        }

        return $ackIds;
    }

    /**
     * Format Duration objects for the API.
     *
     * @param array $options
     * @return array
     */
    private function formatSubscriptionDurations(array $options)
    {
        if (isset($options['messageRetentionDuration']) && $options['messageRetentionDuration'] instanceof Duration) {
            $duration = $options['messageRetentionDuration']->get();
            $options['messageRetentionDuration'] = sprintf(
                '%s.%ss',
                $duration['seconds'],
                $this->convertNanoSecondsToFraction($duration['nanos'], false)
            );
        }

        if (isset($options['expirationPolicy']['ttl']) && $options['expirationPolicy']['ttl'] instanceof Duration) {
            $duration = $options['expirationPolicy']['ttl']->get();
            $options['expirationPolicy']['ttl'] = sprintf(
                '%s.%ss',
                $duration['seconds'],
                $this->convertNanoSecondsToFraction($duration['nanos'], false)
            );
        }

        if (isset($options['retryPolicy']['minimumBackoff']) &&
            $options['retryPolicy']['minimumBackoff'] instanceof Duration
        ) {
            $duration = $options['retryPolicy']['minimumBackoff']->get();
            $options['retryPolicy']['minimumBackoff'] = sprintf(
                '%s.%ss',
                $duration['seconds'],
                $this->convertNanoSecondsToFraction($duration['nanos'], false)
            );
        }

        if (isset($options['retryPolicy']['maximumBackoff']) &&
            $options['retryPolicy']['maximumBackoff'] instanceof Duration
        ) {
            $duration = $options['retryPolicy']['maximumBackoff']->get();
            $options['retryPolicy']['maximumBackoff'] = sprintf(
                '%s.%ss',
                $duration['seconds'],
                $this->convertNanoSecondsToFraction($duration['nanos'], false)
            );
        }

        return $options;
    }

    /**
     * Format dead letter topic subscription data for API.
     *
     * @param array $subscription
     * @return array
     */
    private function formatDeadLetterPolicyForApi(array $subscription)
    {
        if (isset($subscription['deadLetterPolicy'])) {
            if ($subscription['deadLetterPolicy']['deadLetterTopic'] instanceof Topic) {
                $topic = $subscription['deadLetterPolicy']['deadLetterTopic'];
                $subscription['deadLetterPolicy']['deadLetterTopic'] = $topic->name();
            }
        }

        return $subscription;
    }

    /**
     * Checks if a given exception failure is because of
     * an EOD failure.
     *
     * @param BadRequestException $e
     * @return boolean
     */
    private function isExceptionExactlyOnce(BadRequestException $e)
    {
        $reason = $e->getReason();

        return $reason === self::$exactlyOnceDeliveryFailureReason;
    }

    /**
     * Present a nicer debug result to people using php 5.6 or greater.
     * @return array
     * @codeCoverageIgnore
     * @access private
     */
    public function __debugInfo()
    {
        return [
            'name' => $this->name,
            'topicName' => $this->topicName,
            'projectId' => $this->projectId,
            'info' => $this->info,
            'connection' => get_class($this->connection)
        ];
    }

    /**
     * Returns the temporarily failed ackIds from the exception object
     *
     * @param BadRequestException
     * @return array
     */
    private function getRetryableAckIds(BadRequestException $e)
    {
        $metadata = $e->getErrorInfoMetadata();
        $ackIds = [];

        // EOD enabled subscription
        if ($this->isExceptionExactlyOnce($e)) {
            foreach ($metadata as $ackId => $failureReason) {
                // check if the prefix of the failure reason is same as
                // the transient failure for EOD enabled subscriptions
                if (strpos($failureReason, self::$exactlyOnceDeliveryTransientFailurePrefix) === 0) {
                    $ackIds[] = $ackId;
                }
            }
        }

        return $ackIds;
    }

    /**
     * Func to change the maximum delay time for an `Exactly Once Delivery` enabled subscription's
     * retry attempt.
     *
     * @internal
     */
    public static function setMaxEodRetryTime($maxTime)
    {
        self::$exactlyOnceDeliveryMaxRetryTime = $maxTime;
    }

    /**
     * Getter for the private static variable
     * @return int
     */
    public static function getMaxRetries()
    {
        return self::$exactlyOnceDeliveryMaxRetries;
    }
}
