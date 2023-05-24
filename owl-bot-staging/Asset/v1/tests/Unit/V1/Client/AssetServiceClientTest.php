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

namespace Google\Cloud\Asset\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Asset\V1\AnalyzeIamPolicyLongrunningRequest;
use Google\Cloud\Asset\V1\AnalyzeIamPolicyLongrunningResponse;
use Google\Cloud\Asset\V1\AnalyzeIamPolicyRequest;
use Google\Cloud\Asset\V1\AnalyzeIamPolicyResponse;
use Google\Cloud\Asset\V1\AnalyzeMoveRequest;
use Google\Cloud\Asset\V1\AnalyzeMoveResponse;
use Google\Cloud\Asset\V1\AnalyzeOrgPoliciesRequest;
use Google\Cloud\Asset\V1\AnalyzeOrgPoliciesResponse;
use Google\Cloud\Asset\V1\AnalyzeOrgPoliciesResponse\OrgPolicyResult;
use Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedAssetsRequest;
use Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedAssetsResponse;
use Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedAssetsResponse\GovernedAsset;
use Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedContainersRequest;
use Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedContainersResponse;
use Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedContainersResponse\GovernedContainer;
use Google\Cloud\Asset\V1\Asset;
use Google\Cloud\Asset\V1\BatchGetAssetsHistoryRequest;
use Google\Cloud\Asset\V1\BatchGetAssetsHistoryResponse;
use Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesRequest;
use Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesResponse;
use Google\Cloud\Asset\V1\Client\AssetServiceClient;
use Google\Cloud\Asset\V1\ContentType;
use Google\Cloud\Asset\V1\CreateFeedRequest;
use Google\Cloud\Asset\V1\CreateSavedQueryRequest;
use Google\Cloud\Asset\V1\DeleteFeedRequest;
use Google\Cloud\Asset\V1\DeleteSavedQueryRequest;
use Google\Cloud\Asset\V1\ExportAssetsRequest;
use Google\Cloud\Asset\V1\ExportAssetsResponse;
use Google\Cloud\Asset\V1\Feed;
use Google\Cloud\Asset\V1\FeedOutputConfig;
use Google\Cloud\Asset\V1\GetFeedRequest;
use Google\Cloud\Asset\V1\GetSavedQueryRequest;
use Google\Cloud\Asset\V1\IamPolicyAnalysisOutputConfig;
use Google\Cloud\Asset\V1\IamPolicyAnalysisQuery;
use Google\Cloud\Asset\V1\IamPolicySearchResult;
use Google\Cloud\Asset\V1\ListAssetsRequest;
use Google\Cloud\Asset\V1\ListAssetsResponse;
use Google\Cloud\Asset\V1\ListFeedsRequest;
use Google\Cloud\Asset\V1\ListFeedsResponse;
use Google\Cloud\Asset\V1\ListSavedQueriesRequest;
use Google\Cloud\Asset\V1\ListSavedQueriesResponse;
use Google\Cloud\Asset\V1\OutputConfig;
use Google\Cloud\Asset\V1\QueryAssetsRequest;
use Google\Cloud\Asset\V1\QueryAssetsResponse;
use Google\Cloud\Asset\V1\ResourceSearchResult;
use Google\Cloud\Asset\V1\SavedQuery;
use Google\Cloud\Asset\V1\SearchAllIamPoliciesRequest;
use Google\Cloud\Asset\V1\SearchAllIamPoliciesResponse;
use Google\Cloud\Asset\V1\SearchAllResourcesRequest;
use Google\Cloud\Asset\V1\SearchAllResourcesResponse;
use Google\Cloud\Asset\V1\TimeWindow;
use Google\Cloud\Asset\V1\UpdateFeedRequest;
use Google\Cloud\Asset\V1\UpdateSavedQueryRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group asset
 *
 * @group gapic
 */
class AssetServiceClientTest extends GeneratedTest
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

    /** @return AssetServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AssetServiceClient($options);
    }

    /** @test */
    public function analyzeIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $fullyExplored = true;
        $expectedResponse = new AnalyzeIamPolicyResponse();
        $expectedResponse->setFullyExplored($fullyExplored);
        $transport->addResponse($expectedResponse);
        // Mock request
        $analysisQuery = new IamPolicyAnalysisQuery();
        $analysisQueryScope = 'analysisQueryScope-495018392';
        $analysisQuery->setScope($analysisQueryScope);
        $request = (new AnalyzeIamPolicyRequest())
            ->setAnalysisQuery($analysisQuery);
        $response = $gapicClient->analyzeIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getAnalysisQuery();
        $this->assertProtobufEquals($analysisQuery, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeIamPolicyExceptionTest()
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
        $analysisQuery = new IamPolicyAnalysisQuery();
        $analysisQueryScope = 'analysisQueryScope-495018392';
        $analysisQuery->setScope($analysisQueryScope);
        $request = (new AnalyzeIamPolicyRequest())
            ->setAnalysisQuery($analysisQuery);
        try {
            $gapicClient->analyzeIamPolicy($request);
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
    public function analyzeIamPolicyLongrunningTest()
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
        $incompleteOperation->setName('operations/analyzeIamPolicyLongrunningTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new AnalyzeIamPolicyLongrunningResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/analyzeIamPolicyLongrunningTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $analysisQuery = new IamPolicyAnalysisQuery();
        $analysisQueryScope = 'analysisQueryScope-495018392';
        $analysisQuery->setScope($analysisQueryScope);
        $outputConfig = new IamPolicyAnalysisOutputConfig();
        $request = (new AnalyzeIamPolicyLongrunningRequest())
            ->setAnalysisQuery($analysisQuery)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->analyzeIamPolicyLongrunning($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeIamPolicyLongrunning', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAnalysisQuery();
        $this->assertProtobufEquals($analysisQuery, $actualValue);
        $actualValue = $actualApiRequestObject->getOutputConfig();
        $this->assertProtobufEquals($outputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/analyzeIamPolicyLongrunningTest');
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
    public function analyzeIamPolicyLongrunningExceptionTest()
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
        $incompleteOperation->setName('operations/analyzeIamPolicyLongrunningTest');
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
        $analysisQuery = new IamPolicyAnalysisQuery();
        $analysisQueryScope = 'analysisQueryScope-495018392';
        $analysisQuery->setScope($analysisQueryScope);
        $outputConfig = new IamPolicyAnalysisOutputConfig();
        $request = (new AnalyzeIamPolicyLongrunningRequest())
            ->setAnalysisQuery($analysisQuery)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->analyzeIamPolicyLongrunning($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/analyzeIamPolicyLongrunningTest');
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
    public function analyzeMoveTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AnalyzeMoveResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $destinationParent = 'destinationParent-1362053637';
        $request = (new AnalyzeMoveRequest())
            ->setResource($resource)
            ->setDestinationParent($destinationParent);
        $response = $gapicClient->analyzeMove($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeMove', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getDestinationParent();
        $this->assertProtobufEquals($destinationParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeMoveExceptionTest()
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
        $resource = 'resource-341064690';
        $destinationParent = 'destinationParent-1362053637';
        $request = (new AnalyzeMoveRequest())
            ->setResource($resource)
            ->setDestinationParent($destinationParent);
        try {
            $gapicClient->analyzeMove($request);
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
    public function analyzeOrgPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $orgPolicyResultsElement = new OrgPolicyResult();
        $orgPolicyResults = [
            $orgPolicyResultsElement,
        ];
        $expectedResponse = new AnalyzeOrgPoliciesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOrgPolicyResults($orgPolicyResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $constraint = 'constraint-190376483';
        $request = (new AnalyzeOrgPoliciesRequest())
            ->setScope($scope)
            ->setConstraint($constraint);
        $response = $gapicClient->analyzeOrgPolicies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOrgPolicyResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeOrgPolicies', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getConstraint();
        $this->assertProtobufEquals($constraint, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeOrgPoliciesExceptionTest()
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
        $scope = 'scope109264468';
        $constraint = 'constraint-190376483';
        $request = (new AnalyzeOrgPoliciesRequest())
            ->setScope($scope)
            ->setConstraint($constraint);
        try {
            $gapicClient->analyzeOrgPolicies($request);
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
    public function analyzeOrgPolicyGovernedAssetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $governedAssetsElement = new GovernedAsset();
        $governedAssets = [
            $governedAssetsElement,
        ];
        $expectedResponse = new AnalyzeOrgPolicyGovernedAssetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setGovernedAssets($governedAssets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $constraint = 'constraint-190376483';
        $request = (new AnalyzeOrgPolicyGovernedAssetsRequest())
            ->setScope($scope)
            ->setConstraint($constraint);
        $response = $gapicClient->analyzeOrgPolicyGovernedAssets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGovernedAssets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeOrgPolicyGovernedAssets', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getConstraint();
        $this->assertProtobufEquals($constraint, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeOrgPolicyGovernedAssetsExceptionTest()
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
        $scope = 'scope109264468';
        $constraint = 'constraint-190376483';
        $request = (new AnalyzeOrgPolicyGovernedAssetsRequest())
            ->setScope($scope)
            ->setConstraint($constraint);
        try {
            $gapicClient->analyzeOrgPolicyGovernedAssets($request);
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
    public function analyzeOrgPolicyGovernedContainersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $governedContainersElement = new GovernedContainer();
        $governedContainers = [
            $governedContainersElement,
        ];
        $expectedResponse = new AnalyzeOrgPolicyGovernedContainersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setGovernedContainers($governedContainers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $constraint = 'constraint-190376483';
        $request = (new AnalyzeOrgPolicyGovernedContainersRequest())
            ->setScope($scope)
            ->setConstraint($constraint);
        $response = $gapicClient->analyzeOrgPolicyGovernedContainers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGovernedContainers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeOrgPolicyGovernedContainers', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getConstraint();
        $this->assertProtobufEquals($constraint, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function analyzeOrgPolicyGovernedContainersExceptionTest()
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
        $scope = 'scope109264468';
        $constraint = 'constraint-190376483';
        $request = (new AnalyzeOrgPolicyGovernedContainersRequest())
            ->setScope($scope)
            ->setConstraint($constraint);
        try {
            $gapicClient->analyzeOrgPolicyGovernedContainers($request);
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
    public function batchGetAssetsHistoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchGetAssetsHistoryResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $contentType = ContentType::CONTENT_TYPE_UNSPECIFIED;
        $readTimeWindow = new TimeWindow();
        $request = (new BatchGetAssetsHistoryRequest())
            ->setParent($parent)
            ->setContentType($contentType)
            ->setReadTimeWindow($readTimeWindow);
        $response = $gapicClient->batchGetAssetsHistory($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/BatchGetAssetsHistory', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getContentType();
        $this->assertProtobufEquals($contentType, $actualValue);
        $actualValue = $actualRequestObject->getReadTimeWindow();
        $this->assertProtobufEquals($readTimeWindow, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchGetAssetsHistoryExceptionTest()
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
        $contentType = ContentType::CONTENT_TYPE_UNSPECIFIED;
        $readTimeWindow = new TimeWindow();
        $request = (new BatchGetAssetsHistoryRequest())
            ->setParent($parent)
            ->setContentType($contentType)
            ->setReadTimeWindow($readTimeWindow);
        try {
            $gapicClient->batchGetAssetsHistory($request);
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
    public function batchGetEffectiveIamPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchGetEffectiveIamPoliciesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $names = [];
        $request = (new BatchGetEffectiveIamPoliciesRequest())
            ->setScope($scope)
            ->setNames($names);
        $response = $gapicClient->batchGetEffectiveIamPolicies($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/BatchGetEffectiveIamPolicies', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($names, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchGetEffectiveIamPoliciesExceptionTest()
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
        $scope = 'scope109264468';
        $names = [];
        $request = (new BatchGetEffectiveIamPoliciesRequest())
            ->setScope($scope)
            ->setNames($names);
        try {
            $gapicClient->batchGetEffectiveIamPolicies($request);
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
    public function createFeedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Feed();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $feedId = 'feedId-976011428';
        $feed = new Feed();
        $feedName = 'feedName-192096951';
        $feed->setName($feedName);
        $feedFeedOutputConfig = new FeedOutputConfig();
        $feed->setFeedOutputConfig($feedFeedOutputConfig);
        $request = (new CreateFeedRequest())
            ->setParent($parent)
            ->setFeedId($feedId)
            ->setFeed($feed);
        $response = $gapicClient->createFeed($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/CreateFeed', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getFeedId();
        $this->assertProtobufEquals($feedId, $actualValue);
        $actualValue = $actualRequestObject->getFeed();
        $this->assertProtobufEquals($feed, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createFeedExceptionTest()
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
        $feedId = 'feedId-976011428';
        $feed = new Feed();
        $feedName = 'feedName-192096951';
        $feed->setName($feedName);
        $feedFeedOutputConfig = new FeedOutputConfig();
        $feed->setFeedOutputConfig($feedFeedOutputConfig);
        $request = (new CreateFeedRequest())
            ->setParent($parent)
            ->setFeedId($feedId)
            ->setFeed($feed);
        try {
            $gapicClient->createFeed($request);
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
    public function createSavedQueryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $creator = 'creator1028554796';
        $lastUpdater = 'lastUpdater338699296';
        $expectedResponse = new SavedQuery();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreator($creator);
        $expectedResponse->setLastUpdater($lastUpdater);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $savedQuery = new SavedQuery();
        $savedQueryId = 'savedQueryId1290759850';
        $request = (new CreateSavedQueryRequest())
            ->setParent($formattedParent)
            ->setSavedQuery($savedQuery)
            ->setSavedQueryId($savedQueryId);
        $response = $gapicClient->createSavedQuery($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/CreateSavedQuery', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSavedQuery();
        $this->assertProtobufEquals($savedQuery, $actualValue);
        $actualValue = $actualRequestObject->getSavedQueryId();
        $this->assertProtobufEquals($savedQueryId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSavedQueryExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $savedQuery = new SavedQuery();
        $savedQueryId = 'savedQueryId1290759850';
        $request = (new CreateSavedQueryRequest())
            ->setParent($formattedParent)
            ->setSavedQuery($savedQuery)
            ->setSavedQueryId($savedQueryId);
        try {
            $gapicClient->createSavedQuery($request);
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
    public function deleteFeedTest()
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
        $formattedName = $gapicClient->feedName('[PROJECT]', '[FEED]');
        $request = (new DeleteFeedRequest())
            ->setName($formattedName);
        $gapicClient->deleteFeed($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/DeleteFeed', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteFeedExceptionTest()
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
        $formattedName = $gapicClient->feedName('[PROJECT]', '[FEED]');
        $request = (new DeleteFeedRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteFeed($request);
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
    public function deleteSavedQueryTest()
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
        $formattedName = $gapicClient->savedQueryName('[PROJECT]', '[SAVED_QUERY]');
        $request = (new DeleteSavedQueryRequest())
            ->setName($formattedName);
        $gapicClient->deleteSavedQuery($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/DeleteSavedQuery', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSavedQueryExceptionTest()
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
        $formattedName = $gapicClient->savedQueryName('[PROJECT]', '[SAVED_QUERY]');
        $request = (new DeleteSavedQueryRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteSavedQuery($request);
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
    public function exportAssetsTest()
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
        $incompleteOperation->setName('operations/exportAssetsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new ExportAssetsResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/exportAssetsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $parent = 'parent-995424086';
        $outputConfig = new OutputConfig();
        $request = (new ExportAssetsRequest())
            ->setParent($parent)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->exportAssets($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/ExportAssets', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualApiRequestObject->getOutputConfig();
        $this->assertProtobufEquals($outputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportAssetsTest');
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
    public function exportAssetsExceptionTest()
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
        $incompleteOperation->setName('operations/exportAssetsTest');
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
        $parent = 'parent-995424086';
        $outputConfig = new OutputConfig();
        $request = (new ExportAssetsRequest())
            ->setParent($parent)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->exportAssets($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportAssetsTest');
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
    public function getFeedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new Feed();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->feedName('[PROJECT]', '[FEED]');
        $request = (new GetFeedRequest())
            ->setName($formattedName);
        $response = $gapicClient->getFeed($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/GetFeed', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFeedExceptionTest()
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
        $formattedName = $gapicClient->feedName('[PROJECT]', '[FEED]');
        $request = (new GetFeedRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getFeed($request);
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
    public function getSavedQueryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $creator = 'creator1028554796';
        $lastUpdater = 'lastUpdater338699296';
        $expectedResponse = new SavedQuery();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreator($creator);
        $expectedResponse->setLastUpdater($lastUpdater);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->savedQueryName('[PROJECT]', '[SAVED_QUERY]');
        $request = (new GetSavedQueryRequest())
            ->setName($formattedName);
        $response = $gapicClient->getSavedQuery($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/GetSavedQuery', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSavedQueryExceptionTest()
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
        $formattedName = $gapicClient->savedQueryName('[PROJECT]', '[SAVED_QUERY]');
        $request = (new GetSavedQueryRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getSavedQuery($request);
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
    public function listAssetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $assetsElement = new Asset();
        $assets = [
            $assetsElement,
        ];
        $expectedResponse = new ListAssetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAssets($assets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListAssetsRequest())
            ->setParent($parent);
        $response = $gapicClient->listAssets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAssets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/ListAssets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAssetsExceptionTest()
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
        $request = (new ListAssetsRequest())
            ->setParent($parent);
        try {
            $gapicClient->listAssets($request);
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
    public function listFeedsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListFeedsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListFeedsRequest())
            ->setParent($parent);
        $response = $gapicClient->listFeeds($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/ListFeeds', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFeedsExceptionTest()
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
        $request = (new ListFeedsRequest())
            ->setParent($parent);
        try {
            $gapicClient->listFeeds($request);
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
    public function listSavedQueriesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $savedQueriesElement = new SavedQuery();
        $savedQueries = [
            $savedQueriesElement,
        ];
        $expectedResponse = new ListSavedQueriesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSavedQueries($savedQueries);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListSavedQueriesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listSavedQueries($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSavedQueries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/ListSavedQueries', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSavedQueriesExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListSavedQueriesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listSavedQueries($request);
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
    public function queryAssetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $jobReference = 'jobReference-2014311095';
        $done = true;
        $expectedResponse = new QueryAssetsResponse();
        $expectedResponse->setJobReference($jobReference);
        $expectedResponse->setDone($done);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new QueryAssetsRequest())
            ->setParent($parent);
        $response = $gapicClient->queryAssets($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/QueryAssets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryAssetsExceptionTest()
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
        $request = (new QueryAssetsRequest())
            ->setParent($parent);
        try {
            $gapicClient->queryAssets($request);
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
    public function searchAllIamPoliciesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $resultsElement = new IamPolicySearchResult();
        $results = [
            $resultsElement,
        ];
        $expectedResponse = new SearchAllIamPoliciesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setResults($results);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $request = (new SearchAllIamPoliciesRequest())
            ->setScope($scope);
        $response = $gapicClient->searchAllIamPolicies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/SearchAllIamPolicies', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchAllIamPoliciesExceptionTest()
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
        $scope = 'scope109264468';
        $request = (new SearchAllIamPoliciesRequest())
            ->setScope($scope);
        try {
            $gapicClient->searchAllIamPolicies($request);
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
    public function searchAllResourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $resultsElement = new ResourceSearchResult();
        $results = [
            $resultsElement,
        ];
        $expectedResponse = new SearchAllResourcesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setResults($results);
        $transport->addResponse($expectedResponse);
        // Mock request
        $scope = 'scope109264468';
        $request = (new SearchAllResourcesRequest())
            ->setScope($scope);
        $response = $gapicClient->searchAllResources($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/SearchAllResources', $actualFuncCall);
        $actualValue = $actualRequestObject->getScope();
        $this->assertProtobufEquals($scope, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchAllResourcesExceptionTest()
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
        $scope = 'scope109264468';
        $request = (new SearchAllResourcesRequest())
            ->setScope($scope);
        try {
            $gapicClient->searchAllResources($request);
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
    public function updateFeedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new Feed();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $feed = new Feed();
        $feedName = 'feedName-192096951';
        $feed->setName($feedName);
        $feedFeedOutputConfig = new FeedOutputConfig();
        $feed->setFeedOutputConfig($feedFeedOutputConfig);
        $updateMask = new FieldMask();
        $request = (new UpdateFeedRequest())
            ->setFeed($feed)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateFeed($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/UpdateFeed', $actualFuncCall);
        $actualValue = $actualRequestObject->getFeed();
        $this->assertProtobufEquals($feed, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateFeedExceptionTest()
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
        $feed = new Feed();
        $feedName = 'feedName-192096951';
        $feed->setName($feedName);
        $feedFeedOutputConfig = new FeedOutputConfig();
        $feed->setFeedOutputConfig($feedFeedOutputConfig);
        $updateMask = new FieldMask();
        $request = (new UpdateFeedRequest())
            ->setFeed($feed)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateFeed($request);
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
    public function updateSavedQueryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $creator = 'creator1028554796';
        $lastUpdater = 'lastUpdater338699296';
        $expectedResponse = new SavedQuery();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreator($creator);
        $expectedResponse->setLastUpdater($lastUpdater);
        $transport->addResponse($expectedResponse);
        // Mock request
        $savedQuery = new SavedQuery();
        $updateMask = new FieldMask();
        $request = (new UpdateSavedQueryRequest())
            ->setSavedQuery($savedQuery)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateSavedQuery($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/UpdateSavedQuery', $actualFuncCall);
        $actualValue = $actualRequestObject->getSavedQuery();
        $this->assertProtobufEquals($savedQuery, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSavedQueryExceptionTest()
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
        $savedQuery = new SavedQuery();
        $updateMask = new FieldMask();
        $request = (new UpdateSavedQueryRequest())
            ->setSavedQuery($savedQuery)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateSavedQuery($request);
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
    public function analyzeIamPolicyAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $fullyExplored = true;
        $expectedResponse = new AnalyzeIamPolicyResponse();
        $expectedResponse->setFullyExplored($fullyExplored);
        $transport->addResponse($expectedResponse);
        // Mock request
        $analysisQuery = new IamPolicyAnalysisQuery();
        $analysisQueryScope = 'analysisQueryScope-495018392';
        $analysisQuery->setScope($analysisQueryScope);
        $request = (new AnalyzeIamPolicyRequest())
            ->setAnalysisQuery($analysisQuery);
        $response = $gapicClient->analyzeIamPolicyAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.asset.v1.AssetService/AnalyzeIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getAnalysisQuery();
        $this->assertProtobufEquals($analysisQuery, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
