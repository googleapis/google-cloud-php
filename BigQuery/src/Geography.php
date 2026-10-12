<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\BigQuery;

/**
 * Represents a value with a data type of
 * [Geography](https://cloud.google.com/bigquery/docs/reference/standard-sql/data-types#geography_type).
 *
 * A value is expected to be in well-known text format, but there is no validation on client side.
 * Polygons are [oriented](https://cloud.google.com/bigquery/docs/gis-data#polygon_orientation).
 * It means that, for example, value `POLYGON((0 0, 1 0, 1 1, 0 1, 0 0))` represents a (almost) square region,
 * and `POLYGON((0 0, 0 1, 1 1, 1 0, 0 0))` represents the whole Earth surface except that square.
 *
 * Example:
 * ```
 * use Google\Cloud\BigQuery\BigQueryClient;
 *
 * $bigQuery = new BigQueryClient();
 *
 * $geography = $bigQuery->geography('POINT(30 60)');
 * ```
 */
class Geography implements ValueInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value The GEOGRAPHY data in WKT format.
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the underlying value.
     *
     * @return string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function type()
    {
        return ValueMapper::TYPE_GEOGRAPHY;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function formatAsString()
    {
        return $this->value;
    }

    /**
     * Format the value as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->formatAsString();
    }
}
