<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/cx/v3/agent.proto

namespace Google\Cloud\Dialogflow\Cx\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The response message for
 * [Agents.ExportAgent][google.cloud.dialogflow.cx.v3.Agents.ExportAgent].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.cx.v3.ExportAgentResponse</code>
 */
class ExportAgentResponse extends \Google\Protobuf\Internal\Message
{
    protected $agent;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $agent_uri
     *           The URI to a file containing the exported agent. This field is populated
     *           if `agent_uri` is specified in
     *           [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *     @type string $agent_content
     *           Uncompressed raw byte content for agent. This field is populated
     *           if none of `agent_uri` and `git_destination` are specified in
     *           [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *     @type string $commit_sha
     *           Commit SHA of the git push. This field is populated if
     *           `git_destination` is specified in
     *           [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\Cx\V3\Agent::initOnce();
        parent::__construct($data);
    }

    /**
     * The URI to a file containing the exported agent. This field is populated
     * if `agent_uri` is specified in
     * [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *
     * Generated from protobuf field <code>string agent_uri = 1;</code>
     * @return string
     */
    public function getAgentUri()
    {
        return $this->readOneof(1);
    }

    public function hasAgentUri()
    {
        return $this->hasOneof(1);
    }

    /**
     * The URI to a file containing the exported agent. This field is populated
     * if `agent_uri` is specified in
     * [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *
     * Generated from protobuf field <code>string agent_uri = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setAgentUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Uncompressed raw byte content for agent. This field is populated
     * if none of `agent_uri` and `git_destination` are specified in
     * [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *
     * Generated from protobuf field <code>bytes agent_content = 2;</code>
     * @return string
     */
    public function getAgentContent()
    {
        return $this->readOneof(2);
    }

    public function hasAgentContent()
    {
        return $this->hasOneof(2);
    }

    /**
     * Uncompressed raw byte content for agent. This field is populated
     * if none of `agent_uri` and `git_destination` are specified in
     * [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *
     * Generated from protobuf field <code>bytes agent_content = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setAgentContent($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Commit SHA of the git push. This field is populated if
     * `git_destination` is specified in
     * [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *
     * Generated from protobuf field <code>string commit_sha = 3;</code>
     * @return string
     */
    public function getCommitSha()
    {
        return $this->readOneof(3);
    }

    public function hasCommitSha()
    {
        return $this->hasOneof(3);
    }

    /**
     * Commit SHA of the git push. This field is populated if
     * `git_destination` is specified in
     * [ExportAgentRequest][google.cloud.dialogflow.cx.v3.ExportAgentRequest].
     *
     * Generated from protobuf field <code>string commit_sha = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setCommitSha($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getAgent()
    {
        return $this->whichOneof("agent");
    }

}
