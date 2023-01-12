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

if (false) {
/**
 * Enqueue and write multiple mutations to Cloud Firestore.
 *
 * This class may be used directly for multiple non-transactional writes. To
 * run changes in a transaction (with automatic retry/rollback on failure),
 * use {@see Google\Cloud\Firestore\Transaction}. Single modifications can be
 * made using the various methods on {@see Google\Cloud\Firestore\DocumentReference}.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $batch = $firestore->batch();
 * ```
 * This class is deprecated. Use Google\Cloud\Firestore\BulkWriter instead.
 * @deprecated
 */
    class WriteBatch
    {
    }
}

class_alias(BulkWriter::class, WriteBatch::class);
@trigger_error(
    "Google\Cloud\Firestore\WriteBatch is deprecated and will be removed in the next major release.
    Use Google\Cloud\Firestore\BulkWriter instead",
    E_USER_DEPRECATED
);
