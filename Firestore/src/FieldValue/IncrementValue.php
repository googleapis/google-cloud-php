<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Firestore\FieldValue;

/**
 * Represents an increment DocumentTransform.
 *
 * This class is not intended to be used directly. See
 * {@see Google\Cloud\Firestore\FieldValue::increment()} for usage.
 *
 * @internal
 */
class IncrementValue implements DocumentTransformInterface
{
    use DocumentTransformTrait;

    /**
     * @access private
     * @return string
     */
    public function key()
    {
        return 'increment';
    }

    /**
     * @access private
     * @return bool
     */
    public function includeInUpdateMask()
    {
        return false;
    }

    /**
     * @access private
     * @return bool
     */
    public function sendRaw()
    {
        return false;
    }
}
