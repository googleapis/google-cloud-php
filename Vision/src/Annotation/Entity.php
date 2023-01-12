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

/**
 * Represents an entity annotation. Entities are created by several
 * [Google Cloud Vision](https://cloud.google.com/vision/docs/) features, namely
 * `LANDMARK_DETECTION`, `LOGO_DETECTION`, `LABEL_DETECTION` and `TEXT_DETECTION`.
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'text' ]);
 * $annotation = $vision->annotate($image);
 *
 * $text = $annotation->text()[0];
 * ```
 *
 * @method mid() {
 *     Opaque entity ID.
 *
 *     Some IDs might be available in Knowledge Graph(KG).
 *
 *     Example:
 *     ```
 *     echo $text->mid();
 *     ```
 *
 *     @see https://developers.google.com/knowledge-graph/ Knowledge Graph
 *
 *     @return string
 * }
 * @method locale() {
 *     The language code for the locale in which the entity textual description
 *     (next field) is expressed.
 *
 *     Example:
 *     ```
 *     echo $text->locale();
 *     ```
 *
 *     @return string
 * }
 * @method description() {
 *     Entity textual description, expressed in its locale language.
 *
 *     Example:
 *     ```
 *     echo $text->description();
 *     ```
 *
 *     @return string
 * }
 * @method score() {
 *     Overall score of the result.
 *
 *     Range [0, 1].
 *
 *     Example:
 *     ```
 *     echo $text->score();
 *     ```
 *
 *     @return float
 * }
 * @method confidence() {
 *     The accuracy of the entity detection in an image.
 *
 *     For example, for an image containing 'Eiffel Tower,' this field
 *     represents the confidence that there is a tower in the query image.
 *
 *     Range [0, 1].
 *
 *     Example:
 *     ```
 *     echo $text->confidence();
 *     ```
 *
 *     @return float
 * }
 * @method topicality() {
 *     The relevancy of the ICA (Image Content Annotation) label to the image.
 *
 *     For example, the relevancy of 'tower' to an image containing
 *     'Eiffel Tower' is likely higher than an image containing a distant
 *     towering building, though the confidence that there is a tower may be the
 *     same.
 *
 *     Range [0, 1].
 *
 *     Example:
 *     ```
 *     echo $text->topicality();
 *     ```
 *
 *     @return float
 * }
 * @method boundingPoly() {
 *     Image region to which this entity belongs.
 *
 *     Not filled currently for LABEL_DETECTION features. For TEXT_DETECTION
 *     (OCR), boundingPolys are produced for the entire text detected in an
 *     image region, followed by boundingPolys for each word within the detected
 *     text.
 *
 *     Example:
 *     ```
 *     print_r($text->boundingPoly());
 *     ```
 *
 *     @return array
 * }
 * @method locations() {
 *     The location information for the detected entity.
 *
 *     Multiple LocationInfo elements can be present since one location may
 *     indicate the location of the scene in the query image, and another the
 *     location of the place where the query image was taken. Location
 *     information is usually present for landmarks.
 *
 *     Example:
 *     ```
 *     print_r($text->locations());
 *     ```
 *
 *     @return array
 * }
 * @method properties() {
 *     Some entities can have additional optional Property fields. For example a
 *     different kind of score or string that qualifies the entity.
 *
 *     Example:
 *     ```
 *     print_r($text->properties());
 *     ```
 *
 *     @return array
 * }
 * @method info() {
 *     Get the raw annotation result
 *
 *     Example:
 *     ```
 *     $info = $text->info();
 *     ```
 *
 *     @return array
 * }
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#entityannotation EntityAnnotation
 * @codingStandardsIgnoreEnd
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
class Entity extends AbstractFeature
{
    use CallTrait;

    /**
     * Create an entity annotation result.
     *
     * This class is created internally by {@see Annotation} and is used to represent various
     * annotation feature results.
     *
     * This class should not be instantiated externally.
     *
     * Entities are returned by {@see Annotation::landmarks()},
     * {@see Annotation::logos()},
     * {@see Annotation::labels()} and
     * {@see Annotation::text()}.
     *
     * @param array $info The entity annotation result
     */
    public function __construct(array $info)
    {
        $this->info = $info;

        $class = get_class($this);
        $err = "The class {$class} is no longer supported";
        @trigger_error($err, E_USER_DEPRECATED);
    }
}
