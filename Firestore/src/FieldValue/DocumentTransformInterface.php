<?php
/**
 * Copyright 2018 Google LLC
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
 * Represents a DocumentTransform value.
 *
 * A DocumentTransformInterface instance defines the structure of a
 * {@see Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform}
 * message. `$key` defines the `oneof transformType` key, and `$args` defines
 * the transformType message data.
 */
interface DocumentTransformInterface extends FieldValueInterface
{
    /**
     * Get the transform key.
     *
     * @return string
     */
    public function key();

    /**
     * Get the transform arguments.
     *
     * @return mixed
     */
    public function args();

    /**
     * Whether the argument should be mapped or sent as given.
     *
     * @return bool
     */
    public function sendRaw();
}
