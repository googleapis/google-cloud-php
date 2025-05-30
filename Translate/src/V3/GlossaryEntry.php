<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/translate/v3/common.proto

namespace Google\Cloud\Translate\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents a single entry in a glossary.
 *
 * Generated from protobuf message <code>google.cloud.translation.v3.GlossaryEntry</code>
 */
class GlossaryEntry extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. The resource name of the entry.
     * Format:
     *   `projects/&#42;&#47;locations/&#42;&#47;glossaries/&#42;&#47;glossaryEntries/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Describes the glossary entry.
     *
     * Generated from protobuf field <code>string description = 4;</code>
     */
    protected $description = '';
    protected $data;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Identifier. The resource name of the entry.
     *           Format:
     *             `projects/&#42;&#47;locations/&#42;&#47;glossaries/&#42;&#47;glossaryEntries/&#42;`
     *     @type \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsPair $terms_pair
     *           Used for an unidirectional glossary.
     *     @type \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsSet $terms_set
     *           Used for an equivalent term sets glossary.
     *     @type string $description
     *           Describes the glossary entry.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Translate\V3\Common::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifier. The resource name of the entry.
     * Format:
     *   `projects/&#42;&#47;locations/&#42;&#47;glossaries/&#42;&#47;glossaryEntries/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. The resource name of the entry.
     * Format:
     *   `projects/&#42;&#47;locations/&#42;&#47;glossaries/&#42;&#47;glossaryEntries/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Used for an unidirectional glossary.
     *
     * Generated from protobuf field <code>.google.cloud.translation.v3.GlossaryEntry.GlossaryTermsPair terms_pair = 2;</code>
     * @return \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsPair|null
     */
    public function getTermsPair()
    {
        return $this->readOneof(2);
    }

    public function hasTermsPair()
    {
        return $this->hasOneof(2);
    }

    /**
     * Used for an unidirectional glossary.
     *
     * Generated from protobuf field <code>.google.cloud.translation.v3.GlossaryEntry.GlossaryTermsPair terms_pair = 2;</code>
     * @param \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsPair $var
     * @return $this
     */
    public function setTermsPair($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsPair::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Used for an equivalent term sets glossary.
     *
     * Generated from protobuf field <code>.google.cloud.translation.v3.GlossaryEntry.GlossaryTermsSet terms_set = 3;</code>
     * @return \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsSet|null
     */
    public function getTermsSet()
    {
        return $this->readOneof(3);
    }

    public function hasTermsSet()
    {
        return $this->hasOneof(3);
    }

    /**
     * Used for an equivalent term sets glossary.
     *
     * Generated from protobuf field <code>.google.cloud.translation.v3.GlossaryEntry.GlossaryTermsSet terms_set = 3;</code>
     * @param \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsSet $var
     * @return $this
     */
    public function setTermsSet($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Translate\V3\GlossaryEntry\GlossaryTermsSet::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Describes the glossary entry.
     *
     * Generated from protobuf field <code>string description = 4;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Describes the glossary entry.
     *
     * Generated from protobuf field <code>string description = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->whichOneof("data");
    }

}

