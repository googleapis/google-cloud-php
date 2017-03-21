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

namespace Google\Cloud\Vision\Annotation\Web;

use Google\Cloud\Core\CallTrait;
use Google\Cloud\Vision\Annotation\AbstractFeature;

/**
 * Represents an Entity deduced from similar images on the Internet.
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/eiffel-tower.jpg', 'r');
 * $image = $vision->image($imageResource, ['WEB_DETECTION']);
 * $annotation = $vision->annotate($image);
 *
 * $entities = $annotation->web()->entities();
 * $firstEntity = $entities[0];
 * ```
 *
 * @method entityId() {
 *     The Entity ID
 *
 *     Example:
 *     ```
 *     $id = $entity->entityId();
 *     ```
 *
 *     @return string
 * }
 * @method score() {
 *     Overall relevancy score for the image.
 *
 *     Not normalized and not comparable across different image queries.
 *
 *     Example:
 *     ```
 *     $score = $entity->score();
 *     ```
 *
 *     @return float
 * }
 * @method description() {
 *     Canonical description of the entity, in English.
 *
 *     Example:
 *     ```
 *     $description = $entity->description();
 *     ```
 *
 *     @return string
 * }
 *
 * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#WebEntity WebEntity
 */
class WebEntity extends AbstractFeature
{
    use CallTrait;

    /**
     * @param array $info WebEntity info
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }
}
