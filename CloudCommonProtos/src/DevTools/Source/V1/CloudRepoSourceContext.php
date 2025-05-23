<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/source/v1/source_context.proto

namespace Google\Cloud\DevTools\Source\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A CloudRepoSourceContext denotes a particular revision in a cloud
 * repo (a repo hosted by the Google Cloud Platform).
 *
 * Generated from protobuf message <code>google.devtools.source.v1.CloudRepoSourceContext</code>
 */
class CloudRepoSourceContext extends \Google\Protobuf\Internal\Message
{
    /**
     * The ID of the repo.
     *
     * Generated from protobuf field <code>.google.devtools.source.v1.RepoId repo_id = 1;</code>
     */
    protected $repo_id = null;
    protected $revision;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\DevTools\Source\V1\RepoId $repo_id
     *           The ID of the repo.
     *     @type string $revision_id
     *           A revision ID.
     *     @type string $alias_name
     *           The name of an alias (branch, tag, etc.).
     *     @type \Google\Cloud\DevTools\Source\V1\AliasContext $alias_context
     *           An alias, which may be a branch or tag.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Devtools\Source\V1\SourceContext::initOnce();
        parent::__construct($data);
    }

    /**
     * The ID of the repo.
     *
     * Generated from protobuf field <code>.google.devtools.source.v1.RepoId repo_id = 1;</code>
     * @return \Google\Cloud\DevTools\Source\V1\RepoId|null
     */
    public function getRepoId()
    {
        return $this->repo_id;
    }

    public function hasRepoId()
    {
        return isset($this->repo_id);
    }

    public function clearRepoId()
    {
        unset($this->repo_id);
    }

    /**
     * The ID of the repo.
     *
     * Generated from protobuf field <code>.google.devtools.source.v1.RepoId repo_id = 1;</code>
     * @param \Google\Cloud\DevTools\Source\V1\RepoId $var
     * @return $this
     */
    public function setRepoId($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DevTools\Source\V1\RepoId::class);
        $this->repo_id = $var;

        return $this;
    }

    /**
     * A revision ID.
     *
     * Generated from protobuf field <code>string revision_id = 2;</code>
     * @return string
     */
    public function getRevisionId()
    {
        return $this->readOneof(2);
    }

    public function hasRevisionId()
    {
        return $this->hasOneof(2);
    }

    /**
     * A revision ID.
     *
     * Generated from protobuf field <code>string revision_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setRevisionId($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * The name of an alias (branch, tag, etc.).
     *
     * Generated from protobuf field <code>string alias_name = 3 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getAliasName()
    {
        if ($this->hasOneof(3)) {
            @trigger_error('alias_name is deprecated.', E_USER_DEPRECATED);
        }
        return $this->readOneof(3);
    }

    public function hasAliasName()
    {
        if ($this->hasOneof(3)) {
            @trigger_error('alias_name is deprecated.', E_USER_DEPRECATED);
        }
        return $this->hasOneof(3);
    }

    /**
     * The name of an alias (branch, tag, etc.).
     *
     * Generated from protobuf field <code>string alias_name = 3 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setAliasName($var)
    {
        @trigger_error('alias_name is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * An alias, which may be a branch or tag.
     *
     * Generated from protobuf field <code>.google.devtools.source.v1.AliasContext alias_context = 4;</code>
     * @return \Google\Cloud\DevTools\Source\V1\AliasContext|null
     */
    public function getAliasContext()
    {
        return $this->readOneof(4);
    }

    public function hasAliasContext()
    {
        return $this->hasOneof(4);
    }

    /**
     * An alias, which may be a branch or tag.
     *
     * Generated from protobuf field <code>.google.devtools.source.v1.AliasContext alias_context = 4;</code>
     * @param \Google\Cloud\DevTools\Source\V1\AliasContext $var
     * @return $this
     */
    public function setAliasContext($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DevTools\Source\V1\AliasContext::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getRevision()
    {
        return $this->whichOneof("revision");
    }

}

