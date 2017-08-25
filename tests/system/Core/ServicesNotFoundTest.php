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

namespace Google\Cloud\Tests\System\Core;

use Google\Cloud\Core\ServiceBuilder;

/**
 * @group core
 */
class ServicesNotFoundTest extends \PHPUnit_Framework_TestCase
{
    private static $autoloaders;
    private static $cloud;

    public static function setUpBeforeClass()
    {
        self::$cloud = new ServiceBuilder;
        self::$autoloaders = spl_autoload_functions();
        foreach (self::$autoloaders as $function) {
            spl_autoload_unregister($function);
        }
    }

    public static function tearDownAfterClass()
    {
        foreach (self::$autoloaders as $function) {
            spl_autoload_register($function);
        }
    }

    public function serviceBuilderMethods()
    {
        return [
            ['bigQuery'],
            ['datastore'],
            ['logging'],
            ['language'],
            ['pubsub'],
            ['spanner'],
            ['speech'],
            ['storage'],
            ['trace'],
            ['vision'],
            ['translate']
        ];
    }

    /**
     * @dataProvider serviceBuilderMethods
     */
    public function testServicesNotFound($method)
    {
        $this->setExpectedException('Exception', sprintf(
            'The google/cloud-%s package is missing and must be installed.',
            strtolower($method)
        ));

        self::$cloud->$method();
    }
}
