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

use Google\Cloud\Vision\Annotation\Entity;
use Google\Cloud\Vision\Annotation\Face;
use Google\Cloud\Vision\Annotation\ImageProperties;
use Google\Cloud\Vision\Annotation\SafeSearch;

/**
 * Represents a Cloud Vision image annotation result
 */
class Annotation
{
    /**
     * @var array
     */
    private $result;

    /**
     * @var array
     */
    private $faces;

    /**
     * @var array
     */
    private $landmarks;

    /**
     * @var array
     */
    private $logos;

    /**
     * @var array
     */
    private $labels;

    /**
     * @var array
     */
    private $text;

    /**
     * @var SafeSearch
     */
    private $safeSearch;

    /**
     * @var ImageProperties
     */
    private $imageProperties;

    /**
     * @var array
     */
    private $error;

    /**
     * Create an annotation result.
     *
     * This class represents a single image annotation response from Cloud Vision. If multiple images were tested at
     * once, the result will be an array of Annotation instances.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder();
     * $vision = $cloud->vision();
     *
     * $image = $vision->image(fopen(__DIR__ .'/assets/family-photo.jpg', 'r', [ 'faces' ]);
     * $annotation = $vision->annotate($image);
     *
     * echo get_class($annotation); // Google\Cloud\Vision\Annotation
     * ```
     *
     * @param array $result The annotation result
     */
    public function __construct($result)
    {
        if (isset($result['faceAnnotations'])) {
            $this->faces = [];

            foreach ($result['faceAnnotations'] as $face) {
                $this->faces[] = new Face($face);
            }
        }

        if (isset($result['landmarkAnnotations'])) {
            $this->landmarks = [];

            foreach ($result['landmarkAnnotations'] as $landmark) {
                $this->landmarks[] = new Entity($landmark);
            }
        }

        if (isset($result['logoAnnotations'])) {
            $this->logos = [];

            foreach ($result['logoAnnotations'] as $logo) {
                $this->logos[] = new Entity($logo);
            }
        }

        if (isset($result['labelAnnotations'])) {
            $this->labels = [];

            foreach ($result['labelAnnotations'] as $label) {
                $this->labels[] = new Entity($label);
            }
        }

        if (isset($result['safeSearchAnnotation'])) {
            $this->safeSearch = new SafeSearch($result['safeSearchAnnotation']);
        }

        if (isset($result['imagePropertiesAnnotation'])) {
            $this->imageProperties = new ImageProperties($result['imagePropertiesAnnotation']);
        }

        if (isset($result['error'])) {
            $this->error = $result['error'];
        }
    }

    /**
     * Return raw annotation response array
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $info = $annotation->info();
     * ```
     *
     * @return array
     */
    public function info()
    {
        return $this->result;
    }

    /**
     * Return an array of faces
     *
     * Example:
     * ```
     * $annotation = $vision->annotate($image);
     * $faces = $annotation->faces();
     * $firstFace = $faces[0];
     * ```
     *
     * @return array
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
     * $
     * ```
     *
     * @return Entity[]
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
     * // Example here
     * ```
     *
     * @return Entity[]
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
     * // Example here
     * ```
     *
     * @return Entity[]
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
     * // Example here
     * ```
     *
     * @return Entity[]
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * Get the result of a safe search detection
     *
     * Example:
     * ```
     * // Example here
     * ```
     *
     * @return SafeSearch
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
     * // Example here
     * ```
     *
     * @return ImageProperties
     */
    public function imageProperties()
    {
        return $this->imageProperties;
    }

    /**
     * Get error information, if present
     *
     * Example:
     * ```
     * // Example here
     * ```
     *
     * @return array
     */
    public function error()
    {
        return $this->error;
    }
}
