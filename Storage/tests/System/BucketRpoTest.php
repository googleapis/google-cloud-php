<?php
/**
 * Copyright 2021 Google Inc. All Rights Reserved.
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

/**
 * @group storage
 * @group storage-rpo
 */
class BucketRpoTest extends StorageTestCase
{
    private static $dualRegionBucket;

    /**
     * Test creating a dual-region bucket with RPO already set
     */
    public function testCreateBucketWithRpoSet()
    {
        self::$dualRegionBucket = self::createBucket(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            [
                'locationType' => 'dual-region',
                'location' => 'nam4',
                'rpo' => 'ASYNC_TURBO',
            ]
        );

        $this->assertEquals('ASYNC_TURBO', self::$dualRegionBucket->info()['rpo']);
    }

    /**
     * Test updating the RPO on a created bucket
     * @depends testCreateBucketWithRpoSet
     */
    public function testUpdateRpo()
    {
        self::$dualRegionBucket->update(['rpo' => 'DEFAULT']);
        $this->assertEquals('DEFAULT', self::$dualRegionBucket->info()['rpo']);

        self::$dualRegionBucket->update(['rpo' => 'ASYNC_TURBO']);
        $this->assertEquals('ASYNC_TURBO', self::$dualRegionBucket->info()['rpo']);
    }

    /**
     * The getter should return RPO value as NULL for a regional bucket
     * The getter should return RPO value as `DEFAULT` for a multi-regional bucket
     */
    public function testGetRpoOnNonDualRegionBucket()
    {
        // self::$bucket is already created in StorageTestCase::setUp
        $this->assertArrayNotHasKey('rpo', self::$bucket->info());

        $bucketMulti = self::createBucket(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            [
                'locationType' => 'multi-region',
            ]
        );

        $this->assertEquals('DEFAULT', $bucketMulti->info()['rpo']);
    }
}
