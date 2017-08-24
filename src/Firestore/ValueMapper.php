<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\ValueMapperTrait;

class ValueMapper
{
    use ValueMapperTrait;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @param bool $returnInt64AsObject
     */
    public function __construct($returnInt64AsObject)
    {
        $this->returnInt64AsObject = $returnInt64AsObject;
    }

    public function decodeValues(array $fields)
    {
        $output = [];

        foreach ($fields as $key => $val) {
            $type = array_keys($val)[0];
            $value = current($val);

            $output[$key] = $this->decodeValue($type, $value);
        }

        return $output;
    }

    public function encodeValues()
    {}

    private function decodeValue($type, $value)
    {
        switch ($type) {
            case 'stringValue' :
                return $value;
                break;

            case 'timestampValue' :
                return $this->createTimestampWithNanos($value);
                break;

            default :
                return $value;
                break;
        }
    }
}
