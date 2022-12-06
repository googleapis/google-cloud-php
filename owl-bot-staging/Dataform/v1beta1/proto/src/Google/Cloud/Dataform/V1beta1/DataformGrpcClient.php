<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Dataform\V1beta1;

/**
 * Dataform is a service to develop, create, document, test, and update curated
 * tables in BigQuery.
 */
class DataformGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Repositories in a given project and location.
     * @param \Google\Cloud\Dataform\V1beta1\ListRepositoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRepositories(\Google\Cloud\Dataform\V1beta1\ListRepositoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/ListRepositories',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\ListRepositoriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches a single Repository.
     * @param \Google\Cloud\Dataform\V1beta1\GetRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRepository(\Google\Cloud\Dataform\V1beta1\GetRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/GetRepository',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\Repository', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Repository in a given project and location.
     * @param \Google\Cloud\Dataform\V1beta1\CreateRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRepository(\Google\Cloud\Dataform\V1beta1\CreateRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/CreateRepository',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\Repository', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a single Repository.
     * @param \Google\Cloud\Dataform\V1beta1\UpdateRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRepository(\Google\Cloud\Dataform\V1beta1\UpdateRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/UpdateRepository',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\Repository', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Repository.
     * @param \Google\Cloud\Dataform\V1beta1\DeleteRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRepository(\Google\Cloud\Dataform\V1beta1\DeleteRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/DeleteRepository',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches a Repository's remote branches.
     * @param \Google\Cloud\Dataform\V1beta1\FetchRemoteBranchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchRemoteBranches(\Google\Cloud\Dataform\V1beta1\FetchRemoteBranchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/FetchRemoteBranches',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\FetchRemoteBranchesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Workspaces in a given Repository.
     * @param \Google\Cloud\Dataform\V1beta1\ListWorkspacesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListWorkspaces(\Google\Cloud\Dataform\V1beta1\ListWorkspacesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/ListWorkspaces',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\ListWorkspacesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches a single Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\GetWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWorkspace(\Google\Cloud\Dataform\V1beta1\GetWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/GetWorkspace',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\Workspace', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Workspace in a given Repository.
     * @param \Google\Cloud\Dataform\V1beta1\CreateWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateWorkspace(\Google\Cloud\Dataform\V1beta1\CreateWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/CreateWorkspace',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\Workspace', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\DeleteWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteWorkspace(\Google\Cloud\Dataform\V1beta1\DeleteWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/DeleteWorkspace',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Installs dependency NPM packages (inside a Workspace).
     * @param \Google\Cloud\Dataform\V1beta1\InstallNpmPackagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function InstallNpmPackages(\Google\Cloud\Dataform\V1beta1\InstallNpmPackagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/InstallNpmPackages',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\InstallNpmPackagesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Pulls Git commits from the Repository's remote into a Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\PullGitCommitsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PullGitCommits(\Google\Cloud\Dataform\V1beta1\PullGitCommitsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/PullGitCommits',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Pushes Git commits from a Workspace to the Repository's remote.
     * @param \Google\Cloud\Dataform\V1beta1\PushGitCommitsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PushGitCommits(\Google\Cloud\Dataform\V1beta1\PushGitCommitsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/PushGitCommits',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches Git statuses for the files in a Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\FetchFileGitStatusesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchFileGitStatuses(\Google\Cloud\Dataform\V1beta1\FetchFileGitStatusesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/FetchFileGitStatuses',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\FetchFileGitStatusesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches Git ahead/behind against a remote branch.
     * @param \Google\Cloud\Dataform\V1beta1\FetchGitAheadBehindRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchGitAheadBehind(\Google\Cloud\Dataform\V1beta1\FetchGitAheadBehindRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/FetchGitAheadBehind',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\FetchGitAheadBehindResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Applies a Git commit for uncommitted files in a Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\CommitWorkspaceChangesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CommitWorkspaceChanges(\Google\Cloud\Dataform\V1beta1\CommitWorkspaceChangesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/CommitWorkspaceChanges',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs a Git reset for uncommitted files in a Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\ResetWorkspaceChangesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetWorkspaceChanges(\Google\Cloud\Dataform\V1beta1\ResetWorkspaceChangesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/ResetWorkspaceChanges',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches Git diff for an uncommitted file in a Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\FetchFileDiffRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchFileDiff(\Google\Cloud\Dataform\V1beta1\FetchFileDiffRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/FetchFileDiff',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\FetchFileDiffResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the contents of a given Workspace directory.
     * @param \Google\Cloud\Dataform\V1beta1\QueryDirectoryContentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryDirectoryContents(\Google\Cloud\Dataform\V1beta1\QueryDirectoryContentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/QueryDirectoryContents',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\QueryDirectoryContentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a directory inside a Workspace.
     * @param \Google\Cloud\Dataform\V1beta1\MakeDirectoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MakeDirectory(\Google\Cloud\Dataform\V1beta1\MakeDirectoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/MakeDirectory',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\MakeDirectoryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a directory (inside a Workspace) and all of its contents.
     * @param \Google\Cloud\Dataform\V1beta1\RemoveDirectoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveDirectory(\Google\Cloud\Dataform\V1beta1\RemoveDirectoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/RemoveDirectory',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Moves a directory (inside a Workspace), and all of its contents, to a new
     * location.
     * @param \Google\Cloud\Dataform\V1beta1\MoveDirectoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MoveDirectory(\Google\Cloud\Dataform\V1beta1\MoveDirectoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/MoveDirectory',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\MoveDirectoryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the contents of a file (inside a Workspace).
     * @param \Google\Cloud\Dataform\V1beta1\ReadFileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReadFile(\Google\Cloud\Dataform\V1beta1\ReadFileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/ReadFile',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\ReadFileResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a file (inside a Workspace).
     * @param \Google\Cloud\Dataform\V1beta1\RemoveFileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveFile(\Google\Cloud\Dataform\V1beta1\RemoveFileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/RemoveFile',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Moves a file (inside a Workspace) to a new location.
     * @param \Google\Cloud\Dataform\V1beta1\MoveFileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MoveFile(\Google\Cloud\Dataform\V1beta1\MoveFileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/MoveFile',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\MoveFileResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Writes to a file (inside a Workspace).
     * @param \Google\Cloud\Dataform\V1beta1\WriteFileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function WriteFile(\Google\Cloud\Dataform\V1beta1\WriteFileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/WriteFile',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\WriteFileResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CompilationResults in a given Repository.
     * @param \Google\Cloud\Dataform\V1beta1\ListCompilationResultsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCompilationResults(\Google\Cloud\Dataform\V1beta1\ListCompilationResultsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/ListCompilationResults',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\ListCompilationResultsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches a single CompilationResult.
     * @param \Google\Cloud\Dataform\V1beta1\GetCompilationResultRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCompilationResult(\Google\Cloud\Dataform\V1beta1\GetCompilationResultRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/GetCompilationResult',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\CompilationResult', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new CompilationResult in a given project and location.
     * @param \Google\Cloud\Dataform\V1beta1\CreateCompilationResultRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCompilationResult(\Google\Cloud\Dataform\V1beta1\CreateCompilationResultRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/CreateCompilationResult',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\CompilationResult', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns CompilationResultActions in a given CompilationResult.
     * @param \Google\Cloud\Dataform\V1beta1\QueryCompilationResultActionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryCompilationResultActions(\Google\Cloud\Dataform\V1beta1\QueryCompilationResultActionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/QueryCompilationResultActions',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\QueryCompilationResultActionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists WorkflowInvocations in a given Repository.
     * @param \Google\Cloud\Dataform\V1beta1\ListWorkflowInvocationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListWorkflowInvocations(\Google\Cloud\Dataform\V1beta1\ListWorkflowInvocationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/ListWorkflowInvocations',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\ListWorkflowInvocationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches a single WorkflowInvocation.
     * @param \Google\Cloud\Dataform\V1beta1\GetWorkflowInvocationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWorkflowInvocation(\Google\Cloud\Dataform\V1beta1\GetWorkflowInvocationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/GetWorkflowInvocation',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\WorkflowInvocation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new WorkflowInvocation in a given Repository.
     * @param \Google\Cloud\Dataform\V1beta1\CreateWorkflowInvocationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateWorkflowInvocation(\Google\Cloud\Dataform\V1beta1\CreateWorkflowInvocationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/CreateWorkflowInvocation',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\WorkflowInvocation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single WorkflowInvocation.
     * @param \Google\Cloud\Dataform\V1beta1\DeleteWorkflowInvocationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteWorkflowInvocation(\Google\Cloud\Dataform\V1beta1\DeleteWorkflowInvocationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/DeleteWorkflowInvocation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Requests cancellation of a running WorkflowInvocation.
     * @param \Google\Cloud\Dataform\V1beta1\CancelWorkflowInvocationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelWorkflowInvocation(\Google\Cloud\Dataform\V1beta1\CancelWorkflowInvocationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/CancelWorkflowInvocation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns WorkflowInvocationActions in a given WorkflowInvocation.
     * @param \Google\Cloud\Dataform\V1beta1\QueryWorkflowInvocationActionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryWorkflowInvocationActions(\Google\Cloud\Dataform\V1beta1\QueryWorkflowInvocationActionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataform.v1beta1.Dataform/QueryWorkflowInvocationActions',
        $argument,
        ['\Google\Cloud\Dataform\V1beta1\QueryWorkflowInvocationActionsResponse', 'decode'],
        $metadata, $options);
    }

}
