<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/memorystore/v1beta/memorystore.proto

namespace Google\Cloud\Memorystore\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A certificate authority for an instance.
 *
 * Generated from protobuf message <code>google.cloud.memorystore.v1beta.CertificateAuthority</code>
 */
class CertificateAuthority extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. Unique name of the certificate authority.
     * Format:
     * projects/{project}/locations/{location}/instances/{instance}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    protected $server_ca;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Memorystore\V1beta\CertificateAuthority\ManagedCertificateAuthority $managed_server_ca
     *           A managed server certificate authority.
     *     @type string $name
     *           Identifier. Unique name of the certificate authority.
     *           Format:
     *           projects/{project}/locations/{location}/instances/{instance}
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Memorystore\V1Beta\Memorystore::initOnce();
        parent::__construct($data);
    }

    /**
     * A managed server certificate authority.
     *
     * Generated from protobuf field <code>.google.cloud.memorystore.v1beta.CertificateAuthority.ManagedCertificateAuthority managed_server_ca = 2;</code>
     * @return \Google\Cloud\Memorystore\V1beta\CertificateAuthority\ManagedCertificateAuthority|null
     */
    public function getManagedServerCa()
    {
        return $this->readOneof(2);
    }

    public function hasManagedServerCa()
    {
        return $this->hasOneof(2);
    }

    /**
     * A managed server certificate authority.
     *
     * Generated from protobuf field <code>.google.cloud.memorystore.v1beta.CertificateAuthority.ManagedCertificateAuthority managed_server_ca = 2;</code>
     * @param \Google\Cloud\Memorystore\V1beta\CertificateAuthority\ManagedCertificateAuthority $var
     * @return $this
     */
    public function setManagedServerCa($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Memorystore\V1beta\CertificateAuthority\ManagedCertificateAuthority::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Identifier. Unique name of the certificate authority.
     * Format:
     * projects/{project}/locations/{location}/instances/{instance}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. Unique name of the certificate authority.
     * Format:
     * projects/{project}/locations/{location}/instances/{instance}
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
     * @return string
     */
    public function getServerCa()
    {
        return $this->whichOneof("server_ca");
    }

}

