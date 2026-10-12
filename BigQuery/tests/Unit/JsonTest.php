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
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 * @group bigquery-json
 */
class JsonTest extends TestCase
{
    /**
     * @dataProvider invalidJsonProvider
     */
    public function testInvalidValues($value)
    {
        $this->expectException(InvalidArgumentException::class);

        new Json($value);
    }

    /**
     * @dataProvider validJsonProvider
     */
    public function testValidValues($value)
    {
        $json = new Json($value);
        $this->assertInstanceOf(Json::class, $json);
        $this->assertEquals($value, $json->formatAsString());
        $this->assertEquals($value, $json->get());
    }

    public function testGetsType()
    {
        $json = new Json(json_encode(['id' => 2]));

        $this->assertEquals('JSON', $json->type());
    }

    public function testJsonAttributes()
    {
        $json = new Json(json_encode(['id' => 2]));

        $this->assertEquals(2, json_decode($json->get())->id);
    }

    public function testToString()
    {
        $expectedJson = '{"id":1}';
        $value = json_encode(['id' => 1]);
        $json = new Json($value);

        $this->assertEquals($expectedJson, (string) $json);
        $this->assertEquals($expectedJson, $json->formatAsString());
    }

    public function validJsonProvider()
    {
        return
            [
                [json_encode(['id' => 2])],
                ['{"key":"value"}'],
                [null],
                [json_encode(
                    [
                        "string" => "value",
                        "number" => 123,
                        "boolean" => true,
                        "array" => [1, 2, 3],
                        "object" => ["nested" => "value"],
                        "twoNested" => ["top" => ["mid" => "\"bottom\""]]
                    ]
                )],
                [json_encode([])],
                [json_encode(1234)],
                [json_encode([
                    "message" => "Special characters: \u00A9 \u00AE \u00E7 \u20AC അ 😀"
                ])],
            ];
    }

    public function invalidJsonProvider()
    {
        return
            [
                [tmpfile()],
                [new \stdClass],
                [1234],
                [['a', 'b']],
                [['key' => 'val']]
            ];
    }
}
