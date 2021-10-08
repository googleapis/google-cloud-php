<?php
/**
 * Copyright 2021 Google Inc.
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

namespace Google\Cloud\Storage\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Prophecy\Argument;

class BucketRpoTest extends TestCase
{
    const BUCKET_NAME = 'my-rpo-bucket';
    const PROJECT_ID = 'my-project';
    const BUCKET_LOCATION = 'nam4';

    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
    }

    private function getBucket($data = [])
    {
        return new Bucket(
            $this->connection->reveal(),
            self::BUCKET_NAME,
            $data
        );
    }

    private function modifyPatchResponse($data)
    {
        $this->connection->patchBucket(Argument::any())->willReturn($data);
    }

    /**
     * RPO can be set only a dual-region bucket, so we make sure isDualRegion() works fine
     */
    public function testIsDualRegion()
    {
        $data = [
            'locationType' => Bucket::LOCATION_TYPE_DUAL_REGION,
            'location' => self::BUCKET_LOCATION
        ];

        $bucket = $this->getBucket($data);

        $this->assertTrue($bucket->isDualRegion());

        $data['locationType'] = Bucket::LOCATION_TYPE_MULTI_REGION;
        $bucket = $this->getBucket($data);
        $this->assertFalse($bucket->isDualRegion());

        $data['locationType'] = Bucket::LOCATION_TYPE_SINGLE_REGION;
        $bucket = $this->getBucket($data);
        $this->assertFalse($bucket->isDualRegion());
    }

    /**
     * Test for the getter method rpo() on the Bucket instance
     */
    public function testGetRpo()
    {
        $data = [
            'locationType' => Bucket::LOCATION_TYPE_DUAL_REGION,
            'location' => self::BUCKET_LOCATION,
            'rpo' => Bucket::RPO_DEFAULT
        ];

        $bucket = $this->getBucket($data);
        $this->assertEquals($bucket->rpo(), Bucket::RPO_DEFAULT);

        $data['rpo'] = Bucket::RPO_ASYNC_TYRBO;
        $bucket = $this->getBucket($data);
        $this->assertEquals($bucket->rpo(), Bucket::RPO_ASYNC_TYRBO);
    }

    /**
     * Test the update of RPO on a bucket b/w DEFAULT and ASYNC_TURBO
     */
    public function testUpdateRpo()
    {
        $data = [
            'locationType' => Bucket::LOCATION_TYPE_DUAL_REGION,
            'location' => self::BUCKET_LOCATION,
            'rpo' => Bucket::RPO_DEFAULT
        ];

        $bucket = $this->getBucket($data);
        $this->modifyPatchResponse(array_merge($data, ['rpo' => Bucket::RPO_ASYNC_TYRBO]));
        $bucket->update(['rpo' => Bucket::RPO_ASYNC_TYRBO]);
        $this->assertEquals(Bucket::RPO_ASYNC_TYRBO, $bucket->rpo());

        $this->modifyPatchResponse(array_merge($data, ['rpo' => Bucket::RPO_DEFAULT]));
        $bucket->update(['rpo' => Bucket::RPO_DEFAULT]);
        $this->assertEquals(Bucket::RPO_DEFAULT, $bucket->rpo());
    }
}
