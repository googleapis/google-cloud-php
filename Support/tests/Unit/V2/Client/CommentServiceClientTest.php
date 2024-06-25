<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\Support\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Support\V2\Client\CommentServiceClient;
use Google\Cloud\Support\V2\Comment;
use Google\Cloud\Support\V2\CreateCommentRequest;
use Google\Cloud\Support\V2\ListCommentsRequest;
use Google\Cloud\Support\V2\ListCommentsResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group support
 *
 * @group gapic
 */
class CommentServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return CommentServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CommentServiceClient($options);
    }

    /** @test */
    public function createCommentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $body = 'body3029410';
        $plainTextBody = 'plainTextBody-2068348609';
        $expectedResponse = new Comment();
        $expectedResponse->setName($name);
        $expectedResponse->setBody($body);
        $expectedResponse->setPlainTextBody($plainTextBody);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $comment = new Comment();
        $request = (new CreateCommentRequest())->setParent($formattedParent)->setComment($comment);
        $response = $gapicClient->createComment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CommentService/CreateComment', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getComment();
        $this->assertProtobufEquals($comment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCommentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $comment = new Comment();
        $request = (new CreateCommentRequest())->setParent($formattedParent)->setComment($comment);
        try {
            $gapicClient->createComment($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCommentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $commentsElement = new Comment();
        $comments = [$commentsElement];
        $expectedResponse = new ListCommentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setComments($comments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new ListCommentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listComments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getComments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CommentService/ListComments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCommentsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new ListCommentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listComments($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCommentAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $body = 'body3029410';
        $plainTextBody = 'plainTextBody-2068348609';
        $expectedResponse = new Comment();
        $expectedResponse->setName($name);
        $expectedResponse->setBody($body);
        $expectedResponse->setPlainTextBody($plainTextBody);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $comment = new Comment();
        $request = (new CreateCommentRequest())->setParent($formattedParent)->setComment($comment);
        $response = $gapicClient->createCommentAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CommentService/CreateComment', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getComment();
        $this->assertProtobufEquals($comment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
