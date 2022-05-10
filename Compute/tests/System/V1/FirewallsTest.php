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


use Google\Cloud\Compute\V1\Allowed;
use Google\Cloud\Compute\V1\Firewall;
use Google\Cloud\Compute\V1\FirewallsClient;
use Google\Cloud\Compute\V1\GlobalOperationsClient;
use PHPUnit\Framework\TestCase;

class FirewallsTest extends TestCase
{
    protected static $client;
    protected static $projectId;
    protected static $name;
    protected static $globalClient;

    public static function setUpBeforeClass(): void
    {
        self::$projectId = getenv('PROJECT_ID');
        if (self::$projectId === false) {
            self::fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        self::$client = new FirewallsClient();
        self::$name = 'gapicphp' . strval(rand(100000, 999999));
    }

    public static function tearDownAfterClass(): void
    {
        self::$client->close();
    }

    public function testCapitalLetter()
    {
        // we test a field like "I_p_protocol"
        $allowed = [new Allowed([
            'I_p_protocol' => 'tcp',
            'ports' => ['80']
        ])];
        $resource = new Firewall([
            'name' => self::$name,
            'source_ranges' => ['0.0.0.0/0'],
            'allowed' => $allowed
        ]);
        $operation = self::$client->insert($resource, self::$projectId);
        $operation->pollUntilComplete();
        try {
            $firewall = self::$client->get(self::$name, self::$projectId);
            $this->assertEquals($allowed, iterator_to_array($firewall->getAllowed()->getIterator()));
        } finally {
            self::$client->delete(self::$name, self::$projectId);
        }
    }
}
