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

trait OperationTrait
{
    use ArrayTrait;
    use ValueMapperTrait;

    /**
     * Commit writes to the database.
     *
     * @param string $database
     * @param WriteBatch $writes
     * @param array $options
     * @return array [https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#commitresponse](CommitResponse)
     */
    private function commitWrites(WriteBatch $writes, array $options = [])
    {
        $response = $this->connection->commit([
            'database' => $writes->database(),
            'writes' => $writes->writes()
        ] + $options);

        if (isset($response['commitTime'])) {
            $response['commitTime'] = $this->createTimestampWithNanos($response['commitTime']);
        }

        if (isset($response['writeResults'])) {
            foreach ($response['writeResults'] as &$result) {
                if (isset($result['updateTime'])) {
                    $result['updateTime'] = $this->createTimestampWithNanos($result['updateTime']);
                }
            }
        }

        return $response;
    }

    private function rollback($database, $transactionId, array $options = [])
    {
        $this->connection->rollback([
            'database' => $database,
            'transaction' => $transactionId
        ] + $options);
    }

    private function createSnapshot(Document $document, array $options = [])
    {
        $exists = true;
        $data = [];
        $fields = [];

        try {
            $data = $this->getSnapshot($document->name(), $options);

            $fields = $this->valueMapper->decodeValues(
                $this->pluck('fields', $data)
            );

            $data['createTime'] = isset($data['createTime'])
                ? $this->valueMapper->createTimestampWithNanos($data['createTime'])
                : null;

            $data['updateTime'] = isset($data['updateTime'])
                ? $this->valueMapper->createTimestampWithNanos($data['updateTime'])
                : null;

        } catch (NotFoundException $e) {
            $exists = false;
        }

        return new DocumentSnapshot($document, $data, $fields, $exists);
    }

    private function getSnapshot($name, array $options = [])
    {
        return $this->connection->getDocument([
            'name' => $name,
        ] + $options);
    }
}
