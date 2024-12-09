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

namespace Google\Cloud\Language\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Language\V2\AnalyzeEntitiesRequest;
use Google\Cloud\Language\V2\AnalyzeEntitiesResponse;
use Google\Cloud\Language\V2\AnalyzeSentimentRequest;
use Google\Cloud\Language\V2\AnalyzeSentimentResponse;
use Google\Cloud\Language\V2\AnnotateTextRequest;
use Google\Cloud\Language\V2\AnnotateTextRequest\Features;
use Google\Cloud\Language\V2\AnnotateTextResponse;
use Google\Cloud\Language\V2\ClassifyTextRequest;
use Google\Cloud\Language\V2\ClassifyTextResponse;
use Google\Cloud\Language\V2\Client\LanguageServiceClient;
use Google\Cloud\Language\V2\Document;
use Google\Cloud\Language\V2\ModerateTextRequest;
use Google\Cloud\Language\V2\ModerateTextResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group language
 *
 * @group gapic
 */
class LanguageServiceClientTest extends GeneratedTest
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

    /** @return LanguageServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LanguageServiceClient($options);
    }

    /** @test */
    public function analyzeEntitiesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $languageSupported = false;
        $expectedResponse = new AnalyzeEntitiesResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setLanguageSupported($languageSupported);
        $transport->addResponse($expectedResponse);
        // Mock request
        $document = new Document();
        $request = (new AnalyzeEntitiesRequest())->setDocument($document);
        $response = $gapicClient->analyzeEntities($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.language.v2.LanguageService/AnalyzeEntities', $actualFuncCall);
        $actualValue = $actualRequestObject->getDocument();
        $this->assertProtobufEquals($document, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeEntitiesExceptionTest()
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
        $document = new Document();
        $request = (new AnalyzeEntitiesRequest())->setDocument($document);
        try {
            $gapicClient->analyzeEntities($request);
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
    public function analyzeSentimentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $languageSupported = false;
        $expectedResponse = new AnalyzeSentimentResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setLanguageSupported($languageSupported);
        $transport->addResponse($expectedResponse);
        // Mock request
        $document = new Document();
        $request = (new AnalyzeSentimentRequest())->setDocument($document);
        $response = $gapicClient->analyzeSentiment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.language.v2.LanguageService/AnalyzeSentiment', $actualFuncCall);
        $actualValue = $actualRequestObject->getDocument();
        $this->assertProtobufEquals($document, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeSentimentExceptionTest()
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
        $document = new Document();
        $request = (new AnalyzeSentimentRequest())->setDocument($document);
        try {
            $gapicClient->analyzeSentiment($request);
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
    public function annotateTextTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $languageSupported = false;
        $expectedResponse = new AnnotateTextResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setLanguageSupported($languageSupported);
        $transport->addResponse($expectedResponse);
        // Mock request
        $document = new Document();
        $features = new Features();
        $request = (new AnnotateTextRequest())->setDocument($document)->setFeatures($features);
        $response = $gapicClient->annotateText($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.language.v2.LanguageService/AnnotateText', $actualFuncCall);
        $actualValue = $actualRequestObject->getDocument();
        $this->assertProtobufEquals($document, $actualValue);
        $actualValue = $actualRequestObject->getFeatures();
        $this->assertProtobufEquals($features, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function annotateTextExceptionTest()
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
        $document = new Document();
        $features = new Features();
        $request = (new AnnotateTextRequest())->setDocument($document)->setFeatures($features);
        try {
            $gapicClient->annotateText($request);
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
    public function classifyTextTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $languageSupported = false;
        $expectedResponse = new ClassifyTextResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setLanguageSupported($languageSupported);
        $transport->addResponse($expectedResponse);
        // Mock request
        $document = new Document();
        $request = (new ClassifyTextRequest())->setDocument($document);
        $response = $gapicClient->classifyText($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.language.v2.LanguageService/ClassifyText', $actualFuncCall);
        $actualValue = $actualRequestObject->getDocument();
        $this->assertProtobufEquals($document, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function classifyTextExceptionTest()
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
        $document = new Document();
        $request = (new ClassifyTextRequest())->setDocument($document);
        try {
            $gapicClient->classifyText($request);
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
    public function moderateTextTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $languageSupported = false;
        $expectedResponse = new ModerateTextResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setLanguageSupported($languageSupported);
        $transport->addResponse($expectedResponse);
        // Mock request
        $document = new Document();
        $request = (new ModerateTextRequest())->setDocument($document);
        $response = $gapicClient->moderateText($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.language.v2.LanguageService/ModerateText', $actualFuncCall);
        $actualValue = $actualRequestObject->getDocument();
        $this->assertProtobufEquals($document, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function moderateTextExceptionTest()
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
        $document = new Document();
        $request = (new ModerateTextRequest())->setDocument($document);
        try {
            $gapicClient->moderateText($request);
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
    public function analyzeEntitiesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $languageSupported = false;
        $expectedResponse = new AnalyzeEntitiesResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setLanguageSupported($languageSupported);
        $transport->addResponse($expectedResponse);
        // Mock request
        $document = new Document();
        $request = (new AnalyzeEntitiesRequest())->setDocument($document);
        $response = $gapicClient->analyzeEntitiesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.language.v2.LanguageService/AnalyzeEntities', $actualFuncCall);
        $actualValue = $actualRequestObject->getDocument();
        $this->assertProtobufEquals($document, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
