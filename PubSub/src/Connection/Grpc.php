<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\PubSub\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Duration as CoreDuration;
use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\V1\ExpirationPolicy;
use Google\Cloud\PubSub\V1\MessageStoragePolicy;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\PushConfig;
use Google\Cloud\PubSub\V1\SubscriberClient;
use Google\Cloud\PubSub\V1\Subscription;
use Google\Cloud\PubSub\V1\Topic;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;

/**
 * Implementation of the
 * [Google Pub/Sub gRPC API](https://cloud.google.com/pubsub/docs/reference/rpc/).
 */
class Grpc implements ConnectionInterface
{
    use EmulatorTrait;
    use GrpcTrait;

    const BASE_URI = 'https://pubsub.googleapis.com/';

    /**
     * @var PublisherClient
     */
    private $publisherClient;

    /**
     * @var SubscriberClient
     */
    private $subscriberClient;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([
            'publish_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'expiration_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [], [
            'google.protobuf.Duration' => function ($v) {
                return $this->transformDuration($v);
            }
        ]);

        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $grpcConfig = $this->getGaxConfig(
            PubSubClient::VERSION,
            isset($config['authHttpHandler'])
                ? $config['authHttpHandler']
                : null
        );

        $config += ['emulatorHost' => null];

        if (isset($config['apiEndpoint'])) {
            $grpcConfig['apiEndpoint'] = $config['apiEndpoint'];
        }

        if ((bool) $config['emulatorHost']) {
            $grpcConfig += $this->emulatorGapicConfig($config['emulatorHost']);
        }

        $this->publisherClient = $this->constructGapic(PublisherClient::class, $grpcConfig);
        $this->subscriberClient = $this->constructGapic(SubscriberClient::class, $grpcConfig);
    }

    /**
     * @param array $args
     */
    public function createTopic(array $args)
    {
        if (isset($args['messageStoragePolicy'])) {
            $args['messageStoragePolicy'] = $this->serializer->decodeMessage(
                new MessageStoragePolicy,
                $args['messageStoragePolicy']
            );
        }

        return $this->send([$this->publisherClient, 'createTopic'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getTopic(array $args)
    {
        return $this->send([$this->publisherClient, 'getTopic'], [
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteTopic(array $args)
    {
        return $this->send([$this->publisherClient, 'deleteTopic'], [
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function updateTopic(array $args)
    {
        $updateMaskPaths = [];
        foreach (explode(',', $this->pluck('updateMask', $args)) as $path) {
            $updateMaskPaths[] = Serializer::toSnakeCase($path);
        }

        $fieldMask = new FieldMask([
            'paths' => $updateMaskPaths
        ]);

        $topic = $this->serializer->decodeMessage(
            new Topic,
            $this->pluck('topic', $args)
        );

        unset($args['name']);
        return $this->send([$this->publisherClient, 'updateTopic'], [
            $topic,
            $fieldMask,
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listTopics(array $args)
    {
        return $this->send([$this->publisherClient, 'listTopics'], [
            $this->pluck('project', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function publishMessage(array $args)
    {
        $pbMessages = [];
        $messages = $this->pluck('messages', $args);

        foreach ($messages as $message) {
            $pbMessages[] = $this->buildMessage($message);
        }

        return $this->send([$this->publisherClient, 'publish'], [
            $this->pluck('topic', $args),
            $pbMessages,
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listSubscriptionsByTopic(array $args)
    {
        return $this->send([$this->publisherClient, 'listTopicSubscriptions'], [
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function createSubscription(array $args)
    {
        if (isset($args['pushConfig'])) {
            $args['pushConfig'] = $this->buildPushConfig($args['pushConfig']);
        }

        if (isset($args['expirationPolicy'])) {
            $args['expirationPolicy'] = $this->serializer->decodeMessage(
                new ExpirationPolicy,
                $args['expirationPolicy']
            );
        }

        if (isset($args['messageRetentionDuration'])) {
            $args['messageRetentionDuration'] = new Duration(
                $this->transformDuration($args['messageRetentionDuration'])
            );
        }

        return $this->send([$this->subscriberClient, 'createSubscription'], [
            $this->pluck('name', $args),
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function updateSubscription(array $args)
    {
        $updateMaskPaths = [];
        foreach (explode(',', $this->pluck('updateMask', $args)) as $path) {
            $updateMaskPaths[] = Serializer::toSnakeCase($path);
        }

        $fieldMask = new FieldMask([
            'paths' => $updateMaskPaths
        ]);

        $subscription = $this->serializer->decodeMessage(
            new Subscription,
            $this->pluck('subscription', $args)
        );

        unset($args['name']);
        return $this->send([$this->subscriberClient, 'updateSubscription'], [
            $subscription,
            $fieldMask,
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getSubscription(array $args)
    {
        return $this->send([$this->subscriberClient, 'getSubscription'], [
            $this->pluck('subscription', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listSubscriptions(array $args)
    {
        return $this->send([$this->subscriberClient, 'listSubscriptions'], [
            $this->pluck('project', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteSubscription(array $args)
    {
        return $this->send([$this->subscriberClient, 'deleteSubscription'], [
            $this->pluck('subscription', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function modifyPushConfig(array $args)
    {
        return $this->send([$this->subscriberClient, 'modifyPushConfig'], [
            $this->pluck('subscription', $args),
            $this->buildPushConfig($this->pluck('pushConfig', $args)),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function pull(array $args)
    {
        return $this->send([$this->subscriberClient, 'pull'], [
            $this->pluck('subscription', $args),
            $this->pluck('maxMessages', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function modifyAckDeadline(array $args)
    {
        return $this->send([$this->subscriberClient, 'modifyAckDeadline'], [
            $this->pluck('subscription', $args),
            $this->pluck('ackIds', $args),
            $this->pluck('ackDeadlineSeconds', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function acknowledge(array $args)
    {
        return $this->send([$this->subscriberClient, 'acknowledge'], [
            $this->pluck('subscription', $args),
            $this->pluck('ackIds', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listSnapshots(array $args)
    {
        $whitelisted = true;
        return $this->send([$this->subscriberClient, 'listSnapshots'], [
            $this->pluck('project', $args),
            $args
        ], $whitelisted);
    }

    /**
     * @param array $args
     */
    public function createSnapshot(array $args)
    {
        $whitelisted = true;
        return $this->send([$this->subscriberClient, 'createSnapshot'], [
            $this->pluck('name', $args),
            $this->pluck('subscription', $args),
            $args
        ], $whitelisted);
    }

    /**
     * @param array $args
     */
    public function deleteSnapshot(array $args)
    {
        $whitelisted = true;
        return $this->send([$this->subscriberClient, 'deleteSnapshot'], [
            $this->pluck('snapshot', $args),
            $args
        ], $whitelisted);
    }

    /**
     * @param array $args
     */
    public function seek(array $args)
    {
        if (isset($args['time'])) {
            $time = $this->formatTimestampForApi($args['time']);
            $args['time'] = $this->serializer->decodeMessage(new Timestamp(), $time);
        }

        $whitelisted = true;
        return $this->send([$this->subscriberClient, 'seek'], [
            $this->pluck('subscription', $args),
            $args
        ], $whitelisted);
    }

    /**
     * @param array $args
     */
    public function getTopicIamPolicy(array $args)
    {
        return $this->send([$this->publisherClient, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function setTopicIamPolicy(array $args)
    {
        return $this->send([$this->publisherClient, 'setIamPolicy'], [
            $this->pluck('resource', $args),
            $this->buildPolicy($this->pluck('policy', $args)),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function testTopicIamPermissions(array $args)
    {
        return $this->send([$this->publisherClient, 'testIamPermissions'], [
            $this->pluck('resource', $args),
            $this->pluck('permissions', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getSubscriptionIamPolicy(array $args)
    {
        return $this->send([$this->subscriberClient, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function setSubscriptionIamPolicy(array $args)
    {
        return $this->send([$this->subscriberClient, 'setIamPolicy'], [
            $this->pluck('resource', $args),
            $this->buildPolicy($this->pluck('policy', $args)),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function testSubscriptionIamPermissions(array $args)
    {
        return $this->send([$this->subscriberClient, 'testIamPermissions'], [
            $this->pluck('resource', $args),
            $this->pluck('permissions', $args),
            $args
        ]);
    }

    /**
     * @param array $message
     * @return PubsubMessage
     */
    private function buildMessage(array $message)
    {
        return $this->serializer->decodeMessage(new PubsubMessage(), $message);
    }

    /**
     * @param array $policy
     * @return Policy
     */
    private function buildPolicy(array $policy)
    {
        return $this->serializer->decodeMessage(new Policy(), $policy);
    }

    /**
     * @param array $pushConfig
     * @return PushConfig
     */
    private function buildPushConfig(array $pushConfig)
    {
        return $this->serializer->decodeMessage(new PushConfig(), $pushConfig);
    }

    private function transformDuration($v)
    {
        if (is_string($v)) {
            $d = explode('.', trim($v, 's'));
            if (count($d) !== 2) {
                return null;
            }

            $seconds = (int) $d[0];
            $nanos = $this->convertFractionToNanoSeconds($d[1]);
        } elseif ($v instanceof CoreDuration) {
            $d = $v->get();
            $seconds = $d['seconds'];
            $nanos = $d['nanos'];
        }

        return [
            'seconds' => $seconds,
            'nanos' => $nanos
        ];
    }
}
