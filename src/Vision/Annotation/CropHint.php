<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Vision\Annotation;

use Google\Cloud\Core\CallTrait;

/**
 * Represents a recommended image crop.
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'CROP_HINTS' ]);
 * $annotation = $vision->annotate($image);
 *
 * $hints = $annotation->cropHints();
 * $hint = $hints[0];
 * ```
 *
 * @method boundingPoly() {
 *     The bounding polygon of the recommended crop.
 *
 *     Example:
 *     ```
 *     $poly = $hint->boundingPoly();
 *     ```
 *
 *     @return array [BoundingPoly](https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#boundingpoly)
 * }
 * @method confidence() {
 *     Confidence of this being a salient region.  Range [0, 1].
 *
 *     Example:
 *     ```
 *     $confidence = $hint->confidence();
 *     ```
 *
 *     @return float
 * }
 * @method importanceFraction() {
 *     Fraction of importance of this salient region with respect to the
 *     original image.
 *
 *     Example:
 *     ```
 *     $importance = $hint->importanceFraction();
 *     ```
 *
 *     @return float
 * }
 *
 * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#CropHint CropHint
 */
class CropHint extends AbstractFeature
{
    use CallTrait;

    /**
     * @param array $info Crop Hint result
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }
}
