<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Translate\Tests\Unit\V3\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Translate\V3\AdaptiveMtDataset;
use Google\Cloud\Translate\V3\AdaptiveMtFile;
use Google\Cloud\Translate\V3\AdaptiveMtSentence;
use Google\Cloud\Translate\V3\AdaptiveMtTranslateRequest;
use Google\Cloud\Translate\V3\AdaptiveMtTranslateResponse;
use Google\Cloud\Translate\V3\BatchDocumentOutputConfig;
use Google\Cloud\Translate\V3\BatchTranslateDocumentRequest;
use Google\Cloud\Translate\V3\BatchTranslateDocumentResponse;
use Google\Cloud\Translate\V3\BatchTranslateResponse;
use Google\Cloud\Translate\V3\BatchTranslateTextRequest;
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\CreateAdaptiveMtDatasetRequest;
use Google\Cloud\Translate\V3\CreateGlossaryRequest;
use Google\Cloud\Translate\V3\DeleteAdaptiveMtDatasetRequest;
use Google\Cloud\Translate\V3\DeleteAdaptiveMtFileRequest;
use Google\Cloud\Translate\V3\DeleteGlossaryRequest;
use Google\Cloud\Translate\V3\DeleteGlossaryResponse;
use Google\Cloud\Translate\V3\DetectLanguageRequest;
use Google\Cloud\Translate\V3\DetectLanguageResponse;
use Google\Cloud\Translate\V3\DocumentInputConfig;
use Google\Cloud\Translate\V3\GetAdaptiveMtDatasetRequest;
use Google\Cloud\Translate\V3\GetAdaptiveMtFileRequest;
use Google\Cloud\Translate\V3\GetGlossaryRequest;
use Google\Cloud\Translate\V3\GetSupportedLanguagesRequest;
use Google\Cloud\Translate\V3\Glossary;
use Google\Cloud\Translate\V3\ImportAdaptiveMtFileRequest;
use Google\Cloud\Translate\V3\ImportAdaptiveMtFileResponse;
use Google\Cloud\Translate\V3\ListAdaptiveMtDatasetsRequest;
use Google\Cloud\Translate\V3\ListAdaptiveMtDatasetsResponse;
use Google\Cloud\Translate\V3\ListAdaptiveMtFilesRequest;
use Google\Cloud\Translate\V3\ListAdaptiveMtFilesResponse;
use Google\Cloud\Translate\V3\ListAdaptiveMtSentencesRequest;
use Google\Cloud\Translate\V3\ListAdaptiveMtSentencesResponse;
use Google\Cloud\Translate\V3\ListGlossariesRequest;
use Google\Cloud\Translate\V3\ListGlossariesResponse;
use Google\Cloud\Translate\V3\OutputConfig;
use Google\Cloud\Translate\V3\SupportedLanguages;
use Google\Cloud\Translate\V3\TranslateDocumentRequest;
use Google\Cloud\Translate\V3\TranslateDocumentResponse;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use Google\Cloud\Translate\V3\TranslateTextResponse;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group translate
 *
 * @group gapic
 */
class TranslationServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return TranslationServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TranslationServiceClient($options);
    }

    /** @test */
    public function adaptiveMtTranslateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new AdaptiveMtTranslateResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedDataset = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $content = [];
        $request = (new AdaptiveMtTranslateRequest())
            ->setParent($formattedParent)
            ->setDataset($formattedDataset)
            ->setContent($content);
        $response = $gapicClient->adaptiveMtTranslate($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/AdaptiveMtTranslate', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataset();
        $this->assertProtobufEquals($formattedDataset, $actualValue);
        $actualValue = $actualRequestObject->getContent();
        $this->assertProtobufEquals($content, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function adaptiveMtTranslateExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedDataset = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $content = [];
        $request = (new AdaptiveMtTranslateRequest())
            ->setParent($formattedParent)
            ->setDataset($formattedDataset)
            ->setContent($content);
        try {
            $gapicClient->adaptiveMtTranslate($request);
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
    public function batchTranslateDocumentTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchTranslateDocumentTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $totalPages = 396186871;
        $translatedPages = 1652747493;
        $failedPages = 2002254526;
        $totalBillablePages = 1292117569;
        $totalCharacters = 1368640955;
        $translatedCharacters = 1337326221;
        $failedCharacters = 1723028396;
        $totalBillableCharacters = 1242495501;
        $expectedResponse = new BatchTranslateDocumentResponse();
        $expectedResponse->setTotalPages($totalPages);
        $expectedResponse->setTranslatedPages($translatedPages);
        $expectedResponse->setFailedPages($failedPages);
        $expectedResponse->setTotalBillablePages($totalBillablePages);
        $expectedResponse->setTotalCharacters($totalCharacters);
        $expectedResponse->setTranslatedCharacters($translatedCharacters);
        $expectedResponse->setFailedCharacters($failedCharacters);
        $expectedResponse->setTotalBillableCharacters($totalBillableCharacters);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/batchTranslateDocumentTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $sourceLanguageCode = 'sourceLanguageCode1687263568';
        $targetLanguageCodes = [];
        $inputConfigs = [];
        $outputConfig = new BatchDocumentOutputConfig();
        $request = (new BatchTranslateDocumentRequest())
            ->setParent($formattedParent)
            ->setSourceLanguageCode($sourceLanguageCode)
            ->setTargetLanguageCodes($targetLanguageCodes)
            ->setInputConfigs($inputConfigs)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->batchTranslateDocument($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/BatchTranslateDocument', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getSourceLanguageCode();
        $this->assertProtobufEquals($sourceLanguageCode, $actualValue);
        $actualValue = $actualApiRequestObject->getTargetLanguageCodes();
        $this->assertProtobufEquals($targetLanguageCodes, $actualValue);
        $actualValue = $actualApiRequestObject->getInputConfigs();
        $this->assertProtobufEquals($inputConfigs, $actualValue);
        $actualValue = $actualApiRequestObject->getOutputConfig();
        $this->assertProtobufEquals($outputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchTranslateDocumentTest');
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

    /** @test */
    public function batchTranslateDocumentExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchTranslateDocumentTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $sourceLanguageCode = 'sourceLanguageCode1687263568';
        $targetLanguageCodes = [];
        $inputConfigs = [];
        $outputConfig = new BatchDocumentOutputConfig();
        $request = (new BatchTranslateDocumentRequest())
            ->setParent($formattedParent)
            ->setSourceLanguageCode($sourceLanguageCode)
            ->setTargetLanguageCodes($targetLanguageCodes)
            ->setInputConfigs($inputConfigs)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->batchTranslateDocument($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchTranslateDocumentTest');
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

    /** @test */
    public function batchTranslateTextTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchTranslateTextTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $totalCharacters = 1368640955;
        $translatedCharacters = 1337326221;
        $failedCharacters = 1723028396;
        $expectedResponse = new BatchTranslateResponse();
        $expectedResponse->setTotalCharacters($totalCharacters);
        $expectedResponse->setTranslatedCharacters($translatedCharacters);
        $expectedResponse->setFailedCharacters($failedCharacters);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/batchTranslateTextTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $sourceLanguageCode = 'sourceLanguageCode1687263568';
        $targetLanguageCodes = [];
        $inputConfigs = [];
        $outputConfig = new OutputConfig();
        $request = (new BatchTranslateTextRequest())
            ->setParent($formattedParent)
            ->setSourceLanguageCode($sourceLanguageCode)
            ->setTargetLanguageCodes($targetLanguageCodes)
            ->setInputConfigs($inputConfigs)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->batchTranslateText($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/BatchTranslateText', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getSourceLanguageCode();
        $this->assertProtobufEquals($sourceLanguageCode, $actualValue);
        $actualValue = $actualApiRequestObject->getTargetLanguageCodes();
        $this->assertProtobufEquals($targetLanguageCodes, $actualValue);
        $actualValue = $actualApiRequestObject->getInputConfigs();
        $this->assertProtobufEquals($inputConfigs, $actualValue);
        $actualValue = $actualApiRequestObject->getOutputConfig();
        $this->assertProtobufEquals($outputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchTranslateTextTest');
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

    /** @test */
    public function batchTranslateTextExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/batchTranslateTextTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $sourceLanguageCode = 'sourceLanguageCode1687263568';
        $targetLanguageCodes = [];
        $inputConfigs = [];
        $outputConfig = new OutputConfig();
        $request = (new BatchTranslateTextRequest())
            ->setParent($formattedParent)
            ->setSourceLanguageCode($sourceLanguageCode)
            ->setTargetLanguageCodes($targetLanguageCodes)
            ->setInputConfigs($inputConfigs)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->batchTranslateText($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/batchTranslateTextTest');
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

    /** @test */
    public function createAdaptiveMtDatasetTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $sourceLanguageCode = 'sourceLanguageCode1687263568';
        $targetLanguageCode = 'targetLanguageCode1323228230';
        $exampleCount = 1517063674;
        $expectedResponse = new AdaptiveMtDataset();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setSourceLanguageCode($sourceLanguageCode);
        $expectedResponse->setTargetLanguageCode($targetLanguageCode);
        $expectedResponse->setExampleCount($exampleCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $adaptiveMtDataset = new AdaptiveMtDataset();
        $adaptiveMtDatasetName = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $adaptiveMtDataset->setName($adaptiveMtDatasetName);
        $request = (new CreateAdaptiveMtDatasetRequest())
            ->setParent($formattedParent)
            ->setAdaptiveMtDataset($adaptiveMtDataset);
        $response = $gapicClient->createAdaptiveMtDataset($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/CreateAdaptiveMtDataset', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdaptiveMtDataset();
        $this->assertProtobufEquals($adaptiveMtDataset, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAdaptiveMtDatasetExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $adaptiveMtDataset = new AdaptiveMtDataset();
        $adaptiveMtDatasetName = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $adaptiveMtDataset->setName($adaptiveMtDatasetName);
        $request = (new CreateAdaptiveMtDatasetRequest())
            ->setParent($formattedParent)
            ->setAdaptiveMtDataset($adaptiveMtDataset);
        try {
            $gapicClient->createAdaptiveMtDataset($request);
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
    public function createGlossaryTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createGlossaryTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $entryCount = 811131134;
        $displayName = 'displayName1615086568';
        $expectedResponse = new Glossary();
        $expectedResponse->setName($name);
        $expectedResponse->setEntryCount($entryCount);
        $expectedResponse->setDisplayName($displayName);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createGlossaryTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $glossary = new Glossary();
        $glossaryName = 'glossaryName-297469495';
        $glossary->setName($glossaryName);
        $request = (new CreateGlossaryRequest())
            ->setParent($formattedParent)
            ->setGlossary($glossary);
        $response = $gapicClient->createGlossary($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/CreateGlossary', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getGlossary();
        $this->assertProtobufEquals($glossary, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createGlossaryTest');
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

    /** @test */
    public function createGlossaryExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createGlossaryTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $glossary = new Glossary();
        $glossaryName = 'glossaryName-297469495';
        $glossary->setName($glossaryName);
        $request = (new CreateGlossaryRequest())
            ->setParent($formattedParent)
            ->setGlossary($glossary);
        $response = $gapicClient->createGlossary($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createGlossaryTest');
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

    /** @test */
    public function deleteAdaptiveMtDatasetTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new DeleteAdaptiveMtDatasetRequest())
            ->setName($formattedName);
        $gapicClient->deleteAdaptiveMtDataset($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/DeleteAdaptiveMtDataset', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAdaptiveMtDatasetExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new DeleteAdaptiveMtDatasetRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAdaptiveMtDataset($request);
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
    public function deleteAdaptiveMtFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtFileName('[PROJECT]', '[LOCATION]', '[DATASET]', '[FILE]');
        $request = (new DeleteAdaptiveMtFileRequest())
            ->setName($formattedName);
        $gapicClient->deleteAdaptiveMtFile($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/DeleteAdaptiveMtFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAdaptiveMtFileExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtFileName('[PROJECT]', '[LOCATION]', '[DATASET]', '[FILE]');
        $request = (new DeleteAdaptiveMtFileRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteAdaptiveMtFile($request);
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
    public function deleteGlossaryTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteGlossaryTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $expectedResponse = new DeleteGlossaryResponse();
        $expectedResponse->setName($name2);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteGlossaryTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
        $request = (new DeleteGlossaryRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteGlossary($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/DeleteGlossary', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteGlossaryTest');
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

    /** @test */
    public function deleteGlossaryExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/deleteGlossaryTest');
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
        $formattedName = $gapicClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
        $request = (new DeleteGlossaryRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteGlossary($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteGlossaryTest');
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

    /** @test */
    public function detectLanguageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new DetectLanguageResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new DetectLanguageRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->detectLanguage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/DetectLanguage', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function detectLanguageExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new DetectLanguageRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->detectLanguage($request);
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
    public function getAdaptiveMtDatasetTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $sourceLanguageCode = 'sourceLanguageCode1687263568';
        $targetLanguageCode = 'targetLanguageCode1323228230';
        $exampleCount = 1517063674;
        $expectedResponse = new AdaptiveMtDataset();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setSourceLanguageCode($sourceLanguageCode);
        $expectedResponse->setTargetLanguageCode($targetLanguageCode);
        $expectedResponse->setExampleCount($exampleCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new GetAdaptiveMtDatasetRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAdaptiveMtDataset($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/GetAdaptiveMtDataset', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdaptiveMtDatasetExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new GetAdaptiveMtDatasetRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAdaptiveMtDataset($request);
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
    public function getAdaptiveMtFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $entryCount = 811131134;
        $expectedResponse = new AdaptiveMtFile();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntryCount($entryCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtFileName('[PROJECT]', '[LOCATION]', '[DATASET]', '[FILE]');
        $request = (new GetAdaptiveMtFileRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAdaptiveMtFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/GetAdaptiveMtFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdaptiveMtFileExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->adaptiveMtFileName('[PROJECT]', '[LOCATION]', '[DATASET]', '[FILE]');
        $request = (new GetAdaptiveMtFileRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAdaptiveMtFile($request);
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
    public function getGlossaryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $entryCount = 811131134;
        $displayName = 'displayName1615086568';
        $expectedResponse = new Glossary();
        $expectedResponse->setName($name2);
        $expectedResponse->setEntryCount($entryCount);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
        $request = (new GetGlossaryRequest())
            ->setName($formattedName);
        $response = $gapicClient->getGlossary($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/GetGlossary', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getGlossaryExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');
        $request = (new GetGlossaryRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getGlossary($request);
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
    public function getSupportedLanguagesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SupportedLanguages();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new GetSupportedLanguagesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->getSupportedLanguages($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/GetSupportedLanguages', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSupportedLanguagesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new GetSupportedLanguagesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->getSupportedLanguages($request);
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
    public function importAdaptiveMtFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ImportAdaptiveMtFileResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new ImportAdaptiveMtFileRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->importAdaptiveMtFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/ImportAdaptiveMtFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function importAdaptiveMtFileExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new ImportAdaptiveMtFileRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->importAdaptiveMtFile($request);
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
    public function listAdaptiveMtDatasetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $adaptiveMtDatasetsElement = new AdaptiveMtDataset();
        $adaptiveMtDatasets = [
            $adaptiveMtDatasetsElement,
        ];
        $expectedResponse = new ListAdaptiveMtDatasetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAdaptiveMtDatasets($adaptiveMtDatasets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAdaptiveMtDatasetsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAdaptiveMtDatasets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdaptiveMtDatasets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/ListAdaptiveMtDatasets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdaptiveMtDatasetsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAdaptiveMtDatasetsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAdaptiveMtDatasets($request);
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
    public function listAdaptiveMtFilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $adaptiveMtFilesElement = new AdaptiveMtFile();
        $adaptiveMtFiles = [
            $adaptiveMtFilesElement,
        ];
        $expectedResponse = new ListAdaptiveMtFilesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAdaptiveMtFiles($adaptiveMtFiles);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new ListAdaptiveMtFilesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAdaptiveMtFiles($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdaptiveMtFiles()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/ListAdaptiveMtFiles', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdaptiveMtFilesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $request = (new ListAdaptiveMtFilesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAdaptiveMtFiles($request);
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
    public function listAdaptiveMtSentencesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $adaptiveMtSentencesElement = new AdaptiveMtSentence();
        $adaptiveMtSentences = [
            $adaptiveMtSentencesElement,
        ];
        $expectedResponse = new ListAdaptiveMtSentencesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAdaptiveMtSentences($adaptiveMtSentences);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->adaptiveMtFileName('[PROJECT]', '[LOCATION]', '[DATASET]', '[FILE]');
        $request = (new ListAdaptiveMtSentencesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAdaptiveMtSentences($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdaptiveMtSentences()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/ListAdaptiveMtSentences', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdaptiveMtSentencesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->adaptiveMtFileName('[PROJECT]', '[LOCATION]', '[DATASET]', '[FILE]');
        $request = (new ListAdaptiveMtSentencesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAdaptiveMtSentences($request);
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
    public function listGlossariesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $glossariesElement = new Glossary();
        $glossaries = [
            $glossariesElement,
        ];
        $expectedResponse = new ListGlossariesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setGlossaries($glossaries);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListGlossariesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listGlossaries($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGlossaries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/ListGlossaries', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listGlossariesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListGlossariesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listGlossaries($request);
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
    public function translateDocumentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $model2 = 'model21226956956';
        $expectedResponse = new TranslateDocumentResponse();
        $expectedResponse->setModel($model2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $targetLanguageCode = 'targetLanguageCode1323228230';
        $documentInputConfig = new DocumentInputConfig();
        $request = (new TranslateDocumentRequest())
            ->setParent($parent)
            ->setTargetLanguageCode($targetLanguageCode)
            ->setDocumentInputConfig($documentInputConfig);
        $response = $gapicClient->translateDocument($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/TranslateDocument', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getTargetLanguageCode();
        $this->assertProtobufEquals($targetLanguageCode, $actualValue);
        $actualValue = $actualRequestObject->getDocumentInputConfig();
        $this->assertProtobufEquals($documentInputConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function translateDocumentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $parent = 'parent-995424086';
        $targetLanguageCode = 'targetLanguageCode1323228230';
        $documentInputConfig = new DocumentInputConfig();
        $request = (new TranslateDocumentRequest())
            ->setParent($parent)
            ->setTargetLanguageCode($targetLanguageCode)
            ->setDocumentInputConfig($documentInputConfig);
        try {
            $gapicClient->translateDocument($request);
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
    public function translateTextTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TranslateTextResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $contents = [];
        $targetLanguageCode = 'targetLanguageCode1323228230';
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new TranslateTextRequest())
            ->setContents($contents)
            ->setTargetLanguageCode($targetLanguageCode)
            ->setParent($formattedParent);
        $response = $gapicClient->translateText($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/TranslateText', $actualFuncCall);
        $actualValue = $actualRequestObject->getContents();
        $this->assertProtobufEquals($contents, $actualValue);
        $actualValue = $actualRequestObject->getTargetLanguageCode();
        $this->assertProtobufEquals($targetLanguageCode, $actualValue);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function translateTextExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $contents = [];
        $targetLanguageCode = 'targetLanguageCode1323228230';
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new TranslateTextRequest())
            ->setContents($contents)
            ->setTargetLanguageCode($targetLanguageCode)
            ->setParent($formattedParent);
        try {
            $gapicClient->translateText($request);
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
    public function adaptiveMtTranslateAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new AdaptiveMtTranslateResponse();
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedDataset = $gapicClient->adaptiveMtDatasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
        $content = [];
        $request = (new AdaptiveMtTranslateRequest())
            ->setParent($formattedParent)
            ->setDataset($formattedDataset)
            ->setContent($content);
        $response = $gapicClient->adaptiveMtTranslateAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.translation.v3.TranslationService/AdaptiveMtTranslate', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataset();
        $this->assertProtobufEquals($formattedDataset, $actualValue);
        $actualValue = $actualRequestObject->getContent();
        $this->assertProtobufEquals($content, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
