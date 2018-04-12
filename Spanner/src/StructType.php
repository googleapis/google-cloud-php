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
     * @param array[] $fields An array containing a field definition. Each field
     *        must be of form `[(string|null) $name, (int) $type, ArrayType|StructType|null $child]`.
     */
    public function __construct(array $fields = [])
    {
        foreach ($fields as $field) {
            $field += [
                'name' => null,
                'type' => null,
                'child' => null
            ];

            $this->add($field['name'], $field['type'], $field['child']);
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
     * $customer->add('orderIds', Database::TYPE_ARRAY, $orderIds);
     *
     * // Add the customer definition to the parameter definition.
     * $structType->add('customer', Database::TYPE_STRUCT, $customer);
     * ```
     *
     * @param string $name The field name.
     * @param int $type The field type.
     * @param ArrayType|StructType $child [optional] A definition for structured
     *        data within the struct field.
     * @return StructType The current instance, for chaining additional field
     *        definitions.
     * @throws \InvalidArgumentException If an invalid type is provided, or if a
     *        child is given but is not an instance of
     *        {@see Google\Cloud\Spanner\ArrayType} or
     *        {@see Google\Cloud\Spanner\StructType}.
     */
    public function add($name, $type, $child = null)
    {
        if (!in_array($type, ValueMapper::$allowedTypes)) {
            throw new \InvalidArgumentException(sprintf(
                'Field type `%s` is not valid.',
                $type
            ));
        }

        $typesRequiringChild = [
            Database::TYPE_STRUCT,
            Database::TYPE_ARRAY
        ];

        if (in_array($type, $typesRequiringChild) && !$child) {
            throw new \InvalidArgumentException(
                'If type is `Database::TYPE_ARRAY` or `Database::TYPE_STRUCT`, `$child` definition must be provided.'
            );
        }

        if ($child) {
            if (!in_array($type, $typesRequiringChild)) {
                throw new \InvalidArgumentException(
                    'Struct field child may only be provided if field is of ' .
                    'type `Database::TYPE_ARRAY` or `Database::TYPE_STRUCT`.'
                );
            }

            $errTpl = 'Field child must be an instance of `%s`. Got `%s`.';

            $childTypes = [
                Database::TYPE_ARRAY => ArrayType::class,
                Database::TYPE_STRUCT => StructType::class
            ];

            if (!is_object($child)) {
                throw new \InvalidArgumentException(sprintf(
                    $errTpl,
                    $childTypes[$type],
                    gettype($child)
                ));
            }

            $childType = get_class($child);
            if (!in_array($childType, $childTypes)) {
                throw new \InvalidArgumentException(sprintf(
                    $errTpl,
                    $childTypes[$type],
                    $childType
                ));
            }

            if ($childType !== $childTypes[$type]) {
                throw new \InvalidArgumentException(sprintf(
                    $errTpl,
                    $childTypes[$type],
                    $childType
                ));
            }
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
     * @param int $type The field type.
     * @param ArrayType|StructType $child [optional] A definition for structured
     *        data within the struct field.
     * @return StructType The current instance, for chaining additional field
     *        definitions.
     * @throws \InvalidArgumentException If an invalid type is provided, or if a
     *        child is given but is not an instance of
     *        {@see Google\Cloud\Spanner\ArrayType} or
     *        {@see Google\Cloud\Spanner\StructType}.
     */
    public function addUnnamed($type, $child = null)
    {
        return $this->add(null, $type, $child);
    }

    /**
     * Fetch the defined fields list.
     *
     * @access private
     * @return array[]
     */
    public function fields()
    {
        return $this->fields;
    }
}
