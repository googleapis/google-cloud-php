<?php
/**
 * Copyright 201 Google Inc. All Rights Reserved.
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

use Google\Cloud\Storage\Bucket;

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
                'locationType' => Bucket::LOCATION_TYPE_DUAL_REGION,
                'location' => 'nam4',
                'rpo' => Bucket::RPO_ASYNC_TYRBO
            ]
        );

        $this->assertEquals(Bucket::RPO_ASYNC_TYRBO, self::$dualRegionBucket->rpo());
    }

    /**
     * Test updating the RPO on a created bucket
     * @depends testCreateBucketWithRpoSet
     */
    public function testUpdateRpo()
    {
        self::$dualRegionBucket->update(['rpo' => Bucket::RPO_DEFAULT]);
        $this->assertEquals(Bucket::RPO_DEFAULT, self::$dualRegionBucket->rpo());

        self::$dualRegionBucket->update(['rpo' => Bucket::RPO_ASYNC_TYRBO]);
        $this->assertEquals(Bucket::RPO_ASYNC_TYRBO, self::$dualRegionBucket->rpo());
    }

    /**
     * The getter should return RPO value as NULL for a regional bucket
     * The getter should return RPO value as `DEFAULT` for a multi-regional bucket
     */
    public function testGetRpoOnNonDualRegionBucket()
    {
        // self::$bucket is already created in StorageTestCase::setUp
        $this->assertNull(self::$bucket->rpo());

        $bucketMulti = self::createBucket(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            [
                'locationType' => Bucket::LOCATION_TYPE_MULTI_REGION
            ]
        );

        $this->assertEquals(Bucket::RPO_DEFAULT, $bucketMulti->rpo());
    }
}
