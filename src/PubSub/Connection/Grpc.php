<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

use DrSlump\Protobuf\Codec\CodecInterface;
use Google\Cloud\EmulatorTrait;
use Google\Cloud\PhpArray;
use Google\Cloud\PubSub\V1\PublisherApi;
use Google\Cloud\PubSub\V1\SubscriberApi;
use Google\Cloud\GrpcRequestWrapper;
use Google\Cloud\GrpcTrait;
use Grpc\ChannelCredentials;
use google\iam\v1\Policy;
use google\pubsub\v1\PubsubMessage;
use google\pubsub\v1\PushConfig;

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
     * @var PublisherApi
     */
    private $publisherApi;

    /**
     * @var SubscriberApi
     */
    private $subscriberApi;

    /**
     * @var CodecInterface
     */
    private $codec;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->codec = new PhpArray(['publishTime' => function ($v) {
            return $this->formatTimestampFromApi($v);
        }]);
        $config['codec'] = $this->codec;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $grpcConfig = $this->getGaxConfig();
        $emulatorHost = getenv('PUBSUB_EMULATOR_HOST');
        $baseUri = $this->getEmulatorBaseUri(self::BASE_URI, $emulatorHost);

        if ($emulatorHost) {
            $grpcConfig += [
                'serviceAddress' => parse_url($baseUri, PHP_URL_HOST),
                'port' => parse_url($baseUri, PHP_URL_PORT),
                'sslCreds' => ChannelCredentials::createInsecure()
            ];
        }

        $this->publisherApi = new PublisherApi($grpcConfig);
        $this->subscriberApi = new SubscriberApi($grpcConfig);
    }

    /**
     * @param array $args
     */
    public function createTopic(array $args)
    {
        return $this->send([$this->publisherApi, 'createTopic'], [
            $this->pluck('name', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getTopic(array $args)
    {
        return $this->send([$this->publisherApi, 'getTopic'], [
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteTopic(array $args)
    {
        return $this->send([$this->publisherApi, 'deleteTopic'], [
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listTopics(array $args)
    {
        return $this->send([$this->publisherApi, 'listTopics'], [
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

        return $this->send([$this->publisherApi, 'publish'], [
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
        return $this->send([$this->publisherApi, 'listTopicSubscriptions'], [
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

        return $this->send([$this->subscriberApi, 'createSubscription'], [
            $this->pluck('name', $args),
            $this->pluck('topic', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getSubscription(array $args)
    {
        return $this->send([$this->subscriberApi, 'getSubscription'], [
            $this->pluck('subscription', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listSubscriptions(array $args)
    {
        return $this->send([$this->subscriberApi, 'listSubscriptions'], [
            $this->pluck('project', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function deleteSubscription(array $args)
    {
        return $this->send([$this->subscriberApi, 'deleteSubscription'], [
            $this->pluck('subscription', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function modifyPushConfig(array $args)
    {
        return $this->send([$this->subscriberApi, 'modifyPushConfig'], [
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
        return $this->send([$this->subscriberApi, 'pull'], [
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
        return $this->send([$this->subscriberApi, 'modifyAckDeadline'], [
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
        return $this->send([$this->subscriberApi, 'acknowledge'], [
            $this->pluck('subscription', $args),
            $this->pluck('ackIds', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function getTopicIamPolicy(array $args)
    {
        return $this->send([$this->publisherApi, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function setTopicIamPolicy(array $args)
    {
        return $this->send([$this->publisherApi, 'setIamPolicy'], [
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
        return $this->send([$this->publisherApi, 'testIamPermissions'], [
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
        return $this->send([$this->subscriberApi, 'getIamPolicy'], [
            $this->pluck('resource', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function setSubscriptionIamPolicy(array $args)
    {
        return $this->send([$this->subscriberApi, 'setIamPolicy'], [
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
        return $this->send([$this->subscriberApi, 'testIamPermissions'], [
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
        if (isset($message['attributes'])) {
            $message['attributes'] = $this->formatLabelsForApi($message['attributes']);
        }

        return (new PubsubMessage())->deserialize($message, $this->codec);
    }

    /**
     * @param array $policy
     * @return Policy
     */
    private function buildPolicy(array $policy)
    {
        return (new Policy())->deserialize($policy, $this->codec);
    }

    /**
     * @param array $pushConfig
     * @return PushConfig
     */
    private function buildPushConfig(array $pushConfig)
    {
        if (isset($pushConfig['attributes'])) {
            $pushConfig['attributes'] = $this->formatLabelsForApi($pushConfig['attributes']);
        }

        return (new PushConfig())->deserialize($pushConfig, $this->codec);
    }
}
