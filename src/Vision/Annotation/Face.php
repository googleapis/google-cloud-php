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

use Google\Cloud\Exception\GoogleException;
use Google\Cloud\Vision\Annotation\Face\Landmarks;

/**
 * Represents a face annotation result
 *
 * @method array boundingPoly() {
 *     The bounding polygon around the face.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->boundingPoly());
 *     ```
 * }
 * @method array fdBoundingPoly() {
 *     Bounding polygon around the face.
 *
 *     Tighter than `boundingPoly` and encloses only the skin part of the face.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->fdBoundingPoly());
 *     ```
 * }
 * @method float rollAngle() {
 *     Roll angle.
 *
 *     Indicates the amount of clockwise/anti-clockwise rotation of the face.
 *     Range [-180,180]
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->rollAngle());
 *     ```
 * }
 * @method float panAngle() {
 *     Yaw angle.
 *
 *     Indicates the leftward/rightward angle that the face is pointing. Range
 *     [-180,180]
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->panAngle());
 *     ```
 * }
 * @method float tiltAngle() {
 *     Pitch angle.
 *
 *     Indicates the upwards/downwards angle that the face is pointing. Range
 *     [-180,180]
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->tiltAngle());
 *     ```
 * }
 * @method float detectionConfidence() {
 *     The detection confidence.
 *
 *     Range [0,1]
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->detectionConfidence());
 *     ```
 * }
 * @method float landmarkingConfidence() {
 *     Face landmarking confidence.
 *
 *     Range [0,1]
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->landmarkingConfidence());
 *     ```
 * }
 * @method string joyLikelihood() {
 *     Joy likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->joyLikelihood());
 *     ```
 * }
 * @method string sorrowLikelihood() {
 *     Sorrow likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->sorrowLikelihood());
 *     ```
 * }
 * @method string angerLikelihood() {
 *     Anger likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->angerLikelihood());
 *     ```
 * }
 * @method string surpriseLikelihood() {
 *     Surprise likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->surpriseLikelihood());
 *     ```
 * }
 * @method string underExposedLikelihood() {
 *     Under exposure likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->underExposedLikelihood());
 *     ```
 * }
 * @method string blurredLikelihood() {
 *     Blurred likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->blurredLikelihood());
 *     ```
 * }
 * @method string headwearLikelihood() {
 *     Headwear likelihood.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $face = $annotation->faces()[0];
 *     print_R($face->headwearLikelihood());
 *     ```
 * }
 */
class Face implements FeatureInterface
{
    use CallTrait;
    use FeatureTrait;

    private $result;

    public function __construct(array $result)
    {
        $this->result = $result;
        $this->landmarks = new Landmarks($result['landmarks']);
    }

    /**
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
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->isJoyful()) {
     *     echo "Face is Joyful";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isJoyful($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('joyLikelihood', $strength);
    }

    /**
     * Check whether the face is sorrowful.
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->isSorrowful()) {
     *     echo "Face is Sorrowful";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isSorrowful($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('sorrowLikelihood', $strength);
    }

    /**
     * Check whether the face is angry.
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->isAngry()) {
     *     echo "Face is Angry";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isAngry($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('angerLikelihood', $strength);
    }

    /**
     * Check whether the face is surprised.
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->isSurprised()) {
     *     echo "Face is Surprised";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isSurprised($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('surpriseLikelihood', $strength);
    }

    /**
     * Check whether the face is under exposed.
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->isUnderExposed()) {
     *     echo "Face is Under Exposed";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isUnderExposed($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('underExposedLikelihood', $strength);
    }

    /**
     * Check whether the face is blurred.
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->isBlurred()) {
     *     echo "Face is Blurred";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function isBlurred($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('blurredLikelihood', $strength);
    }

    /**
     * Check whether the person is wearing headwear.
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $face = $annotation->faces()[0];
     *
     * if ($face->hasHeadwear()) {
     *     echo "Face has Headwear";
     * }
     * ```
     *
     * @param  string $strength Value should be one of "low", "medium" or "high".
     *         Recommended usage is via `Face::STRENGTH_*` constants. Defaults
     *         to "low". Higher strength will result in fewer `true` results,
     *         but fewer false positives.
     * @return bool
     */
    public function hasHeadwear($strength = self::STRENGTH_LOW)
    {
        return $this->likelihood('headwearLikelihood', $strength);
    }
}
