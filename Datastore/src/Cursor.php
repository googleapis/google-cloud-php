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

namespace Google\Cloud\Datastore;

/**
 * Represents a Cursor value.
 *
 * A cursor points to a position within a set of entities. Cloud Datastore uses
 * Cursors for paginating query results.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 * $cursor = $datastore->cursor($cursorValue);
 *
 * $query = $datastore->gqlQuery('SELECT * FROM Companies OFFSET @cursor', [
 *     'bindings' => [
 *         'cursor' => $cursor
 *     ]
 * ]);
 * ```
 */
class Cursor
{
    /**
     * @var string|int
     */
    private $cursor;

    /**
     * @param string|int $cursor The cursor value.
     */
    public function __construct($cursor)
    {
        $this->cursor = $cursor;
    }

    /**
     * @access private
     * @return string|int
     */
    public function cursor()
    {
        return $this->cursor;
    }
}
