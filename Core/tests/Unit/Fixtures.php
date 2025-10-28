<?php
/**
 * Copyright 2018 Google Inc.
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

//@codingStandardsIgnoreStart
class Fixtures
{
    public static function JSON_KEY_FIXTURE()
    {
        return __DIR__ . '/fixtures/json-key-fixture.json';
    }

    public static function SERVICE_ACCOUNT_FIXTURE()
    {
        return __DIR__ . '/fixtures/service-account-fixture.json';
    }

    public static function SERVICE_FIXTURE()
    {
        return __DIR__ . '/fixtures/service-fixture.json';
    }

    public static function SERVICE_FIXTURE_BASEPATH()
    {
        return __DIR__ . '/fixtures/service-fixture-basepath.json';
    }
}
//@codingStandardsIgnoreEnd
