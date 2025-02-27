<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/artifactregistry/v1/generic.proto

namespace Google\Cloud\ArtifactRegistry\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * GenericArtifact represents a generic artifact
 *
 * Generated from protobuf message <code>google.devtools.artifactregistry.v1.GenericArtifact</code>
 */
class GenericArtifact extends \Google\Protobuf\Internal\Message
{
    /**
     * Resource name of the generic artifact.
     * project, location, repository, package_id and version_id
     * create a unique generic artifact.
     * i.e. "projects/test-project/locations/us-west4/repositories/test-repo/
     * genericArtifacts/package_id:version_id"
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * The version of the generic artifact.
     *
     * Generated from protobuf field <code>string version = 2;</code>
     */
    protected $version = '';
    /**
     * Output only. The time when the Generic module is created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. The time when the Generic module is updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Resource name of the generic artifact.
     *           project, location, repository, package_id and version_id
     *           create a unique generic artifact.
     *           i.e. "projects/test-project/locations/us-west4/repositories/test-repo/
     *           genericArtifacts/package_id:version_id"
     *     @type string $version
     *           The version of the generic artifact.
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The time when the Generic module is created.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The time when the Generic module is updated.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Devtools\Artifactregistry\V1\Generic::initOnce();
        parent::__construct($data);
    }

    /**
     * Resource name of the generic artifact.
     * project, location, repository, package_id and version_id
     * create a unique generic artifact.
     * i.e. "projects/test-project/locations/us-west4/repositories/test-repo/
     * genericArtifacts/package_id:version_id"
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Resource name of the generic artifact.
     * project, location, repository, package_id and version_id
     * create a unique generic artifact.
     * i.e. "projects/test-project/locations/us-west4/repositories/test-repo/
     * genericArtifacts/package_id:version_id"
     *
     * Generated from protobuf field <code>string name = 1;</code>
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
     * The version of the generic artifact.
     *
     * Generated from protobuf field <code>string version = 2;</code>
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * The version of the generic artifact.
     *
     * Generated from protobuf field <code>string version = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setVersion($var)
    {
        GPBUtil::checkString($var, True);
        $this->version = $var;

        return $this;
    }

    /**
     * Output only. The time when the Generic module is created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function hasCreateTime()
    {
        return isset($this->create_time);
    }

    public function clearCreateTime()
    {
        unset($this->create_time);
    }

    /**
     * Output only. The time when the Generic module is created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->create_time = $var;

        return $this;
    }

    /**
     * Output only. The time when the Generic module is updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    public function hasUpdateTime()
    {
        return isset($this->update_time);
    }

    public function clearUpdateTime()
    {
        unset($this->update_time);
    }

    /**
     * Output only. The time when the Generic module is updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->update_time = $var;

        return $this;
    }

}

