<?php
/*
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/bigtable/v2/bigtable.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Bigtable\V2;

use Google\Cloud\Bigtable\V2\ChunkFormatter;
use Google\Cloud\Bigtable\V2\Gapic\BigtableGapicClient;

/**
 * {@inheritdoc}
 */
class BigtableClient extends BigtableGapicClient
{
    // This class is intentionally empty, and is intended to hold manual
    // additions to the generated {@see BigtableClientImpl} class.

    /**
     * Read rows from table.
     * @param string $table         The unique name of the table to be deleted.
     *                              Values are of the form
     *                              `projects/<project>/instances/<instance>/tables/<table>`.
     *
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RowSet $rows
     *          The row keys and/or ranges to read. If not specified, reads from all rows.
     *     @type RowFilter $filter
     *          The filter to apply to the contents of the specified row(s). If unset,
     *          reads the entirety of each row.
     *     @type int $rowsLimit
     *          The read will terminate after committing to N rows' worth of results. The
     *          default (zero) is to return all results.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     *
     * @return  \Google\Cloud\Bigtable\V2\ChunkFormatter
     */
    public function readRows($tableName, $optionalArgs = [])
    {
        $serverStream   = parent::readRows($tableName, $optionalArgs);
        $chunkFormatter = new ChunkFormatter($serverStream, $optionalArgs);
        return $chunkFormatter;
    }
}
