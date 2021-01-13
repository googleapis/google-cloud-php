<?php
/**
 * Copyright 2020 Google Inc.
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
use Google\ApiCore\ValidationException;
use Google\Cloud\Compute\V1\AccessConfig;
use Google\Cloud\Compute\V1\AttachedDisk;
use Google\Cloud\Compute\V1\AttachedDiskInitializeParams;
use Google\Cloud\Compute\V1\Instance;
use Google\Cloud\Compute\V1\InstancesClient;
use Google\Cloud\Compute\V1\NetworkInterface;
use Google\Cloud\Compute\V1\Operation\Status;
use Google\Cloud\Compute\V1\ZoneOperationsClient;
use Google\Cloud\Core\Testing\System\SystemTestCase;

/**
 * @group compute
 * @group gapic
 */
class SmokeTest extends SystemTestCase
{
    const ZONE = 'us-central1-a';
    const IMAGE = 'https://www.googleapis.com/compute/v1/projects/debian-cloud/global/images/debian-7-wheezy-v20150710';

    protected static $instancesClient;
    protected static $projectId;
    protected static $machineType;

    public static function setUpBeforeClass(): void
    {
        self::$projectId = getenv('PROJECT_ID');
        if (self::$projectId === false) {
            self::fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        self::$instancesClient = new InstancesClient();
        self::$machineType = sprintf(
            'https://www.googleapis.com/compute/v1/projects/%s/zones/%s/machineTypes/n1-standard-1',
            self::$projectId,
            self::ZONE
        );
    }

    public static function tearDownAfterClass(): void
    {
        self::$instancesClient->close();
    }

    public function testInsertInstance()
    {
        $name = "gapicphp" . strval(rand($min = 100000, $max = 999999));
        $disk = new AttachedDisk([
            'boot' => true,
             "auto_delete" => true,
             "type" => 0,
            'initialize_params' => new AttachedDiskInitializeParams([
                'source_image' => self::IMAGE
            ]),
        ]);
        $access_configs = new AccessConfig(['name' => 'default']);
        $network_config = new NetworkInterface([
            'access_configs' => [$access_configs]
        ]);
        $instanceResource = new Instance([
            'name' => $name,
            'machine_type' => self::$machineType,
            'network_interfaces' => [$network_config],
            'disks' => [$disk],
        ]);
        $operation = self::$instancesClient->insert(
            $instanceResource,
            self::$projectId,
            self::ZONE
        );
        try{
            $operationClient = new ZoneOperationsClient();
            while (true) {
                $op = $operationClient->get(
                    $operation->getName(),
                    self::$projectId, self::ZONE
                );
                $status = $op->getStatus();
                if (in_array($status, [Status::DONE, Status::UNDEFINED_STATUS])) {
                    break;
                }
            }
            $instance = self::$instancesClient->get(
                $name,
                self::$projectId,
                self::ZONE
            );
        } finally {
            self::$instancesClient->delete($name, self::$projectId, self::ZONE);
        }
        self::assertEquals($name, $instance->getName());
        self::assertEquals(self::$machineType, $instance->getMachineType());
    }

    public function testAPIError()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('was not found');
        $operationClient = new ZoneOperationsClient();
        $op = $operationClient->get('123', self::$projectId, self::ZONE);
    }

    public function testValidationError()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Could not map bindings');
        $operationClient = new ZoneOperationsClient();
        $op = $operationClient->get('123', self::$projectId, '');
    }
}
