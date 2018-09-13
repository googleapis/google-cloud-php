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

use Google\Cloud\Firestore\FieldPath;

/**
 * Represents a special Field Value.
 *
 * A special field value which is handled by the client to accomplish a specific
 * task, such as field deletion. Instances of `FieldValueInterface` do not
 * enqueue a DocumentTransform mutation. to enqueue a transform, use
 * {@see Google\Cloud\Firestore\FieldValue\DocumentTransformInterface}.
 */
interface FieldValueInterface
{
    /**
     * Whether the value should be included in the update mask.
     *
     * @return bool
     */
    public function includeInUpdateMask();

    /**
     * Set the transform field path.
     *
     * @param FieldPath $fieldPath
     * @return void
     */
    public function setFieldPath(FieldPath $fieldPath);

    /**
     * Get the transform field path.
     *
     * @return FieldPath|null
     */
    public function fieldPath();
}
