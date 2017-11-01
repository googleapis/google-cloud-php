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

use Google\Cloud\Core\Timestamp;
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
     * Execute a service request to retrieve a document snapshot.
     *
     * @param DocumentReference $reference The parent document.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID to fetch the snapshot.
     *     @type bool $allowNonExistence If true, a DocumentSnapshot will be
     *           returned, even if the document does not exist. **Defaults to**
     *           `true`.
     * }
     * @return DocumentSnapshot
     * @throws NotFoundException If the document does not exist, and
     *         `$options['allowNonExistence'] is `false`.
     */
    private function createSnapshot(DocumentReference $reference, ValueMapper $valueMapper, array $options = [])
    {
        $options += [
            'allowNonExistence' => true,
        ];

        $document = [];
        $fields = [];
        $exists = true;

        $allowNonExistence = $this->pluck('allowNonExistence', $options);
        try {
            $document = $this->getSnapshot($reference->name(), $options);
        } catch (NotFoundException $e) {
            if (!$allowNonExistence) {
                throw $e;
            }

            $exists = false;
        }

        return $this->createSnapshotWithData($reference, $valueMapper, $document, $exists);
    }

    /**
     * Create a document snapshot by providing a dataset.
     *
     * This method will not perform a service request.
     *
     * @codingStandardsIgnoreStart
     * @param DocumentReference $reference The parent document.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param array $document [Document](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Document)
     * @param bool $exists Whether the document exists. **Defaults to** `true`.
     * @codingStandardsIgnoreEnd
     */
    private function createSnapshotWithData(
        DocumentReference $reference,
        ValueMapper $valueMapper,
        array $document,
        $exists = true
    ) {
        $fields = $exists
            ? $this->valueMapper->decodeValues($this->pluck('fields', $document))
            : [];

        $document = $this->transformSnapshotTimestamps($document);

        return new DocumentSnapshot($reference, $valueMapper, $document, $fields, $exists);
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
        if (isset($options['readTime'])) {
            if (!($options['readTime'] instanceof Timestamp)) {
                throw new \InvalidArgumentException(
                    '`$options.readTime` must be an instance of Google\\Cloud\\Core\\Timestamp'
                );
            }

            $options['readTime'] = $options['readTime']->formatForApi();
        }

        $snapshot = $this->connection->batchGetDocuments([
            'database' => $this->databaseFromName($name),
            'documents' => [$name],
        ] + $options)->current();

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
