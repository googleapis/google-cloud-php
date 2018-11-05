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

use Google\Cloud\Bigtable\Filter\ChainFilter;
use Google\Cloud\Bigtable\Filter\ConditionFilter;
use Google\Cloud\Bigtable\Filter\FilterInterface;
use Google\Cloud\Bigtable\Filter\InterleaveFilter;
use Google\Cloud\Bigtable\Filter\Builder\FamilyFilter;
use Google\Cloud\Bigtable\Filter\Builder\KeyFilter;
use Google\Cloud\Bigtable\Filter\Builder\LimitFilter;
use Google\Cloud\Bigtable\Filter\Builder\OffsetFilter;
use Google\Cloud\Bigtable\Filter\Builder\QualifierFilter;
use Google\Cloud\Bigtable\Filter\Builder\TimestampFilter;
use Google\Cloud\Bigtable\Filter\Builder\ValueFilter;
use Google\Cloud\Bigtable\Filter\SimpleFilter;
use Google\Cloud\Bigtable\V2\RowFilter;

/**
 * This class houses static factory methods which can be used to create a
 * hierarchy of filters for use with
 * {@see Google\Cloud\Bigtable\Table::checkAndMutateRow()} or
 * {@see Google\Cloud\Bigtable\Table::readRows()}.
 *
 * Filters are used to take an input row and produce an alternate view of the
 * row based on the specified rules. For example, a filter might trim down a row
 * to include just the cells from columns matching a given regular expression,
 * or might return all the cells of a row but not their values. More complicated
 * filters can be composed out of these components to express requests such as,
 * "within every column of a particular family, give just the two most recent
 * cells which are older than timestamp X."
 *
 * There are two broad categories of filters (true filters and transformers),
 * as well as two ways to compose simple filters into more complex ones
 * (chains and interleaves). They work as follows:
 *
 * True filters alter the input row by excluding some of its cells wholesale
 * from the output row. An example of a true filter is
 * {@see Google\Cloud\Bigtable\Filter\Builder\ValueFilter::regex()}, which excludes
 * cells whose values don't match the specified pattern. All regex true filters
 * use [RE2 syntax](https://github.com/google/re2/wiki/Syntax) in raw byte mode
 * (RE2::Latin1), and are evaluated as full matches. An important point to keep
 * in mind is that `RE2(.)` is equivalent by default to `RE2([^\n])`, meaning
 * that it does not match newlines.
 *
 * Transformers alter the input row by changing the values of some of its cells
 * in the output, without excluding them completely. An example of such a
 * transformer is {@see Google\Cloud\Bigtable\Filter\Builder\ValueFilter::strip()}.
 *
 * The total serialized size of a filter message must not
 * exceed 4096 bytes, and filters may not be nested within each other
 * (in Chains or Interleaves) to a depth of more than 20.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 * use Google\Cloud\Bigtable\Filter;
 *
 * $bigtable = new BigtableClient();
 * $table = $bigtable->table('my-instance', 'my-table');
 * $rowFilter = Filter::chain()
 *     ->addFilter(Filter::qualifier()->regex('prefix.*'))
 *     ->addFilter(Filter::limit()->cellsPerRow(10));
 *
 * $rows = $table->readRows([
 *     'filter' => $rowFilter
 * ]);
 *
 * foreach ($rows as $row) {
 *     print_r($row) . PHP_EOL;
 * }
 * ```
 */
class Filter
{
    /**
     * Creates an empty chain filter.
     *
     * Filters can be added to the chain by invoking
     * {@see Google\Cloud\Bigtable\Filter\ChainFilter::addFilter()}.
     *
     * The filters are applied in sequence, progressively narrowing the results.
     * The full chain is executed atomically.
     *
     * Conceptually, the process looks like the following:
     * `in row -> filter0 -> intermediate row -> filter1 -> ... -> filterN -> out row`.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::chain()
     *     ->addFilter(Filter::qualifier()->regex('prefix.*'))
     *     ->addFilter(Filter::limit()->cellsPerRow(10));
     * ```
     *
     * @return ChainFilter
     */
    public static function chain()
    {
        return new ChainFilter();
    }

    /**
     * Creates an empty interleave filter.
     *
     * Filters can be added to the interleave by invoking
     * {@see Google\Cloud\Bigtable\Filter\InterleaveFilter::addFilter()}.
     *
     * The supplied filters all process a copy of the input row, and the
     * results are pooled, sorted, and combined into a single output row. If
     * multiple cells are produced with the same column and timestamp, they will
     * all appear in the output row in an unspecified mutual order. The full
     * chain is executed atomically.
     *
     * Consider the following example, with three filters:
     * ```
     *                                  input row
     *                                      |
     *            -----------------------------------------------------
     *            |                         |                         |
     *         filter1                   filter2                   filter3
     *            |                         |                         |
     *     1: foo,bar,10,x             foo,bar,10,z              far,bar,7,a
     *     2: foo,blah,11,z            far,blah,5,x              far,blah,5,x
     *            |                         |                         |
     *            -----------------------------------------------------
     *                                      |
     *     1:                      foo,bar,10,z   // could have switched with #2
     *     2:                      foo,bar,10,x   // could have switched with #1
     *     3:                      foo,blah,11,z
     *     4:                      far,bar,7,a
     *     5:                      far,blah,5,x   // identical to #6
     *     6:                      far,blah,5,x   // identical to #5
     * ```
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::interleave()
     *     ->addFilter(Filter::key()->regex('prefix.*'))
     *     ->addFilter(Filter::sink());
     * ```
     *
     * @return InterleaveFilter
     */
    public static function interleave()
    {
        return new InterleaveFilter();
    }

    /**
     * Creates a condition filter.
     *
     * If the result of predicate filter outputs any cells the filter configured
     * by {@see Google\Cloud\Bigtable\Filter\ConditionFilter::then()} will be
     * applied. Conversely, if the predicate results in no cells, the filter
     * configured by
     * {@see Google\Cloud\Bigtable\Filter\ConditionFilter::otherwise()} will
     * then be applied instead.
     *
     * IMPORTANT NOTE: The predicate filter does not execute atomically with the
     * {@see Google\Cloud\Bigtable\Filter\ConditionFilter::then()}
     * and {@see Google\Cloud\Bigtable\Filter\ConditionFilter::otherwise()}
     * filters, which may lead to inconsistent or unexpected results.
     * Additionally, {@see Google\Cloud\Bigtable\Filter\ConditionFilter} may
     * have poor performance, especially when filters are set for the
     * {@see Google\Cloud\Bigtable\Filter\ConditionFilter::otherwise()}.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::condition(Filter::key()->regex('prefix.*'))
     *     ->then(Filter::label('hasPrefix'))
     *     ->otherwise(Filter::value()->strip());
     * ```
     *
     * @param FilterInterface $predicateFilter A predicate filter.
     * @return ConditionFilter
     */
    public static function condition(FilterInterface $predicateFilter)
    {
        return new ConditionFilter($predicateFilter);
    }

    /**
     * Returns a builder used to configure row key filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::key()
     *     ->regex('prefix.*');
     * ```
     *
     * @return KeyFilter
     */
    public static function key()
    {
        return new KeyFilter();
    }

    /**
     * Returns a builder used to configure column family filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::family()
     *     ->regex('prefix.*');
     * ```
     *
     * @return FamilyFilter
     */
    public static function family()
    {
        return new FamilyFilter();
    }

    /**
     * Returns a builder used to configure column qualifier filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::qualifier()
     *     ->regex('prefix.*');
     * ```
     *
     * @return QualifierFilter
     */
    public static function qualifier()
    {
        return new QualifierFilter();
    }

    /**
     * Returns a builder used to configure timestamp related filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::timestamp()
     *     ->range()
     *     ->of(1536766964380000, 1536766964383000);
     * ```
     *
     * @return TimestampFilter
     */
    public static function timestamp()
    {
        return new TimestampFilter();
    }

    /**
     * Returns a builder used to configure value related filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::value()
     *     ->range()
     *     ->of('a', 'z');
     * ```
     *
     * @return ValueFilter
     */
    public static function value()
    {
        return new ValueFilter();
    }

    /**
     * Returns a builder used to configure offset related filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::offset()
     *     ->cellsPerRow(1);
     * ```
     *
     * @return OffsetFilter
     */
    public static function offset()
    {
        return new OffsetFilter();
    }

    /**
     * Returns a builder used to configure limit related filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::limit()
     *     ->cellsPerRow(1);
     * ```
     *
     * @return LimitFilter
     */
    public static function limit()
    {
        return new LimitFilter();
    }

    /**
     * Matches all cells, regardless of input. Functionally equivalent to having
     * no filter.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::pass();
     * ```
     *
     * @return SimpleFilter
     */
    public static function pass()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setPassAllFilter(true);
        return new SimpleFilter($rowFilter);
    }

    /**
     * Does not match any cells, regardless of input. Useful for temporarily
     * disabling just part of a filter.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::block();
     * ```
     *
     * @return SimpleFilter
     */
    public static function block()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setBlockAllFilter(true);
        return new SimpleFilter($rowFilter);
    }

    /**
     * Outputs all cells directly to the output of the read rather than to any
     * parent filter. For advanced usage,
     * [see comments in](https://github.com/googleapis/googleapis/blob/master/google/bigtable/v2/data.proto)
     * for more detail.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::sink();
     * ```
     *
     * @return SimpleFilter
     */
    public static function sink()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setSink(true);
        return new SimpleFilter($rowFilter);
    }

    /**
     * Applies the given label to all cells in the output row. This allows the
     * caller to determine which results were produced from which part of the
     * filter.
     *
     * Due to technical limitation, it is not currently possible to apply
     * multiple labels to a cell. As a result, a
     * {@see Google\Cloud\Bigtable\Filter\ChainFilter} may have no more than one
     * sub-filter which contains a label. It is okay for a
     * {@see Google\Cloud\Bigtable\Filter\InterleaveFilter} to contain multiple
     * labels, as they will be applied to separate copies of the input. This may
     * be relaxed in the future.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Filter;
     *
     * $rowFilter = Filter::label('my-label');
     * ```
     *
     * @param string $value The label to apply.
     * @return SimpleFilter
     */
    public static function label($value)
    {
        $rowFilter = new RowFilter();
        $rowFilter->setApplyLabelTransformer($value);
        return new SimpleFilter($rowFilter);
    }
}
