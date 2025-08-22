<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Cloud\Dataform\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dataform\V1\CancelWorkflowInvocationRequest;
use Google\Cloud\Dataform\V1\CancelWorkflowInvocationResponse;
use Google\Cloud\Dataform\V1\Client\DataformClient;
use Google\Cloud\Dataform\V1\CommitAuthor;
use Google\Cloud\Dataform\V1\CommitLogEntry;
use Google\Cloud\Dataform\V1\CommitMetadata;
use Google\Cloud\Dataform\V1\CommitRepositoryChangesRequest;
use Google\Cloud\Dataform\V1\CommitRepositoryChangesResponse;
use Google\Cloud\Dataform\V1\CommitWorkspaceChangesRequest;
use Google\Cloud\Dataform\V1\CommitWorkspaceChangesResponse;
use Google\Cloud\Dataform\V1\CompilationResult;
use Google\Cloud\Dataform\V1\CompilationResultAction;
use Google\Cloud\Dataform\V1\ComputeRepositoryAccessTokenStatusRequest;
use Google\Cloud\Dataform\V1\ComputeRepositoryAccessTokenStatusResponse;
use Google\Cloud\Dataform\V1\Config;
use Google\Cloud\Dataform\V1\CreateCompilationResultRequest;
use Google\Cloud\Dataform\V1\CreateReleaseConfigRequest;
use Google\Cloud\Dataform\V1\CreateRepositoryRequest;
use Google\Cloud\Dataform\V1\CreateWorkflowConfigRequest;
use Google\Cloud\Dataform\V1\CreateWorkflowInvocationRequest;
use Google\Cloud\Dataform\V1\CreateWorkspaceRequest;
use Google\Cloud\Dataform\V1\DeleteReleaseConfigRequest;
use Google\Cloud\Dataform\V1\DeleteRepositoryRequest;
use Google\Cloud\Dataform\V1\DeleteWorkflowConfigRequest;
use Google\Cloud\Dataform\V1\DeleteWorkflowInvocationRequest;
use Google\Cloud\Dataform\V1\DeleteWorkspaceRequest;
use Google\Cloud\Dataform\V1\DirectoryEntry;
use Google\Cloud\Dataform\V1\FetchFileDiffRequest;
use Google\Cloud\Dataform\V1\FetchFileDiffResponse;
use Google\Cloud\Dataform\V1\FetchFileGitStatusesRequest;
use Google\Cloud\Dataform\V1\FetchFileGitStatusesResponse;
use Google\Cloud\Dataform\V1\FetchGitAheadBehindRequest;
use Google\Cloud\Dataform\V1\FetchGitAheadBehindResponse;
use Google\Cloud\Dataform\V1\FetchRemoteBranchesRequest;
use Google\Cloud\Dataform\V1\FetchRemoteBranchesResponse;
use Google\Cloud\Dataform\V1\FetchRepositoryHistoryRequest;
use Google\Cloud\Dataform\V1\FetchRepositoryHistoryResponse;
use Google\Cloud\Dataform\V1\GetCompilationResultRequest;
use Google\Cloud\Dataform\V1\GetConfigRequest;
use Google\Cloud\Dataform\V1\GetReleaseConfigRequest;
use Google\Cloud\Dataform\V1\GetRepositoryRequest;
use Google\Cloud\Dataform\V1\GetWorkflowConfigRequest;
use Google\Cloud\Dataform\V1\GetWorkflowInvocationRequest;
use Google\Cloud\Dataform\V1\GetWorkspaceRequest;
use Google\Cloud\Dataform\V1\InstallNpmPackagesRequest;
use Google\Cloud\Dataform\V1\InstallNpmPackagesResponse;
use Google\Cloud\Dataform\V1\ListCompilationResultsRequest;
use Google\Cloud\Dataform\V1\ListCompilationResultsResponse;
use Google\Cloud\Dataform\V1\ListReleaseConfigsRequest;
use Google\Cloud\Dataform\V1\ListReleaseConfigsResponse;
use Google\Cloud\Dataform\V1\ListRepositoriesRequest;
use Google\Cloud\Dataform\V1\ListRepositoriesResponse;
use Google\Cloud\Dataform\V1\ListWorkflowConfigsRequest;
use Google\Cloud\Dataform\V1\ListWorkflowConfigsResponse;
use Google\Cloud\Dataform\V1\ListWorkflowInvocationsRequest;
use Google\Cloud\Dataform\V1\ListWorkflowInvocationsResponse;
use Google\Cloud\Dataform\V1\ListWorkspacesRequest;
use Google\Cloud\Dataform\V1\ListWorkspacesResponse;
use Google\Cloud\Dataform\V1\MakeDirectoryRequest;
use Google\Cloud\Dataform\V1\MakeDirectoryResponse;
use Google\Cloud\Dataform\V1\MoveDirectoryRequest;
use Google\Cloud\Dataform\V1\MoveDirectoryResponse;
use Google\Cloud\Dataform\V1\MoveFileRequest;
use Google\Cloud\Dataform\V1\MoveFileResponse;
use Google\Cloud\Dataform\V1\PullGitCommitsRequest;
use Google\Cloud\Dataform\V1\PullGitCommitsResponse;
use Google\Cloud\Dataform\V1\PushGitCommitsRequest;
use Google\Cloud\Dataform\V1\PushGitCommitsResponse;
use Google\Cloud\Dataform\V1\QueryCompilationResultActionsRequest;
use Google\Cloud\Dataform\V1\QueryCompilationResultActionsResponse;
use Google\Cloud\Dataform\V1\QueryDirectoryContentsRequest;
use Google\Cloud\Dataform\V1\QueryDirectoryContentsResponse;
use Google\Cloud\Dataform\V1\QueryRepositoryDirectoryContentsRequest;
use Google\Cloud\Dataform\V1\QueryRepositoryDirectoryContentsResponse;
use Google\Cloud\Dataform\V1\QueryWorkflowInvocationActionsRequest;
use Google\Cloud\Dataform\V1\QueryWorkflowInvocationActionsResponse;
use Google\Cloud\Dataform\V1\ReadFileRequest;
use Google\Cloud\Dataform\V1\ReadFileResponse;
use Google\Cloud\Dataform\V1\ReadRepositoryFileRequest;
use Google\Cloud\Dataform\V1\ReadRepositoryFileResponse;
use Google\Cloud\Dataform\V1\ReleaseConfig;
use Google\Cloud\Dataform\V1\RemoveDirectoryRequest;
use Google\Cloud\Dataform\V1\RemoveDirectoryResponse;
use Google\Cloud\Dataform\V1\RemoveFileRequest;
use Google\Cloud\Dataform\V1\RemoveFileResponse;
use Google\Cloud\Dataform\V1\Repository;
use Google\Cloud\Dataform\V1\ResetWorkspaceChangesRequest;
use Google\Cloud\Dataform\V1\ResetWorkspaceChangesResponse;
use Google\Cloud\Dataform\V1\SearchFilesRequest;
use Google\Cloud\Dataform\V1\SearchFilesResponse;
use Google\Cloud\Dataform\V1\SearchResult;
use Google\Cloud\Dataform\V1\UpdateConfigRequest;
use Google\Cloud\Dataform\V1\UpdateReleaseConfigRequest;
use Google\Cloud\Dataform\V1\UpdateRepositoryRequest;
use Google\Cloud\Dataform\V1\UpdateWorkflowConfigRequest;
use Google\Cloud\Dataform\V1\WorkflowConfig;
use Google\Cloud\Dataform\V1\WorkflowInvocation;
use Google\Cloud\Dataform\V1\WorkflowInvocationAction;
use Google\Cloud\Dataform\V1\Workspace;
use Google\Cloud\Dataform\V1\WriteFileRequest;
use Google\Cloud\Dataform\V1\WriteFileResponse;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dataform
 *
 * @group gapic
 */
class DataformClientTest extends GeneratedTest
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

    /** @return DataformClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataformClient($options);
    }

    /** @test */
    public function cancelWorkflowInvocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CancelWorkflowInvocationResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new CancelWorkflowInvocationRequest())->setName($formattedName);
        $response = $gapicClient->cancelWorkflowInvocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CancelWorkflowInvocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelWorkflowInvocationExceptionTest()
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
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new CancelWorkflowInvocationRequest())->setName($formattedName);
        try {
            $gapicClient->cancelWorkflowInvocation($request);
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
    public function commitRepositoryChangesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $commitSha = 'commitSha1018601892';
        $expectedResponse = new CommitRepositoryChangesResponse();
        $expectedResponse->setCommitSha($commitSha);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $commitMetadata = new CommitMetadata();
        $commitMetadataAuthor = new CommitAuthor();
        $authorName = 'authorName-1501539658';
        $commitMetadataAuthor->setName($authorName);
        $authorEmailAddress = 'authorEmailAddress-6398493';
        $commitMetadataAuthor->setEmailAddress($authorEmailAddress);
        $commitMetadata->setAuthor($commitMetadataAuthor);
        $request = (new CommitRepositoryChangesRequest())->setName($formattedName)->setCommitMetadata($commitMetadata);
        $response = $gapicClient->commitRepositoryChanges($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CommitRepositoryChanges', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getCommitMetadata();
        $this->assertProtobufEquals($commitMetadata, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function commitRepositoryChangesExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $commitMetadata = new CommitMetadata();
        $commitMetadataAuthor = new CommitAuthor();
        $authorName = 'authorName-1501539658';
        $commitMetadataAuthor->setName($authorName);
        $authorEmailAddress = 'authorEmailAddress-6398493';
        $commitMetadataAuthor->setEmailAddress($authorEmailAddress);
        $commitMetadata->setAuthor($commitMetadataAuthor);
        $request = (new CommitRepositoryChangesRequest())->setName($formattedName)->setCommitMetadata($commitMetadata);
        try {
            $gapicClient->commitRepositoryChanges($request);
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
    public function commitWorkspaceChangesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CommitWorkspaceChangesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $author = new CommitAuthor();
        $authorName = 'authorName-1501539658';
        $author->setName($authorName);
        $authorEmailAddress = 'authorEmailAddress-6398493';
        $author->setEmailAddress($authorEmailAddress);
        $request = (new CommitWorkspaceChangesRequest())->setName($formattedName)->setAuthor($author);
        $response = $gapicClient->commitWorkspaceChanges($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CommitWorkspaceChanges', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getAuthor();
        $this->assertProtobufEquals($author, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function commitWorkspaceChangesExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $author = new CommitAuthor();
        $authorName = 'authorName-1501539658';
        $author->setName($authorName);
        $authorEmailAddress = 'authorEmailAddress-6398493';
        $author->setEmailAddress($authorEmailAddress);
        $request = (new CommitWorkspaceChangesRequest())->setName($formattedName)->setAuthor($author);
        try {
            $gapicClient->commitWorkspaceChanges($request);
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
    public function computeRepositoryAccessTokenStatusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ComputeRepositoryAccessTokenStatusResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ComputeRepositoryAccessTokenStatusRequest())->setName($formattedName);
        $response = $gapicClient->computeRepositoryAccessTokenStatus($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ComputeRepositoryAccessTokenStatus', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function computeRepositoryAccessTokenStatusExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ComputeRepositoryAccessTokenStatusRequest())->setName($formattedName);
        try {
            $gapicClient->computeRepositoryAccessTokenStatus($request);
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
    public function createCompilationResultTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $gitCommitish = 'gitCommitish-459981894';
        $name = 'name3373707';
        $resolvedGitCommitSha = 'resolvedGitCommitSha-1974209704';
        $dataformCoreVersion = 'dataformCoreVersion1918089577';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new CompilationResult();
        $expectedResponse->setGitCommitish($gitCommitish);
        $expectedResponse->setName($name);
        $expectedResponse->setResolvedGitCommitSha($resolvedGitCommitSha);
        $expectedResponse->setDataformCoreVersion($dataformCoreVersion);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $compilationResult = new CompilationResult();
        $request = (new CreateCompilationResultRequest())
            ->setParent($formattedParent)
            ->setCompilationResult($compilationResult);
        $response = $gapicClient->createCompilationResult($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CreateCompilationResult', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCompilationResult();
        $this->assertProtobufEquals($compilationResult, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCompilationResultExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $compilationResult = new CompilationResult();
        $request = (new CreateCompilationResultRequest())
            ->setParent($formattedParent)
            ->setCompilationResult($compilationResult);
        try {
            $gapicClient->createCompilationResult($request);
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
    public function createReleaseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $gitCommitish = 'gitCommitish-459981894';
        $cronSchedule = 'cronSchedule206244136';
        $timeZone = 'timeZone36848094';
        $releaseCompilationResult = 'releaseCompilationResult1831489873';
        $disabled = true;
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new ReleaseConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setGitCommitish($gitCommitish);
        $expectedResponse->setCronSchedule($cronSchedule);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setReleaseCompilationResult($releaseCompilationResult);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $releaseConfig = new ReleaseConfig();
        $releaseConfigGitCommitish = 'releaseConfigGitCommitish1714987262';
        $releaseConfig->setGitCommitish($releaseConfigGitCommitish);
        $releaseConfigId = 'releaseConfigId-113371904';
        $request = (new CreateReleaseConfigRequest())
            ->setParent($formattedParent)
            ->setReleaseConfig($releaseConfig)
            ->setReleaseConfigId($releaseConfigId);
        $response = $gapicClient->createReleaseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CreateReleaseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getReleaseConfig();
        $this->assertProtobufEquals($releaseConfig, $actualValue);
        $actualValue = $actualRequestObject->getReleaseConfigId();
        $this->assertProtobufEquals($releaseConfigId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createReleaseConfigExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $releaseConfig = new ReleaseConfig();
        $releaseConfigGitCommitish = 'releaseConfigGitCommitish1714987262';
        $releaseConfig->setGitCommitish($releaseConfigGitCommitish);
        $releaseConfigId = 'releaseConfigId-113371904';
        $request = (new CreateReleaseConfigRequest())
            ->setParent($formattedParent)
            ->setReleaseConfig($releaseConfig)
            ->setReleaseConfigId($releaseConfigId);
        try {
            $gapicClient->createReleaseConfig($request);
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
    public function createRepositoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $npmrcEnvironmentVariablesSecretVersion = 'npmrcEnvironmentVariablesSecretVersion-2118517056';
        $setAuthenticatedUserAdmin = true;
        $serviceAccount = 'serviceAccount-1948028253';
        $kmsKeyName = 'kmsKeyName2094986649';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new Repository();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setNpmrcEnvironmentVariablesSecretVersion($npmrcEnvironmentVariablesSecretVersion);
        $expectedResponse->setSetAuthenticatedUserAdmin($setAuthenticatedUserAdmin);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $repository = new Repository();
        $repositoryId = 'repositoryId1101683248';
        $request = (new CreateRepositoryRequest())
            ->setParent($formattedParent)
            ->setRepository($repository)
            ->setRepositoryId($repositoryId);
        $response = $gapicClient->createRepository($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CreateRepository', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRepository();
        $this->assertProtobufEquals($repository, $actualValue);
        $actualValue = $actualRequestObject->getRepositoryId();
        $this->assertProtobufEquals($repositoryId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createRepositoryExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $repository = new Repository();
        $repositoryId = 'repositoryId1101683248';
        $request = (new CreateRepositoryRequest())
            ->setParent($formattedParent)
            ->setRepository($repository)
            ->setRepositoryId($repositoryId);
        try {
            $gapicClient->createRepository($request);
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
    public function createWorkflowConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $releaseConfig = 'releaseConfig582587002';
        $cronSchedule = 'cronSchedule206244136';
        $timeZone = 'timeZone36848094';
        $disabled = true;
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new WorkflowConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setReleaseConfig($releaseConfig);
        $expectedResponse->setCronSchedule($cronSchedule);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $workflowConfig = new WorkflowConfig();
        $workflowConfigReleaseConfig = $gapicClient->releaseConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[RELEASE_CONFIG]'
        );
        $workflowConfig->setReleaseConfig($workflowConfigReleaseConfig);
        $workflowConfigId = 'workflowConfigId-60129608';
        $request = (new CreateWorkflowConfigRequest())
            ->setParent($formattedParent)
            ->setWorkflowConfig($workflowConfig)
            ->setWorkflowConfigId($workflowConfigId);
        $response = $gapicClient->createWorkflowConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CreateWorkflowConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getWorkflowConfig();
        $this->assertProtobufEquals($workflowConfig, $actualValue);
        $actualValue = $actualRequestObject->getWorkflowConfigId();
        $this->assertProtobufEquals($workflowConfigId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createWorkflowConfigExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $workflowConfig = new WorkflowConfig();
        $workflowConfigReleaseConfig = $gapicClient->releaseConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[RELEASE_CONFIG]'
        );
        $workflowConfig->setReleaseConfig($workflowConfigReleaseConfig);
        $workflowConfigId = 'workflowConfigId-60129608';
        $request = (new CreateWorkflowConfigRequest())
            ->setParent($formattedParent)
            ->setWorkflowConfig($workflowConfig)
            ->setWorkflowConfigId($workflowConfigId);
        try {
            $gapicClient->createWorkflowConfig($request);
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
    public function createWorkflowInvocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $compilationResult = 'compilationResult-2035984871';
        $name = 'name3373707';
        $resolvedCompilationResult = 'resolvedCompilationResult-2110280256';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new WorkflowInvocation();
        $expectedResponse->setCompilationResult($compilationResult);
        $expectedResponse->setName($name);
        $expectedResponse->setResolvedCompilationResult($resolvedCompilationResult);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $workflowInvocation = new WorkflowInvocation();
        $request = (new CreateWorkflowInvocationRequest())
            ->setParent($formattedParent)
            ->setWorkflowInvocation($workflowInvocation);
        $response = $gapicClient->createWorkflowInvocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CreateWorkflowInvocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getWorkflowInvocation();
        $this->assertProtobufEquals($workflowInvocation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createWorkflowInvocationExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $workflowInvocation = new WorkflowInvocation();
        $request = (new CreateWorkflowInvocationRequest())
            ->setParent($formattedParent)
            ->setWorkflowInvocation($workflowInvocation);
        try {
            $gapicClient->createWorkflowInvocation($request);
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
    public function createWorkspaceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new Workspace();
        $expectedResponse->setName($name);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $workspace = new Workspace();
        $workspaceId = 'workspaceId1578483973';
        $request = (new CreateWorkspaceRequest())
            ->setParent($formattedParent)
            ->setWorkspace($workspace)
            ->setWorkspaceId($workspaceId);
        $response = $gapicClient->createWorkspace($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CreateWorkspace', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($workspace, $actualValue);
        $actualValue = $actualRequestObject->getWorkspaceId();
        $this->assertProtobufEquals($workspaceId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createWorkspaceExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $workspace = new Workspace();
        $workspaceId = 'workspaceId1578483973';
        $request = (new CreateWorkspaceRequest())
            ->setParent($formattedParent)
            ->setWorkspace($workspace)
            ->setWorkspaceId($workspaceId);
        try {
            $gapicClient->createWorkspace($request);
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
    public function deleteReleaseConfigTest()
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
        $formattedName = $gapicClient->releaseConfigName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[RELEASE_CONFIG]');
        $request = (new DeleteReleaseConfigRequest())->setName($formattedName);
        $gapicClient->deleteReleaseConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/DeleteReleaseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteReleaseConfigExceptionTest()
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
        $formattedName = $gapicClient->releaseConfigName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[RELEASE_CONFIG]');
        $request = (new DeleteReleaseConfigRequest())->setName($formattedName);
        try {
            $gapicClient->deleteReleaseConfig($request);
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
    public function deleteRepositoryTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new DeleteRepositoryRequest())->setName($formattedName);
        $gapicClient->deleteRepository($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/DeleteRepository', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteRepositoryExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new DeleteRepositoryRequest())->setName($formattedName);
        try {
            $gapicClient->deleteRepository($request);
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
    public function deleteWorkflowConfigTest()
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
        $formattedName = $gapicClient->workflowConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_CONFIG]'
        );
        $request = (new DeleteWorkflowConfigRequest())->setName($formattedName);
        $gapicClient->deleteWorkflowConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/DeleteWorkflowConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteWorkflowConfigExceptionTest()
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
        $formattedName = $gapicClient->workflowConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_CONFIG]'
        );
        $request = (new DeleteWorkflowConfigRequest())->setName($formattedName);
        try {
            $gapicClient->deleteWorkflowConfig($request);
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
    public function deleteWorkflowInvocationTest()
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
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new DeleteWorkflowInvocationRequest())->setName($formattedName);
        $gapicClient->deleteWorkflowInvocation($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/DeleteWorkflowInvocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteWorkflowInvocationExceptionTest()
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
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new DeleteWorkflowInvocationRequest())->setName($formattedName);
        try {
            $gapicClient->deleteWorkflowInvocation($request);
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
    public function deleteWorkspaceTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new DeleteWorkspaceRequest())->setName($formattedName);
        $gapicClient->deleteWorkspace($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/DeleteWorkspace', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteWorkspaceExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new DeleteWorkspaceRequest())->setName($formattedName);
        try {
            $gapicClient->deleteWorkspace($request);
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
    public function fetchFileDiffTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $formattedDiff = 'formattedDiff-1687410264';
        $expectedResponse = new FetchFileDiffResponse();
        $expectedResponse->setFormattedDiff($formattedDiff);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new FetchFileDiffRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        $response = $gapicClient->fetchFileDiff($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/FetchFileDiff', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchFileDiffExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new FetchFileDiffRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        try {
            $gapicClient->fetchFileDiff($request);
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
    public function fetchFileGitStatusesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new FetchFileGitStatusesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new FetchFileGitStatusesRequest())->setName($formattedName);
        $response = $gapicClient->fetchFileGitStatuses($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/FetchFileGitStatuses', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchFileGitStatusesExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new FetchFileGitStatusesRequest())->setName($formattedName);
        try {
            $gapicClient->fetchFileGitStatuses($request);
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
    public function fetchGitAheadBehindTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $commitsAhead = 1216483806;
        $commitsBehind = 917751619;
        $expectedResponse = new FetchGitAheadBehindResponse();
        $expectedResponse->setCommitsAhead($commitsAhead);
        $expectedResponse->setCommitsBehind($commitsBehind);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new FetchGitAheadBehindRequest())->setName($formattedName);
        $response = $gapicClient->fetchGitAheadBehind($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/FetchGitAheadBehind', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchGitAheadBehindExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new FetchGitAheadBehindRequest())->setName($formattedName);
        try {
            $gapicClient->fetchGitAheadBehind($request);
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
    public function fetchRemoteBranchesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new FetchRemoteBranchesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new FetchRemoteBranchesRequest())->setName($formattedName);
        $response = $gapicClient->fetchRemoteBranches($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/FetchRemoteBranches', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchRemoteBranchesExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new FetchRemoteBranchesRequest())->setName($formattedName);
        try {
            $gapicClient->fetchRemoteBranches($request);
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
    public function fetchRepositoryHistoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $commitsElement = new CommitLogEntry();
        $commits = [$commitsElement];
        $expectedResponse = new FetchRepositoryHistoryResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCommits($commits);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new FetchRepositoryHistoryRequest())->setName($formattedName);
        $response = $gapicClient->fetchRepositoryHistory($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCommits()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/FetchRepositoryHistory', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchRepositoryHistoryExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new FetchRepositoryHistoryRequest())->setName($formattedName);
        try {
            $gapicClient->fetchRepositoryHistory($request);
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
    public function getCompilationResultTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $gitCommitish = 'gitCommitish-459981894';
        $name2 = 'name2-1052831874';
        $resolvedGitCommitSha = 'resolvedGitCommitSha-1974209704';
        $dataformCoreVersion = 'dataformCoreVersion1918089577';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new CompilationResult();
        $expectedResponse->setGitCommitish($gitCommitish);
        $expectedResponse->setName($name2);
        $expectedResponse->setResolvedGitCommitSha($resolvedGitCommitSha);
        $expectedResponse->setDataformCoreVersion($dataformCoreVersion);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->compilationResultName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[COMPILATION_RESULT]'
        );
        $request = (new GetCompilationResultRequest())->setName($formattedName);
        $response = $gapicClient->getCompilationResult($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetCompilationResult', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCompilationResultExceptionTest()
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
        $formattedName = $gapicClient->compilationResultName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[COMPILATION_RESULT]'
        );
        $request = (new GetCompilationResultRequest())->setName($formattedName);
        try {
            $gapicClient->getCompilationResult($request);
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
    public function getConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $defaultKmsKeyName = 'defaultKmsKeyName-635012393';
        $expectedResponse = new Config();
        $expectedResponse->setName($name2);
        $expectedResponse->setDefaultKmsKeyName($defaultKmsKeyName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->configName('[PROJECT]', '[LOCATION]');
        $request = (new GetConfigRequest())->setName($formattedName);
        $response = $gapicClient->getConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getConfigExceptionTest()
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
        $formattedName = $gapicClient->configName('[PROJECT]', '[LOCATION]');
        $request = (new GetConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getConfig($request);
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
    public function getReleaseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $gitCommitish = 'gitCommitish-459981894';
        $cronSchedule = 'cronSchedule206244136';
        $timeZone = 'timeZone36848094';
        $releaseCompilationResult = 'releaseCompilationResult1831489873';
        $disabled = true;
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new ReleaseConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setGitCommitish($gitCommitish);
        $expectedResponse->setCronSchedule($cronSchedule);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setReleaseCompilationResult($releaseCompilationResult);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->releaseConfigName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[RELEASE_CONFIG]');
        $request = (new GetReleaseConfigRequest())->setName($formattedName);
        $response = $gapicClient->getReleaseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetReleaseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getReleaseConfigExceptionTest()
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
        $formattedName = $gapicClient->releaseConfigName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[RELEASE_CONFIG]');
        $request = (new GetReleaseConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getReleaseConfig($request);
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
    public function getRepositoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $npmrcEnvironmentVariablesSecretVersion = 'npmrcEnvironmentVariablesSecretVersion-2118517056';
        $setAuthenticatedUserAdmin = true;
        $serviceAccount = 'serviceAccount-1948028253';
        $kmsKeyName = 'kmsKeyName2094986649';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new Repository();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setNpmrcEnvironmentVariablesSecretVersion($npmrcEnvironmentVariablesSecretVersion);
        $expectedResponse->setSetAuthenticatedUserAdmin($setAuthenticatedUserAdmin);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new GetRepositoryRequest())->setName($formattedName);
        $response = $gapicClient->getRepository($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetRepository', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getRepositoryExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new GetRepositoryRequest())->setName($formattedName);
        try {
            $gapicClient->getRepository($request);
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
    public function getWorkflowConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $releaseConfig = 'releaseConfig582587002';
        $cronSchedule = 'cronSchedule206244136';
        $timeZone = 'timeZone36848094';
        $disabled = true;
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new WorkflowConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setReleaseConfig($releaseConfig);
        $expectedResponse->setCronSchedule($cronSchedule);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workflowConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_CONFIG]'
        );
        $request = (new GetWorkflowConfigRequest())->setName($formattedName);
        $response = $gapicClient->getWorkflowConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetWorkflowConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWorkflowConfigExceptionTest()
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
        $formattedName = $gapicClient->workflowConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_CONFIG]'
        );
        $request = (new GetWorkflowConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getWorkflowConfig($request);
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
    public function getWorkflowInvocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $compilationResult = 'compilationResult-2035984871';
        $name2 = 'name2-1052831874';
        $resolvedCompilationResult = 'resolvedCompilationResult-2110280256';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new WorkflowInvocation();
        $expectedResponse->setCompilationResult($compilationResult);
        $expectedResponse->setName($name2);
        $expectedResponse->setResolvedCompilationResult($resolvedCompilationResult);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new GetWorkflowInvocationRequest())->setName($formattedName);
        $response = $gapicClient->getWorkflowInvocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetWorkflowInvocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWorkflowInvocationExceptionTest()
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
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new GetWorkflowInvocationRequest())->setName($formattedName);
        try {
            $gapicClient->getWorkflowInvocation($request);
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
    public function getWorkspaceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new Workspace();
        $expectedResponse->setName($name2);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new GetWorkspaceRequest())->setName($formattedName);
        $response = $gapicClient->getWorkspace($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/GetWorkspace', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWorkspaceExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new GetWorkspaceRequest())->setName($formattedName);
        try {
            $gapicClient->getWorkspace($request);
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
    public function installNpmPackagesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new InstallNpmPackagesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new InstallNpmPackagesRequest())->setWorkspace($formattedWorkspace);
        $response = $gapicClient->installNpmPackages($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/InstallNpmPackages', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function installNpmPackagesExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new InstallNpmPackagesRequest())->setWorkspace($formattedWorkspace);
        try {
            $gapicClient->installNpmPackages($request);
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
    public function listCompilationResultsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $compilationResultsElement = new CompilationResult();
        $compilationResults = [$compilationResultsElement];
        $expectedResponse = new ListCompilationResultsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCompilationResults($compilationResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListCompilationResultsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCompilationResults($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCompilationResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ListCompilationResults', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCompilationResultsExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListCompilationResultsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCompilationResults($request);
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
    public function listReleaseConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $releaseConfigsElement = new ReleaseConfig();
        $releaseConfigs = [$releaseConfigsElement];
        $expectedResponse = new ListReleaseConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setReleaseConfigs($releaseConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListReleaseConfigsRequest())->setParent($formattedParent);
        $response = $gapicClient->listReleaseConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getReleaseConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ListReleaseConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listReleaseConfigsExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListReleaseConfigsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listReleaseConfigs($request);
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
    public function listRepositoriesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $repositoriesElement = new Repository();
        $repositories = [$repositoriesElement];
        $expectedResponse = new ListRepositoriesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setRepositories($repositories);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRepositoriesRequest())->setParent($formattedParent);
        $response = $gapicClient->listRepositories($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getRepositories()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ListRepositories', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listRepositoriesExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListRepositoriesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listRepositories($request);
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
    public function listWorkflowConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workflowConfigsElement = new WorkflowConfig();
        $workflowConfigs = [$workflowConfigsElement];
        $expectedResponse = new ListWorkflowConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkflowConfigs($workflowConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListWorkflowConfigsRequest())->setParent($formattedParent);
        $response = $gapicClient->listWorkflowConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkflowConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ListWorkflowConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listWorkflowConfigsExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListWorkflowConfigsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listWorkflowConfigs($request);
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
    public function listWorkflowInvocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workflowInvocationsElement = new WorkflowInvocation();
        $workflowInvocations = [$workflowInvocationsElement];
        $expectedResponse = new ListWorkflowInvocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkflowInvocations($workflowInvocations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListWorkflowInvocationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listWorkflowInvocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkflowInvocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ListWorkflowInvocations', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listWorkflowInvocationsExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListWorkflowInvocationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listWorkflowInvocations($request);
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
    public function listWorkspacesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workspacesElement = new Workspace();
        $workspaces = [$workspacesElement];
        $expectedResponse = new ListWorkspacesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkspaces($workspaces);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListWorkspacesRequest())->setParent($formattedParent);
        $response = $gapicClient->listWorkspaces($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkspaces()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ListWorkspaces', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listWorkspacesExceptionTest()
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
        $formattedParent = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new ListWorkspacesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listWorkspaces($request);
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
    public function makeDirectoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new MakeDirectoryResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new MakeDirectoryRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        $response = $gapicClient->makeDirectory($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/MakeDirectory', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function makeDirectoryExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new MakeDirectoryRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        try {
            $gapicClient->makeDirectory($request);
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
    public function moveDirectoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new MoveDirectoryResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $newPath = 'newPath1377204068';
        $request = (new MoveDirectoryRequest())
            ->setWorkspace($formattedWorkspace)
            ->setPath($path)
            ->setNewPath($newPath);
        $response = $gapicClient->moveDirectory($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/MoveDirectory', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $actualValue = $actualRequestObject->getNewPath();
        $this->assertProtobufEquals($newPath, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function moveDirectoryExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $newPath = 'newPath1377204068';
        $request = (new MoveDirectoryRequest())
            ->setWorkspace($formattedWorkspace)
            ->setPath($path)
            ->setNewPath($newPath);
        try {
            $gapicClient->moveDirectory($request);
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
    public function moveFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new MoveFileResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $newPath = 'newPath1377204068';
        $request = (new MoveFileRequest())
            ->setWorkspace($formattedWorkspace)
            ->setPath($path)
            ->setNewPath($newPath);
        $response = $gapicClient->moveFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/MoveFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $actualValue = $actualRequestObject->getNewPath();
        $this->assertProtobufEquals($newPath, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function moveFileExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $newPath = 'newPath1377204068';
        $request = (new MoveFileRequest())
            ->setWorkspace($formattedWorkspace)
            ->setPath($path)
            ->setNewPath($newPath);
        try {
            $gapicClient->moveFile($request);
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
    public function pullGitCommitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new PullGitCommitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $author = new CommitAuthor();
        $authorName = 'authorName-1501539658';
        $author->setName($authorName);
        $authorEmailAddress = 'authorEmailAddress-6398493';
        $author->setEmailAddress($authorEmailAddress);
        $request = (new PullGitCommitsRequest())->setName($formattedName)->setAuthor($author);
        $response = $gapicClient->pullGitCommits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/PullGitCommits', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getAuthor();
        $this->assertProtobufEquals($author, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function pullGitCommitsExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $author = new CommitAuthor();
        $authorName = 'authorName-1501539658';
        $author->setName($authorName);
        $authorEmailAddress = 'authorEmailAddress-6398493';
        $author->setEmailAddress($authorEmailAddress);
        $request = (new PullGitCommitsRequest())->setName($formattedName)->setAuthor($author);
        try {
            $gapicClient->pullGitCommits($request);
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
    public function pushGitCommitsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new PushGitCommitsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new PushGitCommitsRequest())->setName($formattedName);
        $response = $gapicClient->pushGitCommits($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/PushGitCommits', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function pushGitCommitsExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new PushGitCommitsRequest())->setName($formattedName);
        try {
            $gapicClient->pushGitCommits($request);
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
    public function queryCompilationResultActionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $compilationResultActionsElement = new CompilationResultAction();
        $compilationResultActions = [$compilationResultActionsElement];
        $expectedResponse = new QueryCompilationResultActionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCompilationResultActions($compilationResultActions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->compilationResultName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[COMPILATION_RESULT]'
        );
        $request = (new QueryCompilationResultActionsRequest())->setName($formattedName);
        $response = $gapicClient->queryCompilationResultActions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCompilationResultActions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/QueryCompilationResultActions', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryCompilationResultActionsExceptionTest()
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
        $formattedName = $gapicClient->compilationResultName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[COMPILATION_RESULT]'
        );
        $request = (new QueryCompilationResultActionsRequest())->setName($formattedName);
        try {
            $gapicClient->queryCompilationResultActions($request);
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
    public function queryDirectoryContentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $directoryEntriesElement = new DirectoryEntry();
        $directoryEntries = [$directoryEntriesElement];
        $expectedResponse = new QueryDirectoryContentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDirectoryEntries($directoryEntries);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new QueryDirectoryContentsRequest())->setWorkspace($formattedWorkspace);
        $response = $gapicClient->queryDirectoryContents($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDirectoryEntries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/QueryDirectoryContents', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryDirectoryContentsExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new QueryDirectoryContentsRequest())->setWorkspace($formattedWorkspace);
        try {
            $gapicClient->queryDirectoryContents($request);
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
    public function queryRepositoryDirectoryContentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $directoryEntriesElement = new DirectoryEntry();
        $directoryEntries = [$directoryEntriesElement];
        $expectedResponse = new QueryRepositoryDirectoryContentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDirectoryEntries($directoryEntries);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new QueryRepositoryDirectoryContentsRequest())->setName($formattedName);
        $response = $gapicClient->queryRepositoryDirectoryContents($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDirectoryEntries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/QueryRepositoryDirectoryContents', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryRepositoryDirectoryContentsExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $request = (new QueryRepositoryDirectoryContentsRequest())->setName($formattedName);
        try {
            $gapicClient->queryRepositoryDirectoryContents($request);
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
    public function queryWorkflowInvocationActionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workflowInvocationActionsElement = new WorkflowInvocationAction();
        $workflowInvocationActions = [$workflowInvocationActionsElement];
        $expectedResponse = new QueryWorkflowInvocationActionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkflowInvocationActions($workflowInvocationActions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new QueryWorkflowInvocationActionsRequest())->setName($formattedName);
        $response = $gapicClient->queryWorkflowInvocationActions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkflowInvocationActions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/QueryWorkflowInvocationActions', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryWorkflowInvocationActionsExceptionTest()
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
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new QueryWorkflowInvocationActionsRequest())->setName($formattedName);
        try {
            $gapicClient->queryWorkflowInvocationActions($request);
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
    public function readFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $fileContents = '125';
        $expectedResponse = new ReadFileResponse();
        $expectedResponse->setFileContents($fileContents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new ReadFileRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        $response = $gapicClient->readFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ReadFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readFileExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new ReadFileRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        try {
            $gapicClient->readFile($request);
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
    public function readRepositoryFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $contents = '26';
        $expectedResponse = new ReadRepositoryFileResponse();
        $expectedResponse->setContents($contents);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $path = 'path3433509';
        $request = (new ReadRepositoryFileRequest())->setName($formattedName)->setPath($path);
        $response = $gapicClient->readRepositoryFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ReadRepositoryFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readRepositoryFileExceptionTest()
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
        $formattedName = $gapicClient->repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
        $path = 'path3433509';
        $request = (new ReadRepositoryFileRequest())->setName($formattedName)->setPath($path);
        try {
            $gapicClient->readRepositoryFile($request);
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
    public function removeDirectoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RemoveDirectoryResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new RemoveDirectoryRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        $response = $gapicClient->removeDirectory($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/RemoveDirectory', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeDirectoryExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new RemoveDirectoryRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        try {
            $gapicClient->removeDirectory($request);
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
    public function removeFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RemoveFileResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new RemoveFileRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        $response = $gapicClient->removeFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/RemoveFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeFileExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $request = (new RemoveFileRequest())->setWorkspace($formattedWorkspace)->setPath($path);
        try {
            $gapicClient->removeFile($request);
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
    public function resetWorkspaceChangesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ResetWorkspaceChangesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new ResetWorkspaceChangesRequest())->setName($formattedName);
        $response = $gapicClient->resetWorkspaceChanges($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/ResetWorkspaceChanges', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function resetWorkspaceChangesExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new ResetWorkspaceChangesRequest())->setName($formattedName);
        try {
            $gapicClient->resetWorkspaceChanges($request);
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
    public function searchFilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $searchResultsElement = new SearchResult();
        $searchResults = [$searchResultsElement];
        $expectedResponse = new SearchFilesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSearchResults($searchResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new SearchFilesRequest())->setWorkspace($formattedWorkspace);
        $response = $gapicClient->searchFiles($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSearchResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/SearchFiles', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchFilesExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $request = (new SearchFilesRequest())->setWorkspace($formattedWorkspace);
        try {
            $gapicClient->searchFiles($request);
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
    public function updateConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $defaultKmsKeyName = 'defaultKmsKeyName-635012393';
        $expectedResponse = new Config();
        $expectedResponse->setName($name);
        $expectedResponse->setDefaultKmsKeyName($defaultKmsKeyName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $config = new Config();
        $request = (new UpdateConfigRequest())->setConfig($config);
        $response = $gapicClient->updateConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/UpdateConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getConfig();
        $this->assertProtobufEquals($config, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateConfigExceptionTest()
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
        $config = new Config();
        $request = (new UpdateConfigRequest())->setConfig($config);
        try {
            $gapicClient->updateConfig($request);
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
    public function updateReleaseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $gitCommitish = 'gitCommitish-459981894';
        $cronSchedule = 'cronSchedule206244136';
        $timeZone = 'timeZone36848094';
        $releaseCompilationResult = 'releaseCompilationResult1831489873';
        $disabled = true;
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new ReleaseConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setGitCommitish($gitCommitish);
        $expectedResponse->setCronSchedule($cronSchedule);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setReleaseCompilationResult($releaseCompilationResult);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $releaseConfig = new ReleaseConfig();
        $releaseConfigGitCommitish = 'releaseConfigGitCommitish1714987262';
        $releaseConfig->setGitCommitish($releaseConfigGitCommitish);
        $request = (new UpdateReleaseConfigRequest())->setReleaseConfig($releaseConfig);
        $response = $gapicClient->updateReleaseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/UpdateReleaseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getReleaseConfig();
        $this->assertProtobufEquals($releaseConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateReleaseConfigExceptionTest()
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
        $releaseConfig = new ReleaseConfig();
        $releaseConfigGitCommitish = 'releaseConfigGitCommitish1714987262';
        $releaseConfig->setGitCommitish($releaseConfigGitCommitish);
        $request = (new UpdateReleaseConfigRequest())->setReleaseConfig($releaseConfig);
        try {
            $gapicClient->updateReleaseConfig($request);
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
    public function updateRepositoryTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $npmrcEnvironmentVariablesSecretVersion = 'npmrcEnvironmentVariablesSecretVersion-2118517056';
        $setAuthenticatedUserAdmin = true;
        $serviceAccount = 'serviceAccount-1948028253';
        $kmsKeyName = 'kmsKeyName2094986649';
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new Repository();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setNpmrcEnvironmentVariablesSecretVersion($npmrcEnvironmentVariablesSecretVersion);
        $expectedResponse->setSetAuthenticatedUserAdmin($setAuthenticatedUserAdmin);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $repository = new Repository();
        $request = (new UpdateRepositoryRequest())->setRepository($repository);
        $response = $gapicClient->updateRepository($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/UpdateRepository', $actualFuncCall);
        $actualValue = $actualRequestObject->getRepository();
        $this->assertProtobufEquals($repository, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateRepositoryExceptionTest()
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
        $repository = new Repository();
        $request = (new UpdateRepositoryRequest())->setRepository($repository);
        try {
            $gapicClient->updateRepository($request);
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
    public function updateWorkflowConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $releaseConfig = 'releaseConfig582587002';
        $cronSchedule = 'cronSchedule206244136';
        $timeZone = 'timeZone36848094';
        $disabled = true;
        $internalMetadata = 'internalMetadata-1087755663';
        $expectedResponse = new WorkflowConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setReleaseConfig($releaseConfig);
        $expectedResponse->setCronSchedule($cronSchedule);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setInternalMetadata($internalMetadata);
        $transport->addResponse($expectedResponse);
        // Mock request
        $workflowConfig = new WorkflowConfig();
        $workflowConfigReleaseConfig = $gapicClient->releaseConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[RELEASE_CONFIG]'
        );
        $workflowConfig->setReleaseConfig($workflowConfigReleaseConfig);
        $request = (new UpdateWorkflowConfigRequest())->setWorkflowConfig($workflowConfig);
        $response = $gapicClient->updateWorkflowConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/UpdateWorkflowConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkflowConfig();
        $this->assertProtobufEquals($workflowConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateWorkflowConfigExceptionTest()
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
        $workflowConfig = new WorkflowConfig();
        $workflowConfigReleaseConfig = $gapicClient->releaseConfigName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[RELEASE_CONFIG]'
        );
        $workflowConfig->setReleaseConfig($workflowConfigReleaseConfig);
        $request = (new UpdateWorkflowConfigRequest())->setWorkflowConfig($workflowConfig);
        try {
            $gapicClient->updateWorkflowConfig($request);
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
    public function writeFileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new WriteFileResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $contents = '26';
        $request = (new WriteFileRequest())
            ->setWorkspace($formattedWorkspace)
            ->setPath($path)
            ->setContents($contents);
        $response = $gapicClient->writeFile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/WriteFile', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkspace();
        $this->assertProtobufEquals($formattedWorkspace, $actualValue);
        $actualValue = $actualRequestObject->getPath();
        $this->assertProtobufEquals($path, $actualValue);
        $actualValue = $actualRequestObject->getContents();
        $this->assertProtobufEquals($contents, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function writeFileExceptionTest()
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
        $formattedWorkspace = $gapicClient->workspaceName('[PROJECT]', '[LOCATION]', '[REPOSITORY]', '[WORKSPACE]');
        $path = 'path3433509';
        $contents = '26';
        $request = (new WriteFileRequest())
            ->setWorkspace($formattedWorkspace)
            ->setPath($path)
            ->setContents($contents);
        try {
            $gapicClient->writeFile($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function getIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())->setResource($resource);
        $response = $gapicClient->getIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())->setResource($resource);
        try {
            $gapicClient->getIamPolicy($request);
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
    public function setIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())->setResource($resource)->setPolicy($policy);
        $response = $gapicClient->setIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())->setResource($resource)->setPolicy($policy);
        try {
            $gapicClient->setIamPolicy($request);
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
    public function testIamPermissionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TestIamPermissionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())->setResource($resource)->setPermissions($permissions);
        $response = $gapicClient->testIamPermissions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPermissions();
        $this->assertProtobufEquals($permissions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function testIamPermissionsExceptionTest()
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
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())->setResource($resource)->setPermissions($permissions);
        try {
            $gapicClient->testIamPermissions($request);
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
    public function cancelWorkflowInvocationAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CancelWorkflowInvocationResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workflowInvocationName(
            '[PROJECT]',
            '[LOCATION]',
            '[REPOSITORY]',
            '[WORKFLOW_INVOCATION]'
        );
        $request = (new CancelWorkflowInvocationRequest())->setName($formattedName);
        $response = $gapicClient->cancelWorkflowInvocationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataform.v1.Dataform/CancelWorkflowInvocation', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
