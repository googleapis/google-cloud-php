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

use Google\Cloud\Core\Iam\IamConnectionInterface;

/**
 * Proxy IAM service calls to the Pub/Sub Subscription IAM resources
 */
class IamSubscription implements IamConnectionInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @param  ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  array $args
     */
    public function getPolicy(array $args)
    {
        return $this->connection->getSubscriptionIamPolicy($args);
    }

    /**
     * @param  array $args
     */
    public function setPolicy(array $args)
    {
        return $this->connection->setSubscriptionIamPolicy($args);
    }

    /**
     * @param  array $args
     */
    public function testPermissions(array $args)
    {
        return $this->connection->testSubscriptionIamPermissions($args);
    }
}
