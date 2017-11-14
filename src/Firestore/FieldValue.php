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
 * Contains special field values for Cloud Firestore.
 *
 * This class cannot be instantiated, and methods contained within it should be
 * accessed statically.
 */
class FieldValue
{
    /**
     * @access private
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Prevent instantiation of this class.
    }

    /**
     * Denotes a field which should be deleted from a Firestore Document.
     *
     * This special value, when used as a field value on update calls, will
     * cause the field to be entirely deleted from Cloud Firestore.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldValue;
     * use Google\Cloud\Firestore\FirestoreClient;
     *
     * $firestore = new FirestoreClient;
     * $document = $firestore->document('users/dave');
     * $document->update([
     *     ['path' => 'hometown', 'value' => FieldValue::deleteField()]
     * ]);
     * ```
     *
     * @return string
     */
    public static function deleteField()
    {
        return '___google-cloud-php__deleteField___';
    }

    /**
     * Denotes a field which should be set to the server timestamp.
     *
     * This special value, when used as a field value on create, update or set
     * calls, will cause the field value to be set to the current server
     * timestamp.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldValue;
     * use Google\Cloud\Firestore\FirestoreClient;
     *
     * $firestore = new FirestoreClient;
     * $document = $firestore->document('users/dave');
     * $document->update([
     *     ['path' => 'lastLogin', 'value' => FieldValue::serverTimestamp()]
     * ]);
     * ```
     *
     * @return string
     */
    public static function serverTimestamp()
    {
        return '___google-cloud-php__serverTimestamp___';
    }
}
