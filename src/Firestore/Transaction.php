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

use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

class Transaction
{
    use OperationTrait;
    use PathTrait;
    use DebugInfoTrait;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var WriteBatch
     */
    private $writer;

    /**
     * @var array
     */
    private $commitOptions = [];

    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, $database, $transactionId)
    {
        $this->valueMapper = $valueMapper;
        $this->writer = new WriteBatch($connection, $valueMapper, $database, $transactionId);
    }

    public function snapshot(Document $document, array $options = [])
    {
        return $this->createSnapshot($document, [
            'transaction' => $this->transactionId
        ] + $options);
    }

    public function create(Document $document, array $fields)
    {
        $this->writer->update($document->name(), $fields, [
            'currentDocument' => ['exists' => false]
        ]);

        return $this;
    }

    public function set(Document $document, array $fields, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true],
            'updateMask' => []
        ];

        $this->writer->update($document->name(), $fields, [
            'currentDocument' => $this->pluck('precondition', $options)
        ]);

        return $this;
    }

    public function update(Document $document, array $fields, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true]
        ];

        $this->writer->update($document->name(), $fields, [
            'currentDocument' => $this->pluck('precondition', $options)
        ]);

        return $this;
    }

    public function delete(Document $document, array $options = [])
    {
        $options += [
            'precondition' => ['exists' => true]
        ];

        $this->writer->delete($document->name(), [
            'currentDocument' => $this->pluck('precondition', $options)
        ]);

        return $this;
    }

    /**
     * Set the `$options` value passed to the Transaction commit RPC.
     *
     * @param array $options
     * @return void
     */
    public function setCommitOptions(array $options)
    {
        $this->commitOptions = $options;
    }

    /**
     * Get the `$options` value to pass to the Transaction commit RPC.
     *
     * @access private
     * @return array
     */
    public function commitOptions()
    {
        return $this->commitOptions;
    }

    /**
     * Get the WriteBatch object.
     *
     * @access private
     * @return WriteBatch
     */
    public function writer()
    {
        return $this->writer;
    }
}
