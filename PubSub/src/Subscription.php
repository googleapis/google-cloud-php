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

use Google\ApiCore\ApiException;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\PubSub\V1\AcknowledgeRequest;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\DeadLetterPolicy;
use Google\Cloud\PubSub\V1\DeleteSubscriptionRequest;
use Google\Cloud\PubSub\V1\DetachSubscriptionRequest;
use Google\Cloud\PubSub\V1\ExpirationPolicy;
use Google\Cloud\PubSub\V1\GetSubscriptionRequest;
use Google\Cloud\PubSub\V1\ModifyAckDeadlineRequest;
use Google\Cloud\PubSub\V1\ModifyPushConfigRequest;
use Google\Cloud\PubSub\V1\PullRequest;
use Google\Cloud\PubSub\V1\PushConfig;
use Google\Cloud\PubSub\V1\RetryPolicy;
use Google\Cloud\PubSub\V1\SeekRequest;
use Google\Cloud\PubSub\V1\Subscription as SubscriptionProto;
use Google\Cloud\PubSub\V1\UpdateSubscriptionRequest;
use Google\Protobuf\Duration as ProtobufDuration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
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
 * $pubsub = new PubSubClient(['projectId' => 'my-awesome-project']);
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
 * $pubsub = new PubSubClient(['projectId' => 'my-awesome-project']);
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
    use IncomingMessageTrait;
    use ResourceNameTrait;
    use TimeTrait;
    use ValidateTrait;
    use ApiHelperTrait;

    const MAX_MESSAGES = 1000;

    /**
     * @internal
     * The request handler that is responsible for sending a request and
     * serializing responses into relevant classes.
     */
    private RequestHandler $requestHandler;
    private Serializer $serializer;

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
     * @param RequestHandler The request handler that is responsible for sending a request
     * and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The current project
     * @param string $name The subscription name
     * @param string $topicName The topic name the subscription is attached to
     * @param bool $encode Whether messages are encrypted or not.
     * @param array $info [optional] Subscription info. Used to pre-populate the object.
     */
    public function __construct(
        RequestHandler $requestHandler,
        Serializer $serializer,
        $projectId,
        $name,
        $topicName,
        $encode,
        array $info = []
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
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
     * {@see Topic::subscribe()} or {@see Topic::subscription()}.
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
     *           the same `orderingKey` in {@see Message}
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
     *     @type array $cloudStorageConfig If provided, messages will be delivered to Google Cloud Storage.
     *     @type string $cloudStorageConfig.bucket User-provided name for the Cloud Storage bucket.
     *           The bucket must be created by the user. The bucket name must be without
     *           any prefix like "gs://". See the [bucket naming
     *           requirements] (https://cloud.google.com/storage/docs/buckets#naming).
     *     @type string $cloudStorageConfig.filenamePrefix
     *           User-provided prefix for Cloud Storage filename. See the [object naming
     *           requirements](https://cloud.google.com/storage/docs/objects#naming).
     *     @type string $cloudStorageConfig.filenameSuffix
     *           User-provided suffix for Cloud Storage filename. See the [object naming
     *           requirements](https://cloud.google.com/storage/docs/objects#naming). Must
     *           not end in "/".
     *     @type array $cloudStorageConfig.textConfig If present, payloads will be written
     *           to Cloud Storage as raw text, separated by a newline.
     *     @type array $cloudStorageConfig.avroConfig If set, message payloads and metadata
     *           will be written to Cloud Storage in Avro format.
     *     @type bool $cloudStorageConfig.avroConfig.writeMetadata
     *           When true, write the subscription name, message_id, publish_time,
     *           attributes, and ordering_key as additional fields in the output.
     *     @type Duration|string $cloudStorageConfig.maxDuration The maximum duration
     *           that can elapse before a new Cloud Storage file is created.
     *           Min 1 minute, max 10 minutes, default 5 minutes. May not exceed the
     *           subscription's acknowledgement deadline. If a string is provided,
     *           it should be as a duration in seconds with up to nine fractional digits,
     *           terminated by 's', e.g "3.5s"
     *     @type int|string $cloudStorageConfig.maxBytes The maximum bytes that can be
     *           written to a Cloud Storage file before a new file is created.
     *           Min 1 KB, max 10 GiB. The max_bytes limit may be exceeded in cases where
     *           messages are larger than the limit.
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

        list($data, $optionalArgs) = $this->splitOptionalArgs($options);

        $data = $this->formatSubscriptionDurations($data);
        $data = $this->formatDeadLetterPolicyForApi($data);

        // convert args to protos
        $protoMap = [
            'expirationPolicy' => ExpirationPolicy::class,
            'deadLetterPolicy' => DeadLetterPolicy::class,
            'retryPolicy' => RetryPolicy::class,
        ];
        $data = $this->convertDataToProtos($data, $protoMap);
        $data['name'] = $this->name;
        $data['topic'] = $this->topicName;

        $request = $this->serializer->decodeMessage(new SubscriptionProto(), $data);

        $this->info = $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            $request,
            $options
        );

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
     * @param array $data {
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
     *           the same `orderingKey` in {@see Message}
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
     *     @type array $cloudStorageConfig If provided, messages will be delivered to Google Cloud Storage.
     *     @type string $cloudStorageConfig.bucket User-provided name for the Cloud Storage bucket.
     *           The bucket must be created by the user. The bucket name must be without
     *           any prefix like "gs://". See the [bucket naming
     *           requirements] (https://cloud.google.com/storage/docs/buckets#naming).
     *     @type string $cloudStorageConfig.filenamePrefix
     *           User-provided prefix for Cloud Storage filename. See the [object naming
     *           requirements](https://cloud.google.com/storage/docs/objects#naming).
     *     @type string $cloudStorageConfig.filenameSuffix
     *           User-provided suffix for Cloud Storage filename. See the [object naming
     *           requirements](https://cloud.google.com/storage/docs/objects#naming). Must
     *           not end in "/".
     *     @type array $cloudStorageConfig.textConfig If present, payloads will be written
     *           to Cloud Storage as raw text, separated by a newline.
     *     @type array $cloudStorageConfig.avroConfig If set, message payloads and metadata
     *           will be written to Cloud Storage in Avro format.
     *     @type bool $cloudStorageConfig.avroConfig.writeMetadata
     *           When true, write the subscription name, message_id, publish_time,
     *           attributes, and ordering_key as additional fields in the output.
     *     @type Duration|string $cloudStorageConfig.maxDuration The maximum duration
     *           that can elapse before a new Cloud Storage file is created.
     *           Min 1 minute, max 10 minutes, default 5 minutes. May not exceed the
     *           subscription's acknowledgement deadline. If a string is provided,
     *           it should be as a duration in seconds with up to nine fractional digits,
     *           terminated by 's', e.g "3.5s"
     *     @type int|string $cloudStorageConfig.maxBytes The maximum bytes that can be
     *           written to a Cloud Storage file before a new file is created.
     *           Min 1 KB, max 10 GiB. The max_bytes limit may be exceeded in cases where
     *           messages are larger than the limit.
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
    public function update(array $data, array $options = [])
    {
        $updateMaskPaths = $this->pluck('updateMask', $options, false) ?: [];
        if (!$updateMaskPaths) {
            $excludes = ['name', 'topic'];
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveArrayIterator($data),
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

        $maskPaths = [];
        foreach ($updateMaskPaths as $path) {
            $maskPaths[] = $this->serializer::toSnakeCase($path);
        }

        $fieldMask = new FieldMask([
            'paths' => $maskPaths
        ]);

        $data = $this->formatSubscriptionDurations($data);
        $data = $this->formatDeadLetterPolicyForApi($data);
        $data['name'] = $this->name;

        $data = ['subscription' => $data, 'updateMask' => $fieldMask];
        $data = $this->convertDataToProtos($data, ['subscription' => SubscriptionProto::class]);

        $request = $this->serializer->decodeMessage(new UpdateSubscriptionRequest(), $data);

        return $this->info = $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'updateSubscription',
            $request,
            $options
        );
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
        $request = $this->serializer->decodeMessage(
            new DeleteSubscriptionRequest(),
            ['subscription' => $this->name]
        );

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'deleteSubscription',
            $request,
            $options
        );
    }

    /**
     * Check if a subscription exists.
     *
     * Service errors will NOT bubble up from this method. It will always return
     * a boolean value. If you want to check for errors, use
     * {@see Subscription::info()}.
     *
     * If you need to re-check the existence of a subscription that is already
     * downloaded, call {@see Subscription::reload()} first
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
     * To fetch a fresh result, use {@see Subscription::reload()}.
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
        $request = $this->serializer->decodeMessage(
            new GetSubscriptionRequest(),
            ['subscription' => $this->name]
        );

        return $this->info = $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            $request,
            $options
        );
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
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data['subscription'] = $this->name;
        $data['maxMessages'] =  $data['maxMessages'] ?? self::MAX_MESSAGES;
        $request = $this->serializer->decodeMessage(new PullRequest(), $data);

        $messages = [];
        $response = $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'pull',
            $request,
            $optionalArgs
        );

        if (isset($response['receivedMessages'])) {
            foreach ($response['receivedMessages'] as $message) {
                $messages[] = $this->messageFactory($message, $this->projectId, $this->encode);
            }
        }

        return $messages;
    }

    /**
     * Acknowledge receipt of a message.
     *
     * Use {@see Subscription::acknowledgeBatch()} to
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
     * Use {@see Subscription::acknowledge()} to acknowledge
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

        $returnFailures = $this->pluck('returnFailures', $options, false) ?: false;

        if ($returnFailures) {
            return $this->acknowledgeBatchWithRetries($messages, $options);
        }

        // the rpc may throw errors for a sub with EOD enabled
        // but we don't act on the exception to maintain compatibility
        try {
            $this->sendAckRequest($messages, $options);
        } catch (\Exception $e) {
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
            $this->sendAckRequest($messages, $options);
        };

        return $this->retryEodAction($actionFunc, $messages, $options);
    }

    /**
     * Set the acknowledge deadline for a single ackId.
     *
     * Use {@see Subscription::modifyAckDeadlineBatch()} to
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
     * Use {@see Subscription::modifyAckDeadline()} to
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

        $returnFailures = $this->pluck('returnFailures', $options, false) ?: false;

        if ($returnFailures) {
            return $this->modifyAckDeadlineBatchWithRetries($messages, $seconds, $options);
        }

        // the rpc may throw errors for a sub with EOD enabled
        // but we don't act on the exception to maintain compatibility
        try {
            $this->sendModAckRequest($messages, $seconds, $options);
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
            $this->sendModAckRequest($messages, $seconds, $options);
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

        // Func that decides if we need to retry again or not
        $retryFunc = function (
            \Exception $e
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

        // min delay of 1 sec, max delay of 64 secs
        // doubles on every attempt
        // We use 15 retries as the number of retries should be high enough to have a total delay
        // of 10 minutes($maxAttemptTime)
        $retrySettings = [
            'initialRetryDelayMillis' => 1000,
            'maxRetryDelayMillis' => self::$exactlyOnceDeliveryMaxRetryTime,
            'retryDelayMultiplier' => 2,
            'retryFunction' => $retryFunc,
            'maxRetries' => self::$exactlyOnceDeliveryMaxRetries
        ];

        $options['retrySettings'] = $retrySettings;

        try {
            $actionFunc($messages, $options);
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
        $data = ['pushConfig' => $pushConfig, 'subscription' => $this->name];
        $data = $this->convertDataToProtos($data, ['pushConfig' => PushConfig::class]);

        $request = $this->serializer->decodeMessage(new ModifyPushConfigRequest(), $data);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyPushConfig',
            $request,
            $options
        );
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
        $data = ['time' => $timestamp->formatForApi(), 'subscription' => $this->name];

        $data = $this->convertDataToProtos($data, ['time' => ProtobufTimestamp::class]);
        $request = $this->serializer->decodeMessage(new SeekRequest(), $data);

        return $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'seek',
            $request,
            $options,
            true
        );
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
        $data = ['subscription' => $this->name, 'snapshot' => $snapshot->name()];
        $request = $this->serializer->decodeMessage(new SeekRequest(), $data);

        return $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'seek',
            $request,
            $options,
            true
        );
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
        $data = ['subscription' => $this->name];
        $request = $this->serializer->decodeMessage(new DetachSubscriptionRequest(), $data);

        return $this->requestHandler->sendRequest(
            PublisherClient::class,
            'detachSubscription',
            $request,
            $options
        );
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
     * @return IamManager
     */
    public function iam()
    {
        if (!$this->iam) {
            $this->iam = new IamManager($this->requestHandler, $this->serializer, SubscriberClient::class, $this->name);
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
     * @param array $data
     * @return array
     */
    private function formatSubscriptionDurations(array $data)
    {
        if (isset($data['messageRetentionDuration'])) {
            if ($data['messageRetentionDuration'] instanceof Duration) {
                $duration = $data['messageRetentionDuration']->get();
                $data['messageRetentionDuration'] = sprintf(
                    '%s.%ss',
                    $duration['seconds'],
                    $this->convertNanoSecondsToFraction($duration['nanos'], false)
                );
            }
            $data['messageRetentionDuration'] = new ProtobufDuration(
                $this->formatDurationForApi($data['messageRetentionDuration'])
            );
        }

        if (isset($data['retryPolicy'])) {
            if (isset($data['expirationPolicy']['ttl']) && $data['expirationPolicy']['ttl'] instanceof Duration) {
                $duration = $data['expirationPolicy']['ttl']->get();
                $data['expirationPolicy']['ttl'] = sprintf(
                    '%s.%ss',
                    $duration['seconds'],
                    $this->convertNanoSecondsToFraction($duration['nanos'], false)
                );
            }

            if (isset($data['retryPolicy']['minimumBackoff']) &&
                $data['retryPolicy']['minimumBackoff'] instanceof Duration
            ) {
                $duration = $data['retryPolicy']['minimumBackoff']->get();
                $data['retryPolicy']['minimumBackoff'] = sprintf(
                    '%s.%ss',
                    $duration['seconds'],
                    $this->convertNanoSecondsToFraction($duration['nanos'], false)
                );
            }

            if (isset($data['retryPolicy']['maximumBackoff']) &&
                $data['retryPolicy']['maximumBackoff'] instanceof Duration
            ) {
                $duration = $data['retryPolicy']['maximumBackoff']->get();
                $data['retryPolicy']['maximumBackoff'] = sprintf(
                    '%s.%ss',
                    $duration['seconds'],
                    $this->convertNanoSecondsToFraction($duration['nanos'], false)
                );
            }
        }

        if (isset($data['cloudStorageConfig']['maxDuration']) &&
            $data['cloudStorageConfig']['maxDuration'] instanceof Duration
        ) {
            $duration = $data['cloudStorageConfig']['maxDuration']->get();
            $data['cloudStorageConfig']['maxDuration'] = sprintf(
                '%s.%ss',
                $duration['seconds'],
                $this->convertNanoSecondsToFraction($duration['nanos'], false)
            );
        }

        return $data;
    }

    /**
     * Format dead letter topic subscription data for API.
     *
     * @param array $data
     * @return array
     */
    private function formatDeadLetterPolicyForApi(array $data)
    {
        if (isset($data['deadLetterPolicy'])) {
            if ($data['deadLetterPolicy']['deadLetterTopic'] instanceof Topic) {
                $topic = $data['deadLetterPolicy']['deadLetterTopic'];
                $data['deadLetterPolicy']['deadLetterTopic'] = $topic->name();
            }
        }

        return $data;
    }

    /**
     * Checks if a given exception failure is because of
     * an EOD failure.
     *
     * @param \Exception $e
     * @return boolean
     */
    private function isExceptionExactlyOnce(\Exception $e)
    {
        if (!$e instanceof ApiException && !$e instanceof BadRequestException) {
            return false;
        }

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
            'requestHandler' => $this->requestHandler
        ];
    }

    /**
     * Returns the temporarily failed ackIds from the exception object
     *
     * @param \Exception
     * @return array
     */
    private function getRetryableAckIds(\Exception $e)
    {
        $ackIds = [];

        // EOD enabled subscription
        if ($this->isExceptionExactlyOnce($e)) {
            $metadata = $e->getErrorInfoMetadata();

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

    /**
     * Helper function that sends an ack request for the given msgs.
     *
     * @param array $messages List of messages to ack.
     * @param array $options
     */
    private function sendAckRequest(array $messages, array $options)
    {
        $ackIds = $this->getMessageAckIds($messages);
        $data = ['subscription' => $this->name, 'ackIds' => $ackIds];
        $request = $this->serializer->decodeMessage(new AcknowledgeRequest(), $data);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            $request,
            $options
        );
    }

    /**
     * Helper function that sends a modack request for the given msgs.
     *
     * @param array $messages List of messages to ack.
     * @param int $seconds The new deadline in seconds.
     * @param array $options
     */
    private function sendModAckRequest(array $messages, $seconds, array $options)
    {
        $ackIds = $this->getMessageAckIds($messages);
        $data = ['subscription' => $this->name, 'ackIds' => $ackIds, 'ackDeadlineSeconds' => $seconds];
        $request = $this->serializer->decodeMessage(new ModifyAckDeadlineRequest(), $data);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            $request,
            $options
        );
    }
}
