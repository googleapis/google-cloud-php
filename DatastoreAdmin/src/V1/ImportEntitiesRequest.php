<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/datastore/admin/v1/datastore_admin.proto

namespace Google\Cloud\Datastore\Admin\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request for
 * [google.datastore.admin.v1.DatastoreAdmin.ImportEntities][google.datastore.admin.v1.DatastoreAdmin.ImportEntities].
 *
 * Generated from protobuf message <code>google.datastore.admin.v1.ImportEntitiesRequest</code>
 */
class ImportEntitiesRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Project ID against which to make the request.
     *
     * Generated from protobuf field <code>string project_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $project_id = '';
    /**
     * Client-assigned labels.
     *
     * Generated from protobuf field <code>map<string, string> labels = 2;</code>
     */
    private $labels;
    /**
     * Required. The full resource URL of the external storage location.
     * Currently, only Google Cloud Storage is supported. So input_url should be
     * of the form:
     * `gs://BUCKET_NAME[/NAMESPACE_PATH]/OVERALL_EXPORT_METADATA_FILE`, where
     * `BUCKET_NAME` is the name of the Cloud Storage bucket, `NAMESPACE_PATH` is
     * an optional Cloud Storage namespace path (this is not a Cloud Datastore
     * namespace), and `OVERALL_EXPORT_METADATA_FILE` is the metadata file written
     * by the ExportEntities operation. For more information about Cloud Storage
     * namespace paths, see
     * [Object name
     * considerations](https://cloud.google.com/storage/docs/naming#object-considerations).
     * For more information, see
     * [google.datastore.admin.v1.ExportEntitiesResponse.output_url][google.datastore.admin.v1.ExportEntitiesResponse.output_url].
     *
     * Generated from protobuf field <code>string input_url = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $input_url = '';
    /**
     * Optionally specify which kinds/namespaces are to be imported. If provided,
     * the list must be a subset of the EntityFilter used in creating the export,
     * otherwise a FAILED_PRECONDITION error will be returned. If no filter is
     * specified then all entities from the export are imported.
     *
     * Generated from protobuf field <code>.google.datastore.admin.v1.EntityFilter entity_filter = 4;</code>
     */
    protected $entity_filter = null;

    /**
     * @param string                                        $projectId    Required. Project ID against which to make the request.
     * @param array                                         $labels       Client-assigned labels.
     * @param string                                        $inputUrl     Required. The full resource URL of the external storage location.
     *                                                                    Currently, only Google Cloud Storage is supported. So input_url should be
     *                                                                    of the form:
     *                                                                    `gs://BUCKET_NAME[/NAMESPACE_PATH]/OVERALL_EXPORT_METADATA_FILE`, where
     *                                                                    `BUCKET_NAME` is the name of the Cloud Storage bucket, `NAMESPACE_PATH` is
     *                                                                    an optional Cloud Storage namespace path (this is not a Cloud Datastore
     *                                                                    namespace), and `OVERALL_EXPORT_METADATA_FILE` is the metadata file written
     *                                                                    by the ExportEntities operation. For more information about Cloud Storage
     *                                                                    namespace paths, see
     *                                                                    [Object name
     *                                                                    considerations](https://cloud.google.com/storage/docs/naming#object-considerations).
     *
     *                                                                    For more information, see
     *                                                                    [google.datastore.admin.v1.ExportEntitiesResponse.output_url][google.datastore.admin.v1.ExportEntitiesResponse.output_url].
     * @param \Google\Cloud\Datastore\Admin\V1\EntityFilter $entityFilter Optionally specify which kinds/namespaces are to be imported. If provided,
     *                                                                    the list must be a subset of the EntityFilter used in creating the export,
     *                                                                    otherwise a FAILED_PRECONDITION error will be returned. If no filter is
     *                                                                    specified then all entities from the export are imported.
     *
     * @return \Google\Cloud\Datastore\Admin\V1\ImportEntitiesRequest
     *
     * @experimental
     */
    public static function build(string $projectId, array $labels, string $inputUrl, \Google\Cloud\Datastore\Admin\V1\EntityFilter $entityFilter): self
    {
        return (new self())
            ->setProjectId($projectId)
            ->setLabels($labels)
            ->setInputUrl($inputUrl)
            ->setEntityFilter($entityFilter);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $project_id
     *           Required. Project ID against which to make the request.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Client-assigned labels.
     *     @type string $input_url
     *           Required. The full resource URL of the external storage location.
     *           Currently, only Google Cloud Storage is supported. So input_url should be
     *           of the form:
     *           `gs://BUCKET_NAME[/NAMESPACE_PATH]/OVERALL_EXPORT_METADATA_FILE`, where
     *           `BUCKET_NAME` is the name of the Cloud Storage bucket, `NAMESPACE_PATH` is
     *           an optional Cloud Storage namespace path (this is not a Cloud Datastore
     *           namespace), and `OVERALL_EXPORT_METADATA_FILE` is the metadata file written
     *           by the ExportEntities operation. For more information about Cloud Storage
     *           namespace paths, see
     *           [Object name
     *           considerations](https://cloud.google.com/storage/docs/naming#object-considerations).
     *           For more information, see
     *           [google.datastore.admin.v1.ExportEntitiesResponse.output_url][google.datastore.admin.v1.ExportEntitiesResponse.output_url].
     *     @type \Google\Cloud\Datastore\Admin\V1\EntityFilter $entity_filter
     *           Optionally specify which kinds/namespaces are to be imported. If provided,
     *           the list must be a subset of the EntityFilter used in creating the export,
     *           otherwise a FAILED_PRECONDITION error will be returned. If no filter is
     *           specified then all entities from the export are imported.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Datastore\Admin\V1\DatastoreAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Project ID against which to make the request.
     *
     * Generated from protobuf field <code>string project_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Required. Project ID against which to make the request.
     *
     * Generated from protobuf field <code>string project_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setProjectId($var)
    {
        GPBUtil::checkString($var, True);
        $this->project_id = $var;

        return $this;
    }

    /**
     * Client-assigned labels.
     *
     * Generated from protobuf field <code>map<string, string> labels = 2;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Client-assigned labels.
     *
     * Generated from protobuf field <code>map<string, string> labels = 2;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

    /**
     * Required. The full resource URL of the external storage location.
     * Currently, only Google Cloud Storage is supported. So input_url should be
     * of the form:
     * `gs://BUCKET_NAME[/NAMESPACE_PATH]/OVERALL_EXPORT_METADATA_FILE`, where
     * `BUCKET_NAME` is the name of the Cloud Storage bucket, `NAMESPACE_PATH` is
     * an optional Cloud Storage namespace path (this is not a Cloud Datastore
     * namespace), and `OVERALL_EXPORT_METADATA_FILE` is the metadata file written
     * by the ExportEntities operation. For more information about Cloud Storage
     * namespace paths, see
     * [Object name
     * considerations](https://cloud.google.com/storage/docs/naming#object-considerations).
     * For more information, see
     * [google.datastore.admin.v1.ExportEntitiesResponse.output_url][google.datastore.admin.v1.ExportEntitiesResponse.output_url].
     *
     * Generated from protobuf field <code>string input_url = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getInputUrl()
    {
        return $this->input_url;
    }

    /**
     * Required. The full resource URL of the external storage location.
     * Currently, only Google Cloud Storage is supported. So input_url should be
     * of the form:
     * `gs://BUCKET_NAME[/NAMESPACE_PATH]/OVERALL_EXPORT_METADATA_FILE`, where
     * `BUCKET_NAME` is the name of the Cloud Storage bucket, `NAMESPACE_PATH` is
     * an optional Cloud Storage namespace path (this is not a Cloud Datastore
     * namespace), and `OVERALL_EXPORT_METADATA_FILE` is the metadata file written
     * by the ExportEntities operation. For more information about Cloud Storage
     * namespace paths, see
     * [Object name
     * considerations](https://cloud.google.com/storage/docs/naming#object-considerations).
     * For more information, see
     * [google.datastore.admin.v1.ExportEntitiesResponse.output_url][google.datastore.admin.v1.ExportEntitiesResponse.output_url].
     *
     * Generated from protobuf field <code>string input_url = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setInputUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->input_url = $var;

        return $this;
    }

    /**
     * Optionally specify which kinds/namespaces are to be imported. If provided,
     * the list must be a subset of the EntityFilter used in creating the export,
     * otherwise a FAILED_PRECONDITION error will be returned. If no filter is
     * specified then all entities from the export are imported.
     *
     * Generated from protobuf field <code>.google.datastore.admin.v1.EntityFilter entity_filter = 4;</code>
     * @return \Google\Cloud\Datastore\Admin\V1\EntityFilter|null
     */
    public function getEntityFilter()
    {
        return $this->entity_filter;
    }

    public function hasEntityFilter()
    {
        return isset($this->entity_filter);
    }

    public function clearEntityFilter()
    {
        unset($this->entity_filter);
    }

    /**
     * Optionally specify which kinds/namespaces are to be imported. If provided,
     * the list must be a subset of the EntityFilter used in creating the export,
     * otherwise a FAILED_PRECONDITION error will be returned. If no filter is
     * specified then all entities from the export are imported.
     *
     * Generated from protobuf field <code>.google.datastore.admin.v1.EntityFilter entity_filter = 4;</code>
     * @param \Google\Cloud\Datastore\Admin\V1\EntityFilter $var
     * @return $this
     */
    public function setEntityFilter($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Datastore\Admin\V1\EntityFilter::class);
        $this->entity_filter = $var;

        return $this;
    }

}

