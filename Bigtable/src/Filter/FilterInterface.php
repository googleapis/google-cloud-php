<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Filter;

use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * A contract to be implemented by filters.
 */
interface FilterInterface
{
    /**
     * Get the proto representation of the filter.
     *
     * @internal
     * @access private
     * @return RowFilter
     * @throws \RuntimeException
     */
    public function toProto();
}
