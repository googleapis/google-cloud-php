<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Bigtable\Tests\System;

use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Core\LongRunning\LongRunningOperation;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class InstanceTest extends BigtableSystemTestCase
{

    const INSTANCE_ID = 'google-cloud-php-system-tests-instance';
    const CLUSTER_ID = 'google-cloud-php-system-tests-cluster';
    const LOCATION_ID = 'us-east1-b';

    public function testInstance()
    {
        $client = self::$client;

        $instance = $client->instance(self::INSTANCE_ID);
        $op = $instance->create([Instance::buildClusterMetadata(self::CLUSTER_ID, self::LOCATION_ID, null, 3)]);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
        $instance->delete();
    }
}
