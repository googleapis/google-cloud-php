<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Storage\Tests\Unit\Connection;

use Google\Cloud\Storage\Connection\RetryTrait;
use Google\Cloud\Storage\StorageClient;
use PHPUnit\Framework\TestCase;

/**
 * @group storage
 */
class RetryTraitTest extends TestCase
{
    /**
     * Tests the truthy case of isPreconditionSupplied
     * We simply pass in an operation that is conditionally idempotent
     * and we also pass a valid precondition to thet op.
     */
    public function testIsPreconditionSuppliedWithValidPrecondition()
    {
        $retry = new RetryTraitImpl([]);
        $result = $retry->isPreConditionSupplied('buckets.patch', ['ifMetagenerationMatch' => 1]);
        $this->assertTrue($result);
    }

    /**
     * Tests the falsy case of isPreconditionSupplied
     * We simply pass in an operation that is conditionally idempotent
     * but we don't pass any precondition or we pass an invalid
     * precondition to that particular op.
     */
    public function testIsPreconditionSuppliedWithInvalidPrecondition()
    {
        $retry = new RetryTraitImpl([]);
        $result = $retry->isPreConditionSupplied('buckets.patch', []);
        $this->assertFalse($result);
    }

    /**
     * Tests another falsy case of isPreconditionSupplied
     * We simply pass in an operation that is not conditionally
     * idempotent. With that it shouldn't matter if the precondition
     * is actually passed or not.
     */
    public function testIsPreconditionSuppliedWithInvalidOp()
    {
        $retry = new RetryTraitImpl([]);
        $result = $retry->isPreConditionSupplied('bucket_acl.get', ['ifMetagenerationMatch' => 1]);
        $this->assertFalse($result);
    }

    /**
     * @dataProvider retryFunctionReturnValues
     */
    public function testRetryFunction(
        $resource,
        $op,
        $restConfig,
        $args,
        $errorCode,
        $currAttempt,
        $expected
    ) {
        $retry = new RetryTraitImpl([]);
        $retryFun = $retry->getRestRetryFunction($resource, $op, $args);

        $this->assertEquals(
            $expected,
            $retryFun(new \Exception('', $errorCode), $currAttempt)
        );
    }

    public function retryFunctionReturnValues()
    {
        return [
            // Idempotent operation with retriable error code
            ['buckets', 'get', [], [], 503, 1, true],
            ['serviceaccount', 'get', [], [], 504, 1, true],
            // Idempotent operation with non retriable error code
            ['buckets', 'get', [], [], 400, 1, false],
            // Conditionally Idempotent with retriable error code
            // correct precondition provided
            ['buckets', 'update', [], ['ifMetagenerationMatch' => 0], 503, 1, true],
            // Conditionally Idempotent with retriable error code
            // wrong precondition provided
            ['buckets', 'update', [], ['ifGenerationMatch' => 0], 503, 1, false],
            // Conditionally Idempotent with non retriable error code
            // precondition provided
            ['buckets', 'update', [], ['ifMetagenerationMatch' => 0], 400, 1, false],
            // Conditionally Idempotent with retriable error code
            // precondition not provided
            ['buckets', 'update', [], [], 503, 1, false],
            // Conditionally Idempotent with non retriable error code
            // precondition not provided
            ['buckets', 'update', [], [], 400, 1, false],
            // Non idempotent
            ['bucket_acl', 'delete', [], [], 503, 2, false],
            ['bucket_acl', 'delete', [], [], 400, 3, false],
        ];
    }

    /**
     * Checks different cases for the retry strategy.
     * Essentially there are 4 cases(if an error is retryable):
     * - When the strategy is 'always', we retry the error,
     *      regardless of the operation type.
     * - When the strategy is 'never' we simply don't retry ever.
     *      even if the op is idempotent etc.
     * - When the strategy is idempotent(default),
     *      the decidion is based on the op context.
     */
    public function retryStrategyProvider()
    {
        return [
            // The op is a conditionally idempotent operation,
            // but it should still be retried because we pass the strategy as 'always'
            [false, true, false, StorageClient::RETRY_ALWAYS, true],
            // The op is an idempotent operation,
            // but it should still not be retried because we pass the strategy as 'never'
            [true, false, false, StorageClient::RETRY_NEVER, false],
            // The op is a conditionally idempotent operation,
            // so, the decision is based on the status of the precondition supplied by the user
            [false, true, false, StorageClient::RETRY_IDEMPOTENT, false],
            [false, true, true, StorageClient::RETRY_IDEMPOTENT, true],
        ];
    }

    /**
     * @dataProvider retryStrategyProvider
     */
    public function testRetryStrategy(
        bool $isIdempotent,
        bool $condIdempotent,
        bool $preconditionSupplied,
        string $strategy,
        bool $expected
    ) {
        // We intentionally pass a retryable exception
        // so that the decision is completely based on the retry strategy
        $retryAbleException = new \Exception("", 503);

        $retry = new RetryTraitImpl();
        $shouldRetry = $retry->retryDeciderFunction(
            $retryAbleException,
            $isIdempotent,
            $condIdempotent,
            $preconditionSupplied,
            $strategy
        );

        $this->assertEquals($shouldRetry, $expected);
    }
}

//@codingStandardsIgnoreStart
class RetryTraitImpl
{
    use RetryTrait {
        getRestRetryFunction as public;
        isPreConditionSupplied as public;
        retryDeciderFunction as public;
    }
}
