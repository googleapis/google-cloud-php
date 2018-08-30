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
use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Chain;

/**
 * Chains multiple filter.
 */
class ChainFilter extends Filter
{
    /**
     * @var array RowFilter
     */
    private $filters = [];

    /**
     * Adds filter to the chain.
     *
     * @param Filter $filter Filter to be added.
     * @return $this
     */
    public function filter($filter)
    {
        if ($filter === null) {
            throw new Exception('Filter can`t be null');
        }
        $this->filters[] = $filter->toProto();
        return $this;
    }

    public function toProto()
    {
        $chain = new Chain();
        $chain->setFilters($this->filters);
        $rowFilter = new RowFilter();
        $rowFilter->setChain($chain);
        return $rowFilter;
    }
}
