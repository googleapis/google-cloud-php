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
 * Represents a Document Text Detection result.
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/the-constitution.jpg', 'r');
 * $image = $vision->image($imageResource, [ 'DOCUMENT_TEXT_DETECTION' ]);
 * $annotation = $vision->annotate($image);
 *
 * $document = $annotation->fullText();
 * ```
 *
 * @method pages() {
 *     Get the document pages.
 *
 *     Example:
 *     ```
 *     $pages = $document->pages();
 *     ```
 *
 *     @return array
 * }
 * @method text() {
 *     Get the document text.
 *
 *     Example:
 *     ```
 *     $text = $document->text();
 *     ```
 *
 *     @return string
 * }
 * @method info() {
 *     Get the Document Text detection result.
 *
 *     Example:
 *     ```
 *     $info = $document->info();
 *     ```
 *
 *     @return array
 * }
 *
 * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#TextAnnotation TextAnnotation
 */
class Document extends AbstractFeature
{
    use CallTrait;

    /**
     * @param array $info Document Text Annotation response.
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }
}
