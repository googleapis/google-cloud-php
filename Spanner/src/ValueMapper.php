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
use Google\Cloud\Spanner\V1\TypeCode;
use Google\Cloud\Spanner\V1\TypeAnnotationCode;

/**
 * Manage value mappings between Google Cloud PHP and Cloud Spanner
 */
class ValueMapper
{
    use ArrayTrait;
    use TimeTrait;

    const TYPE_BOOL = TypeCode::BOOL;
    const TYPE_INT64 = TypeCode::INT64;
    const TYPE_FLOAT64 = TypeCode::FLOAT64;
    const TYPE_TIMESTAMP = TypeCode::TIMESTAMP;
    const TYPE_DATE = TypeCode::DATE;
    const TYPE_STRING = TypeCode::STRING;
    const TYPE_BYTES = TypeCode::BYTES;
    const TYPE_ARRAY = TypeCode::PBARRAY;
    const TYPE_STRUCT = TypeCode::STRUCT;
    const TYPE_NUMERIC = TypeCode::NUMERIC;
    const TYPE_JSON = TypeCode::JSON;
    const TYPE_PG_NUMERIC = 'pgNumeric';
    const TYPE_PG_JSONB = 'pgJsonb';

    /**
     * @var array
     */
    public static $allowedTypes = [
        self::TYPE_BOOL,
        self::TYPE_INT64,
        self::TYPE_FLOAT64,
        self::TYPE_TIMESTAMP,
        self::TYPE_DATE,
        self::TYPE_STRING,
        self::TYPE_BYTES,
        self::TYPE_ARRAY,
        self::TYPE_STRUCT,
        self::TYPE_NUMERIC,
        self::TYPE_JSON,
        self::TYPE_PG_NUMERIC,
        self::TYPE_PG_JSONB,
    ];

    /*
     * Library defined wrapper types declared here will be mapped to a class.
     *
     * Types outside this map are identified only by type codes,
     * but these wrapper classes require a type code annotation as well.
     * Declaring the type here takes care of encoding such types.
     *
     * @var array
     */
    private static $typeToClassMap = [
        self::TYPE_PG_NUMERIC => PgNumeric::class,
        self::TYPE_PG_JSONB => PgJsonb::class,
    ];

    /*
     * Maps library defined wrapper types (e.g., {@see Google\Cloud\Spanner\PgNumeric})
     * which have an accompanying type annotation code to the underlying type code.
     *
     * @var array
     */
    private static $typeCodes = [
        self::TYPE_PG_NUMERIC => self::TYPE_NUMERIC,
        self::TYPE_PG_JSONB => self::TYPE_JSON,
    ];

    /*
     * Maps library defined wrapper types (e.g., {@see Google\Cloud\Spanner\PgNumeric}) to
     * their associated type annotation code.
     *
     * @var array
     */
    private static $typeAnnotations = [
        self::TYPE_PG_NUMERIC => TypeAnnotationCode::PG_NUMERIC,
        self::TYPE_PG_JSONB => TypeAnnotationCode::PG_JSONB,
    ];

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @param bool $returnInt64AsObject
     */
    public function __construct($returnInt64AsObject)
    {
        $this->returnInt64AsObject = $returnInt64AsObject;
    }

    /**
     * Accepts an array of key/value pairs, where the key is a SQL parameter
     * name and the value is the value interpolated by the server, and returns
     * an array of parameters and inferred parameter types.
     *
     * @param array $parameters The key/value parameters.
     * @param array $types The types of values.
     * @return array An associative array containing params and paramTypes.
     */
    public function formatParamsForExecuteSql(array $parameters, array $types = [])
    {
        $paramTypes = [];

        foreach ($parameters as $key => $value) {
            if (is_null($value) && !isset($types[$key])) {
                throw new \BadMethodCallException(sprintf(
                    'Null value for parameter @%s must supply a parameter type.',
                    $key
                ));
            }

            $type = isset($types[$key])
                ? $types[$key]
                : null;

            if (!$type && is_array($value) && !$this->isAssoc($value)) {
                $type = new ArrayType(null);
            }

            $definition = null;
            if ($type) {
                list ($type, $definition) = $this->resolveTypeDefinition($type, $key);
            }

            $paramDefinition = $this->paramType($value, $type, $definition);
            list ($parameters[$key], $paramTypes[$key]) = $paramDefinition;
        }

        return [
            'params' => $parameters,
            'paramTypes' => $paramTypes
        ];
    }

    /**
     * Accepts a list of values and encodes the value into a format accepted by
     * the Spanner API.
     *
     * @param array $values The list of values
     * @param bool $allowMixedArrayType If true, array values may be of mixed type.
     *        **Defaults to** `false`.
     * @return array The encoded values
     */
    public function encodeValuesAsSimpleType(array $values, $allowMixedArrayType = false)
    {
        $res = [];
        foreach ($values as $value) {
            $type = null;
            $definition = null;
            if (is_array($value) && (empty($value) || !$this->isAssoc($value))) {
                $type = Database::TYPE_ARRAY;
                $definition = new ArrayType(null);
            }

            $res[] = $this->paramType($value, $type, $definition, $allowMixedArrayType)[0];
        }

        return $res;
    }

    /**
     * Accepts a list of columns (with name and type) and a row from read or
     * executeSql and decodes each value to its corresponding PHP type.
     *
     * @param array $columns The list of columns.
     * @param array $row The row data.
     * @param string $format The format in which to return the rows.
     * @return array The decoded row data.
     * @throws \InvalidArgumentException
     */
    public function decodeValues(array $columns, array $row, $format)
    {
        switch ($format) {
            case Result::RETURN_NAME_VALUE_PAIR:
                foreach ($row as $index => $value) {
                    $row[$index] = [
                        'name' => $this->getColumnName($columns, $index),
                        'value' => $this->decodeValue($value, $columns[$index]['type'])
                    ];
                }

                return $row;

            case Result::RETURN_ASSOCIATIVE:
                foreach ($row as $index => $value) {
                    unset($row[$index]);
                    $row[$this->getColumnName($columns, $index)] = $this->decodeValue(
                        $value,
                        $columns[$index]['type']
                    );
                }

                return $row;

            case Result::RETURN_ZERO_INDEXED:
                foreach ($row as $index => $value) {
                    $row[$index] = $this->decodeValue($value, $columns[$index]['type']);
                }

                return $row;
            default:
                throw new \InvalidArgumentException('Invalid format provided.');
        }
    }

    /**
     * Infer the type of a parameter and ensure that the definition, if given,
     * is valid.
     *
     * Because types are provided as either an integer code, or a StructType
     * or an ArrayType, and `paramType()` accepts the type and Struct/Array
     * definition separately, this method determines the proper value of
     * both the type and definition prior to calling `paramType()`.
     *
     * @param mixed $type The type code or definition.
     * @param string $key the parameter key name.
     * @return array Containing the type value at position 0, and definition or
     *         null at position 1.
     */
    private function resolveTypeDefinition($type, $key = null)
    {
        $definition = null;
        if (is_array($type)) {
            $type += [
                1 => null,
                2 => null
            ];

            $definition = new ArrayType($type[1], $type[2]);
            $type = Database::TYPE_ARRAY;
        } elseif ($type instanceof ArrayType) {
            $definition = $type;
            $type = Database::TYPE_ARRAY;
        } elseif ($type instanceof StructType) {
            $definition = $type;
            $type = Database::TYPE_STRUCT;
        }

        return [$type, $definition];
    }

    /**
     * Convert a single value to its corresponding PHP type.
     *
     * @param mixed $value The value to decode
     * @param array $type The value type
     * @return mixed
     */
    private function decodeValue($value, array $type)
    {
        if ($value === null || $value === '') {
            return $value;
        }

        switch ($type['code']) {
            case self::TYPE_INT64:
                $value = $this->returnInt64AsObject
                    ? new Int64($value)
                    : (int) $value;
                break;

            case self::TYPE_TIMESTAMP:
                $value = $this->parseTimeString($value);
                $value = new Timestamp($value[0], $value[1]);
                break;

            case self::TYPE_DATE:
                $value = new Date(new \DateTimeImmutable($value));
                break;

            case self::TYPE_BYTES:
                $value = new Bytes(base64_decode($value));
                break;

            case self::TYPE_ARRAY:
                $res = [];
                foreach ($value as $item) {
                    $res[] = $this->decodeValue($item, $type['arrayElementType']);
                }

                $value = $res;
                break;

            case self::TYPE_STRUCT:
                $fields = isset($type['structType']['fields'])
                    ? $type['structType']['fields']
                    : [];

                $value = $this->decodeValues($fields, $value, Result::RETURN_ASSOCIATIVE);
                break;

            case self::TYPE_NUMERIC:
                if (isset($type['typeAnnotation']) && $type['typeAnnotation'] === TypeAnnotationCode::PG_NUMERIC) {
                    $value = new PgNumeric($value);
                } else {
                    $value = new Numeric($value);
                }
                break;

            case self::TYPE_JSON:
                if (isset($type['typeAnnotation']) && $type['typeAnnotation'] === TypeAnnotationCode::PG_JSONB) {
                    $value = new PgJsonb($value);
                }
                break;

            case self::TYPE_FLOAT64:
                // NaN, Infinite and -Infinite are possible FLOAT64 values,
                // but when the gRPC response is decoded, they are represented
                // as strings. This conditional checks for a string, converts to
                // an equivalent double value, or dies if something really weird
                // happens.
                if (is_string($value)) {
                    switch ($value) {
                        case 'NaN':
                            $value = NAN;
                            break;

                        case 'Infinity':
                            $value = INF;
                            break;

                        case '-Infinity':
                            $value = -INF;
                            break;

                        default:
                            throw new \RuntimeException(sprintf(
                                'Unexpected string value %s encountered in FLOAT64 field.',
                                $value
                            ));
                    }
                }

                break;
        }

        return $value;
    }

    /**
     * Create a spanner parameter type value object from a PHP value type.
     *
     * @param mixed $value The PHP value
     * @param int|null $givenType If set, this type will be used in place of an
     *        inferred type.
     * @param ArrayType|StructType|null $definition Defines the structured value
     *        type for non-primitive values.
     * @param bool $allowMixedArrayType If true, array values may be of mixed type.
     *        This is useful when reading against complex keys containing multiple
     *        elements of differing types.
     * @return array The Value, typeCode and optionally the typeAnnotation
     *        in the format: [<value>, ['code' => <typeCode>, 'typeAnnotation' => <typeAnnotation>]].
     */
    private function paramType(
        $value,
        $givenType = null,
        $definition = null,
        $allowMixedArrayType = false
    ) {
        $valueType = gettype($value);
        $typeAnnotation = null;

        // If a definition is provided, the type is set to `array` to force
        // the value to be interpreted as an array or a struct, even if null.
        if ($definition !== null) {
            $valueType = 'array';
        }

        // Convert library specific wrapper type to type code and type
        // code annotation, if applicable.
        if (isset(self::$typeCodes[$givenType])) {
            $typeAnnotation = self::$typeAnnotations[$givenType];
            $givenType = self::$typeCodes[$givenType];
        }

        switch ($valueType) {
            case 'boolean':
                $type = $this->typeObject($givenType ?: self::TYPE_BOOL, $typeAnnotation);
                break;

            case 'integer':
                $value = (string) $value;
                $type = $this->typeObject($givenType ?: self::TYPE_INT64, $typeAnnotation);
                break;

            case 'double':
                $type = $this->typeObject($givenType ?: self::TYPE_FLOAT64, $typeAnnotation);
                switch ($value) {
                    case INF:
                        $value = 'Infinity';
                        break;

                    case -INF:
                        $value = '-Infinity';
                        break;
                }

                if (!is_string($value) && is_nan($value)) {
                    $value = 'NaN';
                }

                break;

            case 'string':
                $type = $this->typeObject($givenType ?: self::TYPE_STRING, $typeAnnotation);
                break;

            case 'resource':
                $type = $this->typeObject($givenType ?: self::TYPE_BYTES, $typeAnnotation);
                $value = base64_encode(stream_get_contents($value));
                break;

            case 'object':
                list ($type, $value) = $this->objectParam($value);
                break;

            case 'array':
                if ($givenType === Database::TYPE_STRUCT) {
                    if (!($definition instanceof StructType)) {
                        throw new \InvalidArgumentException(
                            'Struct parameter types must be declared explicitly, and must '.
                            'be an instance of Google\Cloud\Spanner\StructType.'
                        );
                    }

                    if ($value instanceof \stdClass) {
                        $value = (array) $value;
                    }

                    list ($value, $type) = $this->structParam($value, $definition);
                } else {
                    if (!($definition instanceof ArrayType)) {
                        throw new \InvalidArgumentException(
                            'Array parameter types must be an instance of Google\Cloud\Spanner\ArrayType.'
                        );
                    }

                    list ($value, $type) = $this->arrayParam($value, $definition, $allowMixedArrayType);
                }

                break;

            case 'NULL':
                $type = $this->typeObject($givenType, $typeAnnotation);

                break;

            default:
                throw new \InvalidArgumentException(sprintf(
                    'Unrecognized value type %s. ' .
                    'Please ensure you are using the latest version of google/cloud or google/cloud-spanner.',
                    get_class($value)
                ));
                break;
        }

        return [$value, $type];
    }

    /**
     * Create value and type declaration for a Struct Query Parameter.
     *
     * @param StructValue|array|null $value The struct value.
     * @param StructType $type The struct type.
     * @return [array, array] An array containing the value and type.
     */
    private function structParam($value, StructType $type)
    {
        if (!($value instanceof StructValue) && !is_array($value) && $value !== null) {
            throw new \InvalidArgumentException(
                'Struct value must be an array an instance of `Google\Cloud\Spanner\StructValue` or null.'
            );
        }

        $typeFields = $type->fields();

        // iterate through types and values separately to accurately align
        // unnamed and fields with duplicate names.
        // We also record the original position in order to return values in
        // the order given.
        $values = [];
        if (is_array($value)) {
            $idx = 0;
            foreach ($value as $name => $val) {
                if (!isset($values[$name])) {
                    $values[$name] = [];
                }

                // Nest values inside an array keyed by field name.
                // This allows for duplicate field names, and aligning
                // definitions by position.
                $values[$name][] = [
                    'index' => $idx,
                    'value' => $val
                ];

                $idx++;
            }
        } elseif ($value instanceof StructValue) {
            foreach ($value->values() as $idx => $val) {
                $name = $val['name'];
                $valValue = $val['value'];

                if (!isset($values[$name])) {
                    $values[$name] = [];
                }

                $values[$name][] = [
                    'index' => $idx,
                    'value' => $valValue
                ];
            }
        }

        // Iterate through given type fields and align them with corresponding values.
        $res = [];
        $fields = [];
        $names = [];
        foreach ($typeFields as $typeIndex => $paramType) {
            $fieldName = $paramType['name'];

            // Count the number of times the field name has been encountered thus far.
            // This lets us pick the correct index for duplicate fields.
            if (isset($names[$fieldName])) {
                $names[$fieldName]++;
            } else {
                $names[$fieldName] = 0;
            }

            // Get the value which corresponds to the current type.
            $index = $names[$fieldName];
            $paramValue = isset($values[$fieldName][$index])
                ? $values[$fieldName][$index]
                : null;

            // If the value didn't exist in the values structure, set it to null.
            // The $typeIndex will give us a hook to order fields properly.
            // Otherwise, remove the current field value from the list of values.
            if ($paramValue === null) {
                $paramValue = ['value' => null, 'index' => $typeIndex];
            } else {
                unset($values[$fieldName][$index]);
            }

            $param = $this->paramType($paramValue['value'], $paramType['type'], $paramType['child']);

            $fields[$paramValue['index']] = array_filter([
                'name' => $fieldName,
                'type' => $param[1]
            ]);

            $res[$paramValue['index']] = $param[0];
        }

        // Iterate over any remaining fields. If anything is left here, it means
        // no type was defined and its type must be inferred.
        foreach ($values as $name => $list) {
            foreach ($list as $value) {
                $index = $value['index'];
                $val = $value['value'];

                $type = null;
                $def = null;
                if (is_array($val) && !$this->isAssoc($val)) {
                    $type = Database::TYPE_ARRAY;
                    $def = new ArrayType(null);
                }

                $param = $this->paramType($val, $type, $def);

                $fields[$index] = array_filter([
                    'name' => $name,
                    'type' => $param[1]
                ]);

                $res[$index] = $param[0];
            }
        }

        // Sort values and fields by key to reset back to the order given by the user.
        ksort($res);
        ksort($fields);

        $type = [
            'code' => self::TYPE_STRUCT,
            'structType' => [
                'fields' => $fields
            ]
        ];

        // If the input is null, send null (but with the full type structure)
        $res = $value === null ? null : $res;

        return [
            $res,
            $type
        ];
    }

    /**
     * Create value and paramater type declarations for array SQL parameters.
     *
     * @param array $value The array values.
     * @param ArrayType $arrayObj The array type declaration.
     * @param bool $allowMixedArrayType [optional] If true, array values may be of mixed type.
     *        This is useful when reading against complex keys containing multiple
     *        elements of differing types.
     * @return [array, array] An array containing the value and type.
     */
    private function arrayParam($value, ArrayType $arrayObj, $allowMixedArrayType = false)
    {
        if (!is_array($value) && $value !== null) {
            throw new \InvalidArgumentException('Array value must be an array or null.');
        }

        // tracks the diff typeCode, typeAnnotation of all elements
        // inside the array
        $inferredTypes = [];

        // counts the diff data types used inside the array
        $uniqueTypes = [];
        $res = null;
        if ($value !== null) {
            $res = [];

            foreach ($value as $element) {
                $givenType = null;

                if ($arrayObj->type() === Database::TYPE_STRUCT) {
                    $givenType = $arrayObj->type();
                } elseif (self::isCustomType($arrayObj->type())) {
                    $givenType = $arrayObj->type();
                }

                $type = $this->paramType(
                    $element,
                    $givenType,
                    $arrayObj->structType()
                );

                $res[] = $type[0];
                if (isset($type[1]['code'])) {
                    $typeCode = $type[1]['code'];
                    $inferredType = ['code' => $typeCode];

                    $uniqueTypes[$typeCode] = true;

                    if (isset($type[1]['typeAnnotation'])) {
                        $inferredType['typeAnnotation'] = $type[1]['typeAnnotation'];
                    }

                    $inferredTypes[] = $inferredType;
                }
            }
        }

        if (!$allowMixedArrayType && count($uniqueTypes) > 1) {
            throw new \InvalidArgumentException('Array values may not be of mixed type');
        }


        // get typeCode either from the array type or the first element's inferred type
        $typeCode = self::isCustomType($arrayObj->type())
            ? self::getTypeCodeFromString($arrayObj->type())
            : $arrayObj->type();

        // get typeAnnotationCode either from the array type or the first element's inferred type
        $typeAnnotationCode = self::isCustomType($arrayObj->type())
            ? self::getTypeAnnotationFromString($arrayObj->type())
            : null;

        if ($this->arrayDataMismatch($value, $typeCode, $typeAnnotationCode, $inferredTypes)) {
            throw new \InvalidArgumentException('Array data does not match given array parameter type.');
        }

        if (is_null($typeCode) && count($inferredTypes) > 0 && isset($inferredTypes[0]['code'])) {
            $typeCode = $inferredTypes[0]['code'];
        }
        
        if (is_null($typeAnnotationCode) && count($inferredTypes) > 0 && isset($inferredTypes[0]['typeAnnotation'])) {
            $typeAnnotationCode = $inferredTypes[0]['typeAnnotation'];
        }

        $nested = $arrayObj->structType();

        if ($nested) {
            $nestedDefType = $this->resolveTypeDefinition($nested);
            $nestedDef = $this->paramType(null, $nestedDefType[0], $nestedDefType[1]);

            $typeObject = $nestedDef[1];
        } else {
            $typeObject = $this->typeObject($typeCode, $typeAnnotationCode);
        }

        $type = $this->typeObject(
            self::TYPE_ARRAY,
            null,
            $typeObject,
            'arrayElementType'
        );

        return [$res, $type];
    }

    /**
     * Handle query parameter mappings for various types of objects.
     *
     * @param mixed $value The parameter value.
     * @return [array, array] An array containing the value and type.
     */
    private function objectParam($value)
    {
        if ($value instanceof \stdClass) {
            throw new \InvalidArgumentException(
                'Values of type `\stdClass` are interpreted as structs and must define their types.'
            );
        }

        if ($value instanceof ValueInterface) {
            $typeAnnotation = $value instanceof TypeAnnotationInterface
                          ? $value->typeAnnotation()
                          : null;

            return [
                $this->typeObject($value->type(), $typeAnnotation),
                $value->formatAsString()
            ];
        }

        if ($value instanceof Int64) {
            return [
                $this->typeObject(self::TYPE_INT64),
                $value->get()
            ];
        }

        throw new \InvalidArgumentException(sprintf(
            'Unrecognized value type %s. ' .
            'Please ensure you are using the latest version of google/cloud or google/cloud-spanner.',
            get_class($value)
        ));
    }

    /**
     * Create a type object with a code and definition, if provided.
     *
     * @param int $type The type code.
     * @param int $typeAnnotation The type annotation code
     * @param array $nestedDefinition [optional] A nested definition, to define
     *        the structure of an array or struct type.
     * @param string $nestedDefinitionType [optional] Either `arrayElementType`
     *        or `structType`.
     * @return array
     */
    private function typeObject(
        $type,
        $typeAnnotation = null,
        array $nestedDefinition = [],
        $nestedDefinitionType = null
    ) {
        return array_filter([
            'code' => $type,
            $nestedDefinitionType => $nestedDefinition,
            'typeAnnotation' => $typeAnnotation
        ]);
    }

    /**
     * Return the column name given a list of columns and a field index.
     *
     * If the column name is not found, `$index` is returned.
     *
     * @codingStandardsIgnoreStart
     * @param array $columns A list of columns. See
     *        [ResultSetMetadata](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.ResultSetMetadata)
     *        for expected value. Column names are optional.
     * @param int $index The numerical index of the column to search.
     * @return string|int
     * @codingStandardsIgnoreEnd
     */
    private function getColumnName($columns, $index)
    {
        return (isset($columns[$index]['name']) && $columns[$index]['name'])
            ? $columns[$index]['name']
            : $index;
    }

    /**
     * Is the data type a custom type (w/ typeAnnotation)?
     *
     * @param string $type
     * @return bool
     */
    private static function isCustomType($type)
    {
        return array_key_exists($type, self::$typeToClassMap);
    }

    /**
     * Given a type name(ex: pgNumeric), this method returns a typeCode
     * without having to initialize an object of the corressponding class
     *
     * @param string $type
     * @return int
     */
    private static function getTypeCodeFromString($type)
    {
        return array_key_exists($type, self::$typeCodes) ? self::$typeCodes[$type] : null;
    }

    /**
     * Given a type name(ex: pgNumeric), this method returns a typeAnnotation
     * without having to initialize an object of the corressponding class
     *
     * @param string $type
     * @return int
     */
    private static function getTypeAnnotationFromString($type)
    {
        return array_key_exists($type, self::$typeAnnotations) ? self::$typeAnnotations[$type] : null;
    }

    /**
     * Checks if the data type of elements is the same as data type of array
     *
     * @return bool
     */
    private function arrayDataMismatch($value, $arrayTypeCode, $arrayTypeAnnotation, $inferredTypes)
    {
        $mismatch = false;

        if (!empty($value)) {
            if ($arrayTypeCode && isset($inferredTypes[0]['code'])  &&
            $arrayTypeCode !== $inferredTypes[0]['code']) {
                $mismatch = true;
            }

            if ($arrayTypeAnnotation && isset($inferredTypes[0]['typeAnnotation']) &&
            $arrayTypeAnnotation !== $inferredTypes[0]['typeAnnotation']) {
                $mismatch = true;
            }
        }

        return $mismatch;
    }
}
