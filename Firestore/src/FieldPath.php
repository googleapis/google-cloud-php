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

/**
 * Represents a path to a Firestore Document field.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $path = $firestore->fieldPath(['accounts', 'usd']);
 * ```
 */
class FieldPath
{
    private $fieldNames;

    /**
     * @param array $fieldNames A list of field names.
     */
    public function __construct(array $fieldNames)
    {
        $this->fieldNames = $fieldNames;
    }

    /**
     * Get the path elements.
     *
     * @access private
     * @return array
     */
    public function path()
    {
        return $this->fieldNames;
    }

    /**
     * Create a FieldPath from a string path.
     *
     * @param string $path
     * @return FieldPath
     * @access private
     */
    public static function fromString($path)
    {
        return new self(explode('.', $path));
    }
}
