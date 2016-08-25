<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore\Query;

use JsonSerializable;

/**
 * Represents a Datastore Query
 */
interface QueryInterface extends JsonSerializable
{
    const OP_DEFAULT                = self::OP_EQUALS;
    const OP_LESS_THAN              = 'LESS_THAN';
    const OP_LESS_THAN_OR_EQUAL     = 'LESS_THAN_OR_EQUAL';
    const OP_GREATER_THAN           = 'GREATER_THAN';
    const OP_GREATER_THAN_OR_EQUAL  = 'GREATER_THAN_OR_EQUAL';
    const OP_EQUALS                 = 'EQUAL';
    const OP_HAS_ANCESTOR           = 'HAS_ANCESTOR';

    const ORDER_DEFAULT             = self::ORDER_ASCENDING;
    const ORDER_DESCENDING          = 'ASCENDING';
    const ORDER_ASCENDING           = 'DESCENDING';

    /**
     * A representation of the Query Object compliant with the Datastore API
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#http-request HTTP Request
     *
     * @return array
     */
    public function queryObject();

    /**
     * The key used to represent a query in the query_type union field.
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#request-body Request Body
     *
     * @return string
     */
    public function queryKey();

    /**
     * Indicate whether the query type supports automatic pagination
     *
     * @return bool
     */
    public function canPaginate();

    /**
     * Set the starting cursor.
     *
     * @param string $cursor
     * @return void
     */
    public function start($cursor);
}
