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
 * Represents a Struct Query Parameter type declaration.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\StructType;
 * use Google\Cloud\Spanner\Database;
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $res = $database->execute('SELECT @userStruct.firstName, @userStruct.lastName', [
 *     'parameters' => [
 *         'userStruct' => [
 *             'firstName' => 'John',
 *             'lastName' => 'Testuser'
 *         ]
 *     ],
 *     'types' => [
 *         'userStruct' => (new StructType())
 *             ->add('firstName', Database::TYPE_STRING)
 *             ->add('lastName', Database::TYPE_STRING)
 *     ]
 * ])->rows()->current();
 *
 * $fullName = $res['firstName'] . ' ' . $res['lastName']; // `John Testuser`
 * ```
 */
class StructType
{
    /**
     * @var array
     */
    private $fields = [];

    /**
     * Example:
     * ```
     * use Google\Cloud\Spanner\ArrayType;
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\StructType;
     *
     * $structType = new StructType([
     *     [
     *         'name' => 'stringField',
     *         'type' => Database::TYPE_STRING
     *     ],
     *     [
     *         'name' => 'arrayField',
     *         'type' => Database::TYPE_ARRAY,
     *         'child' => new ArrayType(Database::TYPE_STRING)
     *     ]
     * ]);
     * ```
     *
     * @param array[] $fields An array containing a field definition. Each field
     *        must be of form `[(string|null) $name, (int) $type, (ArrayType|StructType|null) $child]`.
     */
    public function __construct(array $fields = [])
    {
        foreach ($fields as $field) {
            $field += [
                'name' => null,
                'type' => null,
                'child' => null
            ];

            $type = $field['child'] === null
                ? $field['type']
                : $field['child'];

            $this->add($field['name'], $type);
        }
    }

    /**
     * Add a struct field definition.
     *
     * Unnamed struct fields may be defined by providing `null` as the first
     * argument value, however you may find it more convenient to use the provided
     * {@see Google\Cloud\Spanner\StructType::addUnnamed()} method.
     *
     * Example:
     * ```
     * $structType->add('firstName', Database::TYPE_STRING);
     * ```
     *
     * ```
     * // If a field is a struct or array, it must be explicitly defined.
     * use Google\Cloud\Spanner\ArrayType;
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\StructType;
     *
     * // Create a struct which will be nested later.
     * $customer = (new StructType)
     *     ->add('name', Database::TYPE_STRING)
     *     ->add('phone', Database::TYPE_STRING)
     *     ->add('email', Database::TYPE_STRING)
     *     ->add('lastOrderDate', Database::TYPE_DATE);
     *
     * // Create an array to nest within the customer type definition.
     * $orderIds = new ArrayType(Database::TYPE_INT64);
     * $customer->add('orderIds', $orderIds);
     *
     * // Add the customer definition to the parameter definition.
     * $structType->add('customer', $customer);
     * ```
     *
     * @param string|null $name The field name.
     * @param int|ArrayType|StructType $type $type A value type code or nested
     *        struct or array definition. Accepted integer values are defined as
     *        constants on {@see Google\Cloud\Spanner\Database}, and are as
     *        follows: `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *        `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *        `Database::TYPE_DATE`, `Database::TYPE_STRING` and
     *        `Database::TYPE_BYTES`
     * @return StructType The current instance, for chaining additional field
     *        definitions.
     * @throws \InvalidArgumentException If an invalid type is provided.
     */
    public function add($name, $type)
    {
        $invalidIntTypes = [
            Database::TYPE_STRUCT,
            Database::TYPE_ARRAY
        ];

        if (is_int($type) && in_array($type, $invalidIntTypes)) {
            throw new \InvalidArgumentException(
                '`Database::TYPE_ARRAY` and `Database::TYPE_STRUCT` are not valid as struct types. ' .
                'Instead provide `Google\Cloud\Spanner\ArrayType` or `Google\Cloud\Spanner\StructType`.'
            );
        }

        $child = null;
        if ($type instanceof StructType) {
            $child = $type;
            $type = Database::TYPE_STRUCT;
        } elseif ($type instanceof ArrayType) {
            $child = $type;
            $type = Database::TYPE_ARRAY;
        }

        if (!in_array($type, ValueMapper::$allowedTypes)) {
            throw new \InvalidArgumentException(sprintf(
                'Field type `%s` is not valid.',
                $type
            ));
        }

        $this->fields[] = [
            'name' => $name,
            'type' => $type,
            'child' => $child
        ];

        return $this;
    }

    /**
     * Add a struct field with no name.
     *
     * Example:
     * ```
     * $structType->addUnnamed(Database::TYPE_STRING);
     * ```
     *
     * @param int|ArrayType|StructType $type $type A value type code or nested
     *        struct or array definition. Accepted integer values are defined as
     *        constants on {@see Google\Cloud\Spanner\Database}, and are as
     *        follows: `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *        `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *        `Database::TYPE_DATE`, `Database::TYPE_STRING` and
     *        `Database::TYPE_BYTES`
     * @return StructType The current instance, for chaining additional field
     *        definitions.
     * @throws \InvalidArgumentException If an invalid type is provided.
     */
    public function addUnnamed($type)
    {
        return $this->add(null, $type);
    }

    /**
     * Fetch the defined fields list.
     *
     * @access private
     * @return array[] An array containing a field definition. Each field
     *        is of form `[(string|null) $name, (int) $type, (ArrayType|StructType|null) $child]`.
     */
    public function fields()
    {
        return $this->fields;
    }
}
