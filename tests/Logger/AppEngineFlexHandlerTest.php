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

namespace Google\Cloud\Tests\Logger;

use Google\Cloud\Logger\AppEngineFlexHandler;
use Monolog\Logger;

class AppEngineFlexHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $path;
    private $log;

    public function setUp()
    {
        $dir = sys_get_temp_dir();
        $this->path = tempnam($dir, "log");
        $handler = new AppEngineFlexHandler(
            Logger::DEBUG, true, 0640, false, $this->path
        );
        $this->log = new Logger('gcloud-test');
        $this->log->pushHandler($handler);
    }

    public function tearDown()
    {
        unlink($this->path);
    }

    public function testOneLine()
    {
        $msg = 'Error message';
        $this->log->addError($msg);
        $log_text = file_get_contents($this->path);
        $log_array = json_decode($log_text, true);
        $this->assertContains($msg, $log_array['message']);
        $this->assertInternalType('int', $log_array['timestamp']['seconds']);
        $this->assertInternalType('int', $log_array['timestamp']['nanos']);
        $this->assertEquals('ERROR', $log_array['severity']);
    }
}
