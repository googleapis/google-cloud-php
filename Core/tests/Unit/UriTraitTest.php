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

use Google\Cloud\Core\UriTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class UriTraitTest extends TestCase
{
    private $implementation;

    public function setUp(): void
    {
        $this->implementation = $this->getObjectForTrait(UriTrait::class);
    }

    public function testExpandsUri()
    {
        $path = 'narf';
        $baseUri = 'http://www.example.com';
        $uri = $this->implementation->expandUri($baseUri . '/{path}', [
            'path' => $path
        ]);

        $this->assertEquals($baseUri . '/' . $path, $uri);
    }

    /**
     * @dataProvider queryProvider
     */
    public function testBuildsUriWithQuery($expectedQuery, $query)
    {
        $baseUri = 'http://www.example.com';
        $uri = $this->implementation->buildUriWithQuery($baseUri, $query);

        $this->assertEquals($baseUri . $expectedQuery, (string) $uri);
    }

    public function queryProvider()
    {
        return [
            ['?narf=yes', ['narf' => 'yes']],
            ['?narf=true', ['narf' => true]],
            ['?narf=false', ['narf' => false]],
            ['?narf=0', ['narf' => '0']]
        ];
    }
}
