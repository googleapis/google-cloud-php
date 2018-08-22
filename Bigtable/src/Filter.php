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

namespace Google\Cloud\Bigtable;

use Exception;
use Google\Cloud\Bigtable\V2\ColumnRange;
use Google\Cloud\Bigtable\V2\RowFilter;
use Google\Cloud\Bigtable\V2\RowFilter\Chain;
use Google\Cloud\Bigtable\V2\RowFilter\Condition;
use Google\Cloud\Bigtable\V2\RowFilter\Interleave;
use Google\Cloud\Bigtable\V2\TimestampRange;
use Google\Cloud\Bigtable\V2\ValueRange;

class Filter
{

    /**
     * @var array RowFilter
     */
    private $filters = [];

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->filters[] = $filter;
        }
    }

    public function chain()
    {
        if (array_count($this->filters) < 2) {
            return $this;
        }
        $chain = new Chain;
        $chain->setFilters($this->filters);
        $rowFilter = new RowFilter;
        $rowFilter->setChain($chain);
        $this->filters = [$rowFilter];
        return $this;
    }

    public function interleave()
    {
        if (array_count($this->filters) < 2) {
            return $this;
        }
        $interleave = new Interleave;
        $interleave->setFilters($this->filters);
        $rowFilter = new RowFilter;
        $rowFilter->setInterleave($interleave);
        $this->filters = [$rowFilter];
        return $this;
    }

    public function condition($predicateFilter, $trueFilter, $falseFilter)
    {
        $condition = new Condition;
        $condition->setPredicateFilter($predicateFilter);
        $condition->setTrueFilter($trueFilter);
        $condition->setFalseFilter($falseFilter);
        $rowFilter = new RowFilter;
        $rowFilter->setCondition($condition);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function sink()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setSink(true);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function passAllFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setPassAllFilter(true);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function blockAllFilter()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setBlockAllFilter(true);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function rowKey($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setRowKeyRegexFilter($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function rowSampleFilter($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setRowSampleFilter($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function familyName($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setFamilyNameRegexFilter($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function columnRange($familyName, $start, $end, $startInclusive = false, $endInclusive = false)
    {
        $columnRange = new ColumnRange;
        $columnRange->setFamilyName($familyName);
        if ($startInclusive) {
            $columnRange->setStartQualifierClosed($start);
        } else {
            $columnRange->setStartQualifierOpen($start);
        }
        if ($endInclusive) {
            $columnRange->setEndQualifierClosed($end);
        } else {
            $columnRange->setEndQualifierOpen($end);
        }
        $rowFilter = new RowFilter;
        $rowFilter->setColumnRangeFilter($columnRange);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function timestampRange($startMicros, $endMicros)
    {
        $timestampRange = new TimestampRange;
        $timestampRange->setStartTimestampMicros($startMicros);
        $timestampRange->setEndTimestampMicros($endMicros);
        $rowFilter = new RowFilter;
        $rowFilter->setTimestampRangeFilter($timestampRange);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function valueRange($start, $end, $startInclusive = false, $endInclusive = false)
    {
        $valueRange = new ValueRange;
        if ($startInclusive) {
            $valueRange->setStartClosed($start);
        } else {
            $valueRange->setStartOpen($start);
        }
        if ($endInclusive) {
            $valueRange->setEndClosed($end);
        } else {
            $valueRange->setEndOpen($end);
        }
        $rowFilter = new RowFilter;
        $rowFilter->setValueRangeFilter($valueRange);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function cellsPerRowOffset($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setCellsPerRowOffsetFilter($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function cellsPerRowLimit($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setCellsPerRowLimitFilter($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function cellsPerColumnLimit($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setCellsPerColumnLimitFilter($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function stripValueTransformer()
    {
        $rowFilter = new RowFilter;
        $rowFilter->setStripValueTransformer(true);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function applyLabelTransformer($value)
    {
        $rowFilter = new RowFilter;
        $rowFilter->setApplyLabelTransformer($value);
        $this->filters[] = $rowFilter;
        return $this;
    }

    public function get()
    {
        if (array_count($this->filters) > 1) {
            throw new Exception('There are multiple filter. Forgot to call chain or interleave?');
        }
        if (array_count($this->filters) === 0) {
            throw new Exception('There are not filters added');
        }
        return $this->filters[0];
    }
}
