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

namespace Google\Cloud\Vision\Annotation\Face;

class Landmarks
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function leftEye()
    {
        return $this->getLandmark('LEFT_EYE');
    }

    public function leftEyePupil()
    {
        return $this->getLandmark('LEFT_EYE_PUPIL');
    }

    public function leftEyeBoundaries()
    {
        return [
            'left' => $this->getLandmark('LEFT_EYE_LEFT_CORNER'),
            'top' => $this->getLandmark('LEFT_EYE_TOP_BOUNDARY'),
            'right' => $this->getLandmark('LEFT_EYE_RIGHT_CORNER'),
            'bottom' => $this->getLandmark('LEFT_EYE_BOTTOM_BOUNDARY')
        ];
    }

    public function leftEyebrow()
    {
        return [
            'left' => $this->getLandmark('LEFT_OF_LEFT_EYEBROW'),
            'right' => $this->getLandmark('RIGHT_OF_LEFT_EYEBROW'),
            'upperMidpoint' => $this->getLandmark('LEFT_EYEBROW_UPPER_MIDPOINT')
        ];
    }

    public function rightEye()
    {
        return $this->getLandmark('RIGHT_EYE');
    }

    public function rightEyePupil()
    {
        return $this->getLandmark('RIGHT_EYE_PUPIL');
    }

    public function rightEyeBoundaries()
    {
        return [
            'left' => $this->getLandmark('RIGHT_EYE_LEFT_CORNER'),
            'top' => $this->getLandmark('RIGHT_EYE_TOP_BOUNDARY'),
            'right' => $this->getLandmark('RIGHT_EYE_RIGHT_CORNER'),
            'bottom' => $this->getLandmark('RIGHT_EYE_BOTTOM_BOUNDARY')
        ];
    }

    public function rightEyebrow()
    {
        return [
            'left' => $this->getLandmark('LEFT_OF_RIGHT_EYEBROW'),
            'right' => $this->getLandmark('RIGHT_OF_RIGHT_EYEBROW'),
            'upperMidpoint' => $this->getLandmark('RIGHT_EYEBROW_UPPER_MIDPOINT')
        ];
    }

    public function midpointBetweenEyes()
    {
        return $this->getLandmark('MIDPOINT_BETWEEN_EYES');
    }

    public function lips()
    {
        return [
            'upper' => $this->getLandmark('UPPER_LIP'),
            'lower' => $this->getLandmark('LOWER_LIP')
        ];
    }

    public function mouth()
    {
        return [
            'left' => $this->getLandmark('MOUTH_LEFT'),
            'right' => $this->getLandmark('MOUTH_RIGHT'),
            'center' => $this->getLandmark('MOUTH_CENTER')
        ];
    }

    public function nose()
    {
        return [
            'tip' => $this->getLandmark('NOSE_TIP'),
            'bottomRight' => $this->getLandmark('NOSE_BOTTOM_RIGHT'),
            'bottomLeft' => $this->getLandmark('NOSE_BOTTOM_LEFT'),
            'bottomCenter' => $this->getLandmark('NOSE_BOTTOM_CENTER')
        ];
    }

    /**
     * @todo should this be earTragions?
     */
    public function ears()
    {
        return [
            'left' => $this->getLandmark('LEFT_EAR_TRAGION'),
            'right' => $this->getLandmark('RIGHT_EAR_TRAGION')
        ];
    }

    public function forehead()
    {
        return $this->getLandmark('FOREHEAD_GLABELLA');
    }

    public function chin()
    {
        return [
            'gnathion' => $this->getLandmark('CHIN_GNATHION'),
            'left' => $this->getLandmark('CHIN_LEFT_GONION'),
            'right' => $this->getLandmark('CHIN_RIGHT_GONION')
        ];
    }

    private function getLandmark($type)
    {
        $result = array_filter($this->result, function ($landmark) use ($type) {
            return $type === $landmark['type'];
        });

        return array_shift($result);
    }
}
