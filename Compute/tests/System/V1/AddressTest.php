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

use Google\ApiCore\ApiException;
use Google\Cloud\Compute\V1\Address;
use Google\Cloud\Compute\V1\AddressesClient;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    const REGION = 'us-central1';
    protected static $addressesClient;
    protected static $projectId;
    protected static $name;

    public static function setUpBeforeClass(): void
    {
        self::$projectId = getenv('PROJECT_ID');
        if (self::$projectId === false) {
            self::fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        self::$addressesClient = new AddressesClient();
        self::$name = "gapicphp" . strval(rand(100000, 999999));
    }

    public static function tearDownAfterClass(): void
    {
        self::$addressesClient->close();
    }

    public function testInsert(): void
    {
        $addressResource = new Address();
        $addressResource->setName(self::$name);
        $op = self::$addressesClient->insert($addressResource, self::$projectId, self::REGION);
        $op->pollUntilComplete();
        $this->assertTrue($op->operationSucceeded(),
            sprintf("Operation %s failed. Error: %s", $op->getName(), $op->getError()->getMessage()));
        $address = self::$addressesClient->get(self::$name, self::$projectId, self::REGION);
        $this->assertEquals($address->getName(), self::$name);
    }

    /**
     * @depends testInsert
     */
    public function testList(): void
    {
        $presented = false;
        $addressList = self::$addressesClient->list(self::$projectId, self::REGION);
        foreach ($addressList->iterateAllElements() as $element) {
            $name = $element->getName();
            if ($name == self::$name){
                $presented = true;
            }
        }
        $this->assertEquals(true, $presented);
    }

    /**
     * @depends testInsert
     */
    public function testDelete(): void
    {
        $op = self::$addressesClient->delete(self::$name, self::$projectId, self::REGION);
        $op->pollUntilComplete();
        $this->assertTrue($op->operationSucceeded(),
            sprintf("Operation %s failed. Error: %s", $op->getName(), $op->getError()->getMessage()));
        try {
            self::$addressesClient->get(self::$name, self::$projectId, self::REGION);
            $this->fail('The deleted instance still exists');
        } catch (ApiException $e) {
            $this->assertEquals(404, $e->getCode());
        }
    }
}
