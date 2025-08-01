<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/backupdr/v1/datasourcereference.proto

namespace Google\Cloud\BackupDR\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * DataSourceReference is a reference to a DataSource resource.
 *
 * Generated from protobuf message <code>google.cloud.backupdr.v1.DataSourceReference</code>
 */
class DataSourceReference extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. The resource name of the DataSourceReference.
     * Format:
     * projects/{project}/locations/{location}/dataSourceReferences/{data_source_reference}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Output only. The resource name of the DataSource.
     * Format:
     * projects/{project}/locations/{location}/backupVaults/{backupVault}/dataSources/{dataSource}
     *
     * Generated from protobuf field <code>string data_source = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $data_source = '';
    /**
     * Output only. The time when the DataSourceReference was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. The backup configuration state of the DataSource.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.BackupConfigState data_source_backup_config_state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $data_source_backup_config_state = 0;
    /**
     * Output only. Number of backups in the DataSource.
     *
     * Generated from protobuf field <code>int64 data_source_backup_count = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $data_source_backup_count = 0;
    /**
     * Output only. Information of backup configuration on the DataSource.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.DataSourceBackupConfigInfo data_source_backup_config_info = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $data_source_backup_config_info = null;
    /**
     * Output only. The GCP resource that the DataSource is associated with.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.DataSourceGcpResourceInfo data_source_gcp_resource_info = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $data_source_gcp_resource_info = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Identifier. The resource name of the DataSourceReference.
     *           Format:
     *           projects/{project}/locations/{location}/dataSourceReferences/{data_source_reference}
     *     @type string $data_source
     *           Output only. The resource name of the DataSource.
     *           Format:
     *           projects/{project}/locations/{location}/backupVaults/{backupVault}/dataSources/{dataSource}
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The time when the DataSourceReference was created.
     *     @type int $data_source_backup_config_state
     *           Output only. The backup configuration state of the DataSource.
     *     @type int|string $data_source_backup_count
     *           Output only. Number of backups in the DataSource.
     *     @type \Google\Cloud\BackupDR\V1\DataSourceBackupConfigInfo $data_source_backup_config_info
     *           Output only. Information of backup configuration on the DataSource.
     *     @type \Google\Cloud\BackupDR\V1\DataSourceGcpResourceInfo $data_source_gcp_resource_info
     *           Output only. The GCP resource that the DataSource is associated with.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Backupdr\V1\Datasourcereference::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifier. The resource name of the DataSourceReference.
     * Format:
     * projects/{project}/locations/{location}/dataSourceReferences/{data_source_reference}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. The resource name of the DataSourceReference.
     * Format:
     * projects/{project}/locations/{location}/dataSourceReferences/{data_source_reference}
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
     * Output only. The resource name of the DataSource.
     * Format:
     * projects/{project}/locations/{location}/backupVaults/{backupVault}/dataSources/{dataSource}
     *
     * Generated from protobuf field <code>string data_source = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getDataSource()
    {
        return $this->data_source;
    }

    /**
     * Output only. The resource name of the DataSource.
     * Format:
     * projects/{project}/locations/{location}/backupVaults/{backupVault}/dataSources/{dataSource}
     *
     * Generated from protobuf field <code>string data_source = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setDataSource($var)
    {
        GPBUtil::checkString($var, True);
        $this->data_source = $var;

        return $this;
    }

    /**
     * Output only. The time when the DataSourceReference was created.
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
     * Output only. The time when the DataSourceReference was created.
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
     * Output only. The backup configuration state of the DataSource.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.BackupConfigState data_source_backup_config_state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getDataSourceBackupConfigState()
    {
        return $this->data_source_backup_config_state;
    }

    /**
     * Output only. The backup configuration state of the DataSource.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.BackupConfigState data_source_backup_config_state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setDataSourceBackupConfigState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\BackupDR\V1\BackupConfigState::class);
        $this->data_source_backup_config_state = $var;

        return $this;
    }

    /**
     * Output only. Number of backups in the DataSource.
     *
     * Generated from protobuf field <code>int64 data_source_backup_count = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getDataSourceBackupCount()
    {
        return $this->data_source_backup_count;
    }

    /**
     * Output only. Number of backups in the DataSource.
     *
     * Generated from protobuf field <code>int64 data_source_backup_count = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setDataSourceBackupCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->data_source_backup_count = $var;

        return $this;
    }

    /**
     * Output only. Information of backup configuration on the DataSource.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.DataSourceBackupConfigInfo data_source_backup_config_info = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Cloud\BackupDR\V1\DataSourceBackupConfigInfo|null
     */
    public function getDataSourceBackupConfigInfo()
    {
        return $this->data_source_backup_config_info;
    }

    public function hasDataSourceBackupConfigInfo()
    {
        return isset($this->data_source_backup_config_info);
    }

    public function clearDataSourceBackupConfigInfo()
    {
        unset($this->data_source_backup_config_info);
    }

    /**
     * Output only. Information of backup configuration on the DataSource.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.DataSourceBackupConfigInfo data_source_backup_config_info = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Cloud\BackupDR\V1\DataSourceBackupConfigInfo $var
     * @return $this
     */
    public function setDataSourceBackupConfigInfo($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\BackupDR\V1\DataSourceBackupConfigInfo::class);
        $this->data_source_backup_config_info = $var;

        return $this;
    }

    /**
     * Output only. The GCP resource that the DataSource is associated with.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.DataSourceGcpResourceInfo data_source_gcp_resource_info = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Cloud\BackupDR\V1\DataSourceGcpResourceInfo|null
     */
    public function getDataSourceGcpResourceInfo()
    {
        return $this->data_source_gcp_resource_info;
    }

    public function hasDataSourceGcpResourceInfo()
    {
        return isset($this->data_source_gcp_resource_info);
    }

    public function clearDataSourceGcpResourceInfo()
    {
        unset($this->data_source_gcp_resource_info);
    }

    /**
     * Output only. The GCP resource that the DataSource is associated with.
     *
     * Generated from protobuf field <code>.google.cloud.backupdr.v1.DataSourceGcpResourceInfo data_source_gcp_resource_info = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Cloud\BackupDR\V1\DataSourceGcpResourceInfo $var
     * @return $this
     */
    public function setDataSourceGcpResourceInfo($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\BackupDR\V1\DataSourceGcpResourceInfo::class);
        $this->data_source_gcp_resource_info = $var;

        return $this;
    }

}

