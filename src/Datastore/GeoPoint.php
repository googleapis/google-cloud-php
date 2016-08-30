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

namespace Google\Cloud\Datastore;

use InvalidArgumentException;

class GeoPoint
{
    private $latitude;
    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function latitude()
    {
        $this->checkContext('latitude', func_get_args_array());
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        if (is_numeric($latitude)) {
            $latitude = (float) $latitude;
        }
        else {
            throw new InvalidArgumentException('Given latitude must be a float');
        }

        $this->latitude = $latitude;

        return $this;
    }

    public function longitude()
    {
        $this->checkContext('longitude', func_get_args_array());
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        if (is_numeric($longitude)) {
            $longitude = (float) $longitude;
        }
        else {
            throw new InvalidArgumentException('Given longitude must be a float');
        }

        $this->longitude = $longitude;

        return $this;
    }

    public function point()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

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
