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

class WriteBatch
{
    use ArrayTrait;

    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';
    const TYPE_VERIFY = 'verify';
    const TYPE_TRANSFORM = 'transform';

    private $valueMapper;
    private $database;

    private $writes = [];
    private $hasPreviousTransform = false;

    public function __construct($valueMapper, $database)
    {
        $this->valueMapper = $valueMapper;
        $this->database = $database;
    }

    public function update($documentName, array $fields, array $options = [])
    {
        if ($this->hasPreviousTransform) {
            throw new \BadMethodCallException(
                'Cannot apply an UPDATE operation after a TRANSFORM operation has been enqueued.'
            );
        }

        $this->writes[] = $this->createDatabaseWrite(self::TYPE_UPDATE, $documentName, [
            'fields' => $this->valueMapper->encodeValues($fields),
            'updateMask' => $this->valueMapper->fieldPaths($fields)
        ] + $options);
    }

    public function delete($documentName, array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_DELETE, $documentName, $options);
    }

    public function verify($documentName, array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_VERIFY, $documentName, $options);
    }

    public function transform($documentName, array $transforms = [], array $options = [])
    {
        $this->writes[] = $this->createDatabaseWrite(self::TYPE_TRANSFORM, $documentName, [
            'fieldTransforms' => $transforms
        ] + $options);
        $this->hasPreviousTransform = true;
    }

    public function writes()
    {
        return $this->writes;
    }

    public function database()
    {
        return $this->database;
    }

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
}
