<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: grafeas/v1/grafeas.proto

namespace Grafeas\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A type of analysis that can be done for a resource.
 *
 * Generated from protobuf message <code>grafeas.v1.Note</code>
 */
class Note extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The name of the note in the form of
     * `projects/[PROVIDER_ID]/notes/[NOTE_ID]`.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * A one sentence description of this note.
     *
     * Generated from protobuf field <code>string short_description = 2;</code>
     */
    protected $short_description = '';
    /**
     * A detailed description of this note.
     *
     * Generated from protobuf field <code>string long_description = 3;</code>
     */
    protected $long_description = '';
    /**
     * Output only. The type of analysis. This field can be used as a filter in
     * list requests.
     *
     * Generated from protobuf field <code>.grafeas.v1.NoteKind kind = 4;</code>
     */
    protected $kind = 0;
    /**
     * URLs associated with this note.
     *
     * Generated from protobuf field <code>repeated .grafeas.v1.RelatedUrl related_url = 5;</code>
     */
    private $related_url;
    /**
     * Time of expiration for this note. Empty if note does not expire.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp expiration_time = 6;</code>
     */
    protected $expiration_time = null;
    /**
     * Output only. The time this note was created. This field can be used as a
     * filter in list requests.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 7;</code>
     */
    protected $create_time = null;
    /**
     * Output only. The time this note was last updated. This field can be used as
     * a filter in list requests.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 8;</code>
     */
    protected $update_time = null;
    /**
     * Other notes related to this note.
     *
     * Generated from protobuf field <code>repeated string related_note_names = 9;</code>
     */
    private $related_note_names;
    protected $type;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Output only. The name of the note in the form of
     *           `projects/[PROVIDER_ID]/notes/[NOTE_ID]`.
     *     @type string $short_description
     *           A one sentence description of this note.
     *     @type string $long_description
     *           A detailed description of this note.
     *     @type int $kind
     *           Output only. The type of analysis. This field can be used as a filter in
     *           list requests.
     *     @type array<\Grafeas\V1\RelatedUrl>|\Google\Protobuf\Internal\RepeatedField $related_url
     *           URLs associated with this note.
     *     @type \Google\Protobuf\Timestamp $expiration_time
     *           Time of expiration for this note. Empty if note does not expire.
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The time this note was created. This field can be used as a
     *           filter in list requests.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The time this note was last updated. This field can be used as
     *           a filter in list requests.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $related_note_names
     *           Other notes related to this note.
     *     @type \Grafeas\V1\VulnerabilityNote $vulnerability
     *           A note describing a package vulnerability.
     *     @type \Grafeas\V1\BuildNote $build
     *           A note describing build provenance for a verifiable build.
     *     @type \Grafeas\V1\ImageNote $image
     *           A note describing a base image.
     *     @type \Grafeas\V1\PackageNote $package
     *           A note describing a package hosted by various package managers.
     *     @type \Grafeas\V1\DeploymentNote $deployment
     *           A note describing something that can be deployed.
     *     @type \Grafeas\V1\DiscoveryNote $discovery
     *           A note describing the initial analysis of a resource.
     *     @type \Grafeas\V1\AttestationNote $attestation
     *           A note describing an attestation role.
     *     @type \Grafeas\V1\UpgradeNote $upgrade
     *           A note describing available package upgrades.
     *     @type \Grafeas\V1\ComplianceNote $compliance
     *           A note describing a compliance check.
     *     @type \Grafeas\V1\DSSEAttestationNote $dsse_attestation
     *           A note describing a dsse attestation note.
     *     @type \Grafeas\V1\VulnerabilityAssessmentNote $vulnerability_assessment
     *           A note describing a vulnerability assessment.
     *     @type \Grafeas\V1\SBOMReferenceNote $sbom_reference
     *           A note describing an SBOM reference.
     *     @type \Grafeas\V1\SecretNote $secret
     *           A note describing a secret.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Grafeas\V1\Grafeas::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. The name of the note in the form of
     * `projects/[PROVIDER_ID]/notes/[NOTE_ID]`.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Output only. The name of the note in the form of
     * `projects/[PROVIDER_ID]/notes/[NOTE_ID]`.
     *
     * Generated from protobuf field <code>string name = 1;</code>
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
     * A one sentence description of this note.
     *
     * Generated from protobuf field <code>string short_description = 2;</code>
     * @return string
     */
    public function getShortDescription()
    {
        return $this->short_description;
    }

    /**
     * A one sentence description of this note.
     *
     * Generated from protobuf field <code>string short_description = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setShortDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->short_description = $var;

        return $this;
    }

    /**
     * A detailed description of this note.
     *
     * Generated from protobuf field <code>string long_description = 3;</code>
     * @return string
     */
    public function getLongDescription()
    {
        return $this->long_description;
    }

    /**
     * A detailed description of this note.
     *
     * Generated from protobuf field <code>string long_description = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setLongDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->long_description = $var;

        return $this;
    }

    /**
     * Output only. The type of analysis. This field can be used as a filter in
     * list requests.
     *
     * Generated from protobuf field <code>.grafeas.v1.NoteKind kind = 4;</code>
     * @return int
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Output only. The type of analysis. This field can be used as a filter in
     * list requests.
     *
     * Generated from protobuf field <code>.grafeas.v1.NoteKind kind = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setKind($var)
    {
        GPBUtil::checkEnum($var, \Grafeas\V1\NoteKind::class);
        $this->kind = $var;

        return $this;
    }

    /**
     * URLs associated with this note.
     *
     * Generated from protobuf field <code>repeated .grafeas.v1.RelatedUrl related_url = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRelatedUrl()
    {
        return $this->related_url;
    }

    /**
     * URLs associated with this note.
     *
     * Generated from protobuf field <code>repeated .grafeas.v1.RelatedUrl related_url = 5;</code>
     * @param array<\Grafeas\V1\RelatedUrl>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRelatedUrl($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Grafeas\V1\RelatedUrl::class);
        $this->related_url = $arr;

        return $this;
    }

    /**
     * Time of expiration for this note. Empty if note does not expire.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp expiration_time = 6;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getExpirationTime()
    {
        return $this->expiration_time;
    }

    public function hasExpirationTime()
    {
        return isset($this->expiration_time);
    }

    public function clearExpirationTime()
    {
        unset($this->expiration_time);
    }

    /**
     * Time of expiration for this note. Empty if note does not expire.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp expiration_time = 6;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setExpirationTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->expiration_time = $var;

        return $this;
    }

    /**
     * Output only. The time this note was created. This field can be used as a
     * filter in list requests.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 7;</code>
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
     * Output only. The time this note was created. This field can be used as a
     * filter in list requests.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 7;</code>
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
     * Output only. The time this note was last updated. This field can be used as
     * a filter in list requests.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 8;</code>
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
     * Output only. The time this note was last updated. This field can be used as
     * a filter in list requests.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 8;</code>
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
     * Other notes related to this note.
     *
     * Generated from protobuf field <code>repeated string related_note_names = 9;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRelatedNoteNames()
    {
        return $this->related_note_names;
    }

    /**
     * Other notes related to this note.
     *
     * Generated from protobuf field <code>repeated string related_note_names = 9;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRelatedNoteNames($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->related_note_names = $arr;

        return $this;
    }

    /**
     * A note describing a package vulnerability.
     *
     * Generated from protobuf field <code>.grafeas.v1.VulnerabilityNote vulnerability = 10;</code>
     * @return \Grafeas\V1\VulnerabilityNote|null
     */
    public function getVulnerability()
    {
        return $this->readOneof(10);
    }

    public function hasVulnerability()
    {
        return $this->hasOneof(10);
    }

    /**
     * A note describing a package vulnerability.
     *
     * Generated from protobuf field <code>.grafeas.v1.VulnerabilityNote vulnerability = 10;</code>
     * @param \Grafeas\V1\VulnerabilityNote $var
     * @return $this
     */
    public function setVulnerability($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\VulnerabilityNote::class);
        $this->writeOneof(10, $var);

        return $this;
    }

    /**
     * A note describing build provenance for a verifiable build.
     *
     * Generated from protobuf field <code>.grafeas.v1.BuildNote build = 11;</code>
     * @return \Grafeas\V1\BuildNote|null
     */
    public function getBuild()
    {
        return $this->readOneof(11);
    }

    public function hasBuild()
    {
        return $this->hasOneof(11);
    }

    /**
     * A note describing build provenance for a verifiable build.
     *
     * Generated from protobuf field <code>.grafeas.v1.BuildNote build = 11;</code>
     * @param \Grafeas\V1\BuildNote $var
     * @return $this
     */
    public function setBuild($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\BuildNote::class);
        $this->writeOneof(11, $var);

        return $this;
    }

    /**
     * A note describing a base image.
     *
     * Generated from protobuf field <code>.grafeas.v1.ImageNote image = 12;</code>
     * @return \Grafeas\V1\ImageNote|null
     */
    public function getImage()
    {
        return $this->readOneof(12);
    }

    public function hasImage()
    {
        return $this->hasOneof(12);
    }

    /**
     * A note describing a base image.
     *
     * Generated from protobuf field <code>.grafeas.v1.ImageNote image = 12;</code>
     * @param \Grafeas\V1\ImageNote $var
     * @return $this
     */
    public function setImage($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\ImageNote::class);
        $this->writeOneof(12, $var);

        return $this;
    }

    /**
     * A note describing a package hosted by various package managers.
     *
     * Generated from protobuf field <code>.grafeas.v1.PackageNote package = 13;</code>
     * @return \Grafeas\V1\PackageNote|null
     */
    public function getPackage()
    {
        return $this->readOneof(13);
    }

    public function hasPackage()
    {
        return $this->hasOneof(13);
    }

    /**
     * A note describing a package hosted by various package managers.
     *
     * Generated from protobuf field <code>.grafeas.v1.PackageNote package = 13;</code>
     * @param \Grafeas\V1\PackageNote $var
     * @return $this
     */
    public function setPackage($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\PackageNote::class);
        $this->writeOneof(13, $var);

        return $this;
    }

    /**
     * A note describing something that can be deployed.
     *
     * Generated from protobuf field <code>.grafeas.v1.DeploymentNote deployment = 14;</code>
     * @return \Grafeas\V1\DeploymentNote|null
     */
    public function getDeployment()
    {
        return $this->readOneof(14);
    }

    public function hasDeployment()
    {
        return $this->hasOneof(14);
    }

    /**
     * A note describing something that can be deployed.
     *
     * Generated from protobuf field <code>.grafeas.v1.DeploymentNote deployment = 14;</code>
     * @param \Grafeas\V1\DeploymentNote $var
     * @return $this
     */
    public function setDeployment($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\DeploymentNote::class);
        $this->writeOneof(14, $var);

        return $this;
    }

    /**
     * A note describing the initial analysis of a resource.
     *
     * Generated from protobuf field <code>.grafeas.v1.DiscoveryNote discovery = 15;</code>
     * @return \Grafeas\V1\DiscoveryNote|null
     */
    public function getDiscovery()
    {
        return $this->readOneof(15);
    }

    public function hasDiscovery()
    {
        return $this->hasOneof(15);
    }

    /**
     * A note describing the initial analysis of a resource.
     *
     * Generated from protobuf field <code>.grafeas.v1.DiscoveryNote discovery = 15;</code>
     * @param \Grafeas\V1\DiscoveryNote $var
     * @return $this
     */
    public function setDiscovery($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\DiscoveryNote::class);
        $this->writeOneof(15, $var);

        return $this;
    }

    /**
     * A note describing an attestation role.
     *
     * Generated from protobuf field <code>.grafeas.v1.AttestationNote attestation = 16;</code>
     * @return \Grafeas\V1\AttestationNote|null
     */
    public function getAttestation()
    {
        return $this->readOneof(16);
    }

    public function hasAttestation()
    {
        return $this->hasOneof(16);
    }

    /**
     * A note describing an attestation role.
     *
     * Generated from protobuf field <code>.grafeas.v1.AttestationNote attestation = 16;</code>
     * @param \Grafeas\V1\AttestationNote $var
     * @return $this
     */
    public function setAttestation($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\AttestationNote::class);
        $this->writeOneof(16, $var);

        return $this;
    }

    /**
     * A note describing available package upgrades.
     *
     * Generated from protobuf field <code>.grafeas.v1.UpgradeNote upgrade = 17;</code>
     * @return \Grafeas\V1\UpgradeNote|null
     */
    public function getUpgrade()
    {
        return $this->readOneof(17);
    }

    public function hasUpgrade()
    {
        return $this->hasOneof(17);
    }

    /**
     * A note describing available package upgrades.
     *
     * Generated from protobuf field <code>.grafeas.v1.UpgradeNote upgrade = 17;</code>
     * @param \Grafeas\V1\UpgradeNote $var
     * @return $this
     */
    public function setUpgrade($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\UpgradeNote::class);
        $this->writeOneof(17, $var);

        return $this;
    }

    /**
     * A note describing a compliance check.
     *
     * Generated from protobuf field <code>.grafeas.v1.ComplianceNote compliance = 18;</code>
     * @return \Grafeas\V1\ComplianceNote|null
     */
    public function getCompliance()
    {
        return $this->readOneof(18);
    }

    public function hasCompliance()
    {
        return $this->hasOneof(18);
    }

    /**
     * A note describing a compliance check.
     *
     * Generated from protobuf field <code>.grafeas.v1.ComplianceNote compliance = 18;</code>
     * @param \Grafeas\V1\ComplianceNote $var
     * @return $this
     */
    public function setCompliance($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\ComplianceNote::class);
        $this->writeOneof(18, $var);

        return $this;
    }

    /**
     * A note describing a dsse attestation note.
     *
     * Generated from protobuf field <code>.grafeas.v1.DSSEAttestationNote dsse_attestation = 19;</code>
     * @return \Grafeas\V1\DSSEAttestationNote|null
     */
    public function getDsseAttestation()
    {
        return $this->readOneof(19);
    }

    public function hasDsseAttestation()
    {
        return $this->hasOneof(19);
    }

    /**
     * A note describing a dsse attestation note.
     *
     * Generated from protobuf field <code>.grafeas.v1.DSSEAttestationNote dsse_attestation = 19;</code>
     * @param \Grafeas\V1\DSSEAttestationNote $var
     * @return $this
     */
    public function setDsseAttestation($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\DSSEAttestationNote::class);
        $this->writeOneof(19, $var);

        return $this;
    }

    /**
     * A note describing a vulnerability assessment.
     *
     * Generated from protobuf field <code>.grafeas.v1.VulnerabilityAssessmentNote vulnerability_assessment = 20;</code>
     * @return \Grafeas\V1\VulnerabilityAssessmentNote|null
     */
    public function getVulnerabilityAssessment()
    {
        return $this->readOneof(20);
    }

    public function hasVulnerabilityAssessment()
    {
        return $this->hasOneof(20);
    }

    /**
     * A note describing a vulnerability assessment.
     *
     * Generated from protobuf field <code>.grafeas.v1.VulnerabilityAssessmentNote vulnerability_assessment = 20;</code>
     * @param \Grafeas\V1\VulnerabilityAssessmentNote $var
     * @return $this
     */
    public function setVulnerabilityAssessment($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\VulnerabilityAssessmentNote::class);
        $this->writeOneof(20, $var);

        return $this;
    }

    /**
     * A note describing an SBOM reference.
     *
     * Generated from protobuf field <code>.grafeas.v1.SBOMReferenceNote sbom_reference = 21;</code>
     * @return \Grafeas\V1\SBOMReferenceNote|null
     */
    public function getSbomReference()
    {
        return $this->readOneof(21);
    }

    public function hasSbomReference()
    {
        return $this->hasOneof(21);
    }

    /**
     * A note describing an SBOM reference.
     *
     * Generated from protobuf field <code>.grafeas.v1.SBOMReferenceNote sbom_reference = 21;</code>
     * @param \Grafeas\V1\SBOMReferenceNote $var
     * @return $this
     */
    public function setSbomReference($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\SBOMReferenceNote::class);
        $this->writeOneof(21, $var);

        return $this;
    }

    /**
     * A note describing a secret.
     *
     * Generated from protobuf field <code>.grafeas.v1.SecretNote secret = 22;</code>
     * @return \Grafeas\V1\SecretNote|null
     */
    public function getSecret()
    {
        return $this->readOneof(22);
    }

    public function hasSecret()
    {
        return $this->hasOneof(22);
    }

    /**
     * A note describing a secret.
     *
     * Generated from protobuf field <code>.grafeas.v1.SecretNote secret = 22;</code>
     * @param \Grafeas\V1\SecretNote $var
     * @return $this
     */
    public function setSecret($var)
    {
        GPBUtil::checkMessage($var, \Grafeas\V1\SecretNote::class);
        $this->writeOneof(22, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->whichOneof("type");
    }

}

