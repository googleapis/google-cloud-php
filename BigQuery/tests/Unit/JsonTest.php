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

use Error;
use Exception;
use Google\Cloud\BigQuery\Json;
use InvalidArgumentException;
use JsonSerializable;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @group bigquery
 * @group bigquery-json
 */
class JsonTest extends TestCase
{
    /**
     * @dataProvider invalidJsonProvider
     */
    public function testInvalidValues($value, $exception)
    {
        $this->expectException($exception);

        try {
            new Json($value);
        } finally {
            if (is_resource($value)) {
                fclose($value);
            }
        }
    }

    /**
     * @dataProvider validJsonProvider
     */
    public function testValidValues($value)
    {
        $json = new Json($value);
        $this->assertInstanceOf(Json::class, $json);
        if (is_array($value) || $value instanceof JsonSerializable || is_resource($value)) {
            $this->assertEquals(json_encode($value), $json->formatAsString());
            $this->assertEquals(json_encode($value), $json->get());
        } else {
            $this->assertEquals($value, $json->formatAsString());
            $this->assertEquals($value, $json->get());
        }
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

    public function testGetVal()
    {
        $id = 1;
        $jsonString = sprintf('{"id":%d}', $id);
        $json = new Json($jsonString);

        $this->assertEquals($id, $json->getVal()->id);
        $this->assertEquals($id, $json->getVal(true)['id']);
    }

    public function validJsonProvider()
    {
        return
            [
                [['id' => 2]],
                ['{"key":"value"}'],
                [null],
                [
                    [
                        "string" => "value",
                        "number" => 123,
                        "boolean" => true,
                        "array" => [1, 2, 3],
                        "object" => ["nested" => "value"],
                        "twoNested" => ["top" => ["mid" => "\"bottom\""]]
                    ]
                    ],
                [[]],
                [1234],
                [["message" => "Special characters: \u00A9 \u00AE \u00E7 \u20AC അ 😀"]],
            ];
    }

    public function invalidJsonProvider()
    {
        return
            [
                [tmpfile(), InvalidArgumentException::class],
                [new \stdClass, Error::class],
            ];
    }
}
