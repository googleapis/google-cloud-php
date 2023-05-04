<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\PubSub;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Duration as CoreDuration;
use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\V1\DeadLetterPolicy;
use Google\Cloud\PubSub\V1\Encoding;
use Google\Cloud\PubSub\V1\ExpirationPolicy;
use Google\Cloud\PubSub\V1\MessageStoragePolicy;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\PushConfig;
use Google\Cloud\PubSub\V1\RetryPolicy;
use Google\Cloud\PubSub\V1\Schema;
use Google\Cloud\PubSub\V1\Schema\Type;
use Google\Cloud\PubSub\V1\SchemaServiceClient;
use Google\Cloud\PubSub\V1\SchemaSettings;
use Google\Cloud\PubSub\V1\SchemaView;
use Google\Cloud\PubSub\V1\SubscriberClient;
use Google\Cloud\PubSub\V1\Subscription;
use Google\Cloud\PubSub\V1\Topic;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;

class RequestHandler
{
    use EmulatorTrait;
    use GrpcTrait;

    const BASE_URI = 'https://pubsub.googleapis.com/';

    /**
     * @var PublisherClient
     */
    protected $publisherClient;

    /**
     * @var SubscriberClient
     */
    protected $subscriberClient;

    /**
     * @var SchemaServiceClient
     */
    protected $schemaClient;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        //@codeCoverageIgnoreStart
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
            $grpcConfig = array_merge(
                $grpcConfig,
                $this->emulatorGapicConfig($config['emulatorHost'])
            );
        }
        //@codeCoverageIgnoreEnd

        $this->clientConfig = $grpcConfig;

        if (isset($config['gapicPublisherClient'])) {
            $this->publisherClient = $config['gapicPublisherClient'];
        }

        if (isset($config['gapicSubscriberClient'])) {
            $this->subscriberClient = $config['gapicSubscriberClient'];
        }

        if (isset($config['gapicSchemaClient'])) {
            $this->schemaClient = $config['gapicSchemaClient'];
        }
    }

    public function sendReq($client, string $method, array $requiredArgs,array $args) {

        $allArgs = $requiredArgs;

        // we send the optional args in the end, because everything before that is
        // passed on the the `$method` as an argument(required)
        $allArgs[] = $args;

        return $this->send([$client, $method], $allArgs);
    }


    /**
     * @param array $args
     */
    public function getTopic(array $args)
    {
        return $this->send([$this->getPublisherClient(), 'getTopic'], [
            $this->pluck('topic', $args),
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
            if (count($d) < 2) {
                $seconds = $d[0];
                $nanos = 0;
            } else {
                $seconds = (int) $d[0];
                $nanos = $this->convertFractionToNanoSeconds($d[1]);
            }
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

    /**
     * Create or return a publisher client.
     *
     * @return PublisherClient
     */
    protected function getPublisherClient()
    {
        if ($this->publisherClient) {
            return $this->publisherClient;
        }

        $this->publisherClient = $this->constructGapic(PublisherClient::class, $this->clientConfig);
        return $this->publisherClient;
    }

    /**
     * Create or return a subscriber client.
     *
     * @return SubscriberClient
     */
    protected function getSubscriberClient()
    {
        if ($this->subscriberClient) {
            return $this->subscriberClient;
        }

        $this->subscriberClient = $this->constructGapic(SubscriberClient::class, $this->clientConfig);
        return $this->subscriberClient;
    }

    /**
     * Create or return a schema client.
     *
     * @return SchemaClient
     */
    protected function getSchemaClient()
    {
        if ($this->schemaClient) {
            return $this->schemaClient;
        }

        $this->schemaClient = $this->constructGapic(SchemaServiceClient::class, $this->clientConfig);
        return $this->schemaClient;
    }
}
