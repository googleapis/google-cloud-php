<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/datasources/v1beta/fileinputs.proto

namespace Google\Shopping\Merchant\DataSources\V1beta\FileInput;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Fetch details to deliver the data source.
 *
 * Generated from protobuf message <code>google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings</code>
 */
class FetchSettings extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Enables or pauses the fetch schedule.
     *
     * Generated from protobuf field <code>bool enabled = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $enabled = false;
    /**
     * Optional. The day of the month when the data source file should be
     * fetched (1-31). This field can only be set for monthly frequency.
     *
     * Generated from protobuf field <code>int32 day_of_month = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $day_of_month = 0;
    /**
     * Optional. The hour of the day when the data source file should be
     * fetched. Minutes and seconds are not supported and will be ignored.
     *
     * Generated from protobuf field <code>.google.type.TimeOfDay time_of_day = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $time_of_day = null;
    /**
     * Optional. The day of the week when the data source file should be
     * fetched. This field can only be set for weekly frequency.
     *
     * Generated from protobuf field <code>.google.type.DayOfWeek day_of_week = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $day_of_week = 0;
    /**
     * Optional. [Time zone](https://cldr.unicode.org) used for schedule. UTC by
     * default. For example, "America/Los_Angeles".
     *
     * Generated from protobuf field <code>string time_zone = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $time_zone = '';
    /**
     * Required. The frequency describing fetch schedule.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.Frequency frequency = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $frequency = 0;
    /**
     * Optional. The URL where the data source file can be fetched. Google
     * Merchant Center supports automatic scheduled uploads using the HTTP,
     * HTTPS or SFTP protocols, so the value will need to be a valid link using
     * one of those three protocols. Immutable for Google Sheets files.
     *
     * Generated from protobuf field <code>string fetch_uri = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $fetch_uri = '';
    /**
     * Optional. An optional user name for
     * [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     * Used for [submitting data sources through
     * SFTP](https://support.google.com/merchants/answer/13813117).
     *
     * Generated from protobuf field <code>string username = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $username = '';
    /**
     * Optional. An optional password for
     * [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     * Used for [submitting data sources through
     * SFTP](https://support.google.com/merchants/answer/13813117).
     *
     * Generated from protobuf field <code>string password = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $password = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $enabled
     *           Optional. Enables or pauses the fetch schedule.
     *     @type int $day_of_month
     *           Optional. The day of the month when the data source file should be
     *           fetched (1-31). This field can only be set for monthly frequency.
     *     @type \Google\Type\TimeOfDay $time_of_day
     *           Optional. The hour of the day when the data source file should be
     *           fetched. Minutes and seconds are not supported and will be ignored.
     *     @type int $day_of_week
     *           Optional. The day of the week when the data source file should be
     *           fetched. This field can only be set for weekly frequency.
     *     @type string $time_zone
     *           Optional. [Time zone](https://cldr.unicode.org) used for schedule. UTC by
     *           default. For example, "America/Los_Angeles".
     *     @type int $frequency
     *           Required. The frequency describing fetch schedule.
     *     @type string $fetch_uri
     *           Optional. The URL where the data source file can be fetched. Google
     *           Merchant Center supports automatic scheduled uploads using the HTTP,
     *           HTTPS or SFTP protocols, so the value will need to be a valid link using
     *           one of those three protocols. Immutable for Google Sheets files.
     *     @type string $username
     *           Optional. An optional user name for
     *           [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     *           Used for [submitting data sources through
     *           SFTP](https://support.google.com/merchants/answer/13813117).
     *     @type string $password
     *           Optional. An optional password for
     *           [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     *           Used for [submitting data sources through
     *           SFTP](https://support.google.com/merchants/answer/13813117).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Shopping\Merchant\Datasources\V1Beta\Fileinputs::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Enables or pauses the fetch schedule.
     *
     * Generated from protobuf field <code>bool enabled = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Optional. Enables or pauses the fetch schedule.
     *
     * Generated from protobuf field <code>bool enabled = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setEnabled($var)
    {
        GPBUtil::checkBool($var);
        $this->enabled = $var;

        return $this;
    }

    /**
     * Optional. The day of the month when the data source file should be
     * fetched (1-31). This field can only be set for monthly frequency.
     *
     * Generated from protobuf field <code>int32 day_of_month = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getDayOfMonth()
    {
        return $this->day_of_month;
    }

    /**
     * Optional. The day of the month when the data source file should be
     * fetched (1-31). This field can only be set for monthly frequency.
     *
     * Generated from protobuf field <code>int32 day_of_month = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setDayOfMonth($var)
    {
        GPBUtil::checkInt32($var);
        $this->day_of_month = $var;

        return $this;
    }

    /**
     * Optional. The hour of the day when the data source file should be
     * fetched. Minutes and seconds are not supported and will be ignored.
     *
     * Generated from protobuf field <code>.google.type.TimeOfDay time_of_day = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Type\TimeOfDay|null
     */
    public function getTimeOfDay()
    {
        return $this->time_of_day;
    }

    public function hasTimeOfDay()
    {
        return isset($this->time_of_day);
    }

    public function clearTimeOfDay()
    {
        unset($this->time_of_day);
    }

    /**
     * Optional. The hour of the day when the data source file should be
     * fetched. Minutes and seconds are not supported and will be ignored.
     *
     * Generated from protobuf field <code>.google.type.TimeOfDay time_of_day = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Type\TimeOfDay $var
     * @return $this
     */
    public function setTimeOfDay($var)
    {
        GPBUtil::checkMessage($var, \Google\Type\TimeOfDay::class);
        $this->time_of_day = $var;

        return $this;
    }

    /**
     * Optional. The day of the week when the data source file should be
     * fetched. This field can only be set for weekly frequency.
     *
     * Generated from protobuf field <code>.google.type.DayOfWeek day_of_week = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getDayOfWeek()
    {
        return $this->day_of_week;
    }

    /**
     * Optional. The day of the week when the data source file should be
     * fetched. This field can only be set for weekly frequency.
     *
     * Generated from protobuf field <code>.google.type.DayOfWeek day_of_week = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setDayOfWeek($var)
    {
        GPBUtil::checkEnum($var, \Google\Type\DayOfWeek::class);
        $this->day_of_week = $var;

        return $this;
    }

    /**
     * Optional. [Time zone](https://cldr.unicode.org) used for schedule. UTC by
     * default. For example, "America/Los_Angeles".
     *
     * Generated from protobuf field <code>string time_zone = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getTimeZone()
    {
        return $this->time_zone;
    }

    /**
     * Optional. [Time zone](https://cldr.unicode.org) used for schedule. UTC by
     * default. For example, "America/Los_Angeles".
     *
     * Generated from protobuf field <code>string time_zone = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setTimeZone($var)
    {
        GPBUtil::checkString($var, True);
        $this->time_zone = $var;

        return $this;
    }

    /**
     * Required. The frequency describing fetch schedule.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.Frequency frequency = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Required. The frequency describing fetch schedule.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.Frequency frequency = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setFrequency($var)
    {
        GPBUtil::checkEnum($var, \Google\Shopping\Merchant\DataSources\V1beta\FileInput\FetchSettings\Frequency::class);
        $this->frequency = $var;

        return $this;
    }

    /**
     * Optional. The URL where the data source file can be fetched. Google
     * Merchant Center supports automatic scheduled uploads using the HTTP,
     * HTTPS or SFTP protocols, so the value will need to be a valid link using
     * one of those three protocols. Immutable for Google Sheets files.
     *
     * Generated from protobuf field <code>string fetch_uri = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFetchUri()
    {
        return $this->fetch_uri;
    }

    /**
     * Optional. The URL where the data source file can be fetched. Google
     * Merchant Center supports automatic scheduled uploads using the HTTP,
     * HTTPS or SFTP protocols, so the value will need to be a valid link using
     * one of those three protocols. Immutable for Google Sheets files.
     *
     * Generated from protobuf field <code>string fetch_uri = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setFetchUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->fetch_uri = $var;

        return $this;
    }

    /**
     * Optional. An optional user name for
     * [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     * Used for [submitting data sources through
     * SFTP](https://support.google.com/merchants/answer/13813117).
     *
     * Generated from protobuf field <code>string username = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Optional. An optional user name for
     * [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     * Used for [submitting data sources through
     * SFTP](https://support.google.com/merchants/answer/13813117).
     *
     * Generated from protobuf field <code>string username = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setUsername($var)
    {
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

    /**
     * Optional. An optional password for
     * [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     * Used for [submitting data sources through
     * SFTP](https://support.google.com/merchants/answer/13813117).
     *
     * Generated from protobuf field <code>string password = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Optional. An optional password for
     * [fetch_uri][google.shopping.merchant.datasources.v1beta.FileInput.FetchSettings.fetch_uri].
     * Used for [submitting data sources through
     * SFTP](https://support.google.com/merchants/answer/13813117).
     *
     * Generated from protobuf field <code>string password = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setPassword($var)
    {
        GPBUtil::checkString($var, True);
        $this->password = $var;

        return $this;
    }

}


