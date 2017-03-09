<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Vision\Annotation;

use Google\Cloud\Core\CallTrait;
use Google\Cloud\Vision\Annotation\Face\Landmarks;

/**
 * Represents a face annotation result
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'FACE_DETECTION' ]);
 * $annotation = $vision->annotate($image);
 *
 * $faces = $annotation->faces();
 * $face = $faces[0];
 * ```
 *
 * @method boundingPoly() {
 *     The bounding polygon around the face.
 *
 *     Example:
 *     ```
 *     print_R($face->boundingPoly());
 *     ```
 *
 *     @return array
 * }
 * @method fdBoundingPoly() {
 *     Bounding polygon around the face.
 *
 *     Tighter than `boundingPoly` and encloses only the skin part of the face.
 *
 *     Example:
 *     ```
 *     print_R($face->fdBoundingPoly());
 *     ```
 *
 *     @return array
 * }
 * @method rollAngle() {
 *     Roll angle.
 *
 *     Indicates the amount of clockwise/anti-clockwise rotation of the face.
 *     Range [-180,180]
 *
 *     Example:
 *     ```
 *     print_R($face->rollAngle());
 *     ```
 *
 *     @return float
 * }
 * @method panAngle() {
 *     Yaw angle.
 *
 *     Indicates the leftward/rightward angle that the face is pointing. Range
 *     [-180,180]
 *
 *     Example:
 *     ```
 *     print_R($face->panAngle());
 *     ```
 *
 *     @return float
 * }
 * @method tiltAngle() {
 *     Pitch angle.
 *
 *     Indicates the upwards/downwards angle that the face is pointing. Range
 *     [-180,180]
 *
 *     Example:
 *     ```
 *     print_R($face->tiltAngle());
 *     ```
 *
 *     @return float
 * }
 * @method detectionConfidence() {
 *     The detection confidence.
 *
 *     Range [0,1]
 *
 *     Example:
 *     ```
 *     print_R($face->detectionConfidence());
 *     ```
 *
 *     @return float
 * }
 * @method landmarkingConfidence() {
 *     Face landmarking confidence.
 *
 *     Range [0,1]
 *
 *     Example:
 *     ```
 *     print_R($face->landmarkingConfidence());
 *     ```
 *
 *     @return float
 * }
 * @method joyLikelihood() {
 *     Joy likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->joyLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method sorrowLikelihood() {
 *     Sorrow likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->sorrowLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method angerLikelihood() {
 *     Anger likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->angerLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method surpriseLikelihood() {
 *     Surprise likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->surpriseLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method underExposedLikelihood() {
 *     Under exposure likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->underExposedLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method blurredLikelihood() {
 *     Blurred likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->blurredLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method headwearLikelihood() {
 *     Headwear likelihood.
 *
 *     Example:
 *     ```
 *     echo $face->headwearLikelihood();
 *     ```
 *
 *     @return string
 * }
 * @method info() {
 *     Get the raw annotation result
 *
 *     Example:
 *     ```
 *     $info = $face->info();
 *     ```
 *
 *     @return array
 * }
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#faceannotation FaceAnnotation
 * @codingStandardsIgnoreEnd
 */
class Face extends AbstractFeature
{
    use CallTrait;
    use LikelihoodTrait;

    /**
     * @var Landmarks
     */
    private $landmarks;

    /**
     * Create an Face result.
     *
     * This class is created internally by {@see Google\Cloud\Vision\Annotation}.
     * See {@see Google\Cloud\Vision\Annotation::faces()} for full usage details.
     * This class should not be instantiated outside the externally.
     *
     * @param array $info The face annotation result
     */
    public function __construct(array $info)
    {
        $this->info = $info;
        $this->landmarks = new Landmarks($info['landmarks']);
    }

    /**
     * Returns an object detailing facial landmarks and their location.
     *
     * Example:
     * ```
     * $leftEye = $face->landmarks()->leftEye();
     * ```
     * @return Landmarks
     */
    public function landmarks()
    {
        return $this->landmarks;
    }

    /**
     * Check whether the face is joyful.
     *
     * Example:
     * ```
     * if ($face->isJoyful()) {
     *     echo "Face is Joyful";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isJoyful($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['joyLikelihood'], $strength);
    }

    /**
     * Check whether the face is sorrowful.
     *
     * Example:
     * ```
     * if ($face->isSorrowful()) {
     *     echo "Face is Sorrowful";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isSorrowful($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['sorrowLikelihood'], $strength);
    }

    /**
     * Check whether the face is angry.
     *
     * Example:
     * ```
     * if ($face->isAngry()) {
     *     echo "Face is Angry";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isAngry($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['angerLikelihood'], $strength);
    }

    /**
     * Check whether the face is surprised.
     *
     * Example:
     * ```
     * if ($face->isSurprised()) {
     *     echo "Face is Surprised";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isSurprised($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['surpriseLikelihood'], $strength);
    }

    /**
     * Check whether the face is under exposed.
     *
     * Example:
     * ```
     * if ($face->isUnderExposed()) {
     *     echo "Face is Under Exposed";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isUnderExposed($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['underExposedLikelihood'], $strength);
    }

    /**
     * Check whether the face is blurred.
     *
     * Example:
     * ```
     * if ($face->isBlurred()) {
     *     echo "Face is Blurred";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function isBlurred($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['blurredLikelihood'], $strength);
    }

    /**
     * Check whether the person is wearing headwear.
     *
     * Example:
     * ```
     * if ($face->hasHeadwear()) {
     *     echo "Face has Headwear";
     * }
     * ```
     *
     * @param  string $strength [optional] Value should be one of "low",
     *         "medium" or "high". Recommended usage is via `Face::STRENGTH_*`
     *         constants. Higher strength will result in fewer `true` results,
     *         but fewer false positives. **Defaults to** `"low"`.
     * @return bool
     */
    public function hasHeadwear($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood($this->info['headwearLikelihood'], $strength);
    }
}
