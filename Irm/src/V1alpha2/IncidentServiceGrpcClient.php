<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC.
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
//
namespace Google\Cloud\Irm\V1alpha2;

/**
 * The Incident API for Incident Response & Management.
 */
class IncidentServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new incident.
     * @param \Google\Cloud\Irm\V1alpha2\CreateIncidentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateIncident(\Google\Cloud\Irm\V1alpha2\CreateIncidentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateIncident',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Incident', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns an incident by name.
     * @param \Google\Cloud\Irm\V1alpha2\GetIncidentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetIncident(\Google\Cloud\Irm\V1alpha2\GetIncidentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/GetIncident',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Incident', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of incidents.
     * Incidents are ordered by start time, with the most recent incidents first.
     * @param \Google\Cloud\Irm\V1alpha2\SearchIncidentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SearchIncidents(\Google\Cloud\Irm\V1alpha2\SearchIncidentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/SearchIncidents',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\SearchIncidentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing incident.
     * @param \Google\Cloud\Irm\V1alpha2\UpdateIncidentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateIncident(\Google\Cloud\Irm\V1alpha2\UpdateIncidentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/UpdateIncident',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Incident', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of incidents that are "similar" to the specified incident
     * or signal. This functionality is provided on a best-effort basis and the
     * definition of "similar" is subject to change.
     * @param \Google\Cloud\Irm\V1alpha2\SearchSimilarIncidentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SearchSimilarIncidents(\Google\Cloud\Irm\V1alpha2\SearchSimilarIncidentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/SearchSimilarIncidents',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\SearchSimilarIncidentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an annotation on an existing incident. Only 'text/plain' and
     * 'text/markdown' annotations can be created via this method.
     * @param \Google\Cloud\Irm\V1alpha2\CreateAnnotationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateAnnotation(\Google\Cloud\Irm\V1alpha2\CreateAnnotationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateAnnotation',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Annotation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists annotations that are part of an incident. No assumptions should be
     * made on the content-type of the annotation returned.
     * @param \Google\Cloud\Irm\V1alpha2\ListAnnotationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListAnnotations(\Google\Cloud\Irm\V1alpha2\ListAnnotationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ListAnnotations',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ListAnnotationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an annotation on an existing incident.
     * @param \Google\Cloud\Irm\V1alpha2\UpdateAnnotationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateAnnotation(\Google\Cloud\Irm\V1alpha2\UpdateAnnotationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/UpdateAnnotation',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Annotation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a tag on an existing incident.
     * @param \Google\Cloud\Irm\V1alpha2\CreateTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTag(\Google\Cloud\Irm\V1alpha2\CreateTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateTag',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Tag', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing tag.
     * @param \Google\Cloud\Irm\V1alpha2\DeleteTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteTag(\Google\Cloud\Irm\V1alpha2\DeleteTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/DeleteTag',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists tags that are part of an incident.
     * @param \Google\Cloud\Irm\V1alpha2\ListTagsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListTags(\Google\Cloud\Irm\V1alpha2\ListTagsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ListTags',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ListTagsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new signal.
     * @param \Google\Cloud\Irm\V1alpha2\CreateSignalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSignal(\Google\Cloud\Irm\V1alpha2\CreateSignalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateSignal',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Signal', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists signals that are part of an incident.
     * Signals are returned in reverse chronological order.
     * @param \Google\Cloud\Irm\V1alpha2\ListSignalsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListSignals(\Google\Cloud\Irm\V1alpha2\ListSignalsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ListSignals',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ListSignalsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a signal by name.
     * @param \Google\Cloud\Irm\V1alpha2\GetSignalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSignal(\Google\Cloud\Irm\V1alpha2\GetSignalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/GetSignal',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Signal', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing signal (e.g. to assign/unassign it to an
     * incident).
     * @param \Google\Cloud\Irm\V1alpha2\UpdateSignalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateSignal(\Google\Cloud\Irm\V1alpha2\UpdateSignalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/UpdateSignal',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Signal', 'decode'],
        $metadata, $options);
    }

    /**
     * Acks a signal. This acknowledges the signal in the underlying system,
     * indicating that the caller takes responsibility for looking into this.
     * @param \Google\Cloud\Irm\V1alpha2\AcknowledgeSignalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AcknowledgeSignal(\Google\Cloud\Irm\V1alpha2\AcknowledgeSignalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/AcknowledgeSignal',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\AcknowledgeSignalResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Escalates an incident.
     * @param \Google\Cloud\Irm\V1alpha2\EscalateIncidentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function EscalateIncident(\Google\Cloud\Irm\V1alpha2\EscalateIncidentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/EscalateIncident',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\EscalateIncidentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new artifact.
     * @param \Google\Cloud\Irm\V1alpha2\CreateArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateArtifact(\Google\Cloud\Irm\V1alpha2\CreateArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateArtifact',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of artifacts for an incident.
     * @param \Google\Cloud\Irm\V1alpha2\ListArtifactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListArtifacts(\Google\Cloud\Irm\V1alpha2\ListArtifactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ListArtifacts',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ListArtifactsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing artifact.
     * @param \Google\Cloud\Irm\V1alpha2\UpdateArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateArtifact(\Google\Cloud\Irm\V1alpha2\UpdateArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/UpdateArtifact',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing artifact.
     * @param \Google\Cloud\Irm\V1alpha2\DeleteArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteArtifact(\Google\Cloud\Irm\V1alpha2\DeleteArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/DeleteArtifact',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns "presets" specific to shift handoff (see SendShiftHandoff), e.g.
     * default values for handoff message fields.
     * @param \Google\Cloud\Irm\V1alpha2\GetShiftHandoffPresetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetShiftHandoffPresets(\Google\Cloud\Irm\V1alpha2\GetShiftHandoffPresetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/GetShiftHandoffPresets',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ShiftHandoffPresets', 'decode'],
        $metadata, $options);
    }

    /**
     * Sends a summary of the shift for oncall handoff.
     * @param \Google\Cloud\Irm\V1alpha2\SendShiftHandoffRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SendShiftHandoff(\Google\Cloud\Irm\V1alpha2\SendShiftHandoffRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/SendShiftHandoff',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\SendShiftHandoffResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new subscription.
     * This will fail if:
     *    a. there are too many (50) subscriptions in the incident already
     *    b. a subscription using the given channel already exists
     * @param \Google\Cloud\Irm\V1alpha2\CreateSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSubscription(\Google\Cloud\Irm\V1alpha2\CreateSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateSubscription',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\Subscription', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of subscriptions for an incident.
     * @param \Google\Cloud\Irm\V1alpha2\ListSubscriptionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListSubscriptions(\Google\Cloud\Irm\V1alpha2\ListSubscriptionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ListSubscriptions',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ListSubscriptionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing subscription.
     * @param \Google\Cloud\Irm\V1alpha2\DeleteSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteSubscription(\Google\Cloud\Irm\V1alpha2\DeleteSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/DeleteSubscription',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a role assignment on an existing incident. Normally, the user field
     * will be set when assigning a role to oneself, and the next field will be
     * set when proposing another user as the assignee. Setting the next field
     * directly to a user other than oneself is equivalent to proposing and
     * force-assigning the role to the user.
     * @param \Google\Cloud\Irm\V1alpha2\CreateIncidentRoleAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateIncidentRoleAssignment(\Google\Cloud\Irm\V1alpha2\CreateIncidentRoleAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CreateIncidentRoleAssignment',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing role assignment.
     * @param \Google\Cloud\Irm\V1alpha2\DeleteIncidentRoleAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteIncidentRoleAssignment(\Google\Cloud\Irm\V1alpha2\DeleteIncidentRoleAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/DeleteIncidentRoleAssignment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists role assignments that are part of an incident.
     * @param \Google\Cloud\Irm\V1alpha2\ListIncidentRoleAssignmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListIncidentRoleAssignments(\Google\Cloud\Irm\V1alpha2\ListIncidentRoleAssignmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ListIncidentRoleAssignments',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\ListIncidentRoleAssignmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a role handover. The proposed assignee will receive an email
     * notifying them of the assignment. This will fail if a role handover is
     * already pending.
     * @param \Google\Cloud\Irm\V1alpha2\RequestIncidentRoleHandoverRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RequestIncidentRoleHandover(\Google\Cloud\Irm\V1alpha2\RequestIncidentRoleHandoverRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/RequestIncidentRoleHandover',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Confirms a role handover. This will fail if the 'proposed_assignee' field
     * of the IncidentRoleAssignment is not equal to the 'new_assignee' field of
     * the request. If the caller is not the new_assignee,
     * ForceIncidentRoleHandover should be used instead.
     * @param \Google\Cloud\Irm\V1alpha2\ConfirmIncidentRoleHandoverRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ConfirmIncidentRoleHandover(\Google\Cloud\Irm\V1alpha2\ConfirmIncidentRoleHandoverRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ConfirmIncidentRoleHandover',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Forces a role handover. This will fail if the 'proposed_assignee' field of
     * the IncidentRoleAssignment is not equal to the 'new_assignee' field of the
     * request. If the caller is the new_assignee, ConfirmIncidentRoleHandover
     * should be used instead.
     * @param \Google\Cloud\Irm\V1alpha2\ForceIncidentRoleHandoverRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ForceIncidentRoleHandover(\Google\Cloud\Irm\V1alpha2\ForceIncidentRoleHandoverRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/ForceIncidentRoleHandover',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a role handover. This will fail if the 'proposed_assignee' field of
     * the IncidentRoleAssignment is not equal to the 'new_assignee' field of the
     * request.
     * @param \Google\Cloud\Irm\V1alpha2\CancelIncidentRoleHandoverRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CancelIncidentRoleHandover(\Google\Cloud\Irm\V1alpha2\CancelIncidentRoleHandoverRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.irm.v1alpha2.IncidentService/CancelIncidentRoleHandover',
        $argument,
        ['\Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment', 'decode'],
        $metadata, $options);
    }

}
