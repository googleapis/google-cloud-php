<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/io.proto

namespace Google\Cloud\AIPlatform\V1\JiraSource;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * JiraQueries contains the Jira queries and corresponding authentication.
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.JiraSource.JiraQueries</code>
 */
class JiraQueries extends \Google\Protobuf\Internal\Message
{
    /**
     * A list of Jira projects to import in their entirety.
     *
     * Generated from protobuf field <code>repeated string projects = 3;</code>
     */
    private $projects;
    /**
     * A list of custom Jira queries to import. For information about JQL (Jira
     * Query Language), see
     * https://support.atlassian.com/jira-service-management-cloud/docs/use-advanced-search-with-jira-query-language-jql/
     *
     * Generated from protobuf field <code>repeated string custom_queries = 4;</code>
     */
    private $custom_queries;
    /**
     * Required. The Jira email address.
     *
     * Generated from protobuf field <code>string email = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $email = '';
    /**
     * Required. The Jira server URI.
     *
     * Generated from protobuf field <code>string server_uri = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $server_uri = '';
    /**
     * Required. The SecretManager secret version resource name (e.g.
     * projects/{project}/secrets/{secret}/versions/{version}) storing the
     * Jira API key. See [Manage API tokens for your Atlassian
     * account](https://support.atlassian.com/atlassian-account/docs/manage-api-tokens-for-your-atlassian-account/).
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.ApiAuth.ApiKeyConfig api_key_config = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $api_key_config = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $projects
     *           A list of Jira projects to import in their entirety.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $custom_queries
     *           A list of custom Jira queries to import. For information about JQL (Jira
     *           Query Language), see
     *           https://support.atlassian.com/jira-service-management-cloud/docs/use-advanced-search-with-jira-query-language-jql/
     *     @type string $email
     *           Required. The Jira email address.
     *     @type string $server_uri
     *           Required. The Jira server URI.
     *     @type \Google\Cloud\AIPlatform\V1\ApiAuth\ApiKeyConfig $api_key_config
     *           Required. The SecretManager secret version resource name (e.g.
     *           projects/{project}/secrets/{secret}/versions/{version}) storing the
     *           Jira API key. See [Manage API tokens for your Atlassian
     *           account](https://support.atlassian.com/atlassian-account/docs/manage-api-tokens-for-your-atlassian-account/).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\Io::initOnce();
        parent::__construct($data);
    }

    /**
     * A list of Jira projects to import in their entirety.
     *
     * Generated from protobuf field <code>repeated string projects = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * A list of Jira projects to import in their entirety.
     *
     * Generated from protobuf field <code>repeated string projects = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setProjects($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->projects = $arr;

        return $this;
    }

    /**
     * A list of custom Jira queries to import. For information about JQL (Jira
     * Query Language), see
     * https://support.atlassian.com/jira-service-management-cloud/docs/use-advanced-search-with-jira-query-language-jql/
     *
     * Generated from protobuf field <code>repeated string custom_queries = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getCustomQueries()
    {
        return $this->custom_queries;
    }

    /**
     * A list of custom Jira queries to import. For information about JQL (Jira
     * Query Language), see
     * https://support.atlassian.com/jira-service-management-cloud/docs/use-advanced-search-with-jira-query-language-jql/
     *
     * Generated from protobuf field <code>repeated string custom_queries = 4;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setCustomQueries($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->custom_queries = $arr;

        return $this;
    }

    /**
     * Required. The Jira email address.
     *
     * Generated from protobuf field <code>string email = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Required. The Jira email address.
     *
     * Generated from protobuf field <code>string email = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->email = $var;

        return $this;
    }

    /**
     * Required. The Jira server URI.
     *
     * Generated from protobuf field <code>string server_uri = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getServerUri()
    {
        return $this->server_uri;
    }

    /**
     * Required. The Jira server URI.
     *
     * Generated from protobuf field <code>string server_uri = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setServerUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->server_uri = $var;

        return $this;
    }

    /**
     * Required. The SecretManager secret version resource name (e.g.
     * projects/{project}/secrets/{secret}/versions/{version}) storing the
     * Jira API key. See [Manage API tokens for your Atlassian
     * account](https://support.atlassian.com/atlassian-account/docs/manage-api-tokens-for-your-atlassian-account/).
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.ApiAuth.ApiKeyConfig api_key_config = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\AIPlatform\V1\ApiAuth\ApiKeyConfig|null
     */
    public function getApiKeyConfig()
    {
        return $this->api_key_config;
    }

    public function hasApiKeyConfig()
    {
        return isset($this->api_key_config);
    }

    public function clearApiKeyConfig()
    {
        unset($this->api_key_config);
    }

    /**
     * Required. The SecretManager secret version resource name (e.g.
     * projects/{project}/secrets/{secret}/versions/{version}) storing the
     * Jira API key. See [Manage API tokens for your Atlassian
     * account](https://support.atlassian.com/atlassian-account/docs/manage-api-tokens-for-your-atlassian-account/).
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.ApiAuth.ApiKeyConfig api_key_config = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\AIPlatform\V1\ApiAuth\ApiKeyConfig $var
     * @return $this
     */
    public function setApiKeyConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\ApiAuth\ApiKeyConfig::class);
        $this->api_key_config = $var;

        return $this;
    }

}


