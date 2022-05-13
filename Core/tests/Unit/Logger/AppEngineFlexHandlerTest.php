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

namespace Google\Cloud\Core\Tests\Unit\Logger;

use Google\Cloud\Core\Logger\AppEngineFlexHandlerFactory;
use Monolog\Logger;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group core
 * @group logger
 */
class AppEngineFlexHandlerTest extends TestCase
{
    use AssertStringContains;
    use AssertIsType;

    private $stream;
    private $log;

    public function set_up()
    {
        $this->stream = tmpfile();

        $handler = AppEngineFlexHandlerFactory::build(Logger::DEBUG, true, 0640, false, $this->stream);

        $this->log = new Logger('gcloud-test');
        $this->log->pushHandler($handler);
    }

    public function tear_down()
    {
        fclose($this->stream);
    }

    public function testOneLine()
    {
        $msg = 'Error message';
        $this->log->error($msg);
        rewind($this->stream);
        $log_text = stream_get_contents($this->stream);
        $log_array = json_decode($log_text, true);
        $this->assertStringContainsString($msg, $log_array['message']);
        $this->assertIsInt($log_array['timestamp']['seconds']);
        $this->assertIsInt($log_array['timestamp']['nanos']);
        $this->assertEquals('ERROR', $log_array['severity']);
    }

    public function testOneLineWithTraceContext()
    {
        $_SERVER['HTTP_X_CLOUD_TRACE_CONTEXT'] = 'foo/bar';

        $msg = 'Error message';
        $this->log->error($msg);
        rewind($this->stream);
        $log_text = stream_get_contents($this->stream);
        $log_array = json_decode($log_text, true);
        $this->assertStringContainsString($msg, $log_array['message']);
        $this->assertIsInt($log_array['timestamp']['seconds']);
        $this->assertIsInt($log_array['timestamp']['nanos']);
        $this->assertEquals('ERROR', $log_array['severity']);
        $this->assertEquals('foo', $log_array['traceId']);

        unset($_SERVER['HTTP_X_CLOUD_TRACE_CONTEXT']);
    }
}
