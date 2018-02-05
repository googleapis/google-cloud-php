<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner;

/**
 * A special value which, when used, will set the field value to the value of
 * the commit timestamp.
 *
 * Cloud Spanner allows users to designate a specific Timestamp column in the
 * table schema to contain commit timestamps. When writing to this column, a
 * manually-created timestamp (in the past) may be supplied, or Cloud Spanner
 * can populate it server-side.
 *
 * Note that this special value cannot be used unless the column has been
 * annotated with support for commit timestamps:
 *
 * ```
 * CREATE TABLE myTable (
 *     id STRING(100) NOT NULL,
 *     commitTimestamp TIMESTAMP NOT NULL OPTIONS
 *         (allow_commit_timestamp=true)
 * ) PRIMARY KEY(id, commitTimestamp DESC)
 * ```
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $database->insert('myTable', [
 *     'id' => $id,
 *     'commitTimestamp' => $spanner->commitTimestamp()
 * ]);
 * ```
 */
class CommitTimestamp implements ValueInterface
{
    const SPECIAL_VALUE = 'spanner.commit_timestamp()';

    /**
     * @access private
     */
    public function type()
    {
        return Database::TYPE_TIMESTAMP;
    }

    /**
     * @access private
     */
    public function get()
    {
        return self::SPECIAL_VALUE;
    }

    /**
     * @access private
     */
    public function formatAsString()
    {
        return self::SPECIAL_VALUE;
    }

    /**
     * @access private
     */
    public function __toString()
    {
        return self::SPECIAL_VALUE;
    }
}
