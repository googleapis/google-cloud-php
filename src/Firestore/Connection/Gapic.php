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

namespace Google\Cloud\Firestore\Connection;

use Google\GAX\Serializer;
use Google\Cloud\Core\GrpcTrait;
use Google\Firestore\V1beta1\Write;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Firestore\V1beta1\DocumentMask;
use Google\Firestore\V1beta1\StructuredQuery;
use Google\Firestore\V1beta1\TransactionOptions;
use Google\Cloud\Firestore\V1beta1\FirestoreClient;
use Google\Firestore\V1beta1\TransactionOptions_ReadWrite;
use Google\Cloud\Firestore\FirestoreClient as ManualFirestoreClient;

/**
 * A gRPC connection to Cloud Firestore via GAPIC.
 */
class Gapic implements ConnectionInterface
{
    use GrpcTrait;

    private $serializer;

    private $firestore;

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([
            'create_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'update_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'commit_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
        ], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
        ]);

        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));

        $grpcConfig = $this->getGaxConfig(ManualFirestoreClient::VERSION);
        $this->firestore = new FirestoreClient($grpcConfig);
    }

    /**
     * @param array $args
     */
    public function batchGetDocuments(array $args)
    {
        return $this->send([$this->firestore, 'batchGetDocuments'], [
            $this->pluck('database', $args),
            $this->pluck('documents', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function beginTransaction(array $args)
    {
        $rw = new TransactionOptions_ReadWrite;
        $rw->setRetryTransaction($this->pluck('retryTransaction', $args, false));

        $args['options'] = new TransactionOptions;
        $args['options']->setReadWrite($rw);

        return $this->send([$this->firestore, 'beginTransaction'], [
            $this->pluck('database', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function commit(array $args)
    {
        $writes = $this->pluck('writes', $args);
        foreach ($writes as $idx => $write) {
            if (isset($write['updateMask'])) {
                $maskFields = $write['updateMask'];
                $write['updateMask'] = new DocumentMask;
                $write['updateMask']->setFieldPaths($maskFields);
            }

            $writes[$idx] = $this->serializer->decodeMessage(new Write, $write);
        }

        return $this->send([$this->firestore, 'commit'], [
            $this->pluck('database', $args),
            $writes,
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function listCollectionIds(array $args)
    {
        return $this->send([$this->firestore, 'listCollectionIds'], [
            $this->pluck('parent', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function rollback(array $args)
    {
        return $this->send([$this->firestore, 'rollback'], [
            $this->pluck('database', $args),
            $this->pluck('transaction', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function runQuery(array $args)
    {
        $q = $this->pluck('structuredQuery', $args);

        $args['structuredQuery'] = $this->serializer->decodeMessage(
            new StructuredQuery,
            $q
        );

        return $this->send([$this->firestore, 'runQuery'], [
            $this->pluck('parent', $args),
            $args
        ]);
    }
}
