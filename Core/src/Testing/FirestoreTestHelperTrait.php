<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Core\Testing;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;

/**
 * Contains all the helper methods specific to testing in Firestore library.
 *
 * @internal
 */
trait FirestoreTestHelperTrait
{
    use ApiHelperTrait;

    private static $_serializer;

    /**
     * @return Serializer
     */
    private function getSerializer()
    {
        if (!self::$_serializer) {
            self::$_serializer = new Serializer([], [
                'google.protobuf.Value' => function ($v) {
                    return $this->flattenValue($v);
                },
                'google.protobuf.ListValue' => function ($v) {
                    return $this->flattenListValue($v);
                },
                'google.protobuf.Struct' => function ($v) {
                    return $this->flattenStruct($v);
                },
            ]);
        }

        return self::$_serializer;
    }
}
