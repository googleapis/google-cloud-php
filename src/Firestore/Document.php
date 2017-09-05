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

use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Represents a reference to a Firestore document.
 */
class Document
{
    // Sentinel values, chosen for uniqueness and extreme unlikeliness to match any real field value.
    const DELETE_FIELD = '___google-cloud-php__deleteField___';
    const SERVER_TIMESTAMP = '___google-cloud-php__serverTimestamp___';

    use OperationTrait;
    use DebugInfoTrait;
    use PathTrait;

    private $connection;
    private $valueMapper;
    private $name;

    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $name)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->name = $name;
    }

    public function parent()
    {
        return new Collection($this->connection, $this->valueMapper, $this->parentPath($this->name));
    }

    /**
     * Create a new document in Firestore. If the document already exists, this method will fail.
     *
     * @param array $fields
     * @param array $options
     * @return array
     * @throws \Google\Cloud\Core\Exception\ConflictException
     */
    public function create(array $fields = [], array $options = [])
    {
        $writer = new WriteBatch($this->valueMapper, $this->databaseName($this->name));
        $writer->update($this->name, $fields, [
            'currentDocument' => ['exists' => false]
        ]);

        return $this->commitWrites($writer, $options);
    }

    /**
     * Replace all fields in a Firestore document.
     *
     * @param array $fields
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $precondition An optional precondition on the document. If
     *           this is set and not met by the target document, the write will
     *           fail. Allowed arguments are `(bool) $exists` and
     *           {@see Google\Cloud\Core\Timestamp} `$updateTime`.
     *           To completely disable precondition checks, provide an empty array
     *           as the value of `$precondition`. **Defaults to**
     *           `['exists' => true]` (i.e. Document must exist in Firestore).
     * }
     * @return array
     * @throws \Google\Cloud\Core\Exception\ConflictException If the
     *         precondition is not met.
     */
    public function set(array $fields, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true],
            'updateMask' => []
        ];

        $writer = new WriteBatch($this->valueMapper, $this->databaseName($this->name));
        $writer->update($this->name, $fields, [
            'currentDocument' => $this->pluck('precondition', $options)
        ]);

        return $this->commitWrites($writer, $options);
    }

    /**
     * Update a Firestore document. Merges provided data with data stored in Firestore.
     *
     * By default, this method will fail if the document does not exist.
     *
     * @param array $fields
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $precondition An optional precondition on the document. If
     *           this is set and not met by the target document, the write will
     *           fail. Allowed arguments are `(bool) $exists` and
     *           {@see Google\Cloud\Core\Timestamp} `$updateTime`.
     *           To completely disable precondition checks, provide an empty array
     *           as the value of `$precondition`. **Defaults to**
     *           `['exists' => true]` (i.e. Document must exist in Firestore).
     * }
     * @return array
     * @throws \Google\Cloud\Core\Exception\ConflictException If the
     *         precondition is not met.
     */
    public function update(array $fields, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true]
        ];

        $writer = new WriteBatch($this->valueMapper, $this->databaseName($this->name));
        $writer->update($this->name, $fields, [
            'currentDocument' => $this->pluck('precondition', $options)
        ]);

        return $this->commitWrites($writer, $options);
    }

    /**
     * Delete a Firestore document.
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $precondition An optional precondition on the document. If
     *           this is set and not met by the target document, the write will
     *           fail. Allowed arguments are `(bool) $exists` and
     *           {@see Google\Cloud\Core\Timestamp} `$updateTime`.
     *           To completely disable precondition checks, provide an empty array
     *           as the value of `$precondition`. **Defaults to**
     *           `['exists' => true]` (i.e. Document must exist in Firestore).
     * }
     * @return array
     * @throws \Google\Cloud\Core\Exception\ConflictException If the
     *         precondition is not met.
     */
    public function delete(array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true]
        ];

        $writer = new WriteBatch($this->valueMapper, $this->databaseName($this->name));
        $writer->delete($this->name, [
            'currentDocument' => $this->pluck('precondition', $options)
        ]);

        return $this->commitWrites($writer, $options);
    }

    /**
     * Get a read-only snapshot of the document.
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $mask A list of fields to return. If not set, returns all
     *           fields.
     * }
     * @return DocumentSnapshot
     */
    public function snapshot(array $options = [])
    {
        $exists = true;
        $document = [];
        $fields = [];

        try {
            $document = $this->connection->getDocument([
                'name' => $this->name,
            ] + $options);

            $fields = $this->valueMapper->decodeValues(
                $this->pluck('fields', $document)
            );
        } catch (NotFoundException $e) {
            $exists = false;
        }

        return new DocumentSnapshot($this->name, $document, $fields, $exists);
    }

    public function collection($collectionId)
    {
        return new Collection($this->connection, $this->valueMapper, $this->childPath($this->name, $collectionId));
    }

    public function collections(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        return new ItemIterator(
            new PageIterator(
                function ($collectionId) {
                    return new Collection($this->connection, $this->valueMapper, $this->childPath($this->name, $collectionId));
                },
                [$this->connection, 'listCollectionIds'],
                $options + ['parent' => $this->name],
                [
                    'itemsKey' => 'collectionIds',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }
}
