<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/gkehub/v1/configmanagement/configmanagement.proto

namespace Google\Cloud\GkeHub\ConfigManagement\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Git repo configuration for a single cluster.
 *
 * Generated from protobuf message <code>google.cloud.gkehub.configmanagement.v1.GitConfig</code>
 */
class GitConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * The URL of the Git repository to use as the source of truth.
     *
     * Generated from protobuf field <code>string sync_repo = 1;</code>
     */
    protected $sync_repo = '';
    /**
     * The branch of the repository to sync from. Default: master.
     *
     * Generated from protobuf field <code>string sync_branch = 2;</code>
     */
    protected $sync_branch = '';
    /**
     * The path within the Git repository that represents the top level of the
     * repo to sync. Default: the root directory of the repository.
     *
     * Generated from protobuf field <code>string policy_dir = 3;</code>
     */
    protected $policy_dir = '';
    /**
     * Period in seconds between consecutive syncs. Default: 15.
     *
     * Generated from protobuf field <code>int64 sync_wait_secs = 4;</code>
     */
    protected $sync_wait_secs = 0;
    /**
     * Git revision (tag or hash) to check out. Default HEAD.
     *
     * Generated from protobuf field <code>string sync_rev = 5;</code>
     */
    protected $sync_rev = '';
    /**
     * Type of secret configured for access to the Git repo. Must be one of ssh,
     * cookiefile, gcenode, token, gcpserviceaccount or none. The
     * validation of this is case-sensitive. Required.
     *
     * Generated from protobuf field <code>string secret_type = 6;</code>
     */
    protected $secret_type = '';
    /**
     * URL for the HTTPS proxy to be used when communicating with the Git repo.
     *
     * Generated from protobuf field <code>string https_proxy = 7;</code>
     */
    protected $https_proxy = '';
    /**
     * The Google Cloud Service Account Email used for auth when secret_type is
     * gcpServiceAccount.
     *
     * Generated from protobuf field <code>string gcp_service_account_email = 8;</code>
     */
    protected $gcp_service_account_email = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $sync_repo
     *           The URL of the Git repository to use as the source of truth.
     *     @type string $sync_branch
     *           The branch of the repository to sync from. Default: master.
     *     @type string $policy_dir
     *           The path within the Git repository that represents the top level of the
     *           repo to sync. Default: the root directory of the repository.
     *     @type int|string $sync_wait_secs
     *           Period in seconds between consecutive syncs. Default: 15.
     *     @type string $sync_rev
     *           Git revision (tag or hash) to check out. Default HEAD.
     *     @type string $secret_type
     *           Type of secret configured for access to the Git repo. Must be one of ssh,
     *           cookiefile, gcenode, token, gcpserviceaccount or none. The
     *           validation of this is case-sensitive. Required.
     *     @type string $https_proxy
     *           URL for the HTTPS proxy to be used when communicating with the Git repo.
     *     @type string $gcp_service_account_email
     *           The Google Cloud Service Account Email used for auth when secret_type is
     *           gcpServiceAccount.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Gkehub\V1\Configmanagement\Configmanagement::initOnce();
        parent::__construct($data);
    }

    /**
     * The URL of the Git repository to use as the source of truth.
     *
     * Generated from protobuf field <code>string sync_repo = 1;</code>
     * @return string
     */
    public function getSyncRepo()
    {
        return $this->sync_repo;
    }

    /**
     * The URL of the Git repository to use as the source of truth.
     *
     * Generated from protobuf field <code>string sync_repo = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSyncRepo($var)
    {
        GPBUtil::checkString($var, True);
        $this->sync_repo = $var;

        return $this;
    }

    /**
     * The branch of the repository to sync from. Default: master.
     *
     * Generated from protobuf field <code>string sync_branch = 2;</code>
     * @return string
     */
    public function getSyncBranch()
    {
        return $this->sync_branch;
    }

    /**
     * The branch of the repository to sync from. Default: master.
     *
     * Generated from protobuf field <code>string sync_branch = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSyncBranch($var)
    {
        GPBUtil::checkString($var, True);
        $this->sync_branch = $var;

        return $this;
    }

    /**
     * The path within the Git repository that represents the top level of the
     * repo to sync. Default: the root directory of the repository.
     *
     * Generated from protobuf field <code>string policy_dir = 3;</code>
     * @return string
     */
    public function getPolicyDir()
    {
        return $this->policy_dir;
    }

    /**
     * The path within the Git repository that represents the top level of the
     * repo to sync. Default: the root directory of the repository.
     *
     * Generated from protobuf field <code>string policy_dir = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPolicyDir($var)
    {
        GPBUtil::checkString($var, True);
        $this->policy_dir = $var;

        return $this;
    }

    /**
     * Period in seconds between consecutive syncs. Default: 15.
     *
     * Generated from protobuf field <code>int64 sync_wait_secs = 4;</code>
     * @return int|string
     */
    public function getSyncWaitSecs()
    {
        return $this->sync_wait_secs;
    }

    /**
     * Period in seconds between consecutive syncs. Default: 15.
     *
     * Generated from protobuf field <code>int64 sync_wait_secs = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setSyncWaitSecs($var)
    {
        GPBUtil::checkInt64($var);
        $this->sync_wait_secs = $var;

        return $this;
    }

    /**
     * Git revision (tag or hash) to check out. Default HEAD.
     *
     * Generated from protobuf field <code>string sync_rev = 5;</code>
     * @return string
     */
    public function getSyncRev()
    {
        return $this->sync_rev;
    }

    /**
     * Git revision (tag or hash) to check out. Default HEAD.
     *
     * Generated from protobuf field <code>string sync_rev = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setSyncRev($var)
    {
        GPBUtil::checkString($var, True);
        $this->sync_rev = $var;

        return $this;
    }

    /**
     * Type of secret configured for access to the Git repo. Must be one of ssh,
     * cookiefile, gcenode, token, gcpserviceaccount or none. The
     * validation of this is case-sensitive. Required.
     *
     * Generated from protobuf field <code>string secret_type = 6;</code>
     * @return string
     */
    public function getSecretType()
    {
        return $this->secret_type;
    }

    /**
     * Type of secret configured for access to the Git repo. Must be one of ssh,
     * cookiefile, gcenode, token, gcpserviceaccount or none. The
     * validation of this is case-sensitive. Required.
     *
     * Generated from protobuf field <code>string secret_type = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setSecretType($var)
    {
        GPBUtil::checkString($var, True);
        $this->secret_type = $var;

        return $this;
    }

    /**
     * URL for the HTTPS proxy to be used when communicating with the Git repo.
     *
     * Generated from protobuf field <code>string https_proxy = 7;</code>
     * @return string
     */
    public function getHttpsProxy()
    {
        return $this->https_proxy;
    }

    /**
     * URL for the HTTPS proxy to be used when communicating with the Git repo.
     *
     * Generated from protobuf field <code>string https_proxy = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setHttpsProxy($var)
    {
        GPBUtil::checkString($var, True);
        $this->https_proxy = $var;

        return $this;
    }

    /**
     * The Google Cloud Service Account Email used for auth when secret_type is
     * gcpServiceAccount.
     *
     * Generated from protobuf field <code>string gcp_service_account_email = 8;</code>
     * @return string
     */
    public function getGcpServiceAccountEmail()
    {
        return $this->gcp_service_account_email;
    }

    /**
     * The Google Cloud Service Account Email used for auth when secret_type is
     * gcpServiceAccount.
     *
     * Generated from protobuf field <code>string gcp_service_account_email = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setGcpServiceAccountEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->gcp_service_account_email = $var;

        return $this;
    }

}

