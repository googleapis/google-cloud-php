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

use ArgumentCountError;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Tests\Unit\GenerateProtoTrait;
use Google\Cloud\Firestore\V1\Client\FirestoreClient as ClientFirestoreClient;
use Google\Cloud\Firestore\V1\CommitRequest;
use Google\Cloud\Firestore\V1\CommitResponse;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

use function PHPUnit\Framework\assertEquals;

/**
 * @group firestore
 * @group firestore-fieldvalue
 */
class FieldValueTest extends SnippetTestCase
{
    use GenerateProtoTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    private $gapicClient;
    private $firestore;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->gapicClient = $this->prophesize(ClientFirestoreClient::class);
        $this->firestore = new FirestoreClient([
            'projectId' => 'my-awesome-project',
            'firestoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testDeleteField()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    "database" => "projects/my-awesome-project/databases/(default)",
                    "writes" => [
                        [
                            "updateMask" => [
                                "fieldPaths" => ["hometown"],
                            ],
                            "currentDocument" => [
                                "exists" => true,
                            ],
                            "update" => [
                                "name" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                            ],
                        ],
                    ],
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->willReturn(new CommitResponse())->shouldBeCalledTimes(1);

        $snippet = $this->snippetFromMethod(FieldValue::class, 'deleteField');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testServerTimestamp()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    "database" => "projects/my-awesome-project/databases/(default)",
                    "writes" => [
                        [
                            "transform" => [
                                "document" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                                "fieldTransforms" => [
                                    [
                                        "fieldPath" => "lastLogin",
                                        "setToServerValue" => ServerValue::REQUEST_TIME,
                                    ],
                                ],
                            ],
                            "currentDocument" => [
                                "exists" => true,
                            ],
                        ],
                    ],
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->willReturn(new CommitResponse())->shouldBeCalledTimes(1);

        $snippet = $this->snippetFromMethod(FieldValue::class, 'serverTimestamp');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testArrayUnion()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
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
                                                    'stringValue' => 'red',
                                                ], [
                                                    'stringValue' => 'blue',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            "currentDocument" => [
                                "exists" => true,
                            ],
                        ],
                    ],
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->willReturn(new CommitResponse())->shouldBeCalledTimes(1);

        $snippet = $this->snippetFromMethod(FieldValue::class, 'arrayUnion');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testArrayRemove()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
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
                                                    'stringValue' => 'green',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            "currentDocument" => [
                                "exists" => true,
                            ],
                        ],
                    ],
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->willReturn(new CommitResponse())->shouldBeCalledTimes(1);

        $snippet = $this->snippetFromMethod(FieldValue::class, 'arrayRemove');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }

    public function testIncrement()
    {
        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $expectedRequest = self::generateProto(CommitRequest::class, [
                    "database" => "projects/my-awesome-project/databases/(default)",
                    "writes" => [
                        [
                            "transform" => [
                                "document" => "projects/my-awesome-project/databases/(default)/documents/users/dave",
                                "fieldTransforms" => [
                                    [
                                        "fieldPath" => "loginCount",
                                        'increment' => [
                                            'integerValue' => 1,
                                        ],
                                    ],
                                ],
                            ],
                            "currentDocument" => [
                                "exists" => true,
                            ],
                        ],
                    ],
                ]);

                $this->assertEquals($expectedRequest, $request);
                return true;
            }),
            Argument::any()
        )->willReturn(new CommitResponse())->shouldBeCalledTimes(1);

        $snippet = $this->snippetFromMethod(FieldValue::class, 'increment');
        $snippet->setLine(3, '');
        $snippet->addLocal('firestore', $this->firestore);

        $snippet->invoke();
    }
}
