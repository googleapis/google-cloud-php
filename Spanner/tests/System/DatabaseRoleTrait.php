<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Cloud\Spanner\Date;

/**
 * Provides required databases for FGAC related tests.
 */
trait DatabaseRoleTrait
{
    private static $restrictiveDbRole = 'restrictiveReaderRole';
    private static $dbRole = 'readerRole';

    abstract public static function setUpBeforeClass();

    public function dbProvider()
    {
        self::setUpBeforeClass();
        return [
            [self::$restrictiveDbRole, 'PERMISSION_DENIED'],
            [self::$dbRole, null]
        ];
    }

    public function insertDbProvider()
    {
        self::setUpBeforeClass();
        return [
            [
                self::getDbWithRestrictiveRole(),
                [
                    'id' => rand(1, 346464),
                    'name' => uniqid(SpannerTestCase::TESTING_PREFIX),
                    'birthday' => new Date(new \DateTime('2000-01-01'))
                ],
                'PERMISSION_DENIED'
            ],
            [
                self::getDbWithSessionPoolRestrictiveRole(),
                [
                    'id' => rand(1, 346464),
                    'name' => uniqid(SpannerTestCase::TESTING_PREFIX)
                ],
                null
            ]
        ];
    }

    public function readDbProvider()
    {
        self::setUpBeforeClass();
        return [
            [self::getDbWithReaderRole(), null],
            [self::getDbWithRestrictiveRole(), 'PERMISSION_DENIED']
        ];
    }
}
