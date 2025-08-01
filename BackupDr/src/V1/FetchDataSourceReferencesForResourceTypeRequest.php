<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/backupdr/v1/datasourcereference.proto

namespace Google\Cloud\BackupDR\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for the FetchDataSourceReferencesForResourceType method.
 *
 * Generated from protobuf message <code>google.cloud.backupdr.v1.FetchDataSourceReferencesForResourceTypeRequest</code>
 */
class FetchDataSourceReferencesForResourceTypeRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The parent resource name.
     * Format: projects/{project}/locations/{location}
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. The type of the GCP resource.
     * Ex: sql.googleapis.com/Instance
     *
     * Generated from protobuf field <code>string resource_type = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $resource_type = '';
    /**
     * Optional. The maximum number of DataSourceReferences to return. The service
     * may return fewer than this value. If unspecified, at most 50
     * DataSourceReferences will be returned. The maximum value is 100; values
     * above 100 will be coerced to 100.
     *
     * Generated from protobuf field <code>int32 page_size = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $page_size = 0;
    /**
     * Optional. A page token, received from a previous call of
     * `FetchDataSourceReferencesForResourceType`.
     * Provide this to retrieve the subsequent page.
     * When paginating, all other parameters provided to
     * `FetchDataSourceReferencesForResourceType` must match
     * the call that provided the page token.
     *
     * Generated from protobuf field <code>string page_token = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $page_token = '';
    /**
     * Optional. A filter expression that filters the results fetched in the
     * response. The expression must specify the field name, a comparison
     * operator, and the value that you want to use for filtering. Supported
     * fields:
     * * data_source
     * * data_source_gcp_resource_info.gcp_resourcename
     * * data_source_backup_config_state
     * * data_source_backup_count
     * * data_source_backup_config_info.last_backup_state
     * * data_source_gcp_resource_info.gcp_resourcename
     * * data_source_gcp_resource_info.type
     * * data_source_gcp_resource_info.location
     * * data_source_gcp_resource_info.cloud_sql_instance_properties.instance_create_time
     *
     * Generated from protobuf field <code>string filter = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $filter = '';
    /**
     * Optional. A comma-separated list of fields to order by, sorted in ascending
     * order. Use "desc" after a field name for descending.
     * Supported fields:
     * * name
     *
     * Generated from protobuf field <code>string order_by = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $order_by = '';

    /**
     * @param string $parent       Required. The parent resource name.
     *                             Format: projects/{project}/locations/{location}
     *                             Please see {@see BackupDRClient::locationName()} for help formatting this field.
     * @param string $resourceType Required. The type of the GCP resource.
     *                             Ex: sql.googleapis.com/Instance
     *
     * @return \Google\Cloud\BackupDR\V1\FetchDataSourceReferencesForResourceTypeRequest
     *
     * @experimental
     */
    public static function build(string $parent, string $resourceType): self
    {
        return (new self())
            ->setParent($parent)
            ->setResourceType($resourceType);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The parent resource name.
     *           Format: projects/{project}/locations/{location}
     *     @type string $resource_type
     *           Required. The type of the GCP resource.
     *           Ex: sql.googleapis.com/Instance
     *     @type int $page_size
     *           Optional. The maximum number of DataSourceReferences to return. The service
     *           may return fewer than this value. If unspecified, at most 50
     *           DataSourceReferences will be returned. The maximum value is 100; values
     *           above 100 will be coerced to 100.
     *     @type string $page_token
     *           Optional. A page token, received from a previous call of
     *           `FetchDataSourceReferencesForResourceType`.
     *           Provide this to retrieve the subsequent page.
     *           When paginating, all other parameters provided to
     *           `FetchDataSourceReferencesForResourceType` must match
     *           the call that provided the page token.
     *     @type string $filter
     *           Optional. A filter expression that filters the results fetched in the
     *           response. The expression must specify the field name, a comparison
     *           operator, and the value that you want to use for filtering. Supported
     *           fields:
     *           * data_source
     *           * data_source_gcp_resource_info.gcp_resourcename
     *           * data_source_backup_config_state
     *           * data_source_backup_count
     *           * data_source_backup_config_info.last_backup_state
     *           * data_source_gcp_resource_info.gcp_resourcename
     *           * data_source_gcp_resource_info.type
     *           * data_source_gcp_resource_info.location
     *           * data_source_gcp_resource_info.cloud_sql_instance_properties.instance_create_time
     *     @type string $order_by
     *           Optional. A comma-separated list of fields to order by, sorted in ascending
     *           order. Use "desc" after a field name for descending.
     *           Supported fields:
     *           * name
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Backupdr\V1\Datasourcereference::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The parent resource name.
     * Format: projects/{project}/locations/{location}
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The parent resource name.
     * Format: projects/{project}/locations/{location}
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Required. The type of the GCP resource.
     * Ex: sql.googleapis.com/Instance
     *
     * Generated from protobuf field <code>string resource_type = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getResourceType()
    {
        return $this->resource_type;
    }

    /**
     * Required. The type of the GCP resource.
     * Ex: sql.googleapis.com/Instance
     *
     * Generated from protobuf field <code>string resource_type = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setResourceType($var)
    {
        GPBUtil::checkString($var, True);
        $this->resource_type = $var;

        return $this;
    }

    /**
     * Optional. The maximum number of DataSourceReferences to return. The service
     * may return fewer than this value. If unspecified, at most 50
     * DataSourceReferences will be returned. The maximum value is 100; values
     * above 100 will be coerced to 100.
     *
     * Generated from protobuf field <code>int32 page_size = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Optional. The maximum number of DataSourceReferences to return. The service
     * may return fewer than this value. If unspecified, at most 50
     * DataSourceReferences will be returned. The maximum value is 100; values
     * above 100 will be coerced to 100.
     *
     * Generated from protobuf field <code>int32 page_size = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * Optional. A page token, received from a previous call of
     * `FetchDataSourceReferencesForResourceType`.
     * Provide this to retrieve the subsequent page.
     * When paginating, all other parameters provided to
     * `FetchDataSourceReferencesForResourceType` must match
     * the call that provided the page token.
     *
     * Generated from protobuf field <code>string page_token = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * Optional. A page token, received from a previous call of
     * `FetchDataSourceReferencesForResourceType`.
     * Provide this to retrieve the subsequent page.
     * When paginating, all other parameters provided to
     * `FetchDataSourceReferencesForResourceType` must match
     * the call that provided the page token.
     *
     * Generated from protobuf field <code>string page_token = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

    /**
     * Optional. A filter expression that filters the results fetched in the
     * response. The expression must specify the field name, a comparison
     * operator, and the value that you want to use for filtering. Supported
     * fields:
     * * data_source
     * * data_source_gcp_resource_info.gcp_resourcename
     * * data_source_backup_config_state
     * * data_source_backup_count
     * * data_source_backup_config_info.last_backup_state
     * * data_source_gcp_resource_info.gcp_resourcename
     * * data_source_gcp_resource_info.type
     * * data_source_gcp_resource_info.location
     * * data_source_gcp_resource_info.cloud_sql_instance_properties.instance_create_time
     *
     * Generated from protobuf field <code>string filter = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Optional. A filter expression that filters the results fetched in the
     * response. The expression must specify the field name, a comparison
     * operator, and the value that you want to use for filtering. Supported
     * fields:
     * * data_source
     * * data_source_gcp_resource_info.gcp_resourcename
     * * data_source_backup_config_state
     * * data_source_backup_count
     * * data_source_backup_config_info.last_backup_state
     * * data_source_gcp_resource_info.gcp_resourcename
     * * data_source_gcp_resource_info.type
     * * data_source_gcp_resource_info.location
     * * data_source_gcp_resource_info.cloud_sql_instance_properties.instance_create_time
     *
     * Generated from protobuf field <code>string filter = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

    /**
     * Optional. A comma-separated list of fields to order by, sorted in ascending
     * order. Use "desc" after a field name for descending.
     * Supported fields:
     * * name
     *
     * Generated from protobuf field <code>string order_by = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getOrderBy()
    {
        return $this->order_by;
    }

    /**
     * Optional. A comma-separated list of fields to order by, sorted in ascending
     * order. Use "desc" after a field name for descending.
     * Supported fields:
     * * name
     *
     * Generated from protobuf field <code>string order_by = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setOrderBy($var)
    {
        GPBUtil::checkString($var, True);
        $this->order_by = $var;

        return $this;
    }

}

