<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\V1\TypeAnnotationCode;
use Google\Cloud\Spanner\V1\TypeCode;

/**
 * Manage value mappings between Google Cloud PHP and Cloud Spanner
 */
interface ValueMapperInterface
{
    /**
     * @param array $parameters The key/value parameters.
     * @param array $types The types of values.
     * @return array An associative array containing params and paramTypes.
     */
    public function formatParamsForExecuteSql(array $parameters, array $types = []);

    /**
     * @param array $values The list of values
     * @param bool $allowMixedArrayType If true, array values may be of mixed type.
     *        **Defaults to** `false`.
     * @return array The encoded values
     */
    public function encodeValuesAsSimpleType(array $values, $allowMixedArrayType = false);

    /**
     * @param array $columns The list of columns.
     * @param array $row The row data.
     * @param string $format The format in which to return the rows.
     * @return array The decoded row data.
     * @throws \InvalidArgumentException
     */
    public function decodeValues(array $columns, array $row, $format);
}
