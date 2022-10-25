<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\GSuiteAddOns\V1;

/**
 * A service for managing Google Workspace Add-ons deployments.
 *
 * A Google Workspace Add-on is a third-party embedded component that can be
 * installed in Google Workspace Applications like Gmail, Calendar, Drive, and
 * the Google Docs, Sheets, and Slides editors. Google Workspace Add-ons can
 * display UI cards, receive contextual information from the host application,
 * and perform actions in the host application (See:
 * https://developers.google.com/gsuite/add-ons/overview for more information).
 *
 * A Google Workspace Add-on deployment resource specifies metadata about the
 * add-on, including a specification of the entry points in the host application
 * that trigger add-on executions (see:
 * https://developers.google.com/gsuite/add-ons/concepts/gsuite-manifests).
 * Add-on deployments defined via the Google Workspace Add-ons API define their
 * entrypoints using HTTPS URLs (See:
 * https://developers.google.com/gsuite/add-ons/guides/alternate-runtimes),
 *
 * A Google Workspace Add-on deployment can be installed in developer mode,
 * which allows an add-on developer to test the experience an end-user would see
 * when installing and running the add-on in their G Suite applications.  When
 * running in developer mode, more detailed error messages are exposed in the
 * add-on UI to aid in debugging.
 *
 * A Google Workspace Add-on deployment can be published to Google Workspace
 * Marketplace, which allows other Google Workspace users to discover and
 * install the add-on.  See:
 * https://developers.google.com/gsuite/add-ons/how-tos/publish-add-on-overview
 * for details.
 */
class GSuiteAddOnsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets the authorization information for deployments in a given project.
     * @param \Google\Cloud\GSuiteAddOns\V1\GetAuthorizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAuthorization(\Google\Cloud\GSuiteAddOns\V1\GetAuthorizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/GetAuthorization',
        $argument,
        ['\Google\Cloud\GSuiteAddOns\V1\Authorization', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a deployment with the specified name and configuration.
     * @param \Google\Cloud\GSuiteAddOns\V1\CreateDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDeployment(\Google\Cloud\GSuiteAddOns\V1\CreateDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/CreateDeployment',
        $argument,
        ['\Google\Cloud\GSuiteAddOns\V1\Deployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates or replaces a deployment with the specified name.
     * @param \Google\Cloud\GSuiteAddOns\V1\ReplaceDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceDeployment(\Google\Cloud\GSuiteAddOns\V1\ReplaceDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/ReplaceDeployment',
        $argument,
        ['\Google\Cloud\GSuiteAddOns\V1\Deployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the deployment with the specified name.
     * @param \Google\Cloud\GSuiteAddOns\V1\GetDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDeployment(\Google\Cloud\GSuiteAddOns\V1\GetDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/GetDeployment',
        $argument,
        ['\Google\Cloud\GSuiteAddOns\V1\Deployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all deployments in a particular project.
     * @param \Google\Cloud\GSuiteAddOns\V1\ListDeploymentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDeployments(\Google\Cloud\GSuiteAddOns\V1\ListDeploymentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/ListDeployments',
        $argument,
        ['\Google\Cloud\GSuiteAddOns\V1\ListDeploymentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the deployment with the given name.
     * @param \Google\Cloud\GSuiteAddOns\V1\DeleteDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDeployment(\Google\Cloud\GSuiteAddOns\V1\DeleteDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/DeleteDeployment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Installs a deployment in developer mode.
     * See:
     * https://developers.google.com/gsuite/add-ons/how-tos/testing-gsuite-addons.
     * @param \Google\Cloud\GSuiteAddOns\V1\InstallDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function InstallDeployment(\Google\Cloud\GSuiteAddOns\V1\InstallDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/InstallDeployment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Uninstalls a developer mode deployment.
     * See:
     * https://developers.google.com/gsuite/add-ons/how-tos/testing-gsuite-addons.
     * @param \Google\Cloud\GSuiteAddOns\V1\UninstallDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UninstallDeployment(\Google\Cloud\GSuiteAddOns\V1\UninstallDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/UninstallDeployment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches the install status of a developer mode deployment.
     * @param \Google\Cloud\GSuiteAddOns\V1\GetInstallStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstallStatus(\Google\Cloud\GSuiteAddOns\V1\GetInstallStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gsuiteaddons.v1.GSuiteAddOns/GetInstallStatus',
        $argument,
        ['\Google\Cloud\GSuiteAddOns\V1\InstallStatus', 'decode'],
        $metadata, $options);
    }

}
