<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/netapp/v1/storage_pool.proto

namespace Google\Cloud\NetApp\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * CreateStoragePoolRequest creates a Storage Pool.
 *
 * Generated from protobuf message <code>google.cloud.netapp.v1.CreateStoragePoolRequest</code>
 */
class CreateStoragePoolRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Value for parent.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. Id of the requesting storage pool. Must be unique within the
     * parent resource. Must contain only letters, numbers and hyphen, with the
     * first character a letter, the last a letter or a number, and a 63 character
     * maximum.
     *
     * Generated from protobuf field <code>string storage_pool_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $storage_pool_id = '';
    /**
     * Required. The required parameters to create a new storage pool.
     *
     * Generated from protobuf field <code>.google.cloud.netapp.v1.StoragePool storage_pool = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $storage_pool = null;

    /**
     * @param string                              $parent        Required. Value for parent. Please see
     *                                                           {@see NetAppClient::locationName()} for help formatting this field.
     * @param \Google\Cloud\NetApp\V1\StoragePool $storagePool   Required. The required parameters to create a new storage pool.
     * @param string                              $storagePoolId Required. Id of the requesting storage pool. Must be unique within the
     *                                                           parent resource. Must contain only letters, numbers and hyphen, with the
     *                                                           first character a letter, the last a letter or a number, and a 63 character
     *                                                           maximum.
     *
     * @return \Google\Cloud\NetApp\V1\CreateStoragePoolRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\NetApp\V1\StoragePool $storagePool, string $storagePoolId): self
    {
        return (new self())
            ->setParent($parent)
            ->setStoragePool($storagePool)
            ->setStoragePoolId($storagePoolId);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Value for parent.
     *     @type string $storage_pool_id
     *           Required. Id of the requesting storage pool. Must be unique within the
     *           parent resource. Must contain only letters, numbers and hyphen, with the
     *           first character a letter, the last a letter or a number, and a 63 character
     *           maximum.
     *     @type \Google\Cloud\NetApp\V1\StoragePool $storage_pool
     *           Required. The required parameters to create a new storage pool.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Netapp\V1\StoragePool::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Value for parent.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Value for parent.
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
     * Required. Id of the requesting storage pool. Must be unique within the
     * parent resource. Must contain only letters, numbers and hyphen, with the
     * first character a letter, the last a letter or a number, and a 63 character
     * maximum.
     *
     * Generated from protobuf field <code>string storage_pool_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getStoragePoolId()
    {
        return $this->storage_pool_id;
    }

    /**
     * Required. Id of the requesting storage pool. Must be unique within the
     * parent resource. Must contain only letters, numbers and hyphen, with the
     * first character a letter, the last a letter or a number, and a 63 character
     * maximum.
     *
     * Generated from protobuf field <code>string storage_pool_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setStoragePoolId($var)
    {
        GPBUtil::checkString($var, True);
        $this->storage_pool_id = $var;

        return $this;
    }

    /**
     * Required. The required parameters to create a new storage pool.
     *
     * Generated from protobuf field <code>.google.cloud.netapp.v1.StoragePool storage_pool = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\NetApp\V1\StoragePool|null
     */
    public function getStoragePool()
    {
        return $this->storage_pool;
    }

    public function hasStoragePool()
    {
        return isset($this->storage_pool);
    }

    public function clearStoragePool()
    {
        unset($this->storage_pool);
    }

    /**
     * Required. The required parameters to create a new storage pool.
     *
     * Generated from protobuf field <code>.google.cloud.netapp.v1.StoragePool storage_pool = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\NetApp\V1\StoragePool $var
     * @return $this
     */
    public function setStoragePool($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\NetApp\V1\StoragePool::class);
        $this->storage_pool = $var;

        return $this;
    }

}

