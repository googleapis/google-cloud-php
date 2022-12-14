<?php
/**
 * Copyright 2022 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage\Connection;

/**
 * Trait which provides helper methods for retry logic.
 */
trait RetryTrait
{
    /**
     * @var array
     */
    private $httpRetryCodes = [
        0, // connetion-refused OR connection-reset gives status code of 0
        408,
        429,
        500,
        502,
        503,
        504
    ];

    /**
     * @var array
     */
    private $opsDescriptionMap = [
        'bucket_acl.get' => 'idempotent',
        'bucket_acl.list' => 'idempotent',
        'buckets.delete' => 'idempotent',
        'buckets.get' => 'idempotent',
        'buckets.getIamPolicy' => 'idempotent',
        'buckets.insert' => 'idempotent',
        'buckets.list' => 'idempotent',
        'buckets.lockRetentionPolicy' => 'idempotent',
        'buckets.testIamPermissions' => 'idempotent',
        'default_object_acl.get' => 'idempotent',
        'default_object_acl.list"' => 'idempotent',
        'hmacKey.delete' => 'idempotent',
        'hmacKey.get' => 'idempotent',
        'hmacKey.list' => 'idempotent',
        'notifications.delete' => 'idempotent',
        'notifications.get' => 'idempotent',
        'notifications.list' => 'idempotent',
        'object_acl.get' => 'idempotent',
        'object_acl.list' => 'idempotent',
        'objects.get' => 'idempotent',
        'objects.list' => 'idempotent',
        'serviceaccount.get' => 'idempotent',
        'buckets.patch' => 'idempotent_with_precondition',
        'buckets.setIamPolicy' => 'idempotent_with_precondition',
        'buckets.update' => 'idempotent_with_precondition',
        'hmacKey.update' => 'idempotent_with_precondition',
        'objects.compose' => 'idempotent_with_precondition',
        'objects.copy' => 'idempotent_with_precondition',
        'objects.delete' => 'idempotent_with_precondition',
        'objects.insert' => 'idempotent_with_precondition',
        'objects.patch' => 'idempotent_with_precondition',
        'objects.rewrite' => 'idempotent_with_precondition',
        'objects.update' => 'idempotent_with_precondition'
    ];

    /**
     * @var array
     */
    private $preConditionMap = [
        'buckets.patch' => ['ifMetagenerationMatch'],
        // Currently etag is not supported, so this preCondition never available
        'buckets.setIamPolicy' => ['etag'],
        'buckets.update' => ['ifMetagenerationMatch'],
        'hmacKey.update' => ['etag'],
        'objects.compose' => ['ifGenerationMatch'],
        'objects.copy' => ['ifGenerationMatch'],
        'objects.delete' => ['ifGenerationMatch'],
        'objects.insert' => ['ifGenerationMatch'],
        'objects.patch' => ['ifMetagenerationMatch'],
        'objects.rewrite' => ['ifGenerationMatch'],
        'objects.update' => ['ifMetagenerationMatch']
    ];

    private static $idempotent = "idempotent";
    private static $cond_idempotent = "idempotent_with_precondition";


    /**
     * Return a retry decider function.
     *
     * @param string $resource resource name, eg: buckets.
     * @param string $method method name, eg: get
     * @param array $args
     * @return array
     */
    public function getRestRetryFunction($resource, $method, $args)
    {
        if (isset($options['restRetryFunction'])) {
            return $options['restRetryFunction'];
        }
        $methodName = sprintf('%s.%s', $resource, $method);
        $maxRetries = (int) (isset($args['retries']) ? $args['retries'] : 3);
        $isOpNonIdempotent = !isset($this->opsDescriptionMap[$methodName]);
        $isOpIdempotent = (!$isOpNonIdempotent and
            ($this->opsDescriptionMap[$methodName] === self::$idempotent));
        $preconditionNeeded = (!$isOpNonIdempotent and
            ($this->opsDescriptionMap[$methodName] === self::$cond_idempotent));
        $preconditionSupplied = $this->isPreConditionSupplied($methodName, $args);

        return function (
            \Exception $exception,
            $currentAttempt
        ) use (
            $isOpIdempotent,
            $preconditionNeeded,
            $preconditionSupplied,
            $maxRetries
        ) {
            return $this->retryDeciderFunction(
                $exception,
                $currentAttempt,
                $isOpIdempotent,
                $preconditionNeeded,
                $preconditionSupplied,
                $maxRetries
            );
        };
    }


    /**
     * Check whether the required preconditions are provided.
     *
     * @param string $methodName method name, eg: buckets.get.
     * @param array $preConditions preconditions provided,
     *  eg: ['ifGenerationMatch' => 0].
     * @return boolean
     */
    private function isPreConditionSupplied($methodName, $preConditions)
    {
        if (isset($this->preConditionMap[$methodName])) {
            // return true if required precondition are given.
            return !empty(array_intersect(
                $this->preConditionMap[$methodName],
                array_keys($preConditions)
            ));
        }
    }


    /**
     * Decide whether the op needs to be retried or not.
     *
     * @param Exception $exception op failure exception.
     * @param int $currentAttempt current attempt number.
     * @param boolean $isIdempotent
     * @param boolean $preconditionNeeded
     * @param boolean $preconditionSupplied
     * @param int $maxRetries
     * @return boolean
     */
    private function retryDeciderFunction(
        \Exception $exception,
        $currentAttempt,
        $isIdempotent,
        $preconditionNeeded,
        $preconditionSupplied,
        $maxRetries
    ) {
        // No retry if maxRetries reached
        if ($maxRetries <= $currentAttempt) {
            return false;
        }

        $statusCode = $exception->getCode();

        // Retry if the exception status code matches
        // with one of the retriable status code and
        // the operation is either idempotent or conditionally
        // idempotent with preconditions supplied.
        if (in_array($statusCode, $this->httpRetryCodes)) {
            if ($isIdempotent) {
                return true;
            } elseif ($preconditionNeeded) {
                return $preconditionSupplied;
            }
        }

        return false;
    }
}
