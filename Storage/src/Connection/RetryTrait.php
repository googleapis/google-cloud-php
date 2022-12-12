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
    private $httpRetryMessages = [
        'reset-connection'
    ];
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

    /**
     * Return a retry decider function.
     */
    public function getRestRetryFunction($resource, $method, $args)
    {
        if (isset($options['restRetryFunction'])) {
            return $options['restRetryFunction'];
        }
        $methodName = $resource . "." . $method;
        $maxRetries = isset($args['retries']) ? (int) $args['retries'] : 3;
        $isOpNonIdempotent = !isset($this->opsDescriptionMap[$methodName]);
        $isOpIdempotent = (!$isOpNonIdempotent and ($this->opsDescriptionMap[$methodName] === "idempotent") );
        $preconditionNeeded = (!$isOpNonIdempotent and ($this->opsDescriptionMap[$methodName] === "idempotent_with_precondition"));
        $preconditionSupplied = ($preconditionNeeded and $this->isPreConditionSupplied($methodName, $args));

        return function (\Exception $exception, $currentAttempt) use (
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


    private function isPreConditionSupplied($methodName, $preConditions)
    {
        return !empty(array_intersect(
            $this->preConditionMap[$methodName],
            array_keys($preConditions)
        )
        );
    }


    private function retryDeciderFunction(
        \Exception $exception,
        $currentAttempt,
        $isIdempotent,
        $preconditionNeeded,
        $preconditionSupplied,
        $maxRetries
    ) {
        // TODO: return if a custom deciding factor is supplied by the user.
        // a custom factor might be a config like, 'retry' => 'always' or 'retry' => 'never'
        // always retry the idempotent op
        if ($maxRetries < $currentAttempt) {
            return false;
        }

        $statusCode = $exception->getCode();

        if (in_array($statusCode, $this->httpRetryCodes)) {
            if ($isIdempotent) {
                return true;
            }
            // if the op needs a precondition,
            // only retry if the precondition is supplied.
            elseif ($preconditionNeeded) {
                return $preconditionSupplied;
            }
        }

        $message = ($exception instanceof RequestException && $exception->hasResponse())
        ? (string) $exception->getResponse()->getBody()
        : $exception->getMessage();

        try {
            $message = $this->jsonDecode(
                $message,
                true
            );
        } catch (\InvalidArgumentException $exception) {
            return false;
        }

        if (!isset($message['error']['errors'])) {
            return false;
        }

        foreach ($message['error']['errors'] as $error) {
            if (in_array($error['reason'], $this->httpRetryMessages)) {
                return true;
            }
        }
        
        return false;
    }
}
