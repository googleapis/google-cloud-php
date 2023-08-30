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

namespace Google\Cloud\Recommender\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Recommender\V1\Client\RecommenderClient;
use Google\Cloud\Recommender\V1\GetInsightRequest;
use Google\Cloud\Recommender\V1\GetInsightTypeConfigRequest;
use Google\Cloud\Recommender\V1\GetRecommendationRequest;
use Google\Cloud\Recommender\V1\GetRecommenderConfigRequest;
use Google\Cloud\Recommender\V1\Insight;
use Google\Cloud\Recommender\V1\InsightTypeConfig;
use Google\Cloud\Recommender\V1\ListInsightsRequest;
use Google\Cloud\Recommender\V1\ListInsightsResponse;
use Google\Cloud\Recommender\V1\ListRecommendationsRequest;
use Google\Cloud\Recommender\V1\ListRecommendationsResponse;
use Google\Cloud\Recommender\V1\MarkInsightAcceptedRequest;
use Google\Cloud\Recommender\V1\MarkRecommendationClaimedRequest;
use Google\Cloud\Recommender\V1\MarkRecommendationDismissedRequest;
use Google\Cloud\Recommender\V1\MarkRecommendationFailedRequest;
use Google\Cloud\Recommender\V1\MarkRecommendationSucceededRequest;
use Google\Cloud\Recommender\V1\Recommendation;
use Google\Cloud\Recommender\V1\RecommenderConfig;
use Google\Cloud\Recommender\V1\UpdateInsightTypeConfigRequest;
use Google\Cloud\Recommender\V1\UpdateRecommenderConfigRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group recommender
 *
 * @group gapic
 */
class RecommenderClientTest extends GeneratedTest
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

    /** @return RecommenderClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new RecommenderClient($options);
    }

    /** @test */
    public function getInsightTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $insightSubtype = 'insightSubtype-1491142701';
        $etag = 'etag3123477';
        $expectedResponse = new Insight();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setInsightSubtype($insightSubtype);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->insightName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]', '[INSIGHT]');
        $request = (new GetInsightRequest())
            ->setName($formattedName);
        $response = $gapicClient->getInsight($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/GetInsight', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getInsightExceptionTest()
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
        $formattedName = $gapicClient->insightName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]', '[INSIGHT]');
        $request = (new GetInsightRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getInsight($request);
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
    public function getInsightTypeConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $etag = 'etag3123477';
        $revisionId = 'revisionId513861631';
        $displayName = 'displayName1615086568';
        $expectedResponse = new InsightTypeConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->insightTypeConfigName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]');
        $request = (new GetInsightTypeConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getInsightTypeConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/GetInsightTypeConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getInsightTypeConfigExceptionTest()
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
        $formattedName = $gapicClient->insightTypeConfigName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]');
        $request = (new GetInsightTypeConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getInsightTypeConfig($request);
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
    public function getRecommendationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $recommenderSubtype = 'recommenderSubtype-1488504412';
        $etag = 'etag3123477';
        $xorGroupId = 'xorGroupId381095487';
        $expectedResponse = new Recommendation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRecommenderSubtype($recommenderSubtype);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setXorGroupId($xorGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $request = (new GetRecommendationRequest())
            ->setName($formattedName);
        $response = $gapicClient->getRecommendation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/GetRecommendation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRecommendationExceptionTest()
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
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $request = (new GetRecommendationRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getRecommendation($request);
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
    public function getRecommenderConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $etag = 'etag3123477';
        $revisionId = 'revisionId513861631';
        $displayName = 'displayName1615086568';
        $expectedResponse = new RecommenderConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recommenderConfigName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]');
        $request = (new GetRecommenderConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getRecommenderConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/GetRecommenderConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRecommenderConfigExceptionTest()
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
        $formattedName = $gapicClient->recommenderConfigName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]');
        $request = (new GetRecommenderConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getRecommenderConfig($request);
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
    public function listInsightsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $insightsElement = new Insight();
        $insights = [
            $insightsElement,
        ];
        $expectedResponse = new ListInsightsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setInsights($insights);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->insightTypeName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]');
        $request = (new ListInsightsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listInsights($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getInsights()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/ListInsights', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listInsightsExceptionTest()
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
        $formattedParent = $gapicClient->insightTypeName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]');
        $request = (new ListInsightsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listInsights($request);
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
    public function listRecommendationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $recommendationsElement = new Recommendation();
        $recommendations = [
            $recommendationsElement,
        ];
        $expectedResponse = new ListRecommendationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRecommendations($recommendations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->recommenderName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]');
        $request = (new ListRecommendationsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listRecommendations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRecommendations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/ListRecommendations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRecommendationsExceptionTest()
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
        $formattedParent = $gapicClient->recommenderName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]');
        $request = (new ListRecommendationsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listRecommendations($request);
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
    public function markInsightAcceptedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $insightSubtype = 'insightSubtype-1491142701';
        $etag2 = 'etag2-1293302904';
        $expectedResponse = new Insight();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setInsightSubtype($insightSubtype);
        $expectedResponse->setEtag($etag2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->insightName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]', '[INSIGHT]');
        $etag = 'etag3123477';
        $request = (new MarkInsightAcceptedRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        $response = $gapicClient->markInsightAccepted($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/MarkInsightAccepted', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getEtag();
        $this->assertProtobufEquals($etag, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function markInsightAcceptedExceptionTest()
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
        $formattedName = $gapicClient->insightName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]', '[INSIGHT]');
        $etag = 'etag3123477';
        $request = (new MarkInsightAcceptedRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        try {
            $gapicClient->markInsightAccepted($request);
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
    public function markRecommendationClaimedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $recommenderSubtype = 'recommenderSubtype-1488504412';
        $etag2 = 'etag2-1293302904';
        $xorGroupId = 'xorGroupId381095487';
        $expectedResponse = new Recommendation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRecommenderSubtype($recommenderSubtype);
        $expectedResponse->setEtag($etag2);
        $expectedResponse->setXorGroupId($xorGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $etag = 'etag3123477';
        $request = (new MarkRecommendationClaimedRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        $response = $gapicClient->markRecommendationClaimed($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/MarkRecommendationClaimed', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getEtag();
        $this->assertProtobufEquals($etag, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function markRecommendationClaimedExceptionTest()
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
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $etag = 'etag3123477';
        $request = (new MarkRecommendationClaimedRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        try {
            $gapicClient->markRecommendationClaimed($request);
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
    public function markRecommendationDismissedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $recommenderSubtype = 'recommenderSubtype-1488504412';
        $etag2 = 'etag2-1293302904';
        $xorGroupId = 'xorGroupId381095487';
        $expectedResponse = new Recommendation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRecommenderSubtype($recommenderSubtype);
        $expectedResponse->setEtag($etag2);
        $expectedResponse->setXorGroupId($xorGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $request = (new MarkRecommendationDismissedRequest())
            ->setName($formattedName);
        $response = $gapicClient->markRecommendationDismissed($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/MarkRecommendationDismissed', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function markRecommendationDismissedExceptionTest()
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
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $request = (new MarkRecommendationDismissedRequest())
            ->setName($formattedName);
        try {
            $gapicClient->markRecommendationDismissed($request);
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
    public function markRecommendationFailedTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $recommenderSubtype = 'recommenderSubtype-1488504412';
        $etag2 = 'etag2-1293302904';
        $xorGroupId = 'xorGroupId381095487';
        $expectedResponse = new Recommendation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRecommenderSubtype($recommenderSubtype);
        $expectedResponse->setEtag($etag2);
        $expectedResponse->setXorGroupId($xorGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $etag = 'etag3123477';
        $request = (new MarkRecommendationFailedRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        $response = $gapicClient->markRecommendationFailed($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/MarkRecommendationFailed', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getEtag();
        $this->assertProtobufEquals($etag, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function markRecommendationFailedExceptionTest()
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
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $etag = 'etag3123477';
        $request = (new MarkRecommendationFailedRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        try {
            $gapicClient->markRecommendationFailed($request);
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
    public function markRecommendationSucceededTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $recommenderSubtype = 'recommenderSubtype-1488504412';
        $etag2 = 'etag2-1293302904';
        $xorGroupId = 'xorGroupId381095487';
        $expectedResponse = new Recommendation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setRecommenderSubtype($recommenderSubtype);
        $expectedResponse->setEtag($etag2);
        $expectedResponse->setXorGroupId($xorGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $etag = 'etag3123477';
        $request = (new MarkRecommendationSucceededRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        $response = $gapicClient->markRecommendationSucceeded($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/MarkRecommendationSucceeded', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getEtag();
        $this->assertProtobufEquals($etag, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function markRecommendationSucceededExceptionTest()
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
        $formattedName = $gapicClient->recommendationName('[PROJECT]', '[LOCATION]', '[RECOMMENDER]', '[RECOMMENDATION]');
        $etag = 'etag3123477';
        $request = (new MarkRecommendationSucceededRequest())
            ->setName($formattedName)
            ->setEtag($etag);
        try {
            $gapicClient->markRecommendationSucceeded($request);
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
    public function updateInsightTypeConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $etag = 'etag3123477';
        $revisionId = 'revisionId513861631';
        $displayName = 'displayName1615086568';
        $expectedResponse = new InsightTypeConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $insightTypeConfig = new InsightTypeConfig();
        $request = (new UpdateInsightTypeConfigRequest())
            ->setInsightTypeConfig($insightTypeConfig);
        $response = $gapicClient->updateInsightTypeConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/UpdateInsightTypeConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getInsightTypeConfig();
        $this->assertProtobufEquals($insightTypeConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateInsightTypeConfigExceptionTest()
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
        $insightTypeConfig = new InsightTypeConfig();
        $request = (new UpdateInsightTypeConfigRequest())
            ->setInsightTypeConfig($insightTypeConfig);
        try {
            $gapicClient->updateInsightTypeConfig($request);
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
    public function updateRecommenderConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $etag = 'etag3123477';
        $revisionId = 'revisionId513861631';
        $displayName = 'displayName1615086568';
        $expectedResponse = new RecommenderConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setRevisionId($revisionId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $recommenderConfig = new RecommenderConfig();
        $request = (new UpdateRecommenderConfigRequest())
            ->setRecommenderConfig($recommenderConfig);
        $response = $gapicClient->updateRecommenderConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/UpdateRecommenderConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getRecommenderConfig();
        $this->assertProtobufEquals($recommenderConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateRecommenderConfigExceptionTest()
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
        $recommenderConfig = new RecommenderConfig();
        $request = (new UpdateRecommenderConfigRequest())
            ->setRecommenderConfig($recommenderConfig);
        try {
            $gapicClient->updateRecommenderConfig($request);
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
    public function getInsightAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $insightSubtype = 'insightSubtype-1491142701';
        $etag = 'etag3123477';
        $expectedResponse = new Insight();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setInsightSubtype($insightSubtype);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->insightName('[PROJECT]', '[LOCATION]', '[INSIGHT_TYPE]', '[INSIGHT]');
        $request = (new GetInsightRequest())
            ->setName($formattedName);
        $response = $gapicClient->getInsightAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommender.v1.Recommender/GetInsight', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
