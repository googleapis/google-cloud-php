<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\System\Spanner;

use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Configuration;

/**
 * @group spanner
 */
class ConfigurationTest extends SpannerTestCase
{
    public function testConfigurations()
    {
        $client = self::$client;

        $configurations = $client->configurations();

        $this->assertContainsOnly(Configuration::class, $configurations);

        $res = iterator_to_array($configurations);
        $firstConfigName = $res[0]->name();

        $config = $client->configuration($firstConfigName);

        $this->assertInstanceOf(Configuration::class, $config);
        $this->assertEquals($firstConfigName, $config->name());

        $this->assertTrue($config->exists());
        $this->assertEquals($config->name(), $this->parseName($config->info()['name']));
        $this->assertEquals($config->name(), $this->parseName($config->reload()['name']));
    }

    private function parseName($name)
    {
        return InstanceAdminClient::parseInstanceConfigFromInstanceConfigName($name);
    }
}
