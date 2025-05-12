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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Cloud\Core\Exception\NotFoundException;

/**
 * @group spanner
 * @group spanner-session
 */
class SessionTest extends SpannerTestCase
{
    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        self::setUpTestDatabase();
    }

    public function testSessionPoolShouldFailWhenIncorrectDatabase()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Database not found');

        $db = self::getDatabaseInstance('non-existent-db');
        $db->runTransaction(function ($t) {
            $t->select('SELECT 1');
            $t->commit();
        });
    }
}
