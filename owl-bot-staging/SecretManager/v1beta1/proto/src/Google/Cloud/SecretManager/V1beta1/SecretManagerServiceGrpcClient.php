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
namespace Google\Cloud\SecretManager\V1beta1;

/**
 * Secret Manager Service
 *
 * Manages secrets and operations using those secrets. Implements a REST
 * model with the following objects:
 *
 * * [Secret][google.cloud.secrets.v1beta1.Secret]
 * * [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion]
 */
class SecretManagerServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists [Secrets][google.cloud.secrets.v1beta1.Secret].
     * @param \Google\Cloud\SecretManager\V1beta1\ListSecretsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSecrets(\Google\Cloud\SecretManager\V1beta1\ListSecretsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/ListSecrets',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\ListSecretsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [Secret][google.cloud.secrets.v1beta1.Secret] containing no [SecretVersions][google.cloud.secrets.v1beta1.SecretVersion].
     * @param \Google\Cloud\SecretManager\V1beta1\CreateSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSecret(\Google\Cloud\SecretManager\V1beta1\CreateSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/CreateSecret',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\Secret', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion] containing secret data and attaches
     * it to an existing [Secret][google.cloud.secrets.v1beta1.Secret].
     * @param \Google\Cloud\SecretManager\V1beta1\AddSecretVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddSecretVersion(\Google\Cloud\SecretManager\V1beta1\AddSecretVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/AddSecretVersion',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\SecretVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets metadata for a given [Secret][google.cloud.secrets.v1beta1.Secret].
     * @param \Google\Cloud\SecretManager\V1beta1\GetSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSecret(\Google\Cloud\SecretManager\V1beta1\GetSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/GetSecret',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\Secret', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates metadata of an existing [Secret][google.cloud.secrets.v1beta1.Secret].
     * @param \Google\Cloud\SecretManager\V1beta1\UpdateSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSecret(\Google\Cloud\SecretManager\V1beta1\UpdateSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/UpdateSecret',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\Secret', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a [Secret][google.cloud.secrets.v1beta1.Secret].
     * @param \Google\Cloud\SecretManager\V1beta1\DeleteSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSecret(\Google\Cloud\SecretManager\V1beta1\DeleteSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/DeleteSecret',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [SecretVersions][google.cloud.secrets.v1beta1.SecretVersion]. This call does not return secret
     * data.
     * @param \Google\Cloud\SecretManager\V1beta1\ListSecretVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSecretVersions(\Google\Cloud\SecretManager\V1beta1\ListSecretVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/ListSecretVersions',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\ListSecretVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets metadata for a [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
     *
     * `projects/&#42;/secrets/&#42;/versions/latest` is an alias to the `latest`
     * [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
     * @param \Google\Cloud\SecretManager\V1beta1\GetSecretVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSecretVersion(\Google\Cloud\SecretManager\V1beta1\GetSecretVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/GetSecretVersion',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\SecretVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Accesses a [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion]. This call returns the secret data.
     *
     * `projects/&#42;/secrets/&#42;/versions/latest` is an alias to the `latest`
     * [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
     * @param \Google\Cloud\SecretManager\V1beta1\AccessSecretVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AccessSecretVersion(\Google\Cloud\SecretManager\V1beta1\AccessSecretVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/AccessSecretVersion',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\AccessSecretVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Disables a [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
     *
     * Sets the [state][google.cloud.secrets.v1beta1.SecretVersion.state] of the [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion] to
     * [DISABLED][google.cloud.secrets.v1beta1.SecretVersion.State.DISABLED].
     * @param \Google\Cloud\SecretManager\V1beta1\DisableSecretVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableSecretVersion(\Google\Cloud\SecretManager\V1beta1\DisableSecretVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/DisableSecretVersion',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\SecretVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables a [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
     *
     * Sets the [state][google.cloud.secrets.v1beta1.SecretVersion.state] of the [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion] to
     * [ENABLED][google.cloud.secrets.v1beta1.SecretVersion.State.ENABLED].
     * @param \Google\Cloud\SecretManager\V1beta1\EnableSecretVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableSecretVersion(\Google\Cloud\SecretManager\V1beta1\EnableSecretVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/EnableSecretVersion',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\SecretVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Destroys a [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion].
     *
     * Sets the [state][google.cloud.secrets.v1beta1.SecretVersion.state] of the [SecretVersion][google.cloud.secrets.v1beta1.SecretVersion] to
     * [DESTROYED][google.cloud.secrets.v1beta1.SecretVersion.State.DESTROYED] and irrevocably destroys the
     * secret data.
     * @param \Google\Cloud\SecretManager\V1beta1\DestroySecretVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DestroySecretVersion(\Google\Cloud\SecretManager\V1beta1\DestroySecretVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/DestroySecretVersion',
        $argument,
        ['\Google\Cloud\SecretManager\V1beta1\SecretVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on the specified secret. Replaces any
     * existing policy.
     *
     * Permissions on [SecretVersions][google.cloud.secrets.v1beta1.SecretVersion] are enforced according
     * to the policy set on the associated [Secret][google.cloud.secrets.v1beta1.Secret].
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a secret.
     * Returns empty policy if the secret exists and does not have a policy set.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has for the specified secret.
     * If the secret does not exist, this call returns an empty set of
     * permissions, not a NOT_FOUND error.
     *
     * Note: This operation is designed to be used for building permission-aware
     * UIs and command-line tools, not for authorization checking. This operation
     * may "fail open" without warning.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.secrets.v1beta1.SecretManagerService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
