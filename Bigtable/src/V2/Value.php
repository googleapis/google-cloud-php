<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/v2/data.proto

namespace Google\Cloud\Bigtable\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * `Value` represents a dynamically typed value.
 * The typed fields in `Value` are used as a transport encoding for the actual
 * value (which may be of a more complex type). See the documentation of the
 * `Type` message for more details.
 *
 * Generated from protobuf message <code>google.bigtable.v2.Value</code>
 */
class Value extends \Google\Protobuf\Internal\Message
{
    /**
     * The verified `Type` of this `Value`, if it cannot be inferred.
     * Read results will never specify the encoding for `type` since the value
     * will already have been decoded by the server. Furthermore, the `type` will
     * be omitted entirely if it can be inferred from a previous response. The
     * exact semantics for inferring `type` will vary, and are therefore
     * documented separately for each read method.
     * When using composite types (Struct, Array, Map) only the outermost `Value`
     * will specify the `type`. This top-level `type` will define the types for
     * any nested `Struct' fields, `Array` elements, or `Map` key/value pairs.
     * If a nested `Value` provides a `type` on write, the request will be
     * rejected with INVALID_ARGUMENT.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.Type type = 7;</code>
     */
    protected $type = null;
    protected $kind;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Bigtable\V2\Type $type
     *           The verified `Type` of this `Value`, if it cannot be inferred.
     *           Read results will never specify the encoding for `type` since the value
     *           will already have been decoded by the server. Furthermore, the `type` will
     *           be omitted entirely if it can be inferred from a previous response. The
     *           exact semantics for inferring `type` will vary, and are therefore
     *           documented separately for each read method.
     *           When using composite types (Struct, Array, Map) only the outermost `Value`
     *           will specify the `type`. This top-level `type` will define the types for
     *           any nested `Struct' fields, `Array` elements, or `Map` key/value pairs.
     *           If a nested `Value` provides a `type` on write, the request will be
     *           rejected with INVALID_ARGUMENT.
     *     @type string $raw_value
     *           Represents a raw byte sequence with no type information.
     *           The `type` field must be omitted.
     *     @type int|string $raw_timestamp_micros
     *           Represents a raw cell timestamp with no type information.
     *           The `type` field must be omitted.
     *     @type string $bytes_value
     *           Represents a typed value transported as a byte sequence.
     *     @type string $string_value
     *           Represents a typed value transported as a string.
     *     @type int|string $int_value
     *           Represents a typed value transported as an integer.
     *     @type bool $bool_value
     *           Represents a typed value transported as a boolean.
     *     @type float $float_value
     *           Represents a typed value transported as a floating point number.
     *           Does not support NaN or infinities.
     *     @type \Google\Protobuf\Timestamp $timestamp_value
     *           Represents a typed value transported as a timestamp.
     *     @type \Google\Type\Date $date_value
     *           Represents a typed value transported as a date.
     *     @type \Google\Cloud\Bigtable\V2\ArrayValue $array_value
     *           Represents a typed value transported as a sequence of values.
     *           To differentiate between `Struct`, `Array`, and `Map`, the outermost
     *           `Value` must provide an explicit `type` on write. This `type` will
     *           apply recursively to the nested `Struct` fields, `Array` elements,
     *           or `Map` key/value pairs, which *must not* supply their own `type`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Bigtable\V2\Data::initOnce();
        parent::__construct($data);
    }

    /**
     * The verified `Type` of this `Value`, if it cannot be inferred.
     * Read results will never specify the encoding for `type` since the value
     * will already have been decoded by the server. Furthermore, the `type` will
     * be omitted entirely if it can be inferred from a previous response. The
     * exact semantics for inferring `type` will vary, and are therefore
     * documented separately for each read method.
     * When using composite types (Struct, Array, Map) only the outermost `Value`
     * will specify the `type`. This top-level `type` will define the types for
     * any nested `Struct' fields, `Array` elements, or `Map` key/value pairs.
     * If a nested `Value` provides a `type` on write, the request will be
     * rejected with INVALID_ARGUMENT.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.Type type = 7;</code>
     * @return \Google\Cloud\Bigtable\V2\Type|null
     */
    public function getType()
    {
        return $this->type;
    }

    public function hasType()
    {
        return isset($this->type);
    }

    public function clearType()
    {
        unset($this->type);
    }

    /**
     * The verified `Type` of this `Value`, if it cannot be inferred.
     * Read results will never specify the encoding for `type` since the value
     * will already have been decoded by the server. Furthermore, the `type` will
     * be omitted entirely if it can be inferred from a previous response. The
     * exact semantics for inferring `type` will vary, and are therefore
     * documented separately for each read method.
     * When using composite types (Struct, Array, Map) only the outermost `Value`
     * will specify the `type`. This top-level `type` will define the types for
     * any nested `Struct' fields, `Array` elements, or `Map` key/value pairs.
     * If a nested `Value` provides a `type` on write, the request will be
     * rejected with INVALID_ARGUMENT.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.Type type = 7;</code>
     * @param \Google\Cloud\Bigtable\V2\Type $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Bigtable\V2\Type::class);
        $this->type = $var;

        return $this;
    }

    /**
     * Represents a raw byte sequence with no type information.
     * The `type` field must be omitted.
     *
     * Generated from protobuf field <code>bytes raw_value = 8;</code>
     * @return string
     */
    public function getRawValue()
    {
        return $this->readOneof(8);
    }

    public function hasRawValue()
    {
        return $this->hasOneof(8);
    }

    /**
     * Represents a raw byte sequence with no type information.
     * The `type` field must be omitted.
     *
     * Generated from protobuf field <code>bytes raw_value = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setRawValue($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Represents a raw cell timestamp with no type information.
     * The `type` field must be omitted.
     *
     * Generated from protobuf field <code>int64 raw_timestamp_micros = 9;</code>
     * @return int|string
     */
    public function getRawTimestampMicros()
    {
        return $this->readOneof(9);
    }

    public function hasRawTimestampMicros()
    {
        return $this->hasOneof(9);
    }

    /**
     * Represents a raw cell timestamp with no type information.
     * The `type` field must be omitted.
     *
     * Generated from protobuf field <code>int64 raw_timestamp_micros = 9;</code>
     * @param int|string $var
     * @return $this
     */
    public function setRawTimestampMicros($var)
    {
        GPBUtil::checkInt64($var);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a byte sequence.
     *
     * Generated from protobuf field <code>bytes bytes_value = 2;</code>
     * @return string
     */
    public function getBytesValue()
    {
        return $this->readOneof(2);
    }

    public function hasBytesValue()
    {
        return $this->hasOneof(2);
    }

    /**
     * Represents a typed value transported as a byte sequence.
     *
     * Generated from protobuf field <code>bytes bytes_value = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setBytesValue($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a string.
     *
     * Generated from protobuf field <code>string string_value = 3;</code>
     * @return string
     */
    public function getStringValue()
    {
        return $this->readOneof(3);
    }

    public function hasStringValue()
    {
        return $this->hasOneof(3);
    }

    /**
     * Represents a typed value transported as a string.
     *
     * Generated from protobuf field <code>string string_value = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setStringValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as an integer.
     *
     * Generated from protobuf field <code>int64 int_value = 6;</code>
     * @return int|string
     */
    public function getIntValue()
    {
        return $this->readOneof(6);
    }

    public function hasIntValue()
    {
        return $this->hasOneof(6);
    }

    /**
     * Represents a typed value transported as an integer.
     *
     * Generated from protobuf field <code>int64 int_value = 6;</code>
     * @param int|string $var
     * @return $this
     */
    public function setIntValue($var)
    {
        GPBUtil::checkInt64($var);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a boolean.
     *
     * Generated from protobuf field <code>bool bool_value = 10;</code>
     * @return bool
     */
    public function getBoolValue()
    {
        return $this->readOneof(10);
    }

    public function hasBoolValue()
    {
        return $this->hasOneof(10);
    }

    /**
     * Represents a typed value transported as a boolean.
     *
     * Generated from protobuf field <code>bool bool_value = 10;</code>
     * @param bool $var
     * @return $this
     */
    public function setBoolValue($var)
    {
        GPBUtil::checkBool($var);
        $this->writeOneof(10, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a floating point number.
     * Does not support NaN or infinities.
     *
     * Generated from protobuf field <code>double float_value = 11;</code>
     * @return float
     */
    public function getFloatValue()
    {
        return $this->readOneof(11);
    }

    public function hasFloatValue()
    {
        return $this->hasOneof(11);
    }

    /**
     * Represents a typed value transported as a floating point number.
     * Does not support NaN or infinities.
     *
     * Generated from protobuf field <code>double float_value = 11;</code>
     * @param float $var
     * @return $this
     */
    public function setFloatValue($var)
    {
        GPBUtil::checkDouble($var);
        $this->writeOneof(11, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a timestamp.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp timestamp_value = 12;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getTimestampValue()
    {
        return $this->readOneof(12);
    }

    public function hasTimestampValue()
    {
        return $this->hasOneof(12);
    }

    /**
     * Represents a typed value transported as a timestamp.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp timestamp_value = 12;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setTimestampValue($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->writeOneof(12, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a date.
     *
     * Generated from protobuf field <code>.google.type.Date date_value = 13;</code>
     * @return \Google\Type\Date|null
     */
    public function getDateValue()
    {
        return $this->readOneof(13);
    }

    public function hasDateValue()
    {
        return $this->hasOneof(13);
    }

    /**
     * Represents a typed value transported as a date.
     *
     * Generated from protobuf field <code>.google.type.Date date_value = 13;</code>
     * @param \Google\Type\Date $var
     * @return $this
     */
    public function setDateValue($var)
    {
        GPBUtil::checkMessage($var, \Google\Type\Date::class);
        $this->writeOneof(13, $var);

        return $this;
    }

    /**
     * Represents a typed value transported as a sequence of values.
     * To differentiate between `Struct`, `Array`, and `Map`, the outermost
     * `Value` must provide an explicit `type` on write. This `type` will
     * apply recursively to the nested `Struct` fields, `Array` elements,
     * or `Map` key/value pairs, which *must not* supply their own `type`.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.ArrayValue array_value = 4;</code>
     * @return \Google\Cloud\Bigtable\V2\ArrayValue|null
     */
    public function getArrayValue()
    {
        return $this->readOneof(4);
    }

    public function hasArrayValue()
    {
        return $this->hasOneof(4);
    }

    /**
     * Represents a typed value transported as a sequence of values.
     * To differentiate between `Struct`, `Array`, and `Map`, the outermost
     * `Value` must provide an explicit `type` on write. This `type` will
     * apply recursively to the nested `Struct` fields, `Array` elements,
     * or `Map` key/value pairs, which *must not* supply their own `type`.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.ArrayValue array_value = 4;</code>
     * @param \Google\Cloud\Bigtable\V2\ArrayValue $var
     * @return $this
     */
    public function setArrayValue($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Bigtable\V2\ArrayValue::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getKind()
    {
        return $this->whichOneof("kind");
    }

}

