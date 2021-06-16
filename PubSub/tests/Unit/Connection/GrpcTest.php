<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\PubSub\Tests\Unit\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Duration as CoreDuration;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Iam\V1\Binding;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\PubSub\Connection\Grpc;
use Google\Cloud\PubSub\V1\DeadLetterPolicy;
use Google\Cloud\PubSub\V1\ExpirationPolicy;
use Google\Cloud\PubSub\V1\MessageStoragePolicy;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\PushConfig;
use Google\Cloud\PubSub\V1\Subscription;
use Google\Cloud\PubSub\V1\Topic;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group pubsub
 * @group pubsub-connection
 * @group pubsub-connection-grpc
 */
class GrpcTest extends TestCase
{
    use GrpcTestTrait;
    use GrpcTrait;

    private $successMessage;
    private $serializer;

    private $projectName = 'projects/foo';
    private $topicName = 'projects/foo/topics/bar';
    private $subscriptionName = 'projects/foo/subscriptions/bar';
    private $snapshotName = 'projects/foo/snapshots/bar';
    private $pageSize = ['pageSize' => 3];

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
        $this->successMessage = 'success';
        $this->serializer = new Serializer;
    }

    public function testApiEndpoint()
    {
        $expected = 'foobar.com';

        $grpc = new GrpcStub(['apiEndpoint' => $expected]);

        $this->assertEquals($expected, $grpc->config['apiEndpoint']);
    }

    public function testUpdateTopic()
    {
        $topic = new Topic;
        $topic->setLabels(['foo' => 'bar']);
        $topic->setName($this->topicName);
        $topicFieldMask = new FieldMask([
            'paths' => ['labels']
        ]);

        $args = [
            'topic' => [
                'name' => $this->topicName,
                'labels' => [
                    'foo' => 'bar'
                ]
            ],
            'updateMask' => 'labels'
        ];

        $expected = [$topic, $topicFieldMask, []];

        $this->sendAndAssert('updateTopic', $args, $expected);
    }

    public function testUpdateSubscription()
    {
        $deadLetterPolicy = new DeadLetterPolicy([
            'dead_letter_topic' => $this->topicName
        ]);

        $subscription = new Subscription;
        $subscription->setName($this->subscriptionName);
        $subscription->setRetainAckedMessages(true);
        $subscription->setDeadLetterPolicy($deadLetterPolicy);

        $subscriptionFieldMask = new FieldMask([
            'paths' => [
                'retain_acked_messages',
                'dead_letter_policy.dead_letter_topic'
            ]
        ]);

        $args = [
            'subscription' => [
                'name' => $this->subscriptionName,
                'retainAckedMessages' => true,
                'deadLetterPolicy' => [
                    'deadLetterTopic' => $this->topicName
                ]
            ],
            'updateMask' => 'retainAckedMessages,deadLetterPolicy.deadLetterTopic'
        ];

        $expected = [$subscription, $subscriptionFieldMask, []];

        $this->sendAndAssert('updateSubscription', $args, $expected);
    }

    public function testListSnapshots()
    {
        $this->sendAndAssert(
            'listSnapshots',
            ['project' => 'projectId'],
            ['projectId', []]
        );
    }

    public function testCreateSnapshot()
    {
        $args = [
            'name' => $this->snapshotName,
            'subscription' => $this->subscriptionName
        ];

        $expected = [
            $this->snapshotName,
            $this->subscriptionName,
            []
        ];

        $this->sendAndAssert('createSnapshot', $args, $expected);
    }

    public function testDeleteSnapshot()
    {
        $args = ['snapshot' => $this->snapshotName];
        $expected = [$this->snapshotName, []];
        $this->sendAndAssert('deleteSnapshot', $args, $expected);
    }

    public function testSeek()
    {
        $time = (new \DateTime)->format('Y-m-d\TH:i:s.u\Z');
        $timestamp = $this->serializer->decodeMessage(new Timestamp(), $this->formatTimestampForApi($time));

        $args = [
            'subscription' => $this->subscriptionName,
            'time' => $time
        ];

        $expected = [
            $this->subscriptionName,
            ['time' => $timestamp]
        ];

        $this->sendAndAssert('seek', $args, $expected);
    }

    public function testCreateTopic()
    {
        $regions = ['us-mybackyard1'];
        $messageStoragePolicy = new MessageStoragePolicy([
            'allowed_persistence_regions' => $regions
        ]);

        $args = [
            'name' => $this->topicName,
            'messageStoragePolicy' => [
                'allowedPersistenceRegions' => $regions
            ]
        ];
        $expected = [$this->topicName, [
            'messageStoragePolicy' => $messageStoragePolicy
        ]];
        $this->sendAndAssert('createTopic', $args, $expected);
    }

    public function testGetTopic()
    {
        $args = ['topic' => $this->topicName];
        $expected = [$this->topicName, []];
        $this->sendAndAssert('getTopic', $args, $expected);
    }

    public function testDeleteTopic()
    {
        $args = ['topic' => $this->topicName];
        $expected = [$this->topicName, []];
        $this->sendAndAssert('deleteTopic', $args, $expected);
    }

    public function testListTopics()
    {
        $args = ['project' => $this->projectName];
        $expected = [$this->projectName, []];
        $this->sendAndAssert('listTopics', $args, $expected);
    }

    public function testPublishMessage()
    {
        $messageData = '123';
        $attributes = ['testing' => 123];
        $message = new PubsubMessage([
            'data' => $messageData,
            'attributes' => $attributes
        ]);

        $args = [
            'topic' => $this->topicName,
            'messages' => [
                [
                    'data' => $messageData,
                    'attributes' => $attributes
                ]
            ]
        ];

        $expected = [$this->topicName, [$message], []];

        $this->sendAndAssert('publishMessage', $args, $expected);
    }

    public function testListSubscriptionsByTopic()
    {
        $args = ['topic' => $this->topicName] + $this->pageSize;
        $expected = [$this->topicName, $this->pageSize];
        $this->sendAndAssert('listSubscriptionsByTopic', $args, $expected);
    }

    /**
     * @dataProvider ttls
     */
    public function testCreateSubscription($ttl, $ttlDuration = null)
    {
        $pushEndpoint = 'http://www.example.com';
        $attributes = ['foo' => 'bar'];
        $pushConfig = new PushConfig([
            'push_endpoint' => $pushEndpoint,
            'attributes' => $attributes
        ]);

        $deadLetterPolicy = new DeadLetterPolicy([
            'dead_letter_topic' => $this->topicName
        ]);

        $duration = new Duration(['seconds' => $ttl]);
        $expirationPolicy = new ExpirationPolicy([
            'ttl' => $duration
        ]);

        $args = [
            'name' => $this->subscriptionName,
            'topic' => $this->topicName,
            'pushConfig' => [
                'pushEndpoint' => $pushEndpoint,
                'attributes' => $attributes
            ],
            'deadLetterPolicy' => [
                'deadLetterTopic' => $this->topicName
            ],
            'expirationPolicy' => [
                'ttl' => $ttlDuration ?: $ttl
            ],
            'messageRetentionDuration' => $ttlDuration ?: $ttl
        ];

        $expected = [
            $this->subscriptionName,
            $this->topicName,
            [
                'pushConfig' => $pushConfig,
                'deadLetterPolicy' => $deadLetterPolicy,
                'expirationPolicy' => $expirationPolicy,
                'messageRetentionDuration' => $duration
            ]
        ];

        $this->sendAndAssert('createSubscription', $args, $expected);
    }

    public function ttls()
    {
        return [
            ['100.0'],
            ['100.0', new CoreDuration(100, 0)],
            ['100']
        ];
    }

    public function testGetSubscription()
    {
        $args = ['subscription' => $this->subscriptionName];
        $expected = [$this->subscriptionName, []];
        $this->sendAndAssert('getSubscription', $args, $expected);
    }

    public function testListSubscriptions()
    {
        $args = ['project' => $this->projectName] + $this->pageSize;
        $expected = [$this->projectName, $this->pageSize];
        $this->sendAndAssert('listSubscriptions', $args, $expected);
    }

    public function testDeleteSubscription()
    {
        $args = ['subscription' => $this->subscriptionName];
        $expected = [$this->subscriptionName, []];
        $this->sendAndAssert('deleteSubscription', $args, $expected);
    }

    public function testModifyPushConfig()
    {
        $pushEndpoint = 'http://www.example.com';
        $attributes = ['foo' => 'bar'];
        $pushConfig = new PushConfig([
            'push_endpoint' => $pushEndpoint,
            'attributes' => $attributes
        ]);

        $args = [
            'subscription' => $this->subscriptionName,
            'pushConfig' => [
                'pushEndpoint' => $pushEndpoint,
                'attributes' => $attributes
            ]
        ];
        $expected = [$this->subscriptionName, $pushConfig, []];

        $this->sendAndAssert('modifyPushConfig', $args, $expected);
    }

    public function testPull()
    {
        $args = [
            'subscription' => $this->subscriptionName,
            'maxMessages' => 10
        ] + $this->pageSize;
        $expected = [$this->subscriptionName, 10, $this->pageSize];
        $this->sendAndAssert('pull', $args, $expected);
    }

    public function testModifyAckDeadline()
    {
        $ackIds = ['1', '2', '3'];
        $ackDeadlineSeconds = 1;

        $args = [
            'subscription' => $this->subscriptionName,
            'ackIds' => $ackIds,
            'ackDeadlineSeconds' => $ackDeadlineSeconds
        ];
        $expected = [$this->subscriptionName, $ackIds, $ackDeadlineSeconds, []];

        $this->sendAndAssert('modifyAckDeadline', $args, $expected);
    }

    public function testAcknowledge()
    {
        $ackIds = ['1', '2', '3'];

        $args = [
            'subscription' => $this->subscriptionName,
            'ackIds' => $ackIds
        ];
        $expected = [$this->subscriptionName, $ackIds, []];

        $this->sendAndAssert('acknowledge', $args, $expected);
    }

    /**
     * @dataProvider iamTypes
     */
    public function testGetIamPolicy($type)
    {
        $args = ['resource' => $this->topicName];
        $expected = [$this->topicName, []];

        $method = sprintf('get%sIamPolicy', $type);
        $this->sendAndAssert($method, $args, $expected);
    }

    /**
     * @dataProvider iamTypes
     */
    public function testSetIamPolicy($type)
    {
        $role = 'test_role';
        $members = ['test_member'];

        $policy = new Policy([
            'bindings' => [
                new Binding([
                    'role' => $role,
                    'members' => $members
                ])
            ]
        ]);

        $args = [
            'resource' => $this->topicName,
            'policy' => [
                'bindings' => [
                    [
                        'role' => $role,
                        'members' => $members
                    ]
                ]
            ]
        ];

        $expected = [$this->topicName, $policy, []];

        $method = sprintf('set%sIamPolicy', $type);
        $this->sendAndAssert($method, $args, $expected);
    }

    /**
     * @dataProvider iamTypes
     */
    public function testTestIamPermissions($type)
    {
        $permissions = ['fake' => 'permissions'];
        $args = ['resource' => $this->topicName, 'permissions' => $permissions];
        $expected = [$this->topicName, $permissions, []];

        $method = sprintf('test%sIamPermissions', $type);
        $this->sendAndAssert($method, $args, $expected);
    }

    public function iamTypes()
    {
        return [
            ['Topic'],
            ['Subscription']
        ];
    }

    public function testDetachSubscription()
    {
        $this->sendAndAssert('detachSubscription', [
            'subscription' => $this->subscriptionName
        ], [$this->subscriptionName, []]);
    }

    private function sendAndAssert($method, array $args, array $expectedArgs, Grpc $connection = null)
    {
        $connection = $connection ?: new Grpc([
            'projectId' => 'foo',
        ]);

        $this->requestWrapper->send(
            Argument::type('callable'),
            $expectedArgs,
            Argument::type('array')
        )->willReturn($this->successMessage);

        $connection->setRequestWrapper($this->requestWrapper->reveal());

        $this->assertEquals($this->successMessage, $connection->$method($args));
    }
}

//@codingStandardsIgnoreStart
class GrpcStub extends Grpc
{
    public $config;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->getPublisherClient();
    }

    protected function constructGapic($gapicName, array $config)
    {
        $this->config = $config;

        return parent::constructGapic($gapicName, $config);
    }
}
//@codingStandardsIgnoreEnd
