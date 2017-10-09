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
 * Represents the data of a document at the time of retrieval.
 * A snapshot is immutable and may point to a non-existing document.
 *
 * Fields may be read in array-style syntax. Note that writing using array-style
 * syntax is NOT supported and will result in a `\BadMethodCallException`.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $document = $firestore->document('users/john');
 * $snapshot = $document->snapshot();
 * ```
 *
 * ```
 * // Fields are exposed via array-style accessors:
 * $bitcoinWalletValue = $snapshot['wallet']['cryptoCurrency']['bitcoin'];
 * ```
 */
class DocumentSnapshot implements \ArrayAccess
{
    /**
     * @var DocumentReference
     */
    private $reference;

    /**
     * @var array
     */
    private $info;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var bool
     */
    private $exists;

    /**
     * @param DocumentReference $reference The document which created the snapshot.
     * @param array $info Document information, such as create and update timestamps.
     * @param array $fields Document field data.
     * @param bool $exists Whether the document exists in the Firestore database.
     */
    public function __construct(DocumentReference $reference, array $info, array $fields, $exists)
    {
        $this->reference = $reference;
        $this->info = $info;
        $this->fields = $fields;
        $this->exists = $exists;
    }

    /**
     * Get the document which created the snapshot.
     *
     * Example:
     * ```
     * $reference = $snapshot->reference();
     * ```
     *
     * @return DocumentReference
     */
    public function reference()
    {
        return $this->reference;
    }

    /**
     * Get the document path.
     *
     * Example:
     * ```
     * $name = $snapshot->name();
     * ```
     *
     * @return string
     */
    public function name()
    {
        return $this->reference->name();
    }

    /**
     * Get the document identifier (i.e. the last path element).
     *
     * Example:
     * ```
     * $id = $snapshot->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->reference->id();
    }

    /**
     * Returns create and update timestamps.
     *
     * Example:
     * ```
     * $info = $snapshot->info();
     * ```
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * Returns document field data as an array.
     *
     * Example:
     * ```
     * $fields = $snapshot->fields();
     * ```
     *
     * @return array
     */
    public function fields()
    {
        return $this->fields;
    }

    /**
     * Returns true if the document exists in the database.
     *
     * Example:
     * ```
     * if ($snapshot->exists()) {
     *     echo "The document exists!";
     * }
     * ```
     *
     * @return bool
     */
    public function exists()
    {
        return $this->exists;
    }

    /**
     * Get a field by field path.
     *
     * A field path is a string containing the path to a specific field, at the
     * top level or nested, delimited by `.`. For instance, the structured field
     * `{ "foo" : { "bar" : "hello" }}` would be represented by the field path
     * `foo.bar`.
     *
     * Example:
     * ```
     * $bitcoinWalletValue = $snapshot->get('wallet.cryptoCurrency.bitcoin');
     * ```
     *
     * @param string $fieldPath The field path to return.
     * @return mixed
     * @throws \InvalidArgumentException if the field path does not exist.
     *
     * @todo support quoted and escaped field path pieces
     */
    public function get($fieldPath)
    {
        $parts = explode('.', $fieldPath);
        $len = count($parts);

        $res = null;

        $fields = $this->fields;
        foreach ($parts as $idx => $part) {
            if ($idx === $len-1 && isset($fields[$part])) {
                $res = $fields[$part];
                break;
            } else {
                if (!isset($fields[$part])) {
                    throw new \InvalidArgumentException('field path does not exist.');
                }

                $fields = $fields[$part];
            }
        }

        return $res;
    }

    /**
     * @access private
     */
    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('DocumentSnapshots are read-only.');
    }

    /**
     * @access private
     */
    public function offsetExists($offset)
    {
        return isset($this->fields[$offset]);
    }

    /**
     * @access private
     */
    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException('DocumentSnapshots are read-only.');
    }

    /**
     * @access private
     */
    public function offsetGet($offset)
    {
        return isset($this->fields[$offset])
            ? $this->fields[$offset]
            : null;
    }
}
