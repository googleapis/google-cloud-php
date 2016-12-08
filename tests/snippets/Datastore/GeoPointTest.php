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

namespace Google\Cloud\Tests\Snippets\Datastore;

use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Dev\Snippet\SnippetTestCase;

/**
 * @group datastore
 */
class GeoPointTest extends SnippetTestCase
{
    private $point;
    private $gp;

    public function setUp()
    {
        $this->point = ['latitude' => 123.45, 'longitude' => 543.21];
        $this->gp = new GeoPoint($this->point['latitude'], $this->point['longitude']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(GeoPoint::class);
        $snippet->addUse(GeoPoint::class);
        $res = $snippet->invoke('point');

        $this->assertInstanceOf(GeoPoint::class, $res->returnVal());
    }

    public function testLatitude()
    {
        $snippet = $this->snippetFromMethod(GeoPoint::class, 'latitude');
        $snippet->addLocal('point', $this->gp);

        $res = $snippet->invoke('latitude');
        $this->assertEquals($this->point['latitude'], $res->returnVal());
    }

    public function testSetLatitude()
    {
        $snippet = $this->snippetFromMethod(GeoPoint::class, 'setLatitude');
        $snippet->addLocal('point', $this->gp);

        $res = $snippet->invoke();
        $this->assertEquals(42.279594, $this->gp->latitude());
    }

    public function testLongitude()
    {
        $snippet = $this->snippetFromMethod(GeoPoint::class, 'longitude');
        $snippet->addLocal('point', $this->gp);

        $res = $snippet->invoke('longitude');
        $this->assertEquals($this->point['longitude'], $res->returnVal());
    }

    public function testSetLongitude()
    {
        $snippet = $this->snippetFromMethod(GeoPoint::class, 'setLongitude');
        $snippet->addLocal('point', $this->gp);

        $res = $snippet->invoke();
        $this->assertEquals(-83.732124, $this->gp->longitude());
    }

    public function testPoint()
    {
        $snippet = $this->snippetFromMethod(GeoPoint::class, 'point');
        $snippet->addLocal('point', $this->gp);

        $res = $snippet->invoke('point');
        $this->assertEquals($this->point, $res->returnVal());
    }
}
