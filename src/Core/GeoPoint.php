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

namespace Google\Cloud\Core;

use InvalidArgumentException;

/**
 * Represents a geographical point.
 *
 * Unless specified otherwise, this must conform to the
 * [WGS84](http://www.unoosa.org/pdf/icg/2012/template/WGS_84.pdf) standard.
 * Values must be within normalized ranges.
 *
 * Example:
 * ```
 * use Google\Cloud\Core\GeoPoint;
 *
 * $point = new GeoPoint(37.423147, -122.085015);
 * ```
 */
class GeoPoint
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * Create a GeoPoint.
     *
     * Ints will be converted to floats. Values not passing the `is_numeric()`
     * check will result in an exception.
     *
     * @param float|int $latitude
     * @param float|int $longitude
     * @throws InvalidArgumentException
     */
    public function __construct($latitude, $longitude)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    /**
     * Get the latitude
     *
     * Example:
     * ```
     * $latitude = $point->latitude();
     * ```
     *
     * @return float
     */
    public function latitude()
    {
        $this->checkContext('latitude', func_get_args());
        return $this->latitude;
    }

    /**
     * Set the latitude
     *
     * Non-numeric values will result in an exception
     *
     * Example:
     * ```
     * $point->setLatitude(42.279594);
     * ```
     *
     * @param int|float $latitude The new latitude
     * @return GeoPoint
     * @throws InvalidArgumentException
     */
    public function setLatitude($latitude)
    {
        if (is_numeric($latitude)) {
            $latitude = (float) $latitude;
        } else {
            throw new InvalidArgumentException('Given latitude must be a float');
        }

        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get the longitude
     *
     * Example:
     * ```
     * $longitude = $point->longitude();
     * ```
     *
     * @return float
     */
    public function longitude()
    {
        $this->checkContext('longitude', func_get_args());
        return $this->longitude;
    }

    /**
     * Set the longitude
     *
     * Non-numeric values will result in an exception.
     *
     * Example:
     * ```
     * $point->setLongitude(-83.732124);
     * ```
     *
     * @param float|int $longitude The new longitude value
     * @return GeoPoint
     * @throws InvalidArgumentException
     */
    public function setLongitude($longitude)
    {
        if (is_numeric($longitude)) {
            $longitude = (float) $longitude;
        } else {
            throw new InvalidArgumentException('Given longitude must be a float');
        }

        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Return a GeoPoint
     *
     * Example:
     * ```
     * $point = $point->point();
     * ```
     *
     * @return array [LatLng](https://cloud.google.com/datastore/reference/rest/Shared.Types/LatLng)
     */
    public function point()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    /**
     * Let people know if they accidentally use the getter in setter context.
     *
     * @param string $method the method name
     * @param array $args The method arguments
     * @throws InvalidArgumentException
     * @return void
     */
    private function checkContext($method, array $args)
    {
        if (count($args) > 0) {
            throw new InvalidArgumentException(sprintf(
                'Calling method %s with arguments is unsupported.',
                $method
            ));
        }
    }
}
