<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Core\Tests\Unit\Compute\Metadata\Readers;

use Google\Auth\Credentials\GCECredentials;
use Google\Cloud\Core\Compute\Metadata\Readers\StreamReader;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group core-compute
 */
class StreamReaderTest extends TestCase
{
    public function testRead()
    {
        $reader = new StreamReaderStub;

        $this->assertEquals(
            GCECredentials::FLAVOR_HEADER . ': Google',
            $reader->options['http']['header']
        );

        $this->assertEquals(
            'GET',
            $reader->options['http']['method']
        );

        $path = 'foo/bar';
        $expectedUrl = sprintf(
            'http://%s/computeMetadata/v1/%s',
            GCECredentials::METADATA_IP,
            $path
        );

        $res = $reader->read($path);
        $this->assertEquals('hello', $res);
        $this->assertEquals($expectedUrl, $reader->url);
    }
}

//@codingStandardsIgnoreStart
class StreamReaderStub extends StreamReader
{
    public $options;
    public $url;

    protected function createStreamContext(array $options)
    {
        $this->options = $options;
        return stream_context_create($options);
    }

    protected function getMetadata($url)
    {
        $this->url = $url;

        return 'hello';
    }
}
//@codingStandardsIgnoreEnd
