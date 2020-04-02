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

namespace Google\Cloud\Vision;

use Google\Cloud\Vision\Annotation\CropHint;
use Google\Cloud\Vision\Annotation\Document;
use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Annotation\SafeSearch;
use Google\Cloud\Vision\Annotation\Web;

/**
 * Represents a [Google Cloud Vision](https://cloud.google.com/vision) image
 * annotation result.
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [
 *     'FACE_DETECTION'
 * ]);
 *
 * $annotation = $vision->annotate($image);
 * ```
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
class Annotation
{
    /**
     * @var array
     */
    private $info;

    /**
     * @var Face[]|null
     */
    private $faces;

    /**
     * @var Entity[]|null
     */
    private $landmarks;

    /**
     * @var Entity[]|null
     */
    private $logos;

    /**
     * @var Entity[]|null
     */
    private $labels;

    /**
     * @var Entity[]|null
     */
    private $text;

    /**
     * @var Document|null
     */
    private $fullText;

    /**
     * @var SafeSearch|null
     */
    private $safeSearch;

    /**
     * @var ImageProperties|null
     */
    private $imageProperties;

    /**
     * @var CropHint[]|null
     */
    private $cropHints;

    /**
     * @var Web|null
     */
    private $web;

    /**
     * @var array|null
     */
    private $error;

    /**
     * Create an annotation result.
     *
     * This class represents a single image annotation response from Cloud Vision. If multiple images were tested at
     * once, the result will be an array of Annotation instances.
     *
     * This class is not intended to be instantiated outside the Google Cloud Platform Client Library.
     *
     * @param array $info The annotation result
     */
    public function __construct($info)
    {
        $this->info = $info;

        if (isset($info['faceAnnotations'])) {
            $this->faces = [];

            foreach ($info['faceAnnotations'] as $face) {
                $this->faces[] = new Face($face);
            }
        }

        if (isset($info['landmarkAnnotations'])) {
            $this->landmarks = [];

            foreach ($info['landmarkAnnotations'] as $landmark) {
                $this->landmarks[] = new Entity($landmark);
            }
        }

        if (isset($info['logoAnnotations'])) {
            $this->logos = [];

            foreach ($info['logoAnnotations'] as $logo) {
                $this->logos[] = new Entity($logo);
            }
        }

        if (isset($info['labelAnnotations'])) {
            $this->labels = [];

            foreach ($info['labelAnnotations'] as $label) {
                $this->labels[] = new Entity($label);
            }
        }

        if (isset($info['textAnnotations'])) {
            $this->text = [];

            foreach ($info['textAnnotations'] as $text) {
                $this->text[] = new Entity($text);
            }
        }

        if (isset($info['fullTextAnnotation'])) {
            $this->fullText = new Document($info['fullTextAnnotation']);
        }

        if (isset($info['safeSearchAnnotation'])) {
            $this->safeSearch = new SafeSearch($info['safeSearchAnnotation']);
        }

        if (isset($info['imagePropertiesAnnotation'])) {
            $this->imageProperties = new ImageProperties($info['imagePropertiesAnnotation']);
        }

        if (isset($info['cropHintsAnnotation']) && is_array($info['cropHintsAnnotation']['cropHints'])) {
            $this->cropHints = [];
            foreach ($info['cropHintsAnnotation']['cropHints'] as $hint) {
                $this->cropHints[] = new CropHint($hint);
            }
        }

        if (isset($info['webDetection'])) {
            $this->web = new Web($info['webDetection']);
        }

        if (isset($info['error'])) {
            $this->error = $info['error'];
        }

        $class = get_class($this);
        $err = "The class {$class} is no longer supported";
        @trigger_error($err, E_USER_DEPRECATED);
    }

    /**
     * Return raw annotation response array
     *
     * Example:
     * ```
     * $info = $annotation->info();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#annotateimageresponse AnnotateImageResponse
     * @codingStandardsIgnoreEnd
     *
     * @return array|null
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Return an array of faces
     *
     * Example:
     * ```
     * $faces = $annotation->faces();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#FaceAnnotation FaceAnnotation
     *
     * @return Face[]|null
     */
    public function faces()
    {
        return $this->faces;
    }

    /**
     * Return an array of landmarks
     *
     * Example:
     * ```
     * $landmarks = $annotation->landmarks();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#EntityAnnotation EntityAnnotation
     *
     * @return Entity[]|null
     */
    public function landmarks()
    {
        return $this->landmarks;
    }

    /**
     * Return an array of logos
     *
     * Example:
     * ```
     * $logos = $annotation->logos();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#EntityAnnotation EntityAnnotation
     *
     * @return Entity[]|null
     */
    public function logos()
    {
        return $this->logos;
    }

    /**
     * Return an array of labels
     *
     * Example:
     * ```
     * $labels = $annotation->labels();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#EntityAnnotation EntityAnnotation
     *
     * @return Entity[]|null
     */
    public function labels()
    {
        return $this->labels;
    }

    /**
     * Return an array containing all text found in the image
     *
     * Example:
     * ```
     * $text = $annotation->text();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#EntityAnnotation EntityAnnotation
     *
     * @return Entity[]|null
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * Return the full text annotation.
     *
     * Example:
     * ```
     * $fullText = $annotation->fullText();
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#fulltextannotation FullTextAnnotation
     *
     * @return Document|null
     */
    public function fullText()
    {
        return $this->fullText;
    }

    /**
     * Get the result of a safe search detection
     *
     * Example:
     * ```
     * $safeSearch = $annotation->safeSearch();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#SafeSearchAnnotation SafeSearchAnnotation
     * @codingStandardsIgnoreEnd
     *
     * @return SafeSearch|null
     */
    public function safeSearch()
    {
        return $this->safeSearch;
    }

    /**
     * Fetch image properties
     *
     * Example:
     * ```
     * $properties = $annotation->imageProperties();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#ImageProperties ImageProperties
     *
     * @return ImageProperties|null
     */
    public function imageProperties()
    {
        return $this->imageProperties;
    }

    /**
     * Fetch Crop Hints
     *
     * Example:
     * ```
     * $hints = $annotation->cropHints();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#CropHintsAnnotation CropHintsAnnotation
     * @codingStandardsIgnoreEnd
     *
     * @return CropHint[]|null
     */
    public function cropHints()
    {
        return $this->cropHints;
    }

    /**
     * Fetch the Web Annotatation.
     *
     * Example:
     * ```
     * $web = $annotation->web();
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate#WebDetection WebDetection
     *
     * @return Web|null
     */
    public function web()
    {
        return $this->web;
    }

    /**
     * Get error information, if present
     *
     * Example:
     * ```
     * $error = $annotation->error();
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#status Status Format
     *
     * @return array|null
     */
    public function error()
    {
        return $this->error;
    }
}
