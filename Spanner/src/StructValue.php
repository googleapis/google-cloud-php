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
 * Defines a struct parameter value with its fields.
 *
 * This class is included to provide a fluent interface to build complex struct
 * parameter values for your queries against Cloud Spanner. If your struct does
 * or may include unnamed fields, or duplicate field names, you must use a
 * StructValue. In most cases, however, an associative array may be used.
 *
 * Please note that query results expressed as structs will not be returned using
 * this class. Query results will always be expressed as a PHP array. This class
 * is intended to be used to create complex struct values only.
 *
 * If your query contains duplicate field names, it must be returned as a name/value
 * pair as demonstrated in the example below using `Result::RETURN_NAME_VALUE_PAIR`.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\Database;
 * use Google\Cloud\Spanner\SpannerClient;
 * use Google\Cloud\Spanner\Result;
 * use Google\Cloud\Spanner\StructType;
 * use Google\Cloud\Spanner\StructValue;
 *
 * $spanner = new SpannerClient();
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $res = $database->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
 *     'parameters' => [
 *         'structParam' => (new StructValue)
 *             ->add('foo', 'bar')
 *             ->add('foo', 2)
 *             ->addUnnamed('this field is unnamed')
 *     ],
 *     'types' => [
 *         'structParam' => (new StructType)
 *             ->add('foo', Database::TYPE_STRING)
 *             ->add('foo', Database::TYPE_INT64)
 *             ->addUnnamed(Database::TYPE_STRING)
 *     ]
 * ])->rows(Result::RETURN_NAME_VALUE_PAIR)->current();
 *
 * echo $res[0]['name'] . ': ' . $res[0]['value'] . PHP_EOL; // "foo: bar"
 * echo $res[1]['name'] . ': ' . $res[1]['value'] . PHP_EOL; // "foo: 2"
 * echo $res[2]['name'] . ': ' . $res[2]['value'] . PHP_EOL; // "2: this field is unnamed"
 * ```
 */
class StructValue
{
    /**
     * @var array[]
     */
    private $values;

    /**
     * @param array[] $values An array containing a field value. Each value
     *        must be of form `[(string|null) $name, mixed $value]`.
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $value) {
            $value += [
                'name' => null,
                'value' => null
            ];

            $this->add($value['name'], $value['value']);
        }
    }

    /**
     * Add a single value to the struct.
     *
     * Example:
     * ```
     * $structValue->add('firstName', 'John');
     * ```
     *
     * @param string|null $name The struct field name.
     * @param mixed $value The struct field value.
     * @return StructValue The current instance, for chaining additional struct
     *        values.
     */
    public function add($name, $value)
    {
        $this->values[] = [
            'name' => $name,
            'value' => $value
        ];

        return $this;
    }

    /**
     * Add an unnamed value to the struct.
     *
     * Example:
     * ```
     * $structValue->addUnnamed('John');
     * ```
     *
     * @param mixed $value The struct field value.
     * @return StructValue The current instance, for chaining additional struct
     *        values.
     */
    public function addUnnamed($value)
    {
        return $this->add(null, $value);
    }

    /**
     * Get the list of values.
     *
     * @access private
     * @return array[]
     */
    public function values()
    {
        return $this->values;
    }
}
