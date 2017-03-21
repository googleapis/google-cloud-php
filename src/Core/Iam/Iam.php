<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Iam;

/**
 * IAM Manager
 *
 * This class is not meant to be used directly. It should be accessed
 * through other objects which support IAM.
 *
 * Note that examples make use of the PubSub API, and the
 * {@see Google\Cloud\PubSub\Topic} class.
 *
 * Policies can be created using the {@see Google\Cloud\Core\Iam\PolicyBuilder}
 * to help ensure their validity.
 *
 * Example:
 * ```
 * // IAM policies are obtained via resources which implement IAM.
 * // In this example, we'll use PubSub topics to demonstrate
 * // how IAM politices are managed.
 *
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * $topic = $pubsub->topic('my-new-topic');
 *
 * $iam = $topic->iam();
 * ```
 */
class Iam
{
    /**
     * @var IamConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $resource;

    /**
     * @var array
     */
    private $policy;

    /**
     * @param  IamConnectionInterface $connection
     * @param  string $resource
     * @access private
     */
    public function __construct(IamConnectionInterface $connection, $resource)
    {
        $this->connection = $connection;
        $this->resource = $resource;
    }

    /**
     * Get the existing IAM policy for this resource.
     *
     * If a policy has already been retrieved from the API, it will be returned.
     * To fetch a fresh copy of the policy, use
     * {@see Google\Cloud\Core\Iam\Iam::reload()}.
     *
     * Example:
     * ```
     * $policy = $iam->policy();
     * ```
     *
     * @param  array $options Configuration Options
     * @return array An array of policy data
     */
    public function policy(array $options = [])
    {
        if (!$this->policy) {
            $this->reload($options);
        }

        return $this->policy;
    }

    /**
     * Set the IAM policy for this resource.
     *
     * Bindings with invalid roles, or non-existent members will raise a server
     * error.
     *
     * Example:
     * ```
     * $oldPolicy = $iam->policy();
     * $oldPolicy['bindings'][0]['members'] = 'user:test@example.com';
     *
     * $policy = $iam->setPolicy($oldPolicy);
     * ```
     *
     * @param  array $policy A new policy array
     * @param  array $options Configuration Options
     * @return array An array of policy data
     */
    public function setPolicy(array $policy, array $options = [])
    {
        return $this->policy = $this->connection->setPolicy($options + [
            'policy' => $policy,
            'resource' => $this->resource
        ]);
    }

    /**
     * Test if the current user has the given permissions on this resource.
     *
     * Invalid permissions will raise a BadRequestException.
     *
     * Example:
     * ```
     * $allowedPermissions = $iam->testPermissions([
     *     'pubsub.topics.publish',
     *     'pubsub.topics.attachSubscription'
     * ]);
     * ```
     *
     * @param  array $permissions A list of permissions to test
     * @param  array $options Configuration Options
     * @return array A subset of $permissions, with only those allowed included.
     */
    public function testPermissions(array $permissions, array $options = [])
    {
        return $this->connection->testPermissions($options + [
            'permissions' => $permissions,
            'resource' => $this->resource
        ]);
    }

    /**
     * Refresh the IAM policy for this resource.
     *
     * Example:
     * ```
     * $policy = $iam->reload();
     * ```
     *
     * @param  array $options Configuration Options
     * @return array An array of policy data
     */
    public function reload(array $options = [])
    {
        return $this->policy = $this->connection->getPolicy($options + [
            'resource' => $this->resource
        ]);
    }
}
