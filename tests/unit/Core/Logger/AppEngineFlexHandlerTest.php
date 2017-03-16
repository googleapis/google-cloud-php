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

namespace Google\Cloud\Tests\Unit\Core\Logger;

use Google\Cloud\Core\Logger\AppEngineFlexHandler;
use Monolog\Logger;

/**
 * @group core
 * @group logger
 */
class AppEngineFlexHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $stream;
    private $log;

    public function setUp()
    {
        $dir = sys_get_temp_dir();
        $this->stream = tmpfile();
        $handler = new AppEngineFlexHandler(
            Logger::DEBUG, true, 0640, false, $this->stream
        );
        $this->log = new Logger('gcloud-test');
        $this->log->pushHandler($handler);
    }

    public function tearDown()
    {
        fclose($this->stream);
    }

    public function testOneLine()
    {
        $msg = 'Error message';
        $this->log->addError($msg);
        rewind($this->stream);
        $log_text = stream_get_contents($this->stream);
        $log_array = json_decode($log_text, true);
        $this->assertContains($msg, $log_array['message']);
        $this->assertInternalType('int', $log_array['timestamp']['seconds']);
        $this->assertInternalType('int', $log_array['timestamp']['nanos']);
        $this->assertEquals('ERROR', $log_array['severity']);
    }
}
