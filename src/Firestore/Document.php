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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Represents a reference to a Firestore document.
 */
class Document
{
    use ArrayTrait;

    private $connection;
    private $valueMapper;
    private $name;

    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $name)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->name = $name;
    }

    public function create(array $fields = [], array $options = [])
    {
        return $this->connection->createDocument([
            'name' => $this->name,
            'fields' => $fields
        ] + $options);
    }

    public function set($key, $value, array $options = [])
    {}

    public function update(array $fields, array $options = [])
    {}

    public function delete(array $options = [])
    {}

    /**
     * Get a document snapshot.
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $mask A list of fields to return. If not set, returns all
     *           fields.
     * }
     * @return DocumentSnapshot
     */
    public function get(array $options = [])
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
}
