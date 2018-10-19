<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage\Tests\System;

use Google\Cloud\Core\Exception\ServiceException;

/**
 * @group storage
 * @group storage-bucket
 * @group storage-bucket-lock
 */
class BucketLockRetentionPolicyTest extends StorageTestCase
{
    public function testLockRetentionPolicy()
    {
        $bucket = self::createBucket(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            [
                'retentionPolicy' => [
                    'retentionPeriod' => 10
                ]
            ]
        );
        $object = $bucket->upload('test', [
            'name' => 'test.txt'
        ]);
        $bucket->lockRetentionPolicy();

        $this->assertTrue(
            $bucket->info()['retentionPolicy']['isLocked']
        );

        try {
            $object->delete();
        } catch (ServiceException $ex) {
            $this->assertEquals(403, $ex->getCode());
        }

        sleep(10); // Wait for the retention period to expire.
        $this->assertNull($object->delete()); // Assert the deletion actually occurs.
    }
}
