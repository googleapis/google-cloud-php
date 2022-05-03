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

namespace Google\Cloud\Firestore\Tests\Snippet;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;

/**
 * @group firestore
 * @group firestore-fieldvalue
 */
class FieldValueTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $connection;
    private $firestore;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->firestore = TestHelpers::stub(FirestoreClient::class);
    }

    public function testDeleteField()
    {
        $this->connection->commit([
            "database" => "projects/my-awesome-project/databases/(default)",
            "writes" => [
                [
                    "updateMask" => [
                        "fieldPaths" => ["hometown"]
                    ],
                    "currentDocument" => [
                        "exists" => true
                    ],
                    "update" => [
                        "name" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                    ]
                ]
            ]
        ])->willReturn([[]]);

        $this->firestore->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FieldValue::class, 'deleteField');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testServerTimestamp()
    {
        $this->connection->commit([
            "database" => "projects/my-awesome-project/databases/(default)",
            "writes" => [
                [
                    "transform" => [
                        "document" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                        "fieldTransforms" => [
                            [
                                "fieldPath" => "lastLogin",
                                "setToServerValue" => ServerValue::REQUEST_TIME
                            ]
                        ]
                    ],
                    "currentDocument" => [
                        "exists" => true
                    ]
                ]
            ]
        ])->willReturn([[]]);

        $this->firestore->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FieldValue::class, 'serverTimestamp');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testArrayUnion()
    {
        $this->connection->commit([
            "database" => "projects/my-awesome-project/databases/(default)",
            "writes" => [
                [
                    "transform" => [
                        "document" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                        "fieldTransforms" => [
                            [
                                "fieldPath" => "favoriteColors",
                                'appendMissingElements' => [
                                    'values' => [
                                        [
                                            'stringValue' => 'red'
                                        ], [
                                            'stringValue' => 'blue'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "currentDocument" => [
                        "exists" => true
                    ]
                ]
            ]
        ])->willReturn([[]]);

        $this->firestore->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FieldValue::class, 'arrayUnion');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testArrayRemove()
    {
        $this->connection->commit([
            "database" => "projects/my-awesome-project/databases/(default)",
            "writes" => [
                [
                    "transform" => [
                        "document" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                        "fieldTransforms" => [
                            [
                                "fieldPath" => "favoriteColors",
                                'removeAllFromArray' => [
                                    'values' => [
                                        [
                                            'stringValue' => 'green'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "currentDocument" => [
                        "exists" => true
                    ]
                ]
            ]
        ])->willReturn([[]]);

        $this->firestore->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FieldValue::class, 'arrayRemove');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testIncrement()
    {
        $this->connection->commit([
            "database" => "projects/my-awesome-project/databases/(default)",
            "writes" => [
                [
                    "transform" => [
                        "document" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                        "fieldTransforms" => [
                            [
                                "fieldPath" => "loginCount",
                                'increment' => [
                                    'integerValue' => 1
                                ]
                            ]
                        ]
                    ],
                    "currentDocument" => [
                        "exists" => true
                    ]
                ]
            ]
        ])->willReturn([[]]);

        $this->firestore->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(FieldValue::class, 'increment');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }
}
