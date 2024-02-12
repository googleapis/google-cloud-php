<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Stubs;

use Google\ApiCore\ArrayTrait;
use Google\Cloud\Core\ApiHelperTrait;

class ApiHelpersTraitImpl
{
    use ArrayTrait;
    use ApiHelperTrait {
        formatStructForApi as public;
        formatTimestampFromApi as public;
        formatListForApi as public;
        formatTimestampForApi as public;
        formatDurationForApi as public;
        formatValueForApi as public;
        unpackValue as public;
    }
}
