<?php
/**
 * Copyright 2026 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\BigQuery;

class TableMetadataView
{
    /**
     * Includes basic table information including schema and partitioning specification.
     * This view does not include storage statistics such as numRows or numBytes.
     * This view is significantly more efficient and should be used to support high query rates.
     */
    public const BASIC = 'BASIC';

    /**
     * Includes all table information, including storage statistics.
     * It returns same information as STORAGE_STATS view, but may contain additional information in the future.
     */
    public const FULL = 'FULL';

    /**
     * Includes all information in the BASIC view as well as storage statistics
     * (numBytes, numLongTermBytes, numRows and lastModifiedTime).
     */
    public const STORAGE_STATS = 'STORAGE_STATS';

    /**
     * The default value. Default to the STORAGE_STATS view.
     */
    public const UNSPECIFIED = 'TABLE_METADATA_VIEW_UNSPECIFIED';
}
