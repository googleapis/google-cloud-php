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

/**
 * Represents the imageProperties feature result
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'imageProperties' ]);
 * $annotation = $vision->annotate($image);
 *
 * $imageProperties = $annotation->imageProperties();
 * ```
 *
 * @method info() {
 *     Get the raw annotation result
 *
 *     Example:
 *     ```
 *     $info = $imageProperties->info();
 *     ```
 *
 *     @return array
 * }
 *
 * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#ImageProperties ImageProperties
 */
class ImageProperties extends AbstractFeature
{
    /**
     * Create an ImageProperties result.
     *
     * This class is created internally by {@see Google\Cloud\Vision\Annotation}.
     * See {@see Google\Cloud\Vision\Annotation::imageProperties()} for full usage details.
     * This class should not be instantiated outside the externally.
     *
     * @param array $info The imageProperties annotation result
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }

    /**
     * Get the dominant colors in the image
     *
     * Example:
     * ```
     * $colors = $imageProperties->colors();
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#colorinfo ColorInfo
     *
     * @return array
     */
    public function colors()
    {
        return $this->info['dominantColors']['colors'];
    }
}
