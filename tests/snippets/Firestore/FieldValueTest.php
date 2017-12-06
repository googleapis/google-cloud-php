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

namespace Google\Cloud\Tests\Snippets\Firestore;

use Prophecy\Argument;
use Google\Cloud\Tests\GrpcTestTrait;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\V1beta1\DocumentTransform_FieldTransform_ServerValue;

/**
 * @group firestore
 * @group firestore-fieldvalue
 */
class FieldValueTest extends SnippetTestCase
{
    use GrpcTestTrait;

    private $connection;
    private $firestore;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->firestore = \Google\Cloud\Dev\stub(FirestoreClient::class);
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
                        "fields" => []
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
                                "setToServerValue" => DocumentTransform_FieldTransform_ServerValue::REQUEST_TIME
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
}
