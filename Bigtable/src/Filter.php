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
use Google\Cloud\Bigtable\Filter\ChainFilter;
use Google\Cloud\Bigtable\Filter\ConditionFilter;
use Google\Cloud\Bigtable\Filter\FamilyFilter;
use Google\Cloud\Bigtable\Filter\InterleaveFilter;
use Google\Cloud\Bigtable\Filter\KeyFilter;
use Google\Cloud\Bigtable\Filter\LimitFilter;
use Google\Cloud\Bigtable\Filter\OffsetFilter;
use Google\Cloud\Bigtable\Filter\QualifierFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\Filter\TimestampFilter;
use Google\Cloud\Bigtable\Filter\ValueFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * Class to create hierarchy of filters for the CheckAndMutateRow and ReadRows Query.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\Filter;
 * $rowFilter = Filter::chain()
 *              .filter(Filter::qualifier().regex("prefix.*"))
 *              .filter(Filter::limit().cellsPerRow(10))
 *              .toProto();
 * ```
 */
abstract class Filter
{

    /**
     * Creates and empty chain filter list. Fitlers can be added to the chain by invoking {@see ChainFilter::filter()}.
     *
     * The elements of "filters" are chained together to process the input row:
     * in row -> filter0 -> intermediate row -> filter1 -> ... -> filterN -> out row
     * The full chain is executed atomatically.
     *
     * @return ChainFilter
     */
    public static function chain()
    {
        return new ChainFilter();
    }

    /**
     * Creates and empty interleave filter list. FIlters can be added to the interleave by invoking
     * {@see InterleaveFilter::filter()}.
     *
     * The elements of "filters" all process a copy of the input row, and the results are pooled, sorted,
     * and combined into a single output row. If multiple cells are produced with the same column and timestamp,
     * they will all appear in the output row in an unspecified mutual order.
     * The full chain is executed atomically.
     *
     * @return InterleaveFilter
     */
    public static function interleave()
    {
        return new InterleaveFilter();
    }

    /**
     * Creates and empty condition filter. The filter results of the predicate can be configured by invoking
     * {@see ConditionFilter::then()} and {@see ConditionFilter::otherwise()}.
     *
     * A RowFilter which evalutes one of two possible RowFilters, depending on whether or not a predicate RowFilter
     * outputs any cells from right input row.
     *
     * IMPORTANT NOTE: The predicate filter does not execute atomically with the {@see ConditionFilter::then()}
     * and {@see ConditionFilter::otherwise()} filters, which may lead to inconsistent or unexpected results.
     * Additionally, {@see ConditionFilter} may have poor performance, especially when filters are set for the
     * {@see ConditionFilter::otherwise()}.
     */
    public static function condition($predicateFilter)
    {
        return new ConditionFilter($predicateFilter);
    }

    /**
     * Returns KeyFilter for the row key related filters.
     *
     * @return KeyFilter
     */
    public static function key()
    {
        return new KeyFilter();
    }

    /**
     * Returns FamilyFilter for column family related filters.
     *
     * @return FamilyFilter
     */
    public static function family()
    {
        return new FamilyFilter();
    }

    /**
     * Returns QualifierFilter for the column qualifier related filters.
     *
     * @return QualifierFilter
     */
    public static function qualifier()
    {
        return new QualifierFilter();
    }

    /**
     * Returns TimestampFilter for timestamp related filters.
     *
     * @return TimestampFilter
     */
    public static function timestamp()
    {
        return new TimestampFilter();
    }

    /**
     * Returns ValueFilter for value related filters.
     *
     * @return ValueFilter
     */
    public static function value()
    {
        return new ValueFilter();
    }

    /**
     * Returns OffsetFilter for offset related filters.
     *
     * @return OffsetFilter
     */
    public static function offset()
    {
        return new OffsetFilter();
    }

    /**
     * Returns LimitFilter for limit related filters.
     *
     * @return LimitFilter
     */
    public static function limit()
    {
        return new LimitFilter();
    }

    /**
     * Matches all cells, regardless of input. Functionally equivalent to having no filter.
     *
     * @return Filter
     */
    public static function pass()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setPassAllFilter(true);
        return new SimpleFilter($rowFilter);
    }

    /**
     * Does not match any cells, regardless of input. Useful for temporarily disabling just part of a filter.
     *
     * @return Filter
     */
    public static function block()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setBlockAllFilter(true);
        return new SimpleFilter($rowFilter);
    }

    /**
     * @codingStandardsIgnoreStart
     * Outputs all cells directly to the output of the read rather than to any parent filter.
     * For advanced usage, [see comments in] (https://github.com/googleapis/googleapis/blob/master/google/bigtable/v2/data.proto) for more detail.
     *
     * @return Filter
     * @codingStandardsIgnoreEnd
     */
    public static function sink()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setSink(true);
        return new SimpleFilter($rowFilter);
    }

    /**
     * Applies the given label to all cells in the output row. This allows the caller to determine which results were
     * produced from which part of the filter.
     *
     * Due to technical limitation, it is not crrently possible to apply multiple labels to a cell. As a result,
     * a {@see ChainFilter} may have no more than one sub-filter which contains a lable. It is okay for an
     * {@see InterleaveFilter} to contain multiple labels, as they will be applied to separate copies of the input.
     * This may be relaxed in the future.
     *
     * @return Filter
     */
    public static function label($value)
    {
        $rowFilter = new RowFilter();
        $rowFilter->setApplyLabelTransformer($value);
        return new SimpleFilter($rowFilter);
    }

    public static function escapeLiteralValue($value)
    {
        if ($value === null) {
            return null;
        }
        $nullBytes = unpack('C*', '\\x00');
        $byteValue = null;
        if (is_array($value)) {
            $byteValue = $value;
        } elseif (is_string($value)) {
            if (preg_match('//u', $value)) {
                $byteValue = unpack('C*', $value);
            } else {
                $byteValue = unpack('C*', utf8_encode($value));
            }
        } else {
            throw new Exception('Expect byte array or string');
        }
        $quotedBytes = [];
        foreach ($byteValue as $byte) {
            if (($byte < ord('a') || $byte > ord('z'))
                && ($byte < ord('A') || $byte > ord('Z'))
                && ($byte < ord('0') || $byte > ord('9'))
                && $byte != ord('_')
                && ($byte & 128) ==0
            ) {
                if ($byte == 0) {
                    $quotedBytes =  array_merge($quotedBytes, $nullBytes);
                    continue;
                }
                $quotedBytes[] = ord('\\');
            }
            $quotedBytes[] = $byte;
        }
        return implode(array_map("chr", $quotedBytes));
    }

    /**
     * Abstract method to be implemented by specific filter.
     *
     * @return RowFilter
     */
    abstract public function toProto();
}
