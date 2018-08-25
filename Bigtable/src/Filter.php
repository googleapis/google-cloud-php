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

abstract class Filter
{

    public static function chain()
    {
        return new ChainFilter();
    }

    public static function interleave()
    {
        return new InterleaveFilter();
    }

    public static function condition($predicateFilter)
    {
        return new ConditionFilter($predicateFilter);
    }

    public static function key()
    {
        return new KeyFilter();
    }

    public static function family()
    {
        return new FamilyFilter();
    }

    public static function qualifier()
    {
        return new QualifierFilter();
    }

    public static function timestamp()
    {
        return new TimestampFilter();
    }

    public static function value()
    {
        return new ValueFilter();
    }

    public static function offset()
    {
        return new OffsetFilter();
    }

    public static function limit()
    {
        return new LimitFilter();
    }

    public static function pass()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setPassAllFilter(true);
        return new SimpleFilter($rowFilter);
    }

    public static function block()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setBlockAllFilter(true);
        return new SimpleFilter($rowFilter);
    }

    public static function sink()
    {
        $rowFilter = new RowFilter();
        $rowFilter->setSink(true);
        return new SimpleFilter($rowFilter);
    }

    public static function label($value)
    {
        $rowFilter = new RowFilter();
        $rowFilter->setApplyLabelTransformer($value);
        return new SimpleFilter($rowFilter);
    }

    abstract public function toProto();
}
