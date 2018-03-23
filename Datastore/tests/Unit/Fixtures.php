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

namespace Google\Cloud\Datastore\Tests\Unit;

class Fixtures
{
    public static function ENTITY_BATCH_LOOKUP_FIXTURE()
    {
        return __DIR__ . '/fixtures/entity-batch-lookup.json';
    }

    public static function ENTITY_LOOKUP_BIGSORT_FIXTURE()
    {
        return __DIR__ . '/fixtures/entity-lookup-bigsort.json';
    }

    public static function QUERY_RESULTS_FIXTURE()
    {
        return __DIR__ . '/fixtures/query-results.json';
    }

    public static function ENTITY_RESULT_FIXTURE()
    {
        return __DIR__ . '/fixtures/entity-result.json';
    }

    public static function ENTITY_RESULT_NO_PROPERTIES_FIXTURE()
    {
        return __DIR__ . '/fixtures/entity-result-no-properties.json';
    }
}
