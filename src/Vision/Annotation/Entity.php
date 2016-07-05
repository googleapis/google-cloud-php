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
 * Represents an entity annotation
 *
 * @method string mid() {
 *     Opaque entity ID.
 *
 *     Some IDs might be available in Knowledge Graph(KG).
 *
 *     @see https://developers.google.com/knowledge-graph/ Knowledge Graph
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->mid());
 *     ```
 * }
 * @method string locale() {
 *     The language code for the locale in which the entity textual description
 *     (next field) is expressed.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->locale());
 *     ```
 * }
 * @method string description() {
 *     Entity textual description, expressed in its locale language.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->description());
 *     ```
 * }
 * @method float score() {
 *     Overall score of the result.
 *
 *     Range [0, 1].
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->score());
 *     ```
 * }
 * @method float confidence() {
 *     The accuracy of the entity detection in an image.
 *
 *     For example, for an image containing 'Eiffel Tower,' this field
 *     represents the confidence that there is a tower in the query image.
 *
 *     Range [0, 1].
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->confidence());
 *     ```
 * }
 * @method float topicality() {
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
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->topicality());
 *     ```
 * }
 * @method array boundingPoly() {
 *     Image region to which this entity belongs.
 *
 *     Not filled currently for LABEL_DETECTION features. For TEXT_DETECTION
 *     (OCR), boundingPolys are produced for the entire text detected in an
 *     image region, followed by boundingPolys for each word within the detected
 *     text.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->boundingPoly());
 *     ```
 * }
 * @method array locations() {
 *     The location information for the detected entity.
 *
 *     Multiple LocationInfo elements can be present since one location may
 *     indicate the location of the scene in the query image, and another the
 *     location of the place where the query image was taken. Location
 *     information is usually present for landmarks.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->locations());
 *     ```
 * }
 * @method array properties() {
 *     Some entities can have additional optional Property fields. For example a
 *     different kind of score or string that qualifies the entity.
 *
 *     Example:
 *     ```
 *     $annotation = $vision->annotate($image);
 *     $text = $annotation->text()[0];
 *     print_r($text->properties());
 *     ```
 * }
 */
class Entity implements FeatureInterface
{
    use CallTrait;
    use FeatureTrait;

    /**
     * @var array
     */
    private $results;

    /**
     * Create an entity annotation result.
     *
     * This class is created internally by {@see Google\Cloud\Vision\Annotation} and is used to represent various
     * annotation feature results.
     *
     * This class should not be instantiated outside the gcloud-php library.
     *
     * Entities are returned by {@see Google\Cloud\Vision\Annotation::landmarks()},
     * {@see Google\Cloud\Vision\Annotation::logos()},
     * {@see Google\Cloud\Vision\Annotation::labels()} and
     * {@see Google\Cloud\Vision\Annotation::text()}.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder();
     * $vision = $cloud->vision();
     *
     * $image = $vision->image(fopen(__DIR__ .'/assets/family-photo.jpg', 'r'), [ 'imageProperties' ]);
     * $annotation = $vision->annotate($image);
     *
     * $landmarks = $annotation->landmarks();
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#entityannotation EntityAnnotation
     *
     * @param array $result The entity annotation result
     */
    public function __construct(array $results)
    {
        $this->results = $results;
    }
}
