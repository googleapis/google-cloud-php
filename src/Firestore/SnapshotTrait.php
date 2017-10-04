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
use Google\Cloud\Core\ValueMapperTrait;
use Google\Cloud\Core\Exception\NotFoundException;

/**
 * Methods common to representing Document Snapshots.
 */
trait SnapshotTrait
{
    use ArrayTrait;
    use PathTrait;

    /**
     * Create and return a document snapshot.
     *
     * If `$options['data']` is set, no service request will be triggered, and
     * the returned snapshot will indicate that the document does exist, and
     * will be populated with the data provided.
     *
     * @param DocumentReference $document The parent document.
     * @param array $options {
     *     Configuration Options
     *
     *     @type bool $exists If set to false, no service request will be
     *           triggered, and the returned snapshot will indicate that the
     *           document does not exist. **Defaults to** `false`.
     *     @type array $data If set, no service request will be triggered, and
     *           the returned snapshot will indicate that the document does
     *           exist, and will be populated with the data provided.
     *     @type string $transactionId The transaction ID to fetch the snapshot.
     *     @type bool $allowNonExistence If true, a DocumentSnapshot will be
     *           returned, even if the document does not exist. **Defaults to**
     *           `true`.
     * }
     * @return DocumentSnapshot
     * @throws NotFoundException If the document does not exist, and
     *         `$options['allowNonExistence'] is `false`.
     */
    private function createSnapshot(DocumentReference $document, array $options = [])
    {
        $options += [
            'exists' => true,
            'allowNonExistence' => true
        ];

        $exists = true;
        $data = [];
        $fields = [];

        $allowNonExistence = $this->pluck('allowNonExistence', $options);
        if ($this->pluck('exists', $options)) {
            try {
                $data = (isset($options['data']))
                    ? $options['data']
                    : $this->getSnapshot($document->name(), $options);

                $fields = $this->valueMapper->decodeValues(
                    $this->pluck('fields', $data)
                );

                $data = $this->transformSnapshotTimestamps($data);
            } catch (NotFoundException $e) {
                if (!$allowNonExistence) {
                    throw $e;
                }

                $exists = false;
            }
        } else {
            $exists = false;

            if (isset($options['data'])) {
                $data = $this->transformSnapshotTimestamps($options['data']);
            }
        }

        return new DocumentSnapshot($document, $data, $fields, $exists);
    }

    /**
     * Send a service request for a snapshot, and return the raw data
     *
     * @param string $name The document name.
     * @param array $options Configuration options.
     * @return array
     */
    private function getSnapshot($name, array $options = [])
    {
        $snapshot = current($this->connection->batchGetDocuments([
            'database' => $this->databaseFromName($name),
            'documents' => [$name],
        ] + $options));

        if (!isset($snapshot['found'])) {
            throw new NotFoundException('');
        }

        return $snapshot['found'];
    }

    /**
     * Convert snapshot timestamps to google cloud php types.
     *
     * @param array $data The snapshot data.
     * @return array
     */
    private function transformSnapshotTimestamps(array $data)
    {
        $data['createTime'] = isset($data['createTime'])
            ? $this->valueMapper->createTimestampWithNanos($data['createTime'])
            : null;

        $data['updateTime'] = isset($data['updateTime'])
            ? $this->valueMapper->createTimestampWithNanos($data['updateTime'])
            : null;

        $data['readTime'] = isset($data['readTime'])
            ? $this->valueMapper->createTimestampWithNanos($data['readTime'])
            : null;

        return $data;
    }
}
