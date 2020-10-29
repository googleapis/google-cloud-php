<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Testing\System;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Core\Testing\System\DeletionQueue;
use PHPUnit\Framework\TestCase;

/**
 * SystemTestCase can be extended to implement system tests
 *
 * @experimental
 * @internal
 */
class SystemTestCase extends TestCase
{
    protected static $deletionQueue;

    private static $emulatedClasses = [];
    private static $emulatedClassPrefixes = [];

    /**
     * Set up the deletion queue
     *
     * @experimental
     * @internal
     */
    public static function setupQueue()
    {
        if (!self::$deletionQueue) {
            self::$deletionQueue = new DeletionQueue;
        }
    }

    /**
     * Process the deletion queue
     *
     * @experimental
     * @internal
     */
    public static function processQueue()
    {
        self::$deletionQueue->process();
    }

    /**
     * Create a random integer ID for test entities.
     *
     * @return int
     *
     * @experimental
     * @internal
     */
    public static function randId()
    {
        return rand(1, 9999999);
    }

    /**
     * Create a bucket and enqueue it for deletion.
     *
     * This method provides a means of creating a bucket with pre-configured
     * flush+delete functionality. Use in place of `StorageClient::createBucket()`.
     *
     * When inserting objects into a bucket created with this method, you do NOT need
     * to enqueue those objects for deletion or concern yourself with order of
     * operations.
     *
     * @param StorageClient $client
     * @param string $bucketName
     * @param array $options
     * @return Bucket
     *
     * @experimental
     * @internal
     */
    public static function createBucket(StorageClient $client, $bucketName, array $options = [])
    {
        $backoff = new ExponentialBackoff(8);

        $bucket = $backoff->execute(function () use ($client, $bucketName, $options) {
            return $client->createBucket($bucketName, $options);
        });

        self::$deletionQueue->add(function () use ($bucket) {
            foreach ($bucket->objects() as $object) {
                $object->delete();
            }

            $bucket->delete();
        });

        return $bucket;
    }

    /**
     * Create a dataset and enqueue it for deletion.
     *
     * This method provides a means of creating a dataset with pre-configured
     * flush+delete functionality. Use in place of `BigQueryClient::createDataset()`.
     *
     * When inserting tables into a dataset created with this method, you do NOT need
     * to enqueue those tables for deletion or concern yourself with order of
     * operations.
     *
     * @param BigQueryClient $client
     * @param string $datasetName
     * @param array $options
     * @return Dataset
     *
     * @experimental
     * @internal
     */
    public static function createDataset(BigQueryClient $client, $datasetName, array $options = [])
    {
        $dataset = $client->createDataset($datasetName, $options);

        self::$deletionQueue->add(function () use ($dataset) {
            $dataset->delete(['deleteContents' => true]);
        });

        return $dataset;
    }

    /**
     * Create a topic and enqueue it for deletion.
     *
     * This method provides a means of creating a topic with pre-configured
     * flush+delete functionality. Use in place of `PubSubClient::createTopic()`.
     *
     * When inserting subscriptions into a topic created with this method, you do NOT need
     * to enqueue those subscriptions for deletion or concern yourself with order of
     * operations.
     *
     * @param PubSubClient $client
     * @param string $topicName
     * @param array $options
     * @return Topic
     *
     * @experimental
     * @internal
     */
    public static function createTopic(PubSubClient $client, $topicName, array $options = [])
    {
        $backoff = new ExponentialBackoff(8);

        $topic = $backoff->execute(function () use ($client, $topicName, $options) {
            return $client->createTopic($topicName, $options);
        });

        self::$deletionQueue->add(function () use ($topic) {
            foreach ($topic->subscriptions() as $subscription) {
                $subscription->delete();
            }

            $topic->delete();
        });

        return $topic;
    }

    /**
     * Set "using emulator" flag for single test case.
     *
     * Should be called in `setUpBeforeClass()` method. This will allow to
     * skip tests that are not supported by emulator.
     *
     * Example:
     * ```
     * self::setUsingEmulator(getenv('FOOBAR_EMULATOR_HOST'));
     * ```
     *
     * @param bool $enabled Whether emulator is detected. **Defaults to** `true`.
     */
    public static function setUsingEmulator($enabled = true)
    {
        self::$emulatedClasses[get_called_class()] = (bool)$enabled;
    }

    /**
     * Set "using emulator" flag for test cases with specified fully-qualified name prefix.
     *
     * Should be called in `setUpBeforeClass()` method. This will allow to
     * skip tests that are not supported by emulator.
     *
     * Example:
     * ```
     * // Set flag for called class namespace.
     * self::setUsingEmulatorForClassPrefix(getenv('FOOBAR_EMULATOR_HOST'));
     * ```
     *
     * ```
     * // Set flag for some other namespace.
     * self::setUsingEmulatorForClassPrefix(getenv('FOOBAR_EMULATOR_HOST'), 'Foobar\\Tests\\System\\Admin\\');
     * ```
     *
     * @param bool $enabled Whether emulator is detected. **Defaults to** `true`.
     * @param string|null $prefix Fully-qualified class name prefix. **Defaults to** called class namespace.
     */
    public static function setUsingEmulatorForClassPrefix($enabled = true, $prefix = null)
    {
        if (!isset($prefix)) {
            $className = get_called_class();
            $prefix = substr($className, 0, strrpos($className, '\\') + 1);
        }
        self::$emulatedClassPrefixes[$prefix] = (bool)$enabled;
    }

    /**
     * Returns `true` when "using emulator" flag is set either for called class name or its
     * fully-qualified name prefix or `false` otherwise.
     *
     * Example:
     * ```
     * $transports = [['grpc']];
     * if (!self::isEmulatorUsed()) {
     *     $transports[] = ['rest'];
     * }
     * ```
     *
     * @return bool
     */
    public static function isEmulatorUsed()
    {
        $className = get_called_class();
        if (!isset(self::$emulatedClasses[$className])) {
            $prefix = substr($className, 0, strrpos($className, '\\') + 1);
            $isEmulated = false;
            foreach (self::$emulatedClassPrefixes as $key => $flag) {
                if (strpos($prefix, $key) === 0) {
                    $isEmulated = $flag;
                    break;
                }
            }
            self::$emulatedClasses[$className] = $isEmulated;
        }
        return self::$emulatedClasses[$className];
    }

    /**
     * Skips current test (when called from test method) or entire test case (when called from `setUpBeforeClass()`)
     * if "using emulator" flag is set either for called class name or its fully-qualified name prefix.
     *
     * Example:
     * ```
     * // Use default reason.
     * self::skipIfEmulatorUsed();
     * ```
     *
     * ```
     * // Use custom reason.
     * self::skipIfEmulatorUsed('Administration functions are not supported by emulator.');
     * ```
     *
     * @param string|null $reason Message explaining reason for skipping this test.
     */
    public static function skipIfEmulatorUsed($reason = null)
    {
        if (self::isEmulatorUsed()) {
            self::markTestSkipped($reason ?: 'This test is not supported by the emulator.');
        }
    }
}
