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

use Google\Cloud\Vision\Annotation\AbstractFeature;

/**
 * Describes landmarks on a face (eyes, nose, chin, etc).
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, ['FACE_DETECTION']);
 * $annotation = $vision->annotate($image);
 *
 * $faces = $annotation->faces();
 * $firstFace = $faces[0];
 *
 * $landmarks = $firstFace->landmarks();
 * ```
 *
 * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#type_1 Face Landmark Types
 *
 * @method info() {
 *     Get the raw landmarks annotation result
 *
 *     Example:
 *     ```
 *     $info = $landmarks->info();
 *     ```
 *
 *     @return array
 * }
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
class Landmarks extends AbstractFeature
{
    /**
     * Create a landmarks results object.
     *
     * This class should not be instantiated directly. It is created internally
     * by the Cloud Vision service wrapper to represent FACE_DETECTION annotation
     * results and provide helpful convenience to users.
     *
     * @param  array $info The face landmark results
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }

    /**
     * Fetch the left eye position.
     *
     * Example:
     * ```
     * $pos = $landmarks->leftEye();
     * echo "x position: ". $pos['x'] . PHP_EOL;
     * echo "y position: ". $pos['y'] . PHP_EOL;
     * echo "z position: ". $pos['z'] . PHP_EOL;
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function leftEye()
    {
        return $this->getLandmark('LEFT_EYE');
    }

    /**
     * Fetch the left eye pupil position.
     *
     * Example:
     * ```
     * $pos = $landmarks->leftEyePupil();
     * echo "x position: ". $pos['x'] . PHP_EOL;
     * echo "y position: ". $pos['y'] . PHP_EOL;
     * echo "z position: ". $pos['z'] . PHP_EOL;
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function leftEyePupil()
    {
        return $this->getLandmark('LEFT_EYE_PUPIL');
    }

    /**
     * Fetch the left eye boundaries.
     *
     * This method returns an array with four keys: `left`, `right`, `top`, `bottom`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->leftEyeBoundaries();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function leftEyeBoundaries()
    {
        return [
            'left' => $this->getLandmark('LEFT_EYE_LEFT_CORNER'),
            'top' => $this->getLandmark('LEFT_EYE_TOP_BOUNDARY'),
            'right' => $this->getLandmark('LEFT_EYE_RIGHT_CORNER'),
            'bottom' => $this->getLandmark('LEFT_EYE_BOTTOM_BOUNDARY')
        ];
    }

    /**
     * Fetch the left eyebrow position.
     *
     * This method returns an array with three keys: `left`, `right`, `upperMidpoint`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->leftEyebrow();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function leftEyebrow()
    {
        return [
            'left' => $this->getLandmark('LEFT_OF_LEFT_EYEBROW'),
            'right' => $this->getLandmark('RIGHT_OF_LEFT_EYEBROW'),
            'upperMidpoint' => $this->getLandmark('LEFT_EYEBROW_UPPER_MIDPOINT')
        ];
    }

    /**
     * Fetch the right eye position.
     *
     * Example:
     * ```
     * $pos = $landmarks->rightEye();
     * echo "x position: ". $pos['x'] . PHP_EOL;
     * echo "y position: ". $pos['y'] . PHP_EOL;
     * echo "z position: ". $pos['z'] . PHP_EOL;
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function rightEye()
    {
        return $this->getLandmark('RIGHT_EYE');
    }

    /**
     * Fetch the right eye pupil position.
     *
     * Example:
     * ```
     * $pos = $landmarks->rightEyePupil();
     * echo "x position: ". $pos['x'] . PHP_EOL;
     * echo "y position: ". $pos['y'] . PHP_EOL;
     * echo "z position: ". $pos['z'] . PHP_EOL;
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function rightEyePupil()
    {
        return $this->getLandmark('RIGHT_EYE_PUPIL');
    }

    /**
     * Fetch the right eye boundaries.
     *
     * This method returns an array with four keys: `left`, `right`, `top`, `bottom`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->rightEyeBoundaries();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function rightEyeBoundaries()
    {
        return [
            'left' => $this->getLandmark('RIGHT_EYE_LEFT_CORNER'),
            'top' => $this->getLandmark('RIGHT_EYE_TOP_BOUNDARY'),
            'right' => $this->getLandmark('RIGHT_EYE_RIGHT_CORNER'),
            'bottom' => $this->getLandmark('RIGHT_EYE_BOTTOM_BOUNDARY')
        ];
    }

    /**
     * Fetch the right eyebrow position.
     *
     * This method returns an array with three keys: `left`, `right`, `upperMidpoint`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->rightEyebrow();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function rightEyebrow()
    {
        return [
            'left' => $this->getLandmark('LEFT_OF_RIGHT_EYEBROW'),
            'right' => $this->getLandmark('RIGHT_OF_RIGHT_EYEBROW'),
            'upperMidpoint' => $this->getLandmark('RIGHT_EYEBROW_UPPER_MIDPOINT')
        ];
    }

    /**
     * Get the position of the midpoint beteeen the eyes.
     *
     * Example:
     * ```
     * $pos = $landmarks->midpointBetweenEyes();
     * echo "x position: ". $pos['x'] . PHP_EOL;
     * echo "y position: ". $pos['y'] . PHP_EOL;
     * echo "z position: ". $pos['z'] . PHP_EOL;
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function midpointBetweenEyes()
    {
        return $this->getLandmark('MIDPOINT_BETWEEN_EYES');
    }

    /**
     * Get the position of the lips.
     *
     * This method returns an array with two keys: `upper` and `lower`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->lips();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function lips()
    {
        return [
            'upper' => $this->getLandmark('UPPER_LIP'),
            'lower' => $this->getLandmark('LOWER_LIP')
        ];
    }

    /**
     * Get the position of the mouth.
     *
     * This method returns an array with three keys: `left`, `right`, `center`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->mouth();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function mouth()
    {
        return [
            'left' => $this->getLandmark('MOUTH_LEFT'),
            'right' => $this->getLandmark('MOUTH_RIGHT'),
            'center' => $this->getLandmark('MOUTH_CENTER')
        ];
    }

    /**
     * Get the position of the nose.
     *
     * This method returns an array with four keys: `tip`, `bottomRight`, `bottomLeft`, `bottomCenter`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->nose();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
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
     * Get the position of the ears.
     *
     * This method returns an array with two keys: `left` and `right`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->ears();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @todo should this be earTragions?
     * @return array
     */
    public function ears()
    {
        return [
            'left' => $this->getLandmark('LEFT_EAR_TRAGION'),
            'right' => $this->getLandmark('RIGHT_EAR_TRAGION')
        ];
    }

    /**
     * Get the position of the forehead glabella.
     *
     * Example:
     * ```
     * $pos = $landmarks->forehead();
     * echo "x position: ". $pos['x'] . PHP_EOL;
     * echo "y position: ". $pos['y'] . PHP_EOL;
     * echo "z position: ". $pos['z'] . PHP_EOL;
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
    public function forehead()
    {
        return $this->getLandmark('FOREHEAD_GLABELLA');
    }

    /**
     * Get the position of the chin.
     *
     * This method returns an array with three keys: `left`, `right`, `gnathion`.
     * The value of each of these keys is of the normal Position format described
     * in the Cloud Vision documentation.
     *
     * Example:
     * ```
     * $positions = $landmarks->chin();
     * foreach ($positions as $name => $pos) {
     *     echo "Position Type: ". $name . PHP_EOL;
     *     echo "x position: ". $pos['x'] . PHP_EOL;
     *     echo "y position: ". $pos['y'] . PHP_EOL;
     *     echo "z position: ". $pos['z'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#position Position
     *
     * @return array
     */
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
        $result = array_filter($this->info, function ($landmark) use ($type) {
            return $type === $landmark['type'];
        });

        return array_shift($result)['position'];
    }
}
