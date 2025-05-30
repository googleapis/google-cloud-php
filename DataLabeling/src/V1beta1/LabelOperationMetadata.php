<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datalabeling/v1beta1/operations.proto

namespace Google\Cloud\DataLabeling\V1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Metadata of a labeling operation, such as LabelImage or LabelVideo.
 * Next tag: 20
 *
 * Generated from protobuf message <code>google.cloud.datalabeling.v1beta1.LabelOperationMetadata</code>
 */
class LabelOperationMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. Progress of label operation. Range: [0, 100].
     *
     * Generated from protobuf field <code>int32 progress_percent = 1;</code>
     */
    protected $progress_percent = 0;
    /**
     * Output only. Partial failures encountered.
     * E.g. single files that couldn't be read.
     * Status details field will contain standard GCP error details.
     *
     * Generated from protobuf field <code>repeated .google.rpc.Status partial_failures = 2;</code>
     */
    private $partial_failures;
    /**
     * Output only. Timestamp when labeling request was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 16;</code>
     */
    protected $create_time = null;
    protected $details;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelImageClassificationOperationMetadata $image_classification_details
     *           Details of label image classification operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingBoxOperationMetadata $image_bounding_box_details
     *           Details of label image bounding box operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingPolyOperationMetadata $image_bounding_poly_details
     *           Details of label image bounding poly operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelImageOrientedBoundingBoxOperationMetadata $image_oriented_bounding_box_details
     *           Details of label image oriented bounding box operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelImagePolylineOperationMetadata $image_polyline_details
     *           Details of label image polyline operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelImageSegmentationOperationMetadata $image_segmentation_details
     *           Details of label image segmentation operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelVideoClassificationOperationMetadata $video_classification_details
     *           Details of label video classification operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectDetectionOperationMetadata $video_object_detection_details
     *           Details of label video object detection operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectTrackingOperationMetadata $video_object_tracking_details
     *           Details of label video object tracking operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelVideoEventOperationMetadata $video_event_details
     *           Details of label video event operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelTextClassificationOperationMetadata $text_classification_details
     *           Details of label text classification operation.
     *     @type \Google\Cloud\DataLabeling\V1beta1\LabelTextEntityExtractionOperationMetadata $text_entity_extraction_details
     *           Details of label text entity extraction operation.
     *     @type int $progress_percent
     *           Output only. Progress of label operation. Range: [0, 100].
     *     @type array<\Google\Rpc\Status>|\Google\Protobuf\Internal\RepeatedField $partial_failures
     *           Output only. Partial failures encountered.
     *           E.g. single files that couldn't be read.
     *           Status details field will contain standard GCP error details.
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. Timestamp when labeling request was created.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Datalabeling\V1Beta1\Operations::initOnce();
        parent::__construct($data);
    }

    /**
     * Details of label image classification operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageClassificationOperationMetadata image_classification_details = 3;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelImageClassificationOperationMetadata|null
     */
    public function getImageClassificationDetails()
    {
        return $this->readOneof(3);
    }

    public function hasImageClassificationDetails()
    {
        return $this->hasOneof(3);
    }

    /**
     * Details of label image classification operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageClassificationOperationMetadata image_classification_details = 3;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImageClassificationOperationMetadata $var
     * @return $this
     */
    public function setImageClassificationDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelImageClassificationOperationMetadata::class);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Details of label image bounding box operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageBoundingBoxOperationMetadata image_bounding_box_details = 4;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingBoxOperationMetadata|null
     */
    public function getImageBoundingBoxDetails()
    {
        return $this->readOneof(4);
    }

    public function hasImageBoundingBoxDetails()
    {
        return $this->hasOneof(4);
    }

    /**
     * Details of label image bounding box operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageBoundingBoxOperationMetadata image_bounding_box_details = 4;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingBoxOperationMetadata $var
     * @return $this
     */
    public function setImageBoundingBoxDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingBoxOperationMetadata::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * Details of label image bounding poly operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageBoundingPolyOperationMetadata image_bounding_poly_details = 11;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingPolyOperationMetadata|null
     */
    public function getImageBoundingPolyDetails()
    {
        return $this->readOneof(11);
    }

    public function hasImageBoundingPolyDetails()
    {
        return $this->hasOneof(11);
    }

    /**
     * Details of label image bounding poly operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageBoundingPolyOperationMetadata image_bounding_poly_details = 11;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingPolyOperationMetadata $var
     * @return $this
     */
    public function setImageBoundingPolyDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelImageBoundingPolyOperationMetadata::class);
        $this->writeOneof(11, $var);

        return $this;
    }

    /**
     * Details of label image oriented bounding box operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageOrientedBoundingBoxOperationMetadata image_oriented_bounding_box_details = 14;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelImageOrientedBoundingBoxOperationMetadata|null
     */
    public function getImageOrientedBoundingBoxDetails()
    {
        return $this->readOneof(14);
    }

    public function hasImageOrientedBoundingBoxDetails()
    {
        return $this->hasOneof(14);
    }

    /**
     * Details of label image oriented bounding box operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageOrientedBoundingBoxOperationMetadata image_oriented_bounding_box_details = 14;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImageOrientedBoundingBoxOperationMetadata $var
     * @return $this
     */
    public function setImageOrientedBoundingBoxDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelImageOrientedBoundingBoxOperationMetadata::class);
        $this->writeOneof(14, $var);

        return $this;
    }

    /**
     * Details of label image polyline operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImagePolylineOperationMetadata image_polyline_details = 12;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelImagePolylineOperationMetadata|null
     */
    public function getImagePolylineDetails()
    {
        return $this->readOneof(12);
    }

    public function hasImagePolylineDetails()
    {
        return $this->hasOneof(12);
    }

    /**
     * Details of label image polyline operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImagePolylineOperationMetadata image_polyline_details = 12;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImagePolylineOperationMetadata $var
     * @return $this
     */
    public function setImagePolylineDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelImagePolylineOperationMetadata::class);
        $this->writeOneof(12, $var);

        return $this;
    }

    /**
     * Details of label image segmentation operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageSegmentationOperationMetadata image_segmentation_details = 15;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelImageSegmentationOperationMetadata|null
     */
    public function getImageSegmentationDetails()
    {
        return $this->readOneof(15);
    }

    public function hasImageSegmentationDetails()
    {
        return $this->hasOneof(15);
    }

    /**
     * Details of label image segmentation operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelImageSegmentationOperationMetadata image_segmentation_details = 15;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImageSegmentationOperationMetadata $var
     * @return $this
     */
    public function setImageSegmentationDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelImageSegmentationOperationMetadata::class);
        $this->writeOneof(15, $var);

        return $this;
    }

    /**
     * Details of label video classification operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoClassificationOperationMetadata video_classification_details = 5;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelVideoClassificationOperationMetadata|null
     */
    public function getVideoClassificationDetails()
    {
        return $this->readOneof(5);
    }

    public function hasVideoClassificationDetails()
    {
        return $this->hasOneof(5);
    }

    /**
     * Details of label video classification operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoClassificationOperationMetadata video_classification_details = 5;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelVideoClassificationOperationMetadata $var
     * @return $this
     */
    public function setVideoClassificationDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelVideoClassificationOperationMetadata::class);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Details of label video object detection operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoObjectDetectionOperationMetadata video_object_detection_details = 6;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectDetectionOperationMetadata|null
     */
    public function getVideoObjectDetectionDetails()
    {
        return $this->readOneof(6);
    }

    public function hasVideoObjectDetectionDetails()
    {
        return $this->hasOneof(6);
    }

    /**
     * Details of label video object detection operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoObjectDetectionOperationMetadata video_object_detection_details = 6;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectDetectionOperationMetadata $var
     * @return $this
     */
    public function setVideoObjectDetectionDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectDetectionOperationMetadata::class);
        $this->writeOneof(6, $var);

        return $this;
    }

    /**
     * Details of label video object tracking operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoObjectTrackingOperationMetadata video_object_tracking_details = 7;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectTrackingOperationMetadata|null
     */
    public function getVideoObjectTrackingDetails()
    {
        return $this->readOneof(7);
    }

    public function hasVideoObjectTrackingDetails()
    {
        return $this->hasOneof(7);
    }

    /**
     * Details of label video object tracking operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoObjectTrackingOperationMetadata video_object_tracking_details = 7;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectTrackingOperationMetadata $var
     * @return $this
     */
    public function setVideoObjectTrackingDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelVideoObjectTrackingOperationMetadata::class);
        $this->writeOneof(7, $var);

        return $this;
    }

    /**
     * Details of label video event operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoEventOperationMetadata video_event_details = 8;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelVideoEventOperationMetadata|null
     */
    public function getVideoEventDetails()
    {
        return $this->readOneof(8);
    }

    public function hasVideoEventDetails()
    {
        return $this->hasOneof(8);
    }

    /**
     * Details of label video event operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelVideoEventOperationMetadata video_event_details = 8;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelVideoEventOperationMetadata $var
     * @return $this
     */
    public function setVideoEventDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelVideoEventOperationMetadata::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Details of label text classification operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelTextClassificationOperationMetadata text_classification_details = 9;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelTextClassificationOperationMetadata|null
     */
    public function getTextClassificationDetails()
    {
        return $this->readOneof(9);
    }

    public function hasTextClassificationDetails()
    {
        return $this->hasOneof(9);
    }

    /**
     * Details of label text classification operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelTextClassificationOperationMetadata text_classification_details = 9;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelTextClassificationOperationMetadata $var
     * @return $this
     */
    public function setTextClassificationDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelTextClassificationOperationMetadata::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * Details of label text entity extraction operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelTextEntityExtractionOperationMetadata text_entity_extraction_details = 13;</code>
     * @return \Google\Cloud\DataLabeling\V1beta1\LabelTextEntityExtractionOperationMetadata|null
     */
    public function getTextEntityExtractionDetails()
    {
        return $this->readOneof(13);
    }

    public function hasTextEntityExtractionDetails()
    {
        return $this->hasOneof(13);
    }

    /**
     * Details of label text entity extraction operation.
     *
     * Generated from protobuf field <code>.google.cloud.datalabeling.v1beta1.LabelTextEntityExtractionOperationMetadata text_entity_extraction_details = 13;</code>
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelTextEntityExtractionOperationMetadata $var
     * @return $this
     */
    public function setTextEntityExtractionDetails($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DataLabeling\V1beta1\LabelTextEntityExtractionOperationMetadata::class);
        $this->writeOneof(13, $var);

        return $this;
    }

    /**
     * Output only. Progress of label operation. Range: [0, 100].
     *
     * Generated from protobuf field <code>int32 progress_percent = 1;</code>
     * @return int
     */
    public function getProgressPercent()
    {
        return $this->progress_percent;
    }

    /**
     * Output only. Progress of label operation. Range: [0, 100].
     *
     * Generated from protobuf field <code>int32 progress_percent = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setProgressPercent($var)
    {
        GPBUtil::checkInt32($var);
        $this->progress_percent = $var;

        return $this;
    }

    /**
     * Output only. Partial failures encountered.
     * E.g. single files that couldn't be read.
     * Status details field will contain standard GCP error details.
     *
     * Generated from protobuf field <code>repeated .google.rpc.Status partial_failures = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPartialFailures()
    {
        return $this->partial_failures;
    }

    /**
     * Output only. Partial failures encountered.
     * E.g. single files that couldn't be read.
     * Status details field will contain standard GCP error details.
     *
     * Generated from protobuf field <code>repeated .google.rpc.Status partial_failures = 2;</code>
     * @param array<\Google\Rpc\Status>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPartialFailures($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Rpc\Status::class);
        $this->partial_failures = $arr;

        return $this;
    }

    /**
     * Output only. Timestamp when labeling request was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 16;</code>
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
     * Output only. Timestamp when labeling request was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 16;</code>
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
     * @return string
     */
    public function getDetails()
    {
        return $this->whichOneof("details");
    }

}

