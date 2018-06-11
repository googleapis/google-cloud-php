<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Speech\Tests\Unit\V1beta1;

use Google\Cloud\Speech\V1beta1\SpeechClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Speech\V1beta1\AsyncRecognizeResponse;
use Google\Cloud\Speech\V1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1beta1\RecognitionConfig_AudioEncoding;
use Google\Cloud\Speech\V1beta1\StreamingRecognizeRequest;
use Google\Cloud\Speech\V1beta1\StreamingRecognizeResponse;
use Google\Cloud\Speech\V1beta1\SyncRecognizeResponse;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group speech
 * @group grpc
 */
class SpeechClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return SpeechClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new SpeechClient($options);
    }

    /**
     * @test
     */
    public function syncRecognizeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new SyncRecognizeResponse();
        $transport->addResponse($expectedResponse);

        // Mock request
        $encoding = RecognitionConfig_AudioEncoding::FLAC;
        $sampleRate = 44100;
        $config = new RecognitionConfig();
        $config->setEncoding($encoding);
        $config->setSampleRate($sampleRate);
        $uri = 'gs://bucket_name/file_name.flac';
        $audio = new RecognitionAudio();
        $audio->setUri($uri);

        $response = $client->syncRecognize($config, $audio);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.speech.v1beta1.Speech/SyncRecognize', $actualFuncCall);

        $actualValue = $actualRequestObject->getConfig();

        $this->assertProtobufEquals($config, $actualValue);
        $actualValue = $actualRequestObject->getAudio();

        $this->assertProtobufEquals($audio, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function syncRecognizeExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $encoding = RecognitionConfig_AudioEncoding::FLAC;
        $sampleRate = 44100;
        $config = new RecognitionConfig();
        $config->setEncoding($encoding);
        $config->setSampleRate($sampleRate);
        $uri = 'gs://bucket_name/file_name.flac';
        $audio = new RecognitionAudio();
        $audio->setUri($uri);

        try {
            $client->syncRecognize($config, $audio);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function asyncRecognizeTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);

        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());

        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/asyncRecognizeTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new AsyncRecognizeResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/asyncRecognizeTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);

        // Mock request
        $encoding = RecognitionConfig_AudioEncoding::FLAC;
        $sampleRate = 44100;
        $config = new RecognitionConfig();
        $config->setEncoding($encoding);
        $config->setSampleRate($sampleRate);
        $uri = 'gs://bucket_name/file_name.flac';
        $audio = new RecognitionAudio();
        $audio->setUri($uri);

        $response = $client->asyncRecognize($config, $audio);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));

        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.speech.v1beta1.Speech/AsyncRecognize', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getConfig();

        $this->assertProtobufEquals($config, $actualValue);
        $actualValue = $actualApiRequestObject->getAudio();

        $this->assertProtobufEquals($audio, $actualValue);

        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/asyncRecognizeTest');

        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));

        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);

        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function asyncRecognizeExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);

        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());

        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/asyncRecognizeTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);

        // Mock request
        $encoding = RecognitionConfig_AudioEncoding::FLAC;
        $sampleRate = 44100;
        $config = new RecognitionConfig();
        $config->setEncoding($encoding);
        $config->setSampleRate($sampleRate);
        $uri = 'gs://bucket_name/file_name.flac';
        $audio = new RecognitionAudio();
        $audio->setUri($uri);

        $response = $client->asyncRecognize($config, $audio);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());

        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/asyncRecognizeTest');

        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function streamingRecognizeTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $resultIndex = 520358448;
        $expectedResponse = new StreamingRecognizeResponse();
        $expectedResponse->setResultIndex($resultIndex);
        $transport->addResponse($expectedResponse);
        $resultIndex2 = 1848265187;
        $expectedResponse2 = new StreamingRecognizeResponse();
        $expectedResponse2->setResultIndex($resultIndex2);
        $transport->addResponse($expectedResponse2);
        $resultIndex3 = 1848265188;
        $expectedResponse3 = new StreamingRecognizeResponse();
        $expectedResponse3->setResultIndex($resultIndex3);
        $transport->addResponse($expectedResponse3);

        // Mock request
        $request = new StreamingRecognizeRequest();
        $request2 = new StreamingRecognizeRequest();
        $request3 = new StreamingRecognizeRequest();

        $bidi = $client->streamingRecognize();
        $this->assertInstanceOf(BidiStream::class, $bidi);

        $bidi->write($request);
        $responses = [];
        $responses[] = $bidi->read();

        $bidi->writeAll([$request2, $request3]);
        foreach ($bidi->closeWriteAndReadAll() as $response) {
            $responses[] = $response;
        }

        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);

        $createStreamRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($createStreamRequests));
        $streamFuncCall = $createStreamRequests[0]->getFuncCall();
        $streamRequestObject = $createStreamRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.speech.v1beta1.Speech/StreamingRecognize', $streamFuncCall);
        $this->assertNull($streamRequestObject);

        $callObjects = $transport->popCallObjects();
        $this->assertSame(1, count($callObjects));
        $bidiCall = $callObjects[0];

        $writeRequests = $bidiCall->popReceivedCalls();
        $expectedRequests = [];
        $expectedRequests[] = $request;
        $expectedRequests[] = $request2;
        $expectedRequests[] = $request3;
        $this->assertEquals($expectedRequests, $writeRequests);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function streamingRecognizeExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);

        $transport->setStreamingStatus($status);

        $this->assertTrue($transport->isExhausted());

        $bidi = $client->streamingRecognize();
        $results = $bidi->closeWriteAndReadAll();

        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }

        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }
}
