<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/gkebackup/v1/backup_plan_binding.proto

namespace Google\Cloud\GkeBackup\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A BackupPlanBinding binds a BackupPlan with a BackupChannel.
 * This resource is created automatically when a BackupPlan is created using a
 * BackupChannel. This also serves as a holder for cross-project fields
 * that need to be displayed in the current project.
 *
 * Generated from protobuf message <code>google.cloud.gkebackup.v1.BackupPlanBinding</code>
 */
class BackupPlanBinding extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. The fully qualified name of the BackupPlanBinding.
     * `projects/&#42;&#47;locations/&#42;&#47;backupChannels/&#42;&#47;backupPlanBindings/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Output only. Server generated global unique identifier of
     * [UUID4](https://en.wikipedia.org/wiki/Universally_unique_identifier)
     *
     * Generated from protobuf field <code>string uid = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     */
    protected $uid = '';
    /**
     * Output only. The timestamp when this binding was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. The timestamp when this binding was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;
    /**
     * Output only. Immutable. The fully qualified name of the BackupPlan bound
     * with the parent BackupChannel.
     * `projects/&#42;&#47;locations/&#42;&#47;backupPlans/{backup_plan}`
     *
     * Generated from protobuf field <code>string backup_plan = 5 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $backup_plan = '';
    /**
     * Output only. Immutable. The fully qualified name of the cluster that is
     * being backed up Valid formats:
     * - `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`
     * - `projects/&#42;&#47;zones/&#42;&#47;clusters/&#42;`
     *
     * Generated from protobuf field <code>string cluster = 6 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $cluster = '';
    /**
     * Output only. Contains details about the backup plan/backup.
     *
     * Generated from protobuf field <code>.google.cloud.gkebackup.v1.BackupPlanBinding.BackupPlanDetails backup_plan_details = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $backup_plan_details = null;
    /**
     * Output only. `etag` is used for optimistic concurrency control as a way to
     * help prevent simultaneous updates of a BackupPlanBinding from overwriting
     * each other. It is strongly suggested that systems make use of the 'etag' in
     * the read-modify-write cycle to perform BackupPlanBinding updates in
     * order to avoid race conditions: An `etag` is returned in the response to
     * `GetBackupPlanBinding`, and systems are expected to put that etag in
     * the request to `UpdateBackupPlanBinding` or
     * `DeleteBackupPlanBinding` to ensure that their change will be applied
     * to the same version of the resource.
     *
     * Generated from protobuf field <code>string etag = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $etag = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Identifier. The fully qualified name of the BackupPlanBinding.
     *           `projects/&#42;&#47;locations/&#42;&#47;backupChannels/&#42;&#47;backupPlanBindings/&#42;`
     *     @type string $uid
     *           Output only. Server generated global unique identifier of
     *           [UUID4](https://en.wikipedia.org/wiki/Universally_unique_identifier)
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The timestamp when this binding was created.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The timestamp when this binding was created.
     *     @type string $backup_plan
     *           Output only. Immutable. The fully qualified name of the BackupPlan bound
     *           with the parent BackupChannel.
     *           `projects/&#42;&#47;locations/&#42;&#47;backupPlans/{backup_plan}`
     *     @type string $cluster
     *           Output only. Immutable. The fully qualified name of the cluster that is
     *           being backed up Valid formats:
     *           - `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`
     *           - `projects/&#42;&#47;zones/&#42;&#47;clusters/&#42;`
     *     @type \Google\Cloud\GkeBackup\V1\BackupPlanBinding\BackupPlanDetails $backup_plan_details
     *           Output only. Contains details about the backup plan/backup.
     *     @type string $etag
     *           Output only. `etag` is used for optimistic concurrency control as a way to
     *           help prevent simultaneous updates of a BackupPlanBinding from overwriting
     *           each other. It is strongly suggested that systems make use of the 'etag' in
     *           the read-modify-write cycle to perform BackupPlanBinding updates in
     *           order to avoid race conditions: An `etag` is returned in the response to
     *           `GetBackupPlanBinding`, and systems are expected to put that etag in
     *           the request to `UpdateBackupPlanBinding` or
     *           `DeleteBackupPlanBinding` to ensure that their change will be applied
     *           to the same version of the resource.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Gkebackup\V1\BackupPlanBinding::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifier. The fully qualified name of the BackupPlanBinding.
     * `projects/&#42;&#47;locations/&#42;&#47;backupChannels/&#42;&#47;backupPlanBindings/&#42;`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. The fully qualified name of the BackupPlanBinding.
     * `projects/&#42;&#47;locations/&#42;&#47;backupChannels/&#42;&#47;backupPlanBindings/&#42;`
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
     * Output only. Server generated global unique identifier of
     * [UUID4](https://en.wikipedia.org/wiki/Universally_unique_identifier)
     *
     * Generated from protobuf field <code>string uid = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Output only. Server generated global unique identifier of
     * [UUID4](https://en.wikipedia.org/wiki/Universally_unique_identifier)
     *
     * Generated from protobuf field <code>string uid = 2 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     * @param string $var
     * @return $this
     */
    public function setUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uid = $var;

        return $this;
    }

    /**
     * Output only. The timestamp when this binding was created.
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
     * Output only. The timestamp when this binding was created.
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
     * Output only. The timestamp when this binding was created.
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
     * Output only. The timestamp when this binding was created.
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

    /**
     * Output only. Immutable. The fully qualified name of the BackupPlan bound
     * with the parent BackupChannel.
     * `projects/&#42;&#47;locations/&#42;&#47;backupPlans/{backup_plan}`
     *
     * Generated from protobuf field <code>string backup_plan = 5 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getBackupPlan()
    {
        return $this->backup_plan;
    }

    /**
     * Output only. Immutable. The fully qualified name of the BackupPlan bound
     * with the parent BackupChannel.
     * `projects/&#42;&#47;locations/&#42;&#47;backupPlans/{backup_plan}`
     *
     * Generated from protobuf field <code>string backup_plan = 5 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setBackupPlan($var)
    {
        GPBUtil::checkString($var, True);
        $this->backup_plan = $var;

        return $this;
    }

    /**
     * Output only. Immutable. The fully qualified name of the cluster that is
     * being backed up Valid formats:
     * - `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`
     * - `projects/&#42;&#47;zones/&#42;&#47;clusters/&#42;`
     *
     * Generated from protobuf field <code>string cluster = 6 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     * Output only. Immutable. The fully qualified name of the cluster that is
     * being backed up Valid formats:
     * - `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`
     * - `projects/&#42;&#47;zones/&#42;&#47;clusters/&#42;`
     *
     * Generated from protobuf field <code>string cluster = 6 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setCluster($var)
    {
        GPBUtil::checkString($var, True);
        $this->cluster = $var;

        return $this;
    }

    /**
     * Output only. Contains details about the backup plan/backup.
     *
     * Generated from protobuf field <code>.google.cloud.gkebackup.v1.BackupPlanBinding.BackupPlanDetails backup_plan_details = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Cloud\GkeBackup\V1\BackupPlanBinding\BackupPlanDetails|null
     */
    public function getBackupPlanDetails()
    {
        return $this->backup_plan_details;
    }

    public function hasBackupPlanDetails()
    {
        return isset($this->backup_plan_details);
    }

    public function clearBackupPlanDetails()
    {
        unset($this->backup_plan_details);
    }

    /**
     * Output only. Contains details about the backup plan/backup.
     *
     * Generated from protobuf field <code>.google.cloud.gkebackup.v1.BackupPlanBinding.BackupPlanDetails backup_plan_details = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Cloud\GkeBackup\V1\BackupPlanBinding\BackupPlanDetails $var
     * @return $this
     */
    public function setBackupPlanDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\GkeBackup\V1\BackupPlanBinding\BackupPlanDetails::class);
        $this->backup_plan_details = $var;

        return $this;
    }

    /**
     * Output only. `etag` is used for optimistic concurrency control as a way to
     * help prevent simultaneous updates of a BackupPlanBinding from overwriting
     * each other. It is strongly suggested that systems make use of the 'etag' in
     * the read-modify-write cycle to perform BackupPlanBinding updates in
     * order to avoid race conditions: An `etag` is returned in the response to
     * `GetBackupPlanBinding`, and systems are expected to put that etag in
     * the request to `UpdateBackupPlanBinding` or
     * `DeleteBackupPlanBinding` to ensure that their change will be applied
     * to the same version of the resource.
     *
     * Generated from protobuf field <code>string etag = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Output only. `etag` is used for optimistic concurrency control as a way to
     * help prevent simultaneous updates of a BackupPlanBinding from overwriting
     * each other. It is strongly suggested that systems make use of the 'etag' in
     * the read-modify-write cycle to perform BackupPlanBinding updates in
     * order to avoid race conditions: An `etag` is returned in the response to
     * `GetBackupPlanBinding`, and systems are expected to put that etag in
     * the request to `UpdateBackupPlanBinding` or
     * `DeleteBackupPlanBinding` to ensure that their change will be applied
     * to the same version of the resource.
     *
     * Generated from protobuf field <code>string etag = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setEtag($var)
    {
        GPBUtil::checkString($var, True);
        $this->etag = $var;

        return $this;
    }

}

