<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

/**
 * Represents a Datastore Query.
 *
 * @see https://cloud.google.com/datastore/docs/concepts/queries Datastore Queries
 */
trait QueryTrait
{
    /**
     * A representation of the Query Object compliant with the Datastore API
     *
     * This method is used internally to run queries and is not intended for use
     * outside the internal library API
     *
     * @access private
     * @return array
     */
    public function queryObject()
    {
        if (is_string($this->query)) {
            // parse as a Gql Query
            return $this->gqlQueryObject();
        }
        if (is_array($this->query)) {
            // parse as a Standard Query
            return $this->standardQueryobject();
        }

        // parse as an Aggregation Query
        return $this->aggregationQueryObject();
    }
}
