<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/session.proto

namespace Google\Cloud\DiscoveryEngine\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * External session proto definition.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.Session</code>
 */
class Session extends \Google\Protobuf\Internal\Message
{
    /**
     * Immutable. Fully qualified name
     * `projects/{project}/locations/global/collections/{collection}/engines/{engine}/sessions/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $name = '';
    /**
     * Optional. The display name of the session.
     * This field is used to identify the session in the UI.
     * By default, the display name is the first turn query text in the session.
     *
     * Generated from protobuf field <code>string display_name = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $display_name = '';
    /**
     * The state of the session.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Session.State state = 2;</code>
     */
    protected $state = 0;
    /**
     * A unique identifier for tracking users.
     *
     * Generated from protobuf field <code>string user_pseudo_id = 3;</code>
     */
    protected $user_pseudo_id = '';
    /**
     * Turns.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Session.Turn turns = 4;</code>
     */
    private $turns;
    /**
     * Output only. The time the session started.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $start_time = null;
    /**
     * Output only. The time the session finished.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp end_time = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $end_time = null;
    /**
     * Optional. Whether the session is pinned, pinned session will be displayed
     * on the top of the session list.
     *
     * Generated from protobuf field <code>bool is_pinned = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $is_pinned = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Immutable. Fully qualified name
     *           `projects/{project}/locations/global/collections/{collection}/engines/{engine}/sessions/&#42;`
     *     @type string $display_name
     *           Optional. The display name of the session.
     *           This field is used to identify the session in the UI.
     *           By default, the display name is the first turn query text in the session.
     *     @type int $state
     *           The state of the session.
     *     @type string $user_pseudo_id
     *           A unique identifier for tracking users.
     *     @type array<\Google\Cloud\DiscoveryEngine\V1\Session\Turn>|\Google\Protobuf\Internal\RepeatedField $turns
     *           Turns.
     *     @type \Google\Protobuf\Timestamp $start_time
     *           Output only. The time the session started.
     *     @type \Google\Protobuf\Timestamp $end_time
     *           Output only. The time the session finished.
     *     @type bool $is_pinned
     *           Optional. Whether the session is pinned, pinned session will be displayed
     *           on the top of the session list.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\Session::initOnce();
        parent::__construct($data);
    }

    /**
     * Immutable. Fully qualified name
     * `projects/{project}/locations/global/collections/{collection}/engines/{engine}/sessions/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Immutable. Fully qualified name
     * `projects/{project}/locations/global/collections/{collection}/engines/{engine}/sessions/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
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
     * Optional. The display name of the session.
     * This field is used to identify the session in the UI.
     * By default, the display name is the first turn query text in the session.
     *
     * Generated from protobuf field <code>string display_name = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Optional. The display name of the session.
     * This field is used to identify the session in the UI.
     * By default, the display name is the first turn query text in the session.
     *
     * Generated from protobuf field <code>string display_name = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;

        return $this;
    }

    /**
     * The state of the session.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Session.State state = 2;</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * The state of the session.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Session.State state = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\DiscoveryEngine\V1\Session\State::class);
        $this->state = $var;

        return $this;
    }

    /**
     * A unique identifier for tracking users.
     *
     * Generated from protobuf field <code>string user_pseudo_id = 3;</code>
     * @return string
     */
    public function getUserPseudoId()
    {
        return $this->user_pseudo_id;
    }

    /**
     * A unique identifier for tracking users.
     *
     * Generated from protobuf field <code>string user_pseudo_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setUserPseudoId($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_pseudo_id = $var;

        return $this;
    }

    /**
     * Turns.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Session.Turn turns = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTurns()
    {
        return $this->turns;
    }

    /**
     * Turns.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Session.Turn turns = 4;</code>
     * @param array<\Google\Cloud\DiscoveryEngine\V1\Session\Turn>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTurns($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\DiscoveryEngine\V1\Session\Turn::class);
        $this->turns = $arr;

        return $this;
    }

    /**
     * Output only. The time the session started.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    public function hasStartTime()
    {
        return isset($this->start_time);
    }

    public function clearStartTime()
    {
        unset($this->start_time);
    }

    /**
     * Output only. The time the session started.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setStartTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->start_time = $var;

        return $this;
    }

    /**
     * Output only. The time the session finished.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp end_time = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    public function hasEndTime()
    {
        return isset($this->end_time);
    }

    public function clearEndTime()
    {
        unset($this->end_time);
    }

    /**
     * Output only. The time the session finished.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp end_time = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setEndTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->end_time = $var;

        return $this;
    }

    /**
     * Optional. Whether the session is pinned, pinned session will be displayed
     * on the top of the session list.
     *
     * Generated from protobuf field <code>bool is_pinned = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getIsPinned()
    {
        return $this->is_pinned;
    }

    /**
     * Optional. Whether the session is pinned, pinned session will be displayed
     * on the top of the session list.
     *
     * Generated from protobuf field <code>bool is_pinned = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setIsPinned($var)
    {
        GPBUtil::checkBool($var);
        $this->is_pinned = $var;

        return $this;
    }

}

