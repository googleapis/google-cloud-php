<?php
/**
 * Copyright 2024 Google Inc. All Rights Reserved.
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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Iam\PolicyBuilder;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\GetPolicyOptions;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use InvalidArgumentException;

/**
 * IAM Manager
 *
 * This class is not meant to be used directly. It should be accessed
 * through other objects which support IAM.
 *
 * Policies can be created using the {@see PolicyBuilder}
 * to help ensure their validity.
 *
 * Example:
 * ```
 * // IAM policies are obtained via resources which implement IAM.
 * // In this example, we'll use PubSub topics to demonstrate
 * // how IAM policies are managed.
 *
 * use Google\Cloud\PubSub\PubSubClient;
 *
 * $pubsub = new PubSubClient();
 * $topic = $pubsub->topic('my-new-topic');
 *
 * $iam = $topic->iam();
 * ```
 *
 * @internal
 */
class IamManager
{
    use ArrayTrait;

    private RequestHandler $requestHandler;
    private Serializer $serializer;
    private string $clientClass;
    private string $resource;
    private ?array $policy;

    /**
     * @param RequestHandler $requestHandler
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $clientClass The client class that will be passed on to the
     * sendRequest method of the $requestHandler.
     * @param string $resource
     * @access private
     */
    public function __construct(
        RequestHandler $requestHandler,
        Serializer $serializer,
        string $clientClass,
        string $resource
    ) {
        $this->requestHandler = $requestHandler;
        $this->serializer = $serializer;
        $this->clientClass = $clientClass;
        $this->resource = $resource;
        $this->policy = null;
    }

    /**
     * Get the existing IAM policy for this resource.
     *
     * If a policy has already been retrieved from the API, it will be returned.
     * To fetch a fresh copy of the policy, use
     * {@see IamManager::reload()}.
     *
     * Example:
     * ```
     * $policy = $iam->policy();
     * ```
     *
     * @param  array $options Configuration Options
     * @param  int   $options['requestedPolicyVersion'] Specify the policy version to
     *     request from the server. Please see
     *     [policy versioning](https://cloud.google.com/iam/docs/policies#versions)
     *     for more information.
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
     * $policy = [
     *      'bindings' => [[
     *          'role' => 'roles/editor',
     *          'members' => ['user:test@example.com'],
     *      ]]
     * ];
     * $policy = $iam->setPolicy($policy);
     * ```
     * ```
     * $oldPolicy = $iam->policy();
     * $oldPolicy['bindings'][0]['members'] = 'user:test@example.com';
     *
     * $policy = $iam->setPolicy($oldPolicy);
     * ```
     *
     * @param  array|PolicyBuilder $policy The new policy, as an array or an
     *         instance of {@see PolicyBuilder}.
     * @param  array $options Configuration Options
     * @return array An array of policy data
     * @throws InvalidArgumentException If the given policy is not an array or PolicyBuilder.
     */
    public function setPolicy($policy, array $options = [])
    {
        if ($policy instanceof PolicyBuilder) {
            $policy = $policy->result();
        }

        if (!is_array($policy)) {
            throw new InvalidArgumentException('Given policy data must be an array or an instance of PolicyBuilder.');
        }

        $policy = $this->serializer->decodeMessage(
            new Policy,
            $policy
        );

        $updateMask = $options['updateMask'] ?? [];

        $data = ['resource' => $this->resource, 'policy' => $policy, 'updateMask' => $updateMask];
        $request = $this->serializer->decodeMessage(new SetIamPolicyRequest(), $data);

        $this->policy = $this->requestHandler->sendRequest(
            $this->clientClass,
            'setIamPolicy',
            $request,
            $options
        );

        return $this->policy;
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
        $data = ['resource' => $this->resource, 'permissions' => $permissions];
        $request = $this->serializer->decodeMessage(new TestIamPermissionsRequest(), $data);
        $res = $this->requestHandler->sendRequest(
            $this->clientClass,
            'testIamPermissions',
            $request,
            $options
        );

        return isset($res['permissions']) ? $res['permissions'] : [];
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
        $policyOptions = $this->pluck('policyOptions', $options, false) ?: [];
        $policyOptions = $this->serializer->decodeMessage(new GetPolicyOptions(), $policyOptions);
        $data = ['resource' => $this->resource, 'options' => $policyOptions];
        $request = $this->serializer->decodeMessage(new GetIamPolicyRequest(), $data);

        $this->policy = $this->requestHandler->sendRequest(
            $this->clientClass,
            'getIamPolicy',
            $request,
            $options
        );

        return $this->policy;
    }
}
