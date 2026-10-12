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

use Google\Cloud\Firestore\FieldValue\ArrayRemoveValue;
use Google\Cloud\Firestore\FieldValue\ArrayUnionValue;
use Google\Cloud\Firestore\FieldValue\DeleteFieldValue;
use Google\Cloud\Firestore\FieldValue\IncrementValue;
use Google\Cloud\Firestore\FieldValue\ServerTimestampValue;

/**
 * Provides special field values for Cloud Firestore.
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
     *     [
     *         'path' => 'hometown',
     *         'value' => FieldValue::deleteField()
     *     ]
     * ]);
     * ```
     *
     * @return DeleteFieldValue
     */
    public static function deleteField()
    {
        return new DeleteFieldValue();
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
     *     [
     *         'path' => 'lastLogin',
     *         'value' => FieldValue::serverTimestamp()
     *     ]
     * ]);
     * ```
     *
     * @return ServerTimestampValue
     */
    public static function serverTimestamp()
    {
        return new ServerTimestampValue();
    }

    /**
     * Returns a special value that can be used with set(), create() or update()
     * that tells the server to union the given elements with any array value
     * that already exists on the server. Each specified element that doesn't
     * already exist in the array will be added to the end. If the field being
     * modified is not already an array it will be overwritten with an array
     * containing exactly the specified elements.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldValue;
     * use Google\Cloud\Firestore\FirestoreClient;
     *
     * $firestore = new FirestoreClient;
     * $document = $firestore->document('users/dave');
     *
     * $document->update([
     *     [
     *         'path' => 'favoriteColors',
     *         'value' => FieldValue::arrayUnion(['red', 'blue'])
     *     ]
     * ]);
     * ```
     *
     * @param array $elements The elements to union into the array.
     * @return ArrayUnionValue
     */
    public static function arrayUnion(array $elements)
    {
        return new ArrayUnionValue($elements);
    }

    /**
     * Returns a special value that can be used with set(), create() or update()
     * that tells the server to remove the given elements from any array value
     * that already exists on the server. All instances of each element
     * specified will be removed from the array. If the field being modified is
     * not already an array it will be overwritten with an empty array.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldValue;
     * use Google\Cloud\Firestore\FirestoreClient;
     *
     * $firestore = new FirestoreClient;
     * $document = $firestore->document('users/dave');
     *
     * $document->update([
     *     [
     *         'path' => 'favoriteColors',
     *         'value' => FieldValue::arrayRemove(['green'])
     *     ]
     * ]);
     * ```
     *
     * @param array $elements The elements to remove from the array.
     * @return ArrayRemoveValue
     */
    public static function arrayRemove(array $elements)
    {
        return new ArrayRemoveValue($elements);
    }

    /**
     * Returns a special value that can be used with set() or update() that
     * tells the server to add the given value to the field's current value.
     *
     * Given value must be an integer or a double value. If the field is not an
     * integer or double, or if the field does not yet exist, the
     * transformation will set the field to the given value. If either of the
     * given value or the current field value are doubles, both values will be
     * interpreted as doubles. Double arithmetic and representation of double
     * values follow IEEE 754 semantics. If there is positive/negative integer
     * overflow, the field is resolved to the largest magnitude
     * positive/negative integer.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\FieldValue;
     * use Google\Cloud\Firestore\FirestoreClient;
     *
     * $firestore = new FirestoreClient;
     * $document = $firestore->document('users/dave');
     *
     * $document->update([
     *     [
     *         'path' => 'loginCount',
     *         'value' => FieldValue::increment(1)
     *     ]
     * ]);
     * ```
     *
     * @param int|float $value
     * @return IncrementValue
     */
    public static function increment($value)
    {
        return new IncrementValue($value);
    }
}
