<?php
/**
 * Created by IntelliJ IDEA.
 * User: michaelbausor
 * Date: 5/6/17
 * Time: 9:14 PM
 */

namespace Google\Cloud\Vision\V1;

use Google\Cloud\Vision\ImageAnnotatorTrait;

class ImageAnnotatorClient extends ImageAnnotatorGapicClient
{
    use ImageAnnotatorTrait;

    function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setClient($this);
    }

    /**
     * @param resource|string|StorageObject $image
     * @param \Google\Cloud\Vision\V1\Feature\Type[]|int $features
     * @param array $optionalArgs {
     *
     *     @type array $maxResults An array of maximum number of features to return
     *     @type \Google\Cloud\Vision\V1\ImageContext $imageContext
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     * @return \Google\Cloud\Vision\V1\AnnotateImageResponse The server response
     */
    function detectFeatures($image, $features, $optionalArgs = [])
    {
        return $this->detectFeaturesImpl($image, $features, $optionalArgs);
    }

    /**
     * @param resource|string|StorageObject $image
     * @param array $optionalArgs {
     *
     *     @type integer $maxResults A maximum number of features to return
     *     @type \Google\Cloud\Vision\V1\ImageContext $imageContext
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     * @return FaceAnnotation[] Array of face annotations
     */
    function detectFaces($image, $optionalArgs = [])
    {
        return $this->detectFeatureTypeImpl($image, Feature\Type::FACE_DETECTION,
            'getFaceAnnotationsList', $optionalArgs);
    }

    /**
     * @param FaceAnnotation $faceAnnotation
     * @param FaceAnnotation\Landmark\Type|int $landmarkType
     * @return Position|null Landmark position
     */
    function getFaceLandmarkPosition($faceAnnotation, $landmarkType)
    {
        return $this->getFaceLandmarkPositionImpl($faceAnnotation, $landmarkType);
    }
}
