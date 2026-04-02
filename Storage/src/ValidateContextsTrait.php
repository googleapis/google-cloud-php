<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage;

/**
 * Trait which provides helper methods for validate the contexts.
 */
trait ValidateContextsTrait
{

    /**
    * @param array $contexts The contexts array to validate.
    * @return void
    */
    private function validateContexts(array $contexts)
    {
        if (!isset($contexts['custom'])) {
            return;
        }
        if (!is_array($contexts['custom'])) {
            throw new \InvalidArgumentException('Object contexts custom field must be an array.');
        }
        foreach ($contexts['custom'] as $key => $data) {
            if (!preg_match('/^[a-zA-Z0-9]/', (string) $key)) {
                throw new \InvalidArgumentException('Object context key must start with an alphanumeric.');
            }
            if (strpos((string) $key, '"') !== false) {
                throw new \InvalidArgumentException('Object context key cannot contain double quotes.');
            }
            if (!is_array($data)) {
                throw new \InvalidArgumentException(sprintf(
                    'Context data for key "%s" must be an array.',
                    $key
                ));
            }
            if (!isset($data['value'])) {
                throw new \InvalidArgumentException(sprintf(
                    'Context for key "%s" must have a \'value\' property.',
                    $key
                ));
            }
            if (!is_scalar($data['value'])) {
                throw new \InvalidArgumentException(sprintf(
                    'Context value for key "%s" must be a scalar type.',
                    $key
                ));
            }
            $val = (string) $data['value'];
            if ($val !== '' && !preg_match('/^[a-zA-Z0-9]/', $val)) {
                throw new \InvalidArgumentException('Object context value must start with an alphanumeric.');
            }
            if (strpos($val, '/') !== false || strpos($val, '"') !== false) {
                throw new \InvalidArgumentException('Object context value cannot contain forbidden characters.');
            }
        }
    }
}
