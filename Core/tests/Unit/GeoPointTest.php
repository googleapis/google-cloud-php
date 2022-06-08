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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\GeoPoint;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 * @group core-geopoint
 */
class GeoPointTest extends TestCase
{
    use ExpectException;

    public function testGeoPoint()
    {
        $point = new GeoPoint(1.1, 2.2);
        $this->assertEquals(1.1, $point->latitude());
        $this->assertEquals(2.2, $point->longitude());
    }

    public function testGeoPointSetters()
    {
        $point = new GeoPoint(1.1, 2.2);
        $point->setLatitude(3.3);
        $this->assertEquals(3.3, $point->latitude());

        $point->setLongitude(4.4);
        $this->assertEquals(4.4, $point->longitude());
    }

    public function testPoint()
    {
        $point = new GeoPoint(1.1, 2.2);
        $this->assertEquals($point->point(), [
            'latitude' => 1.1,
            'longitude' => 2.2
        ]);
    }

    /**
     * @dataProvider methods
     */
    public function testCheckContext($method)
    {
        $this->expectException('InvalidArgumentException');

        $point = new GeoPoint(1.1, 2.2);
        $point->$method(222.33);
    }

    /**
     * @dataProvider methods
     */
    public function testInvalidType($method)
    {
        $this->expectException('InvalidArgumentException');

        $method = 'set' . ucfirst($method);
        $point = new GeoPoint(1.1, 2.2);
        $point->$method('foo');
    }

    /**
     * @dataProvider methods
     */
    public function testSetNullValue($method)
    {
        $this->expectException('InvalidArgumentException');

        $method = 'set' . ucfirst($method);
        $point = new GeoPoint(1.1, 2.2, true);
        $point->$method(null);
    }

    public function testConstructWithNulls()
    {
        $point = new GeoPoint(null, null, true);
        $this->assertEquals([
            'latitude' => null,
            'longitude' => null
        ], $point->point());
    }

    public function methods()
    {
        return [
            ['latitude'],
            ['longitude']
        ];
    }
}
