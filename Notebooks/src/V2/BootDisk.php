<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/notebooks/v2/gce_setup.proto

namespace Google\Cloud\Notebooks\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The definition of a boot disk.
 *
 * Generated from protobuf message <code>google.cloud.notebooks.v2.BootDisk</code>
 */
class BootDisk extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The size of the boot disk in GB attached to this instance, up to
     * a maximum of 64000 GB (64 TB). If not specified, this defaults to the
     * recommended value of 150GB.
     *
     * Generated from protobuf field <code>int64 disk_size_gb = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $disk_size_gb = 0;
    /**
     * Optional. Indicates the type of the disk.
     *
     * Generated from protobuf field <code>.google.cloud.notebooks.v2.DiskType disk_type = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $disk_type = 0;
    /**
     * Optional. Input only. Disk encryption method used on the boot and data
     * disks, defaults to GMEK.
     *
     * Generated from protobuf field <code>.google.cloud.notebooks.v2.DiskEncryption disk_encryption = 3 [(.google.api.field_behavior) = INPUT_ONLY, (.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $disk_encryption = 0;
    /**
     * Optional. Input only. The KMS key used to encrypt the disks, only
     * applicable if disk_encryption is CMEK. Format:
     * `projects/{project_id}/locations/{location}/keyRings/{key_ring_id}/cryptoKeys/{key_id}`
     * Learn more about using your own encryption keys.
     *
     * Generated from protobuf field <code>string kms_key = 4 [(.google.api.field_behavior) = INPUT_ONLY, (.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $kms_key = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $disk_size_gb
     *           Optional. The size of the boot disk in GB attached to this instance, up to
     *           a maximum of 64000 GB (64 TB). If not specified, this defaults to the
     *           recommended value of 150GB.
     *     @type int $disk_type
     *           Optional. Indicates the type of the disk.
     *     @type int $disk_encryption
     *           Optional. Input only. Disk encryption method used on the boot and data
     *           disks, defaults to GMEK.
     *     @type string $kms_key
     *           Optional. Input only. The KMS key used to encrypt the disks, only
     *           applicable if disk_encryption is CMEK. Format:
     *           `projects/{project_id}/locations/{location}/keyRings/{key_ring_id}/cryptoKeys/{key_id}`
     *           Learn more about using your own encryption keys.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Notebooks\V2\GceSetup::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The size of the boot disk in GB attached to this instance, up to
     * a maximum of 64000 GB (64 TB). If not specified, this defaults to the
     * recommended value of 150GB.
     *
     * Generated from protobuf field <code>int64 disk_size_gb = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int|string
     */
    public function getDiskSizeGb()
    {
        return $this->disk_size_gb;
    }

    /**
     * Optional. The size of the boot disk in GB attached to this instance, up to
     * a maximum of 64000 GB (64 TB). If not specified, this defaults to the
     * recommended value of 150GB.
     *
     * Generated from protobuf field <code>int64 disk_size_gb = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int|string $var
     * @return $this
     */
    public function setDiskSizeGb($var)
    {
        GPBUtil::checkInt64($var);
        $this->disk_size_gb = $var;

        return $this;
    }

    /**
     * Optional. Indicates the type of the disk.
     *
     * Generated from protobuf field <code>.google.cloud.notebooks.v2.DiskType disk_type = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getDiskType()
    {
        return $this->disk_type;
    }

    /**
     * Optional. Indicates the type of the disk.
     *
     * Generated from protobuf field <code>.google.cloud.notebooks.v2.DiskType disk_type = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setDiskType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Notebooks\V2\DiskType::class);
        $this->disk_type = $var;

        return $this;
    }

    /**
     * Optional. Input only. Disk encryption method used on the boot and data
     * disks, defaults to GMEK.
     *
     * Generated from protobuf field <code>.google.cloud.notebooks.v2.DiskEncryption disk_encryption = 3 [(.google.api.field_behavior) = INPUT_ONLY, (.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getDiskEncryption()
    {
        return $this->disk_encryption;
    }

    /**
     * Optional. Input only. Disk encryption method used on the boot and data
     * disks, defaults to GMEK.
     *
     * Generated from protobuf field <code>.google.cloud.notebooks.v2.DiskEncryption disk_encryption = 3 [(.google.api.field_behavior) = INPUT_ONLY, (.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setDiskEncryption($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Notebooks\V2\DiskEncryption::class);
        $this->disk_encryption = $var;

        return $this;
    }

    /**
     * Optional. Input only. The KMS key used to encrypt the disks, only
     * applicable if disk_encryption is CMEK. Format:
     * `projects/{project_id}/locations/{location}/keyRings/{key_ring_id}/cryptoKeys/{key_id}`
     * Learn more about using your own encryption keys.
     *
     * Generated from protobuf field <code>string kms_key = 4 [(.google.api.field_behavior) = INPUT_ONLY, (.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getKmsKey()
    {
        return $this->kms_key;
    }

    /**
     * Optional. Input only. The KMS key used to encrypt the disks, only
     * applicable if disk_encryption is CMEK. Format:
     * `projects/{project_id}/locations/{location}/keyRings/{key_ring_id}/cryptoKeys/{key_id}`
     * Learn more about using your own encryption keys.
     *
     * Generated from protobuf field <code>string kms_key = 4 [(.google.api.field_behavior) = INPUT_ONLY, (.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setKmsKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->kms_key = $var;

        return $this;
    }

}
