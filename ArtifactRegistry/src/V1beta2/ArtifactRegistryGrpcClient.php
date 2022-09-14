<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\ArtifactRegistry\V1beta2;

/**
 * The Artifact Registry API service.
 *
 * Artifact Registry is an artifact management system for storing artifacts
 * from different package management systems.
 *
 * The resources managed by this API are:
 *
 * * Repositories, which group packages and their data.
 * * Packages, which group versions and their tags.
 * * Versions, which are specific forms of a package.
 * * Tags, which represent alternative names for versions.
 * * Files, which contain content and are optionally associated with a Package
 *   or Version.
 */
class ArtifactRegistryGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Imports Apt artifacts. The returned Operation will complete once the
     * resources are imported. Package, Version, and File resources are created
     * based on the imported artifacts. Imported artifacts that conflict with
     * existing resources are ignored.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ImportAptArtifactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportAptArtifacts(\Google\Cloud\ArtifactRegistry\V1beta2\ImportAptArtifactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ImportAptArtifacts',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports Yum (RPM) artifacts. The returned Operation will complete once the
     * resources are imported. Package, Version, and File resources are created
     * based on the imported artifacts. Imported artifacts that conflict with
     * existing resources are ignored.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ImportYumArtifactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportYumArtifacts(\Google\Cloud\ArtifactRegistry\V1beta2\ImportYumArtifactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ImportYumArtifacts',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists repositories.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ListRepositoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRepositories(\Google\Cloud\ArtifactRegistry\V1beta2\ListRepositoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ListRepositories',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ListRepositoriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a repository.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\GetRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRepository(\Google\Cloud\ArtifactRegistry\V1beta2\GetRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetRepository',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Repository', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a repository. The returned Operation will finish once the
     * repository has been created. Its response will be the created Repository.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\CreateRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRepository(\Google\Cloud\ArtifactRegistry\V1beta2\CreateRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/CreateRepository',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a repository.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\UpdateRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRepository(\Google\Cloud\ArtifactRegistry\V1beta2\UpdateRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/UpdateRepository',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Repository', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a repository and all of its contents. The returned Operation will
     * finish once the repository has been deleted. It will not have any Operation
     * metadata and will return a google.protobuf.Empty response.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\DeleteRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRepository(\Google\Cloud\ArtifactRegistry\V1beta2\DeleteRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/DeleteRepository',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists packages.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ListPackagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPackages(\Google\Cloud\ArtifactRegistry\V1beta2\ListPackagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ListPackages',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ListPackagesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a package.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\GetPackageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPackage(\Google\Cloud\ArtifactRegistry\V1beta2\GetPackageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetPackage',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Package', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a package and all of its versions and tags. The returned operation
     * will complete once the package has been deleted.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\DeletePackageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePackage(\Google\Cloud\ArtifactRegistry\V1beta2\DeletePackageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/DeletePackage',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists versions.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ListVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVersions(\Google\Cloud\ArtifactRegistry\V1beta2\ListVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ListVersions',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ListVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a version
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\GetVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVersion(\Google\Cloud\ArtifactRegistry\V1beta2\GetVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetVersion',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Version', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a version and all of its content. The returned operation will
     * complete once the version has been deleted.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\DeleteVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteVersion(\Google\Cloud\ArtifactRegistry\V1beta2\DeleteVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/DeleteVersion',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists files.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ListFilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFiles(\Google\Cloud\ArtifactRegistry\V1beta2\ListFilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ListFiles',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ListFilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a file.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\GetFileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFile(\Google\Cloud\ArtifactRegistry\V1beta2\GetFileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetFile',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\File', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists tags.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\ListTagsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTags(\Google\Cloud\ArtifactRegistry\V1beta2\ListTagsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/ListTags',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ListTagsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a tag.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\GetTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTag(\Google\Cloud\ArtifactRegistry\V1beta2\GetTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetTag',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Tag', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a tag.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\CreateTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTag(\Google\Cloud\ArtifactRegistry\V1beta2\CreateTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/CreateTag',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Tag', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a tag.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\UpdateTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTag(\Google\Cloud\ArtifactRegistry\V1beta2\UpdateTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/UpdateTag',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\Tag', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a tag.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\DeleteTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTag(\Google\Cloud\ArtifactRegistry\V1beta2\DeleteTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/DeleteTag',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the IAM policy for a given resource.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM policy for a given resource.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Tests if the caller has a list of permissions on a resource.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the Settings for the Project.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\GetProjectSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProjectSettings(\Google\Cloud\ArtifactRegistry\V1beta2\GetProjectSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/GetProjectSettings',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ProjectSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the Settings for the Project.
     * @param \Google\Cloud\ArtifactRegistry\V1beta2\UpdateProjectSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateProjectSettings(\Google\Cloud\ArtifactRegistry\V1beta2\UpdateProjectSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.artifactregistry.v1beta2.ArtifactRegistry/UpdateProjectSettings',
        $argument,
        ['\Google\Cloud\ArtifactRegistry\V1beta2\ProjectSettings', 'decode'],
        $metadata, $options);
    }

}
