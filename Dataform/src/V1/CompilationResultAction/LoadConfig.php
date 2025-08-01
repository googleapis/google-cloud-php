<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataform/v1/dataform.proto

namespace Google\Cloud\Dataform\V1\CompilationResultAction;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Simplified load configuration for actions
 *
 * Generated from protobuf message <code>google.cloud.dataform.v1.CompilationResultAction.LoadConfig</code>
 */
class LoadConfig extends \Google\Protobuf\Internal\Message
{
    protected $mode;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode $replace
     *           Replace destination table
     *     @type \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode $append
     *           Append into destination table
     *     @type \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode $maximum
     *           Insert records where the value exceeds the previous maximum value for a
     *           column in the destination table
     *     @type \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode $unique
     *           Insert records where the value of a column is not already present in
     *           the destination table
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataform\V1\Dataform::initOnce();
        parent::__construct($data);
    }

    /**
     * Replace destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.SimpleLoadMode replace = 1;</code>
     * @return \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode|null
     */
    public function getReplace()
    {
        return $this->readOneof(1);
    }

    public function hasReplace()
    {
        return $this->hasOneof(1);
    }

    /**
     * Replace destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.SimpleLoadMode replace = 1;</code>
     * @param \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode $var
     * @return $this
     */
    public function setReplace($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Append into destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.SimpleLoadMode append = 2;</code>
     * @return \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode|null
     */
    public function getAppend()
    {
        return $this->readOneof(2);
    }

    public function hasAppend()
    {
        return $this->hasOneof(2);
    }

    /**
     * Append into destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.SimpleLoadMode append = 2;</code>
     * @param \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode $var
     * @return $this
     */
    public function setAppend($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dataform\V1\CompilationResultAction\SimpleLoadMode::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Insert records where the value exceeds the previous maximum value for a
     * column in the destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.IncrementalLoadMode maximum = 3;</code>
     * @return \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode|null
     */
    public function getMaximum()
    {
        return $this->readOneof(3);
    }

    public function hasMaximum()
    {
        return $this->hasOneof(3);
    }

    /**
     * Insert records where the value exceeds the previous maximum value for a
     * column in the destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.IncrementalLoadMode maximum = 3;</code>
     * @param \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode $var
     * @return $this
     */
    public function setMaximum($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Insert records where the value of a column is not already present in
     * the destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.IncrementalLoadMode unique = 4;</code>
     * @return \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode|null
     */
    public function getUnique()
    {
        return $this->readOneof(4);
    }

    public function hasUnique()
    {
        return $this->hasOneof(4);
    }

    /**
     * Insert records where the value of a column is not already present in
     * the destination table
     *
     * Generated from protobuf field <code>.google.cloud.dataform.v1.CompilationResultAction.IncrementalLoadMode unique = 4;</code>
     * @param \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode $var
     * @return $this
     */
    public function setUnique($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dataform\V1\CompilationResultAction\IncrementalLoadMode::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->whichOneof("mode");
    }

}


