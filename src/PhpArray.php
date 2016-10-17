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

namespace Google\Cloud;

use DrSlump\Protobuf;

/**
 * Extend the Protobuf-PHP array codec to convert underscore keys
 * to the camelcase type expected by the library.
 */
class PhpArray extends Protobuf\Codec\PhpArray
{
    protected function encodeMessage(Protobuf\Message $message)
    {
        $res = parent::encodeMessage($message);

        return $this->transformKeys($res);
    }

    private function transformKeys(array $res)
    {
        $out = [];
        foreach ($res as $key => $val) {
            $newKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            if (is_array($val)) {
                $val = $this->transformKeys($val);
            }

            $out[$newKey] = $val;
        }

        return $out;
    }
}
