<?php
/**
 * Copyright 2023 Google LLC
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

use Google\Cloud\BigQuery\Json;
use InvalidArgumentException;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 * @group bigquery-json
 */
class JsonTest extends TestCase
{
    public function testInvalidValues()
    {
        $this->expectException(InvalidArgumentException::class);

        $temp = tmpfile();
        try {
            new Json($temp);
        } finally {
            fclose($temp);
        }
    }

    /**
     * @dataProvider validValueProvider
     */
    public function testValidValues($value)
    {
        $json = new Json($value);
        $this->assertInstanceOf(Json::class, $json);
        $this->assertEquals((string) $value, $json->formatAsString());
        if (!is_null($value) and $value instanceof JsonSerializable) {
            $this->assertEquals(json_encode($value), $json->get());
        } else {
            $this->assertEquals($value, $json->get());
        }
    }

    public function validValueProvider()
    {
        return
            [
                ['id' => 2],
                ['info'],
                [null]
            ];
    }

    public function testGetsType()
    {
        $json = new Json(['id' => 2]);

        $this->assertEquals('JSON', $json->type());
    }

    public function testJsonAttributes()
    {
        $json = new Json(['id' => 2]);

        $this->assertEquals(2, json_decode($json->get())->id);
    }

    public function testToString()
    {
        $expectedJson = '{"id":1}';
        $value = ['id' => 1];
        $json = new Json($value);

        $this->assertEquals($expectedJson, (string) $json);
        $this->assertEquals($expectedJson, $json->formatAsString());
    }
}
