<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/admin/v2/bigtable_instance_admin.proto

namespace Google\Cloud\Bigtable\Admin\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for BigtableInstanceAdmin.ListAppProfiles.
 *
 * Generated from protobuf message <code>google.bigtable.admin.v2.ListAppProfilesResponse</code>
 */
class ListAppProfilesResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The list of requested app profiles.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.admin.v2.AppProfile app_profiles = 1;</code>
     */
    private $app_profiles;
    /**
     * Set if not all app profiles could be returned in a single response.
     * Pass this value to `page_token` in another request to get the next
     * page of results.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';
    /**
     * Locations from which AppProfile information could not be retrieved,
     * due to an outage or some other transient condition.
     * AppProfiles from these locations may be missing from `app_profiles`.
     * Values are of the form `projects/<project>/locations/<zone_id>`
     *
     * Generated from protobuf field <code>repeated string failed_locations = 3;</code>
     */
    private $failed_locations;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Bigtable\Admin\V2\AppProfile>|\Google\Protobuf\Internal\RepeatedField $app_profiles
     *           The list of requested app profiles.
     *     @type string $next_page_token
     *           Set if not all app profiles could be returned in a single response.
     *           Pass this value to `page_token` in another request to get the next
     *           page of results.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $failed_locations
     *           Locations from which AppProfile information could not be retrieved,
     *           due to an outage or some other transient condition.
     *           AppProfiles from these locations may be missing from `app_profiles`.
     *           Values are of the form `projects/<project>/locations/<zone_id>`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Bigtable\Admin\V2\BigtableInstanceAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * The list of requested app profiles.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.admin.v2.AppProfile app_profiles = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAppProfiles()
    {
        return $this->app_profiles;
    }

    /**
     * The list of requested app profiles.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.admin.v2.AppProfile app_profiles = 1;</code>
     * @param array<\Google\Cloud\Bigtable\Admin\V2\AppProfile>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAppProfiles($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Bigtable\Admin\V2\AppProfile::class);
        $this->app_profiles = $arr;

        return $this;
    }

    /**
     * Set if not all app profiles could be returned in a single response.
     * Pass this value to `page_token` in another request to get the next
     * page of results.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * Set if not all app profiles could be returned in a single response.
     * Pass this value to `page_token` in another request to get the next
     * page of results.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

    /**
     * Locations from which AppProfile information could not be retrieved,
     * due to an outage or some other transient condition.
     * AppProfiles from these locations may be missing from `app_profiles`.
     * Values are of the form `projects/<project>/locations/<zone_id>`
     *
     * Generated from protobuf field <code>repeated string failed_locations = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFailedLocations()
    {
        return $this->failed_locations;
    }

    /**
     * Locations from which AppProfile information could not be retrieved,
     * due to an outage or some other transient condition.
     * AppProfiles from these locations may be missing from `app_profiles`.
     * Values are of the form `projects/<project>/locations/<zone_id>`
     *
     * Generated from protobuf field <code>repeated string failed_locations = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFailedLocations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->failed_locations = $arr;

        return $this;
    }

}
