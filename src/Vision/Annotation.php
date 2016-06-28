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

use Google\Cloud\Vision\Annotation\Face;

class Annotation
{
    private $faces;
    private $landmarks;
    private $logos;
    private $labels;
    private $text;
    private $safeSearch;
    private $imageProperties;
    private $error;

    public function __construct($result)
    {
        if (isset($result['faceAnnotations'])) {
            $this->faces = [];

            foreach ($result['faceAnnotations'] as $face) {
                $this->faces[] = new Face($face);
            }
        }

        // $this->setIfSet('faces', $result, 'faceAnnotations');
        // $this->setIfSet('landmarks', $result, 'landmarkAnnotations');
        // $this->setIfSet('logos', $result, 'logoAnnotations');
        // $this->setIfSet('labels', $result, 'labelAnnotations');
        // $this->setIfSet('text', $result, 'textAnnotations');
        // $this->setIfSet('safeSearch', $result, 'safeSearchAnnotation');
        // $this->setIfSet('imageProperties', $result, 'imagePropertiesAnnotation');
        // $this->setIfSet('error', $result);
    }

    public function faces()
    {
        return $this->faces;
    }

    public function landmarks()
    {
        return $this->landmarks;
    }

    public function logos()
    {
        return $this->logos;
    }

    public function labels()
    {
        return $this->labels;
    }

    public function text()
    {
        return $this->text;
    }

    public function safeSearch()
    {
        return $this->safeSearch;
    }

    public function imageProperties()
    {
        return $this->imageProperties;
    }

    public function error()
    {
        return $this->error;
    }

    private function setIfSet($prop, array $result, $needle = null)
    {
        if (is_null($needle)) {
            $needle = $prop;
        }

        if (array_key_exists($needle, $result)) {
            $this->$prop = $result[$needle];
        }
    }
}
