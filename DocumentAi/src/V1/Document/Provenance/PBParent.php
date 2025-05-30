<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/documentai/v1/document.proto

namespace Google\Cloud\DocumentAI\V1\Document\Provenance;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The parent element the current element is based on. Used for
 * referencing/aligning, removal and replacement operations.
 *
 * Generated from protobuf message <code>google.cloud.documentai.v1.Document.Provenance.Parent</code>
 */
class PBParent extends \Google\Protobuf\Internal\Message
{
    /**
     * The index of the index into current revision's parent_ids list.
     *
     * Generated from protobuf field <code>int32 revision = 1;</code>
     */
    protected $revision = 0;
    /**
     * The index of the parent item in the corresponding item list (eg. list
     * of entities, properties within entities, etc.) in the parent revision.
     *
     * Generated from protobuf field <code>int32 index = 3;</code>
     */
    protected $index = 0;
    /**
     * The id of the parent provenance.
     *
     * Generated from protobuf field <code>int32 id = 2 [deprecated = true];</code>
     * @deprecated
     */
    protected $id = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $revision
     *           The index of the index into current revision's parent_ids list.
     *     @type int $index
     *           The index of the parent item in the corresponding item list (eg. list
     *           of entities, properties within entities, etc.) in the parent revision.
     *     @type int $id
     *           The id of the parent provenance.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Documentai\V1\Document::initOnce();
        parent::__construct($data);
    }

    /**
     * The index of the index into current revision's parent_ids list.
     *
     * Generated from protobuf field <code>int32 revision = 1;</code>
     * @return int
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * The index of the index into current revision's parent_ids list.
     *
     * Generated from protobuf field <code>int32 revision = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setRevision($var)
    {
        GPBUtil::checkInt32($var);
        $this->revision = $var;

        return $this;
    }

    /**
     * The index of the parent item in the corresponding item list (eg. list
     * of entities, properties within entities, etc.) in the parent revision.
     *
     * Generated from protobuf field <code>int32 index = 3;</code>
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * The index of the parent item in the corresponding item list (eg. list
     * of entities, properties within entities, etc.) in the parent revision.
     *
     * Generated from protobuf field <code>int32 index = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setIndex($var)
    {
        GPBUtil::checkInt32($var);
        $this->index = $var;

        return $this;
    }

    /**
     * The id of the parent provenance.
     *
     * Generated from protobuf field <code>int32 id = 2 [deprecated = true];</code>
     * @return int
     * @deprecated
     */
    public function getId()
    {
        if ($this->id !== 0) {
            @trigger_error('id is deprecated.', E_USER_DEPRECATED);
        }
        return $this->id;
    }

    /**
     * The id of the parent provenance.
     *
     * Generated from protobuf field <code>int32 id = 2 [deprecated = true];</code>
     * @param int $var
     * @return $this
     * @deprecated
     */
    public function setId($var)
    {
        @trigger_error('id is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkInt32($var);
        $this->id = $var;

        return $this;
    }

}


