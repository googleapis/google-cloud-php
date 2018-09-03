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
 * Common methods for special field values.
 */
trait FieldValueTrait
{
    /**
     * @var FieldPath|null
     */
    private $fieldPath;

    /**
     * Set the field path for the transform value.
     *
     * @param FieldPath $fieldPath The field path object.
     * @return void
     * @access private
     */
    public function setFieldPath(FieldPath $fieldPath)
    {
        $this->fieldPath = $fieldPath;
    }

    /**
     * Get the field path.
     *
     * @return FieldPath|null
     * @access private
     */
    public function fieldPath()
    {
        return $this->fieldPath;
    }
}
