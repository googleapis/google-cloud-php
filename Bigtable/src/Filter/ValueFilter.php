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

use Exception;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\Filter\ValueRangeFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

class ValueFilter
{
    public function regex($value)
    {
        return $this->toFilter($value);
    }

    public function exactMatch($value)
    {
        return $this->toFilter($value);
    }

    public function range()
    {
        return new ValueRangeFilter();
    }

    public function strip()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setStripValueTransformer(true);
        return new SimpleFilter($rowFilter);
    }

    private function toFilter($value)
    {
        if ($value === null) {
            throw new Exception('Value can`t be null');
        }
        $rowFilter = new RowFilter();
        $rowFilter->setValueRegexFilter($value);
        return new SimpleFilter($rowFilter);
    }
}
