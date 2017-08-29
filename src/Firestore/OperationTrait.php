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
     * @param string $type The write operation type.
     * @param string $name The document name to update.
     * @param array $options {
     *     Configuration Options.
     *
     *     @type array $updateMask A list of field paths to update in this document.
     *     @type array $currentDocument An optional precondition.
     *     @type array $fields An array of document fields and their values. Required
     *           if $type is `update`.
     * }
     * @return array
     */
    private function createDatabaseWrite($type, $name, array $options = [])
    {
        return array_filter([
            'updateMask' => $this->pluck('updateMask', $options, false),
            'currentDocument' => $this->pluck('currentDocument', $options, false),
        ]) + $this->createDatabaseWriteOperation($type, $name, $options);
    }

    private function createDatabaseWriteOperation($type, $name, array $options = [])
    {
        switch ($type) {
            case 'update':
                return ['update' => [
                    'name' => $name,
                    'fields' => $this->pluck('fields', $options)
                ]];
                break;

            case 'delete':
                return ['delete' => $name];
                break;

            case 'verify':
                return ['verify' => $name];
                break;

            case 'transform':
                throw new \BadMethodCallException('not implemented');
                break;

            default:
                throw new \BadMethodCallException(sprintf(
                    'Write operation type `%s is not valid. Allowed values are update, delete, verify, transform.',
                    $type
                ));
                break;
        }
    }

    /**
     * Convert the Commit Response type to library types.
     *
     * @see https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#commitresponse CommitResponse
     *
     * @param array $response the Commit Response
     * @return array
     */
    private function commitResponse(array $response)
    {
        if (isset($response['commitTime'])) {
            $response['commitTime'] = $this->createTimestampWithNanos($response['commitTime']);
        }

        if (isset($response['writeResults'])) {
            foreach ($response['writeResults'] as &$result) {
                $result['updateTime'] = $this->createTimestampWithNanos($result['updateTime']);
            }
        }
        return $response;
    }
}
