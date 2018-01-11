<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\ServiceBuilder;
use Composer\Autoload\ClassLoader;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class ServicesNotFoundTest extends TestCase
{
    private static $previousAutoloadFunc;
    private static $newAutoloadFunc;
    private static $cloud;

    public static function setUpBeforeClass()
    {
        self::$cloud = new ServiceBuilder;
        foreach (spl_autoload_functions() as $function) {
            if ($function[0] instanceof ClassLoader) {
                $newAutoloader = clone $function[0];
                $newAutoloader->setPsr4('Google\Cloud\\', '/tmp');
                foreach (self::getApis() as $api) {
                    $newAutoloader->setPsr4("Google\\Cloud\\$api\\", '/tmp');
                }
                spl_autoload_register(self::$newAutoloadFunc = [$newAutoloader, 'loadClass']);
                spl_autoload_unregister(self::$previousAutoloadFunc = $function);
            }
        }
    }

    public static function tearDownAfterClass()
    {
        spl_autoload_register(self::$previousAutoloadFunc);
        spl_autoload_unregister(self::$newAutoloadFunc);
    }

    private static function getApis()
    {
        return [
            "BigQuery",
            "Bigtable",
            "Container",
            "Core",
            "Dataproc",
            "Datastore",
            "Debugger",
            "Dlp",
            "ErrorReporting",
            "Firestore",
            "Language",
            "Logging",
            "Monitoring",
            "OsLogin",
            "PubSub",
            "Spanner",
            "Speech",
            "Storage",
            "Trace",
            "Translate",
            "VideoIntelligence",
            "Vision",
        ];
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
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @dataProvider serviceBuilderMethods
     */
    public function testServicesNotFound($method)
    {
        $this->setExpectedException(\Exception::class, sprintf(
            'The google/cloud-%s package is missing and must be installed.',
            strtolower($method)
        ));

        self::$cloud->$method();
    }
}
