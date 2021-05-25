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

namespace Google\Cloud\Compute\Tests\System\V1;

use Google\Cloud\Compute\V1\Address;
use Google\Cloud\Compute\V1\AddressesClient;
use Google\Cloud\Compute\V1\RegionOperationsClient;
use Google\Cloud\Core\Testing\System\SystemTestCase;

class AddressTest extends SystemTestCase
{
    const REGION = 'us-central1';
    protected static $addressesClient;
    protected static $projectId;
    protected static $name;
    protected static $regionOperationsClient;
    private static $dirty;

    public static function setUpBeforeClass(): void
    {
        self::$projectId = getenv('PROJECT_ID');
        if (self::$projectId === false) {
            self::fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        self::$addressesClient = new AddressesClient();
        self::$regionOperationsClient = new RegionOperationsClient();
    }

    public function setUp(): void
    {
        self::$name = "gapicphp" . strval(rand(100000, 999999));
        self::$dirty = false;
    }

    public function tearDown(): void
    {
        if (self::$dirty == true) {
            self::$addressesClient->delete(self::$name, self::$projectId, self::REGION);
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$addressesClient->close();
    }

    private function insertAddress(): void
    {
        $addressResource = new Address();
        $addressResource->setName(self::$name);
        $op = self::$addressesClient->insert($addressResource, self::$projectId, self::REGION);
        $this->waitForRegionalOp($op);
        self::$dirty = true;
    }

    private function waitForRegionalOp($operation): void
    {
        self::$regionOperationsClient->wait($operation->getName(), self::$projectId, self::REGION);
    }

    public function testInsert(): void
    {
        $this->insertAddress();
        $address = self::$addressesClient->get(self::$name, self::$projectId, self::REGION);
        self::assertEquals($address->getName(), self::$name);
    }

    public function testList(): void
    {
        $this->insertAddress();
        $presented = false;
        $addressList = self::$addressesClient->list(self::$projectId, self::REGION);
        foreach ($addressList->iterateAllElements() as $element) {
            $name = $element->getName();
            if ($name == self::$name){
                $presented = true;
            }
        }
        self::assertEquals(true, $presented);
    }

    public function testDelete(): void
    {
        $this->insertAddress();
        $op = self::$addressesClient->delete(self::$name, self::$projectId, self::REGION);
        $this->waitForRegionalOp($op);
        self::$dirty = false;
    }
}
