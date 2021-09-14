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

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Bytes;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class BytesTest extends TestCase
{
    public $value = '1234';

    /**
     * @dataProvider valueProvider
     */
    public function testGetWithMultipleIncomingValues($value)
    {
        $bytes = new Bytes($value);

        $this->assertEquals($this->value, (string) $bytes->get());
    }

    public function valueProvider()
    {
        $fh = fopen('php://temp', 'r+');
        fwrite($fh, $this->value);
        rewind($fh);

        return [
            [$this->value],
            [$fh],
            [Utils::streamFor($this->value)]
        ];
    }

    public function testGetsType()
    {
        $bytes = new Bytes($this->value);

        $this->assertEquals('BYTES', $bytes->type());
    }

    public function testToString()
    {
        $bytes = new Bytes($this->value);
        $expected = base64_encode($this->value);

        $this->assertEquals($expected, (string) $bytes);
        $this->assertEquals($expected, $bytes->formatAsString());
    }
}
