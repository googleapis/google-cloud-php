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

use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Firestore\FirestoreClient as ManualFirestoreClient;
use Google\Cloud\Firestore\V1beta1\FirestoreAdminGapicClient;
use Google\Cloud\Firestore\V1beta1\FirestoreGapicClient;
use Google\GAX\Serializer;

class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    private $serializer;

    private $admin;

    private $firestore;

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([], [
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
        $this->admin = new FirestoreAdminGapicClient($grpcConfig);
        $this->firestore = new FirestoreGapicClient($grpcConfig);
    }

    public function getDocument(array $args)
    {
        return $this->firestore->getDocument($this->pluck('name', $args), $args);
    }
}
