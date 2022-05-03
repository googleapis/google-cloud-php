<?php
/**
 * Copyright 2018 Google Inc.
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

/**
 * Represents a Spanner SQL Query array type declaration.
 *
 * Array types may usually be inferred. Types are only required if the array
 * is nullable, or if it contains structs.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\ArrayType;
 * use Google\Cloud\Spanner\Database;
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $arrayType = new ArrayType(Database::TYPE_STRING);
 *
 * $res = $database->execute('SELECT @arrayParam as arrayValue', [
 *     'parameters' => [
 *         'arrayParam' => ['foo', 'bar', null]
 *     ],
 *     'types' => [
 *         'arrayParam' => $arrayType
 *     ]
 * ])->rows()->current();
 *
 * $firstValue = $res['arrayValue'][0]; // `foo`
 * ```
 *
 * ```
 * // Arrays may contain structs.
 * use Google\Cloud\Spanner\ArrayType;
 * use Google\Cloud\Spanner\Database;
 * use Google\Cloud\Spanner\StructType;
 *
 * $arrayType = new ArrayType(
 *     (new StructType)
 *         ->add('companyName', Database::TYPE_STRING)
 *         ->add('companyId', Database::TYPE_INT64)
 * );
 * ```
 */
class ArrayType
{
    /**
     * @var int|null
     */
    private $type;

    /**
     * @var StructType|null
     */
    private $structType;

    /**
     * @param int|string|null|StructType $type A value type code or nested struct
     *        definition. Accepted integer and string values are defined as constants on
     *        {@see Google\Cloud\Spanner\Database}, and are as follows:
     *        `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *        `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *        `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *        `Database::TYPE_NUMERIC`, `Database::TYPE_PG_NUMERIC` and
     *        `Database::TYPE_BYTES`. Nested arrays are not supported in Cloud
     *        Spanner, and attempts to use `Database::TYPE_ARRAY` will result in
     *        an exception. If null is given,
     *        Google Cloud PHP will attempt to infer the array type.
     * @throws \InvalidArgumentException If an invalid type is provided, or if
     *        a struct is defined but the given type is not
     *        `Database::TYPE_STRUCT`.
     */
    public function __construct($type)
    {
        if ($type === Database::TYPE_STRUCT) {
            throw new \InvalidArgumentException(
                '`Database::TYPE_STRUCT` is not a valid array type. ' .
                'Please use `Google\Cloud\Spanner\StructType` instead.'
            );
        }

        $structType = null;
        if ($type instanceof StructType) {
            $structType = $type;
            $type = Database::TYPE_STRUCT;
        }

        if ($type && !in_array($type, ValueMapper::$allowedTypes)) {
            throw new \InvalidArgumentException(sprintf(
                'Type %s is not an allowed type.',
                $type
            ));
        }

        if ($type === Database::TYPE_ARRAY) {
            throw new \InvalidArgumentException(
                'Arrays may not contain arrays.'
            );
        }

        $this->type = $type;
        $this->structType = $structType;
    }

    /**
     * Get the array value type.
     *
     * @access private
     * @return int|string|null
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Get the nested struct parameter type.
     *
     * @access private
     * @return StructType|null
     */
    public function structType()
    {
        return $this->structType;
    }
}
